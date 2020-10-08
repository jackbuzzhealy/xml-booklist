<?php 
	include "dbConnect.php";//includes database connection
	
	$db = dbConnect::getConnection();//database connection
	
	//retriving the user input via POST
	$un = $_POST["txtUserName"];
	$pw = $_POST["txtPassword"];
	
	//sql prepared statement to search for member's account in database
	$sqlSearchMember = $db->prepare
	("SELECT * FROM members WHERE email = :username");
    $sqlSearchMember->execute(array
		(
			'username' => $un,
		)
	);   
	$SearchMember = $sqlSearchMember->rowCount();
	
	//if user is already registered onto database
	if($SearchMember > 0)
	{
		$data = $sqlSearchMember->fetch();
		//if password is verified
		if (password_verify($pw, $data['password']))
		{
			//if member is already logged in, end the login session and start another one
			if(isset($_SESSION['logged_in']))
			{
				session_destroy();
			}
			session_start();//logs user onto the session
			$_SESSION['logged_in'] = $un;
			echo "Welcome ".$un;
			//Inputing date and time of the last login into members table 
			$time = date("Y-m-d H:i:s", time());
			$sqlInsertTime = $db->prepare
			("UPDATE members SET lastLogin = :time WHERE email = :username");
			$sqlInsertTime->execute(array
				(
					'username' => $un,
					'time' => $time
				)
			);  
			header("location: index.php");//redirects user to home page
		}
		//if pass word is invalid
		else 
		{
			echo "Password Invalid! Please Try Again";
		}
	}
	//if user is not registered onto database, error message printed
	else 
	{
		echo "Member not Recognised. Please Register";
	}
?>