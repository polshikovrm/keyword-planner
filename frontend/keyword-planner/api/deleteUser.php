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
$bool = false;
$post = json_decode(file_get_contents('php://input'), true);
$id = '';
if (!empty($post['id'])) {
    $id = $post['id'];
}
if ($id == '') {
    echo json_encode(['error' => 'Id not defined']);
    header("HTTP/1.0 404 Not Found");
    die();
}
try {
    $sql = 'DELETE FROM user WHERE id=:id ;';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $bool=  $stmt->execute();
} catch (PDOException $e) {
    header('Content-Type: application/json');
    header("HTTP/1.1 200 OK");
    echo json_encode(['error' => 'Internal error on the server try again later.']);
    die();
}
header('Content-Type: application/json');
header("HTTP/1.1 200 OK");
echo json_encode($bool);
die();