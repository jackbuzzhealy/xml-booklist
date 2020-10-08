<?php 
	include "dbConnect.php";//includes database connection page
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
	
	//if books were selected on checkbox
	if(isset($_POST['add']) AND isset($_POST['checkbox']))
	{
		$checkboxArr = $_POST['checkbox'];//array containing checkbox/book id
		$time = date("Y-m-d H:i:s", time());//time of book being added
		//iterates through each checkbox selected
		foreach($checkboxArr as $isbn)
		{
			//Checks if member already has the book within their list
			$sqlSearchBook = $db->prepare
			("SELECT bookID FROM saved_books WHERE email = :email;");
			$sqlSearchBook->execute(array
				(
					'email' => $_SESSION['logged_in']
				)
			);
			$books = $sqlSearchBook->fetchAll();
			
			//loops through all books selected to check if any of the books selected are already on the list
			foreach($books as $book)
			{
				//searches all books already on the members list on the database
				$sqlSearchBook = $db->prepare
				("SELECT bookID FROM saved_books WHERE email = :email AND bookID :book;");
				$sqlSearchBook->execute(array
					(
						'email' => $_SESSION['logged_in'],
						'book' => $book
					)
				);
				$rows = $sqlSearchBook->rowCount(); 
				//if book is not already there, book will now be added
				if ($rows == 0)
				{
					//adds book to database
					$sqlAddToList = $db->prepare
					("INSERT INTO saved_books (bookID, memberID, dateSaved) VALUES (:isbn, :memberID, :dateSaved);");
					$sqlAddToList->execute(array
						(
							'isbn' => $isbn,
							'memberID' => $memberID,
							'dateSaved' => $time
						)
					);  
				}
			}
			//if none of the selected books were on the list, they will now be added
			$sqlAddToList = $db->prepare
			("INSERT INTO saved_books (bookID, memberID, dateSaved) VALUES (:isbn, :memberID, :dateSaved);");
			$sqlAddToList->execute(array
				(
					'isbn' => $isbn,
					'memberID' => $memberID,
					'dateSaved' => $time
				)
			); 
			//member will now be redirected to their list
			header("location: myList.php");
		}
	}
	//if no books were selected on checkbox, error message will be outputted
	else 
	{
		echo "No books added!  Please select books via the checkbox";
	}
?>