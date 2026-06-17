<?php
session_start();
include "povezava.php";

if (!isset($_SESSION["uporabnik_id"])) {
    header("Location: prijava.php?naprej=moji_recepti.php");
    exit;
}

$uporabnikId = (int)$_SESSION["uporabnik_id"];
$sql = "
    SELECT *
    FROM recepti
    WHERE recepti.uporabniki_id = $uporabnikId
    ORDER BY recepti.datum_objave DESC
";
$receptiUporabnika = mysqli_query($povezava, $sql);
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Moji recepti</title>
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
                <h2>Moji recepti</h2>
                <?php if (mysqli_num_rows($receptiUporabnika) == 0) { ?>
                    <p>Ni mojih receptov.</p>
                <?php } ?>

                <?php while ($recept = mysqli_fetch_assoc($receptiUporabnika)) { ?>
                    <?php
                    $receptId = $recept["id"];
                    $rezultatSlika = mysqli_query($povezava, "SELECT * FROM slike WHERE recepti_id = $receptId");
                    $slika = mysqli_fetch_assoc($rezultatSlika);
                    ?>
                    <div class="recept-kartica">
                        <?php if ($slika) { ?>
                            <img src="<?php echo $slika["url"]; ?>" alt="Slika recepta">
                        <?php } ?>
                        <h3><?php echo $recept["ime"]; ?></h3>
                        <p>Čas priprave: <?php echo $recept["cas_priprave"]; ?> min</p>
                        <p>Zahtevnost: <?php echo $recept["zahtevnost"]; ?></p>
                        <a href="recept.php?id=<?php echo $recept["id"]; ?>">Odpri recept</a>
                    </div>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
