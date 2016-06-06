<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "SELECT * FROM books ORDER BY shelf_id DESC";
?>

<html>
<head>

<link href="../style.css" type="text/css" rel="stylesheet">

<title>Shelf ID Desc</title>

</head>

<body>
<h2>Welcome to the Library</h2>

<?php
if($result = $mysqli->query($query))
{
    #begin table, make the column headings
    echo "<table><tr><th>Book ID</th><th>Titles</th><th>Year Published</th><th>Shelf ID</th></tr>\n";

        #while loop to run through and print all the data in the books table
        while($row = $result->fetch_assoc())
        {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["year_published"] . "</td><td>" . $row["shelf_id"] . "</td></tr>\n";
        }
    #close table
    echo "</table>";
} else
{
    #if the database is empty
    echo "The databasse is empty";
}

