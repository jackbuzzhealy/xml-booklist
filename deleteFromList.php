<?php 
	include "dbConnect.php";//includes database connection 
	session_start();//keeps user logged in 
	
	$db = dbConnect::getConnection();//connects to database
	
	//Returns memberID by checking what email is on the same row within the database
	$sqlSearchMember = $db->prepare
	("SELECT memberID FROM members WHERE email = :email;");
	$sqlSearchMember->execute(array
		(
			'email' => $_SESSION['logged_in']
		)
	);
	$memberID = $sqlSearchMember->fetchColumn(); 
	
	//if books were selected on checkbox and delete button was clicked
	if(isset($_POST['delete']) AND isset($_POST['checkbox']))
	{
		$checkboxArr = $_POST['checkbox'];
		//iteates through all books selected
		foreach($checkboxArr as $isbn)
		{
			//fetches all books the member has on the database
			$sqlSearchBook = $db->prepare
			("SELECT bookID FROM saved_books WHERE email = :email;");
			$sqlSearchBook->execute(array
				(
					'email' => $_SESSION['logged_in']
				)
			);
			$books = $sqlSearchBook->fetchAll();
			
			//iterates through all books selected to check if any of the books selected are already on the list
			foreach($books as $book)
			{
				//fetches all books the member has on the database
				$sqlSearchBook = $db->prepare
				("SELECT bookID FROM saved_books WHERE email = :email AND bookID :book;");
				$sqlSearchBook->execute(array
					(
						'email' => $_SESSION['logged_in'],
						'book' => $book
					)
				);
				$rows = $sqlSearchBook->rowCount(); 
				
				//if book is not already there, book will now be deleted
				if ($rows == 0)
				{
					//Deletes Selected book from list if several book was selected
					$sqlDeleteFromList = $db->prepare
					("DELETE FROM saved_books WHERE bookID = :isbn;");
					$sqlDeleteFromList->execute(array
						(
							'isbn' => $isbn,
						)
					); 
				}
			}
			//Deletes Selected books from list if only one book was selected
			$sqlDeleteFromList = $db->prepare
			("DELETE FROM saved_books WHERE bookID = :isbn;");
			$sqlDeleteFromList->execute(array
				(
					'isbn' => $isbn,
				)
			); 
			//member will now be redirected to their list
			header("location: myList.php");
		}
	}
	//if no books were selected on checkbox, error message will be outputted
	else 
	{
		echo "No books Selected!  Please select books via the checkbox";
	}
?>