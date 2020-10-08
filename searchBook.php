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
		//if search bar isn't empty
		if($_POST['searchBar'] != "")
		{
			//outputs table containing all relevant books in search
			echo
			"
			<div class=wrapper>
				<center>
				<br>
					<div class=container>
					<br>
						<h1>Search Results for ".$_POST['searchBar']."<h1>";
						echo "<table>";
							echo "<tr style='text-align:center; font-size:20px'>";
								echo "<th width='7.5%'>ISBN</th>";
								echo "<th width='15%'>Title</th>";
								echo "<th width='10%'>Author</th>";
								echo "<th width='52.5%'>Description</th>";
								echo "<th width='15%'>Year Published</th>";
							echo"</tr>";
									
							$xml = simplexml_load_file('booklist.xml');//loads books from xml document
							$qry = '/channel/item[contains('.$_POST['searchBar'].')]';//query which will read through all relevant books in xml document via a partial search
							$nodes = $xml->xpath($qry);
							
							//iterates through all books relevant in search
							foreach ($nodes as $node)
							{
								//outputs all books relevant in search
								echo "<tr style='font-size: 12px'>";
									echo "<td width=5%'>";
									echo $node->bookid;
									echo "</td>";
												
									echo "<td width='15%'>";
									echo "<a href=".$item->link ." style='color: white'>";
									echo $node->title;
									echo "</a>";
									echo "</td>";
												
									echo "<td width='10%'>";
									echo $node->author;
									echo "<input type='hidden' name='author' value='".$item->author ."'/>";
									echo "</td>";
												
									echo "<td width='50%'>";
									echo $node->description;
									echo "</td>";
												
									echo "<td width='12.5%'; style='text-align: center'>";
									echo $node->yearPublished;
									echo "</td>";
								echo "</tr>";
							}
						echo "</table>";
						echo "<br>";
					echo "<br>";
					echo "<br>";
					echo "</div>";	
				echo"</center>";
			echo "</div>";
		}
		//if search bar is empty. page will redirect back to index page
		else 
		{
			header("location: index.php");
		}
		?>
	</body>
	<?php include "footer.php";?>
</html>