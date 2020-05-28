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
    $str = "DELETE FROM `alumnidata`.`Industry_Vacancy_List` WHERE (`JB_Id` = '".$data->id."');";
    $result = mysql_query($str,$link);
    if(!$result) {
        $json['error'] = mysql_error();
        echo json_encode($json);
    }

    //寫入log
    $logData = new stdClass();
    $logData->memberTitle=$user->ConfirmDesc;
    $logData->memberName=$user->Name;
    $logData->pageType="職缺";
    $logData->actionType="刪除";
    $logData->actionDetail="成員".$user->Name."刪除了一件職缺:職缺序號".$data->id;
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
