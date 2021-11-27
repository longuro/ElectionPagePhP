<?php
require_once('conf.php');
global $yhendus;
if(isset($_REQUEST["hidden"])) {
    $kask = $yhendus->prepare('UPDATE valimised SET avalik=0 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["hidden"]);
    $kask->execute();
}
if(isset($_REQUEST["opened"])) {
    $kask = $yhendus->prepare('UPDATE valimised SET avalik=1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["opened"]);
    $kask->execute();
}
if(isset($_REQUEST["kustutasid"])){
    $kask=$yhendus->prepare("DELETE FROM valimised WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutasid"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
if(isset($_REQUEST['tuhistamine'])){
    $kask=$yhendus->prepare('UPDATE valimised SET punktid=0 WHERE id=?');
    $kask->bind_param('s', $_REQUEST['tuhistamine']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}if(isset($_REQUEST['komtuhistamine'])){
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid="" WHERE id=?');
    $kask->bind_param('s', $_REQUEST['komtuhistamine']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
    <!Doctype html>
    <html lang="et">
    <head>
        <title>Haldusleht</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <?php
    include('navigation.php');
    ?>
    <body>
    <h1>Election names management</h1>
    <?php
    //valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid, avalik FROM valimised');
    $kask->bind_result($id, $nimi, $punktid, $kommentaarid, $avalik);
    $kask->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>Name</th><th>Rating</th><th>Comment</th><th>Status</th><th>Hide or open</th><th>Admin actions</th>";

    while($kask->fetch()){
        $avatekst="Open";
        $param="opened";
        $seisund="Hidden";
        if($avalik==1){
            $avatekst="Hide";
            $param="hidden";
            $seisund="Opened";
        }

        echo "<tr>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".($punktid)."</td>";
        echo "<td>".($kommentaarid)."</td>";
        echo "<td>".($seisund)."</td>";
        echo "<td><a href='?$param=$id'>$avatekst</a></td>";
        echo "<td><a href='nimideHaldus.php?kustutasid=$id'> Delete note </a><a href='nimideHaldus.php?tuhistamine=$id'> Reset rating </a><a href='nimideHaldus.php?komtuhistamine=$id'> Delete comment</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <div class="link">
        <a href="https://github.com/longuro/ElectionPagePhP">GitHub</a>
    </div>
    <?php
    include('../../footer.php');
    ?>
    </body>
    </html>
<?php
$yhendus->close();
