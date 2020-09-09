<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
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
    $str ="UPDATE `alumnidata`.`Industry_Resume_List` SET
    		`biography` = '".$data->biography."',
				`mail` = '".$data->mail."',
				`cellphone` = '".$data->cellphone."',
        `permit` = '".json_encode($data->permit)."',
				`expertise` = '".$data->expertise."',
				`works` = '".$data->works."',
        `license` = '".$data->license."',
				`modify` = '".$now."',
				`cellphone` = '".$data->cellphone."'
      WHERE (`Mem_Se` = '".$data->Mem_Se."');";
    $result = mysql_query($str,$link);

    $str1 ="UPDATE `alumnidata`.`Member` SET
                `M_Email` = '".$data->mail."',
                `M_Phone` = '".$data->cellphone."'
      WHERE (`Mem_Se` = '".$data->Mem_Se."');";
    $result1 = mysql_query($str1,$link);
    if(!$result || !$result1) {
        $json['error'] = mysql_error();
        echo json_encode($json);
    }
    mysql_close($link);
          
    $result = new stdClass();
    if(!array_key_exists("error",$json)){      
	  $result->code = 'success';
      echo json_encode($result);
    }
    else{
      $result->code = 'error';
      echo json_encode($result);
    }
?>
