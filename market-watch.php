<?php
/*
 * @Name: tehran-stock-market-watch-php
 * @Author: Max Base
 * @Date: 2021-01-03
 * @Repository: https://github.com/BaseMax/tehran-stock-market-watch-php/
 */

function arabicToPersian($str) {
  return $str;
}

function n2n($num) {
  return round($num, 2);
}

function countDigits($input) {
  return 0;
}

function getDbConnection() {
    global $pdo;
    $host = 'localhost';
    $db   = 'stock';
    $user = 'root';
    $pass = '';
    $port = '3306';
    $charset = 'utf8mb4';

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
    try {
        $pdo = new \PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
