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

print("Connecting to database\n");

getDbConnection();
print("Connected to MySQL database\n");

print("Start app\n");

print("Get response from tsetmc website\n");

require "netphp.php";
// function get_it($url) {
//     $ch = curl_init();
//     $headers = [
//         'Accept: application/json',
//         'Content-Type: application/json',
//     ];
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_HEADER, 0);
//     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
//     // $body = '{}';
//     // curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//     return curl_exec($ch);
// }

$data = get("http://www.tsetmc.com/tsev2/data/MarketWatchInit.aspx?h=0&r=0")[0];
// $data = file_get_contents("MarketWatchInit.aspx");

print("Response: " . strlen($data) . "\n");
file_put_contents("res.txt", $data);
// var_dump($data);
$content = explode("@", $data);
if($content[2]) {
    $items = explode(";", $content[2]);
    // print_r($items);
    // print count($items)."\n";
    for($i=0; $i < count($items); $i++) {
        // print $i."\n";
        $cols = explode(",", $items[$i]);
        // print_r($cols);
        $item = parseItem($cols);
        if($item == null) {
            return;
        }

        $sql = "SELECT COUNT(id) as count from `symbol` WHERE code=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item["code"]]);
        $count = $stmt->fetchColumn();
        if($count == 0) {
            $data = [
                $item["symbol"],
                $item["name"],
                $item["code"],
                $item["ins"]
            ];
            $sql = "INSERT INTO `symbol` SET symbol=?, name=?, code=?, ins=?";
            $stmt= $pdo->prepare($sql);
            foreach($data as $x=>$value) {
                $stmt->bindParam($x+1, $value);
            }
            $stmt->execute($data);
        }

        $sql = "SELECT * FROM `symbol` WHERE `code`=? LIMIT 1";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$item["code"]]);
        $stmt->execute(); 
        $symbolID = $stmt->fetch()["id"];
        print $symbolID."\n";

        $data = [
            $symbolID,
            date('r', time()),
            // time(),
            $item["count_all"],
            $item["volume_all"],
            $item["price_all"],
            $item["price_yesterday_last"],
            $item["price_today_first"],
            $item["price_now"],
            $item["price_max"] != "" ? $item["price_max"] : null,
            $item["price_min"] != "" ? $item["price_min"] : null,
            $item["price_close"] != "" ? $item["price_close"] : null,
            $item["eps"] != "" ? $item["eps"] : null
        ];
        $sql = "INSERT INTO `history` SET symbol_id=?, time=?, count_all=?, volume_all=?, price_all=?, price_yesterday_last=?, price_today_first=?, price_now=?, price_max=?, price_min=?, price_close=?, eps=?";
        $stmt= $pdo->prepare($sql);
        foreach($data as $x=>$value) {
            $stmt->bindParam($x+1, $value);
        }
        $stmt->execute($data);
    }
}

print("Close database connection\n");

print("End app\n");
