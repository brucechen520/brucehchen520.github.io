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
    /*
      methods
        'insert'	->   新增資料
        'delete'	->	 刪除資料
        'update'	->   修改資料
    */
    $methods = $_GET['methods'];
    if(isset($_GET['examined']))
      $examined = $_GET['examined'];
    switch ($methods) {
      case 'insert':
          $data = json_decode($_GET['data']); // GET_['data'] 是一個json格式的string， 所以要先把他decode
          $job_List = array();
          $job_List['CP_Name'] = $data->company_Name; // 公司名稱
          $job_List['CP_Website'] = $data->company_Website; // 公司網站

          $job_List['CT_Man'] = $data->contact_Name; // 聯絡人性名
          $job_List['CT_Mail'] = $data->contact_Mail; // 聯絡人信箱
          $job_List['CT_Phone'] = $data->contact_Phone; // 聯絡人電話
          $job_List['CT_Time'] = $data->contact_Time; // 聯絡時間

          $job_List['JB_Name'] = $data->vacancy_Name; // 職缺名稱
          $job_List['JB_Description'] = $data->description; // 專案描述
          $job_List['JB_Offer'] = $data->offer; // 工作待遇
          $job_List['JB_location'] = $data->location; // 工作地點
          $job_List['JB_duty'] = $data->duty; // 管理責任
          $job_List['JB_officeHour'] = $data->officeHour; // 上班時段
          $job_List['JB_trip'] = $data->trip; // 出差外派
          $job_List['JB_vacation'] = $data->vacation; // 休假制度
          $job_List['JB_demandMans'] = $data->demandMans; //需求人數
          $job_List['JB_academicRequire'] = $data->academicRequire; // 學歷要求
          $job_List['JB_exprience'] = $data->exprience; // 工作經歷
          $job_List['JB_others'] = $data->others; // 其他福利
          $job_List['JB_welfare'] = $data->welfare; // 公司福利

          $job_List['checked'] = $data->checked; // 職務類別
          $job_List['skills'] = $data->skills; // 工作技能
          $job_List['language'] = $data->language; // 語文條件

          // 新增資料進去專案基礎資料表
          $now = time();
          $str ="INSERT into Industry_Vacancy_List (";
          $str .= "Mem_Se, JB_Name, JB_Description, JB_Offer, JB_location, CP_Name, CP_Website, CT_Man, CT_Mail, CT_Phone, CT_Time, JB_duty, JB_officeHour,JB_trip, JB_vacation, JB_demandMans, JB_academicRequire, JB_exprience, JB_others, JB_welfare, examined, modify" ;

          $str .= " ) values (" ;

          $str .=     "'".$user->Mem_Se."',
                      '".$job_List['JB_Name']."',
                      '".$job_List['JB_Description']."',
                      '".$job_List['JB_Offer']."',
                      '".$job_List['JB_location']."',
                      '".$job_List['CP_Name']."',
                      '".$job_List['CP_Website']."',
                      '".$job_List['CT_Man']."',
                      '".$job_List['CT_Mail']."',
                      '".$job_List['CT_Phone']."',
                      '".$job_List['CT_Time']."',
                      '".$job_List['JB_duty']."',
                      '".$job_List['JB_officeHour']."',
                      '".$job_List['JB_trip']."',
                      '".$job_List['JB_vacation']."',
                      '".$job_List['JB_demandMans']."',
                      '".$job_List['JB_academicRequire']."',
                      '".$job_List['JB_exprience']."',
                      '".$job_List['JB_others']."',
                      '".$job_List['JB_welfare']."',
                      '0',
                      '".$now."')";

          $result = mysql_query($str,$link);
          if(!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }
          // 取得剛剛新增的那筆資料的JBID
          $selectStr = "SELECT `JB_Id` FROM `Industry_Vacancy_List` where `JB_Name` = '{$job_List['JB_Name']}' AND `CP_Name` = '{$job_List['CP_Name']}' " ;
          $jbMysql = mysql_query($selectStr,$link);
          $ID = mysql_fetch_assoc($jbMysql);
          $jbID = $ID['JB_Id'];
          if(!$jbID) {
            $json['error'] = mysql_error();
            echo json_encode($json);
            break;
          }

          // 利用剛剛的JBID依序新增技能
          for($i = 0; $i < count($job_List['skills']); $i++) {
            $skill = $job_List['skills'][$i]->value;
            $str = "INSERT INTO `Industry_Vacancy_Skill`(`JB_Id`,`JB_Skill`) values('{$jbID}','{$skill}')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }

          // 利用剛剛的JBID依序新增語言
          for($i = 0; $i < count($job_List['language']); $i++) {
            $language = $job_List['language'][$i]->type;
            $listen = $job_List['language'][$i]->listen;
            $speak = $job_List['language'][$i]->speak;
            $read = $job_List['language'][$i]->read;
            $write = $job_List['language'][$i]->write;
            $str = "INSERT INTO `Industry_Vacancy_Language`(`JB_Id`,`JB_Language`,`listen`,`speak`,`read`,`write`) values('".$jbID."','".$language."','".$listen."','".$speak."','".$read."','".$write."')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }

          // 利用剛剛的JBID依序新增專案人才種類
          $type_Information = $job_List['checked'][0]->title; // 網路資訊相關
          $type_Information_Content = $job_List['checked'][0]->content;
          $type_Marketing = $job_List['checked'][1]->title; // 行銷企劃相關
          $type_Marketing_Content = $job_List['checked'][1]->content;
          for($k = 0; $k < count($job_List['checked']); $k++) {
              for($i = 0; $i < count($job_List['checked'][$k]->content); $i++) {
                $str  = "INSERT INTO `Industry_Vacancy_Type`(" ;

                $str .= "`JB_Id`,`JB_Title`,`JB_Type`";

                $str .=  ") values(";
                $str .=  "'$jbID',
                          '". $job_List['checked'][$k]->title."',
                          '". $job_List['checked'][$k]->content[$i]."')";
                $result = mysql_query($str,$link);
                if (!$result) {
                    $json['error'] = mysql_error();
                    echo json_encode($json);
                    break;
                }
              }
          }
          // 將專案資料放在審核資料表等待管理員審核
          $str = "INSERT INTO `Industry_Review`(`itemid`,`itemtype`,`adminer`,`examined`,`suggestion`,`modifyTime`) values('{$jbID}','0','','0','','{$now}')"; // itemtype 0:職缺, 1:專案
          $result = mysql_query($str,$link);
          if (!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }
          $Mail->SentMail("gibe329apt978@gmail.com","陳十二","有新的專案需要審核!","審核網址如下");
          mysql_close($link);
          $json['success'] = 'success';
          echo json_encode($json);
          break;
      case 'select':
          $webData = array() ;
          /*$str = "SELECT * FROM alumnidata.Industry_Vacancy_List AS li
                          LEFT JOIN alumnidata.Industry_Vacancy_Language AS lang ON li.JB_Id = lang.JB_Id
                          LEFT JOIN alumnidata.Industry_Vacancy_Skill AS sk ON li.JB_Id = sk.JB_Id
                          LEFT JOIN alumnidata.Industry_Vacancy_Type AS t ON li.JB_Id = t.JB_Id;";*/

		  $str = "SELECT * FROM alumnidata.`Industry_Vacancy_List` where examined = '".$examined."'";
          $list = mysql_query($str);
		  //echo $str;
          if($list === FALSE) { // 資料庫有沒有 FALSE
              $json['error'] = mysql_error();
              echo json_encode($json);
          } else{
              while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                  $now_row = new stdClass;
                  $now_row->JB_Id    =  $row[JB_Id];
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
                $json['data'] = $webData;
                echo json_encode($webData);
          }
          break;
      case 'delete':

          $json['data']       =       $data;
          echo json_encode($json) ;
          break;
      case 'update':

          break;
    case 'examined_update':
      echo var_dump($_POST['data']);
      //$update_obj = json_decode($_POST['data']);
      $update_obj->id = $_POST['data']['id'];
      $update_obj->suggestion = $_POST['data']['suggestion'];
      $update_obj->examined = $_POST['data']['examined'];
		  $str = "UPDATE `alumnidata`.`Industry_Vacancy_List` SET `suggestion` = '".$update_obj->suggestion."',
				`examined` = '".$update_obj->examined."',
				`adminer` = '".$user->Mem_Se."',
				`verifyTime` = '".time()."'
      WHERE (`JB_Id` = '".$update_obj->id."');";
      echo var_dump($str);
		  $list = mysql_query($str);
		  if($list === FALSE) { // 資料庫有沒有 FALSE
              $json['error'] = mysql_error();
		  }
		  else{
			  $json['success'] = 'success';
		  }
		  echo json_encode($json);
		  break;
      default:
        $json['other'] = "default";
        echo json_encode($json);
        break;
    }



?>
