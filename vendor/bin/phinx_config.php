<?php

require_once "../../app/application/config/database.php";

return [
    "paths" => [
        "migrations" => realpath(dirname(__FILE__).'/../../')."/db/migrations",
        "seeds" => realpath(dirname(__FILE__).'/../../')."/db/seeds",
        ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => $db['default']['database'],
        "development" => [
            "name" => $db['default']['database'],
            "adapter" => "mysql",
            "host" => $db['default']['hostname'],
            "user" => $db['default']['username'],
            "pass" => $db['default']['password'],
            "port" => '3306',
            "charset" => 'utf8',
        ]
    ]
];