<?php
require_once('conf.php');
global $yhendus;
if(!empty($_REQUEST['newname'])){
    $kask=$yhendus->prepare('INSERT INTO valimised(nimi, lisamisaeg) Values (?, Now())');
    $kask->bind_param('s', $_REQUEST['newname']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>

<!Doctype html>
<html lang="et">
<head>
    <title>Adding new note page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
include('navigation.php');
?>
<main>
    <header>
        <h1>Adding new name</h1>
    </header>
    <form action="?">
        <label for="newname">Nimi</label>
        <input type="text" id="newname" name="newname" placeholder="new name">
        <input type="submit" value="OK">
    </form>
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
