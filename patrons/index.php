<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet">
<title>View Patrons</title>
</head>

<body>
<h2>View Patrons</h2>

<h4><a href='../'>Home</a></h4>
<h4><a href='./'>View All Patrons</a></h4>

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
    if ($result = $mysqli->query($query))
    {
        global $sort;
        global $dir;

        //echo "<table><tr>";
/*        print_column_header("id", "Patron ID");
        print_column_header("f_name", "First Name");
        print_column_header("l_name", "Last Name");
        print_column_header("bid", "Book ID");
        print_column_header("title", "Title");
*/
        # loop over each book row
        $temp = null;
        //$counter = 0;
        while ($row = $result->fetch_assoc())
        {
            $id = $row["id"];
            
            //if ($f_name != $f_temp && $l_name != $l_temp)
            if ($temp == $id)
            {
                //echo $counter . ") Name remains the same.";

                    //echo "<tr><td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td></tr>\n";
                    //echo "<tr><td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td><td>" . $row["bid"] . "</td><td>" . $row["title"] . "</td></tr>\n";
                    echo "<tr><td>" . $counter . "</td><td>" . $row["title"] . "</td><td>" . $row["bid"] . "</td></tr>\n";
                    $counter ++;
            }
            else
            {
                echo "</table>";
                
                //echo $counter . ") Name does not remain the same.";
                
                if ($row["bid"] == null)
                {
                    $counter = 0;
                }
                else
                {
                    $counter = 1;
                }
                $temp = $id;
                
                echo "<h3>" . $row["f_name"] . " " . $row["l_name"] . "     ID: " . $row["id"] . "</h3>";
                
                echo "<table><tr>";
                print_column_header("", "Number of Books");
                print_column_header("title", "Title");
                print_column_header("bid", "Book ID");
                
                echo "<tr><td>" . $counter . "</td><td>" . $row["title"] . "</td><td>" . $row["bid"] . "</td></tr>\n";
                $counter++;
            }

        }
        echo "</table>";

/*        //$name = $row["l_name"] . ", " . $row["f_name"];
        //$temp = $name;
        if ( $name == null)
        {
            ?>
            <h5><?$name?></>
            <table>
            
            <?php
        }
        else if($name != $temp)
        {
            $temp = $name;
        }
        else
        {
            
        }
*/
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
    $sortable_columns = array('id', 'f_name', 'l_name');

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
    //$query = "SELECT * FROM patrons ORDER BY $sort";
    $query = "SELECT patrons. id, patrons.f_name, patrons.l_name, books.id AS bid, books.title"
            . " FROM patrons"
            . " LEFT JOIN checkouts ON patrons.id = checkouts.patron_id"
            . " LEFT JOIN books ON checkouts.book_id = books.id"
            . " ORDER BY patrons.$sort";    
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
        $query = "f_name LIKE '%" . $mysqli->real_escape_string($piece) . "%'" .
            "OR l_name LIKE '%" . $mysqli->real_escape_string($piece) . "%'";
    }
    //$query = "SELECT * FROM books WHERE " . $query;
    $query = "SELECT patrons. id, patrons.f_name, patrons.l_name, books.id AS bid, books.title"
            . " FROM patrons"
            . " LEFT JOIN checkouts ON patrons.id = checkouts.patron_id"
            . " LEFT JOIN books ON checkouts.book_id = books.id"
            . " WHERE "
            . $query;
    print_table($mysqli, $query);
}
?>
</body>
</html>