<?php
//$t_id = $conn->escape_string($_GET["id"]);
//include '../contents/navbar.php';
$sorokSQL = "SELECT s_id, s_elnevezes FROM Sorok";
$sorokQRY = $conn->query($sorokSQL) or die("Nem sikerült a lekérdezés");
while ($sorokROW = mysqli_fetch_assoc($sorokQRY)) {
    $sorOsszLetszam = "SELECT COUNT(`dolgozok`.`d_id`) AS db FROM `k_terulet`, `pozicio`, `dolgozok`, `Sorok` WHERE `k_terulet`.`p_id` = `pozicio`.`p_id` AND `pozicio`.`p_id`= `dolgozok`.`p_id` AND `k_terulet`.`s_id` = `Sorok`.`s_id` AND `Sorok`.`s_id` = ".$sorokROW["s_id"];
    $qrySOL = $conn->query($sorOsszLetszam) or die("Nem sikerült a sor db lekérdezés");
    $SorDBEredmeny = $qrySOL->fetch_row();
?>

    <div class="container">
        <div class="accordion bg-dark" id="acc<?php echo $sorokROW['s_id']; ?>">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn  btn-block text-left" type="button" data-toggle="collapse" data-target="#sor<?php echo $sorokROW['s_id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $sorokROW["s_elnevezes"];?>                              
                            <t></t>    
                            <span class="p-2 badge badge-secondary">Létszám: <?php echo $SorDBEredmeny[0];?> fő</span>
                        </button>
                    </h2>
                </div>

                <div id="sor<?php echo $sorokROW['s_id']; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#acc<?php echo $sorokROW['s_id']; ?>">
                    <div class="card card-body">
                        <?php include 'temp.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php } ?>