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
function print_table($mysqli, $query)
{
    if ($result = $mysqli->query($query))
    {
        # loop over each book row
        $temp = null;
        //$counter = 0;
        while ($row = $result->fetch_assoc())
        {
            $id = $row["id"];
            //$first_loop = 1;
            
            if ($temp == $id)
            {
                //echo $counter . ") Name remains the same.";

                    //echo "<tr><td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td></tr>\n";
                    //echo "<tr><td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td><td>" . $row["bid"] . "</td><td>" . $row["title"] . "</td></tr>\n";
                    echo "<tr><td>" . $counter . "</td><td>" . $row["title"] . "</td><td class='center'>" . $row["bid"] . "</td><td>" . $row["due_date"] . "</td></tr>\n";
                    $counter ++;
            }
            else
            {
                echo "</table>\n";
                $temp = $id;
                
                //echo $counter . ") Name does not remain the same.";
                if ($row["bid"] == null)
                {
                    echo "<h3>ID: " . $row["id"] . " Name: " . $row["l_name"] . ", " . $row["f_name"] . "</h3>";
                    echo "--" . $row["f_name"] . " has no books checked out.";
                }
                else
                {
                    $counter = 1;
                    echo "<h3>ID: " . $row["id"] . " Name: " . $row["l_name"] . ", " . $row["f_name"] . "</h3>";
                    echo "<table><tr>";
                    echo "<th>Number of Books</th><th>Title</th><th>Book ID</th><th>Due Date</th>";

                    echo "<tr><td>" . $counter . "</td><td>" . $row["title"] . "</td><td class='center'>" . $row["bid"] . "</td><td>" . $row["due_date"] . "</td></tr>\n";
                    $counter++;
                }
            }
        }
        echo "</table>";
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
    
    //$query = "SELECT * FROM patrons ORDER BY $sort";
    $query = "SELECT patrons. id, patrons.f_name, patrons.l_name, checkouts.due_date, books.id AS bid, books.title"
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
    $query = "SELECT patrons. id, patrons.f_name, patrons.l_name, checkouts.due_date, books.id AS bid, books.title"
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