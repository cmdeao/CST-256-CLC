<html>
<head>
<title>Admin Page
</title>
<style>
.content{
background-image:linear-gradient(to right,#B7B7B7,#EAEAEA);
height:900px;
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
<h3>Affinity Groups</h3>
<div class="form-group">
<body>
    <table>
        <tr>
        	<td>Group ID</td>
            <td>Group Name</td>
            <td>Group Details</td>
            <td>Group Admins</td>
            <td>Group Users</td>
        </tr>
        @for($i = 0; $i < count($groups); $i++)
        	<tr>
        		<td> {{ $groups[$i][0] }} </td>
        		<td> {{ $groups[$i][1] }} </td>
        		<td> {{ $groups[$i][2] }} </td>
        		<td> {{ $groups[$i][3] }} </td>
        		<td> {{ $groups[$i][4] }} </td>
        		<td>
        			<form action="<?php echo url("/viewGroup")?>" method="POST">
            			<button name="displayGroup" type="submit" value="{{ $groups[$i][0] }}">Select</button>
					</form>
				</td>
					<!-- Displaying buttons for Admin users -->
				@if(Session::get('role') == 2)
				<td>
        			<form action="editGroup" method="POST">
            			<button name="editGroup" type="submit" value="{{ $groups[$i][0] }}">Edit</button>
            		</form>
        		</td>
        		<td>
        			<form action="deleteGroup" method="POST">
            			<button name="delete" type="submit" value="{{ $groups[$i][0] }}">Delete</button>
            		</form>
        		</td>
        		@endif
				</tr>
		@endfor
	</table>	
	Not finding what you're looking for? Start an Affinity Group <a href="<?php echo url("/newGroup")?>">here</a> 
</body>
</div>
</form>
</div>
