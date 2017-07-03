<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        "App\\Models"      => "../app/models/",
        "App\\Library\\Utils"      => "../app/library/Utils/",
    ]
);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();
