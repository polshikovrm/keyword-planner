<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 24.07.17
 * Time: 14:38
 */
header('Content-Type: application/json');
$serverName = "localhost";
$username = "root";
$password = "root";
$db = 'keyword-planner';
if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
    die('ok');
}
try {
    $conn = new PDO("mysql:host=$serverName;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
} catch (PDOException $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo "Connection failed: " . $e->getMessage();
    die();
}
$GLOBALS['PDOconnect']=[
    'host'=>'localhost',
    'username'=>'root',
    'password'=>'root',
    'dbname'=>'keyword-planner',
];

if (isset($_GET['action'])) {

    switch ($_GET['action']) {
        case 'GetKeywordIdeas':
            require_once 'GetKeywordIdeas.php';
            break;
        case 'login':
            require_once 'login.php';
            break;
        case 2:
            echo "i equals 2";
            break;
        default:
            echo "404";
    }
}

header("HTTP/1.0 404 Not Found");
die();
