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
        print_column_header("a_f_name", "Author First Name");
        print_column_header("a_l_name", "Author Last Name");
        print_column_header("p_f_name", "Patron First Name");
        print_column_header("p_l_name", "Patron Last Name");

        # loop over each book row
        while ($row = $result->fetch_assoc())
        {
            $id = $row["id"];
            //echo "<tr><td><a href='find.php?id=$id'>" . $row["id"] . "</a></td><td><a href='find.php?id=$id'>" . $row["title"] . "</a></td><td><a href='find.php?id=$id'>" . $row["year_published"] . "</a></td><td><a href='find.php?id=$id'>" . $row["shelf_id"] . "</a></td></tr>\n";
            //echo "<tr><td><a href='edit.php?id=$id'>" . $row["id"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["title"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["year_published"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["shelf_id"] . "</a></td></tr>\n";
            //echo "<tr><td><a href='edit.php?id=$id'>" . $row["id"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["title"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["year_published"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["shelf_id"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["f_name"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["l_name"] . "</a></td></tr>\n";
            echo "<tr><td><a href='edit.php?id=$id'>" . $row["id"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["title"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["year_published"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["shelf_id"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["a_f_name"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["a_l_name"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["p_f_name"] . "</a></td><td><a href='edit.php?id=$id'>" . $row["p_l_name"] . "</a></td></tr>\n";
        }
        echo "</table>";
        ?>
        <form action="edit.php">
        <div class="add_button">
            <input type="submit" value="Add a Book">
        </div>
        </form>
        <?php
    }
    else
    {
        echo "Query failed:" . $mysqli->error;
    }
}

if(!array_key_exists("search", $_REQUEST))
{
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

    //$query = "SELECT * FROM books ORDER BY $sort";
    $query = "SELECT books.id, books.title, books.year_published, books.shelf_id, authors.f_name AS a_f_name, authors.l_name AS a_l_name, patrons.f_name AS p_f_name, patrons.l_name AS p_l_name"
            . " FROM books"
            . " LEFT JOIN checkouts ON books.id = checkouts.book_id"
            . " LEFT JOIN patrons ON checkouts.patron_id = patrons.id"
            . " LEFT JOIN authors_books ON books.id = authors_books.book_id"
            . " LEFT JOIN authors ON authors_books.author_id = authors.id"
            . " ORDER BY books.$sort";

/*    $query = "SELECT books.id, books.title, books.year_published, books.shelf_id, authors.f_name AS a_f_name, authors.l_name AS a_l_name, patrons.f_name AS p_f_name, patrons.l_name AS p_l_name"
            . " FROM books"
            . " LEFT JOIN checkouts ON books.id = checkouts.book_id"
            . " LEFT JOIN patrons ON checkouts.patron_id = patrons.id"
            . " LEFT JOIN authors_books ON books.id = authors_books.book_id"
            . " LEFT JOIN authors ON authors_books.author_id = authors.id"
            //. " ORDER BY books.$sort";
            . " ORDER BY patrons.$sort";
*/
    if ($dir == 0)
    {
        $query .= " DESC";
    }

    print_table($mysqli, $query);
}
else
{
//query for LIKE and substrings
    $input = ($_REQUEST['search']);
    $pieces = explode(" ", $input);
    $query = "";

    foreach($pieces as $piece)
    {
        if ($query != "")
        {
            $query = "AND";
        }
        $query = "title LIKE '%" . $mysqli->real_escape_string($piece) . "%'" .
            "OR year_published LIKE '%" . $mysqli->real_escape_string($piece) . "%'";

/*        $query = "title LIKE '%" . $mysqli->real_escape_string($piece) . "%'" .
            "OR year_published LIKE '%" . $mysqli->real_escape_string($piece) . "%'";
*/
    }
    //$query = "SELECT * FROM books WHERE " . $query;
    $query = "SELECT books.id, books.title, books.year_published, books.shelf_id, authors.f_name AS a_f_name, authors.l_name AS a_l_name, patrons.f_name AS p_f_name, patrons.l_name AS p_l_name"
            . " FROM books"
            . " LEFT JOIN checkouts ON books.id = checkouts.book_id"
            . " LEFT JOIN patrons ON checkouts.patron_id = patrons.id"
            . " LEFT JOIN authors_books ON books.id = authors_books.book_id"
            . " LEFT JOIN authors ON authors_books.author_id = authors.id"
            . " WHERE "
            . $query;
    print_table($mysqli, $query);
}
?>
</body>
</html>
