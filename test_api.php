<?php

$url         = "http://telas/index.php?route=api/login";
$params      = array(
                'key=10VYdOd32nPXpEMt1cdobshN943VGkXUcMRg7p1SR6Cnh4OAkoWTiddOjxpMZyl37uCscosf2RNRYFdt2fZnBxJ4fRjfThUb1qwkCuSq1Etn7D1l4Y4wys6tRXmlzXH9r2hdBrDAtJbiPmrdwOr4P6jTwkX2xVbAkNqphII9Cm5Da8QfoAEkdxmtSmPACUfegfdmQ8YeNdSx14DHjpL89V4EZxfZOcU9abIz4ijXyDsTf3X5GQUgSk1nTlLc0wgj'
                ); // this array can contain the any number of parameter you need to send
$params[]    = 'username=Default';
// $params[] = 'api_token=0';
$parameters  = implode('&', $params);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POST, count($parameters));
curl_setopt($ch,CURLOPT_POSTFIELDS, $parameters);
//execute post
$result = curl_exec($ch);
//close connection
curl_close($ch);

$response   = json_decode($result);
$api_token  = $response->api_token;

// ahora entro a la API de los productos . . .. .

var_dump($api_token);


$url         = "http://telas/index.php?route=api/product/addproduct";
$params      = array(
                'key=10VYdOd32nPXpEMt1cdobshN943VGkXUcMRg7p1SR6Cnh4OAkoWTiddOjxpMZyl37uCscosf2RNRYFdt2fZnBxJ4fRjfThUb1qwkCuSq1Etn7D1l4Y4wys6tRXmlzXH9r2hdBrDAtJbiPmrdwOr4P6jTwkX2xVbAkNqphII9Cm5Da8QfoAEkdxmtSmPACUfegfdmQ8YeNdSx14DHjpL89V4EZxfZOcU9abIz4ijXyDsTf3X5GQUgSk1nTlLc0wgj'
                ); // this array can contain the any number of parameter you need to send
$params[]    = 'username=Default';
$params[] = 'api_token=' . $api_token;
$parameters  = implode('&', $params);


$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POST, count($parameters));
curl_setopt($ch,CURLOPT_POSTFIELDS, $parameters);
//execute post
$result = curl_exec($ch);
//close connection
curl_close($ch);

$response   = json_decode($result);

var_dump($response);
die();



// $api_token  = $response->api_token;








// $url = "http://telas/index.php?route=api/product/getall&api_token=".$api_token;
// $post = array (
// );
// $curl = curl_init($url);
// $raw_response = curl_exec( $curl );
// curl_close($curl);

// echo 'JUAMPA';
// var_dump($raw_response);


// die();









