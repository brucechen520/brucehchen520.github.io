<?

    include "../db_config.php" ;
    $methods = $_GET['methods'];
    switch ($methods) {
      case 'insert':

          break;
      case 'select':
          $data = array() ;
          $str = "SELECT * FROM `Industry_Permit`";
          $list = mysql_query($str);
          if($list === FALSE) {
              $json['error'] = mysql_error();
              echo json_encode($json);
          }
          while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
              $now_row = new stdClass;
              $now_row->Permit_Id  =  $row[Permit_Id];
              $now_row->Permit_Value  =  $row[Permit_Value];
              array_push($data, $now_row);
          }
          mysql_close($link);
          echo json_encode($data);
          break;
      case 'delete':


          break;
      case 'update':

          break;
      default:
        $json['other'] = "default";
        echo json_encode($json);
        break;
    }

?>
