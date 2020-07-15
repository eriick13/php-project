<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>Detail Produktu</title>
    </head>
    <body>        
        <?php require_once 'process.php'; ?> 
        <div class="container-sm p-3 my-3 border bg-dark text-white">
            <?php
            $id = $_GET['id'];
            $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));
            $vypis = $mysqli->query("SELECT * FROM data RIGHT JOIN kategorie_table ON data.kategorie_id=kategorie_table.kat_id WHERE id=$id") or
                    die($mysqli->error);

            $detail = $vypis->fetch_assoc();
            ?>
            <div class="row justify-content-center">
                <h1>Detail Produktu</h1>
            </div>
            <div class="card bg-secondary text-white">                    
                <div class="card-body">
                    <h4 class="card-title"><?php echo $detail['nazev']; ?></h4>
                    <h5 class="card-title"><a href="<?php echo str_replace(' ', '', $detail['kategorie']); ?>.php" class="text-white"><?php echo $detail['kategorie']; ?></a></h5>                        
                    <p class="card-text"><?php echo $detail['popis']; ?></p>

                    <p class="text-right">Cena: <?php echo $detail['cena']; ?> Kč</p>
                </div>
            </div>

            <a href="index.php" class="btn btn-primary btn-block"><- Zpět</a>
        </div>        
    </body>
</html>