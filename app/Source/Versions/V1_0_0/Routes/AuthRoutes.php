<?php

/** @var TYPE_NAME $router */
$router->post('{access}/authorized','AuthController@authorized');
$router->get('{access}/authorized/profile','AuthController@profile');
