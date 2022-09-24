<?php

function array_ksort(&$array)
{
	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				$array[$k] = array_ksort($v);
			} 
		}
		ksort($array);
	}
	return $array;
}


date_default_timezone_set('UTC');
$nonce = md5(uniqid(rand(), true));
$timestamp = time();
$signType = 'sha256';
$method = 'post';
$client_id = '1657773917587739722';
$client_secret = 'jEJoXFbBmFoHofmjPKoRbyDARjATVkzO';

/* Access Token*/
$tokenString = base64_encode($client_id.':'.$client_secret);
$dataSend['grantType'] = 'client_credentials';
$data = json_encode($dataSend);
$url = "https://sb-oauth.revenuemonster.my/v1/token";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Content-Type: application/json",
   "Authorization: Basic ".$tokenString);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
$responseData = json_decode($resp);



/* Refresh Token*/

$dataSend['grantType'] = 'refresh_token';
$dataSend['refreshToken'] = $responseData->refreshToken;
$data = json_encode($dataSend);
$url = "https://sb-oauth.revenuemonster.my/v1/token";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Content-Type: application/json",
   "Authorization: Basic ".$tokenString);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
$responseData = json_decode($resp);


/* web payment */

//step 1
$orderData['order']['title'] = 'Bigpos';
$orderData['order']['detail'] = '';
$orderData['order']['additionalData'] = 'Bigpos Web Payment';
$orderData['order']['amount'] = 10;
$orderData['order']['currencyType'] = 'MYR';
$orderData['order']['id'] = '000013';
$orderData['customer']['userId'] = '1';
$orderData['customer']['email'] = '';
$orderData['method'] = [];
$orderData['type'] = 'WEB_PAYMENT';
$orderData['storeId'] = '1655778340336287127';
$orderData['redirectUrl'] = 'https://revenuemonster.my';
$orderData['notifyUrl'] = 'https://dev-rm-api.ap.ngrok.io';
$orderData['layoutVersion'] = 'v1';
array_ksort($orderData);
echo "<pre>";
print_r($orderData);
die;

$data =  json_encode($orderData,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG);

$ordData =  $data; 

//step 2
$base64data = base64_encode(json_encode($orderData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG));

//step 3
$arr = array();
$url = 'https://sb-open.revenuemonster.my/v3/payment/online';
array_push($arr, "data=$base64data");
array_push($arr, "method=$method");
array_push($arr, "nonceStr=$nonce");
array_push($arr, "requestUrl=$url");
array_push($arr, "signType=$signType");
array_push($arr, "timestamp=$timestamp");
$privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQBmtf6ITHWIZrJ3ag4X/IRyahs6i4yPaTckMEHFeAtuwgKuuUox
CH503FkwEogAhtVec8Sak+NYf3X7/7KO+ZezimaZyFKVuo+tzSRXY8h4vQyFwhZ+
fqTqUa1sXVDI5gfBOFGowGH5JcHZiDNjsGSSv091s6z6VBnbHiFPnyFVQ2uLImEy
vjZYVNVcSrLRDtfiM9PwoMx6kDgqE+OYkgd5KQwzrxyft2HoYStRq9r3ME1vAE0b
pq7gO9+Pxyi0KI3PIbF4dZo8tq8fvCKUNdhtCdEtwCNIdOcJ53XD8HHhgWusU/4L
CbYb4ftBpnCA5LLLM02rwuJ9AHfoEDO0JmizAgMBAAECggEAJ32mJeWv8wf5amx+
ir5udkdRvMrW+nTr3KApSbGEQ8uYmHFpkzy+0lO+fvtBC2LMOwqr9vsRmH85b/C6
SLqylzeJh2s8RZF7mMmdRXR6KeIWJH+hgnVTFzzcPyQJ4ZSAOsxaqVV+1fqsc+Uo
TRYPNVUVSh4RThZz8om9KQ34FP3dbulhxsisgVLSRQJ2oxhYxbll7UvBo0GhwzA1
ZbOpSnfNrKkj3GMt/Abrr4GlJDCIz5Ue8mZzrwn6umiFOmrxtv5BsQSrJ6c+SIRh
l4RGVYYWz5euNFYUwzhxDF0Je6bY46qSO+CFkwO7ALuZmRw3/V6Np1CZcl8GHE5G
AmSDAQKBgQDJ/Cjcv6sliA/9OUzaJa3JC2fB5p4Sz91+sq5XNTxlX0XRPbXjs3rn
intb/ffZJXSkJlI3vUo0l7bU8+C1el6dw98BxCDKxSe+8Q/Er+KfaOE/BkohqOQb
1zbeueRkyhHp82m9r09D453+p3ER6OYQ6gxv40xd4+6Og8aY9P6+8wKBgQCCLY6H
zOu8NHgX1rTSvaLP1DHPxYStM26/MCNSlMfGkpJhGFMmNrcj9TRi+zhrgB1YX0aI
N4RskrVCzr8DtIOnFC5MotAGBT08YZtByqnYLXZ9vJkUQXcPAoV4Xp07g30yP8xs
jDjlt9X1cgLfjTo3jdFacSEHI1tXBRvsi2WfQQKBgQCBNbHeJS6Sv8uarcEf++KE
LaueOqz8U8TZe+xTFVchciTziYqFsxb4b3oiiwC2BGPtbiZCSfDiW/s1lx00eqd0
PQy30IM5s42NdCAmLm3GlA0jiB58EdJ6jN4o9LnKUAnNo00NbsxCHaXAddS7JEWo
pFB4cuszVNASkvHEf1VHSQKBgCtKPxXF/bbOtAkpa2SRj60RYac4hhCbA/8sYPK7
a1wLrgX/8tbIZ0rb5hnsdSy6pAeZV3lBDRaWCxU2b6spwoYzXdo6Ync+EskbpGfS
n3y2UasqprVnt9IUApKu1BbQeTfWo4KNdvZdlhdTXMU+z9ddn/s1l8gp59weZNTa
3maBAoGATHUchuoFbAbuLDN35XXT2LMXPkg5jUqT8dvfpu0zdgABsV6uyu14v/5V
y42Pob5K5ZMmb+hldM6dcJ/SoZ64lNZrZ6CqlT6HFLiu/DSaWskrx97MFfq7ZBFt
1PAKrtajEj92nr8NAoezJ3umTgEfjxkiWwpkEwuXAEPBNIG/PUA=
-----END RSA PRIVATE KEY-----';

$binary_signature = "";
openssl_sign(join("&", $arr), $binary_signature, $privateKey, $signType);
$sign = base64_encode($binary_signature);
//echo $sign;

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Content-Type: application/json",
   "Authorization: Bearer $responseData->accessToken",
   "X-Signature: sha256 $sign",
   "X-Nonce-Str: $nonce",
   "X-Timestamp: $timestamp", 
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $ordData);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
$responseData = json_decode($resp);
echo "<pre>";
print_r($responseData);
die;

?>