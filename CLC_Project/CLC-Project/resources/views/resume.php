<html>
<head>
<title>CLC Project: CST-256
</title>
<style>
.content{
background-image:linear-gradient(to right,#B7B7B7,#EAEAEA);
height:900px;
}
button {
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
button:hover {
	background:linear-gradient(to bottom, #6c7c7c 5%, #768d87 100%);
	background-color:#6c7c7c;
}
button:active {
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
<nav class="navbar navbar-expand-lg navbar-light" style="background:#668B8B">
<a class="navbar-brand" href="/"><h3>Job Search</h3></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
<div class="navbar-nav">
@endif
<</div>
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
<div class="content d-flex justify-content-center">
<div class="col-sm-8">
<h2>Update Your Work History</h2><br>

<!-- This page is broken into (3) different forms.
when building out the controller, we can choose to have the user
 update the tables individually or as one form submittal. -->

<form action="" method="post" return="false">

<!-- This section will update the skills table-->

<div class="form-group" id="mySkills">
<form action=" " method="post">
 <h3>Skills</h3>
<div style="float: left; width: 40%;">
<ul>
<input type="checkbox" id="skill1" name="skill1" value="MS Office,">
<label for="skill1"> MS Office</label><br>
<input type="checkbox" id="skill2" name="skill2" value="Coding,">
<label for="skill2"> Coding</label><br>
<input type="checkbox" id="skill6" name="skill6" value="Web Development,">
<label for="skill6"> Web Development</label><br>
</div>
 <div style="float: right; width: 20%;">
<ul>
 <button type="submit" class="btn">Submit</button>
<br>
</div>
<div style="float: right; width: 40%;">
<ul>
<input type="checkbox" id="skill3" name="skill3" value="Project Management,">
<label for="skill3"> Project Management</label><br>
<input type="checkbox" id="skill4" name="skill4" value="Networking,">
<label for="skill4"> Networking</label><br>
<input type="checkbox" id="skill5" name="skill5" value="Accounting,">
<label for="skill5"> Accounting</label><br>
<ul>
</div>
</form>
</div>


<!-- This section will update the education table-->

<div class="form-group" id="mySchool">
  <form action=" " method="post" >
  <br>
    <h3>Education</h3>

    <label for="startdate"><b>Start Date</b></label>
    <input type="date"name="startdate" required>

    <label for="enddate"><b>End Date</b></label>
    <input type="date"name="startdate" required>

    <label for="school"><b>Company</b></label>
    <input type="text" placeholder="Enter School Name" name="school" required>

	<label for="degree"><b>Degree</b></label>
    <select class="box">
	  <option>Certification</option>
      <option>Diploma</option>
      <option>Associates</option>
      <option>Bachelors</option>
    </select>
 <br>
	<label for="degree"><b>Field of Study</b></label>
    <input type="text" placeholder="Enter Field of Study" name="jobtitle" required>
   
    <button type="submit" class="btn">Submit</button>
	<br>
  </form>
</div>


<!-- This section will update the work history table-->

<div class="form-group" id="myWork">
  <form action="" method="post"  >
    <h3>Work History</h3>

    <label for="startdate"><b>Start Date</b></label>
    <input type="date"name="startdate" required>

    <label for="enddate"><b>End Date</b></label>
    <input type="date"name="startdate" required>

    <label for="company"><b>Company</b></label>
    <input type="text" placeholder="Enter Company Name" name="company" required>

	<label for="jobtitle"><b>Job Title</b></label>
    <input type="text" placeholder="Enter Job Title" name="jobtitle" required>

	<label for="description"><b>Job Description</b></label>
    <textarea type="text" rows="6" cols="80"name="description"  class="form-control" required> Enter Position Details </textarea>
	<br>
    <button type="submit" class="btn">Submit</button>
  </form>
</script>
</form>
</div>
