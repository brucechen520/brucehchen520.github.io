<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    function isShow($user,$data){
      if($data == 2 || ($data ==1 && $user == 0))
        return false;
      return true;
    }

    $Mail = new MailSender();
    $json = array();
    $memberArray = array();
    $user = getUserData();

    $param = json_decode(file_get_contents('php://input'));
    $id = $param->id ? $param->id : $user->Mem_Se ;
    $resume = array() ;
	  $str = "SELECT *,B.M_Name,B.M_ULevel,B.M_UClass FROM alumnidata.`Industry_Resume_List` LEFT JOIN Member B USING(`Mem_Se`)";
    $list = mysql_query($str);
    if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
        echo json_encode($json);
    } else{
      while($row = mysql_fetch_array($list, MYSQL_ASSOC)){
        $now_row = new stdClass;
        $now_row->Mem_Se    =  $row[Mem_Se];
        $now_row->level    =  $row[M_ULevel];
        $now_row->class    =  $row[M_UClass];
        $now_row->name    =  $row[M_Name];
        $now_row->cellphone    =  $row[cellphone];
        $now_row->permit    =  json_decode($row[permit]);
        $now_row->biography  =  $row[biography];
        $now_row->mail  =  $row[mail];
        $now_row->modify    =  $row[modify];
        $now_row->expertise  =  $row[expertise];
        $now_row->works  =  $row[works];
        $now_row->license    =  $row[license];

        $now_row->name = isShow($user->Confirm,$now_row->permit->name) ? $now_row->name : "不公開";
        $now_row->cellphone = isShow($user->Confirm,$now_row->permit->phone) ? $now_row->cellphone : "不公開";
        $now_row->mail = isShow($user->Confirm,$now_row->permit->mail) ? $now_row->mail : "不公開";
        array_push($memberArray, $now_row);
      };

      mysql_close($link);
  
      $data = new stdClass();
      $data->list = $memberArray;
      $data->totalCount = count($memberArray);
      $result = new stdClass();
      $result->code = 'success';
      $result->data = $data;

      echo json_encode($result);
    }

?>
