<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM User
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: /forex flux/signals/signal.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="/forex flux/login/login.css">
</head>
<body>


	<header>
		<div class="logo">
			<object type="image/svg+xml" data="/forex flux/logo/final.svg">
				<!-- Fallback image for non-SVG supporting browsers -->
				<img src="#" alt="Example Website Logo">
			</object>
		</div>

		<nav>
			<ul>
				<li><a href="/forex flux/index.html">Home</a></li>
				<li><a href="/forex flux/signals/signal.html">Signals</a></li>
				<li><a href="/forex flux/register/register.html">Register</a></li>
				<li><a href="/forex flux/login/login.html">Login</a></li>
				<li><a href="/forex flux/contact_us/contact.html">Contact us</a></li>
			</ul>
		</nav>
	</header>


	<div class="container">
		<form method="post">
			<h1>Log in</h1>

			<label for="email"><b>Email</b></label>
			<input type="text" placeholder="Enter Email" id="email" name="email"

			value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
			

			<label for="password"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" id="password" name="password" required>

			<button type="submit">Register</button>
		</form>
	</div>


	<footer>
		<div class="ending">
		<p> Forex Flux </br>Copyright &copy; 2023</p>
	  </div>
	</footer>
		  
</body>
</html>
