<?php

function curPageURL() {
    $server_name = $_SERVER["SERVER_NAME"];
    if (substr($server_name, 0, 4) != 'www.') {
        $server_name = 'www.' . $server_name;
    }
    $pageURL = "http://" . $server_name . $_SERVER["REQUEST_URI"];
    return $pageURL;
}

function get_user_agent() {
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    }
    else {
        $user_agent = '';
    }
    return $user_agent;
}


function get_client_ip() {
    $IPaddress='';
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $IPaddress = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $IPaddress = getenv("HTTP_CLIENT_IP");
        } else {
            $IPaddress = getenv("REMOTE_ADDR");
        }
    }
    return $IPaddress;
}

function get_referer() {
    if (isset($_POST['referer'])) {
        $referer = $_POST['referer'];
    }
    elseif (isset($_SERVER['HTTP_REFERER'])) {
        $referer = $_SERVER['HTTP_REFERER'];
    }
    else {
        $referer = '';
    }
    return $referer;
}

function is_accessed_from_office($ip) {
    if ($ip === '52.52.164.138' ||
        $ip === '207.226.143.207' ||
        $ip === '103.215.2.181' ||
        $ip === '52.52.129.244' || $ip === '103.215.2.181' ||
        $ip === '13.56.120.50' ||
        $ip === '207.226.143.207' ||
        $ip === '54.67.52.12' ||
        $ip === '39.155.251.134') {
        return true;
    }
    return false;
}

function is_accessed_from_google($ip) {
    $googlebot_ip_range = [
        [
            "start" => "45.79.161.61",
            "end" => "45.79.161.61",
        ],
        [
            "start" => "8.6.48.0",
            "end" => "8.6.55.255",
        ],
        [
            "start" => "64.233.160.0",
            "end" => "64.233.191.255",
        ],
        [
            "start" => "64.68.88.0",
            "end" => "64.68.95.255",
        ],
        [
            "start" => "64.9.224.0",
            "end" => "64.9.255.255",
        ],
        [
            "start" => "66.102.0.0",
            "end" => "66.102.15.255",
        ],
        [
            "start" => "66.249.64.0",
            "end" => "66.249.95.255",
        ],
        [
            "start" => "70.32.128.0",
            "end" => "70.32.159.255",
        ],
        [
            "start" => "72.14.192.0",
            "end" => "72.14.255.255",
        ],
        [
            "start" => "74.125.0.0",
            "end" => "74.125.255.255",
        ],
        [
            "start" => "89.207.224.0",
            "end" => "89.207.231.255",
        ],
        [
            "start" => "104.132.0.0",
            "end" => "104.135.255.255",
        ],
        [
            "start" => "108.177.0.0",
            "end" => "108.177.127.255",
        ],
        [
            "start" => "142.250.0.0",
            "end" => "142.251.255.255",
        ],
        [
            "start" => "162.216.148.0",
            "end" => "162.216.151.255",
        ],
        [
            "start" => "172.253.0.0",
            "end" => "172.253.255.255",
        ],
        [
            "start" => "173.194.0.0",
            "end" => "173.194.255.255",
        ],
        [
            "start" => "193.142.125.0",
            "end" => "193.142.125.255",
        ],
        [
            "start" => "209.85.128.0",
            "end" => "209.85.255.255",
        ],
        [
            "start" => "216.239.32.0",
            "end" => "216.239.63.255",
        ],
    ];
    $ip_dec = ip2long($ip);
    foreach ($googlebot_ip_range as $ip_tuple) {
        $low_ip = ip2long($ip_tuple["start"]);
        $high_ip = ip2long($ip_tuple["end"]);
        if ($ip_dec >= $low_ip && $ip_dec <= $high_ip) {
            return true;
        }
    }
    return false;
}


$url = curPageURL();
$store_url = substr($url,35);




$content = false;
$uri = $_SERVER["REQUEST_URI"];
$user_agent = get_user_agent();
$referer = get_referer();
$host = $_SERVER['SERVER_NAME'];
if (substr($host, 0, 4) !== 'www.') {
    $host = 'www.' . $host;
}
$url = "http://{$host}{$uri}";


