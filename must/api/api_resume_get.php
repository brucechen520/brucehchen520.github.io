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
    $resume = array() ;
	  $str = "SELECT * FROM alumnidata.`Industry_Resume_List` WHERE `Mem_Se` = '".$param->id."'";
    $list = mysql_query($str);
		//echo $str; 
    if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
        echo json_encode($json);
    } else{
      $row = mysql_fetch_array($list, MYSQL_ASSOC);
      $now_row = new stdClass;
      $now_row->Mem_Se    =  $row[Mem_Se];
      $now_row->cellphone    =  $row[cellphone];
      $now_row->permit    =  $row[permit];
      $now_row->biography  =  $row[biography];
      $now_row->mail  =  $row[mail];
      $now_row->modify    =  $row[modify];
      $now_row->expertise  =  $row[expertise];
      $now_row->works  =  $row[works];
      $now_row->license    =  $row[license];
      /*
      $now_row->expertise = array() ;
      
      $str2 = "SELECT * FROM alumnidata.`Industry_Resume_Expertise` WHERE Mem_Se = '".$param->id."'";
      $list2 = mysql_query($str2);
      while ($row2 = mysql_fetch_array($list2, MYSQL_ASSOC)) {
        array_push($now_row->expertise, $row2[expertise]);
      }

      $now_row->license = array() ;
      
      $str2 = "SELECT * FROM alumnidata.`Industry_Resume_License` WHERE Mem_Se = '".$param->id."'";
      $list2 = mysql_query($str2);
      while ($row2 = mysql_fetch_array($list2, MYSQL_ASSOC)) {
        array_push($now_row->license, $row2[license]);
      }

      $now_row->works = array() ;
      
      $str2 = "SELECT * FROM alumnidata.`Industry_Resume_Works` WHERE Mem_Se = '".$param->id."'";
      $list2 = mysql_query($str2);
      while ($row2 = mysql_fetch_array($list2, MYSQL_ASSOC)) {
        array_push($now_row->works, $row2[works]);
      }
      */
      mysql_close($link);
  
      $data = $now_row;

      $result = new stdClass();
      $result->code = 'success';
      $result->data = $data;
      echo json_encode($result);
    }
?>
