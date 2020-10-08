<?php include "header.php";?>
<html>
	<head>
		<title>Login</title>
		<style>
			body
			{
				background-color:#BBDEFB;
				background-size:cover;
				font-family:"Arial Black", Gadget, sans-serif;
				font-size:15px;
			}
			div.content
			{
				height:cover;
				width:1180px;
				margin-left: auto;
				margin-right: auto;
				background-color:#2196F3;
				padding-left: 20px; 
				font-size:22px;
				font-family: Arial, Helvetica, sans-serif;
				color:#3c3c42;
			}	
			input[type=text]
			{
				padding: 6px;
			    border: none;
			    font-size: 18px;
			}
			input[type=password]
			{
				padding: 6px;
			    border: none;
			    font-size: 18px;
			}
			input[type=submit] 
			{
				background-color: #2196F3;
				border: none;
				color: black;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 15px;
			}
			input[type=submit]:hover
			{
				background-color: #1976D2;
			}
		</style>
	</head>
	
	<body>
		<script>
			//javascript function ensures user fills in both text boxes before continuing
			function loginForm()
			{
				var isComplete = true;
				
				var un = document.forms["memberLogin"]["txtUserName"].value;
				var pw = document.forms["memberLogin"]["txtPassword"].value;	

				if(un != "" & pw != "")
				{
					isComplete = true;
				}
				else 
				{
					isComplete = false;
					alert("Please complete all fields");
				}
				return isComplete;
			}
		</script>
		<br>
		<div class=content>
			<br>
			<center>
				<h2 style="color:#212121">Login</h2>
				<p>
				<table border="1" bordercolor="#212121" width = 60%>
					<form name =memberLogin action=loginProcess.php  onsubmit="return loginForm()"  method=POST>
						<tr>
							<td>User Name:</td>
							<td><input type=text name=txtUserName id=txtUserName></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type=password name=txtPassword id=txtPassword></td>
						</tr>
						<tr>
							<td colspan=2 align=center>
							<input type=submit value="Submit">
							</td>
						</tr>
					</form>		
				</table>
				<br>
			</center>					
		</div>
		<?php include "footer.php";?>	
	</body>
</html>