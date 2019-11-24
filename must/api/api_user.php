<?

    session_start();
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $json = array();
    $user = unserialize($_SESSION['mem']);
    //$ULEVEL = $tmp['ULEVEL'];
    //$json['ULEVEL'] = $ULEVEL;
    if(is_object($user)){
      $user->GetMemberData();
      $user->GetMemberConfirm();
      //$request = $_GET['params'];
      // $json["request"] = $request;
      // echo json_encode($json);


      //  回傳系級跟姓名
      $json['level'] = $user->M_ULevel;
      $json['name'] = $user->Name;
      if($user->Confirm == 4)
          $json['isAdmin'] = 1; // 管理員
      echo json_encode($json);
    } else {
      $json['name'] = '訪客';
      echo json_encode($json);
    }






/*
    $test = array();
    $test["name"] = 123;
    echo json_encode($test);
    */
?>
