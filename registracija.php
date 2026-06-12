<?php
session_start();
include "povezava.php";

$sporocilo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = mysqli_real_escape_string($povezava, $_POST["ime"]);
    $priimek = mysqli_real_escape_string($povezava, $_POST["priimek"]);
    $email = mysqli_real_escape_string($povezava, $_POST["email"]);
    $geslo = $_POST["geslo"];
    $geslo2 = $_POST["geslo2"];

    if ($geslo != $geslo2) {
        $sporocilo = "Gesli nista enaki.";
    } else {
        $preveri = mysqli_query($povezava, "SELECT id FROM uporabniki WHERE email = '$email'");

        if (mysqli_num_rows($preveri) > 0) {
            $sporocilo = "Ta email je že registriran.";
        } else {
            $gesloHash = password_hash($geslo, PASSWORD_DEFAULT);
            $sql = "
                INSERT INTO uporabniki (ime, priimek, email, geslo, datum_registracije)
                VALUES ('$ime', '$priimek', '$email', '$gesloHash', NOW())
            ";
            mysqli_query($povezava, $sql);
            $sporocilo = "Registracija je uspela. Zdaj se lahko prijavite.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Registracija</title>
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
            <a href="prijava.php">Prijava</a>
            <a href="registracija.php">Registracija</a>
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
            <div class="prijava-okvir">
                <h2>Registracija</h2>

                <?php if ($sporocilo != "") { ?>
                    <p class="prijava-sporocilo"><?php echo $sporocilo; ?></p>
                <?php } ?>

                <form method="post">
                    <label for="ime">Ime:</label>
                    <input type="text" id="ime" name="ime" required>

                    <label for="priimek">Priimek:</label>
                    <input type="text" id="priimek" name="priimek" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="geslo">Geslo:</label>
                    <input type="password" id="geslo" name="geslo" required>

                    <label for="geslo2">Ponovi geslo:</label>
                    <input type="password" id="geslo2" name="geslo2" required>

                    <button type="submit">Registriraj se</button>
                </form>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
