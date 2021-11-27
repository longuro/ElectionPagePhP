<?php
require_once('conf.php');
global $yhendus;

if(isset($_REQUEST["rating"])) {
    $kask = $yhendus->prepare('UPDATE valimised SET punktid=punktid + 1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["rating"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["comment"])){
    $kask = $yhendus->prepare('UPDATE valimised SET kommentaarid=? WHERE id=?');
    $commenttext=$_REQUEST['commenttext']."\n";
    $kask->bind_param('si', $commenttext, $_REQUEST["comment"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
<!Doctype html>
<html lang="et">
<head>
    <title>Election page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
include('navigation.php');
?>
<main>
    <h1>Election page</h1>


<?php
    global $yhendus;
    $kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid FROM valimised WHERE avalik=1');
    $kask->bind_result($id, $nimi, $punktid, $kommentaarid);
    $kask->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>Name</th><th>Rating</th><th>Comments</th><th>Give your rating</th><th>Submit comment</th>";

    while($kask->fetch()){
        echo "<tr>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".($punktid)."</td>";
        echo "<td>".($kommentaarid)."</td>";
        echo "<td><a href='?rating=$id'>Give +1 rating</a></td>";
        echo "<td>
                <form action='?'>
                <input type='hidden' name='comment' value='$id'>
                <input type='text' id='commenttext' name='commenttext' placeholder='Your comment'>
                <input type='submit' value='Submit comment'>
                </form></td>";
        echo "</tr>";
    }
echo "</table>";
?>
</main>
<div class="link">
    <a href="https://github.com/longuro/ElectionPagePhP" target="_blank">GitHub</a>
</div>
<?php
include('../../footer.php');
?>
</body>
</html>
<?php
$yhendus->close();
/*CREATE TABLE valimised(
    id int primary key auto_increment,
    nimi varchar(100),
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaarid text,
    avalik int DEFAULT 1);

Insert into valimised(nimi, lisamisaeg, punktid, kommentaarid,avalik)
Values ('Karlson', '2021-11-1', 10, 'Väga hea raamat', 1);

Select * From valimised*/
