<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 26.07.17
 * Time: 12:51
 */
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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


$name = '';
if (isset($_GET['q'])) {
    $name = urldecode($_GET['q']);
}
$words = array_filter(explode(' ',str_replace(',',' ',$name)));
$where = '';
foreach ($words as $key => $word) {
    $where .= " and canonical_name LIKE :canonical_name_$key ";
}
// prepare sql and bind parameters
$stmt = $conn->prepare('SELECT * FROM location_criteria WHERE  1=1 '.$where.' ORDER BY  location_criteria.name,location_criteria.target_type ASC  limit 10 ');
$pref='';

foreach ($words as $key => $word) {
    $stmt->bindValue(':canonical_name_' . $key, $pref . $word . '%', PDO::PARAM_STR);
    $pref = '%';
}
$stmt->execute();
$data = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
    $data[] = $item;
}
echo json_encode($data);
die();