<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "SELECT * FROM books ORDER BY id DESC";
?>

<html>
<head>

<link href="../style.css" type="text/css" rel="stylesheet">

<title>Book ID Desc</title>

</head>

<body>
<h2>Welcome to the Library</h2>

<h4><a href='http://rrynda.wiktel.com/sqltest.php'>Home</a></h4>

<?php

#make variables for all of the links to sorting pages
$book_id_a = "http://rrynda.wiktel.com/sqltest.php";
$book_id_d = "http://rrynda.wiktel.com/sort/book_id_d.php";
$title_a = "http://rrynda.wiktel.com/sort/title_a.php";
$title_d = "http://rrynda.wiktel.com/sort/title_d.php";
$year_published_a = "http://rrynda.wiktel.com/sort/year_published_a.php";
$year_published_d = "http://rrynda.wiktel.com/sort/year_published_d.php";
$shelf_id_a ="http://rrynda.wiktel.com/sort/shelf_id_a.php";
$shelf_id_d ="http://rrynda.wiktel.com/sort/shelf_id_d.php";
#make variables for the images displayed
$asc = "https://imp.wiktel.com/media/img/admin/arrow-down.gif";
$desc = "https://imp.wiktel.com/media/img/admin/arrow-up.gif";

if($result = $mysqli->query($query))
{
    #begin table, make the column headings
    echo "<table><tr><th><a href='$book_id_a'>Book ID<img src='$desc'></a></th>
    <th><a href='$title_a'>Titles<img src='$asc'></a></th>
    <th><a href='$year_published_a'>Year Published<img src='$asc'></a></th>
    <th><a href='$shelf_id_a'>Shelf ID<img src='$asc'></th></a></tr>\n";

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
    echo "The database is empty";
}

