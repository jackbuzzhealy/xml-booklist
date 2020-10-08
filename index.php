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
		//if user is already logged in, logout and mylist will appear in navbar 
		//checkboxs will also appear if users wish to add books to their list
		if(isset($_SESSION['logged_in']))
		{
			$db = dbConnect::getConnection();//database connection
			//fetches members name
			$sqlSearchMember = $db->prepare
			("SELECT name FROM members WHERE email = :username");
			$sqlSearchMember->execute(array
				(
					'username' => $_SESSION['logged_in']
				)
			);  
			$name = $sqlSearchMember->fetchColumn(); 
			
			//outputs start of the content container with the users name printed to show that they're logged in
			echo
			"
			<div class=wrapper>
				<br>
				<center>
					<div class=container>
						<br>
						<h1>Welcome ".$name."<h1>
						<h4>Please select a book and add it to your booklist<h4>";
						echo "<form method='post' action='addToList.php'>";
							//outputs table containing all data related to books
							echo "<table>";
								echo "<tr style='text-align:center; font-size:20px'>";
									echo "<th width='5%'>ISBN</th>";
									echo "<th width='15%'>Title</th>";
									echo "<th width='10%'>Author</th>";
									echo "<th width='50%'>Description</th>";
									echo "<th width='12.5%'>Year Published</th>";
									echo "<th width='7.5%'>Add</th>";
								echo"</tr>";
								
								
								$xml = simplexml_load_file('booklist.xml');//loads xml document containing books
								/*
									array and list containing all books which 
									will be posted to the addToList page to enable 
									solution to iterate through them and add all of the 
									data into the database
								*/
								$arrBook = array();
								$listBooks = array();
								
								//iterates through each chaneel in xml document
								foreach($xml->channel as $channel)
								{
									//iterates through each item on the channel
									foreach ($channel->item as $item)
									{
										//outputs book data onto table
										echo "<tr style='font-size: 12px'>";
											echo "<td width=5%'>";
											echo $item->bookid;
											echo "</td>";
											
											echo "<td width='15%'>";
											echo "<a href=".$item->link ." style='color: white'>";
											echo $item->title;
											echo "</a>";
											echo "</td>";
											
											echo "<td width='10%'>";
											echo $item->author;
											echo "</td>";
											
											echo "<td width='50%'>";
											echo $item->description;
											echo "</td>";
											
											echo "<td width='12.5%'; style='text-align: center'>";
											echo $item->yearPublished;
											echo "</td>";
											
											echo "<td width='7.5%'; style='text-align: center'>";
											echo "<input type='checkbox' name='checkbox[]' value='".$item->bookid ."'>";
											echo "</td>";
										echo "</tr>";
										
										//book data pusehd onto array
										array_push($arrBook, $item->bookid);
										array_push($arrBook, $item->title);
										array_push($arrBook, $item->link);
										array_push($arrBook, $item->author);
										array_push($arrBook, $item->description);
										array_push($arrBook, $item->yearPublished);
										
										//data pusged onto list
										array_push($listBooks, $arrBook);
									}
								}
							echo "</table>";
							echo "<br>";
							echo "<input type='submit' name='add' id='add' value='Add Books My List'>";
						echo "</form>";
					echo "<br>";
					echo "<br>";	
					echo "</div>";	
				echo"</center>";
			echo "</div>";
			echo "<br>";
		}
		//if user is not logged in, they cannot open the myList page.  They must login first
		else
		{
			//outputs start of the content container with the users name printed to show that they're logged in
			echo
		    "
			<div class=wrapper>
				<br>
				<center>
					<div class=container>
						<br>
						<h1>Please see uploaded book list below<h1>
						<table>
							<tr style='text-align:center; font-size: 20px'>
								<th width='7.5%'>ISBN</th>
								<th width='15%'>Title</th>
								<th width='10%'>Author</th>
								<th width='52.5%'>Description</th>
								<th width='15%'>Year Published</th>
							</tr>".
							$xml = simplexml_load_file('booklist.xml');//loads xml document containing books
							foreach($xml->channel as $channel)
							{
								//iterates through each item on the channel
								foreach ($channel->item as $item)
								{
									//outputs book data onto table
									echo "<tr style='font-size: 12px'>";
										echo "<td width=7.5%'>";
										echo $item->bookid;
										echo "</td>";
										echo "<td width='15%'>";
										echo "<a href=".$item->link ." style='color: white'>";
										echo $item->title;
										echo "</a>";
										echo "</td>";
										echo "<td width='10%'>";
										echo $item->author;
										echo "</td>";
										echo "<td width='52.5%'>";
										echo $item->description;
										echo "</td>";
										echo "<td width='10%'; style='text-align: center'>";
										echo $item->yearPublished;
										echo "</td>";
									echo "</tr>";
								}
							}
						echo "</table>";
					echo "<br>";
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
