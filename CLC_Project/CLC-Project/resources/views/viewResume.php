<html>
<head>
<title>CLC Project: CST-256
</title>
<style>
.content{
background-image:linear-gradient(to right,#B7B7B7,#EAEAEA);
height:600px;
}

Button {
	box-shadow:inset 0px 1px 3px 0px #91b8b3;
	background:linear-gradient(to bottom, #768d87 5%, #6c7c7c 100%);
	background-color:#768d87;
	border-radius:5px;
	border:1px solid #566963;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	padding:11px 23px;
	text-decoration:none;
	text-shadow:0px -1px 0px #2b665e;
}
Button:hover {
	background:linear-gradient(to bottom, #6c7c7c 5%, #768d87 100%);
	background-color:#6c7c7c;
}
Button:active {
	position:relative;
	top:1px;
}
html {
  height: 100%;
}
body {
  min-height: 100%;
  display: flex;
  flex-direction: column;
  grid-template-rows: 1fr auto;
}
main {flex-grow: 1;}
.footer {
  position: fixed;
  grid-row-start: 2;
  grid-row-end: 3;
  text-align: center;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light" style="background:#668B8B">
<a class="navbar-brand" href="/"><h3>Job Search</h3></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
<div class="navbar-nav">
</div>
<div class="navbar-nav ml-auto">
<a class="nav-item nav-link active" href="<?php echo url("/home")?>">Home</a>
<a class="nav-item nav-link active" href="<?php echo url("/profile")?>">Profile</a>
</div>
</div>
</nav>
</header>
<div class="content d-flex justify-content-center">
<div class="col-sm-8">
<h3>Member Dashboard</h3>
<body>
<h3 style="text-align: center;">
<b>Education:</b><br>
School: <?php echo $data[0]; ?> <br>
Degree: <?php echo $data[1]; ?> <br>
Field of Study: <?php echo $data[2]; ?> <br>
Start Date: <?php echo $data[3]; ?> <br>
End Date: <?php echo $data[4]; ?> <br>
<b>Work History:</b><br>
Company: <?php echo $data[5]; ?> <br>
Title: <?php echo $data[6]; ?> <br>
Start Date: <?php echo $data[7]; ?> <br>
End Date: <?php echo $data[8]; ?> <br>
Description: <?php echo $data[9]; ?> <br>
<b>Skills:</b><br> <?php echo $data[10]; ?> <br>
</h3>
<form action="updateResume" METHOD="GET" style="text-align:center;">
	<button class="Button" type="Submit">Update Resume</button>
</form>
</body>
</div>
</div>

