<?php
session_start();
include "povezava.php";

if (!isset($_SESSION["vloga"]) || $_SESSION["vloga"] != "admin") {
    header("Location: prijava.php");
    exit;
}

$id = (int)$_GET["id"];

mysqli_query($povezava, "DELETE FROM komentarji WHERE recepti_id = $id");
mysqli_query($povezava, "DELETE FROM shranjeni_recepti WHERE recepti_id = $id");
mysqli_query($povezava, "DELETE FROM recepti_sestavine WHERE recepti_id = $id");
mysqli_query($povezava, "DELETE FROM slike WHERE recepti_id = $id");
mysqli_query($povezava, "DELETE FROM recepti WHERE id = $id");

header("Location: index.php");
exit;
?>
