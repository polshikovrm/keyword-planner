<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 28.08.17
 * Time: 12:57
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header("HTTP/1.1 200 OK");
require_once 'conf.php';



$host = $GLOBALS['PDOconnect']['host'];
$dbname = $GLOBALS['PDOconnect']['dbname'];
$username = $GLOBALS['PDOconnect']['username'];
$password = $GLOBALS['PDOconnect']['password'];
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare('SELECT * FROM user  ORDER BY  email ASC');
$stmt->execute();
$data = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
    $data[] = $item;
}
echo json_encode($data);
die();