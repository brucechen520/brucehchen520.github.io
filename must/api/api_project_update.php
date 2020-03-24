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
    $str ="UPDATE `alumnidata`.`Industry_Project_List` SET
    		`CP_Name` = '".$data->company_Name."',
				`CP_Website` = '".$data->company_Website."',
				`PJ_Name` = '".$data->project_Name."',
        `PJ_Description` = '".$data->description."',
				`PJ_Budget` = '".$data->offer."',
				`PJ_TTL` = '".$data->deadline."',
        `CT_Man` = '".$data->contact_Name."',
				`CT_Mail` = '".$data->contact_Mail."',
        `CT_Phone` = '".$data->contact_Phone."',
				`CT_Time` = '".$data->contact_Time."',
        `status` = '0',
				`modify` = '".$now."'
        WHERE (`PJ_Id` = '".$data->id."');";
    $result = mysql_query($str,$link);
    if(!$result) {
        $json['error'] = mysql_error();
        echo json_encode($json);
    }

    //寫入log
    $logData = new stdClass();
    $logData->memberTitle=$user->ConfirmDesc;
    $logData->memberName=$user->Name;
    $logData->pageType="專案";
    $logData->actionType="修改";
    $logData->actionDetail="成員".$user->Name."修改了一件專案需求:".$data->project_Name."專案序號:".$data->id;
    $logData->actionTime=time();
    
    insertActionLog($logData);

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
