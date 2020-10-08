<?php
	session_start();//keeps the user logged in throughout all the pages that include the header	
?>

<html>
	<head>
		<style>
			div.wrapper 
			{
				background-color: #BBDEFB;
				height: auto;
				width: auto;
			}
			div.navbar 
			{
				width: 1200px;
				height: 100px;
				background-color: #2196F3;
			} 
			div.navbar img
			{
				width: 200px;
				height: 80px;
				margin-top: 10px;
				margin-left: 10px;
				float: left;
			} 
			div.navbar input[type=text] 
			{
			    padding: 6px;
			    border: none;
			    margin-top: 10px;
				margin-left: 100px;
			    font-size: 18px;
				float: left;
			}
			div.navbar input[type=submit]
			{
			    padding: 6px 10px;
				height: 33px;
				width: 33px;
				margin-top: 10px;
				margin-left: 10px;
			    background: #ddd;
			    font-size: 18px;
			    border: none;
			    cursor: pointer;
				float: left;
			}
			div.navbar input[type=submit]:hover
			{
				background: #ccc;
			}
			div.navbar a 
			{
				width: 100px;
				height: auto;
				float: right;
				font-size: 20px;
				color: #212121;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
			}
			div.navbar a:hover
			{
				background-color: #1976D2;
			}
		</style>
	</head>
	<body>
		<?php
		//if user is logged in, user can logout and/or view their list of books
		if(isset($_SESSION['logged_in']))
		{
			//Outputs the header container
			echo 
			"
			<div class=wrapper>
				<center>
					<br>
					<div class=navbar>
						<img src='logo.jpg'>
						<form method='post' action='searchBook.php'>
							<input type='text' id='searchBar' name='searchBar' placeholder='Search...'>
							<input type='submit' name='search' id='search' value=''>
						</form>
						<a href=myList.php>MyList</a>
						<a href=logout.php>Logout</a>
						<a href=index.php>Home</a>
					</div>	
					<br>
				</center>
			</div>
			";	
		}
		//if user is not logged in, they cannot open the myList page.  They must login first
		else
		{
			//Outputs the header container
			echo 
			"
			<div class=wrapper>
				<center>
					<br>
					<div class=navbar>
						<img src='logo.jpg'>
						<form method='post' action='searchBook.php'>
							<input type='text' id='searchBar' name='searchBar' placeholder='Search...'>
							<input type='submit' name='search' id='search' value=''>
						</form>
						<a href=login.php>Login</a>
						<a href=index.php>Home</a>
					</div>	
					<br>
				</center>
			</div>	
			";	
		}
		?>
	</body>
</html>