<html>
<body style="background-color:powderblue;">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="ISO-8859-1">
<link rel="stylesheet" href="../style.css">
<title>Login to Application</title>
</head>
<body>
<h1 style="text-align:center;">Login</h1>
<form action="loginProcess" method="POST" style="text-align:center;">
	<label for="username">Username:</label>
	<input type="text" name="username" placeholder="Enter username" required/> <br><br>
	<label for="password">Password:</label>
	<input type="password" name="password" placeholder="Enter password" required/> <br><br>
	<button type="submit">Login!</button>
</form>
</body>
</html>