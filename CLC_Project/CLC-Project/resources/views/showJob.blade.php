<html>
<head>
<title>CLC Project: CST-256
</title>
<style>
.content{
background-image:linear-gradient(to right,#B7B7B7,#EAEAEA);
height:900px;
}
Button {
	box-shadow:inset 0px 1px 2px 0px #91b8b3;
	background:linear-gradient(to bottom, #446480 5%, #1A4265 100%);
	background-color:#446480;
	border-radius:5px;
	border:1px solid #566963;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:10px;
	font-weight:bold;
	padding:5px 12px;
	text-decoration:none;
	text-shadow:0px -1px 0px #2b665e;
}
Button:hover {
	background:linear-gradient(to bottom, #1A4265 5%, #446480 100%);
	background-color:#1A4265;
}
Button:active {
	position:relative;
	top:1px;
}

</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#446480">
<a class="navbar-brand" href="/"><h3>Job Search</h3></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
<div class="navbar-nav">
</div>
<div class="navbar-nav ml-auto">
@if(Session::get('user'))
<a class="nav-item nav-link" href="#">Welcome, {{Session::get('user')}}</a>
<a class="nav-item nav-lhttp://marketplace.eclipse.org/marketplace-client-intro?mpc_install=4008412ink" href="/logout">Logout</a>
@else
<a class="nav-item nav-link active" href="home.blade.php">Home</a>
<a class="nav-item nav-link active" href="login.blade.php">Login</a>
<a class="nav-item nav-link active" href="users.blade.php">Register</a>
@endif
</div>
</div>
</nav>
</header>
<body>
<div class="content d-flex justify-content-center">
<div class="col-sm-8">
<h3>View Job Posting</h3>
<form  action="submitApp" method="POST" return="false">
<input type="hidden" id="jobID" name="jobID" value=<?php echo $jobID; ?>>
<label>Posting Date: <?php echo $postDate; ?></label><br>
<label>Position Title <?php echo $postTitle; ?></label><br>
<label>Company<?php echo $company; ?></label><br>
<label>Preferred Skills <?php echo $skills; ?></label><br>
<label>Job Details <?php echo $jobDetails; ?></label><br>
@if($applicationStatus == false)
<button type="submit" onclick="openForm()">Apply</button>
@else
<button type="submit" onclick="openForm()" disabled>Application Processing</button>
@endif
</form>
</div>
</div>

<!-- Pop up confirming application submittal -->

<div class="form-popup" id="appConfirm">
  <form class="form-container" method="GET">
		<label>{{Session::get('user')}} has applied for the <?php echo $postTitle; ?> position.</label>
		<button onclick="closeForm()">Close</button>
	</form>
</div>

<!--scripts to open and close pop up form-->

<script>
function openForm() {
  document.getElementById("appConfirm").style.display = "block";
}

function closeForm() {
  document.getElementById("appConfirm").style.display = "none";
}
</script>
</body>
</html>
