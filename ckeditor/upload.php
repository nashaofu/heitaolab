<?php
/*
$upload_config=array(
'document'=>array(
'directory'=>'/uploads/document/'.date('Ymd',time()).'/',
'maxsize' => 5000,
'type' => array('doc','docx','pdf','xls','ppt','txt')
),
'flash'=>array(
'directory'=>'/uploads/flash/'.date('Ymd',time()).'/',
'maxsize' => 8000,
'type' => array('swf')
),
'image'=>array(
'directory'=>'/uploads/image/'.date('Ymd',time()).'/',
'maxsize' => 2000,
'type' => array('bmp','gif','jpg','jpe','png')
),
'music'=>array(
'directory'=>'/uploads/music/'.date('Ymd',time()).'/',
'maxsize' => 5000,
'type' => array('mp3','wav')
),
'video'=>array(
'directory'=>'/uploads/video/'.date('Ymd',time()).'/',
'maxsize' => 8000,
'type' => array('mp4','webm')
),
'zip'=>array(
'directory'=>'/uploads/zip/'.date('Ymd',time()).'/',
'maxsize' => 8000,
'type' => array('zip','7z','rar')
)
);
 */
@session_start();
$upload_dir = array(
    'image'      => '/uploads/image/' . date('Ymd', time()) . '/',
    'flash'      => '/uploads/flash/' . date('Ymd', time()) . '/',
    'attachment' => '/uploads/attachment/' . date('Ymd', time()) . '/',
);

$imageset = array(
    'maxsize' => 2000,
    'type'    => array('bmp', 'gif', 'jpg', 'jpe', 'png'),
);

$flashset = array(
    'maxsize' => 8000,
    'type'    => array('swf', 'wmv'),
);

$attachmentset = array(
    'maxsize' => 10000,
    'type'    => array('zip', '7z', 'rar', 'bmp', 'gif', 'jpg', 'jpe', 'png', 'swf', 'wmv'),
);
/**
 * 文件存在且RENAME_F为1时，重命名文件为(name_1.ext, name_2.ext, ..)
 * 否则覆盖文件
 */
define('RENAME_F', 1);
/**
 * 返回结果函数
 * @param [type] $url [description]
 * @param [type] $msg [description]
 */
function RTURN($url, $msg)
{
    @header('Content-type: text/html; charset=utf-8');
    $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
    echo "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg');</script>";
    exit;
}
/** @var 返回内容 [description] */
$url = '';
$msg = '';
if (isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) {
    if (empty($_SESSION['ID'])) {
        if (!empty($_GET['tag'])) {
            $msg = '请先登录';
            die('<script>window.parent.alert("' . $msg . '");window.parent.iframe.src="dialog.html";</script>');
        } else {
            $msg = '请先登录';
            die('<script>window.parent.alert("' . $msg . '");window.parent.iframe.src="dialog.html";</script>');
        }
    }
    if (empty($_GET['type'])) {
        $msg = '请使用工具栏上传！';
        RTURN($url, $msg);
    }
    if ($_FILES['upload']['error'] == 1) {
        $msg = '文件大小超过服务器设置限制,请上传小于' . ini_get('upload_max_filesize') . '的文件！';
        RTURN($url, $msg);
    }
    if ($_FILES['upload']['error'] == 2) {
        $msg = '文件大小超过HTML表单中MAX_FILE_SIZE限制！';
        RTURN($url, $msg);
    }
    //获取服务器地址
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }
    $site = $protocol . $_SERVER['SERVER_NAME'] . '/';
    //获取后缀名
    $sepext = explode('.', strtolower($_FILES['upload']['name']));
    $type   = end($sepext);

    /**
     * 文件检验函数
     * @param  [type] $type [description]
     * @param  [type] $set  [description]
     * @return [type]       [description]
     */
    function fset($f_type, $set)
    {
        $m = '';
        if (in_array($f_type, $set['type'])) {
            if ($_FILES['upload']['size'] > $set['maxsize'] * 1000) {
                $m = '文件大小超过了: ' . $set['maxsize'] . ' KB.';
            }
        } else {
            $m = '仅支持';
            foreach ($set['type'] as $key => $value) {
                if ($key < count($set['type']) - 1) {
                    $m .= $value . ',';
                } else {
                    $m .= $value . '类型文件';
                }
            }
        }
        return $m;
    }
    //设置文件存储路径，并检查文件
    if (!empty($_GET['tag']) && $_GET['tag'] == 'example') {
        if ($_GET['type'] == 'image') {
            $msg = fset($type, $imageset);
            if (empty($msg)) {
                $upload_dir = $upload_dir['image'];
            } else {
                die('<script>window.parent.alert("' . $msg . '");window.parent.iframe.src="dialog.html";</script>');
            }
        } else {
            $msg = '不支持的上传方式！';
            die('<script>window.parent.alert("' . $msg . '");window.parent.iframe.src="dialog.html";</script>');
        }
    } else {
        switch ($_GET['type']) {
            case 'image':
                $msg = fset($type, $imageset);
                if (empty($msg)) {
                    $upload_dir = $upload_dir['image'];
                } else {
                    RTURN($url, $msg);
                }
                break;
            case 'flash':
                $msg = fset($type, $flashset);
                if (empty($msg)) {
                    $upload_dir = $upload_dir['flash'];
                } else {
                    RTURN($url, $msg);
                }
                break;
            case 'attachment':
                $msg = fset($type, $attachmentset);
                if (empty($msg)) {
                    $upload_dir = $upload_dir['attachment'];
                } else {
                    RTURN($url, $msg);
                }
                break;
            default:
                $msg = '不支持的上传方式！';
                RTURN($url, $msg);
                break;
        }
    }

    $upload_dir = trim($upload_dir, '/') . '/';
    //检查是否存在文件夹，没有则创建
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir)) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir, 0777, true);
    }
    //定义文件名(不含后缀名)
    define('F_NAME', preg_replace('/\.(.+?)$/i', '', basename($_FILES['upload']['name'])));
    //设置文件名，看是否已经存在
    function setFName($p, $fn, $ex, $i)
    {
        if (RENAME_F == 1 && file_exists($p . $fn . $ex)) {
            return setFName($p, F_NAME . '_' . ($i + 1), $ex, ($i + 1));
        } else {
            return $fn . $ex;
        }
    }
    $f_name     = setFName($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir, F_NAME, ".$type", 0);
    $uploadpath = $_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir . iconv("utf-8", "gb2312", $f_name);
    //把上传的图片移动到指定文件夹
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
        if (!empty($_GET['tag']) && $_GET['tag'] == 'example') {
            //返回实例上传的Name和URL
            $name = $f_name;
            $url  = $site . $upload_dir . $f_name;
            echo '<script>window.parent.get("' . $name . '","' . $url . '")</script>';
        } else {
            //返回Ckeditor的url和消息
            $url = $site . $upload_dir . $f_name;
            $msg = '';
            RTURN($url, $msg);
        }
    } else {
        $msg = '文件:' . $_FILES['upload']['name'] . '上传失败';
        RTURN($url, $msg);
    }
}
