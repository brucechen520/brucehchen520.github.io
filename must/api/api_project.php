<?
    header("Content-Type: text/html; charset=UTF-8");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    session_start();
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
          $proj_List = array();
          $proj_List['CP_Name'] = $data->company_Name; // 公司名稱
          $proj_List['CP_Website'] = $data->company_Website; // 公司網站
          $proj_List['CT_Man'] = $data->contact_Name; // 聯絡人性名
          $proj_List['CT_Mail'] = $data->contact_Mail; // 聯絡人信箱
          $proj_List['CT_Phone'] = $data->contact_Phone; // 聯絡人電話
          $proj_List['CT_Time'] = $data->contact_Time; // 聯絡時間
          $proj_List['PJ_Name'] = $data->project_Name; // 專案名稱
          $proj_List['PJ_Description'] = $data->description; // 專案描述
          $proj_List['PJ_Budget'] = $data->project_budget; // 專案預算
          $proj_List['PJ_TTL'] = $data->deadline; // 專案截止期限
          $proj_List['PJ_KeyWords'] = $data->key; // 專案關鍵字
          $proj_List['checked'] = $data->checked; // 職務類別
          $proj_List['skills'] = $data->skills; // 要求技能
          $proj_List['language'] = $data->language; // 職務類別

          // 新增資料進去專案基礎資料表
          $now = time();
          $str ="INSERT into Industry_Project_List (";
      $str .= "`Mem_Se`, `PJ_Name`,`PJ_Description`, `PJ_Budget`, `PJ_TTL`, `CP_Name`, `CP_Website`, `CT_Man`, `CT_Mail`, `CT_Phone`, `CT_Time`, `status`, `modify`" ;

      $str .= " ) values (" ;

      $str .=     "'".$user->Mem_Se."',
                  '".$proj_List['PJ_Name']."',
                  '".$proj_List['PJ_Description']."',
                  '".$proj_List['PJ_Budget']."',
                  '".$proj_List['PJ_TTL']."',
                  '".$proj_List['CP_Name']."',
                  '".$proj_List['CP_Website']."',
                  '".$proj_List['CT_Man']."',
                  '".$proj_List['CT_Mail']."',
                  '".$proj_List['CT_Phone']."',
                  '".$proj_List['CT_Time']."',
                  '0',
                  '".$now."')";

          $result = mysql_query($str,$link);
          if(!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }
          // 取得剛剛新增的那筆資料的PJID
          $selectStr = "SELECT `PJ_Id` FROM `Industry_Project_List` where `PJ_Name` = '{$proj_List['PJ_Name']}' AND `CP_Name` = '{$proj_List['CP_Name']}' " ;
          $pjMysql = mysql_query($selectStr,$link);
          $ID = mysql_fetch_assoc($pjMysql);
          $pjID = $ID['PJ_Id'];
          if(!$pjID) {
            $json['error'] = mysql_error();
            echo json_encode($json);
            break;
          }
          // 利用剛剛的PJID依序新增關鍵字
          for($i = 0; $i < count($proj_List['PJ_KeyWords']); $i++ ) {
            $key = $proj_List['PJ_KeyWords'][$i]->value ;
            $str = "INSERT INTO `Industry_Project_KeyW`(`PJ_Id`,`PJ_KeyWords`) values('{$pjID}','{$key}')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }

          // 利用剛剛的PJID依序新增技能
          for($i = 0; $i < count($proj_List['skills']); $i++) {
            $skill = $proj_List['skills'][$i]->value;
            $str = "INSERT INTO `Industry_Project_Skill`(`PJ_Id`,`PJ_Skill`) values('{$pjID}','{$skill}')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }

          // 利用剛剛的PJID依序新增語言
          for($i = 0; $i < count($proj_List['language']); $i++) {
            $language = $proj_List['language'][$i]->type;
            $listen = $proj_List['language'][$i]->listen;
            $speak = $proj_List['language'][$i]->speak;
            $read = $proj_List['language'][$i]->read;
            $write = $proj_List['language'][$i]->write;
            $str = "INSERT INTO `Industry_Project_Language`(`PJ_Id`,`PJ_Language`,`listen`,`speak`,`read`,`write`) values('".$pjID."','".$language."','".$listen."','".$speak."','".$read."','".$write."')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }

          // 利用剛剛的PJID依序新增專案人才種類
          $type_Information = $proj_List['checked'][0]->title; // 網路資訊相關
          $type_Information_Content = $proj_List['checked'][0]->content;
          $type_Marketing = $proj_List['checked'][1]->title; // 行銷企劃相關
          $type_Marketing_Content = $proj_List['checked'][1]->content;
          for($i = 0; $i < count($type_Information_Content); $i++) {
            $str = "INSERT INTO `Industry_Project_Type`(`PJ_Id`,`PJ_Title`,`PJ_Type`) values('{$pjID}','{$type_Information}','{$type_Information_Content[$i]}')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }
          for($i = 0; $i < count($type_Marketing_Content); $i++) {
            $str = "INSERT INTO `Industry_Project_Type`(`PJ_Id`,`PJ_Title`,`PJ_Type`) values('{$pjID}','{$type_Marketing}','{$type_Marketing_Content[$i]}')";
            $result = mysql_query($str,$link);
            if (!$result) {
                $json['error'] = mysql_error();
                echo json_encode($json);
                break;
            }
          }
          // 將專案資料放在審核資料表等待管理員審核
          // 20190923取消
		  /*$str = "INSERT INTO `Industry_Review`(`itemid`,`itemtype`,`adminer`,`examined`,`suggestion`,`modifyTime`) values('{$pjID}','1','','0','','{$now}')";
          $result = mysql_query($str,$link);
          if (!$result) {
              $json['error'] = mysql_error();
              echo json_encode($json);
              break;
          }*/
          $Mail->SentMail("gibe329apt978@gmail.com","陳十二","有新的專案需要審核!","審核網址如下");
          mysql_close($link);
          $json['success'] = 'success';
          echo json_encode($json);
          break;
      case 'select':
          $PJ_List = array() ; // 專案基本
          $L_List = array() ; // 語言
          $K_List = array() ; // 關鍵字
          $Sk_List = array() ; // 專長
          $TP_List = array() ; // 類型

          $str = "SELECT li.*, GROUP_CONCAT(DISTINCT CONCAT(t.serial,'_',t.PJ_Title,'_',PJ_Type) SEPARATOR ',') as type,
                      GROUP_CONCAT(DISTINCT CONCAT(sk.serial,'_',sk.PJ_Skill) SEPARATOR ',') as skill,
                      GROUP_CONCAT(DISTINCT CONCAT(kw.serial,'_',kw.PJ_KeyWords) SEPARATOR ',') as keywords,
                      GROUP_CONCAT(DISTINCT CONCAT(lang.serial,'_',lang.PJ_Language ,'_', lang.listen ,'_', lang.speak ,'_', lang.read, '_', lang.write) SEPARATOR ', ') as language_sum
                      FROM alumnidata.Industry_Project_List AS li
                      LEFT JOIN alumnidata.Industry_Project_KeyW AS kw ON li.PJ_Id = kw.PJ_Id
                      LEFT JOIN alumnidata.Industry_Project_Language AS lang ON li.PJ_Id = lang.PJ_Id
                      LEFT JOIN alumnidata.Industry_Project_Skill AS sk ON li.PJ_Id = sk.PJ_Id
                      LEFT JOIN alumnidata.Industry_Project_Type AS t ON li.PJ_Id = t.PJ_Id
                      WHERE li.examined = '".$examined."'
                      GROUP BY PJ_Id ;";
          $list = mysql_query($str);
          if($list === FALSE) { // 資料庫有沒有 FALSE
              $json['error'] = mysql_error();
              echo json_encode($json);
          } else{
            while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                $PJ_row = new stdClass;
                $PJ_row->PJ_Id  =  $row[PJ_Id];
                $PJ_row->Name  =  $row[PJ_Name];
                $PJ_row->description  =  $row[PJ_Description];
                $PJ_row->offer  =  $row[PJ_Budget];
                $PJ_row->deadline  =  $row[PJ_TTL];
                $PJ_row->company_Name = $row[CP_Name];
                $PJ_row->company_Website = $row[CP_Website];
                $PJ_row->contact_Name  =  $row[CT_Man];
                $PJ_row->contact_Mail  =  $row[CT_Mail];
                $PJ_row->contact_Phone  =  $row[CT_Phone];
                $PJ_row->contact_Time  =  $row[CT_Time];
                $PJ_row->modify  =  date("Y-m-d", $row[modify]);
				$PJ_row->suggestion = $row[suggestion];
				$PJ_row->adminer =	$row[adminer];
				$PJ_row->verifyTime = date("Y-m-d", $row[verifyTime]);
                $PJ_row->type     =  array() ; ; // 人才種類標題
                $PJ_row->skills     =  array() ; ; // 專長
                $PJ_row->key     =  array() ; ; // 關鍵字
                $PJ_row->language  =  array() ;; // 語言能力
                array_push($PJ_List, $PJ_row);
				//解析type
				$type_explode0 = explode(",",$row[type]);
				foreach($type_explode0 as $value){
					$type_explode = explode("_",$value);
					$type_class = new stdClass;
					$type_class->id = $type_explode[0];
					$type_class->title = $type_explode[1];
					$type_class->content = $type_explode[2];
					array_push($PJ_row->type, $type_class);
				}
				//解析keywords
				$key_explode0 = explode(",",$row[keywords]);
				foreach($key_explode0 as $value){
					$key_explode = explode("_",$value);
					$key_class = new stdClass;
					$key_class->id = $key_explode[0];
					$key_class->keyword = $key_explode[1];
					array_push($PJ_row->key, $key_class);
				}
				//解析language
				$language_explode0 = explode(",",$row[language_sum]);
				foreach($language_explode0 as $value){
					$language_explode = explode("_",$value);
					$language_class = new stdClass;
					$language_class->id = $language_explode[0];
					$language_class->type = $language_explode[1];
					$language_class->listen = $language_explode[2];
					$language_class->speak = $language_explode[3];
					$language_class->read = $language_explode[4];
					$language_class->write = $language_explode[5];
					array_push($PJ_row->language, $language_class);
				}
				//解析skill
				$skills_explode0 = explode(",",$row[skill]);
				foreach($skills_explode0 as $value){
					$skills_explode = explode("_",$value);
					$skills_class = new stdClass;
					$skills_class->id = $skills_explode[0];
					$skills_class->value = $skills_explode[1];
					array_push($PJ_row->skills, $skills_class);
				}
            }
              mysql_close($link);
              $json['data'] = $PJ_List;
              echo json_encode($PJ_List);
          }
          break;
	  case 'delete':
          $json['data']       =       $data;
          echo json_encode($json) ;
          break;
    case 'update':

        break;
	  case 'examined_update':
		  $update_obj = $_POST['data'];
      $suggestion = $_POST['data']['suggestion'];
      $examined = $_POST['data']['examined'];
      $PJ_Id = $_POST['data']['id'];
		  $str = "UPDATE `alumnidata`.`Industry_Project_List` SET
				`suggestion` = '".$suggestion."',
				`examined` = '".$examined."',
				`adminer` = '".$user->Mem_Se."',
				`verifyTime` = '".time()."'
		  WHERE (`PJ_Id` = '".$PJ_Id."');";
		  $list = mysql_query($str);
		  if($list === FALSE) { // 資料庫有沒有 FALSE
              $json['error'] = mysql_error();
		  }
		  else{
			  $json['success'] = 'success';
		  }
      $json['postDATA'] = $update_obj;
		  echo json_encode($json);
      // echo var_dump($update_obj->suggestion);
		  break;
    default:
      $json['other'] = "default";
      echo json_encode($update_obj);
      break;
    }
?>
