<?php include "header.php";?>
<?php include "dbConnect.php";?>
<html>
	<head>
		<style>
			body
			{
				background-color:#BBDEFB;
				font-family:"Arial Black", Gadget, sans-serif;
				display: flex;
			    flex-direction: column;
			    align-items: center;
			}
			div.container 
			{
				width: 1200px;
				height: auto;
				color: white;
				background-color: #2196F3;
				flex: 1 1 auto;
			} 
			div.container table
			{
				width: 1100px;
				height: auto;
				border: 5px solid black;
				color: white;
			}
			div.container table td
			{
				border: 2px solid black;
				padding: 2px;
			}
			div.container input[type=checkbox]
			{
				width: 25px;
			    height: 25px;
				
			}
			div.container input[type=submit]
			{
				width: 200px;
			    background-color: black;
				border: none;
				color: white;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 15px;
			}
			div.container input[type=submit]:hover 
			{
				background-color: #1976D2;
			}
		</style>
	</head>
	<body>
		<?php 
		//page won't run unless user is logged in
		if(isset($_SESSION['logged_in']))
		{
			$db = dbConnect::getConnection();
			
			//fetches memberID number of member
			$sqlSearchMember = $db->prepare
			("SELECT memberID FROM members WHERE email = :username");
			$sqlSearchMember->execute(array
				(
					'username' => $_SESSION['logged_in']
				)
			);  
			$memberID = $sqlSearchMember->fetchColumn(); 
			
			//fetches name of member
			$sqlSearchName = $db->prepare
			("SELECT name FROM members WHERE email = :username");
			$sqlSearchName->execute(array
				(
					'username' => $_SESSION['logged_in']
				)
			);  
			$name = $sqlSearchName->fetchColumn(); 
			
			//fetches data of books added to list
			$sqlSearchBooks = $db->prepare
			("SELECT * FROM saved_books WHERE memberID = :memberID");
			$sqlSearchBooks->execute(array
				(
					'memberID' => $memberID
				)
			);  
			$books = $sqlSearchBooks->fetchAll();
 			
			//outputs table which will contain the books
			echo
			"
			<div class=wrapper>
				<center>
				<br>
					<div class=container>
						<br>
						<h1>Welcome ".$name."<h1>
						<h4>Please see your selected books below<h4>";
						echo "<form method='post' action='deleteFromList.php'>";
							echo "<table>";
								echo "<tr style='text-align:center; font-size:20px'>";
									echo "<th width='5%'>ISBN</th>";
									echo "<th width='15%'>Title</th>";
									echo "<th width='10%'>Author</th>";
									echo "<th width='50%'>Description</th>";
									echo "<th width='12.5%'>Year Published</th>";
									echo "<th width='7.5%'>Delete</th>";
								echo"</tr>";
								
								//iterates through all the books on the database
								foreach($books as $book)
								{
									//outputs all the books on the database
									echo "<tr style='font-size: 12px'>";
										echo "<td width=5%'>";
										$isbn = $book['bookID'];
										echo $isbn;
										echo "</td>";
											
										echo "<td width='15%'>";
										$link = $book['link'];
										echo "<a href=".$link." style='color: white'>";
										$title = $book['bookTitle'];
										echo $title;
										echo "</a>";
										echo "</td>";
											
										echo "<td width='10%'>";
										$author = $book['author'];
										echo $author;
										echo "</td>";
											
										echo "<td width='50%'>";
										$description = $book['description'];
										echo $description;
										echo "</td>";
											
										echo "<td width='12.5%'; style='text-align: center'>";
										$yearPublished = $book['yearPublished'];
										echo $yearPublished;
										echo "</td>";
											
										echo "<td width='7.5%'; style='text-align: center'>";
										echo "<input type='checkbox' name='checkbox[]' value='".$isbn."'>";
										echo "</td>";
									echo "</tr>";
								}
							echo "</table>";
							echo "<br>";
							echo "<br>";
							echo "<input type='submit' name='delete' id='delete' value='Delete Selected Books'>";
						echo "</form>";
						echo "<br>";
						echo "<form method='post' action='exportMyList.php'>";
							echo "<input type='submit' name='export' id='export' value='Export Books'>";
						echo "</form>";
					echo "<br>";
					echo "</div>";	
				echo"</center>";
			echo "</div>";
			echo "<br>";
		}
		?>
	</body>
	<?php include "footer.php";?>
</html>