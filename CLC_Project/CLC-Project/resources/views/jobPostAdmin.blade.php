<html>
<head>
<title>Admin Page
</title>
<style>
.content{
background-image:linear-gradient(to right,#B7B7B7,#EAEAEA);
height:1200px;
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
 table {
            color: #668B8B;
            font-family: Arial;
            font-weight: bold;
            width: 640px;
            border-collapse: collapse;
            border-spacing: 0;
        }
          
        td,
        th {
            border: 1px solid #CCC;
            height: 30px;
        }
          
        th {
            background: #F3F3F3;
            
        }
          
        td {
            background: #FAFAFA;
            text-align: center;
        }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
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
<h3>Job Postings</h3>
<div class="form-group">
<body>
<table id="jobs" class="display">
<thead>
	<tr>
		@if(Session::get('role') == 2)
		<th>ID</th>
		<td>Posting Date</td>
		<th>Position Title</th>
		<th>Company</th>
		<th>Pref. Skills</th>
		<th>Job Details</th>
		<th>View Job</th>
		<th>Update Job</th>
		<th>Delete Job</th>
		@else
		<th>ID</th>
		<td>Posting Date</td>
		<th>Position Title</th>
		<th>Company</th>
		<th>Pref. Skills</th>
		<th>Job Details</th>
		<th>View Job</th>
		@endif
	</tr>
</thead>
<tbody>
@for($i = 0; $i < count($postings); $i++)
<tr>
	<td> {{ $postings[$i][0] }} </td>
	<td> {{ $postings[$i][1] }} </td>
	<td> {{ $postings[$i][2] }} </td>
	<td> {{ $postings[$i][3] }} </td>
	<td> {{ $postings[$i][4] }} </td>
	<td> {{ $postings[$i][5] }} </td>
	<td>
		<form action="<?php echo url("/showJob")?>" method="POST">
			<button name="displayJob" type="submit" value="{{ $postings[$i][0] }}">View Job</button>
		</form>
	</td>
	@if(Session::get('role') == 2)
	<td>
		<form action="<?php echo url("/editPost")?>" method="POST">
			<button name="editpost" type="submit" value="{{ $postings[$i][0] }}">Edit</button>
		</form>
	</td>
	<td>
		<form action="deletePost" method="POST">
			<button name="delete" type="submit" value="{{ $postings[$i][0] }}">Delete</button>
		</form>
	</td>
	@endif
</tr>
@endfor
</tbody>
</table>

    @if(Session::get('role') == 2)
    <form action="newPost" method="GET">
		<button name="delete" type="submit">Create New Job Posting</button>
	</form>
	@endif


	<script>
	$(document).ready( function () {
		$('#jobs').DataTable();
	});	
</script>
</body>
</div>
</form>
</div>
