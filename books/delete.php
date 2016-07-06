<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<html>
<head>
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Delete a Book</title>
</head>
<body>
<h2>Delete a Book</h2>

<h4><a href='../'>Home</a></h4>
<h4><a href='./'>View All Books</a></h4>

<?php
#search for and display book to be deleted

$id = $_REQUEST["id"];
$query1 = "SELECT * FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";

#print $query1;
    
if ($result = $mysqli->query($query1))
{
    if ($row = $result->fetch_assoc())
    {
        echo "<ul><li>Book ID: " . $row["id"]  . "</li>\n";
        echo "<li>Title: " . $row["title"] . "</li>\n";
        echo "<li>Year Published: " . $row["year_published"] . "</li>\n";
        echo "<li>Shelf ID: " . $row["shelf_id"] . "</li></ul>\n";

        $title = $row["title"];
        if(!array_key_exists("delete", $_POST))
        {
        ?>

        <form method="post">
        <p>
            Are you sure you want to delete this book?
            <input name="delete" type="submit" value="Yes, delete book"> <!--delete selected book-->
        </p>
        </form>
        <?php

        }
        else
        {
            $query2 = "DELETE FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";
            if ($mysqli->query($query2))
            {
                ?>
                <p class="succeed">
                    "<?= $title ?>" was deleted successfully.
                </p>
                <?php
            }
            else
            {
                ?>
                <p class="error">
                    Failed to delete "<?= $title ?>".
                </p>
                <?php
            }
        }
    }
}


?>

</body>
</html>
