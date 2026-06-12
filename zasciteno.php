<?php
session_start();

if (!isset($_SESSION["uporabnik_id"])) {
    header("Location: prijava.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Zaščitena stran</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<table>
    <tr class="zgornja-vrstica">
        <td class="naslov"><h1>Kuharski recepti</h1></td>
        <td class="meni">
            <a href="index.php">Domov</a>
            <a href="vsi_recepti.php">Recepti</a>
            <a href="kategorija.php?id=1">Kategorije</a>
            <a href="dodaj_recept.php">Dodaj recept</a>
            <a href="viri.php">Viri</a>
        </td>
        <td class="prijava">
            <span class="prijavljen">Prijavljeni ste kot <?php echo $_SESSION["email"]; ?></span>
            <a href="odjava.php">Odjava</a>
        </td>
    </tr>

    <tr>
        <td class="kategorije" colspan="3">
            <b>Kategorije</b>
            <a href="kategorija.php?id=1">Juhe</a>
            <a href="kategorija.php?id=2">Glavne jedi</a>
            <a href="kategorija.php?id=3">Sladice</a>
            <a href="kategorija.php?id=4">Solate</a>
            <a href="vsi_recepti.php">Vsi Recepti</a>
        </td>
    </tr>

    <tr>
        <td class="recepti" colspan="3">
            <b>Recepti</b>
            <a href="moji_recepti.php">Moji recepti</a>
            <a href="dodaj_recept.php">Dodaj recept</a>
            <a href="shranjeni_recepti.php">Shranjeni recepti</a>
        </td>
    </tr>

    <tr>
        <td class="besedilo" colspan="3">
            <div class="recept-okvir">
                <h2>Za to stran morate biti prijavljeni</h2>
                <p>Ta del strani je pripravljen za prijavljene uporabnike.</p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
