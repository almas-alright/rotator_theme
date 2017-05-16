<?php

// 1. Script Usage
// ----------------------------
/*
  // Requirements:
  //      It is assumed that you have a PHP 5.3+ installation, including libcurl support.
  // Usage:
  //      Modify the values under headings 2. - 4. as required
  //      Only change values inside quotes (" ") on the right side of "=" and "=>" symbols.
  //      Be careful not remove any other characters or formatting.
  //      Standard PHP syntax rules are required.
  // Variable Placement:
  //      There are several variables that you can use in your pre-sell page which will be dynamically placed.
  //      The variables given are:
  //          campaign_id, campaign_name, shipping_price, product_image, redirect_link
  //      To use them, you may place them depending on step1 / step2 as follows:
  //          <?=$step1["redirect_link"]?> - will substitute the step1 redirect link into the page
  //          Similarly, to use step2 variables instead simply use <?=$step2["redirect_link"]?>
 */

// 2. User Variables
// ----------------------------

$affiliate = "381387";
$country = "us";
$vertical = "muscle";

// If a user re-visits a page within the threshold defined below, they will be presented with the same campaign, regardless of current ruleset.
// Choosing a value too small may make your page content inconsistent between page reloads.
$cookieLifetimeInHours = 24;

// By default, a users cookie expiry will be re-calculated after each impression.
// If set to false, the campaign routing decision will expire after $cookieLifetimeInHours, regardless of whether or not the user has recently re-visted the page.
$resetCookieTimerOnRefresh = true;

// 3. Tracking Setup
// ----------------------------
// tracking_link: Set this value to the base url of whatever tracking service you are using.
//      Do not attach any query string values (The part of the url including and after the "?" symbol)
//          Ex. For voluum, this will typically look something like "http://stats.voluumtracker.com/click/1" for step 1 links.
//
//      There are then 2 options for setting up redirects with your tracker:
//
//      1. Script based redirect [Difficulty: Easy, Redirect Latency: Medium]
//          Host the redirect.php script on your server, and follow the installation instructions of that script.
//
//      2. URL based redirector [Difficulty: Medium, Redirect Latency: Low]
//          The URL you place in your tracker will be at least "http://affiliate.jbxroute.com/rd/r.php?", but you will need to add additional passthrough variables.
//          Your tracker must be setup to pass **at least** 3 variables, and up 6 if tracking custom variables is desired.
//          The URL variables that you **NEED** to pass are:
//              "pub", "sid", "bps".
//          Optional variables include:
//              "c1", "c2", "c3"
//          Thus, the final URL in your tracking system may end up looking like: "http://affiliate.jbxroute.com/rd/r.php?pub={pub}&sid={sid}&bps={bps}&c1={c1}&c2={c2}&c3={c3}"
//
// tracking_variables:
//      You may use the values c1, c2, and c3 any way you deem necessary.
//      The values listed below will be passed to the configured tracking_link.
//      You must ensure that your tracking system continues to pass along these variables, using the same names (c1, c2, c3).
//      If you change this from the default value you must ensure that the variables continue to pass from your tracking system back to Jumbleberry.

$step1_setup = array(
    "tracking_link" => "http://stats.playhousetrk.com/click/1",
    "tracking_variables" => array(
        "c1" => @$_GET["c1"],
        "c2" => @$_GET["c2"],
        "c3" => @$_GET["c3"]
    )
);
$step2_setup = array(
    "tracking_link" => "http://stats.playhousetrk.com/click/2",
    "tracking_variables" => array(
        "c1" => @$_GET["c1"],
        "c2" => @$_GET["c2"],
        "c3" => @$_GET["c3"]
    )
);

// 4. Default Campaigns
// ----------------------------
// You do not need to modify this under normal operations.
// The below campaigns will be displayed **only** if the rotator service goes down.

$step1 = array(
    'campaign_id' => '2027',
    'campaign_name' => 'Ronda Rousey',
    'shipping_price' => '4.95',
    'product_image' => 'images/alpha.png',
    'redirect_link' => 'http://affiliate.mediaclicktrker.com/rd/r.php?pub=381387&sid=2027&',
);
$step2 = '381387';

