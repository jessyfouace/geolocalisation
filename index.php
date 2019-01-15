<?php
function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();

$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$user_ip)); //Connection to ip-api.com server and get data. If site is online, you can change second parameter with $ip
if ($query && $query['status'] == 'success') {
    $query['region'];
    $query['city'];
    $query['org'];
    $query['as'];
    $query['lon'];
    $query['lat'];
    $query['isp'];
    $query['zip'];
    $query['timezone'];
    $query['country'];
    $query['countryCode'];
    $query['regionName'];
}

echo $query['city'];
