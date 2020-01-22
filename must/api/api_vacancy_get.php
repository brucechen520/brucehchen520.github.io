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
	  $str = "SELECT * FROM alumnidata.`Industry_Vacancy_List` WHERE `status` = '".$param->status."'";
    $list = mysql_query($str);
		//echo $str; 
    if($list === FALSE) { // 資料庫有沒有 FALSE
        $json['error'] = mysql_error();
        echo json_encode($json);
    } else{
      while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
        $now_row = new stdClass;
        $now_row->id    =  $row[JB_Id];
        $now_row->company_Name    =  $row[CP_Name];
        $now_row->company_Website    =  $row[CP_Website];
        $now_row->Name  =  $row[JB_Name];
        $now_row->description  =  $row[JB_Description];
        $now_row->location    =  $row[JB_location];
        $now_row->duty    =  $row[JB_duty];
        $now_row->offer    =  $row[JB_Offer];
        $now_row->officeHour  =  $row[JB_officeHour];
        $now_row->trip  =  $row[JB_trip];
        $now_row->vacation  =  $row[JB_vacation];
        $now_row->demandMans  =  $row[JB_demandMans];
        $now_row->academicRequire  =  $row[JB_academicRequire];
        $now_row->exprience  =  $row[JB_trip];
        $now_row->others  =  $row[JB_others];
        $now_row->welfare  =  $row[JB_welfare];
        $now_row->contact_Name  =  $row[CT_Man];
        $now_row->contact_Mail  =  $row[CT_Mail];
        $now_row->contact_Phone  =  $row[CT_Phone];
        $now_row->contact_Time  =  $row[CT_Time];
        $now_row->status = $row[status];
        $now_row->modify  =  date("Y-m-d", $row[modify]);
        $now_row->suggestion  =  $row[suggestion];
        $now_row->adminer  =  $row[adminer];
        $now_row->verifyTime  =  date("Y-m-d", $row[verifyTime]);
        $now_row->type = array() ;
        $now_row->language = array() ;
        $now_row->skills = array() ;
        //取得Type資料
        $str2 = "SELECT * FROM alumnidata.`Industry_Vacancy_Type` WHERE JB_Id = $row[JB_Id]";
        $list2 = mysql_query($str2);

        while ($row2 = mysql_fetch_array($list2, MYSQL_ASSOC)) {
          $now_row2 = new stdClass;
          $now_row2->id = $row2[serial];
          $now_row2->title = $row2[JB_Title];
          $now_row2->content = $row2[JB_Type];
          array_push($now_row->type, $now_row2);
        }
        //取得language資料
        $str2 = "SELECT * FROM alumnidata.`Industry_Vacancy_Language` WHERE JB_Id = $row[JB_Id]";
        $list2 = mysql_query($str2);

        while ($row2 = mysql_fetch_array($list2, MYSQL_ASSOC)) {
          $now_row2 = new stdClass;
          $now_row2->id = $row2[serial];
          $now_row2->type = $row2[JB_Language];
          $now_row2->listen = $row2[listen];
          $now_row2->speak = $row2[speak];
          $now_row2->read = $row2[read];
          $now_row2->write = $row2[write];
          array_push($now_row->language, $now_row2);
        }
        //取得skills資料
        $str2 = "SELECT * FROM alumnidata.`Industry_Vacancy_Skill` WHERE JB_Id = $row[JB_Id]";
        $list2 = mysql_query($str2);

        while ($row2 = mysql_fetch_array($list2, MYSQL_ASSOC)) {
          $now_row2 = new stdClass;
          $now_row2->id = $row2[serial];
          $now_row2->value = $row2[JB_Skill];
          array_push($now_row->skills, $now_row2);
        }
        
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
