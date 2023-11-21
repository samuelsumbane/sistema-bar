<?php
   // Database Connection
   include 'conexao.php';
   // Reading value
   $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value

   $searchArray = array();
   // Search
   $searchQuery = " ";
   if($searchValue != ''){
      $searchQuery = " AND (producto LIKE :producto OR quantidade LIKE :quantidade OR valorcusto LIKE :valorcusto OR valorunico LIKE :valorunico OR valortotal LIKE :valortotal OR desconto LIKE :desconto or lucro LIKE :lucro OR mes LIKE :mes OR ano LIKE :ano) ";
      $searchArray = array( 'producto'=>"%$searchValue%",'quantidade'=>"%$searchValue%",'valorcusto'=>"%$searchValue%", 'valorunico'=>"%$searchValue%", 'valortotal'=>"%$searchValue", 'desconto'=>"%$searchValue%", 'lucro'=>"%$searchValue%", 'mes'=>"%$searchValue%", 'ano'=>"%$searchValue%");
   }

   // Total number of records without filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM controlodevendas ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM controlodevendas WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $con->prepare("SELECT * FROM controlodevendas WHERE  1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

   $data = array();
  
   foreach ($empRecords as $row) {

      $data[] = array(
         "producto"=>$row["producto"],
         "pesoliquido"=>$row["pesoliquido"],
         "quantidade"=>$row["quantidade"],
         "valorcusto"=>$row["valorcusto"],
         "valorunico"=>$row["valorunico"],
         "valortotal"=>$row["valortotal"],
         "desconto"=>number_format($row["desconto"], 2),
         "lucro"=>$row["lucro"],
         "mes"=>$row["mes"],
         "ano"=>$row["ano"]
   
      );
    

   }

   // Response
   $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
   );

   echo json_encode($response);

// on addproducts
