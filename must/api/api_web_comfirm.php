<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $json = array();
    $user = unserialize($_SESSION['mem']);
    if(is_object($user)) {
      $user->GetMemberData();
      $user->GetMemberConfirm();
    }

      $data = json_decode(file_get_contents('php://input'));
	  
	  $str = "UPDATE `alumnidata`.`Industry_Website` SET
				`suggestion` = '".$data->suggestion."',
				`status` = '".$data->status."',
				`adminer` = '".$user->Mem_Se."',
				`verifyTime` = '".time()."'
		  WHERE (`Web_Id` = '".$data->id."');";
		  $list = mysql_query($str); 
		  if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
		  }
		  else{
			  $json['code'] = 'success';
		  }
      echo json_encode($json);

      //寫入log
      $logData = new stdClass();
      $logData->memberTitle=$user->ConfirmDesc;
      $logData->memberName=$user->Name;
      $logData->pageType="網站";
      $logData->actionType="審核";
      $logData->actionDetail="成員".$user->Name."審核了".$data->publisher."的網站:".$data->name."的狀態為".getStatusDesc($data->status)."(網站序號:".$data->id.")";
      $logData->actionTime=time();
      insertActionLog($logData);

      //寄信
      if($data->status == 1 || $data->status == 2){
        $str = "SELECT mail FROM alumnidata.Industry_Resume_List WHERE Mem_Se = ".$data->publisherId.";";
        $list = mysql_query($str);
        $row = mysql_fetch_array($list, MYSQL_ASSOC);
        $publisherMail = $row[mail];

        $Mail = new MailSender();
        $address = $publisherMail;
        $name = $data->publisher;
        $subject = "[系統通知]---您曾使用電機系友會工商網站,＂發佈網站＂ 審核結果通知　(此信件透過系統發送，請勿直接回覆)";
        if($data->status == 1){
          $body = $data->publisher." 系友您好;

          感謝您使用電機系友會工商網站,＂發佈網站＂ 其審核結果如下：　
          
          網站名稱:".$data->name."

          審核通過（並已公佈）　
        
          請您再次連結　電機系友會
        
          http://etouch.ee.fcu.edu.tw/ee/"; 
        }
        else{
          $body = $data->publisher." 系友您好;

          感謝您使用電機系友會工商網站,＂發佈網站＂ 其審核結果如下：　
          
          網站名稱:".$data->name."

          暫不通過, 管理員意見如下　
          
          ".$data->suggestion."
          
          請您再次連結　電機系友會自行修改或和系友會聯絡
        
          http://etouch.ee.fcu.edu.tw/ee/"; 
        }
        $Mail->SentMail($address,$name,$subject,$body);
      }
?>
