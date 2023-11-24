<?php

class CrudAll{
  private $pdo;

  public function __construct(){

        try{  

            $minpath =  $_SERVER['DOCUMENT_ROOT'];
            $path = "$minpath/bar/src";
            $this->pdo = new PDO("sqlite:$path/barBank.sqlite");

            $cmusers = $this->pdo->prepare("CREATE TABLE if not exists users(id integer primary key not null, nome varchar(20), usuario varchar(20), senha varchar (30), nivel int(10), imagem text(30))");
            $cmusers->execute();

            $cmdv = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS controlodevendas(id integer primary key not null, producto varchar(20), pesoliquido int(10), quantidade int(10), valorcusto int(10), valorunico int(10), valortotal int(10), lucro int(10), desconto int(10), mes varchar(10), ano int(4))");
            $cmdv->execute();

            $cmds = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS controlodestock(id integer primary key not null, codigo int(10), producto varchar(20), pesoliquido int(10), quantidade int(10), valorcusto int(10), valorvenda int(10), totalpago int(15), stockrestante int(20), vendido int(15))");
            $cmds->execute();

            $cmdact = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS activities(id integer primary key not null, accao varchar(50), producto varchar(20), pesoliquido int(10), quantidade int(10), totalpago int(15), usuario varchar(20), dia varchar(15), hora varchar(10), validade varchar(30) )");
            $cmdact->execute();

            $cmdpromo = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS promocoes(id integer primary key not null, produto varchar(50), codigo int(20), nprodutos int(50), vpromo int(20), pesoliquido varchar(10)) ");
            $cmdpromo->execute();

            $def = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS definicoes(id integer primary key not null, limiteinfe int(10)) ");
            $def->execute();

            $rem = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS  remessarecs(id int(20), produto varchar(20), pesoliquido varchar(10), quantidade int(10), usuario varchar(40), dia varchar(10), hora varchar(10) )");
            $rem->execute();

            try {
              $cmdimg = $this->pdo->prepare("SELECT barcode FROM controlodestock");
              $cmdimg->execute();
            } catch (\Throwable $th) {
                $cmdimg = $this->pdo->prepare("ALTER TABLE controlodestock ADD COLUMN barcode varchar(12)");
                $cmdimg->execute();
            }

            try {
              $cmdimg = $this->pdo->prepare("SELECT desconto FROM controlodevendas");
              $cmdimg->execute();
            } catch (\Throwable $th) {
                $cmdimg = $this->pdo->prepare("ALTER TABLE controlodevendas ADD COLUMN desconto int(10)");
                $cmdimg->execute();
            }

            try {
              $cmdimg = $this->pdo->prepare("SELECT barcode FROM promocoes");
              $cmdimg->execute();
            } catch (\Throwable $th) {
                $cmdimg = $this->pdo->prepare("ALTER TABLE promocoes ADD COLUMN barcode varchar(12)");
                $cmdimg->execute();
            }

            // try {
            //   $cmdimg = $this->pdo->prepare("SELECT lucro FROM activities");
            //   $cmdimg->execute();
            // } catch (\Throwable $th) {
            //     $cmdimg = $this->pdo->prepare("ALTER TABLE activities ADD COLUMN lucro int(10)");
            //     $cmdimg->execute();
            // }

        }catch(PDOException $e){echo "Erro com banco de dados ".$e->getMessage();}
    }

    function con(){$conn = new PDO('sqlite:barBank.sqlite');return $conn;}

    public function buscarDadosPorUsuario($table, $usuario){
      $res = array();
      $cmd = $this->pdo->prepare("SELECT * FROM $table where usuario = :u");
      $cmd->bindValue(":u",$usuario);
      $cmd->execute();
      $res = $cmd->fetch(PDO::FETCH_ASSOC);
      return $res;
    }


