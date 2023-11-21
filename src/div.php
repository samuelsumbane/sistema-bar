<?php
// session_start();
require_once('classCrud.php');
require_once "conexao.php";
require_once 'funcoes.php';


$p = new CrudAll;
$func = new Funcoes;
session_start();
ob_start();


?> 

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pdv</title>
    <link rel="shortcut icon" href="../icones/water_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../styles/tooltip.css">
    <link rel="stylesheet" href="../styles/amsify.select.css">
    <script src="../scripts/jquery-3.3.1.js"></script>
    <script src="../scripts/jquery.amsifyselect.js"></script>
</head>

<script>

    $(document).on("submit", "#sellForm", function(e){
        e.preventDefault();

        document.getElementById("sellProCombo").selectedIndex = 0
    });
</script>

<body>

            <form method="post" id="sellForm">
                <div id="leftPart">
                    <div id="leftPartTop">
                        
                        <select name="list" class="form-control" id="sellProCombo" searchable>
                            <option value="0">Selecionar produt</option>
                            <?php  
                                $command = $con->query("SELECT * FROM controlodestock");
                                $res = $command->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($res as $key => $value) {
                                $pro = $value["producto"];
                                $code = $value["codigo"];
                                $sr = $value["stockrestante"];
                                $ml = $value["pesoliquido"];
                                echo "<option class='$code $sr' value='$pro - $ml'>$pro - $ml</option>"; 
                                }
                                //  for($a=0;$a<3;$a++){
                                //  echo "<option value='sam$a'>$a</option>"; 
                                //  }
                            ?>
                            
                        </select>

                        <input type="submit" value="Submit">
                    </div>
                </div>                
             </form>

            </div>
        </div>
    </div> 

    <script src="../scripts/sweetalert.min.js"></script>
    <script src="../scripts/jquery.dataTables.min.js"></script>
    <!-- <script src="../scripts/crudProducts.js"></script>  -->
    <!-- <script src="../scripts/listVendas.js"></script> -->
    <!-- <script src="../scripts/listSellUser.js"></script> -->
    <!-- <script src="../scripts/script.js"></script> -->


    <script>
         document.getElementById("sellProCombo").addEventListener("change", function(){
        // alert('changed')
            var sell = document.getElementById("sellProCombo")
            // var itval = sell.value()
            // document.getElementById("leftPartTop").appendChild(`<p>l</p>`)
        })
    </script>
   
</body>



</html>
