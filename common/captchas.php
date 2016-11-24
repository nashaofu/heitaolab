<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-captchas.php";
$captchas = new Captchas();
$captchas->creatCaptchas();
