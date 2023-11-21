<?php
require_once 'classCrud.php';
$p = new CrudAll;

class Funcoes{

    public function returnComplenteMonth($date){
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


    public function return2digitsMonth($date){
        $mes = array(
            "Janeiro"=>"01",
            "Fevereiro"=>"02",
            "Março"=>"03",
            "Abril"=>"04",
            "Maio"=>"05",
            "Junho"=>"06",
            "Julho"=>"07",
            "Agosto"=>"08",
            "Setembro"=>"09",
            "Outubro"=>"10",
            "Novembro"=>"11",
            "Dezembro"=>"12"
        );
        return $mes[$date];
    }

    public function return2digitsValues($month){

        $valores = array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12");
        
        if ($month == "0"){
            $mesCap = $valores["12"];
            $ano = date('Y') - 1;

        }else{
            $mesCap = $valores[$month];
            $ano = date('Y');
        }
        
        $datas = array($mesCap, $ano);
        return $datas;

    }

    public function randomCode(){$fiveDigits = rand(100000, 999999);return $fiveDigits;}


    public function nextMonth2digits($month){

        $valores = array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12");

        if ($month == "13"){
            $mesCap = $valores["1"];
            $ano = date('Y') + 1;

        }else{
            $mesCap = $valores[$month];
            $ano = date('Y');

        }
        $datas = array($mesCap, $ano);
        return $datas;

    }

    public function prevMonth2digits($month){

        $valores = array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12");

        if ($month == "0"){
            $mesAntCap = $valores["12"];
            $ano = date('Y') - 1;
        }else{
            $mesAntCap = $valores[$month];
            $ano = date('Y');
        }
        $datas = array($mesAntCap, $ano);
        return $datas;
    }
    
    public function returnVencDate($dia){

        $proximomes = date('m') + 1;
        $dadosdomes = $this->nextMonth2digits($proximomes);
        $mes = $dadosdomes[0];
        $ano = $dadosdomes[1];

        $venc = $dia.".".$mes.".".$ano;
        return $venc;
    }

    function retornarHora(){
        date_default_timezone_set('Africa/Maputo');
        $hora = date('H:i');
        return $hora;
    }

    function retornarData(){
        $data = date('d-m-Y');
        return $data;
    }

    function calcularPercentagem($primario, $secundario){
        $res1 = $primario / 100;
        $finalRes = $res1 * $secundario;
        return $finalRes;
    }
    
    function return4months($mes, $ano){
        $valores = array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12");

        $quartomes = $mes + 4;
        if($quartomes > 12){
            $novomes = $quartomes - 12;
            $ano += 1;
            $quartomesAntes = $novomes;
            $quartomesDepois = $valores[$quartomesAntes];
        }else{
            $quartomesDepois = $valores[$quartomes];
        }
        $datadoquartomes = array($quartomesDepois, $ano);
        return $datadoquartomes;
    }

    function vencimentodaactividade(){
        $dataPamericano = date('Y-m-d');
        $mesatual = date('m');
        $anoatual = date('Y');
        $quartomesdados = $this->return4months($mesatual, $anoatual);
        $mes = $quartomesdados[0];
        $ano = $quartomesdados[1];
        $dadosdevencimento = array($mes, $ano);
        return $dadosdevencimento;
    }   


    function datetimenow(){
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $hour = date('H');
        $men = date('i');
        $fulldate = $year.$month.$day.$hour.$men;
        return $fulldate; 
    }

    function returnActDate(){
        $dataPamericano = date('Y-m-d');
        $mesatual = date('m');
        $anoatual = date('Y') + 1;
        $dadosdevencimento = array($mesatual, $anoatual);
        return $dadosdevencimento;
    }

}
