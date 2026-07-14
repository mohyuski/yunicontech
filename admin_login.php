<?php
session_start();

// ⚠️ CHANGE THIS PASSWORD to something only you know
$correct_password = "yunicon123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['password'] === $correct_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: orders.php");
        exit;
    } else {
        $error = "Incorrect password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | Yunicon Tech</title>
<style>
    body{font-family:Arial, sans-serif;background:#0f172a;color:#fff;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}
    .login-box{background:#1e293b;padding:40px;border-radius:10px;width:300px;box-shadow:0 0 20px rgba(0,191,255,0.3);}
    .login-box h2{margin-top:0;text-align:center;}
    input{width:100%;padding:10px;margin:10px 0;border-radius:5px;border:none;box-sizing:border-box;}
    button{width:100%;padding:10px;background:#00bfff;color:#fff;border:none;border-radius:5px;cursor:pointer;font-size:15px;}
    button:hover{background:#0099cc;}
    .error{color:#ff6666;text-align:center;}
</style>
</head>
<body>
<div class="login-box">
    <h2>🔒 Admin Login</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="password" name="password" placeholder="Enter admin password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
