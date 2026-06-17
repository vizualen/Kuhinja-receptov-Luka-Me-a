<?php
session_start();
include "povezava.php";

if (!isset($_SESSION["uporabnik_id"])) {
    header("Location: prijava.php?naprej=shranjeni_recepti.php");
    exit;
}

$uporabnikId = (int)$_SESSION["uporabnik_id"];

if (isset($_POST["odstrani"])) {
    $receptId = (int)$_POST["recept_id"];
    mysqli_query($povezava, "DELETE FROM shranjeni_recepti WHERE uporabniki_id = $uporabnikId AND recepti_id = $receptId");
}

$sql = "
    SELECT *
    FROM shranjeni_recepti
    WHERE uporabniki_id = $uporabnikId
    ORDER BY datum DESC
";
$shranjeni = mysqli_query($povezava, $sql);
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Shranjeni recepti</title>
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
                <h2>Shranjeni recepti</h2>
                <?php if (mysqli_num_rows($shranjeni) == 0) { ?>
                    <p>Ni shranjenih receptov.</p>
                <?php } ?>

                <?php while ($shranjen = mysqli_fetch_assoc($shranjeni)) { ?>
                    <?php
                    $receptId = $shranjen["recepti_id"];
                    $rezultatRecept = mysqli_query($povezava, "SELECT * FROM recepti WHERE id = $receptId");
                    $recept = mysqli_fetch_assoc($rezultatRecept);

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
                        <form method="post">
                            <input type="hidden" name="recept_id" value="<?php echo $recept["id"]; ?>">
                            <button type="submit" name="odstrani">Odstrani</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
