<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $defaultGroup = 'default';

    public array $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'railway',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => false,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    public function __construct()
    {
        parent::__construct();
        $host = getenv('database.default.hostname');
        if ($host) {
            $this->default['hostname'] = $host;
            $this->default['username'] = getenv('database.default.username') ?: 'root';
            $this->default['password'] = getenv('database.default.password') ?: '';
            $this->default['database'] = getenv('database.default.database') ?: 'railway';
            $this->default['port']     = (int)(getenv('database.default.DBPort') ?: 3306);
            // Forzar TCP en lugar de socket Unix
            $this->default['DSN'] = 'mysqli://' . $this->default['username'] . ':' . $this->default['password'] . '@' . $host . ':' . $this->default['port'] . '/' . $this->default['database'];
        }
    }

    public array $tests = [
        'DSN'      => '',
        'hostname' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'database' => 'ci4_test',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => 'ci4_',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
}
