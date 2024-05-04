<?php
include('menu.php');
include('classCrud.php');
$p = new CrudAll;
require_once 'funcoes.php';
$func = new Funcoes;
//
session_start();
ob_start();

include 'conexao.php';
if((!isset($_SESSION['id'])) && (!$_SESSION['nome'])){
  header('Location: ../index.php');
}
//
$hora = $func->retornarHora();
$data = $func->retornarData();
$diahoje = date('d');
$dadosdeVDA = $func->returnActDate();
$mesVDA = $dadosdeVDA[0];
$anoVDA = $dadosdeVDA[1];
$activityVenci = $anoVDA."-".$mesVDA."-".$diahoje;
//
$p->saveActivity("Login", "-", "-", "-", "-", $_SESSION["nome"], $data, $hora, $activityVenci);


if($_SESSION['nivel'] == 1){
  $valoresStock = $p->returnStockRestantValues();
  foreach($valoresStock as $dados){
    $producto[] = $dados['proname'];
    $stockrestante[] = $dados['amount']; 
  }
  //

  $valoresLucro = $p->returnMonthLucro(date('Y'));
  foreach($valoresLucro as $lucroData){
    $sellMonth[] = $lucroData['monthname'];
    $sellLucro[] = $lucroData['amount'];
  }

  //
  $valorProLucro = $p->returnProLucro();
  foreach($valorProLucro as $proLucroData){
    $proName[] = $proLucroData['proname'];
    $proLucro[] = $proLucroData['amount'];
  }

  $valortotallucro = $p->lucroSum();
  foreach($valortotallucro as $l){
    $lucro = $l["totallucro"];
    $lucro == null && $lucro = 0;
  }

}else{$lucro = 0;}

//

$tlucro = 0;
if(isset($_POST['yS'])){
  $yS = $_POST['yS'];
  $mS = $_POST['mS'];
  $queryChartDaily = $p->dailyChart($yS, $mS);
  foreach($queryChartDaily as $dc){
    $days[] = $dc['dayname'];
    $sells[] = $dc['amount'];
    $tlucro += $dc['amount']; 
  }
};

$lucroTotal = json_encode($lucro);

?> 
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial </title>

    <link rel="stylesheet" href="../select2.min.css">
    <link rel="stylesheet" href="../styles/submain.css">
    <link rel="stylesheet" href="../styles/dotFlashing.css">

    <script src="../scripts/chart.js"></script>


  <script>document.querySelector('.home').setAttribute('id', 'activo')</script>

</head>

