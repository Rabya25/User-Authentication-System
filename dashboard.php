<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

?>
<!DOCTYPE html>
<html>
    <head><title>Dashboard</title></head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_email'] ?? 'User') ?>!</h1>

    <?php if ($flash): ?>
        <p style="color: green;"><?= htmlspecialchars($flash) ?></p>
    <?php endif; ?>

    <ul>
        <li><a href="profile.php">View Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>