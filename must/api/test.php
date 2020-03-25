<?
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');
    include "../db_config.php" ;
    include_once '../phpclass.php';
    // $Mail = new MailSender();
    // $json = array();
    // $user = unserialize($_SESSION['mem']);
    // //$ULEVEL = $tmp['ULEVEL'];
    // //$json['ULEVEL'] = $ULEVEL;
    // if(is_object($user)) {
    //   $user->GetMemberData();
    //   $user->GetMemberConfirm();
    // }

    $me = new Member(1);
    $me->GetMemberData();
    $me->GetMemberConfirm();
    $_SESSION['mem'] = serialize($me);
    
    $me->token = "testMan";
    mysql_close($link);
    $json['code'] = 'success';
    $json['data'] = $me;
    echo json_encode($json);
?>
