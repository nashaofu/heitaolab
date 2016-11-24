<?php
header("content-type:text/html;charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/class-article.php";
session_start();
if (empty($_GET['aid']) || (!empty($_GET['aid']) && !is_numeric($_GET['aid']))) {
    $_SESSION['Notice'] = "请求页面错误！";
    RTURN();
}
if (empty($_SESSION['ID'])) {
    $_SESSION['Notice'] = "请先登录！";
    RTURN();
}
if (empty($_SESSION['Role']) || (!empty($_SESSION['Role']) && ($_SESSION['Role'] != 'Admin' && $_SESSION['Role'] != 'Root'))) {
    $_SESSION['Notice'] = '您没有权限浏览该页面！';
    RTURN();
}
if (!empty($_GET['obj']) && isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) {
    if ($_FILES["upload"]["error"] == 1) {
        $_SESSION['Notice'] = "文件大小超过服务器限制！";
        RTURN();
    }
    if ($_FILES["upload"]["error"] == 2) {
        $_SESSION['Notice'] = "文件大小超过HTML表单中MAX_FILE_SIZE限制！";
        RTURN();
    }
    if ($_FILES["upload"]["size"] <= 2000000) {
        switch ($_FILES['upload']["type"]) {
            case 'image/jpeg':
                $src_image = imagecreatefromjpeg($_FILES["upload"]["tmp_name"]);
                $type      = '.png';
                break;
            case 'image/png':
                $src_image = imagecreatefrompng($_FILES["upload"]["tmp_name"]);
                $type      = '.png';
                break;
            case 'gif':
                $src_image = imagecreatefromgif($_FILES["upload"]["tmp_name"]);
                $type      = '.gif';
                break;
            case 'bmp':
                $src_image = imagecreatefromwbmp($_FILES["upload"]["tmp_name"]);
                $type      = '.pmb';
                break;
            default:
                $_SESSION['Notice'] = "请上传'jpg','png','bmp','gif'类型图片！";
                RTURN();
                break;
        }
        //缩放裁剪图片
        $dst_width                    = 800;
        $dst_height                   = 460;
        list($src_width, $src_height) = getimagesize($_FILES["upload"]["tmp_name"]);
        $dst_image                    = imagecreatetruecolor($dst_width, $dst_height);
        imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

        //定义文件名(不含后缀名)
        define('F_NAME', preg_replace('/\.(.+?)$/i', '', basename($_FILES['upload']['name'])));
        //设置文件名，看是否已经存在
        function setFName($p, $fn, $ex, $i)
        {
            if (file_exists($p . $fn . $ex)) {
                return setFName($p, F_NAME . '_' . ($i + 1), $ex, ($i + 1));
            } else {
                return $fn . $ex;
            }
        }
        $upload_dir = '/uploads/image/' . date('Ymd', time()) . '/';
        $dir        = $_SERVER['DOCUMENT_ROOT'] . $upload_dir;
        //检查是否存在文件夹，没有则创建
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $filename = setFName($dir, F_NAME, $type, 0);
        $f_name   = $dir . $filename;
        imagejpeg($dst_image, $f_name);
        imagedestroy($src_image);
        imagedestroy($dst_image);
        if (file_exists($f_name)) {
            $article = new Article();
            //获取服务器地址
            if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            $site               = $protocol . $_SERVER['SERVER_NAME'];
            $id                 = $_GET['aid'];
            $obj                = $_GET['obj'];
            $url                = $site . $upload_dir . $filename;
            $_SESSION['Notice'] = $article->SetCarousel($id, $url);
            if ($_SESSION['Notice'] === '设置成功！') {
                echo "<script>parent.$('#{$obj}').children('#background').hide();alert('{$_SESSION['Notice']}');parent.$('#{$obj}').children('#background').remove();</script>";
            }
        } else {
            $_SESSION['Notice'] = "保存失败！";
        }
    } else {
        $_SESSION['Notice'] = "文件大于了2M！";
    }
}
function RTURN()
{
    if (!empty($_SESSION['Notice'])) {
        $NoticeBox = '<div id="Notice" style="width: 100%;height: 40px;line-height: 40px;background: rgba(250,250,200,0.98);margin: -33px 0;padding: 7px;position: fixed;top: 50%;left: 0;color: red;font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold;text-align: center;border: 1px solid #fff;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-wrap: break-word;word-break: break-all;overflow-wrap: break-word;z-index: 10;">' . $_SESSION['Notice'] . '</div>';
        unset($_SESSION['Notice']);
        die($NoticeBox);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>dialog</title>
    <link rel="stylesheet" type="text/css" href="../article/css/dialog.css">
</head>
<body>
<h3>推荐图片大小为:800&times;460</h3>
<?php SetNotice("2");?>
<form action='<?php echo $_SERVER['PHP_SELF'] . '?obj=container&aid=' . $_GET['aid']; ?>' enctype="multipart/form-data" method="post" target="targetFrame">
    <div class="form-item"><input type="file" name="upload"></div>
    <div class="form-item"><input class="section-btn" type="submit" value="上传到服务器"></div>
</form>
</body>
</html>