<html>
	<head>
		<style>
			div.wrapper 
			{
				background-color: #BBDEFB;
			}
			div.footer
			{
				width: 1200px;
				height: 100px;
				background-color: #2196F3;
			} 
			div.footer a 
			{
				float: left;
				width: 100px;
				height: auto;
				font-size: 20px;
				color: #212121;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
			}
			div.footer a:hover
			{
				background-color: #1976D2;
			}
			div.footer img
			{
				float: right;
				width: 80px;
				height: 80px;
				margin-top: 10px;
				margin-right: 10px;
			} 
		</style> 
	</head>
	<body>
		<?php
		//if user is logged in, user can logout and/or view their list of books
		if(isset($_SESSION['logged_in']))
		{
			//Outputs the footer container
			echo 
			"
			<div class=wrapper>
				<center>
					<br>
					<div class=footer>
						<a href=index.php>Home</a>
						<a href=logout.php>Logout</a>
						<a href=myList.php>MyList</a>
						<img src='twitter.jpg'>
						<img src='facebook.jpg'>
					</div>
					<br>
				</center>
			</div>
			";	
		}
		//if user is not logged in, they cannot open the myList page.  They must login first
		else
		{
			//Outputs the footer container
			echo 
			"
			<div class=wrapper>
				<center>
					<br>
					<div class=footer>
						<a href=index.php>Home</a>
						<a href=login.php>Login</a>
						<img src='twitter.jpg'>
						<img src='facebook.jpg'>
					</div>
					<br>
				</center>
			</div>	
			";	
		}
		?>
	</body>
</html>