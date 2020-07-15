<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$nazev = '';
$kategorie = '';
$kategorieValue = '';
$kategorieId = '';
$kategorieIdFinal = '';
$kategorieOption = '';
$popis = '';
$cena = '';

error_reporting(0);
$kategorieValue = $_POST['kategorie'];
$kategorieId = $mysqli->query("SELECT kat_id FROM kategorie_table WHERE kategorie= '$kategorieValue'") or
                            die($mysqli->error);
$kategorieId = mysqli_fetch_array($kategorieId);
$kategorieIdFinal = $kategorieId[0];
error_reporting(1);

if (isset($_POST['ulozit'])) {
    $nazev = $_POST['nazev'];    
    $popis = $_POST['popis'];
    $cena = $_POST['cena'];   
    
    
    $mysqli->query("INSERT INTO data (nazev, kategorie_id, popis, cena) VALUES('$nazev','$kategorieIdFinal','$popis','$cena')") or
            die($mysqli->error);    
  

    $_SESSION['message'] = "Uloženo!";
    $_SESSION['msg_type'] = "success";
    
    header("location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or
            die($mysqli->error);

    $_SESSION['message'] = "Záznam byl vymazán!";
    $_SESSION['msg_type'] = "danger";
    
    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $vypis = $mysqli->query("SELECT * FROM data RIGHT JOIN kategorie_table ON data.kategorie_id=kategorie_table.kat_id WHERE id=$id;") or
            die($mysqli->error);
    if ($vypis->num_rows){
        $row = $vypis->fetch_array();
        $nazev = $row['nazev'];
        $popis = $row['popis'];
        $cena = $row['cena'];        
        $kategorieOption = $row['kategorie'];
        $editSelect = true;
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nazev = $_POST['nazev'];
    $popis = $_POST['popis'];
    $cena = $_POST['cena'];
    
    $mysqli->query("UPDATE data SET nazev='$nazev', kategorie_id='$kategorieIdFinal', popis='$popis', cena='$cena' WHERE id=$id") or
            die($mysqli->error);
    
    $_SESSION['message'] = "Záznam byl aktualizován!";
    $_SESSION['msg_type'] = "warning";
    
    header("location: index.php");
}