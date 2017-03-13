<?php
header("Content-type:text/html;charset=utf-8");

$dir = isset($_GET['dir']) ? $_GET['dir'].'/' : '';

$host = $_SERVER['HTTP_HOST']."/LocalQrCode";
$upload_dir = "/uploads/";
$url = '..'.$upload_dir.$dir;

$file=scandir($url);
$new_list = array();
foreach($file as $key=>$vo){
    $new_list[$key]['name']=$dir.$vo;
    $new_list[$key]['is_dir']=pathinfo($vo, PATHINFO_EXTENSION) ? 0 : 1;
    $new_list[$key]['date']=filemtime($url.$vo);
    $new_list[$key]['qrcode'] = '';
    if(!$new_list[$key]['is_dir']){
        $new_list[$key]['qrcode'] = './QrCode.php?host='.$host.$upload_dir.$dir.'&id='.$vo;
    }
}
unset($new_list[0]);
unset($new_list[1]);

$new_list = array_sort($new_list,'date');


function array_sort($arr, $keys, $type = 'desc') {
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <title>Apk list</title>
</head>
<body>
<style>
    h1{
        text-align: center;
    }
    div{
        display: block;
        margin:3%;
        height:110px;
        text-align: left;
        text-indent:20%
        color:#333;
        line-height: 30px;
        font-size:20px;
        overflow: hidden;
        border-bottom:1px solid #ccc;
        position: relative;
    }
    div img{ max-width:100px;
        position: absolute;right:10px; top:0px;}
</style>
<h1>Apk list</h1>
<?php
foreach($new_list as $key=>$vo){
    if($vo['name']!='.' && $vo['name']!='..'){
        $href='';
        if($vo['is_dir'])
            $href =  "onclick=\"window.location.href='?dir={$vo['name']}'\" ";
        echo "<div {$href}> {$vo['name']} <br />".date('Y-m-d H:i:s',$vo['date'])." <img src = '{$vo['qrcode']}' /></div>";
    }
}
?>

</body>
</html>
