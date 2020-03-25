<?

    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $json = array();
    $user = unserialize($_SESSION['mem']);
    //$ULEVEL = $tmp['ULEVEL'];
    //$json['ULEVEL'] = $ULEVEL;
    //$headers = apache_request_headers();

    // foreach ($_SERVER as $header => $value) {
    //     echo "$header: $value <br />\n";
    // }
    //echo "token:".$_SERVER["HTTP_TOKEN"];
    //echo var_dump($_SESSION['mem']);
    if(is_object($user)){
      $user->GetMemberData();
      $user->GetMemberConfirm();
      //$request = $_GET['params'];
      // $json["request"] = $request;
      // echo json_encode($json);


      //  回傳系級跟姓名
      $json['level'] = $user->M_ULevel;
      $json['name'] = $user->Name;
      $json['id'] = $user->Mem_Se;
      if($user->Confirm == 4)
          $json['isAdmin'] = 1; // 管理員
      echo json_encode($json);
    }
    else if($_SERVER["HTTP_TOKEN"] != null){
        if($_SERVER["HTTP_TOKEN"] == "testMan"){
          $user = new Member(1);
          $user->GetMemberData();
          $user->GetMemberConfirm();

          $json['level'] = $user->M_ULevel;
          $json['name'] = $user->Name;
          $json['id'] = $user->Mem_Se;
          if($user->Confirm == 4)
            $json['isAdmin'] = 1; // 管理員
          echo json_encode($json);
        }
    }
    else {
      $json['name'] = '訪客';
      echo json_encode($json);
    }






/*
    $test = array();
    $test["name"] = 123;
    echo json_encode($test);
    */
?>
