<?php

namespace App\Core;

class Database extends \PDO
{
    /**
     * Instance of the database class
     *
     * @var
     */
    private static $instance;

    /**
     * PDO options
     *
     * @var array
     */
    protected $options;

    /**
     * Get singleton instance of the Database class
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Database constructor.
     *
     * PDO Helper class to easily setup all the
     * necessary database parameters and options
     */
    public function __construct()
    {
        $this->options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];

        $dsn = DATABASE_TYPE . ':host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME;

        parent::__construct($dsn, DATABASE_USER, DATABASE_PASS, $this->options);

        $this->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}