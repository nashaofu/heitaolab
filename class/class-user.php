<?php
/**
 * User Library v1.1.3
 * 网站用户(账号)类文件
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-1-30T19:30Z
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-crypt.php";
class User
{
    /** 服务器地址 */
    const DBHOST = DB_HOST;

    /** 数据库名 */
    const DBNAME = DB_NAME;

    /** 用户名 */
    const DBUSER = DB_USER;

    /** 密码 */
    const DBPASSWORD = DB_PASSWORD;

    /** 数据库字符集 */
    const DBCHARSET = DB_CHARSET;

    /** @var 数据库链接 */
    private $Link;

    /** @var 用户表名 */
    private $Table = DB_USER_TABLE;

    /**
     * 连接到数据库
     */
    public function __construct()
    {
        $this->Link = mysqli_connect($this::DBHOST, $this::DBUSER, $this::DBPASSWORD, $this::DBNAME) or die("数据库连接失败！请联系网站管理员进行处理！");
        mysqli_set_charset($this->Link, $this::DBCHARSET);
    }

    /**
     * 把信息写入session
     * @param 数组 $parameter 用户信息
     */
    public function Session($parameter)
    {
        $_SESSION['ID']       = $parameter['ID'];
        $_SESSION['Email']    = $parameter['Email'];
        $_SESSION['Name']     = $parameter['Name'];
        $_SESSION['LV']       = $parameter['LV'];
        $_SESSION['XP']       = $parameter['XP'];
        $_SESSION['Points']   = $parameter['Points'];
        $_SESSION['Role']     = $parameter['Role'];
        $_SESSION['Gender']   = $parameter['Gender'];
        $_SESSION['Birthday'] = $parameter['Birthday'];
        if (count(explode(',', $parameter['Area'])) < 2) {
            $parameter['Area'] .= ',未设置';
        }
        $_SESSION['Area']         = $parameter['Area'];
        $_SESSION['Avatar']       = $parameter['Avatar'];
        $_SESSION['Introduction'] = $parameter['Introduction'];
        $_SESSION['Focus']        = $parameter['Focus'];
        $_SESSION['Fans']         = $parameter['Fans'];
        $_SESSION['Focus-Size']   = "0";
        $_SESSION['Fans-Size']    = "0";
    }

    /**
     * 隐藏邮箱
     * @param [type] $Mail [description]
     */
    public function HiddenMail($Mail)
    {
        $before = '';
        $after  = '';
        $star   = 4;
        for ($i = $star; $i < strpos($Mail, "@"); $i++) {
            $before .= '*';
        }
        for ($i = strpos($Mail, "@") + 1; $i < strrpos($Mail, "."); $i++) {
            $after .= '*';
        }
        $str    = $before . '@' . $after . '.';
        $length = strlen($str);
        return substr_replace($Mail, $str, $star, $length);
    }

    /**
     * 用户登录
     * @param [type] $username  [description]
     * @param [type] $password [description]
     */
    public function Login($username, $password)
    {
        if (!empty($username) && !empty($password)) {
            $sql    = "SELECT * FROM `{$this->Table}` WHERE `Email`='{$username}'";
            $query  = mysqli_query($this->Link, $sql); //登录信息查询
            $result = mysqli_fetch_assoc($query);
            if (!empty($result)) {
                /** @var CRYPT 密码加密、解密 */
                $CRYPT = new CRYPT();
                if ($CRYPT->decode($result['Password']) == $password) {
                    $sql = "UPDATE `{$this->Table}` SET `LogTime`=now(),`LogIP`='{$_SERVER['REMOTE_ADDR']}'  WHERE `Email`='{$username}'";
                    //更新最后登录时间和最后登录IP
                    mysqli_query($this->Link, $sql);
                    if (mysqli_affected_rows($this->Link) > 0) {
                        //把数据写入Session，让用户处于登录状态
                        $this->Session($result);
                        if (!empty($_GET['url'])) {
                            PageJump($_GET['url']);
                        } else {
                            PageJump("/user/home.php?id={$_SESSION['ID']}");
                        }
                    } else {
                        $_SESSION['Notice'] = "内部错误，登录失败！";
                    }
                } else {
                    $_SESSION['Notice'] = "密码错误！";
                }
            } else {
                $_SESSION['Notice'] = "用户名不存在！";
            }
        }
    }

    /**
     * 用户注册
     * @param [type] $username  [description]
     * @param [type] $password [description]
     */
    public function Register($username, $password)
    {
        @session_start();
        if ($_SESSION['UserName'] == $username) {
            unset($_SESSION['UserName']);
            //查询记录值是否已经存在了
            $sql   = "SELECT * FROM `{$this->Table}` WHERE `Email`='{$username}'";
            $query = mysqli_query($this->Link, $sql);
            if (empty(mysqli_fetch_assoc($query))) {
                $name = substr($username, 0, strpos($username, "@"));
                $name = substr($name, 0, 12);
                /** @var CRYPT 密码加密、解密 */
                $CRYPT    = new CRYPT();
                $password = $CRYPT->encode($password);
                $sql      = "INSERT INTO `{$this->Table}` (`Email`,`Password`,`Name`,`RegTime`) VALUES ('$username','$password','$name',now())";
                //写入Email、Password、Name、注册时间
                mysqli_query($this->Link, $sql);
                if (mysqli_affected_rows($this->Link) > 0) {
                    $this->Login($username, $CRYPT->decode($password));
                } else {
                    $_SESSION['Notice'] = "内部错误，激活失败！";
                }
            } else {
                $_SESSION['Notice'] = "用户名已经被注册了，您可以直接登录！";
            }
        } else {
            unset($_SESSION['UserName']);
            $_SESSION['Notice'] = "用户名与接收验证码邮箱不一致！";
        }
    }

    /**
     * 用户退出
     */
    public function Logout()
    {
        if (!empty($_SESSION['ID'])) {
            unset($_SESSION['ID']);
            unset($_SESSION['Email']);
            unset($_SESSION['Name']);
            unset($_SESSION['LV']);
            unset($_SESSION['Points']);
            unset($_SESSION['Role']);
            unset($_SESSION['XP']);
            unset($_SESSION['Gender']);
            unset($_SESSION['Birthday']);
            unset($_SESSION['Area']);
            unset($_SESSION['Avatar']);
            unset($_SESSION['Introduction']);
            unset($_SESSION['Focus']);
            unset($_SESSION['Fans']);
            $_SESSION['Notice'] = "当前账号已经退出，正在<a href='/user/login.php'>跳转...</a>";
        } else {
            $_SESSION['Notice'] = "非法操作！";
        }
    }
    /**
     * 取得用户信息
     * @param [type] $id [description]
     */
    public function Getinfo($id)
    {
        if (!empty($id) && is_numeric($id)) {
            $sql    = "SELECT `Name`,`LV`,`Points`,`Gender`,`Birthday`,`Area`,`Avatar`,`Introduction` FROM `{$this->Table}` WHERE `ID`='{$id}'";
            $query  = mysqli_query($this->Link, $sql);
            $result = mysqli_fetch_assoc($query);
            return $result;
        }

    }
    /**
     * 基本信息更新
     */
    public function Update()
    {
        if (!empty($_POST['Name']) && !empty($_POST['Introduction']) && !empty($_POST['Gender']) && !empty($_POST['Birthday']) && !empty($_POST['Area'])) {
            $name         = strip_tags($_POST['Name']);
            $introduction = strip_tags($_POST['Introduction']);
            $gender       = strip_tags($_POST['Gender']);
            $Birthday     = $_POST['Birthday'][0] . '-' . $_POST['Birthday'][1] . '-' . $_POST['Birthday'][2];
            $birthday     = strip_tags($Birthday);
            $area         = str_replace(",", "", $_POST['Area'][0]) . ',' . str_replace(",", "", $_POST['Area'][1]);
            $area         = strip_tags($area);
            $sql          = "UPDATE `{$this->Table}` SET `Name` = '{$name}', `Gender` = '{$gender}', `Birthday` = '{$birthday}', `Introduction` = '{$introduction}', `Area` = '{$area}' WHERE `ID` = {$_SESSION['ID']}";
            mysqli_query($this->Link, $sql);
            $sql    = "SELECT * FROM `{$this->Table}` WHERE `ID` = {$_SESSION['ID']}";
            $query  = mysqli_query($this->Link, $sql);
            $result = mysqli_fetch_assoc($query);
            //更新Session
            $this->Session($result);
            $_SESSION['Notice'] = "保存成功！";
            PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
        }
        //修改头像
        elseif (isset($_FILES['Avatar']) && strlen($_FILES['Avatar']['name']) > 1 && $_POST['Avatar-data']) {
            if ($_FILES["Avatar"]["error"] == 1) {
                $_SESSION['Notice'] = "文件大小超过服务器限制！";
                return;
            }
            if ($_FILES["Avatar"]["error"] == 2) {
                $_SESSION['Notice'] = "文件大小超过HTML表单中MAX_FILE_SIZE限制！";
                return;
            }
            if ($_FILES["Avatar"]["size"] > 5242880) {
                $_SESSION['Notice'] = "文件大于了5M！";
                return;
            }
            //获取图片信息
            $imginfo = getimagesize($_FILES["Avatar"]["tmp_name"]);
            //存储图片类型
            $mime = '';
            if (is_array($imginfo)) {
                $mime = $imginfo["mime"];
            }
            //创建图片资源
            switch ($mime) {
                case 'image/jpeg':
                    $src_image = imagecreatefromjpeg($_FILES["Avatar"]["tmp_name"]);
                    break;
                case 'image/png':
                    $src_image = imagecreatefrompng($_FILES["Avatar"]["tmp_name"]);
                    break;
                case 'image/gif':
                    $src_image = imagecreatefromgif($_FILES["Avatar"]["tmp_name"]);
                    break;
                default:
                    $_SESSION['Notice'] = "不是合法的文件类型！";
                    PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
                    break;
            }
            //解析裁剪数据
            $size = array();
            foreach (explode(',', $_POST['Avatar-data']) as $key => $value) {
                $tmp = explode("=", $value);
                $size += array($tmp[0] => $tmp[1]);
            }
            list($src_width, $src_height) = $imginfo;
            //图片缩放比例
            $ratio = ($src_width / $size['iw'] + $src_height / $size['ih']) / 2;
            //裁剪后图片大小
            $dst_width  = 256;
            $dst_height = 256;
            $src_width  = $size['mw'] * $ratio;
            $src_height = $size['mh'] * $ratio;
            $src_x      = $size['ml'] * $ratio;
            $src_y      = $size['mt'] * $ratio;
            $dst_image  = imagecreatetruecolor($dst_width, $dst_height);
            imagecopyresampled($dst_image, $src_image, 0, 0, $src_x, $src_y, $dst_width, $dst_height, $src_width, $src_height);
            //创建文件名并生成相应格式图片
            switch ($mime) {
                case 'image/jpeg':
                    $filename = $_SESSION['ID'] . time() . ".jpg";
                    $file     = '../user/avatar/' . $filename;
                    imagejpeg($dst_image, $file);
                    break;
                case 'image/png':
                    $filename = $_SESSION['ID'] . time() . ".png";
                    $file     = '../user/avatar/' . $filename;
                    imagepng($dst_image, $file);
                    break;
                case 'image/gif':
                    $filename = $_SESSION['ID'] . time() . ".gif";
                    $file     = '../user/avatar/' . $filename;
                    imagegif($dst_image, $file);
                    break;
                default:
                    $_SESSION['Notice'] = "不是合法的文件类型！";
                    return;
                    break;
            }
            //销毁图片资源
            imagedestroy($src_image);
            imagedestroy($dst_image);
            if (file_exists($file)) {
                $sql = "UPDATE `{$this->Table}` SET `Avatar` = '{$filename}' WHERE `ID` = {$_SESSION['ID']}";
                mysqli_query($this->Link, $sql);
                if (mysqli_affected_rows($this->Link) > 0) {
                    //删除原图片文件
                    if (file_exists('../user/avatar/' . $_SESSION['Avatar']) && $_SESSION['Avatar'] != 'default.jpg') {
                        unlink('../user/avatar/' . $_SESSION['Avatar']);
                    }
                    $_SESSION['Avatar'] = $filename;
                    $_SESSION['Notice'] = "保存成功！";
                } else {
                    $_SESSION['Notice'] = "保存失败！";
                }
            } else {
                $_SESSION['Notice'] = "保存失败！";
            }
            PageJump("{$_SERVER['PHP_SELF']}?id={$_SESSION['ID']}");
        }
    }

    /**
     * 找回密码
     */
    public function SafeResetpwd()
    {
        if (!empty($_POST['UserName'])) {
            $username = $_POST['UserName'];
            $sql      = "SELECT `Email`,`Security` FROM `{$this->Table}` WHERE `Email` = '{$username}'";
            $query    = mysqli_query($this->Link, $sql);
            $result   = mysqli_fetch_assoc($query);
            if (!empty($result)) {
                $_SESSION['ResetMail']  = $username;
                $_SESSION['HiddenMail'] = $this->HiddenMail($username);
                if (!empty($result['Security'])) {
                    $Security              = explode(",", $result['Security']);
                    $_SESSION['SecurityQ'] = $Security[0];
                    $_SESSION['SecurityA'] = $Security[1];
                } else {
                    $_SESSION['SecurityQ'] = "您未设置密保问题，请使用邮箱验证！";
                    $_SESSION['SecurityA'] = "false";
                }
                setcookie("Resetpwd", "type", time() + 3);
                PageJump("{$_SERVER['PHP_SELF']}?resetpwd=type");
            } else {
                $_SESSION['Notice'] = "账号不存在！";
                PageJump("{$_SERVER['PHP_SELF']}");
            }
        } elseif (!empty($_POST['codeText']) && !empty($_SESSION['ResetMail'])) {
            if (!empty($_SESSION['YZM'])) {
                if ($_POST['codeText'] == $_SESSION['YZM']) {
                    if (isset($_SESSION['HiddenMail'])) {
                        unset($_SESSION['HiddenMail']);
                    }
                    if (isset($_SESSION['SecurityQ'])) {
                        unset($_SESSION['SecurityQ']);
                    }
                    if (isset($_SESSION['SecurityA'])) {
                        unset($_SESSION['SecurityA']);
                    }
                    if (isset($_SESSION['YZM'])) {
                        unset($_SESSION['YZM']);
                    }
                    PageJump("{$_SERVER['PHP_SELF']}?resetpwd=reset");
                } else {
                    if (isset($_SESSION['ResetMail'])) {
                        unset($_SESSION['ResetMail']);
                    }
                    if (isset($_SESSION['HiddenMail'])) {
                        unset($_SESSION['HiddenMail']);
                    }
                    if (isset($_SESSION['SecurityQ'])) {
                        unset($_SESSION['SecurityQ']);
                    }
                    if (isset($_SESSION['SecurityA'])) {
                        unset($_SESSION['SecurityA']);
                    }
                    if (isset($_SESSION['YZM'])) {
                        unset($_SESSION['YZM']);
                    }
                    $_SESSION['Notice'] = "验证码错误！";
                    PageJump("{$_SERVER['PHP_SELF']}");
                }
            } else {
                $_SESSION['Notice'] = "请先申请验证码！";
                PageJump("{$_SERVER['PHP_SELF']}?resetpwd=type");
            }
        } elseif (!empty($_POST['securityText']) && !empty($_SESSION['ResetMail'])) {
            if (!empty($_SESSION['SecurityA'])) {
                if ($_SESSION['SecurityA'] != "false") {
                    if ($_POST['securityText'] == $_SESSION['SecurityA']) {
                        if (isset($_SESSION['HiddenMail'])) {
                            unset($_SESSION['HiddenMail']);
                        }
                        if (isset($_SESSION['SecurityQ'])) {
                            unset($_SESSION['SecurityQ']);
                        }
                        if (isset($_SESSION['SecurityA'])) {
                            unset($_SESSION['SecurityA']);
                        }
                        if (isset($_SESSION['YZM'])) {
                            unset($_SESSION['YZM']);
                        }
                        PageJump("{$_SERVER['PHP_SELF']}?resetpwd=reset");
                    } else {
                        if (isset($_SESSION['ResetMail'])) {
                            unset($_SESSION['ResetMail']);
                        }
                        if (isset($_SESSION['HiddenMail'])) {
                            unset($_SESSION['HiddenMail']);
                        }
                        if (isset($_SESSION['SecurityQ'])) {
                            unset($_SESSION['SecurityQ']);
                        }
                        if (isset($_SESSION['SecurityA'])) {
                            unset($_SESSION['SecurityA']);
                        }
                        if (isset($_SESSION['YZM'])) {
                            unset($_SESSION['YZM']);
                        }
                        $_SESSION['Notice'] = "密保答案错误！";
                        PageJump("{$_SERVER['PHP_SELF']}");
                    }
                } else {
                    $_SESSION['Notice'] = "没有设置密保问题！";
                }
            }
        } elseif (!empty($_POST['passwordText'])) {
            $this->SafeModifypwd();
        }
    }

    /**
     * 修改密码
     */
    public function SafeModifypwd()
    {
        if (!empty($_POST['passwordText'])) {
            if (count($_POST['passwordText']) == 2) {
                if ($_POST['passwordText'][0] == $_POST['passwordText'][1]) {
                    /** @var CRYPT 密码加密、解密 */
                    $CRYPT    = new CRYPT();
                    $password = $CRYPT->encode($_POST['passwordText'][0]);
                    $sql      = "UPDATE `{$this->Table}` SET `Password` = '{$password}' WHERE `Email` = '{$_SESSION['ResetMail']}'";
                    mysqli_query($this->Link, $sql);
                    if (isset($_SESSION['ResetMail'])) {
                        unset($_SESSION['ResetMail']);
                    }
                    if (isset($_SESSION['HiddenMail'])) {
                        unset($_SESSION['HiddenMail']);
                    }
                    if (isset($_SESSION['SecurityQ'])) {
                        unset($_SESSION['SecurityQ']);
                    }
                    if (isset($_SESSION['SecurityA'])) {
                        unset($_SESSION['SecurityA']);
                    }
                    if (isset($_SESSION['YZM'])) {
                        unset($_SESSION['YZM']);
                    }
                    PageJump("{$_SERVER['PHP_SELF']}?resetpwd=success");
                } else {
                    $_SESSION['Notice'] = "密码不一致！";
                    PageJump("{$_SERVER['PHP_SELF']}?resetpwd=reset");
                }
            } elseif (count($_POST['passwordText']) == 3) {
                $sql    = "SELECT `Password` FROM `{$this->Table}` WHERE `ID` = {$_SESSION['ID']}";
                $query  = mysqli_query($this->Link, $sql);
                $result = mysqli_fetch_assoc($query);
                if (!empty($result)) {
                    $CRYPT = new CRYPT();
                    if ($CRYPT->decode($result['Password']) == $_POST['passwordText'][0]) {
                        if ($_POST['passwordText'][1] == $_POST['passwordText'][2]) {
                            $password = $CRYPT->encode($_POST['passwordText'][1]);
                            $sql      = "UPDATE `{$this->Table}` SET `Password` = '{$password}' WHERE `ID` = {$_SESSION['ID']}";
                            mysqli_query($this->Link, $sql);
                            $_SESSION['Notice'] = "密码修改成功！";
                            PageJump("{$_SERVER['PHP_SELF']}?safe=modifypwd");
                        } else {
                            $_SESSION['Notice'] = "新密码不一致！";
                            PageJump("{$_SERVER['PHP_SELF']}?safe=modifypwd");
                        }
                    } else {
                        $_SESSION['Notice'] = "原密码错误！";
                        PageJump("{$_SERVER['PHP_SELF']}?safe=modifypwd");
                    }
                }
            }
        }
    }

    /**
     * 密保问题设置
     */
    public function SafeSecurity()
    {
        if (!empty($_POST['codeText']) && !empty($_POST['security'])) {
            if (!empty($_SESSION['YZM'])) {
                if ($_POST['codeText'] == $_SESSION['YZM']) {
                    unset($_SESSION['YZM']);
                    if (!empty($_POST['security'][0]) && $_POST['security'][0] != 'NULL') {
                        if (!empty($_POST['security'][1])) {
                            $Security = $_POST['security'][0] . ',' . $_POST['security'][1];
                            $sql      = "UPDATE `{$this->Table}` SET `Security` = '{$Security}' WHERE `ID` = {$_SESSION['ID']}";
                            mysqli_query($this->Link, $sql);
                            $_SESSION['Notice'] = "设置成功！";
                        } else {
                            $_SESSION['Notice'] = "答案为空，设置失败！";
                        }
                    } else {
                        $_SESSION['Notice'] = "没有选择问题，设置失败！";
                    }
                } else {
                    unset($_SESSION['YZM']);
                    $_SESSION['Notice'] = "验证码错误！";
                }
            } else {
                unset($_SESSION['YZM']);
                $_SESSION['Notice'] = "未申请验证码，请先申请！";
            }
            PageJump("{$_SERVER['PHP_SELF']}?safe=security");
        }
    }
}
