<?php

use CoffeeCode\Router\Router;

$router = new Router(BASE_URL);

$router->namespace('\App\Controllers');

$router->get('/products', 'ProductsController:index');

$router->get('/account', 'AccountController:index');

$router->get('/account/change_name', 'AccountController:editName');
$router->post('/account/change_name', 'AccountController:updateName');

$router->get('/account/change_email', 'AccountController:editEmail');
$router->post('/account/change_email', 'AccountController:updateEmail');

$router->get('/account/change_password', 'AccountController:editPassword');
$router->post('/account/change_password', 'AccountController:updatePassword');

$router->get('/login', 'AuthController:index');
$router->post('/login', 'AuthController:auth');

$router->get('/logout', 'LogOutController:index');

$router->get('/register', 'RegistrationController:index');
$router->post('/register', 'RegistrationController:store');

$router->get('/recover_password', 'PasswordRecoveryController:index');
$router->post('/recover_password', 'PasswordRecoveryController:sendRecoveryToken');

$router->get('/reset_password', 'PasswordResetController:index');
$router->post('/reset_password', 'PasswordResetController:reset');

$router->get('/verify_email', 'EmailVerificationController:index');

$router->get('/send_verification_email', 'EmailCheckSendingController:index');

$router->dispatch();
