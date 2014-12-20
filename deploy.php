<?php
require_once __DIR__ . '/bin/symfony.php';
require_once __DIR__ . '/vendor/autoload.php';
$yaml = new \Symfony\Component\Yaml\Yaml();
$parameters = $yaml->parse(__DIR__ . '/app/config/parameters.yml');
server('students-hackathon', $parameters['parameters']['prod_server_ip'])
    ->path('/var/www/' . $parameters['parameters']['domain'])
    ->user('root', $parameters['parameters']['prod_server_pass'])
;
set('repository', $parameters['parameters']['https_github_repository_url']);
