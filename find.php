<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<html>
<head>

<link href="style.css" type="text/css" rel="stylesheet">

<title>Find a Book</title>

</head>

<body>
<h2>Find a Book</h2>

<h4><a href='sqltest.php'>Home</a></h4>
<h4><a href='find.php'>Find a Book</a></h4>
<!--
<form>

<div class="dropdown">
    <p>
        Type of cover:
        <select name="cover">
            <option value="hard">Hard cover</option>
            <option value="soft">Soft cover</option>
        </select>
    </p>
</div>
<div class="radio">
    <p>
        Library location: 
        <input type="radio" name="location" value="north">North
        <input type="radio" name="location" value="south">South
    </p>
</div>
<div class="date">
    <p>
        <input type="date" name="date">
    </p>
</div>
<div class="checkbox">
    <p>
        <input type="checkbox" name="genre" value="classic">Classic<br>
        <input type="checkbox" name="genre" value="modern">Modern<br>
    </p>
</div>
-->
<?php
#search for and display searched individual books
#echo"To view a book, please enter its ID number: " . '<textarea name="search"></textarea>' . '<div><input type="submit" value="Search"></div>';

$sortable_columns = array('id', 'title', 'year_published', 'shelf_id');
if(!array_key_exists("id", $_REQUEST))
{
    echo "Book ID not entered. Please try again.";
}
else 
{
    $id = $_REQUEST["id"];
    $query = "SELECT * FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";

    #print $query;
    
    if ($result = $mysqli->query($query))
    {
        if ($row = $result->fetch_assoc())
        {
            echo "<ul><li>Book ID: " . $row["id"]  . "</li>\n";
            echo "<li>Title: " . $row["title"] . "</li>\n";
            echo "<li>Year Published: " . $row["year_published"] . "</li>\n";
            echo "<li>Shelf ID: " . $row["shelf_id"] . "</li></ul></form>\n";
        }
   }
}
?>
</form>
</body>
</html>
