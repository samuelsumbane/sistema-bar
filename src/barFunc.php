<?php
require_once("classCrud.php");
include 'phpfuncoes.php';

class Bar extends CrudAll{

    function retornarHora(){date_default_timezone_set('Africa/Maputo');$hora = date('H:i');return $hora;}
    function retornarData(){$data = date('Y-m-d');return $data;}

    function vencimentodaactividade(){
        $dataPamericano = date('Y-m-d');
        $mesatual = date('m');
        $anoatual = date('Y') + 1;
        $dadosdevencimento = array($mesatual, $anoatual);
        return $dadosdevencimento;
    }   

    function venciDate(){
        $diahoje = date('d');
        $dadosdeVDA = $this->vencimentodaactividade();
        $mesVDA = $dadosdeVDA[0];
        $anoVDA = $dadosdeVDA[1];
        $datadevencimento = $anoVDA."-".$mesVDA."-".$diahoje;
        return $datadevencimento;
    }
   

    function returnComplenteMonth($date){
        $mes = array(
            "01"=>"Janeiro",
            "02"=>"Fevereiro",
            "03"=>"Março",
            "04"=>"Abril",
            "05"=>"Maio",
            "06"=>"Junho",
            "07"=>"Julho",
            "08"=>"Agosto",
            "09"=>"Setembro",
            "10"=>"Outubro",
            "11"=>"Novembro",
            "12"=>"Dezembro"
        );
        return $mes[$date];
    }


    public function randomCode(){$fiveDigits = rand(100000, 999999);return $fiveDigits;}
    // public function importQuery(){$ano = $_POST["ano"];$q = $this->exportSDataQuery($ano);echo json_encode($q);}

    // public function getPro(){
    //     if($_POST['proId']){
    //         $row = array();
    //         $code = addslashes($_POST["proId"]);
    //         $row = $this->selectRecord("productos", "codigo", $code); 
    //         echo json_encode($row);
    //     }
    // }

    public function getStock(){
        if($_POST['stockCode']){
            $row = array();
            $id = addslashes($_POST["stockCode"]);
            $row = $this->selectRecord("controlodestock", "codigo", $_POST["stockCode"]); 
            echo json_encode($row);
        }
    }


    // public function updatePro(){
    //     if($_POST['proId']){
    //         $valorCusto = addslashes($_POST["valorCusto"]);
    //         $valorVenda = addslashes($_POST["valorVenda"]);
    //         $code = addslashes($_POST["proId"]);
    //         $this->atualizarProMin($valorCusto, $valorVenda, $code);
    //     }
    // }

    public function delStock(){
        if($_POST["stockCode"]){
            $codigo = addslashes($_POST["stockCode"]);
            $this->delRec("controlodestock", "codigo", $codigo);
            $this->delRec("productos", "codigo", $codigo);
        }
    }

    public function returnProCode(){
        $fiveDigits = rand(10000, 99999);
        //
        $dadoscodigo = $this->selectRecord('productos', 'codigo', $fiveDigits);
        if($dadoscodigo != false){
            while ($dadoscodigo['codigo'] == $fiveDigits){
                $fiveDigits = rand(10000, 99999);
            }
            echo json_encode($fiveDigits);
        }else{
            echo json_encode($fiveDigits);
        }
    }


    public function productData(){
        if($_POST["codeStock"]){
            $codeStock = $_POST["codeStock"];
            $sr = $this->selectRecord("controlodestock", "barcode", $codeStock);
            if($sr != false || $sr != null){
                $rs = $this->selectRecord("controlodestock", "barcode", $codeStock);
            }else{
                $rs = $this->selectRecord("controlodestock", "codigo", $codeStock);
            }
           
            $promo = $this->selectRecord("promocoes", "barcode", $codeStock);
            if($promo != false || $promo != null){
                $promoValues = $promo;
            }else{
                $promoValues = $this->selectRecord("promocoes", "codigo", $codeStock);

            }
            
            $data = [$rs, $promoValues];

            echo json_encode($data);
        }
    }

