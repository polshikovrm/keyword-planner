<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 26.07.17
 * Time: 12:51
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
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
    $name = $_GET['q'];
}

// prepare sql and bind parameters
$stmt = $conn->prepare('SELECT * FROM location_criteria WHERE  name LIKE :canonical_name ORDER BY  location_criteria.name,location_criteria.target_type ASC  limit 10 ');

$stmt->bindValue(':canonical_name', '%'.$name.'%',PDO::PARAM_STR);
$stmt->execute();
//$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data=[];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item){
    $data[]=$item;
}
//echo '<pre>';
//var_dump($_GET);
//echo '</pre>';
//die();
echo json_encode($data);
die();