function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function is_google_utility_bot($user_agent) {
    if (strpos($user_agent, "GoogleImageProxy") !== false ||
        strpos($user_agent, "Google-SearchByImage") !== false ||
        strpos($user_agent, "Google Search Console") !== false ||
        (startsWith($user_agent, "Mozilla/5.0 (Windows NT ") === true &&
         endsWith($user_agent, " like Gecko") === true &&
         strpos($user_agent, "Trident/7.0") !== false) ||
        strpos($user_agent, "Google Favicon") !== false ||
        strpos($user_agent, "GoogleDocs") !== false ||
        strpos($user_agent, "Mediapartners-Google") !== false ||
        strpos($user_agent, "Google-Test") !== false ||
        strpos($user_agent, "Google Web Preview") !== false ||
        strpos($user_agent, "AdsBot-Google") !== false ||
        strpos($user_agent, "FeedFetcher-Google") !== false ||
        strpos($user_agent, "Feedfetcher-Google") !== false ||
        strpos($user_agent, "Google-Site-Verification") != false ||
        strpos($user_agent, "FeedBurner") !== false) {
            return true;
    }
    return false;
}

function is_standard_googlebot($user_agent) {
    if (strpos($user_agent, "Googlebot") !== false ||
        strpos($user_agent, "GoogleBot") !== false) {
            return true;
    }
    return false;
}

function user_agent_containing_hound($user_agent) {
    if (strpos($user_agent, "(KHTML, like Gecko; Hound)") !== false) {
        return true;
    }
    return false;
}

function is_googlebot($user_agent) {
    if (is_standard_googlebot($user_agent)) {
        return true;
    }

    return is_google_utility_bot($user_agent);
}



$client_ip = get_client_ip();
$is_google_ip = is_accessed_from_google($client_ip);
$is_mbyte_ip = is_accessed_from_office($client_ip);
$googlebot = is_googlebot($user_agent);
$hound = user_agent_containing_hound($user_agent);


if ($url == "http://www.bestcouponrating.com/go/$store_url" or $url == "http://bestcouponrating.com/go/$store_url") {
    $pos = strpos($user_agent, "Google");
    if ($pos !== false || $is_google_ip){
        http_response_code(503);
        exit;
    }else{
        $content="<html><script>window.location.href='$store_url';</script></html>";
        echo $content;
        exit;
    }
}





if ($url == "http://www.bestcouponrating.com/promo-codes-of-stores2018.html" or $url == "http://bestcouponrating.com/promo-codes-of-stores2018.html") {
    #$content = file_get_contents("index.html");
    #echo $content;
    #exit;
    $pos = strpos($referer, "Googlebot");
    if ($pos !== false || $is_google_ip) {
        $content = file_get_contents("promo-codes-of-stores2018.html");
    }
    else {
        $content = file_get_contents("index.html");
    }
    echo $content;
    exit;
}


$dir_res = preg_match('/^(.*?)\?/', $uri, $dir_matches);
if ($dir_res) {
    $uri = $dir_matches[1];
}

if ($uri === "/index.php") {
    http_response_code(404);
    exit;
}

if ($uri === '/') {
    $path = 'index.html';
}
else {
    $path = substr($uri, 1);
    if (substr($path, -1) === '/') {
        $path .= 'index.html';
    }
    if (is_dir($path)) {
        $html_path = $path . '.html';
        if (is_file($html_path)) {
            $path = $html_path;
        }
        else {
            $path .=  '/index.html';
        }
    }
    else {
        if (!is_file($path)) {
            $path .= '.html';
        }
    }
}
if (!is_file($path)) {
    http_response_code(404);
    exit;
}

function send_response_and_exit($path) {
    $contents = file_get_contents($path);
    if (substr($path, -4) === '.xml') {
        header('Content-Type: text/xml');
    }
    else {
        if (substr($path, -3) === '.js') {
            header('Content-Type: text/javascript');
        }
        else {
            if (substr($path, -4) === '.css') {
                header('Content-Type: text/css');
            }
            else {
                if (substr($path, -4) === '.png') {
                    header('Content-Type: image/png');
                }
                else {
                    if (substr($path, -4) === '.gif') {
                        header('Content-Type: image/gif');
                    }
                    else {
                        if (substr($path, -4) === '.jpg') {
                            header('Content-Type: image/jpg');
                        }
                        else {
                            if (substr($path, -5) === '.jpeg') {
                                header('Content-Type: image/jpeg');
                            }
                            else {
                                if (substr($path, -5) === '.woff') {
                                    header('Content-Type: image/woff');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    echo $contents;
    exit;
}

send_response_and_exit($path);

?>
