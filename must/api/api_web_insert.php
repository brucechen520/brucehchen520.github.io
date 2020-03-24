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
    
    $str="INSERT into `Industry_Website`(`Mem_Se`,`web_type`,`web_name`,`web_description`,`web_address`,`Permit_Id`) 
          values('".$user->Mem_Se."',
                  '".$data->type."',
                  '".$data->name."',
                  '".$data->description."',
                  '".$data->address."',
                  '".$data->permit."')";
    $result = mysql_query($str,$link);
    if (!$result) {
        $json['error'] = mysql_error();
        echo json_encode($json);
        break;
    }

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
