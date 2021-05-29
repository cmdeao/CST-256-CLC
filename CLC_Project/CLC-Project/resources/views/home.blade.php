<html>
<head>
<title>CLC Project: CST-256
</title>
<style>
.content{
background-image:linear-gradient(to right,#B7B7B7,#EAEAEA);
height:1000px;
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

@if(Session::get('loggedUser') == 1)
<a class="nav-item nav-link" href="#">Welcome, {{Session::get('user')}}</a>
<a class="nav-item nav-lhttp://marketplace.eclipse.org/marketplace-client-intro?mpc_install=4008412ink" href="<?php echo url("/login");?>">Logout</a>
<a class="nav-item nav-link active" href="<?php echo url("/home"); ?>">Home</a>
<a class="nav-item nav-link active" href="<?php echo url("/profile")?>">Profile</a>
@else
<a class="nav-item nav-link active" href="<?php echo url("/home"); ?>">Home</a>
<a class="nav-item nav-link active" href="<?php echo url("/login"); ?>">Login</a>
<a class="nav-item nav-link active" href="<?php echo url("/register")?>">Register</a>
@endif

@if(Session::get('role') == 2)
<a class="nav-item nav-link active" href="<?php echo url("/adminPage")?>">Admin Users</a>
<a class="nav-item nav-link active" href="<?php echo url("/adminJobs")?>">Admin Job Postings</a>
@endif
</div>
</div>
</nav>
</header>
<div class="content d-flex justify-content-center">
Welcome to the Application!<br>
	<form action="searchProcess" method="POST" style="text-align: center;">
	<br><br>
		<input type="text" name="search" class="form-control" placeholder="Search jobs or groups..."><br>
		<button name="submit" type="submit" value="jobs">Search Jobs</button>
		<button name="submit" type="submit" value="groups">Search Groups</button>
	</form>
</div>
<footer class="container"></footer>
</body>
</html>