<?php 
    include "../1_Include/panel.php";
    include "../1_Include/config.php";
    include "../2_Control/exp.php";
?>

<body>

  

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Risposta esatta</h5>

                </div>
                <div class="modal-body" id="modalB">

                </div>

            </div>
        </div>
    </div>

    <div class="container" style="padding-top: 3%;">
        <div class="row align-items-start justify-content-end">
            <div class="col-3">
                <div style="border:solid;">
                    Punteggio <?= $punteggio ?><br />
                    Esatte <?= $esatte ?><br />
                    Errate <?= $errate ?><br />
                    Nulle <?= $nulle ?><br />
                </div>
            </div>
            <div class="col-9">
                <table class=" table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Codice</th>
                            <th scope="col">id Domanda</th>
                            <th scope="col">Domanda</th>
                            <th scope="col">Risposta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                        ?>

                                <tr>
                                    <th scope="row"><?= $row["Codice"] ?></th>
                                    <td><?= $row["idDomanda"] ?></td>
                                    <td><?= $row["Domanda"] ?></td>
                                    <td>
                                        <?php if ($array_ex[$row["idDomanda"]] == $row["Risposta"]) {
                                            $risp = $row["Risposta"];

                                            echo "<div style='background: #0dd800b5;'> $risp  </div>";
                                        } else {
                                            $idd = $row["idDomanda"];
                                            $risp_ex = $array_ex[$row["idDomanda"]];
                                            $risp = $row["Risposta"];
                                            $func = 'err("$idd","' . addslashes($risp_ex) . '")';
                                            echo "<button  onclick='" . $func . "' style='background: #ff0000b5;' data-toggle='modal' data-target='#exampleModal'> $risp  </button>";
                                        }
                                        ?>
                                    </td>
                                </tr>



                        <?php
                            }
                        } else {
                            header('Location: ./errorEmpty.php'); ;
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-12">

                <h2> Risposte nulle (non date)</h2>
            </div>
            <div class="col-9">
                <table class=" table table-bordered">
                    <thead>
                        <tr>

                            <th scope="col">id Domanda</th>
                            <th scope="col">Domanda</th>
                            <th scope="col">Risposta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_n->num_rows > 0) {
                            // output data of each row
                            while ($row = $result_n->fetch_assoc()) {
                        ?>

                                <tr>

                                    <td><?= $row["idDomanda"] ?></td>
                                    <td><?= $row["Domanda"] ?></td>
                                    <td>
                                        <?php
                                        $risp = $row["Risposta"];

                                        echo "<div style='background: #ffeb00b5;'> $risp  </div>";

                                        ?>
                                    </td>
                                </tr>



                        <?php
                            }
                        } else {
                            echo "0 results";
                        }

                        //$conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function err(id, risp) {
        $('#modal').modal('show');
        $('#modalB').html(risp);
    }
</script>

</html>