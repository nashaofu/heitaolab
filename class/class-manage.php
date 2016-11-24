<?php
/**
 * Manage Library v1.1.3
 * 网站管理(支持)类文件
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-3-10T19:30Z
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
class Manage
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

    /** @var 支持表名 */
    private $Table = DB_MANAGE_TABLE;

    /**
     * 连接到数据库
     */
    public function __construct()
    {
        $this->Link = mysqli_connect($this::DBHOST, $this::DBUSER, $this::DBPASSWORD, $this::DBNAME) or die("数据库连接失败！请联系网站管理员进行处理！");
        mysqli_set_charset($this->Link, $this::DBCHARSET);
    }
    /**
     * 发布支持文档
     * @param [type] $title      [description]
     * @param [type] $visibility [description]
     * @param [type] $tag        [description]
     * @param [type] $body       [description]
     */
    public function Publish($title, $visibility, $tag, $body)
    {
        if (!empty($title) && !empty($tag) && !empty($body) && !empty($visibility)) {
            $title      = htmlspecialchars($title, ENT_QUOTES);
            $visibility = htmlspecialchars($visibility, ENT_QUOTES);
            $tag        = htmlspecialchars($tag, ENT_QUOTES);
            $body       = htmlspecialchars($body, ENT_QUOTES);

            if ($visibility === 'true') {
                $visibility = 1;
            } else {
                $visibility = 0;
            }
            $sql = "INSERT INTO {$this->Table} (`Title`,`Visibility`,`Tag`,`Body`,`Time`) VALUES ('$title','$visibility','$tag','$body',now())";
            mysqli_query($this->Link, $sql);
            if (mysqli_affected_rows($this->Link) > 0) {
                $sql                = "select last_insert_id()";
                $query              = mysqli_query($this->Link, $sql);
                $result             = mysqli_fetch_assoc($query);
                $_SESSION['Notice'] = "发布成功！";
                PageJump("{$_SERVER['PHP_SELF']}?s={$result['last_insert_id()']}");
            } else {
                $_SESSION['Notice'] = "发布失败！";
                PageJump("{$_SERVER['PHP_SELF']}");
            }
        }
    }
    /**
     * [Update description]
     * @param [type] $id [description]
     */
    public function Update($id)
    {
        if (!empty($_POST['Title']) && !empty($_POST['Visibility']) && !empty($_POST['Tag']) && !empty($_POST['Body'])) {
            if (empty($_SESSION['ID'])) {
                $_SESSION['Notice'] = "请先登录！";
                return;
            }
            $title      = htmlspecialchars($_POST['Title'], ENT_QUOTES);
            $visibility = htmlspecialchars($_POST['Visibility'], ENT_QUOTES);
            $tag        = htmlspecialchars($_POST['Tag'], ENT_QUOTES);
            $body       = htmlspecialchars($_POST['Body'], ENT_QUOTES);
            if ($visibility === 'true') {
                $visibility = 1;
            } else {
                $visibility = 0;
            }
            $sql   = "UPDATE {$this->Table} SET `Title`='{$title}',`Visibility`='{$visibility}',`Tag`='{$tag}',`Body`='{$body}' WHERE `ID`={$id}";
            $query = mysqli_query($this->Link, $sql);
            if (mysqli_affected_rows($this->Link) > 0) {
                $_SESSION['Notice'] = "更新成功！";
                PageJump("{$_SERVER['PHP_SELF']}?s={$id}");
            } else {
                $_SESSION['Notice'] = "更新失败！";
                PageJump("{$_SERVER['PHP_SELF']}?s={$id}");
            }
        }
    }
    /**
     * 加载管理文档
     * @param [type]  $tag        [description]
     * @param string  $visibility [description]
     * @param integer $offset     [description]
     * @param integer $length     [description]
     * @param string  $sortorder  [description]
     * @param string  $sortord    [description]
     */
    public function Loader($tag, $visibility = 'true', $offset = 0, $length = 50, $sortorder = 'ID', $sortord = 'DESC')
    {
        if (!empty($tag) && !empty($visibility) && is_numeric($offset) && is_numeric($length)) {
            if ($tag == 'ALL') {
                $sql = "SELECT * FROM {$this->Table} where ";
            } else {
                $sql = "SELECT * FROM {$this->Table} where Tag='{$tag}' AND ";
            }
            if ($visibility === 'true') {
                $sql .= "Visibility=1 ";
            }
            if ($visibility === 'false') {
                $sql .= "Visibility=0 ";
            }
            if ($visibility === 'ALL') {
                $sql .= "1 ";
            }
            $sql .= "ORDER BY `{$sortorder}` {$sortord} LIMIT {$offset},{$length}";
            $query  = mysqli_query($this->Link, $sql);
            $manage = array();
            while ($result = mysqli_fetch_assoc($query)) {
                $manage = array_merge_recursive($manage, array($result));
            }
            return $manage;
        }
    }
    /**
     * [LoaderTotal description]
     * @param [type] $tag        [description]
     * @param string $visibility [description]
     */
    public function LoaderTotal($tag, $visibility = 'true')
    {
        if (!empty($tag) && !empty($visibility)) {
            if ($tag == 'ALL') {
                $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where ";
            } else {
                $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where Tag='{$tag}' AND ";
            }
            if ($visibility === 'true') {
                $sql .= "Visibility=1 ";
            }
            if ($visibility === 'false') {
                $sql .= "Visibility=0 ";
            }
            if ($visibility === 'ALL') {
                $sql .= "1";
            }
            if ($query = mysqli_query($this->Link, $sql)) {
                $Total = mysqli_fetch_assoc($query);
                return $Total['Total'];
            } else {
                return $Total['Total'] = 0;
            }
        }
    }
    /**
     * 搜索支持文档
     * @param [type]  $keyword    [description]
     * @param string  $tag        [description]
     * @param integer $visibility [description]
     * @param integer $offset     [description]
     * @param integer $length     [description]
     */
    public function Search($keyword, $tag = 'help', $visibility = 'true', $offset = 0, $length = 20)
    {
        if (!empty($keyword) && !empty($tag) && !empty($visibility) && is_numeric($offset) && is_numeric($length)) {
            $keyword = trim($keyword);
            if ($tag == 'ALL') {
                $sql = "SELECT * FROM {$this->Table} where (Title LIKE '{$keyword}%' or Title LIKE '%{$keyword}%' or Title LIKE '%{$keyword}') AND ";
            } else {
                $sql = "SELECT * FROM {$this->Table} where Tag='{$tag}' AND (Title LIKE '{$keyword}%' or Title LIKE '%{$keyword}%' or Title LIKE '%{$keyword}') AND ";
            }
            if ($visibility === 'true') {
                $sql .= "Visibility=1 ";
            }
            if ($visibility === 'false') {
                $sql .= "Visibility=0 ";
            }
            if ($visibility === 'ALL') {
                $sql .= "1 ";
            }
            $sql .= "ORDER BY HitCount DESC LIMIT {$offset},{$length}";
            $query  = mysqli_query($this->Link, $sql);
            $search = array();
            while ($result = mysqli_fetch_assoc($query)) {
                $result['Body'] = strip_tags(htmlspecialchars_decode($result['Body'], ENT_QUOTES));
                $result['Body'] = mb_strimwidth($result['Body'], 0, 360, '...', 'utf-8');
                $search         = array_merge_recursive($search, array($result));
            }
            return $search;
        }
    }
    /**
     * 搜索到文档总数
     * @param [type] $keyword    [description]
     * @param string $tag        [description]
     * @param string $visibility [description]
     */
    public function SearchTotal($keyword, $tag = 'help', $visibility = 'true')
    {
        if (!empty($keyword) && !empty($tag) && !empty($visibility)) {
            $keyword = trim($keyword);
            if ($tag == 'ALL') {
                $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where (Title LIKE '{$keyword}%' or Title LIKE '%{$keyword}%' or Title LIKE '%{$keyword}') AND ";
            } else {
                $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where Tag='{$tag}' AND (Title LIKE '{$keyword}%' or Title LIKE '%{$keyword}%' or Title LIKE '%{$keyword}') AND ";
            }
            if ($visibility === 'true') {
                $sql .= "Visibility=1 ";
            }
            if ($visibility === 'false') {
                $sql .= "Visibility=0 ";
            }
            if ($visibility === 'ALL') {
                $sql .= "1 ";
            }
            $sql   = trim($sql);
            $query = mysqli_query($this->Link, $sql);
            $total = mysqli_fetch_assoc($query);
            return $total['Total'];
        }
    }
    /**
     * 浏览支持文档
     * @param [type]  $id         [description]
     * @param integer $visibility [description]
     */
    public function Browser($id, $visibility = 1)
    {
        if (!empty($id) && is_numeric($id)) {
            if ($visibility === 0 || $visibility === 1) {
                $sql = "SELECT * FROM {$this->Table} where Visibility={$visibility} AND ID={$id}";
            } elseif ($visibility == 'ALL') {
                $sql = "SELECT * FROM {$this->Table} where ID={$id}";
            } else {
                return array();
            }
            $query  = mysqli_query($this->Link, $sql);
            $result = mysqli_fetch_assoc($query);
            if (!empty($result)) {
                $result['Body'] = htmlspecialchars_decode($result['Body'], ENT_QUOTES);
                $sql            = "UPDATE {$this->Table} SET `HitCount`=HitCount+1  WHERE `ID`='{$id}'";
                $query          = mysqli_query($this->Link, $sql);
                return $result;
            } else {
                return array();
            }
        }
    }
}
