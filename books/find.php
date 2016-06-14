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

<h4><a href='../index.php'>Home</a></h4>
<h4><a href='index.php'>View Books</a></h4>
<h4><a href='find.php'>Find a Book</a></h4>

<form>

<div class="search">
<p>
    To view a book, please enter its ID number:
    <textarea name="id"></textarea>
</p>

<input type="submit" value="Find">

</div>
</form>

<?php
#search for and display searched individual books

if(!array_key_exists("id", $_REQUEST))
{
    echo "Book ID not entered.";
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
        else
        {
            echo "Book not in database.";
        }
   }
}

?>

<form>
<p>
    <a href='edit.php'><input type="submit" value="Edit"></a>
</p>
</form>
</body>
</html>
