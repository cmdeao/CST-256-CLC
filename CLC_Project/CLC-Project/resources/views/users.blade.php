<html>
<body style="background-color:powderblue;">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="ISO-8859-1">
<link rel="stylesheet" href="../style.css">
<title>Edit Product</title>
</head>
<body>
<h1 style="text-align:center;">User Registration</h1>
<form action="accountRegistration" method="POST" style="text-align:center;">
	<label for="name">Name:</label>
	<input type="text" name="name" placeholder="Enter name" required/><br><br>
	<label for="email">Email Address:</label>
	<input type="email" name="email" placeholder="Enter email" required/><br><br>
	<label for="age">Age:</label>
	<input type="number" name="age" min="18" max="100" required/><br><br>
	<label for="username">Username:</label>
	<input type="text" name="username" placeholder="Enter username" required/> <br><br>
	<label for="password">Password:</label>
	<input type="password" name="password" placeholder="Enter password" required/> <br><br>
	<button type="submit">Register Account!</button><br>
</form>
</body>
</html>