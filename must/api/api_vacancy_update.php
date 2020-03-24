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
    $param = json_decode(file_get_contents('php://input'));
    $data = $param->data;
    // 修改資料
    $now = time();
    $str ="UPDATE `alumnidata`.`Industry_Vacancy_List` SET
    		`CP_Name` = '".$data->company_Name."',
				`CP_Website` = '".$data->company_Website."',
				`JB_Name` = '".$data->vacancy_Name."',
        `JB_Description` = '".$data->description."',
				`JB_Offer` = '".$data->offer."',
				`JB_location` = '".$data->location."',
        `CT_Man` = '".$data->contact_Name."',
				`CT_Mail` = '".$data->contact_Mail."',
        `CT_Phone` = '".$data->contact_Phone."',
				`CT_Time` = '".$data->contact_Time."',
        `status` = '0',
				`modify` = '".$now."'
        WHERE (`JB_Id` = '".$data->id."');";
    $result = mysql_query($str,$link);
    if(!$result) {
        $json['error'] = mysql_error();
        echo json_encode($json);
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
