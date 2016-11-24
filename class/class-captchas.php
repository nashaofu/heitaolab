<?php
/**
 * Captchas Library v1.1.3
 * 验证码类
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-1-30T19:30Z
 */
class Captchas
{
    //定义验证码字母集合
    const CAPTCHAS = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    private $captchas; //验证码

    public function __construct()
    {
        @session_start();
        $this->captchas = str_split($this::CAPTCHAS);
    }

    public function creatCaptchasText()
    {
        $captchasSize = count($this->captchas);
        $key          = rand(0, $captchasSize - 1);
        $this->captchas[$key];
        return $this->captchas[$key];
    }

    public function creatCaptchas()
    {
        //创建画布
        $img = imagecreate(160, 50);
        // 设置背景颜色和文本颜色
        $bg        = imagecolorallocate($img, rand(240, 255), rand(240, 255), rand(240, 255));
        $textcolor = imagecolorallocate($img, rand(0, 150), rand(0, 150), rand(0, 150));

        //创建背景干扰点
        for ($i = 0; $i < rand(600, 700); $i++) {
            $pointcolor = imagecolorallocate($img, rand(150, 240), rand(150, 240), rand(150, 240));
            imagefilledellipse($img, rand(0, 160), rand(0, 50), rand(2, 5), rand(2, 5), $pointcolor);
        }
        //字体文件路径,不可把前面的两个点去掉
        $font         = "../font/arialbd.ttf";
        $captchasText = "";
        $x            = -18;
        for ($i = 0; $i < 4; $i++) {
            $captchas = $this->creatCaptchasText();
            $captchasText .= $captchas;
            $fontSize = rand(20, 25);
            //文字位置
            $x = rand($x + $fontSize + 15, $x - $fontSize + 55);
            $y = rand(12 + $fontSize, 38);
            //使用字体来画出字符串
            imagettftext($img, $fontSize, rand(-30, 30), $x, $y, $textcolor, $font, $captchas);
        }
        $_SESSION['CAPTCHAS'] = $captchasText;
        // 输出图像
        header("Content-type: image/gif");
        imagegif($img);
        //销毁图片，释放资源
        imagedestroy($img);
    }
}
