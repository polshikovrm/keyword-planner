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
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
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
if ($pass == '' && $email == '') {
    header("HTTP/1.0 404 Not Found");
    die();
}
try {
    $sql = "INSERT INTO user (id, email, password, token) VALUES (NULL, :email, :password, '');";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
    $stmt->execute();

    $stmt = $conn->prepare('SELECT * FROM user WHERE user.email=:email and user.password=:password');
    $stmt->bindValue(':email', $email,PDO::PARAM_STR);
    $stmt->bindValue(':password', $pass,PDO::PARAM_STR);
    $row = $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    header("HTTP/1.1 200 OK");
    echo json_encode(['error' => 'Duplicate entry ' . $email . '']);
    die();
}
header('Content-Type: application/json');
header("HTTP/1.1 200 OK");
echo json_encode($row);
die();