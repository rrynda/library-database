<?php
$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASSWORD', 'DB_NAME');

$query = "SELECT * FROM books";
#$query = "SELECT title FROM books";

#make a title bar denoting what is displayed
echo "<h2>Book_ID\tTitle\tYear_Published\tShelf_ID</h2>\n";

if($result = $mysqli->query($query))
{
    #while loop to run through and print all the data in the books table
    while($row = $result->fetch_assoc())
    {
        #print_r($row);
        #echo "<h2>Title: </h2>" . $row["title"] . "<br>\n";
        printf ("<p>%s\t%s\t%s\t%s</p>\n", $row["id"], $row["title"], $row["year_published"], $row["shelf_id"]);
    }
}
