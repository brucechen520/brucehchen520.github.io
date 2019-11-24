<?
    session_start();
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $Mail = new MailSender();
    $json = array();
    $user = unserialize($_SESSION['mem']);
    //$ULEVEL = $tmp['ULEVEL'];
    //$json['ULEVEL'] = $ULEVEL;
    if(is_object($user)) {
      $user->GetMemberData();
      $user->GetMemberConfirm();
    }
    /*
      methods
        'insert'	->   新增資料
        'delete'	->	 刪除資料
        'update'	->   修改資料
    */
    $methods = $_GET['methods'];
    switch ($methods) {
      case 'insert':
          $data = json_decode($_GET['data']); // GET_['data'] 是一個json格式的string， 所以要先把他decode
          $man_List = array();
          $man_List['biography'] = $data->biography; // 自傳
          $man_List['mail'] = $data->mail; // 信箱
          $man_List['cellphone'] = $data->cellphone; // 手機
          $man_List['permit'] = $data->permit; // 公開權限

          $man_List['expertise'] = $data->expertise; // 技能專長
          $man_List['works'] = $data->works; // 作品
          $man_List['license'] = $data->license; // 證照

          // 新增資料進去專案基礎資料表
          $now = time();
          $str ="INSERT into Industry_Resume_List (";
          $str .= "Mem_Se, biography, mail, cellphone, permit, modify" ;

          $str .= " ) values (" ;

          $str .=     "'".$user->Mem_Se."',
                      '".$man_List['biography']."',
                      '".$man_List['mail']."',
                      '".$man_List['cellphone']."',
                      '".$man_List['permit']."',
                      '".$now."')";

          $result = mysql_query($str,$link);
          if(!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }

            // 新增技能
          for($i = 0; $i < count($man_List['expertise']); $i++) {
            $expertise = $man_List['expertise'][$i]->value;
            $str = "INSERT INTO `Industry_Resume_Expertise`(`Mem_Se`,`expertise`) values('{$user->Mem_Se}','{$expertise}')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }

          // 新增證照
        for($i = 0; $i < count($man_List['license']); $i++) {
          $license = $man_List['license'][$i]->value;
          $str = "INSERT INTO `Industry_Resume_License`(`Mem_Se`,`license`) values('{$user->Mem_Se}','{$license}')";
          $result = mysql_query($str,$link);
          if (!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }
        }

          // 新增作品
        for($i = 0; $i < count($man_List['works']); $i++) {
          $works = $man_List['works'][$i]->value;
          $str = "INSERT INTO `Industry_Resume_Works`(`Mem_Se`,`works`) values('{$user->Mem_Se}','{$works}')";
          $result = mysql_query($str,$link);
          if (!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }
        }
          mysql_close($link);
          if(!array_key_exists("error",$json)){
            $json['success'] = 'success';
            echo json_encode($json);
          }
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
