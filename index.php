<?php

$path = match(explode('?', $_SERVER["REQUEST_URI"])[0]) {
    '/' => 'controllers/homeController.php',
    '/api/status' => 'api/status.php',
    '/create'=> 'controllers/createController.php',
    '/quizz'=> 'controllers/quizzController.php',
    '/login'=> 'controllers/loginController.php',
    '/register'=> 'controllers/registerController.php',
    default => 'views/404.php',
};

require $path;
