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
      $searchQuery = " AND (nome like :nome or usuario like :usuario or nivel like :nivel) ";

      $searchArray = array('nome'=>"%$searchValue%", "usuario"=>"%$searchValue%", "nivel"=>"%$searchValue%");
   }

   // Total number of records without filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM users ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $con->prepare("SELECT COUNT(*) AS allcount FROM users WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $con->prepare("SELECT * FROM users WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
         "nome"=>$row['nome'],
         "user"=>$row['usuario'],
         // "senha"=>$row['senha'],
         "nivel"=>$row['nivel'],
         "imagem"=>'<img src="uploads/'.$row["imagem"].'" class="" height="35" />',
         "deletar"=>'<button type="button" class="deleteButton" id="'.$row["id"].'" title="Deletar"></button>'
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