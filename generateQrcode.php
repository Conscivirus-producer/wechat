<?php
$access_token = "KTiNB71hRLbj54rDCeiRIPHC7ryyTRU3JqW4SnCsoFql2sph5j5U0FBe8R60DmBWaFficmYdKdIEJhRsuGWUpEf7MxqcXMcXH2UldS9GmjM";
$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 6 }}}';
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$result = https_post($url,$qrcode);
$jsoninfo = json_decode($result,true);
$ticket = $jsoninfo["ticket"];
echo "<p>scene_id : 6</p>";
$imgurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
echo "<img src='".$imgurl."'>";

$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 2 }}}';
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$result = https_post($url,$qrcode);
$jsoninfo = json_decode($result,true);
$ticket = $jsoninfo["ticket"];
echo "<p>scene_id : 2</p>";
$imgurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
echo "<img src='".$imgurl."'>";

$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 3 }}}';
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$result = https_post($url,$qrcode);
$jsoninfo = json_decode($result,true);
$ticket = $jsoninfo["ticket"];
echo "<p>scene_id : 3</p>";
$imgurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
echo "<img src='".$imgurl."'>";

$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 4 }}}';
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$result = https_post($url,$qrcode);
$jsoninfo = json_decode($result,true);
$ticket = $jsoninfo["ticket"];
echo "<p>scene_id : 4</p>";
$imgurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
echo "<img src='".$imgurl."'>";

$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 5 }}}';
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$result = https_post($url,$qrcode);
$jsoninfo = json_decode($result,true);
$ticket = $jsoninfo["ticket"];
echo "<p>scene_id : 5</p>";
$imgurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
echo "<img src='".$imgurl."'>";

function https_post($url, $data = null){
	$curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
	if(!empty($data)){
		curl_setopt($curl,CURLOPT_POST,1);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
	}
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}
?>




















