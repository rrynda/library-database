<!DOCTYPE html>
<?php
require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<html>
<head>

<link href="style.css" type="text/css" rel="stylesheet">

<title>Edit Book Entry</title>

</head>
<body>
<h2>Edit Book Entry</h2>

<h4><a href='../index.php'>Home</a></h4>
<h4><a href='index.php'>View Books</a></h4>
<h4><a href='find.php'>Find a Book</a></h4>

<form>
<div class="search">
<p>
    To edit a book, please enter its ID number:
    <textarea name="id"></textarea>
</p>

<input type="submit" value="Edit">

</div>
</form>

<?php
if (array_key_exists("id", $_POST))
{
    $id = $_POST["id"];
      //print_r ($id);
    $title = $_POST["title"];
      //print_r ($title);
    $year_published = $_POST["year_published"];
      //print_r ($year_published);
    $shelf_id = $_POST["shelf_id"];
      //print_r ($shelf_id);

    $query2 = "UPDATE books SET title = '" . $mysqli->real_escape_string($title) . "',
        year_published = '" . $mysqli->real_escape_string($year_published) . "',
        shelf_id = '" . $mysqli->real_escape_string($shelf_id) . "'
        WHERE id = '" . $mysqli->real_escape_string($id) . "'";
      print_r ($query2);
    $mysqli->query($query2);
?>

<p>
    Your edit was made successfully.
</p>

<?php
}else
{
    if(!array_key_exists("id", $_REQUEST))
    {
        echo "Book ID not entered.";
    }
    else
    {
        $id = $_REQUEST["id"];
        $query1 = "SELECT * FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";
        #print $query;

        if ($result = $mysqli->query($query1))
        {
            if ($row = $result->fetch_assoc())
            {
    ?>
    <form method="post">
    <div class="edit">
    <p>
    
        Book ID: <?= $row["id"] ?><br>
        Title: <input  name="title" type="text" value="<?php echo$row["title"] ?>"><br>
        Year Published: <input name="year_published" type="text" value="<?= $row["year_published"] ?>"><br>
        Shelf ID: <input name="shelf_id" type="text" value="<?= $row["shelf_id"] ?>"><br>
        <a href=""><input type="submit" value="Save"></a>

        <input type="hidden" name="id" value="<?= $id ?>">
    </p>
    </div>
    </form>

    <?php
            }
            else
            {
                echo "Book not in database.";
            }
        }
    }
}

?>
</body>
</html>