// --------- Modify at own risk
// ----------------------------

header("Expires: Sun, 01 Jan 2010 00:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", FALSE);
header("Pragma: no-cache");

$token = substr(base_convert(md5(strtolower($affiliate . $country . $vertical)), 16, 32), 0, 12);

$ch = curl_init();
$url = "http://affiliate.jbxroute.com/affiliate/" . $affiliate . "/" . $country . "/" . $vertical;
$session = isset($_COOKIE[$token], $_COOKIE[$token . "_lifetime"]) && $cookieLifetimeInHours > 0 ? "bps=" . $_COOKIE[$token] : "";

curl_setopt($ch, CURLOPT_URL, $url . "?" . $session);
curl_setopt($ch, CURLOPT_COOKIE, @$_SERVER["HTTP_COOKIE"] . ";");

if (isset($_SERVER["HTTP_USER_AGENT"]))
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);

if (isset($_SERVER["HTTP_REFERER"]))
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER["HTTP_REFERER"]);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "REMOTE-ADDR: " . $_SERVER["REMOTE_ADDR"],
    "X-FORWARDED-FOR: " . $_SERVER["REMOTE_ADDR"]
));

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);

if ((($response = curl_exec($ch)) && ($responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE)) == "200") || (isset($step1) && is_array($step1))) {

    $response = json_decode($response, true) ?: array("success" => true, "step1" => $step1, "step2" => @$step2);

    if (!is_null($response) && isset($response["success"]) && $response["success"]) {

        foreach (array("step1", "step2") as $step) {
            if (isset($response[$step]))
                ${$step} = $response[$step];

            $config = ${$step . "_setup"};
            if (isset($config)) {
                @parse_str(parse_url(${$step}["redirect_link"], PHP_URL_QUERY), $vars);
                $qm = @is_null(parse_url($config["tracking_link"], PHP_URL_QUERY));
                ${$step}["redirect_link"] = rtrim(rtrim($config["tracking_link"], "&"), "?") .
                        ($qm ? "?" : "&") .
                        http_build_query(array_merge($config["tracking_variables"], $vars));
            }

            setcookie($token . "_" . $step, implode("-", array(@$affiliate, @${$step}["campaign_id"], @${$step}["landing_page"])), time() + 1209600, "/");
        }

        if (isset($response["bps"]))
            setcookie($token, $response["bps"], time() + 1209600, "/");

        if ($resetCookieTimerOnRefresh || !isset($_COOKIE[$token . "_lifetime"]))
            setcookie($token . "_lifetime", time() + intval($cookieLifetimeInHours) * (60 * 60), time() + intval($cookieLifetimeInHours) * (60 * 60), "/");
    }
}

@curl_close($ch);

function get_step($step) {
    if ($step == "1") {
        return $out1 = $GLOBALS['step1'];
    } elseif ($step == "2") {
        return $out1 = $GLOBALS['step2'];
    }
}

function deft_image($atts) {
    $a = shortcode_atts(array(
        'step' => '1',
        'class' => 'something else',
            ), $atts);
    $out1 = get_step($a['step']);
    ob_start();
    echo '<img src="' . $out1["product_image"] . '" alt="" class="' . $a['class'] . '" />';
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

add_shortcode('step-img', 'deft_image');

function deft_link($atts){
//    $step1["redirect_link"]
    $a = shortcode_atts(array(
        'step' => '1',
        'title' => 'Link',
        'class' => 'something else',
            ), $atts);
    $out1 = get_step($a['step']);
    if($a['title'] == 'Link'){
       $a['title'] = $out1["campaign_name"];  
    }
    ob_start();
    echo '<a href="' . $out1["redirect_link"] . '" alt="" class="' . $a['class'] . '">'.$a['title'].'</a>';
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}
add_shortcode('step-a', 'deft_link');

function deft_title($atts){
//    $step1["redirect_link"]
    $a = shortcode_atts(array(
        'step' => '1',
        'after' => '',
        'before' => '',
            ), $atts);
    $out1 = get_step($a['step']);
    
    ob_start();
    echo $a['before'].$out1['campaign_name'].$a['after'];
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}
add_shortcode('step-title', 'deft_title');

?>