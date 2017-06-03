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
);

$router->add(
    "/article/{id:[0-9]+}",
    "Article::detail"
)->setName('detail');

$router->add(
    "/new",
    [
        "controller" => "post",
        "action"     => "new",
    ]
);

$router->add(
    "/catalog/{id}",
    [
        "controller" => "catalog",
        "action"     => "list",
    ]
)->setName('catalog');


// Set 404 paths
$router->add(
    '/show404/{code:[0-9]+}',
    "Public::show404"
);
