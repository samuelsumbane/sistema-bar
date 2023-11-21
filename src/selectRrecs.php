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
      $searchQuery = " AND (produto LIKE :produto OR pesoliquido LIKE :pesoliquido OR quantidade LIKE :quantidade OR usuario LIKE :usuario OR dia LIKE :dia OR hora LIKE :hora) ";
      $searchArray = array( 'produto'=>"%$searchValue%",'pesoliquido'=>"%$searchValue%", 'quantidade'=>"%$searchValue%", 'usuario'=>"%$searchValue", 'dia'=>"%$searchValue", 'hora'=>"%$searchValue" );
   }

   // Total number of records without filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM remessarecs ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM remessarecs WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $con->prepare("SELECT * FROM remessarecs WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
         "produto"=>$row['produto'],
         "pesoliquido"=>$row['pesoliquido'],
         "quantidade"=>$row['quantidade'],
         "usuario"=>$row['usuario'],
         "dia"=>$row['dia'],
         "hora"=>$row['hora'],
         "delete"=>'<button type="button" class="deleteButton" id="'.$row["id"].'" title="Deletar"></button>'
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