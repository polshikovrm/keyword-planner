<?php
/**
 * Created by PhpStorm.
 * User: spiritvoin
 * Date: 24.07.17
 * Time: 17:18
 */

header('Content-Type: application/json');
$host = $GLOBALS['PDOconnect']['host'];
$dbname = $GLOBALS['PDOconnect']['dbname'];
$username = $GLOBALS['PDOconnect']['username'];
$password = $GLOBALS['PDOconnect']['password'];
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
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare('SELECT * FROM user WHERE user.email=:email and user.password=:password');

    $stmt->bindValue(':password', $pass,PDO::PARAM_STR);
    $stmt->bindValue(':email', $email,PDO::PARAM_STR);
    $row = $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        unset($_COOKIE['PHPSESSID']);
        session_destroy();
        session_start();

        $token = session_id();
        $sql = "UPDATE user SET user.token = :token WHERE user.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $row['id']);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        header("HTTP/1.1 200 OK");

        echo json_encode(['successfully' => ['token' => $token]]);
        die();
//        echo json_encode(['errors'=>['emailOrPassword'=>'Wrong email or password']]);
    } else {
        header('Content-Type: application/json');
        header("HTTP/1.1 200 OK");
        echo json_encode(['errors'=>['emailOrPassword'=>'Wrong email or password']]);
        die();
    }
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}


