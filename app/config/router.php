<?php
// Create the router
$router = $di->get("router");

// Remove trailing slashes automatically
$router->removeExtraSlashes(true);

// Define a route
$router->add(
    "/",
    [
        "controller" => "article",
        "action"     => "index",
    ]
)->setName('/');

//详情页
$router->add(
    "/article/{id:[0-9]+}",
    "Article::detail"
)->setName('detail');

//文章添加页
$router->add(
    "/add",
    "Post::new"
)->setName('add');

//文章编辑页
$router->add(
    "/edit/{id:[0-9]+}",
    "Post::edit"
)->setName('edit');

//文章编辑页
$router->add(
    "/save",
    "Post::edit"
)->setName('save');

//详情页--ajax
$router->add(
    "/description/{id:[0-9]+}",
    "Article::description"
)->setName('description');

//按栏目分类文章列表页
$router->add(
    "/list",
    [
        "controller" => "article",
        "action"     => "list",
    ]
)->setName('list');

//按栏目分类文章列表页
$router->add(
    "/catalog/{id}",
    [
        "controller" => "catalog",
        "action"     => "list",
    ]
)->setName('catalog');

//注册页
$router->add(
    "/register",
    "Public::register"
)->setName('register');

//登录页
$router->add(
    "/login",
    "Public::login"
)->setName('login');


// Set 404 paths
$router->add(
    '/show404/{code:[0-9]+}',
    "Public::show404"
);
$router->add(
    '/ajaxshow404/{code:[0-9]+}',
    "Public::ajaxshow404"
);
