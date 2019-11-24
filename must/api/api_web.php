<?
    session_start();
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $json = array();
    $user = unserialize($_SESSION['mem']);
    //$ULEVEL = $tmp['ULEVEL'];
    //$json['ULEVEL'] = $ULEVEL;
    if(is_object($user)) {
      $user->GetMemberData(); // 取得會員資料
      $user->GetMemberConfirm(); // 取得會員權限
    }
    /*
      methods
        'insert'	->   新增資料
        'delete'	->	 刪除資料
        'update'	->   修改資料
    */
    $methods = $_GET['methods']; // 取得請求動作
    //$json['methods'] = $methods;
    //$json['data'] = $data;
    //echo json_encode($json);
    switch ($methods) {
      case 'insert':
          $data = json_decode($_GET['data']); // GET_['data'] 是一個json格式的string， 所以要先把他decode
          $web_type = $data->type; // 網頁類別 都是陣列
          $web_name = $data->name; // 網頁名稱
          $web_descr = $data->descript; // 網頁描述
          $web_add = $data->address; // 網址
          $web_permit = $data->permit; // 網站開放權限
          //echo gettype($data);
          /*
          $json['type'] = $web_type;
          $json['name'] = $web_name;
          $json['descript'] = $web_descr;
          $json['address'] = $web_add;
          echo json_encode($json);
          */
          for($i = 0; $i < count($web_type); $i++){
              $str="INSERT into `Industry_Website`(`Mem_Se`,`web_type`,`web_name`,`web_description`,`web_address`,`Permit_Id`) values('".$user->Mem_Se."','".$web_type[$i]."','".$web_name[$i]."','".$web_descr[$i]."','".$web_add[$i]."','".$web_permit[$i]."')";
              $result = mysql_query($str,$link);
              if (!$result) {
                  $json['error'] = mysql_error();
                  echo json_encode($json);
                  break;
              }
          }
          mysql_close($link);
          $json['success'] = 'success';
          echo json_encode($json);
          break;
      case 'select':
          $webData = array() ;
          $str = "SELECT A.web_type , A.web_name, A.web_description, A.web_address,A.Web_Id,A.Permit_Id,
                              B.M_Name
                      FROM `Industry_Website` A
                          LEFT JOIN Member B USING(`Mem_Se`) ORDER BY `Web_Id` DESC;";
          $list = mysql_query($str);
          if($list === FALSE) { // 資料庫有沒有 FALSE
              $json['error'] = mysql_error();
              echo json_encode($json);
          } else{
            // $user 為會員登入的 session 物件
              if($user->Confirm == -1 || $user->Confirm == 0)
                  $mapConfirm = 0 ; // 封鎖或未認證會員
              else if($user->Confirm == 1 || $user->Confirm == 2 || $user->Confirm == 3)
                  $mapConfirm = 1 ; // 正常會員
              else if($user->Confirm == 4)
                  $mapConfirm = 2; // 管理員
              if(is_object($user)){
                switch($mapConfirm){ // 映射會員權限所看到的畫面
                    case 0: // 封鎖會員 或 未認這會員
                      $id = 1;
                      while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                        if($row[Permit_Id] == 1){ // $now_row->permit === 1 為 對訪客公開但不含姓名
                          $now_row = new stdClass;
                          $now_row->id    =  $id;
                          $now_row->type  =  $row[web_type];
                          $now_row->wName  =  $row[web_name];
                          $now_row->description  =  $row[web_description];
                          $now_row->address  =  $row[web_address];
                          $now_row->name  =  'Secret';
                          array_push($webData, $now_row);
                          $id = $id + 1;
                        }
                        else if($row[Permit_Id] == 2) { // $now_row->permit === 2 為 對訪客全公開
                          $now_row = new stdClass;
                          $now_row->id    =  $id;
                          $now_row->type  =  $row[web_type];
                          $now_row->wName  =  $row[web_name];
                          $now_row->description  =  $row[web_description];
                          $now_row->address  =  $row[web_address];
                          $now_row->name  =  $row[M_Name];
                          array_push($webData, $now_row);
                          $id = $id + 1;
                        }
                      }
                      mysql_close($link);
                      $json['data'] = $webData;
                      echo json_encode($webData);
                      break;
                    case 1: // 正常會員
                      $id = 1;
                      while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                        if($row[Permit_Id] != 3){ // $now_row->permit === 3 為 不公開
                          $now_row = new stdClass;
                          $now_row->id    =  $id;
                          $now_row->type  =  $row[web_type];
                          $now_row->wName  =  $row[web_name];
                          $now_row->description  =  $row[web_description];
                          $now_row->address  =  $row[web_address];
                          $now_row->name  =  $row[M_Name];
                          array_push($webData, $now_row);
                          $id = $id + 1;
                        }
                      }
                      mysql_close($link);
                      $json['data'] = $webData;
                      echo json_encode($webData);
                      break;
                    case 2: // 管理員
                      $id = 1;
                      while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                          $now_row = new stdClass;
                          $now_row->id    =  $id;
                          $now_row->type  =  $row[web_type];
                          $now_row->wName  =  $row[web_name];
                          $now_row->description  =  $row[web_description];
                          $now_row->address  =  $row[web_address];
                          $now_row->name  =  $row[M_Name];
                          array_push($webData, $now_row);
                          $id = $id + 1;
                      }
                      mysql_close($link);
                      $json['data'] = $webData;
                      echo json_encode($webData);
                      break;
                }
              } else { // 訪客
                  $id = 1;
                  while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                    if($row[Permit_Id] == 1){ // $now_row->permit === 1 為 對訪客公開但不含姓名
                      $now_row = new stdClass;
                      $now_row->id    =  $id;
                      $now_row->type  =  $row[web_type];
                      $now_row->wName  =  $row[web_name];
                      $now_row->description  =  $row[web_description];
                      $now_row->address  =  $row[web_address];
                      $now_row->name  =  'Secret';
                      array_push($webData, $now_row);
                      $id = $id + 1;
                    }
                    else if($row[Permit_Id] == 2) { // $now_row->permit === 2 為 對訪客全公開
                      $now_row = new stdClass;
                      $now_row->id    =  $id;
                      $now_row->type  =  $row[web_type];
                      $now_row->wName  =  $row[web_name];
                      $now_row->description  =  $row[web_description];
                      $now_row->address  =  $row[web_address];
                      $now_row->name  =  $row[M_Name];
                      array_push($webData, $now_row);
                      $id = $id + 1;
                    }
                  }
                  mysql_close($link);
                  $json['data'] = $webData;
                  echo json_encode($webData);
              }
          }


          break;
      case 'delete':

          $json['data']       =       $data;
          echo json_encode($json) ;
          break;
      case 'update':

          break;
      default:
        $json['other'] = "default";
        echo json_encode($json);
        break;
    }



?>
