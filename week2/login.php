<?php
session_start();
include 'db_connect.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] === 'seller') {
                header("Location: seller_portal.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Wrong password.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h1>Login</h1>
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
            <button type="submit" name="login" class="btn indigo accent-3">Login</button>
        </form>
        <p>New here? <a href="register.php">Register</a></p>
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