<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 24.07.17
 * Time: 14:38
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conf.php';
$host = $GLOBALS['PDOconnect']['host'];
$dbname = $GLOBALS['PDOconnect']['dbname'];
$username = $GLOBALS['PDOconnect']['username'];
$password = $GLOBALS['PDOconnect']['password'];
//echo '<pre>';
////print_r($_SESSION);
////print_r($_COOKIE);
//print_r(session_id());
//echo '</pre>';
//die();
if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
    die('ok');
}
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $conn
//    echo "Connected successfully";
} catch (PDOException $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo "Connection failed: " . $e->getMessage();
    die();
}
if(isset($_GET['token']) && $_GET['action']!=='login'){
    $stmt = $conn->prepare('SELECT * FROM user WHERE user.token=:token');

    $stmt->bindValue(':token', $_GET['token'],PDO::PARAM_STR);
    $row = $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row==false){
        header("HTTP/1.0 404 Not Found");
        die();
    }
}
if (isset($_GET['action'])) {

    switch ($_GET['action']) {
        case 'GetKeywordIdeas':
            require_once 'GetKeywordIdeas.php';
            break;
        case 'login':
            require_once 'login.php';
            break;
        default:
            echo "404";
    }
}

header("HTTP/1.0 404 Not Found");
die();
