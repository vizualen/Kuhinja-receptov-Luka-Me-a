<?php
session_start();
include "povezava.php";

if (!isset($_SESSION["uporabnik_id"])) {
    header("Location: prijava.php?naprej=dodaj_recept.php");
    exit;
}

$kategorije = mysqli_query($povezava, "SELECT * FROM kategorije ORDER BY ime");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST["ime"];
    $postopek = $_POST["postopek"];
    $casPriprave = (int)$_POST["cas_priprave"];
    $zahtevnost = $_POST["zahtevnost"];
    $kategorijeId = (int)$_POST["kategorije_id"];
    $stOseb = (int)$_POST["st_oseb"];
    $uporabnikId = (int)$_SESSION["uporabnik_id"];

    $sql = "INSERT INTO recepti (ime, postopek, cas_priprave, zahtevnost, kategorije_id, uporabniki_id, st_oseb)
            VALUES ('$ime', '$postopek', $casPriprave, '$zahtevnost', $kategorijeId, $uporabnikId, $stOseb)";
    mysqli_query($povezava, $sql);
    $receptId = mysqli_insert_id($povezava);

    if (isset($_FILES["slika"]) && $_FILES["slika"]["name"] != "") {
        $imeSlike = $_FILES["slika"]["name"];
        $potSlike = "slike/" . $imeSlike;
        move_uploaded_file($_FILES["slika"]["tmp_name"], $potSlike);
        mysqli_query($povezava, "INSERT INTO slike (ime, url, recepti_id) VALUES ('$ime', '$potSlike', $receptId)");
    }

    for ($i = 0; $i < count($_POST["kolicina"]); $i++) {
        $kolicina = trim($_POST["kolicina"][$i]);
        $enota = trim($_POST["enota"][$i]);
        $sestavinaIme = trim($_POST["sestavina"][$i]);

        if ($kolicina == "" || $enota == "" || $sestavinaIme == "") {
            continue;
        }

        mysqli_query($povezava, "INSERT INTO enote (ime) VALUES ('$enota')");
        $enotaId = mysqli_insert_id($povezava);

        mysqli_query($povezava, "INSERT INTO sestavine (ime, opis, enote_id) VALUES ('$sestavinaIme', '', $enotaId)");
        $sestavinaId = mysqli_insert_id($povezava);

        mysqli_query($povezava, "INSERT INTO recepti_sestavine (kolicina, recepti_id, sestavine_id) VALUES ('$kolicina', $receptId, $sestavinaId)");
    }

    header("Location: recept.php?id=$receptId");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Dodaj recept</title>
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
        <td class="prijava-stran" colspan="3">
            <div class="dodaj-okvir">
                <h2>Dodaj recept</h2>

                <form method="post" enctype="multipart/form-data">
                    <table class="dodaj-tabela">
                        <tr>
                            <td><label for="ime">Ime recepta:</label></td>
                            <td><input type="text" id="ime" name="ime" required></td>
                        </tr>
                        <tr>
                            <td><label for="cas_priprave">Čas priprave:</label></td>
                            <td><input type="number" id="cas_priprave" name="cas_priprave" required></td>
                        </tr>
                        <tr>
                            <td><label for="zahtevnost">Zahtevnost:</label></td>
                            <td>
                                <select id="zahtevnost" name="zahtevnost">
                                    <option value="Lahko">Lahko</option>
                                    <option value="Srednje">Srednje</option>
                                    <option value="Težko">Težko</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="kategorije_id">Kategorija:</label></td>
                            <td>
                                <select id="kategorije_id" name="kategorije_id">
                                    <?php while ($kategorija = mysqli_fetch_assoc($kategorije)) { ?>
                                        <option value="<?php echo $kategorija["id"]; ?>"><?php echo $kategorija["ime"]; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="st_oseb">Število oseb:</label></td>
                            <td><input type="number" id="st_oseb" name="st_oseb" required></td>
                        </tr>
                        <tr>
                            <td><label for="slika">Slika:</label></td>
                            <td><input type="file" id="slika" name="slika" accept="image/*"></td>
                        </tr>
                        <tr>
                            <td>Sestavine:</td>
                            <td>
                                <div id="sestavine-polja">
                                    <div class="sestavina-vrstica">
                                        <input type="text" name="kolicina[]" placeholder="Količina" required>
                                        <input type="text" name="enota[]" placeholder="Enota" required>
                                        <input type="text" name="sestavina[]" placeholder="Sestavina" required>
                                    </div>
                                </div>
                                <button type="button" onclick="dodajSestavino()">Dodaj več</button>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="postopek">Postopek:</label></td>
                            <td><textarea id="postopek" name="postopek" required></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="send">Dodaj recept</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </td>
    </tr>
</table>
<script>
function dodajSestavino() {
    var okvir = document.getElementById("sestavine-polja");
    var vrstica = document.createElement("div");
    vrstica.className = "sestavina-vrstica";
    vrstica.innerHTML = '<input type="text" name="kolicina[]" placeholder="Količina" required> <input type="text" name="enota[]" placeholder="Enota" required> <input type="text" name="sestavina[]" placeholder="Sestavina" required>';
    okvir.appendChild(vrstica);
}
</script>
</body>
</html>