<body onload="loading()">
    <div id="flashingModal">
        <div class="dotsdiv">
            <div class="snippet" data-title="dot-flashing">
                <div class="stage">
                    <div class="dot-flashing"></div>
                </div>
            </div>
        </div>

    </div>


    <div class="rightside">
      <div class="homeContent">

          <div class="fUserDiv">
            <div class="userDivPhoto" title="Minha página">
              <?php
                $data = $p->selectRecord("users", "id", $_SESSION["id"]);
                $image = $data["imagem"];
                if($image != ""){
                  echo '<img src="uploads/'.$image.'" class="" height="" style="width:100%;height:100%;object-fit:cover;border-radius:50%" />';
                }
              ?>
            </div>
            <div class="userDivName">
              <p><?= $_SESSION["nome"]?></p>
            </div>
          </div>



      <div class="totalAllDiv">
            <div class="divAllResume" >
                <div class="totalClientesDiv">
                  <h3 id="timeH"></h3>
                  <h3 id="dateH"></h3>
                </div>

                <div class="totalUsuariosDiv">
                  <h4 id="usersp">Usuários</h4>
                  <h3><?php $dados = $p->contarClientesUsuarios("users", "usuario"); ?></h3>
                </div>

                <div class="totalLucroDiv">
                  <h4 id="lucrop">Lucro</h4>
                  <h3><?= number_format($lucroTotal, 2) ?> MT</h3>
                </div>
            </div>

            <div class="userDivDateInput">
              <div class="userDiv"></div>
              <div class="dateInput">
                <label for="">Data</label><br>
                <input type="number" name="sdateinput" id="sdateinput" >
              </div>
            </div>

            </div>
          
            <div class="photoslide">
              <div id="leftdivDatesDiv">
                <div id="topDatesDiv">
                    <?php if($_SESSION['nivel'] == 1){
                      ?>
                      <form method="POST" >
                        <label>Ano</label>

                        <select name="yS" id="yearSells" style="width:20%;">
                          <option></option>
                        </select>

                        <label>Mes</label>
                                                
                        <select name="mS" id="monthSells" style="width:20%;">
                          <option></option>
                        </select>

                        <button class='hiddenButton' id="vDateCharts">Sub</button>
                      </form>
                      <?php
                    }
                    ?>
                  
                </div>
              
                <div id="bottomDatesDiv">
                <!-- <div class="graphicsOne"> -->
                  <div class="datesChart" id="chart"><canvas id="datesChart"></canvas>
                </div>
                  <script>
                      new Chart(document.getElementById("datesChart"), {
                          type: 'bar',
                          data: {
                          labels: <?php  echo json_encode($days) ?>,
                          datasets: [
                              {
                              barPercentage: 1,
                              barThickness: 18,
                              maxBarThickness: 100,
                              minBarLength: 14,
                              label: "Lucro Mensal",
                              type: "bar",
                              backgroundColor:'rgb(0, 57, 82)',
                              data: <?php  echo json_encode($sells)  ?>,
                              }
                          ]
                          },
                          options: {
                          title: {
                              display: true,
                              text: 'Lucro mensal de todos os productos'
                          },
                          legend: { display: false }
                          }
                      });
                  </script>
                </div>
              </div>


              <div id="rightdivDatesDiv"><label class="hiddentlucro">T. Lucro: <?php echo $tlucro ?> MT</label></div>

                                          
            </div>


            
            <div class="proStock">
              <div class="parentChart">
                <p>Stock</p>
                <canvas id="proStockChart"></canvas>  
              </div>

              <script>
                  var stockChart = document.getElementById('proStockChart').getContext('2d');
                  var proStockChart = new Chart(stockChart, {
                    type: 'pie',
                      data:{
                        labels: <?php echo json_encode($producto); ?>,
                          datasets: [{
                              label: '# of products',
                              data: <?php echo json_encode($stockrestante); ?>,
                              backgroundColor: [
                                  'rgba(0,0,12,.3)',
                                  'transparent', 

                                  'rgb(77, 105, 112)',
                                  'rgba(0,191,245,.5)',

                                  'rgb(3, 64, 80)',

                                  'rgba(255, 147, 97, 0.993)',

                                  'deepskyblue',
                                  'lightblue', 
                                  'rgba(0, 191, 255, 0.144)'
                              ],
                              borderWidth: 1,
                              borderColor:[
                                'white'
                              ]
                          }]
                      },
                      options: {
                        plugins: {
                          legend:{
                            display:false
                          }
                        }
                      }
                  })
                      
              </script>
            </div>


            <div class="monthValueDiv">
                <div class="graphicsOne">
                  <div class="monthlyChart" id="chart"><canvas id="myChart"></canvas></div>
                  <script>
                      new Chart(document.getElementById("myChart"), {
                          type: 'bar',
                          data: {
                          labels: <?php echo json_encode($sellMonth) ?>,
                          datasets: [
                              {
                              barPercentage: 1,
                              barThickness: 18,
                              maxBarThickness: 100,
                              minBarLength: 14,
                              label: "Lucro Mensal",
                              type: "bar",
                              backgroundColor: "#0098b3",
                              data: <?php echo json_encode($sellLucro)  ?>,
                              }
                          ]
                          },
                          options: {
                          title: {
                              display: true,
                              text: 'Lucro mensal de todos os productos'
                          },
                          legend: { display: false }
                          }
                      });
                  </script>
                </div>
            
              </div>
                

                <div class="proLucroDiv">
                <div class="parentChart">
                  <p>Lucro por producto</p>
                  <canvas id="proLucroChart"></canvas> 
                  <script>
                      var stockChart = document.getElementById('proLucroChart').getContext('2d');
                      var proStockChart = new Chart(stockChart, {
                        type: 'pie',
                          data:{
                            labels: <?php echo json_encode($proName); ?>,
                              datasets: [{
                                  label: '# of products',
                                  data: <?php echo json_encode($proLucro); ?>,
                                  backgroundColor: [
                                      'rgba(0,0,12,.3)',
                                      'rgb(0, 57, 82)',
                                      'rgb(77, 105, 112)',
                                      'rgb(3, 64, 80)',
                                      'rgb(31, 100, 100)', 
                                      'rgba(0,191,245,.5)',
                                      'deepskyblue',
                                      'lightblue', 
                                      'transparent'
                                  ],
                                  borderWidth: 1,
                                  borderColor:[
                                    'white'
                                  ]
                              }]
                          },
                          options: {
                            plugins: {
                              legend:{
                                display:false
                              }
                            }
                          }
                      })  
                  </script>
                </div>
          </div>
          </div>
    </div>

    <div id='notificationInfo'>
    <?php 
      $alldeftables = $p->selectAllRecs('definicoes');
      if($alldeftables != false){
        $lminfe = $alldeftables[0]['limiteinfe'];
        ?>
        <span id='closeNotInfo'>&times</span>

                <h4 style='color:darkred;margin-bottom:15px'>Productos em menor quantidade</h4>
                <table>
                    <thead>
                        <th>Pro</th>
                        <th>Pl</th>
                        <th>S. R.</th>
                    </thead>
                    <tbody>
                        <?php
                          $resdados = array();
                          $dados = $p->con()->query("SELECT * FROM controlodestock WHERE stockrestante <= $lminfe ");
                          $resdados = $dados->fetchAll(PDO::FETCH_ASSOC);
                          $resdadosCount = count($resdados);
                          if( $resdadosCount > 0){
                              $totalentrada = 0;
                              $totalsaida = 0;
                              for ($i=0; $i < $resdadosCount; $i++){
                                echo "<tr>";
                              
                                foreach($resdados[$i] as $k => $v){
                                  if($k != "id" and $k != "codigo" and $k !='valorcusto' and $k !='valorvenda' and $k !='totalpago' and $k !='qrcode' and $k !='vendido' and $k !='valortotal' and $k !='quantidade' and $k !='barcode'){
                                  ?><td style="width:10%;padding-left:10px;"><?php echo $v ?></td><?php
                                  } 
                                }
                              }
                          }else{
                            ?>
                            <script>
                              document.querySelector('#notificationInfo').style.opacity = '0'
                            </script>
                            <?php
                          }
                        ?>
                    </tbody>
                </table>

      <?php


      }
      
    ?>
    
        
    </div>
</body>
<script src="../scripts/jquery-3.3.1.js"></script>
<script src="../scripts/select2.min.js"></script>
<script src="../scripts/submain.js"></script>


<script src="../scripts/script.js"></script>


<script src="../scripts/dash.js"></script>


<!-- <script src="../scripts/dash.js" onload="loadSecondScript()"></script>

<script>
  function loadSecondScript() {
    var secondScript = document.createElement('script');
    secondScript.src = "../scripts/usertimeout.js";
    document.body.appendChild(secondScript);
  }
</script> -->


</html>