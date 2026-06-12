<?php
if ($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "mezaluka.lovestoblog.com/") {
    $streznik = "localhost";
    $uporabnik = "root";
    $geslo = "";
    $baza = "kuharski_recepti";
} else {
    $streznik = "sql305.infinityfree.com";
    $uporabnik = "if0_42086910";
    $geslo = "MOJdom1234";
    $baza = "if0_42086910_kuharski_recepti";

}
$povezava = @mysqli_connect($streznik, $uporabnik, $geslo, $baza);

if (!$povezava) {
    die("Povezava z bazo ni uspela. Preveri podatke v datoteki povezava.php.");
}

mysqli_set_charset($povezava, "utf8mb4");
?>
