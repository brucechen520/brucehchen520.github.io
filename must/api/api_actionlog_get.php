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
    $webData = array() ;

    // $whereString = "";
    // $wherefirst = true;
    // if($param->status != null && $param->status != ''){
    //   $whereString = "WHERE (status = '".$param->status."'";
    //   $wherefirst = false;
    // }
    // if($param->Mem_Se != null){
    //   if($param->Mem_Se == 'auto')
    //     $param->Mem_Se = $user->Mem_Se;
    //   if($wherefirst){
    //     $whereString = "WHERE (Mem_Se = '".$param->Mem_Se."'";
    //     $wherefirst = false;
    //   }
    //   else
    //     $whereString .= " && Mem_Se = '".$param->Mem_Se."'";
    // }
    // if(!$wherefirst)
    //   $whereString .= ")";

    $str = "SELECT * FROM alumnidata.`Industry_log` ORDER BY `actionTime` desc";
    $list = mysql_query($str);
		//echo $str; 
    if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
        echo json_encode($json);
    } else{
      while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
        $now_row = new stdClass;
        $now_row->serial    =  $row[serial];
        $now_row->memberTitle    =  $row[memberTitle];
        $now_row->memberName    =  $row[memberName];
        $now_row->pageType  =  $row[pageType];
        $now_row->actionType  =  $row[actionType];
        $now_row->actionDetail    =  $row[actionDetail];
        $now_row->actionTime    =  date("Y-m-d H:i:s", $row[actionTime]);        
        array_push($webData, $now_row);
      }
      mysql_close($link);
 
	  $data = new stdClass();
	  $data->list = $webData;
	  $data->totalCount = count($webData);
	  $result = new stdClass();
	  $result->code = 'success';
	  $result->data = $data;
      echo json_encode($result);
    }
?>
