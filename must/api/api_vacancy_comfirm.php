<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $json = array();
    $user = unserialize($_SESSION['mem']);
    //$ULEVEL = $tmp['ULEVEL'];
    //$json['ULEVEL'] = $ULEVEL;
    if(is_object($user)) {
      $user->GetMemberData();
      $user->GetMemberConfirm();
    }

      $update_obj = json_decode(file_get_contents('php://input'));
		  $str = "UPDATE `alumnidata`.`Industry_Vacancy_List` SET `suggestion` = '".$update_obj->suggestion."',
				`status` = '".$update_obj->status."',
				`adminer` = '".$user->Mem_Se."',
				`verifyTime` = '".time()."'
      WHERE (`JB_Id` = '".$update_obj->id."');";
		  $list = mysql_query($str);
		  if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
		  }
		  else{
			  $json['code'] = 'success';
		  }
		  echo json_encode($json);
?>
