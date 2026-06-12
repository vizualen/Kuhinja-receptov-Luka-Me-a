<?php
session_start();
include "povezava.php";

if (!isset($_SESSION["vloga"]) || $_SESSION["vloga"] != "admin") {
    header("Location: prijava.php");
    exit;
}

$id = (int)$_GET["id"];
$kategorije = mysqli_query($povezava, "SELECT * FROM kategorije ORDER BY ime");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = mysqli_real_escape_string($povezava, $_POST["ime"]);
    $postopek = mysqli_real_escape_string($povezava, $_POST["postopek"]);
    $casPriprave = (int)$_POST["cas_priprave"];
    $zahtevnost = mysqli_real_escape_string($povezava, $_POST["zahtevnost"]);
    $kategorijeId = (int)$_POST["kategorije_id"];
    $stOseb = (int)$_POST["st_oseb"];

    $sql = "
        UPDATE recepti SET
        ime = '$ime',
        postopek = '$postopek',
        cas_priprave = $casPriprave,
        zahtevnost = '$zahtevnost',
        kategorije_id = $kategorijeId,
        st_oseb = $stOseb
        WHERE id = $id
    ";
    mysqli_query($povezava, $sql);

    if (isset($_FILES["slika"]) && $_FILES["slika"]["name"] != "") {
        $imeSlike = basename($_FILES["slika"]["name"]);
        $potSlike = "slike/" . $imeSlike;
        move_uploaded_file($_FILES["slika"]["tmp_name"], $potSlike);
        $imeSlikeDb = mysqli_real_escape_string($povezava, $potSlike);

        $preveri = mysqli_query($povezava, "SELECT id FROM slike WHERE recepti_id = $id");
        if (mysqli_num_rows($preveri) > 0) {
            mysqli_query($povezava, "UPDATE slike SET ime = '$ime', url = '$imeSlikeDb' WHERE recepti_id = $id");
        } else {
            mysqli_query($povezava, "INSERT INTO slike (ime, url, recepti_id) VALUES ('$ime', '$imeSlikeDb', $id)");
        }
    }

    header("Location: recept.php?id=$id");
    exit;
}

$rezultat = mysqli_query($povezava, "SELECT * FROM recepti WHERE id = $id");
$recept = mysqli_fetch_assoc($rezultat);
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Uredi recept</title>
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
        <td class="prijava-stran" colspan="3">
            <div class="dodaj-okvir">
                <h2>Uredi recept</h2>
                <form method="post" enctype="multipart/form-data">
                    <table class="dodaj-tabela">
                        <tr>
                            <td>Ime recepta:</td>
                            <td><input type="text" name="ime" value="<?php echo $recept["ime"]; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Čas priprave:</td>
                            <td><input type="number" name="cas_priprave" value="<?php echo $recept["cas_priprave"]; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Zahtevnost:</td>
                            <td>
                                <select name="zahtevnost">
                                    <option value="Lahko">Lahko</option>
                                    <option value="Srednje">Srednje</option>
                                    <option value="Težko">Težko</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kategorija:</td>
                            <td>
                                <select name="kategorije_id">
                                    <?php while ($kategorija = mysqli_fetch_assoc($kategorije)) { ?>
                                        <option value="<?php echo $kategorija["id"]; ?>"><?php echo $kategorija["ime"]; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Število oseb:</td>
                            <td><input type="number" name="st_oseb" value="<?php echo $recept["st_oseb"]; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Nova slika:</td>
                            <td><input type="file" name="slika" accept="image/*"></td>
                        </tr>
                        <tr>
                            <td>Postopek:</td>
                            <td><textarea name="postopek" required><?php echo $recept["postopek"]; ?></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit">Shrani spremembe</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
