<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<html>
<head>

<link href="style.css" type="text/css" rel="stylesheet">

<title>View Books</title>

</head>

<body>
<h2>View Books</h2>

<h4><a href='../index.php'>Home</a></h4>
<h4><a href='index.php'>View Books</a></h4>
<h4><a href='find.php'>Find a Book</a></h4>

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
        $id = $row["id"];
        //echo "<tr><td><a href='find.php?id=$id'>" . $row["id"] . "</a></td><td><a href='find.php?id=$id'>" . $row["title"] . "</a></td><td><a href='find.php?id=$id'>" . $row["year_published"] . "</a></td><td><a href='find.php?id=$id'>" . $row["shelf_id"] . "</a></td></tr>\n";
        echo "<tr><td><a href='edit.php?id=$id'>" . $row["id"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["title"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["year_published"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["shelf_id"] . "</a></td></tr>\n";
    }
    echo "</table>";
}
else
{
    echo "Query failed:" . $mysqli->error();
}
?>
</body>
</html>
