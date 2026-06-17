<?php
session_start();
include "povezava.php";

$id = 0;
$sporocilo = "";
$jeAdmin = isset($_SESSION["vloga"]) && $_SESSION["vloga"] == "admin";

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $id > 0) {
    if (!isset($_SESSION["uporabnik_id"])) {
        header("Location: prijava.php?naprej=recept.php?id=$id");
        exit;
    }

    $uporabnikId = (int)$_SESSION["uporabnik_id"];

    if ($_POST["akcija"] == "shrani") {
        $preveri = mysqli_query($povezava, "SELECT id FROM shranjeni_recepti WHERE uporabniki_id = $uporabnikId AND recepti_id = $id");
        if (mysqli_num_rows($preveri) == 0) {
            mysqli_query($povezava, "INSERT INTO shranjeni_recepti (uporabniki_id, recepti_id) VALUES ($uporabnikId, $id)");
            $sporocilo = "Recept je shranjen.";
        } else {
            $sporocilo = "Ta recept je že shranjen.";
        }
    }

    if ($_POST["akcija"] == "komentar") {
        $vsebina = $_POST["vsebina"];
        $ocena = (int)$_POST["ocena"];

        if ($ocena >= 1 && $ocena <= 10 && $vsebina != "") {
            $sqlDodajKomentar = "
                INSERT INTO komentarji (vsebina, uporabniki_id, recepti_id, ocena)
                VALUES ('$vsebina', $uporabnikId, $id, $ocena)
            ";

            mysqli_query($povezava, $sqlDodajKomentar);
            $sporocilo = "Komentar je bil dodan.";
        }
    }
}

$sql = "
    SELECT *
    FROM recepti
    WHERE id = $id
";

$rezultat = mysqli_query($povezava, $sql);
$recept = mysqli_fetch_assoc($rezultat);

$rezultatSlika = mysqli_query($povezava, "SELECT * FROM slike WHERE recepti_id = $id");
$slika = mysqli_fetch_assoc($rezultatSlika);

$sestavine = mysqli_query($povezava, "SELECT * FROM recepti_sestavine WHERE recepti_id = $id");

$komentarji = mysqli_query($povezava, "SELECT * FROM komentarji WHERE recepti_id = $id ORDER BY datum DESC");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title><?php if ($recept) { echo "Recept: " . $recept["ime"]; } else { echo "Recept"; } ?></title>
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

    <?php if ($recept) { ?>
    <tr>
        <td class="recept-besedilo" colspan="2" rowspan="2">
            <div class="recept-okvir">
                <h2>Recept: <?php echo $recept["ime"]; ?></h2>

                <?php if ($sporocilo != "") { ?>
                    <p class="prijava-sporocilo"><?php echo $sporocilo; ?></p>
                <?php } ?>

                <?php if ($jeAdmin) { ?>
                    <p class="admin-gumbi">
                        <a href="uredi_recept.php?id=<?php echo $id; ?>">Uredi</a>
                        <a href="brisi_recept.php?id=<?php echo $id; ?>">Izbriši</a>
                    </p>
                <?php } ?>

                <h3>Podatki:</h3>
                <p><b>Čas priprave:</b> <?php echo $recept["cas_priprave"]; ?> min</p>
                <p><b>Zahtevnost:</b> <?php echo $recept["zahtevnost"]; ?></p>
                <p><b>Število oseb:</b> <?php echo $recept["st_oseb"]; ?></p>

                <h3>Sestavine:</h3>
                <ul>
                    <?php while ($sestavina = mysqli_fetch_assoc($sestavine)) { ?>
                        <?php
                        $sestavinaId = $sestavina["sestavine_id"];
                        $rezultatSestavina = mysqli_query($povezava, "SELECT * FROM sestavine WHERE id = $sestavinaId");
                        $podatkiSestavina = mysqli_fetch_assoc($rezultatSestavina);

                        $enotaId = $podatkiSestavina["enote_id"];
                        $rezultatEnota = mysqli_query($povezava, "SELECT * FROM enote WHERE id = $enotaId");
                        $enota = mysqli_fetch_assoc($rezultatEnota);
                        ?>
                        <li><?php echo $sestavina["kolicina"] . " " . $enota["ime"] . " " . $podatkiSestavina["ime"]; ?></li>
                    <?php } ?>
                </ul>

                <h3>Postopek:</h3>
                <p><?php echo nl2br($recept["postopek"]); ?></p>
            </div>
        </td>
        <td class="slika-recepta">
            <?php if ($slika) { ?>
                <img src="<?php echo $slika["url"]; ?>" alt="Slika recepta">
            <?php } else { ?>
                Prostor za sliko
            <?php } ?>

            <?php if (isset($_SESSION["uporabnik_id"])) { ?>
                <form method="post">
                    <input type="hidden" name="akcija" value="shrani">
                    <button type="submit">Shrani recept</button>
                </form>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td class="komentar-prostor">
            <?php if (isset($_SESSION["uporabnik_id"])) { ?>
                <form class="komentar-obrazec" method="post">
                    <input type="hidden" name="akcija" value="komentar">
                    <h3>Dodaj komentar</h3>

                    <label for="vsebina">Komentar:</label>
                    <textarea id="vsebina" name="vsebina" required></textarea>

                    <label for="ocena">Ocena:</label>
                    <select id="ocena" name="ocena">
                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>

                    <button type="submit">Dodaj</button>
                </form>
            <?php } else { ?>
                <a href="prijava.php?naprej=recept.php?id=<?php echo $id; ?>">Za komentar in shranjevanje se morate prijaviti</a>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td class="recept-besedilo" colspan="3">
            <div class="recept-okvir">
                <h3>Komentarji:</h3>

                <?php if (mysqli_num_rows($komentarji) == 0) { ?>
                    <p>Ta recept še nima komentarjev.</p>
                <?php } ?>

                <?php while ($komentar = mysqli_fetch_assoc($komentarji)) { ?>
                    <?php
                    $uporabnikIdKomentar = $komentar["uporabniki_id"];
                    $rezultatUporabnik = mysqli_query($povezava, "SELECT * FROM uporabniki WHERE id = $uporabnikIdKomentar");
                    $uporabnikKomentar = mysqli_fetch_assoc($rezultatUporabnik);
                    ?>
                    <div class="komentar">
                        <p><b><?php echo $uporabnikKomentar["email"]; ?></b> - ocena: <?php echo $komentar["ocena"]; ?>/10</p>
                        <p><?php echo nl2br($komentar["vsebina"]); ?></p>
                        <?php if ($jeAdmin) { ?>
                            <a href="brisi_komentar.php?id=<?php echo $komentar["id"]; ?>&recept_id=<?php echo $id; ?>">Izbriši komentar</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </td>
    </tr>
    <?php } else { ?>
    <tr>
        <td class="besedilo" colspan="3">
            <div class="recept-okvir">
                <h2>Recept ne obstaja</h2>
                <p>Izbrani recept ni bil najden.</p>
                <a href="index.php">Nazaj na glavno stran</a>
            </div>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