    function gravarCliente($nome, $codigo, $telefone, $endereco){
      $cmd = $this->pdo->prepare("INSERT INTO clientes (nome, codigo, telefone, endereco)
      VALUES(:nome, :codigo, :telefone, :endereco)");
      $cmd->bindValue(':nome',$nome);
      $cmd->bindValue(':codigo',$codigo);
      $cmd->bindValue(':telefone', $telefone);
      $cmd->bindValue(':endereco', $endereco);
      $cmd->execute();
    }
    
    public function atualizarCliente($nome, $codigo, $telefone, $endereco){
      $cmd = $this->pdo->prepare("UPDATE clientes SET  nome = :nome, telefone = :tel, endereco = :endereco WHERE codigo = :codigo");
      $cmd->bindValue(":nome", $nome);
      $cmd->bindValue(":tel", $telefone);
      $cmd->bindValue(":endereco", $endereco);
      $cmd->bindValue(":codigo", $codigo);
      $cmd->execute();
    }

    public function selectRecords($table, $row, $value){$res = array();$cmd = $this->pdo->prepare("SELECT * FROM $table WHERE $row = :valor");$cmd->bindValue(":valor",$value);$cmd->execute();$res = $cmd->fetchAll(PDO::FETCH_ASSOC);return $res;}

    public function selectRecord($table, $row, $value){$res = array();$cmd = $this->pdo->prepare("SELECT * FROM $table WHERE $row = :valor");$cmd->bindValue(":valor",$value);$cmd->execute();$res = $cmd->fetch(PDO::FETCH_ASSOC);return $res;}

    public function selectRecordLike($table, $row, $value){$res = array();$cmd = $this->pdo->prepare("SELECT * FROM $table WHERE $row LIKE ? ");$params = array("%$value%");$cmd->execute($params);$res = $cmd->fetchAll(PDO::FETCH_ASSOC);return $res;}

    public function selectRecord2($table, $row1, $value1, $row2, $value2){
      $res = array();
      $cmd = $this->pdo->prepare("SELECT * FROM $table WHERE $row1 = :valor1 and $row2 = :valor2 LIMIT 1");
      $cmd->bindValue(":valor1",$value1);
      $cmd->bindValue(":valor2",$value2);
      $cmd->execute();
      $res = $cmd->fetch(PDO::FETCH_ASSOC);
      return $res;
    }

    function actualizarUser($id, $nome, $user, $senha, $nivel){
      $cmd = $this->pdo->prepare("UPDATE users SET nome = :nome, usuario = :usuario, senha = :senha, nivel = :nivel WHERE id = :id");
      $cmd->bindValue(":nome", $nome);
      $cmd->bindValue(":usuario", $user);
      $cmd->bindValue(":senha", $senha);
      $cmd->bindValue(":nivel", $nivel);
      $cmd->bindValue(":id", $id);
      $cmd->execute();
    }

    function contarClientesUsuarios($table, $name){$res = array();$cmd = $this->pdo->query("SELECT * FROM $table ORDER BY $name");$res = $cmd->fetchAll(PDO::FETCH_ASSOC);echo count($res);}function countClientsPayment($table, $name){$res = array();$cmd = $this->pdo->query("SELECT * FROM $table ORDER BY $name");$res = $cmd->fetchAll(PDO::FETCH_ASSOC);return count($res);}function returnMonthLucro($ano){$query =  $this->pdo->query("SELECT mes as monthname , SUM(lucro) as amount from controlodevendas where ano = $ano group BY monthname ;");return $query;}
    
    function returnStockRestantValues(){$query = $this->pdo->query("SELECT producto as proname, SUM(stockrestante) as amount from controlodestock group BY proname ;");return $query;}
    
    function returnProLucro(){$query = $this->pdo->query("SELECT producto as proname, SUM(lucro) as amount from controlodevendas group BY proname ;");return $query;}function lucroSum(){$lucroQuery = $this->pdo->query("SELECT SUM(lucro) as totallucro from controlodevendas");return $lucroQuery;}


    function gravarVendas($produto, $pesoliquido, $quantidade, $valorcusto, $valorunico, $valortotal, $desconto, $lucro, $mes, $ano){
      $cmd = $this->pdo->prepare("INSERT INTO controlodevendas(producto, pesoliquido, quantidade, valorcusto, valorunico, valortotal, desconto, lucro, mes, ano) VALUES(:pro, :pl, :qua, :vc, :vu, :vt, :dc, :lu, :mes, :ano) ");
      $cmd->bindValue(":pro", $produto);
      $cmd->bindValue(":pl", $pesoliquido);
      $cmd->bindValue(":qua", $quantidade);
      $cmd->bindValue(":vc", $valorcusto);
      $cmd->bindValue(":vu", $valorunico);
      $cmd->bindValue(":vt", $valortotal);
      $cmd->bindValue(":dc", $desconto);
      $cmd->bindValue(":lu", $lucro);
      $cmd->bindValue(":mes", $mes);
      $cmd->bindValue(":ano", $ano);
      $cmd->execute();
    }


    function gravarStock($codigo, $proname, $pl, $qtd, $vcusto, $vvenda, $totalpago, $stockrestante, $barcode, $vendido){
      $cmd = $this->pdo->prepare("INSERT INTO controlodestock(codigo, producto, pesoliquido, quantidade, valorcusto, valorvenda, totalpago, stockrestante, barcode, vendido) VALUES(:code, :proname, :pl, :qtd, :vc, :vv, :tp, :sr, :barcode, :vend) ");
      $cmd->bindValue(":code", $codigo);
      $cmd->bindValue(":proname", $proname);
      $cmd->bindValue(":pl", $pl);
      $cmd->bindValue(":qtd", $qtd);
      $cmd->bindValue(":vc", $vcusto);
      $cmd->bindValue(":vv", $vvenda);
      $cmd->bindValue(":tp", $totalpago);
      $cmd->bindValue(":sr", $stockrestante);
      $cmd->bindValue(":barcode", $barcode);
      $cmd->bindValue(":vend", $vendido);
      $cmd->execute();
    }

    function increaseStock($value, $vend, $code){
      $cmd = $this->pdo->prepare("UPDATE controlodestock SET stockrestante = stockrestante - :valor, vendido = vendido + :vend WHERE codigo = :code");
      $cmd->bindValue(":valor", $value);
      $cmd->bindValue(":vend", $vend);
      $cmd->bindValue(":code", $code);
      $cmd->execute();
    }
      
    function saveActivity($accao, $pro, $pl, $qtd, $tp, $us, $dia, $hora, $val){
      $cmd = $this->pdo->prepare("INSERT INTO activities (accao, producto, pesoliquido, quantidade, totalpago, usuario, dia, hora, validade) VALUES(:accao, :pro, :pl, :qtd, :tp, :us, :dia, :hora, :val) ");
      $cmd->bindValue(":accao", $accao);
      $cmd->bindValue(":pro", $pro);
      $cmd->bindValue(":pl", $pl);
      $cmd->bindValue(":qtd", $qtd);
      $cmd->bindValue(":tp", $tp);
      $cmd->bindValue(":us", $us);
      $cmd->bindValue(":dia", $dia);
      $cmd->bindValue(":hora", $hora);
      $cmd->bindValue(":val", $val);
      $cmd->execute();
    }

    // should del it!
    function delActivity($val){
      $sallact = $this->selectRecords("activities", "validade", $val);
      $tsallact = count($sallact);
      for($i=0;$i<$tsallact;$i++){
        if($sallact[$i]["accao"] == "Login" || $sallact[$i]["accao"] == "Logout"){
          $actId = $sallact[$i]["accao"];
          $this->delRec("activities", "id", $actId);
        }
      }
      
    }

    public function delRec($table, $row, $value){$cmd = $this->pdo->prepare("DELETE FROM $table WHERE $row = :valor");$cmd->bindValue(":valor", $value);$cmd->execute();}

    function actualizarStock($pro, $pl, $qtd, $vcu, $vvu, $tp, $st, $barcode, $code){
     $oneres = array();
     $vcmd = $this->pdo->prepare('SELECT * FROM controlodestock where codigo = :code');
     $vcmd->bindValue(":code", $code);
     $vcmd->execute();
     $oneres = $vcmd->fetch(PDO::FETCH_ASSOC);
     if ($oneres["stockrestante"] == 0){
        $astock = $this->pdo->prepare("UPDATE controlodestock SET producto = :pro, pesoliquido = :pl, quantidade = :qtd, valorcusto = :vc, valorvenda = :vv, totalpago = :tp, stockrestante = stockrestante + :st, barcode = :qc, vendido = 0 WHERE codigo = :code");
        $astock->bindValue(":pro", $pro);
        $astock->bindValue(":pl", $pl);
        $astock->bindValue(":qtd", $qtd);
        $astock->bindValue(":vc", $vcu);
        $astock->bindValue(":vv", $vvu);
        $astock->bindValue(":tp", $tp);
        $astock->bindValue(":st", $st);
        $astock->bindValue(":qc", $barcode);
        $astock->bindValue(":code", $code);
        $astock->execute();
     }else{
        $astock = $this->pdo->prepare("UPDATE controlodestock SET producto = :pro, pesoliquido = :pl, quantidade = quantidade + :qtd, valorcusto = :vc, valorvenda = :vv, totalpago = totalpago + :tp, stockrestante = stockrestante + :st, barcode = :qc WHERE codigo = :code");
        $astock->bindValue(":pro", $pro);
        $astock->bindValue(":pl", $pl);
        $astock->bindValue(":qtd", $qtd);
        $astock->bindValue(":vc", $vcu);
        $astock->bindValue(":vv", $vvu);
        $astock->bindValue(":tp", $tp);
        $astock->bindValue(":st", $st);
        $astock->bindValue(":qc", $barcode);
        $astock->bindValue(":code", $code);
        $astock->execute();
     }
    }

    function selectActiRec($seletedDateBegin, $seletedDateFinal){$result = array();$query = $this->pdo->prepare("SELECT * FROM activities WHERE dia >= :inicialdate AND dia <= :finaldate");$query->bindValue(':inicialdate', $seletedDateBegin);$query->bindValue(':finaldate', $seletedDateFinal);$query->execute();$result = $query->fetchAll(PDO::FETCH_ASSOC);return $result;}

    function selectAllRecs($table){$res = array();$squery = $this->pdo->query("SELECT * FROM $table");$res = $squery->fetchAll(PDO::FETCH_ASSOC);return $res;}

    function createPromo($pro, $code, $np, $vp, $pl, $barcode){
      $q = $this->pdo->prepare("INSERT INTO promocoes(produto, codigo, nprodutos, vpromo, pesoliquido, barcode) VALUES(:pro, :code, :np, :vp, :pl, :barcode)");
      $q->bindValue(":pro", $pro);
      $q->bindValue(":code", $code);
      $q->bindValue(":np", $np);
      $q->bindValue(":vp", $vp);
      $q->bindValue(":pl", $pl);
      $q->bindValue(":barcode", $barcode);
      $q->execute();
    }

    function dailyChart($seletedDateBegin, $seletedDateFinal){
      $query = $this->pdo->query("SELECT mes as dayname, SUM(lucro) as amount FROM controlodevendas WHERE ano='$seletedDateBegin' AND mes = '$seletedDateFinal' group by dayname ");
      return $query;
    }
    // SELECT producto as proname, SUM(quantidade) as amount FROM activities WHERE dia >='2023-11-21' AND dia <='2023-11-21' group by proname

    function actirecs($seletedDateBegin, $seletedDateFinal){ 
      $query = $this->pdo->prepare("SELECT accao, producto as proname, SUM(quantidade) as qtd, SUM(totalpago) as amount FROM activities WHERE dia >='$seletedDateBegin' AND dia <='$seletedDateFinal' AND accao == 'Venda' group by proname ");
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    function saveDef($li){
      $q = $this->pdo->prepare("INSERT INTO definicoes(limiteinfe) VALUES(:li)");
      $q->bindValue(':li', $li);
      $q->execute();
    }

    function updateDef($li, $id){
      $q = $this->pdo->prepare("UPDATE definicoes SET limiteinfe = :infe WHERE id = :id ");
      $q->bindValue(":infe", $li);
      $q->bindValue(":id", $id);
      $q->execute();
    }

    function saveremessadoc($id, $pro, $pl, $qtd, $user, $dia, $hora){
      $q = $this->pdo->prepare("INSERT INTO remessarecs(id, produto, pesoliquido, quantidade, usuario, dia, hora) VALUES(:id, :pro, :pl, :qtd, :user, :dia, :hora)");
      $q->bindValue(":id", $id);
      $q->bindValue(":pro", $pro);
      $q->bindValue(":pl", $pl);
      $q->bindValue(":qtd", $qtd);
      $q->bindValue(":user", $user);
      $q->bindValue(":dia", $dia);
      $q->bindValue(":hora", $hora);
      $q->execute();
    }
}


?>