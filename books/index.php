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

<h4><a href='../'>Home</a></h4>
<h4><a href='./'>View All Books</a></h4>
<!-- <h4><a href='find.php'>Find a Book</a></h4> -->

<form>
<div class="search_box">
    <input type="submit" value="Search">
    <input type="text" name="search" maxlength="100">
</div>
</form>

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

function print_table($mysqli, $query)
{
    global $sort;
    global $dir;
    
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
        ?>
        <p>
        <a href='edit.php'><input type="submit" value="Add a Book"></a>
        </p>
        <?php
    }
    else
    {
        echo "Query failed:" . $mysqli->error;
    }
}

if(!array_key_exists("search", $_REQUEST))
{
    //echo "No search parameters entered.";
    
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

    print_table($mysqli, $query);
}
else
{
    //echo "Search parameters entered.";

/*    $title = $_REQUEST['search'];
    $year_published = $_REQUEST['search'];
    $shelf_id = $_REQUEST['search'];
*/
//query for an exact match
/*    $query2 = "SELECT * FROM books WHERE title = '" . $mysqli->real_escape_string($title) . "'" .
        "OR year_published = '" . $mysqli->real_escape_string($year_published) . "'" .
        "OR shelf_id = '" . $mysqli->real_escape_string($shelf_id) . "'";

    print_table($mysqli, $query2);
*/
//query for LIKE
/*    $query3 = "SELECT * FROM books WHERE title LIKE '%" . $mysqli->real_escape_string($title) . "%'" .
        "OR year_published LIKE '%" . $mysqli->real_escape_string($year_published) . "%'" .
        "OR shelf_id LIKE '%" . $mysqli->real_escape_string($shelf_id) . "%'";

    print_table($mysqli, $query3);
*/
//query for LIKE only looking at title
/*    $query4 = "SELECT * FROM books WHERE title LIKE '%" . $mysqli->real_escape_string($title) . "%'";

    print_table($mysqli, $query4);
*/

//query for LIKE and substrings
    $input = ($_REQUEST['search']);
    //echo $input;
    $length = str_word_count($input, 0, '0123456789,:'); //characters between '' designate characters to be counted as words.
        //str_word_count could also be used to turn the string into an array and store each word in an index by replacing 0 with 1
    //echo $length;

    if ($length == 1)
    {
        $query3 = "SELECT * FROM books WHERE title LIKE '%" . $mysqli->real_escape_string($input) . "%'" .
            "OR year_published LIKE '%" . $mysqli->real_escape_string($input) . "%'" .
            "OR shelf_id LIKE '%" . $mysqli->real_escape_string($input) . "%'";
        //echo $query3;
        print_table($mysqli, $query3);
    }
    else
    {
        //$pieces = explode(" ", $input);
        $pieces = str_word_count($input, 1, '0123456789,:');
        $counter = $length;
        $query5 = "SELECT * FROM books WHERE "; //array[all the search terms stored in varables];

        for ($index = 0; $index < $length; $index++)
        {
            $word = $pieces[$index];

            $temp = "(title LIKE '%" . $mysqli->real_escape_string($pieces[$index]) . "%'" .
                "OR year_published LIKE '%" . $mysqli->real_escape_string($pieces[$index]) . "%')"; //add . to concatenate to shelf_id line below
                //"OR shelf_id LIKE '%" . $mysqli->real_escape_string($pieces[$index]) . "%')";
            //echo $temp;

            if ($counter == 1)
            {
                $query5 = $query5 . $temp; //end query
            }
            else
            {
                $query5 = $query5 . $temp . " AND ";//add to query with AND
                $counter--;
            }
        }
        //echo $query5;
        print_table($mysqli, $query5);
    }
}
?>
</body>
</html>
