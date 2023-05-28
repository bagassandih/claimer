<?php
date_default_timezone_set("Asia/Jakarta");
//MODUL
function post($link,$data,$ua){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    return curl_exec($ch);
  }
function get($link,$ua){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  curl_setopt($ch, CURLOPT_HEADER,0);
	  
    return curl_exec($ch);
  }
  function Save($namadata){
   if(file_exists($namadata)){
     $data = file_get_contents($namadata);
    }else{
     $data = readline("Input ".$namadata." :  ");
     file_put_contents($namadata,$data);
    }
    return $data;
  }
 
  function tim($tim){
  for($i=$tim; $i>0; $i--){
    echo "Tunggu ".gmdate("H:i:s", $i)." detik";
    sleep(1);
    echo "                                                                      \r";
  }
  return $i;
  }
  $user=save("user-agent");
  $cook=save("Cookie");
  $ua=array("Host: adsyou.biz","X-Requested-With: XMLHttpRequest", "user-agent: $user","cookie: $cook");
  $res=get("https://adsyou.biz/dashboard",$ua);
  $bal=explode('</div>',explode('<div class="fw-bold">',$res)[1])[0];
  $use=explode('</b>',explode('id="greeting"></span> <b>',$res)[1])[0];
  $count=explode('</div>', explode('<div class="fw-bold">',$res)[3])[0];

  echo "===================================\n";
  echo "| - Username : ".$use."\n";
  echo "| - Balance : ".$bal."\n";
  echo "| - Total Claim: ".$count."x\n";
  echo "===================================\n";

again:
  $res=get("http://adsyou.biz/auto/currency/matic", $ua);
  $token=explode('"', explode('name="token" value="', $res)[1])[0];
  $tim=explode(',', explode('let timer = ', $res)[1])[0];

  if ($tim){
    tim($tim);
  }

  $data="token=$token";
  $res=post("http://adsyou.biz/auto/verify/matic", $data, $ua);
  $count_update=explode('</div>', explode('<div class="fw-bold">',$res)[3])[0];
  $success = explode("has been sent to your FaucetPay account!'", explode("html: '", $res)[1])[0];
  echo "[".date("d/M/Y")."]:".date("h:i")."\n";
  echo "Profit: ".$success."\n";
  echo "Total Claim: ".$count_update."x\n";
  echo "===================================\n";
goto again;