<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    $Mail = new MailSender();
    $json = array();
    $user = getUserData();

    $param = json_decode(file_get_contents('php://input'));
    $id = $param->id ? $param->id : $user->Mem_Se ;
    $resume = array() ;
	$str = "SELECT * FROM alumnidata.`Industry_Resume_List` WHERE `Mem_Se` = '".$id."'";
    $list = mysql_query($str);
    
    $row = mysql_fetch_array($list, MYSQL_ASSOC);
    $now_row = new stdClass;
    $now_row->Mem_Se    =  $row[Mem_Se];
    $now_row->permit    =  json_decode($row[permit]);
    $now_row->biography  =  $row[biography];
    $now_row->modify    =  $row[modify];
    $now_row->expertise  =  $row[expertise];
    $now_row->works  =  $row[works];
    $now_row->license    =  $row[license];
    
    $str2 = "SELECT `M_Email`, `M_Phone` FROM alumnidata.`Member` WHERE `Mem_Se` = '".$param->id."'";
    $list2 =  mysql_query($str2);
    $row2 = mysql_fetch_array($list2, MYSQL_ASSOC);
    $now_row->mail  =  $row2[M_Email];
    $now_row->cellphone    =  $row2[M_Phone];

    $data = $now_row;

    $isError = FALSE;
    if(!$list) { // 資料庫有沒有 FALSE
        $isError = TRUE;
    } else if (!$list2) {
        $isError = TRUE;
    }
    if($isError) {
        $json['error'] = mysql_error();
        echo json_encode($json);      
    } else {
        $result = new stdClass();
        $result->code = 'success';
        $result->data = $data;
        echo json_encode($result);
    }

    mysql_close($link);
?>
