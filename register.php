<?php
session_start();

if(isset($_SESSION['user_id'])){
 header("Location: dashboard.php");
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

$errors = [];
$oldEmail = '';

if(($_SERVER['REQUEST_METHOD'] ?? '') === "POST"){
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$oldEmail = $email;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email required";
}
if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
}
if(empty($errors)){
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
      if($stmt->fetch()){
         $errors[] = "Email already registered"; 
       }

 if(empty($errors)){      
   $password_hash = password_hash($password, PASSWORD_DEFAULT);
   $stmt = $pdo->prepare("INSERT INTO users(email, password_hash) VALUES(:email, :password_hash)");
   $stmt->execute(['email' => $email, 'password_hash' => $password_hash]);
   
   $_SESSION['flash'] = "Registration successful! Please log in.";
   header("Location: login.php");
   exit;
    }
  }
} ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <?php if(!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>    
        </ul>
    <?php endif; ?>     
    <h1>Register</h1>
    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($oldEmail) ?>">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required minlength="8">
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
