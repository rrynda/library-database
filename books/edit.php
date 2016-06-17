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

    print_r ($id);
    if ($id != "") //if id != empty
    {
        $query2 = "UPDATE books SET title = '" . $mysqli->real_escape_string($title) . "',
            year_published = '" . $mysqli->real_escape_string($year_published) . "',
            shelf_id = '" . $mysqli->real_escape_string($shelf_id) . "'
            WHERE id = '" . $mysqli->real_escape_string($id) . "'";
        print_r ($query2);
        $mysqli->query($query2);
        
        //CLEAN UP STUFF IN GENERAL
        //if query succeeded
            ?>
            <p>
                Your edit was made successfully.
            </p>
            <?php
        //else
    }
    else //id id = empty
    {
        $query3 = "INSERT INTO books (title, year_published, shelf_id)" . 
            "VALUES ( '" . $mysqli->real_escape_string($title) . "'," .
            "'" . $mysqli->real_escape_string($year_published) . "', " .
            "'" . $mysqli->real_escape_string($shelf_id) . "')";
        print_r ($query3);
        $mysqli->query($query3);
        
        //if query succeeded
            ?>
            <p>
                Book was added successfully.
            </p>
            <?php
        //else
    }
?>


<?php
}
else
{
    if (!array_key_exists("id", $_REQUEST))
    {
        echo "Book ID not entered.";
        
        //display empty form to add book
        $id = null;
        //$title = "Larry";
        $title = null;
        $year_published = null;
        $shelf_id = null;
        form($id, $title, $year_published, $shelf_id);
    }
    else
    {
        $id = $_REQUEST["id"];
        $query1 = "SELECT * FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";
        print_r ($query1);

        if ($result = $mysqli->query($query1))
        {
            if ($row = $result->fetch_assoc())
            {
                $id = $row["id"];
                $title = $row["title"];
                $year_published = $row["year_published"];
                $shelf_id = $row["shelf_id"];
                
                //display filled form to edit book
                form($id, $title, $year_published, $shelf_id);
            }
            else
            {
                echo "Book not in database.";
            }
        }
    }
}


function form($id, $title, $year_published, $shelf_id)
{
    ?>
    <form method="post">
    <div class="edit">
    <p>
    
        Book ID: <?php echo $id ?><br>
        Title: <input  name="title" type="text" value="<?= htmlspecialchars($title) ?>"><br>
        Year Published: <input name="year_published" type="text" value="<?= htmlspecialchars($year_published) ?>"><br>
        Shelf ID: <input name="shelf_id" type="text" value="<?= htmlspecialchars($shelf_id) ?>"><br>
        
            <a href=""><input type="submit" value="<?= $id ? 'Save':'Add'?>"></a>

            <!-- <input type="hidden" name="id" value="<? // = $id ?>"> -->
            <input type="hidden" name="id" value="<?= $id ?>">
        
    </p>
    </div>
    </form>
    <?php
    return "title, year_published, shelf_id"; //return data so query3 can do its thing
}
?>
</body>
</html>
