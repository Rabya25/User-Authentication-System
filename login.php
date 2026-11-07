<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit;
}

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

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

$errors = [];
$oldEmail = '';

if(($_SERVER['REQUEST_METHOD'] ?? '') === "POST"){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $oldEmail = $email;
    
    if( $email === ''){
        $errors[] = "Email required";
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
    $errors[] = "Invalid credentials";
}
   
    if(empty($errors)){
    session_regenerate_id(true);
         $_SESSION['user_id'] = $user['id'];
         header("Location: dashboard.php");
         exit;
     }
  } 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Form</title>       
    </head>
    <body>
        <?php if ($flash): ?>
           <p style="color: green;"><?= htmlspecialchars($flash) ?></p>
        <?php endif; ?>
        <?php if(!empty($errors)): ?>
         <ul style= "color:red;">
          <?php foreach($errors as $e):?>
            <li>
              <?= htmlspecialchars($e) ?>
            </li>
            <?php endforeach; ?>
         </ul>
        <?php endif; ?>
        <form method="post">
            <label for="email">Enter Email</label>
            <input type="text" name="email" value="<?= htmlspecialchars($oldEmail) ?>">
            <label for="password">Enter Password</label>
            <input type="password" name="password">
            <button type="submit">Login</button>
        </form>
        <p>New to the site? <a href="register.php">Register</a></p>
    </body>
</html>