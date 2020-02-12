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
	$whereString = "";
	$wherefirst = true;
	if($param->status != null && $param->status != ''){
		$whereString = "WHERE (A.status = '".$param->status."'";
		$wherefirst = false;
	}
	if($param->Mem_Se != null){
		if($param->Mem_Se == 'auto')
			$param->Mem_Se = $user->Mem_Se;
		if($wherefirst){
			$whereString = "WHERE (A.Mem_Se = '".$param->Mem_Se."'";
			$wherefirst = false;
		}
		else
			$whereString .= " && A.Mem_Se = '".$param->Mem_Se."'";
	}
	if(!$wherefirst)
		$whereString .= ")";
	
	$str = "SELECT A.web_type , A.web_name, A.web_description, A.web_address,A.Web_Id,A.Permit_Id,A.status,A.verifyTime,B.M_Name
		FROM `Industry_Website` A
		LEFT JOIN Member B USING(`Mem_Se`)
		".$whereString."
		ORDER BY `Web_Id` DESC;";
	//var_dump($param);
	//var_dump($param->Mem_Se != null);
	$list = mysql_query($str);
	$webData = array();
	if($list === FALSE) { // 資料庫有沒有 FALSE
		$json['error'] = mysql_error();
		echo json_encode($json);
	} else{
		while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
			$now_row = new stdClass;
			$now_row->id  =  $row[Web_Id];
			$now_row->type  =  $row[web_type];
			$now_row->wName  =  $row[web_name];
			$now_row->description  =  $row[web_description];
			$now_row->address  =  $row[web_address];
			$now_row->name  =  $row[M_Name];
			$now_row->status = $row[status];
			$now_row->verifyTime = $row[verifyTime];
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
