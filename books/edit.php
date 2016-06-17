<?php
header('Content-Type: text/html; charset=UTF-8');

require_once(dirname($_SERVER["DOCUMENT_ROOT"]) . "/lib/mysql_db.inc.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?><!DOCTYPE html>
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
    $title = $_POST["title"];
    $year_published = $_POST["year_published"];
    $shelf_id = $_POST["shelf_id"];

    if ($id != "")
    {
        $query = "UPDATE books SET title = '" . $mysqli->real_escape_string($title) . "',
            year_published = '" . $mysqli->real_escape_string($year_published) . "',
            shelf_id = '" . $mysqli->real_escape_string($shelf_id) . "'
            WHERE id = '" . $mysqli->real_escape_string($id) . "'";
    }
    else
    {
        $query = "INSERT INTO books (title, year_published, shelf_id)" .
            "VALUES ( '" . $mysqli->real_escape_string($title) . "'," .
            "'" . $mysqli->real_escape_string($year_published) . "', " .
            "'" . $mysqli->real_escape_string($shelf_id) . "')";
    }

    if ($mysqli->query($query))
    {
        ?>
        <p class="succeed">
            "<?= $title ?>" was saved successfully.
        </p>
        <?php
    }
    else
    {
        ?>
        <p class="error">
            Failed to save "<?= $title ?>".
        </p>
        <?php
    }
}
else
{
    # No form was submitted.

    if (!array_key_exists("id", $_REQUEST))
    {
        $id = "";
        $title = "";
        $year_published = "";
        $shelf_id = "";
        form($id, $title, $year_published, $shelf_id);
    }
    else
    {
        $id = $_REQUEST["id"];
        $query = "SELECT * FROM books WHERE id = '" . $mysqli->real_escape_string($id) . "'";

        if ($result = $mysqli->query($query))
        {
            if ($row = $result->fetch_assoc())
            {
                $id = $row["id"];
                $title = $row["title"];
                $year_published = $row["year_published"];
                $shelf_id = $row["shelf_id"];

                form($id, $title, $year_published, $shelf_id);
            }
            else
            {
                echo "Book not in database.";
            }
        }
        else
        {
            echo "Database query failed.";
        }
    }
}

function form($id, $title, $year_published, $shelf_id)
{
    ?>
    <form method="post">
    <div class="edit">
    <p>
        Book ID: <?php echo $id ?><input type="hidden" name="id" value="<?= $id ?>"><br>
        <label for="title">Title</label>: <input id="title" name="title" type="text" value="<?= htmlspecialchars($title) ?>"><br>
        <label for="year_published">Year Published</label>: <input id="year_published" name="year_published" type="text" value="<?= htmlspecialchars($year_published) ?>"><br>
        <label for="shelf_id">Shelf ID</label>: <input id="shelf_id" name="shelf_id" type="text" value="<?= htmlspecialchars($shelf_id) ?>"><br>
        <input type="submit" value="<?= $id ? 'Save' : 'Add' ?>">
    </p>
    </div>
    </form>
    <?php
}
?>
</body>
</html>
