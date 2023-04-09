<?php session_start();
if (isset($_SESSION['user'])) {
	header('Location:index.php'); // no need to sign in again if session still exist 
}
$pageTitle = "Homepage";

include "init.php";


// check if user coming from http post request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$hashedpass = sha1($password);

	// check user exists in database
	$stmt = $con->prepare("select UserID , Username , Password from users where username = ? and password = ? LIMIT 1");
	$stmt->execute(array($username, $hashedpass));
	$count = $stmt->rowcount();
	$row = $stmt->fetch();

	// if count > 0 this mean the database contain record about this username 
	if ($count > 0) {
		$_SESSION['user'] = $username; // register session name 
		$_SESSION['I_D'] = $row['UserID']; // register User id 
		header('Location:index.php'); // redirect to dashboard page
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Sign up / Login Form</title>
	<link rel="stylesheet" href="layout/css/login.css">

</head>

<body>
	<!-- partial:index.partial.html -->
	<!DOCTYPE html>
	<html>

	<head>
		<title>Slide Navbar</title>
		<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
	</head>

	<body>

		<div class="main">
			<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button>Sign up</button>
				</form>
			</div>

			<div class="login">
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="Username" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button>Login</button>
				</form>
			</div>
		</div>
	</body>

	</html>
	<!-- partial -->

</body>

</html>