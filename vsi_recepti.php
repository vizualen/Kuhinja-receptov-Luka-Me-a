<?php
session_start();
include "povezava.php";

$zahtevnost = "";
$cas = "";
$sestavineFilter = "";
$iskanje = "";
$pogoj = "WHERE 1 = 1";

if (isset($_GET["zahtevnost"])) {
    $zahtevnost = mysqli_real_escape_string($povezava, $_GET["zahtevnost"]);
}

if (isset($_GET["cas"])) {
    $cas = $_GET["cas"];
}

if (isset($_GET["sestavine"])) {
    $sestavineFilter = $_GET["sestavine"];
}

if (isset($_GET["iskanje"])) {
    $iskanje = mysqli_real_escape_string($povezava, $_GET["iskanje"]);
}

if ($iskanje != "") {
    $pogoj .= " AND recepti.ime LIKE '%$iskanje%'";
}

if ($zahtevnost != "") {
    $pogoj .= " AND recepti.zahtevnost = '$zahtevnost'";
}

if ($cas == "20") {
    $pogoj .= " AND recepti.cas_priprave <= 20";
} elseif ($cas == "40") {
    $pogoj .= " AND recepti.cas_priprave <= 40";
} elseif ($cas == "60") {
    $pogoj .= " AND recepti.cas_priprave <= 60";
} elseif ($cas == "vec") {
    $pogoj .= " AND recepti.cas_priprave > 60";
}

$sql = "
    SELECT *
    FROM recepti
    $pogoj
    ORDER BY recepti.ime
";

$vsiRecepti = mysqli_query($povezava, $sql);
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Vsi recepti</title>
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
        <td class="besedilo" colspan="3">
            <div class="recept-okvir">
                <h2>Vsi recepti</h2>

                <form class="filter-obrazec" method="get">
                    <label>Isci:</label>
                    <input type="text" name="iskanje" value="<?php echo $iskanje; ?>" placeholder="Ime recepta">

                    <label>Tezavnost:</label>
                    <select name="zahtevnost">
                        <option value="">Vse</option>
                        <option value="Lahko" <?php if ($zahtevnost == "Lahko") { echo "selected"; } ?>>Lahko</option>
                        <option value="Srednje" <?php if ($zahtevnost == "Srednje") { echo "selected"; } ?>>Srednje</option>
                        <option value="Tezko" <?php if ($zahtevnost == "Tezko") { echo "selected"; } ?>>Tezko</option>
                    </select>

                    <label>Cas:</label>
                    <select name="cas">
                        <option value="">Vse</option>
                        <option value="20" <?php if ($cas == "20") { echo "selected"; } ?>>Do 20 min</option>
                        <option value="40" <?php if ($cas == "40") { echo "selected"; } ?>>Do 40 min</option>
                        <option value="60" <?php if ($cas == "60") { echo "selected"; } ?>>Do 60 min</option>
                        <option value="vec" <?php if ($cas == "vec") { echo "selected"; } ?>>Vec kot 60 min</option>
                    </select>

                    <label>Sestavine:</label>
                    <select name="sestavine">
                        <option value="">Vse</option>
                        <option value="5" <?php if ($sestavineFilter == "5") { echo "selected"; } ?>>Do 5 sestavin</option>
                        <option value="10" <?php if ($sestavineFilter == "10") { echo "selected"; } ?>>6 do 10 sestavin</option>
                        <option value="vec" <?php if ($sestavineFilter == "vec") { echo "selected"; } ?>>Vec kot 10 sestavin</option>
                    </select>

                    <button type="submit">Prikazi</button>
                    <a href="vsi_recepti.php">Pocisti</a>
                </form>

                <?php $prikazanih = 0; ?>
                <?php while ($recept = mysqli_fetch_assoc($vsiRecepti)) { ?>
                    <?php
                    $receptId = $recept["id"];
                    $kategorijeId = $recept["kategorije_id"];

                    $rezultatSlika = mysqli_query($povezava, "SELECT * FROM slike WHERE recepti_id = $receptId");
                    $slika = mysqli_fetch_assoc($rezultatSlika);

                    $rezultatKategorija = mysqli_query($povezava, "SELECT * FROM kategorije WHERE id = $kategorijeId");
                    $kategorija = mysqli_fetch_assoc($rezultatKategorija);

                    $rezultatStevilo = mysqli_query($povezava, "SELECT COUNT(*) AS stevilo FROM recepti_sestavine WHERE recepti_id = $receptId");
                    $vrsticaStevilo = mysqli_fetch_assoc($rezultatStevilo);
                    $steviloSestavin = $vrsticaStevilo["stevilo"];

                    if ($sestavineFilter == "5" && $steviloSestavin > 5) {
                        continue;
                    }

                    if ($sestavineFilter == "10" && ($steviloSestavin < 6 || $steviloSestavin > 10)) {
                        continue;
                    }

                    if ($sestavineFilter == "vec" && $steviloSestavin <= 10) {
                        continue;
                    }

                    $prikazanih++;
                    ?>
                    <div class="recept-kartica">
                        <?php if ($slika) { ?>
                            <img src="<?php echo $slika["url"]; ?>" alt="Slika recepta">
                        <?php } ?>
                        <h3><?php echo $recept["ime"]; ?></h3>
                        <p>Kategorija: <?php echo $kategorija["ime"]; ?></p>
                        <p>Cas priprave: <?php echo $recept["cas_priprave"]; ?> min</p>
                        <p>Zahtevnost: <?php echo $recept["zahtevnost"]; ?></p>
                        <p>Sestavin: <?php echo $steviloSestavin; ?></p>
                        <a href="recept.php?id=<?php echo $recept["id"]; ?>">Odpri recept</a>
                    </div>
                <?php } ?>

                <?php if ($prikazanih == 0) { ?>
                    <p>Ni receptov za ta izbor.</p>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
