<?php

require_once ROOT_PATH.'/config/env.php';

class Db
{
    protected $dbh;

    protected function __construct($dbh = null)
    {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        if (!$dbh) {
            try {
                $this->dbh = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                echo '接続失敗'.$e->getMessage();
                exit();
            }
        } else {
            $this->dbh = $dbh;
        }
    }
}
