<?php
session_start();
include "povezava.php";

$napaka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($povezava, $_POST["email"]);
    $geslo = $_POST["geslo"];

    $sql = "SELECT * FROM uporabniki WHERE email = '$email'";
    $rezultat = mysqli_query($povezava, $sql);
    $uporabnik = mysqli_fetch_assoc($rezultat);

    if ($uporabnik && (password_verify($geslo, $uporabnik["geslo"]) || $geslo == $uporabnik["geslo"])) {
        $_SESSION["uporabnik_id"] = $uporabnik["id"];
        $_SESSION["email"] = $uporabnik["email"];
        $_SESSION["vloga"] = $uporabnik["vloga"];

        if (isset($_GET["naprej"])) {
            header("Location: " . $_GET["naprej"]);
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $napaka = "Email ali geslo ni pravilno.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>Prijava</title>
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
        <td class="prijava-stran" colspan="3">
            <div class="prijava-okvir">
                <h2>Prijava</h2>

                <?php if ($napaka != "") { ?>
                    <p class="prijava-sporocilo"><?php echo $napaka; ?></p>
                <?php } ?>

                <form method="post">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="geslo">Geslo:</label>
                    <input type="password" id="geslo" name="geslo" required>

                    <button type="submit">Prijavi se</button>
                </form>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