    public function verifyStockProduct(){
        if($_POST["itemSelecionado"]){
            $valor = $_POST["itemSelecionado"];
            $results = $this->selectRecord("controlodestock", "producto", $valor);
            echo json_encode($results);
        }
    }

 
    public function sellProducts(){
        $codetd = $_POST["codetd"];
        $produto = $_POST["pronametd"];
        $pesoliquido = $_POST["pltd"];
        $quantidade = $_POST["qtdtd"];
        $valorcusto = $_POST["vctd"];
        $valorunico = $_POST["vvtd"];
        $valortotal = $_POST["totaltd"];
        $desconto = $_POST["dctd"];
        $usernamelogged = $_POST["usernamelogged"];
        $lucro = ($valorunico - $valorcusto) * $quantidade;
        $currentMonthStr = $this->returnComplenteMonth(date('m'));
        $currentYear = date('Y');

        $this->saveActivity("Venda", $produto, $pesoliquido, $quantidade, $valortotal, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
        $this->gravarVendas($produto, $pesoliquido, $quantidade, $valorcusto, $valorunico, $valortotal, $desconto, $lucro, $currentMonthStr, $currentYear);
        $this->increaseStock($quantidade, $quantidade, $codetd);
        makeDBBackup();

    }

    public function addStockProducts(){
        $produto = $_POST["pronametd"];
        $pl = $_POST["pltd"];
        $qtd = $_POST["qtdtd"];
        $vcutd = $_POST["vcutd"];
        $vvutd = $_POST["vvutd"];
        $tpptd = $_POST["tpptd"];
        $stockrestante = $_POST["stockr"];
        $usernamelogged = $_POST["usernamelogged"];
        $barCode = $_POST["barCodetd"];
        //
        $codigoRandomizado = $this->randomCode();

        if($barCode != "" || $barCode != null){
            $dadoscodigo = $this->selectRecord('controlodestock', 'codigo', $codigoRandomizado);
            if($dadoscodigo != false){
                while ($dadoscodigo['codigo'] == $codigoRandomizado){
                    $codigoRandomizado = $this->randomCode();
                }$this->gravarStock($codigoRandomizado, $produto, $pl, $qtd, $vcutd, $vvutd, $tpptd, $stockrestante, $barCode, 0);
            //
                $this->saveActivity("Stock", $produto, $pl, $qtd, $tpptd, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
            }
            else{$this->gravarStock($codigoRandomizado, $produto, $pl, $qtd, $vcutd, $vvutd, $tpptd, $stockrestante, $barCode, 0);
            //
            $this->saveActivity("Stock", $produto, $pl, $qtd, $tpptd, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
            }        
        }else{
            $dadoscodigo = $this->selectRecord('controlodestock', 'codigo', $codigoRandomizado);
            if($dadoscodigo != false){
                while ($dadoscodigo['codigo'] == $codigoRandomizado){
                    $codigoRandomizado = $this->randomCode();
            }$this->gravarStock($codigoRandomizado, $produto, $pl, $qtd, $vcutd, $vvutd, $tpptd, $stockrestante, $codigoRandomizado, 0);}
            else{$this->gravarStock($codigoRandomizado, $produto, $pl, $qtd, $vcutd, $vvutd, $tpptd, $stockrestante, $codigoRandomizado, 0);}        
            // $this->gravarProducto($codigoRandomizado, $produto, $pl, $vcutd, $vvutd, $barCode);
            $this->saveActivity("Stock", $produto, $pl, $qtd, $tpptd, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
        }
        makeDBBackup();

    }

    function updateStock(){
        if($_POST["stockCode"]){
            $produto = $_POST["pronametd"];
            $codigo = $_POST["stockCode"];
            $pl = $_POST["pltd"];
            $qtd = $_POST["qtdtd"];
            $vcu = $_POST["vcutd"];
            $vvu = $_POST["vvutd"];
            $stockrestante = $_POST["stockr"];
            $tp = $_POST["tpptd"];
            $usernamelogged = $_POST["usernamelogged"];
            $barCode = $_POST["barCodetd"];

            if($barCode == "" || $barCode == null){
                $query = $this->selectRecord("controlodestock", "codigo", $codigo);
                $newBC = $query["barcode"];
                if($newBC == "" || $newBC == false){
                    $this->actualizarStock($produto, $pl, $qtd, $vcu, $vvu, $tp, $stockrestante, null, $codigo);
                    $this->saveActivity("Stock", $produto, $pl, $qtd, $tp, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
                }else{
                    $this->actualizarStock($produto, $pl, $qtd, $vcu, $vvu, $tp, $stockrestante, $newBC, $codigo);
                    $this->saveActivity("Stock", $produto, $pl, $qtd, $tp, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
                }
                
            }else{
                $this->actualizarStock($produto, $pl, $qtd, $vcu, $vvu, $tp, $stockrestante, $barCode, $codigo);
                // $this->atualizarProducto($produto, $pl, $vcu, $vvu, $barCode, $codigo);
                $this->saveActivity("Stock", $produto, $pl, $qtd, $tp, $usernamelogged, $this->retornarData(), $this->retornarHora(), $this->venciDate());
            }
            makeDBBackup();

        }
     
    }

    function verifyA(){
        if($_POST["dateprintbegin"]){
            $seletedDatebegin = $_POST["dateprintbegin"];
            $seletedDatefinal = $_POST["dateprintfinal"];
            $recs = $this->selectActiRec($seletedDatebegin, $seletedDatefinal);
            echo json_encode($recs);
        }
    }

    function addpromo(){
        if($_POST["proName"]){
            $proname = $_POST["proName"];
            $nGarafas = $_POST["nGarafas"];
            $vPromo = $_POST["valorPromo"];
            $proCode = $_POST["proCode"];
            $pl = $_POST["plPro"];
            $barcode = $_POST["barcodeinput"];
            $this->createPromo($proname, $proCode, $nGarafas, $vPromo, $pl, $barcode);
            makeDBBackup();
        }
    }

    function delPromo(){
        if($_POST["promoCode"]){
            $id = addslashes($_POST["promoCode"]);
            $this->delRec("promocoes", "id", $id);
        }
    }

    function selectPromo(){
        if($_POST["promoCode"]){
            $codigo = addslashes($_POST["promoCode"]);
            $digitedV = addslashes($_POST['vDig']);
            $row = $this->selectRecord2("promocoes", 'codigo', $codigo, 'nprodutos', $digitedV);
            echo json_encode($row);
        }
    }

    function returnDatesChart(){
        if($_POST['fDateChart']){
            $firstdate = $_POST['fDateChart'];
            $seconddate = $_POST['lDateChart'];
            $query = $this->dailyChart($firstdate, $seconddate);
            echo json_encode($query);
        }
    }

    function selectAllProCards(){
        $res = $this->selectAllRecs("productos");
        echo json_encode($res);
    }

    function selectAllStockCards(){
        $res = $this->selectAllRecs("controlodestock");
        echo json_encode($res);
    }


    function selectallrecords($table){
        $res = $this->selectAllRecs($table);
        echo json_encode($res);
    }

    function selectremessadocs(){
        $response = array();
        $q = $this->con()->query("SELECT * FROM remessarecs GROUP BY id");
        $response = $q->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($response);
    }

    function selectremrecs(){
        $id = $_POST['rangedid'];
        $response = $this->selectRecords('remessarecs', 'id', $id);
        echo json_encode($response);
    }

    function filterPro(){
        if($_POST['searchValue']){
            $searchValue = addslashes($_POST['searchValue']);
            $response = $this->selectRecordLike('productos', 'marca', $searchValue);
            echo json_encode($response);
        }
    }

    function filterStock(){
        if($_POST['searchValue']){
            $searchValue = addslashes($_POST['searchValue']);
            $response = $this->selectRecordLike('controlodestock', 'producto', $searchValue);
            echo json_encode($response);
        }
    }

    function filter($table, $value){
        if($_POST['searchValue']){
            $seachValue = addslashes(($_POST['searchValue']));
            $res = $this->selectRecordLike($table, $value, $seachValue);
            echo json_encode($res);
        }
    }

    function saveLimiteInfe(){
        $vstockdef = addslashes($_POST['vstockdef']);
        $res = $this->selectAllRecs('definicoes');
        $allrecsnum = count($res);
        if ($allrecsnum == 0){
            $this->saveDef($vstockdef);
        }else{
            $this->updateDef($vstockdef, 1);
        }
    }


    function saveremessarecs(){
        if($_POST['produto']){
            $idrec = $_POST['id'];
            $pro = $_POST['produto'];
            $pl = $_POST['pesoliquido'];
            $qtd = $_POST['quantidade'];
            $user = $_POST['username'];
            $hora = $this->retornarHora();
            $dia = date('d/m/Y');

            $this->saveremessadoc($idrec, $pro, $pl, $qtd, $user, $dia, $hora);
            // $saveremessadoc = array($idrec, $pro, $pl, $qtd, $user, $dia, $hora);
            // echo json_encode($saveremessadoc);
        }
    }

    function selectSells($column){
        $cmd = $this->con()->prepare("select $column from controlodevendas group by $column");
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);

    }

    function selectSellsBy(){
        $value = $_POST["value"];
        $cmd = $this->con()->prepare("select mes from controlodevendas where ano = $value group by mes ");
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
    }

}
