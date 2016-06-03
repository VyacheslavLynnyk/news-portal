<?php

Config::set('site_name', 'News Portal');

Config::set('languages', ['ru', 'en']);

// Routers. Router name => method prefix
Config::set('routes', [
    'default' => '',
    'admin' => 'admin_',
]);

Config::set('default_route', 'default');

Config::set('default_language', 'ru');

Config::set('default_controller', 'news');

Config::set('default_action', 'index');


// Data base config connection
ActiveRecord\Config::initialize(function ($cfg) {
    $cfg->set_model_directory(ROOT.DS.'models');
    $cfg->set_connections([
        'development' => 'mysql://root:@localhost/news;charset=utf8'
    ]);
    $cfg->set_default_connection('development');

});

