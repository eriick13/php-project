<!DOCTYPE html>
<!--
Toto je testovací projekt, je zde využito PHP, HTML, SQL, BOOTSTRAP
a trošku javascriptu.
Vytvořeno 2020/7.
@Databáze - test ver 1.0
@Zavadil Erik
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script type="text/javascript">     
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ( (charCode > 31 && charCode < 48) || charCode > 57) {
                    return false;
                }
                return true;
            }            
        </script>
        <title>Databáze - test</title>
    </head>
    <body>
        <?php require_once 'process.php'; ?>
        
        <div class="container-sm p-3 my-3 border bg-dark text-white">            
            <div class="row justify-content-center">
                <h1>Databáze - test</h1>
            </div>          
        </div>        
        <?php        
        if (isset($_SESSION['message'])): ?>
        
        <div class="alert alert-<?=$_SESSION['msg_type']?>">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>        
        </div>
        <?php endif ?>        
        <div class="container">
            <?php
            $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));
            $vypis = $mysqli->query("SELECT * FROM data INNER JOIN kategorie_table ON data.kategorie_id=kategorie_table.kat_id;") or die($mysqli->error);
            ?>

            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Název</th>
                            <th>Kategorie</th>
                            <th>Cena</th>
                            <th colspan="2">Akce</th>
                        </tr>
                    </thead>
                    <?php while ($row = $vypis->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['nazev']; ?></td>
                            <td><a href="<?php echo str_replace(' ', '', $row['kategorie']); ?>.php"><?php echo $row['kategorie']; ?></a></td>
                            <td><?php echo $row['cena']; ?> Kč</td>
                            <td>
                                <a href="index.php?edit=<?php echo $row['id']; ?>"
                                   class="btn btn-info">Upravit</a>
                                <a href="process.php?delete=<?php echo $row['id']; ?>"
                                   class="btn btn-danger">Vymazat</a>
                                <a href="product.php?id=<?php echo $row['id']; ?>"
                                   class="btn btn-secondary">Detail</a>                                
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <div class="row justify-content-center">
                <form action="process.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label>Název produktu</label>
                        <input type="text" name="nazev" class="form-control" 
                               value="<?php echo $nazev; ?>" placeholder="Vložte název">
                    </div>
                    <div class="form-group">
                        <label>Kategorie</label>
                        <select class="form-control" name="kategorie">
                            <?php
                            $dotaz = $mysqli->query("SELECT kategorie FROM kategorie_table") or
                                    die($mysqli->error);                            
                            ?>
                            <?php while($kategorie = mysqli_fetch_array($dotaz)):?> //$editSelect = true;
                            <option value="<?php echo $kategorie[0];?>"><?php echo $kategorie[0];?></option>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Popis produktu</label>
                        <textarea class="form-control" rows="8" cols="50" 
                                  type="text" name="popis" 
                                  placeholder="Vložte popis"><?php echo $popis; ?></textarea>                    
                    </div>
                    <div class="form-group">
                        <label>Cena (v Kč)</label>
                        <input type="number" name="cena" class="form-control" max="500000"
                               onkeypress="return isNumber(event);" onpaste="return false;"
                               value="<?php echo $cena; ?>" placeholder="Vložte cenu">
                    </div>                    
                    <div class="form-group">
                        <?php 
                        if($update == true):
                        ?>
                            <button type="submit" class="btn btn-info" name="update">Aktualizuj</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary" name="ulozit">Uložit</button>
                        <?php endif;                         
                        ?>                            
                    </div>
                </form>
            </div>  
        </div>        
    </body>
</html>
