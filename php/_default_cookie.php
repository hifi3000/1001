<?php

setcookie($main_cookie, "2020", time() + (86400 * 30), "/"); // 86400 = 1 day
$_COOKIE[$main_cookie] = "2020";

setcookie('user', "hifi", time() + (86400 * 30), "/"); // 86400 = 1 day
$_COOKIE['user'] = "hifi";