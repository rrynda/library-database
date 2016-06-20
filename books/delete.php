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
<h4><a href='./'>View Books</a></h4>
<!-- <h4><a href='find.php'>Find a Book</a></h4> -->

<form>

<div class="search">
<p>
    To begin deletion of a book, please enter its ID number:
    <textarea name="id"></textarea>
</p>

<input type="submit" value="Submit">

</div>
</form>

<?php
#search for and display book to be deleted

if(!array_key_exists("id", $_REQUEST))
{
    echo "Book ID not entered.";
}
else 
{
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
            echo "<li>Shelf ID: " . $row["shelf_id"] . "</li></ul></form>\n";

            $title = $row["title"];
            if(!array_key_exists("delete", $_POST))
            {
            ?>
            
            <form method="post">
            <p>
                Are you sure you want to delete this book?
                <input name="delete" type="submit" value="Yes, delete book"> <!--delete selected book-->
                <!--<input type="hidden" name="delete" value ="false"> -->
                <!--<a href='delete.php'><input name="!delete" type="submit" value="No, do not delete book"></a> -->
            </p>
            </form>
            <?php
            //print_r ($_POST);
            //if(array_key_exists("delete", $_POST)) //book deletion confirmed; delete button pushed
            //{
            }
            else
            {
                $query2 = "DELETE FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";
                //print $query2;
                //print_r ($_POST);
                if ($mysqli->query($query2))
                {
                    //print_r ($_POST);
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
        else
        {
            echo "Book not in database.";
        }
    }
}

?>

</body>
</html>
