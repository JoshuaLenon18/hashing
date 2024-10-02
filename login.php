<?php
include('./config.php');
include('./functions.php');
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];
$recaptcha_response = $_POST['g-recaptcha-response'];
if(!verifyRecaptcha($recaptcha_response)){
$_SESSION['message'] = "Invalid reCAPTCHA. Please try again.";
header("location: login.php");
exit();
}
$sql = "SELECT id, username, password FROM users WHERE username = ?";
if($stmt = mysqli_prepare($conn, $sql)){
mysqli_stmt_bind_param($stmt, "s", $param_username);
$param_username = $username;
if(mysqli_stmt_execute($stmt)){
mysqli_stmt_store_result($stmt);
if(mysqli_stmt_num_rows($stmt) == 1){
mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
if(mysqli_stmt_fetch($stmt)){
if(password_verify($password, $hashed_password)){
session_start();
$_SESSION["loggedin"] = true;
$_SESSION["id"] = $id;
$_SESSION["username"] = $username;
header("location: welcome.php");
} else{
$_SESSION['message'] = "Invalid username or password.";
}
}
} else{
$_SESSION['message'] = "Invalid username or password.";
}
} else{
$_SESSION['message'] = "Oops! Something went wrong. Please try again later.";
}
mysqli_stmt_close($stmt);
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="styles.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<h2>Login</h2>
<p><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : '' ;unset($_SESSION['message']); ?></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div>
<label>Username</label>
<input type="text" name="username" required>
</div>
<div>
<label>Password</label>
<input type="password" name="password" required>
</div>
<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
<div>
<input type="submit" value="Login">
</div>
<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
</form>
</body>
</html>
