<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<html>
<head>

<link href="style.css" type="text/css" rel="stylesheet">

<title>Library</title>

</head>

<body>
<h2>Welcome to the Library</h2>

<h4><a href='http://rrynda.wiktel.com/sqltest.php'>Home</a></h4>

<?php

function print_column_header($name, $description)
{
    global $sort;
    global $dir;

    echo "<th><a href='?sort=$name";
    if ($sort == $name)
    {
        echo "&amp;dir=" . ($dir ? "0" : "1");
        echo "'>$description";
        echo " <img src='https://imp.wiktel.com/media/img/admin/arrow-" . ($dir ? "down" : "up") . ".gif'>";
    }
    else
    {
        echo "'>$description";
    }
    echo "</a></th>";
}

$sort = "id";
$dir = 1;
$sortable_columns = array('id', 'title', 'year_published', 'shelf_id');
if (array_key_exists("sort", $_REQUEST) &&
    array_search($_REQUEST["sort"], $sortable_columns))
{
    $sort = $_REQUEST["sort"];
}
if (array_key_exists("dir", $_REQUEST) &&
    $_REQUEST["dir"] == "0")
{
    $dir = 0;
}

$query = "SELECT * FROM books ORDER BY $sort";
if ($dir == 0)
{
    $query .= " DESC";
}
if ($result = $mysqli->query($query))
{
    echo "<table><tr>";
    print_column_header("id", "Book ID");
    print_column_header("title", "Title");
    print_column_header("year_published", "Year Published");
    print_column_header("shelf_id", "Shelf ID");

        # loop over each book row
        while ($row = $result->fetch_assoc())
        {
            #print_r($row);
            #echo "<h2>Title: </h2>" . $row["title"] . "<br>\n";
            #printf ("<p>%s\t%s\t%s\t%s</p>\n", $row["id"], $row["title"], $row["year_published"], $row["shelf_id"]);

            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["year_published"] . "</td><td>" . $row["shelf_id"] . "</td></tr>\n";
        }
    #close table
    echo "</table>"; 
}
else
{
    echo "The database is empty";
}
?>
</body>
</html>
