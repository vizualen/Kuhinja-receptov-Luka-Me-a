<?php
session_start();
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Kuharski recepti</title>
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
            <?php if (isset($_SESSION["email"])) { ?>
                <span class="prijavljen">Prijavljeni ste kot <?php echo $_SESSION["email"]; ?></span>
                <a href="odjava.php">Odjava</a>
            <?php } else { ?>
                <a href="prijava.php">Prijava</a>
                <a href="registracija.php">Registracija</a>
            <?php } ?>
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
        <td class="besedilo">
            <p class="opis">Na spletni strani Kuharski recepti lahko najdes razlicne recepte, jih razvrstis po kategorijah in si shranis najljubse jedi. Uporabniki lahko dodajo tudi svoje recepte in jih delijo z drugimi.</p>
        </td>
        <td class="slika" rowspan="2" colspan="2">
            <img src="slike/kuharskirecept_glavna.png" alt="Slika recepta">
        </td>
    </tr>

    <tr>
        <td class="besedilo">
            <div class="osnovni-recepti">
                <h2>Osnovni recepti</h2>
                <a href="recept.php?id=1">Umesana jajca</a>
                <a href="recept.php?id=2">Palacinke</a>
                <a href="recept.php?id=3">Goveja juha</a>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
