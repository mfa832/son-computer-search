<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>School of Nursing - Computer Search</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">

<?php
/*.CSV Based
Files needed to run:
index.php – the main file
computer_lookup.csv – spreadsheet of computer information
view.css and image files – page styling

*/?>
</head>

<body id="main_body" >
	<br>
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1>//</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="form">
					<div class="form_description">
			<br /><img id = "" src="uthlogo.png" alt="UTHealth" border="0"><br /><br />
			<label class = "description"><h2>School of Nursing - Computer Search</h2></label>
			
		</div>						
			<ul ><li id="li_1" >
		
		<label class="description" for="element_1">Search by Location, Serial No., Type, or Monitor/MS Tag.<br>
		(Type 'ALL' to show all systems)</label>
		
		</li>
			
					<li class="buttons">
			    <input type="text" name="searchKey" value="" autocomplete="off"/>
			    
					
				<input id="saveForm" class="button_stylish" type="submit" name="submit" value="Search" />
				
		</li>
			</ul>
		</form>	
		


<?php
//checks if there is a the 'Search' button has been clicked. If it hasn't, the rest of the page will not load.
if (!isset($_POST["submit"]))
{
	//if the user has not clicked the search button, nothing will show
	echo "<br/><br/><br/>";
}
else {
	/* $data is the search query input by the user */
	$data = $_POST['searchKey'];
	
	/*removes any whitespaces and changes to uppercase to account for any valid user input. */
	$data = preg_replace('/\s+/','',strtoupper($data) );
	
	//Verifies that the user has entered a valid search term. Only alphanumeric values and whitespace is allowed.
	//Displays an error if nothing is entered or if a non-alphanumeric string is entered.
	//Need to validate input to protect against injection of unwanted files/code
	if (empty($data))
	{ die("<br /><br /> <b>ERROR:</b> No search key entered.<br /><br />");}
	else if (!preg_match("/^[A-Z\d\-_\s]+$/", $data)) 
	{ die("<h2>Invalid Search.</h2>"); }
	
	//prints table header
	echo '<form id="son_computer_search" class="appnitro"  method="post" action="">	<div class="form_description">';
	echo "<h2>Search Results</h2><br></div><ul >";
	echo "<table class=\"tg\">";
	echo "<th>Location</th><th>Serial No.</th><th>MS Tag</th><th>ITAMS Name</th><th>OS</th><th>User</th><th>Type</th><th>Monitor Tag</th>";

	//opens .csv file 
	$file = fopen("computer_lookup.csv","r");

	// results counter
	$k = 0;

	while(! feof($file))
	{
		
	/*search by Type if the search string is Desktop or Laptop*/
	if  ($data === 'DESKTOP'||$data === 'LAPTOP')
	{ $i = 6; }
	/*search by MS Tag if the search string is 6 charcters long*/
	else if  (strlen($data) === 6)
	{ $i = 2; }
	/*search by Location if the search string is 3 charcters long*/
	else if  (strlen($data) === 3)
	{ $i = 0; }
	/*search by Monitor Tag if the search string is 1 or 2 charcters long*/
	else if (strlen($data) <= 2)
	{ $i = 7; }
	/*search by Serial if it does not meet any of the above criteria*/
	else
	{ $i = 1; }




  $f = fgetcsv($file);
 
 //forces all strings being read in from spread sheet to uppercase to accou
  if ($data == strtoupper($f[$i]) || $data == 'ALL') //
  {
                echo "<tr>";
                echo "<td class=\"tg-yw4l\">SON-$f[0]</td>";
                echo "<td class=\"tg-yw4l\"> $f[1]</td>";
				echo "<td class=\"tg-yw4l\"> $f[2]</td>";
				echo "<td class=\"tg-yw4l\"> $f[3]</td>";
				echo "<td class=\"tg-yw4l\"> $f[4]</td>";
				echo "<td class=\"tg-yw4l\"> $f[5]</td>";
                echo "<td class=\"tg-yw4l\"> $f[6]</td>";
                echo "<td class=\"tg-yw4l\"> $f[7]</td>";
                echo "</tr>\n";
                $k++;}
	 
  }
 
 echo "</table>"; 

fclose($file);

// displays the number of search results or if no systems were found
if ($k == 0) { echo "<br /><br /> {$data} Not found in database."; }
else {echo "<br /> {$k} results.";}


}

?>
			</ul>
		</form>	
		<div id="footer">
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>
