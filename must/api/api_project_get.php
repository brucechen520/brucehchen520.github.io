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
    $whereString = "";
    $wherefirst = true;
    if($param->status !== null && $param->status !== ''){
      $whereString = "WHERE (pList.status = '".$param->status."'";
      $wherefirst = false;
    }
    if($param->Mem_Se != null){
      if($param->Mem_Se == 'auto')
        $param->Mem_Se = $user->Mem_Se;
      if($wherefirst){
        $whereString = "WHERE (pList.Mem_Se = '".$param->Mem_Se."'";
        $wherefirst = false;
      }
      else
        $whereString .= " && pList.Mem_Se = '".$param->Mem_Se."'";
    }
    if(!$wherefirst)
      $whereString .= ")";

    $str = "SELECT *,mTable.M_Name FROM alumnidata.`Industry_Project_List` AS pList LEFT JOIN `alumnidata`.`Member` AS mTable ON pList.Mem_Se = mTable.Mem_Se ".$whereString;
    $PJ_List = array() ; // 專案基本
          $L_List = array() ; // 語言
          $K_List = array() ; // 關鍵字
          $Sk_List = array() ; // 專長
          $TP_List = array() ; // 類型

        //   $str = "SELECT li.*, GROUP_CONCAT(DISTINCT CONCAT(t.serial,'_',t.PJ_Title,'_',PJ_Type) SEPARATOR ',') as type,
        //               GROUP_CONCAT(DISTINCT CONCAT(sk.serial,'_',sk.PJ_Skill) SEPARATOR ',') as skill,
        //               GROUP_CONCAT(DISTINCT CONCAT(kw.serial,'_',kw.PJ_KeyWords) SEPARATOR ',') as keywords,
        //               GROUP_CONCAT(DISTINCT CONCAT(lang.serial,'_',lang.PJ_Language ,'_', lang.listen ,'_', lang.speak ,'_', lang.read, '_', lang.write) SEPARATOR ', ') as language_sum
        //               FROM alumnidata.Industry_Project_List AS li
        //               LEFT JOIN alumnidata.Industry_Project_KeyW AS kw ON li.PJ_Id = kw.PJ_Id
        //               LEFT JOIN alumnidata.Industry_Project_Language AS lang ON li.PJ_Id = lang.PJ_Id
        //               LEFT JOIN alumnidata.Industry_Project_Skill AS sk ON li.PJ_Id = sk.PJ_Id
        //               LEFT JOIN alumnidata.Industry_Project_Type AS t ON li.PJ_Id = t.PJ_Id
        //               ".$whereString."'
        //               GROUP BY PJ_Id ;";
          $list = mysql_query($str);
          if($list === FALSE) { // 資料庫有沒有 FALSE
              $json['error'] = mysql_error();
              echo json_encode($json);
          } else{
            while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                $PJ_row = new stdClass;
                $PJ_row->id  =  $row[PJ_Id];
                $PJ_row->M_Name = $row[M_Name];
                $PJ_row->project_Name  =  $row[PJ_Name];
                $PJ_row->description  =  $row[PJ_Description];
                $PJ_row->offer  =  $row[PJ_Budget];
                $PJ_row->deadline  =  $row[PJ_TTL];
                $PJ_row->company_Name = $row[CP_Name];
                $PJ_row->company_Website = $row[CP_Website];
                $PJ_row->contact_Name  =  $row[CT_Man];
                $PJ_row->contact_Mail  =  $row[CT_Mail];
                $PJ_row->contact_Phone  =  $row[CT_Phone];
                $PJ_row->status  =  $row[status]; 
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
              
			  $data = new stdClass();
			  $data->list = $PJ_List;
			  $data->totalCount = count($PJ_List);
			  $result = new stdClass();
        $result->code = 'success';
        $result->SQL = $str;
			  $result->data = $data;
              echo json_encode($result);
          }
?>
