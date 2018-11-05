<?php  

require("phpsqlajax_dbinfo.php"); 

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 


if (empty($_GET['q'])) {
  //if query is empty do nothing
  $category = "";
} else {
  $category = $_GET['q'];
}; 


// eg. $category = "Nurse";

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 

// Select all the rows in the markers table

//other ref. $query = "SELECT * FROM markers WHERE 1";
//other ref. $query = "SELECT * FROM markers WHERE comp_nature_cat LIKE 'Nurse'";

$query = "SELECT * FROM markers WHERE comp_nature_cat LIKE '$category'";
$result = mysql_query($query);
if (!$result) {  
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE
  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   
  $newnode->setAttribute("nametest",$row['comp_name']);

  //other ref. $newnode->setAttribute("address","1");
  //other ref. $newnode->setAttribute("address", $row['street_no' + '", "' + 'town_and_jmpostal' + '", "' +'country']);

  $newnode->setAttribute("st", $row['street_no']);   
  $newnode->setAttribute("parishPosCode", $row['town_and_jmpostal']);
  $newnode->setAttribute("country", $row['country']);
  $newnode->setAttribute("category", $row['comp_nature_cat']);
  $newnode->setAttribute("teleph", $row['telephone_1_1stonfile']);
  
  ////other ref.
  //$newnode->setAttribute("lat", $row['lat']);  
  //$newnode->setAttribute("lng", $row['lng']);  
  //$newnode->setAttribute("icontype", $row['simple_nature_cat']);
  ////
} 

echo $dom->saveXML();

?>