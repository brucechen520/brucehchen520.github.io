<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $json = array();
    $user = getUserData();

    $data = json_decode(file_get_contents('php://input'));
	  if($user){
      $str = "UPDATE `alumnidata`.`Industry_Project_List` SET
          `suggestion` = '".$data->suggestion."',
          `status` = '".$data->status."',
          `adminer` = '".$user->Mem_Se."',
          `verifyTime` = '".time()."'
          WHERE (`PJ_Id` = '".$data->id."');";
      $list = mysql_query($str); 
      if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
      }
      else{
        $json['code'] = 'success';
      }
      //寫入log
    
      $logData = new stdClass();
      $logData->memberTitle=$user->ConfirmDesc;
      $logData->memberName=$user->Name;
      $logData->pageType="專案";
      $logData->actionType="審核";
      $logData->actionDetail="成員".$user->Name."審核了".$data->creater."的專案需求:".$data->project_Name."的狀態為".getStatusDesc($data->status)."(專案序號:".$data->id.")";
      $logData->actionTime=time();
      
      insertActionLog($logData);    
    }


    echo json_encode($json);
?>
