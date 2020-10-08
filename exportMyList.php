<?php
	session_start();//keeps user logged in 
	include "dbConnect.php";//includes //database connection
	
	$db = dbConnect::getConnection();//database connection
		
	//Fetches memberID by checking what email is on the same row within the database
	$sqlSearchMember = $db->prepare
	("SELECT memberID FROM members WHERE email = :email;");
	$sqlSearchMember->execute(array
		(
			'email' => $_SESSION['logged_in']
		)
	);
	$memberID = $sqlSearchMember->fetchColumn(); 
		
	//Fetches all books related to member
	$sqlSelectBooks = $db->prepare
	("SELECT * FROM saved_books WHERE memberID = :memberID;");
	$sqlSelectBooks->execute(array
		(
			'memberID' => $memberID,
		)
	); 
	$books = $sqlSelectBooks->fetchAll(PDO::FETCH_ASSOC);	
	
	//Can only export books if database query returns rows
	if(isset($_POST['export']) AND $sqlSelectBooks->rowCount() > 0)
	{	
		$elementName = "book";//create a variable for each element name
		header("Content-Type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		echo "<{$elementName}s>\n";  // add an 's' for the root element
		
		// fetch each book within the list of books
		foreach($books as $book) 
		{
			echo "\t<$elementName>\n";  // element name as a tag
			// iterate through each field in the associative array
			foreach ($book as $key => $value) 
			{
				// write the key as a tag enclosing its value 
				echo "\t\t<$key>$value</$key>\n";
			}
			echo "\t</$elementName>\n";
		}
		echo "</{$elementName}s>";
	}
	//if database query returns no rows 
	else 
	{
		echo "No books on List!  Please add books to your list";
	}
?>