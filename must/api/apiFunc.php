<?
    include('../PHPMailer_v5.1/class.phpmailer.php');
    include "../db_config.php" ;
    $str = "SELECT A.web_type , A.web_name, A.web_description, A.web_address,
                        B.M_Name
                FROM `Industry_Website` A
                    LEFT JOIN Member B USING(`Mem_Se`) ORDER BY `Web_Id` DESC;";
    $str1 = "SELECT * FROM `Industry_Website` ";
    $list = mysql_query($str);
    if($list === FALSE) {
        die(mysql_error()); // TODO: better error handling
    }
    $webData = array() ;
    $id = 1 ;
    while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
        $now_row = new stdClass;
        $now_row->id    =  $id;
        $now_row->type  =  $row[web_type];
        $now_row->wName  =  $row[web_name];
        $now_row->description  =  $row[web_description];
        $now_row->address  =  $row[web_address];
        $now_row->name  =  $row[M_Name];
        array_push($webData, $now_row);
        $id = $id + 1;
    }
    echo $webData[0]->wName;

    /*
    foreach($webData as $arr){
        foreach($arr as $value){
            echo $value."<br>";
        }
    }
    */
    var_dump($webData);
    mysql_close($link);
/*
    include "../db_config.php" ;
    $web_type[0] = 'test'; // 網頁類別 都是陣列
    $web_name[0] = 'test'; // 網頁名稱
    $web_descr[0] = 'test'; // 網頁描述
    $web_add[0] = 'test'; // 網址
    $user['Mem_Se'] = 'test';
    $i = 0;
    $str="INSERT into Industry_Website(Mem_Se,web_type,web_name,web_description,web_address) values('".$user->Mem_Se."','".$web_type[$i]."','".$web_name[$i]."','".$web_descr[$i]."','".$web_add[$i]."')";
    mysql_query($str,$link);
    mysql_close($link);
    */
?>
