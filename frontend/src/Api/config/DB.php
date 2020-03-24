<?php

namespace Api\Config;

class DB
{
    private $dsn;
    private $dbuser;
    private $dbpass;

    public function __construct()
    {
        $configFile = ROOT_DIR . '/../app_settings.json';
        if (!file_exists($configFile)) {
            throw new \RuntimeException("Missing ROOT config file `app_settings.json`");
        }

        $settings = json_decode(file_get_contents($configFile), true);

        $this->dsn = sprintf(
            'mysql:host=%s;dbname=%s',
            $settings['db']['host'],
            $settings['db']['base']
        );
        $this->dbuser = $settings['db']['user'];
        $this->dbpass = $settings['db']['pass'];
    }

    public function connect()
    {
        $dbConnection = new \PDO($this->dsn, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
