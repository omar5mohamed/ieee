<?php
session_start();
include 'db_connect.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'buyer')");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Username already taken.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <nav class="nav-wrapper indigo accent-3">
        <div class="container">
            <a href="index.php" class="brand-logo left">Bookstore</a>
        </div>
    </nav>

    <div class="container">
        <h1>Create Account</h1>
        <?php if (isset($error)) echo "<p class='red-text'>$error</p>"; ?>
        <form method="POST" class="col s12">
            <div class="input-field">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>
            <button type="submit" name="register" class="btn indigo accent-3">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; Bookstore. All rights reserved to Omar.</p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>