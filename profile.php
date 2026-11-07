<?php
 session_start();

 if(!isset($_SESSION['user_id'])){
   header("Location: login.php");
   exit;
 }

 $pdo = new PDO(
    "mysql:host=localhost;dbname=ecomer;charset=utf8mb4",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,        
    ]
 );
 
 

 $stmt = $pdo->prepare("SELECT id, email, created_at FROM users WHERE id = :id");
 $stmt->execute(['id' => $_SESSION['user_id']]);
 $user = $stmt->fetch();

 if(!$user){
    session_destroy();
    header("Location: login.php");
    exit;
 }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Profile</title>
    </head>
    <body>
        <p> Id : <?= (int)($user['id']) ?></p>
        <p> E-mail : <?= htmlspecialchars($user['email']) ?></p>
        <p>Profile Created At : <?= htmlspecialchars($user['created_at']) ?></p>
        <p>Go Back <a href="dashboard.php">Dashboard</a></p>
    </body>
</html>