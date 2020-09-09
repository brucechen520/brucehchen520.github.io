<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $Mail = new MailSender();
    $json = array();
    $user = getUserData();
    
    $param = json_decode(str_replace("'","''",file_get_contents('php://input')));
    $data = $param->data;
    $man_List = array();
    $man_List['biography'] = $data->biography; // 自傳
    $man_List['mail'] = $data->mail; // 信箱
    $man_List['cellphone'] = $data->cellphone; // 手機
    $man_List['permit'] = json_encode($data->permit); // 公開權限

    $man_List['expertise'] = $data->expertise; // 技能專長
    $man_List['works'] = $data->works; // 作品
    $man_List['license'] = $data->license; // 證照
    function getvalue($e){
      return $e->value;
    }
    /*$array_expertise = array_map("getvalue",$data->expertise);
    $array_works = array_map("getvalue",$data->works);
    $array_license = array_map("getvalue",$data->license);

    $data->expertise_str = implode("、",$array_expertise);
    $data->works_str = implode("、",$array_works);
    $data->license_str = implode("、",$array_license);*/
    // 新增資料進去專案基礎資料表
    $now = time();
    $str ="INSERT into Industry_Resume_List (";
    $str .= "Mem_Se, biography, mail, cellphone, permit, modify, expertise, works, license" ;
    $str .= " ) values (" ;
    $str .=     "'".$user->Mem_Se."',
                '".$man_List['biography']."',
                '".$man_List['mail']."',
                '".$man_List['cellphone']."',
                '".$man_List['permit']."',
                '".$now."',
                '".$data->expertise."',
                '".$data->works."',
                '".$data->license."')";
    $result = mysql_query($str,$link);
    if(!$result) {
        $json['error'] = mysql_error();
        echo json_encode($json);
        break;
    }
    // 新增資料進去old Member table
    $str1 ="INSERT into `alumnidata`.`Member` (";
    $str1 .= "M_Email, M_Phone" ;
    $str1 .= " ) values (" ;
    $str1 .=     "'".$man_List['mail']."',
                 '".$man_List['cellphone']."')";
    $result1 = mysql_query($str1,$link);
    if(!$result1) {
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
      $result = new stdClass();
	    $result->code = 'success';
      echo json_encode($result);
    }
    else{
      $result->code = 'error';
      echo json_encode($result);
    }
?>
