<?php
// register.php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if ($username && $name && $email && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Check if username exists
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Username already taken.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (username, name, email, password) VALUES (:username, :name, :email, :password)");
                $stmt->execute([
                    ':username' => $username,
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $hashedPassword
                ]);
                header("Location: login.php");
                exit;
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Charts Application</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <h1>Register</h1>
  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>
  <form method="post" action="register.php">
    <label>Username: <input type="text" name="username" required></label><br>
    <label>Name: <input type="text" name="name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <label>Confirm Password: <input type="password" name="confirm_password" required></label><br>
    <input type="submit" value="Register">
  </form>
  <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>

