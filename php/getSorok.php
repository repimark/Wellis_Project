<?php
//$t_id = $conn->escape_string($_GET["id"]);
//include '../contents/navbar.php';
$sorokSQL = "SELECT s_id, s_elnevezes FROM Sorok";
$sorokQRY = $conn->query($sorokSQL) or die("Nem sikerült a lekérdezés");
while ($sorokROW = mysqli_fetch_assoc($sorokQRY)) {
?>

    <div class="container">
        <div class="accordion bg-dark" id="acc<?php echo $sorokROW['s_id']; ?>">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn  btn-block text-left" type="button" data-toggle="collapse" data-target="#sor<?php echo $sorokROW['s_id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $sorokROW["s_elnevezes"]; ?>
                        </button>
                    </h2>
                </div>

                <div id="sor<?php echo $sorokROW['s_id']; ?>" class="collapse " aria-labelledby="headingOne" data-parent="#acc<?php echo $sorokROW['s_id']; ?>">
                    <div class="card card-body">
                        <?php include 'temp.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>