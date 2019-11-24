<?
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
    switch ($methods) {
      case 'insert':
          $str = "";
