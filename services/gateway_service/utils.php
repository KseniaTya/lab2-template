<?php
function curl($url, $head_vars = []){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
function curl_post($url, $post_vars = "", $head_vars = []){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}