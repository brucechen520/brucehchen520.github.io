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
    ///test
    // $user = new stdClass();
    // $user->Mem_Se = 1;
    ///
    $now = time();
    $param = json_decode(file_get_contents('php://input'));
    $data = $param->data;
    
    $str="INSERT into `Industry_Project_List`(`Mem_Se`,`CP_Name`,`CP_Website`,`PJ_Name`,`PJ_Description`,`PJ_Budget`,`PJ_TTL`,`CT_Man`,`CT_Mail`,`CT_Phone`,`CT_Time`,`status`,`modify`)
          values('".$user->Mem_Se."',
                  '".$data->company_Name."',
                  '".$data->company_Website."',
                  '".$data->project_Name."',
                  '".$data->description."',
                  '".$data->offer."',
                  '".$data->deadline."',
                  '".$data->contact_Name."',
                  '".$data->contact_Mail."',
                  '".$data->contact_Phone."',
                  '".$data->contact_Time."',
                  '0',
                  '".$now."')";
    $result = mysql_query($str,$link);
    if (!$result) {
        $json['error'] = mysql_error();
        echo json_encode($json);
        break;
    }
    //寫入log
    $logData = new stdClass();
    $logData->memberTitle=$user->ConfirmDesc;
    $logData->memberName=$user->Name;
    $logData->pageType="專案";
    $logData->actionType="新增";
    $logData->actionDetail="成員".$user->Name."新增了一件專案需求:".$data->project_Name;
    $logData->actionTime=time();
    
    insertActionLog($logData);

    mysql_close($link);
          
    if(!array_key_exists("error",$json)){
      $result = new stdClass();
	    $result->code = 'success';
      echo json_encode($result);
    }
    else{
      $result = new stdClass();
      $result->code = 'error';
      echo json_encode($result);
    }
?>
