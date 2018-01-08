

<?php

    
  


function curl_http_request($url,$data = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FASLE);
    //如果$data不为空,则为POST请求
    if (!empty($data)){ 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error){
        throw new Exception('请求发生错误：' . $error);
    }

    return $output;

    // $resultArr = json_decode($output, true);//将json转为数组格式数据
    // return $resultArr;
}



  $reIP=$_SERVER["REMOTE_ADDR"]; 
    // $url = 'https://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip='.$reIP;
    //  http://ip.taobao.com/service/getIpInfo.php?ip=117.89.35.58
     $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$reIP;
    // $html = file_get_contents($url);
    // echo $html;
    $json = curl_http_request($url);
   // echo  json_encode($json);
    // var_dump($json);
    echo $json;