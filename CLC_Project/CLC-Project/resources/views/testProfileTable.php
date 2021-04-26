<html>
<body style="background-color:powderblue;">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="ISO-8859-1">
<link rel="stylesheet" href="../style.css">
<title>Update Profile</title>
</head>
<body>
<h1 style="text-align:center;">Update Information</h1>
<form action="updateProcess" method="POST" style="text-align:center;">
	<label for="address">Address:</label>
	<input type="text" name="address" placeholder="Enter address" required/> <br><br>
	<label for="city">City:</label>
	<input type="text" name="city" placeholder="Enter city" required/> <br><br>
	<label for="state">State:</label>
	<input type="text" name="state" placeholder="Enter state" required/> <br><br>
	<label for="country">Country:</label>
	<input type="text" name="country" placeholder="Enter country" required/> <br><br>
	<label for="profession">Profession:</label>
	<input type="text" name="profession" placeholder="Enter profession" required/> <br><br>
	<label for="bio">Bio:</label>
	<input type="text" name="bio" placeholder="Enter bio" required/> <br><br>
	<label for="skills">Skills:</label>
	<input type="text" name="skills" placeholder="Enter skills" required/> <br><br>
	<label for="yearsExperience">Years Experience:</label>
	<input type="text" name="yearsExperience" placeholder="Enter years of experience" required/> <br><br>
	<label for="jobExperience">Job Experience:</label>
	<input type="text" name="jobExperience" placeholder="Enter job experience" required/> <br><br>
	<label for="relocation">Relocation:</label>
	<input type="text" name="relocation" placeholder="Enter relocation preference" required/> <br><br>
	<label for="education">Education:</label>
	<input type="text" name="education" placeholder="Enter education" required/> <br><br>
	<button type="submit">Update!</button>
</form>
</body>
</html>