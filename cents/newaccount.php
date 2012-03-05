<?php
/*==============DIME===================
(C)2011 Travis Pessetto
Dime is a system designed for the automization
of EHCP user accounts.
=======================================*/

require("./dime-config.php");
require("./objects/adminLogin.php");

//connection currentConnection= new connection();
//currentConnection.doAdminLogin($domain,$username,$password,$cookieFile);

//===========VARIABLES===============
//link to the EHCP home panel.....
$option = "dologin";//should be dologin
$submit = "Login";//Was passed according to Live HTTP headers.

$connection = curl_init($domain);
curl_setopt ($connection, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt ($connection, CURLOPT_RETURNTRANSFER, true);

$fields = array('username'=>urlencode($username),'password'=>urlencode($password),'op'=>urlencode($option),'submit'=>urlencode($submit));

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');

curl_setopt($connection,CURLOPT_URL,$domain);
curl_setopt($connection,CURLOPT_POST,count($fields));
curl_setopt($connection,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt ($connection, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt ($connection, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($connection);

//===NOW GO WITH THE COOKIE====
$connection = curl_init($domain);
curl_setopt($connection,CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($connection,CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($connection);

//===OKAY WE SHOULD BE LOGGED IN...GO MAKE A USER....
$op="addDomain";

$fields = array('domainname'=>urlencode('batmandomain.com'),'panelusername'=>urlencode("batman"),'paneluserpassword'=>urlencode("password"),'ftpusername'=>urlencode('batman'),'ftppassword'=>urlencode('password'),'quota'=>urlencode('100'),'upload'=>urlencode("200"),'download'=>urlencode("200"),'email'=>urlencode("batman@thebatmobilespot.com"),'op'=>urlencode($op),'_insert'=>urlencode("1"));

$fields_string = "";//reset string to prevent previous data.
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');

$connection = curl_init($domain);
curl_setopt($connection,CURLOPT_URL,$domain);
curl_setopt($connection,CURLOPT_POST,count($fields));
curl_setopt($connection,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($connection,CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($connection,CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($connection);

echo $result;

?>
