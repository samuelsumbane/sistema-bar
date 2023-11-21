<?php
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
      $searchQuery = " AND (accao like :accao or producto like :producto or quantidade like :quantidade or totalpago like :totalpago or pesoliquido like :pesoliquido or usuario like :usuario or dia like :dia or hora like :hora) ";

      $searchArray = array('accao'=>"%$searchValue%", "producto"=>"%$searchValue%", "pesoliquido"=>"%$searchValue%", "quantidade"=>"%$searchValue%", "totalpago"=>"%$searchValue%", "dia"=>"%$searchValue%", "hora"=>"%$searchValue%", "usuario"=>"%$searchValue%");
   }

   // Total number of records without filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM activities ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM activities WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $con->prepare("SELECT * FROM activities WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

 

   $data = array();
   //
   foreach ($empRecords as $row) {
      $data[] = array(
         "accao"=>$row['accao'],
         "producto"=>$row['producto'],
         "pesoliquido"=>$row["pesoliquido"],
         "quantidade"=>$row["quantidade"],
         "totalpago"=>$row["totalpago"],
         "usuario"=>$row['usuario'],
         "data"=>$row['dia'],
         "hora"=>$row['hora']
        
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