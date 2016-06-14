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
<div class="edit">
<p>
    Book ID: <?= $row["id"] ?><br>
    Title: <input type="text" value="<?php echo$row["title"] ?>"><br>
    Year Published: <input type="text" value="<?= $row["year_published"] ?>"><br>
    Shelf ID: <input type="text" value="<?= $row["shelf_id"] ?>"><br>
    <a href=""><input type="submit" value="Save"></a>
</p>
</div>

<?php
        }
        else
        {
            echo "Book not in database.";
        }
    }
}
//accept id from find.php
//display options of updateable columns
    //select what column to update
    //execute update query if new data is acceptable

$query = "UPDATE books SET WHERE";

