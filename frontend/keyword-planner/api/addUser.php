<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 28.08.17
 * Time: 13:22
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header("HTTP/1.1 200 OK");
require_once 'conf.php';
$row=false;
$post = json_decode(file_get_contents('php://input'), true);
$pass = '';

if (!empty($post['password'])) {
    $pass = $post['password'];
}
$email = '';
if (!empty($post['email'])) {
    $email = $post['email'];
}
echo '<pre>';
var_dump($pass);
var_dump($email);
echo '</pre>';
die();