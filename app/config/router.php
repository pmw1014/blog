<?php

// Create the router
$router = $di->get("router");

// Define a route
$router->add(
    "/",
    [
        "controller" => "article",
        "action"     => "index",
    ]
);
$router->add(
    "/new",
    [
        "controller" => "post",
        "action"     => "new",
    ]
);
