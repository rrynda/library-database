<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "SELECT * FROM books";
#$query = "SELECT title FROM books";
?>

<html>
<head>

<link href="style.css" type="text/css" rel="stylesheet">

<title>Library</title>

</head>

<body>
<h2>Welcome to the Library</h2>

<?php
if($result = $mysqli->query($query))
{
    #begin table, make the column headings
    echo "<table><tr><th>Book ID</th><th>Titles</th><th>Year Published</th><th>Shelf ID</th></tr>\n";
        # of the above line of code, the text-align function works.

        #while loop to run through and print all the data in the books table
        while($row = $result->fetch_assoc())
        {
            #print_r($row);
            #echo "<h2>Title: </h2>" . $row["title"] . "<br>\n";
            #printf ("<p>%s\t%s\t%s\t%s</p>\n", $row["id"], $row["title"], $row["year_published"], $row["shelf_id"]);

            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["year_published"] . "</td><td>" . $row["shelf_id"] . "</td></tr>\n";
        }
    #close table
    echo "</table>"; 
} else
{
    #if the database is empty
    echo "The databasse is empty";
}
?>
</body>
</html>
