<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Profiler as ProfilerDb;
use Phalcon\Mvc\Router;
use Phalcon\Logger;

/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new Router();
    return $router;
});

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => true,//设置实时编译，并检查父模板中的内容变更。
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

$di->set(
    "profiler",
    function () {
        return new ProfilerDb();
    },
    true
);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $eventsManager = new EventsManager();

    $logger = $this->getLogger('DB');

    // Get a shared instance of the DbProfiler
    $profiler = $this->getProfiler();

    // Listen all the database events
    $eventsManager->attach(
        "db",
        function ($event, $connection) use ($config,$logger,$profiler) {
            if($event->getType() === 'beforeQuery'){
                $profiler->startProfile(
                    $connection->getSQLStatement()
                );
                if(SQL_LOG){
                    $logger->log(
                        $connection->getSQLStatement(),
                        Logger::INFO
                    );
                }
            }

            if ($event->getType() === "afterQuery") {
                $profiler->stopProfile();
            }
        }
    );

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});


/**
 * 404
 */
 $di->setShared(
     "dispatcher",
     function () {
         // 创建一个事件管理
         $eventsManager = new EventsManager();

         // 附上一个侦听者
         $eventsManager->attach(
             "dispatch:beforeException",
             function (Event $event, $dispatcher, Exception $exception) {
                 // 处理404异常
                 if ($exception instanceof DispatchException) {
                     $dispatcher->forward(
                         [
                             "controller" => "public",
                             "action"     => "show404",
                         ]
                     );

                     return false;
                 }

                 // 代替控制器或者动作不存在时的路径
                 switch ($exception->getCode()) {
                     case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                     case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                         $dispatcher->forward(
                             [
                                 "controller" => "public",
                                 "action"     => "show404",
                             ]
                         );

                         return false;
                 }
             }
         );

         $dispatcher = new MvcDispatcher();

         // 将EventsManager绑定到调度器
         $dispatcher->setEventsManager($eventsManager);

         return $dispatcher;
     }
 );


/**
 * Log writer
 */
$di->set(
    'logger',
    function($type = 'log'){
        if ( is_dir(LOG_PATH) ) {
            if ( !is_writable(LOG_PATH) ) {
                header('HTTP/1.1 401 Log Path access denied.', TRUE, 401);
                echo 'Log path access denied.';
                exit(); // EXIT_ERROR
            }
        } else {
            if (!mkdir(LOG_PATH, 0777, true)) {
                header('HTTP/1.1 401 create  log path failed.', TRUE, 401);
                echo 'Create log path failed .';
                exit(); // EXIT_ERROR
            }
        }

        $logFile = sprintf("%s/%s_%s.log", LOG_PATH, $type, date('Y_m_d'));
        $logger = new FileLogger($logFile);
        return $logger;
    }
);
