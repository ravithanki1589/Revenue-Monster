<?php
error_reporting(0);
require __DIR__.'/vendor/autoload.php';

use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Exceptions\ApiException;
use RevenueMonster\SDK\Exceptions\ValidationException;
use RevenueMonster\SDK\Request\WebPayment;
use RevenueMonster\SDK\Request\QRPay;
use RevenueMonster\SDK\Request\QuickPay;

// Initialise sdk instance
$rm = new RevenueMonster([
  'clientId' => '1657773917587739722',
  'clientSecret' => 'jEJoXFbBmFoHofmjPKoRbyDARjATVkzO',
  'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----',
  'isSandbox' => true,
]);

// create Web payment
try {
  $wp = new WebPayment;
  $wp->order->id = '10020';
  $wp->order->title = 'Testing Web Payment';
  $wp->order->currencyType = 'MYR';
  $wp->order->amount = 100;
  $wp->order->detail = '';
  $wp->order->additionalData = '';
  $wp->storeId = "1655778340336287127";
  $wp->redirectUrl = 'https://google.com';
  $wp->notifyUrl = 'https://google.com';
  $wp->layoutVersion = 'v1';

  $response = $rm->payment->createWebPayment($wp);
  echo $response->checkoutId; // Checkout ID
  echo $response->url; // Payment gateway url
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(ValidationException $e) {
  var_dump($e->getMessage());
} catch(Exception $e) {
  echo $e->getMessage();
}


?>