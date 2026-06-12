<?php
session_start();
include "povezava.php";

if (!isset($_SESSION["vloga"]) || $_SESSION["vloga"] != "admin") {
    header("Location: prijava.php");
    exit;
}

$id = (int)$_GET["id"];
$receptId = (int)$_GET["recept_id"];

mysqli_query($povezava, "DELETE FROM komentarji WHERE id = $id");

header("Location: recept.php?id=$receptId");
exit;
?>
