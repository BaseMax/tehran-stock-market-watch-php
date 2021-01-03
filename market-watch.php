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

function parseItem($cols) {
//   print_r($cols);
  $info = [];
  $namadID = $cols[0];
  $info["code"] = $namadID;
  $info["ins"] = $cols[1];

  $info["symbol"] = $cols[2];
  $info["name"] = $cols[3];
  $info["time"] = $cols[3];

  $info["count_all"] = $cols[8];
  $info["volume_all"] = $cols[9];
  $info["price_all"] = $cols[10];


  $info["price_yesterday_last"] = $cols[7];
  $info["price_today_first"] = $cols[5];
  $info["price_now"] = $cols[13];

  $info["price_min"] = $cols[11];
  $info["price_max"] = $cols[12];
  $info["price_close"] = $cols[6];

  // $info["buy_count"] = $cols[17];
  // $info["buy_price"] = $cols[17];
  // $info["buy_volume"] = $cols[17];
  // $info["sell_count"] = $cols[17];
  // $info["sell_price"] = $cols[17];
  // $info["sell_volume"] = $cols[17];

  $info["eps"] = $cols[14];
  return $info;
}
