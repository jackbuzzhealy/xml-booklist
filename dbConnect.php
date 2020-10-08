<?php  
	class dbConnect 
	{
		//method to return database connection string
		static function getConnection() 
		{
			$connectionString = "mysql:host=localhost;dbname=unn_w18017928";//database connection string
			$userName = "unn_w18017928";//database username
			$password = "NEZGMJI2";//database password
			try 
			{
				$db = new PDO($connectionString, $userName, $password);
				return $db;
			}
			//if system cannot connect to database, error message will be outputted
			catch (PDOException $exception)
			{
				echo "Failed to connect to database ".$exception->getMessage();
				return null;
			}
		}
	}
?>