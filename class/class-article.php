<?php
/**
 * Article Library v1.1.3
 * 网站文章(帖子)类文件
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-3-10T19:30Z
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/common/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
class Article
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

    /** @var 机构表名 */
    private $Table = DB_ARTICLE_TABLE;

    /** @var 用户表名 */
    private $Table_User = DB_USER_TABLE;

    /**
     * 连接到数据库
     */
    public function __construct()
    {
        $this->Link = mysqli_connect($this::DBHOST, $this::DBUSER, $this::DBPASSWORD, $this::DBNAME) or die("数据库连接失败！请联系网站管理员进行处理！");
        mysqli_set_charset($this->Link, $this::DBCHARSET);
    }

    /**
     * 发布新闻
     */
    public function Publish()
    {
        if (!empty($_POST['Title']) && !empty($_POST['Input']) && !empty($_POST['Output']) && !empty($_POST['Summary']) && !empty($_POST['Body'])) {
            if (empty($_SESSION['ID'])) {
                $_SESSION['Notice'] = "请先登录！";
                return;
            }
            $title       = htmlspecialchars($_POST['Title'], ENT_QUOTES);
            $Inputarray  = $_POST['Input'];
            $Outputarray = $_POST['Output'];
            $summary     = htmlspecialchars($_POST['Summary'], ENT_QUOTES);
            $body        = htmlspecialchars($_POST['Body'], ENT_QUOTES);

            $example = '';
            if (!empty($_POST['ExampleName']) && is_array($_POST['ExampleName']) && !empty($_POST['ExampleUrl']) && is_array($_POST['ExampleUrl']) && count($_POST['ExampleName']) == count($_POST['ExampleUrl'])) {
                $exampleName = $_POST['ExampleName'];
                $exampleURL  = $_POST['ExampleUrl'];
                $examples    = array();
                $length      = count($exampleName) - 1;
                for ($i = 0; $i <= $length; $i++) {
                    $name       = str_replace(',', '<dot>', htmlspecialchars($exampleName[$i], ENT_QUOTES));
                    $URL        = str_replace(',', '<dot>', htmlspecialchars($exampleURL[$i], ENT_QUOTES));
                    $examples[] = array('name' => $name, 'url' => $URL);
                }
                foreach ($examples as $key => $value) {
                    if ($key < count($examples) - 1) {
                        $example .= $value['name'] . '->' . $value['url'] . ',';
                    } else {
                        $example .= $value['name'] . '->' . $value['url'];
                    }
                }
            }
            $input = "";
            foreach ($Inputarray as $key => $value) {
                if ($key < count($Inputarray) - 1) {
                    $input .= strip_tags(str_replace(",", "", $value)) . ",";
                } else {
                    $input .= strip_tags(str_replace(",", "", $value));
                }
            }
            $output = "";
            foreach ($Outputarray as $key => $value) {
                if ($key < count($Outputarray) - 1) {
                    $output .= strip_tags(str_replace(",", "", $value)) . ",";
                } else {
                    $output .= strip_tags(str_replace(",", "", $value));
                }
            }
            $tag = "";
            foreach ($Inputarray as $Ikey => $inputvalue) {
                foreach ($Outputarray as $Okey => $outputvalue) {
                    if ($Ikey < count($Inputarray) - 1 || $Okey < count($Outputarray) - 1) {
                        $tag .= $inputvalue . '-' . $outputvalue . ",";
                    } else {
                        $tag .= $inputvalue . '-' . $outputvalue;
                    }
                }
            }
            $msg = '';
            if ($_SESSION['Role'] == 'Root' || $_SESSION['Role'] == 'Admin') {
                $filter = 'publish';
                $msg    = "发布成功,且已设置为公开状态！";
            } else {
                $filter = 'pending';
                $msg    = "发布成功,正在等待审核！";
            }
            $sql = "INSERT INTO {$this->Table} (`Title`,`Status`,`Input`,`Output`,`Tag`,`Summary`,`Example`,`Body`,`Time`,`Publisher`) VALUES ('$title','$filter','$input','$output','$tag','$summary','$example','$body',now(),{$_SESSION['ID']})";
            mysqli_query($this->Link, $sql);
            if (mysqli_affected_rows($this->Link) > 0) {
                $sql                = "select last_insert_id()";
                $query              = mysqli_query($this->Link, $sql);
                $result             = mysqli_fetch_assoc($query);
                $_SESSION['Notice'] = $msg;
                PageJump("edit.php?a={$result['last_insert_id()']}");
            } else {
                $_SESSION['Notice'] = "发布失败！";
                PageJump("{$_SERVER['PHP_SELF']}");
            }
        }
    }
    /**
     * 更新机构
     */
    public function Update($id)
    {
        if (!empty($_POST['Title']) && !empty($_POST['Input']) && !empty($_POST['Output']) && !empty($_POST['Summary']) && !empty($_POST['Body'])) {
            if (empty($_SESSION['ID'])) {
                $_SESSION['Notice'] = "请先登录！";
                return;
            }
            $title       = htmlspecialchars($_POST['Title'], ENT_QUOTES);
            $Inputarray  = $_POST['Input'];
            $Outputarray = $_POST['Output'];
            $summary     = htmlspecialchars($_POST['Summary'], ENT_QUOTES);
            $body        = htmlspecialchars($_POST['Body'], ENT_QUOTES);

            $example = '';
            if (!empty($_POST['ExampleName']) && is_array($_POST['ExampleName']) && !empty($_POST['ExampleUrl']) && is_array($_POST['ExampleUrl']) && count($_POST['ExampleName']) == count($_POST['ExampleUrl'])) {
                $exampleName = $_POST['ExampleName'];
                $exampleURL  = $_POST['ExampleUrl'];
                $examples    = array();
                $length      = count($exampleName) - 1;
                for ($i = 0; $i <= $length; $i++) {
                    $name       = str_replace(',', '<dot>', htmlspecialchars($exampleName[$i], ENT_QUOTES));
                    $URL        = str_replace(',', '<dot>', htmlspecialchars($exampleURL[$i], ENT_QUOTES));
                    $examples[] = array('name' => $name, 'url' => $URL);
                }
                foreach ($examples as $key => $value) {
                    if ($key < count($examples) - 1) {
                        $example .= $value['name'] . '->' . $value['url'] . ',';
                    } else {
                        $example .= $value['name'] . '->' . $value['url'];
                    }
                }
            }
            $input = "";
            foreach ($Inputarray as $key => $value) {
                if ($key < count($Inputarray) - 1) {
                    $input .= strip_tags(str_replace(",", "", $value)) . ",";
                } else {
                    $input .= strip_tags(str_replace(",", "", $value));
                }
            }
            $output = "";
            foreach ($Outputarray as $key => $value) {
                if ($key < count($Outputarray) - 1) {
                    $output .= strip_tags(str_replace(",", "", $value)) . ",";
                } else {
                    $output .= strip_tags(str_replace(",", "", $value));
                }
            }
            $tag = "";
            foreach ($Inputarray as $Ikey => $inputvalue) {
                foreach ($Outputarray as $Okey => $outputvalue) {
                    if ($Ikey < count($Inputarray) - 1 || $Okey < count($Outputarray) - 1) {
                        $tag .= $inputvalue . '-' . $outputvalue . ",";
                    } else {
                        $tag .= $inputvalue . '-' . $outputvalue;
                    }
                }
            }
            $msg = '';
            if ($_SESSION['Role'] == 'Root' || $_SESSION['Role'] == 'Admin') {
                $filter = 'publish';
                $msg    = "修改成功,且已设置为公开状态！";
            } else {
                $filter = 'pending';
                $msg    = "修改成功,正在等待审核！";
            }
            $sql = "UPDATE {$this->Table} SET `Title`='{$title}',`Status`='{$filter}',`Input`='{$input}',`Output`='{$output}',`Tag`='{$tag}',`Summary`='{$summary}',`Example`='{$example}',`Body`='{$body}',`Time`=now() WHERE `ID`={$id}";
            mysqli_query($this->Link, $sql);
            if (mysqli_affected_rows($this->Link) > 0) {
                $_SESSION['Notice'] = $msg;
                PageJump("{$_SERVER['REQUEST_URI']}");
            } else {
                $_SESSION['Notice'] = "保存失败！";
                PageJump("{$_SERVER['REQUEST_URI']}");
            }
        }
    }
    /**
     * 加载机构列表
     * $input,$output为数组时必须是数值键值下标
     * @param [type] $input     输入运动值(R、M、G)
     * @param [type] $output    输入运动值(R1-R7、M1-M4、G1-G7)
     * @param [type] $filter    文档状态过滤器(publish,pending,draft)
     * @param [type] $offset    数据库返回结果起始值
     * @param [type] $length    返回记录条数
     * @param [type] $sortorder 排序依据字段
     * @param [type] $sortord   排序方式(正序:DESC,逆序:ASC)
     */
    public function Loader($input, $output, $filter = 'publish', $offset = 0, $length = 50, $sortorder = 'ID', $sortord = 'DESC')
    {
        //函数返回值
        $CallBack = array();
        if (empty($filter) || empty($sortorder) || empty($sortord)) {
            return $CallBack;
        }
        if (!is_numeric($offset) || !is_numeric($length)) {
            return $CallBack;
        }
        $tag = array();
        //把输入$input输出$output合并为tag标签值
        //并存入到$tag中
        if (is_array($input) && is_array($output)) {
            if (empty($input) || empty($output)) {
                return $CallBack;
            }
            //输入$input输出$output都为数组的情况
            foreach ($input as $Ikey => $inputvalue) {
                foreach ($output as $Okey => $outputvalue) {
                    $tag[] = $inputvalue . '-' . $outputvalue;
                }
            }
        } elseif (is_array($input) && !is_array($output)) {
            if (empty($input)) {
                return $CallBack;
            }
            //输入$input为数组,输出$output不是数组的情况
            foreach ($input as $Ikey => $inputvalue) {
                $tag[] = $inputvalue . '-' . $output;
            }
        } elseif (!is_array($input) && is_array($output)) {
            if (empty($output)) {
                return $CallBack;
            }
            //输入$input不是数组,输出$output为数组的情况
            foreach ($output as $Okey => $outputvalue) {
                $tag[] = $input . '-' . $outputvalue;
            }
        } else {
            //输入$input输出$output都不是数组的情况
            $tag[] = $input . '-' . $output;
        }
        //生成sql语句
        if (!empty($filter) && $filter == 'ALL') {
            $sql = "SELECT * FROM {$this->Table} where (";
        } else {
            $sql = "SELECT * FROM {$this->Table} where (Status='$filter') AND (";
        }
        foreach ($tag as $key => $value) {
            if ($key < count($tag) - 1) {
                $sql .= "(Tag LIKE '{$value}%' or Tag LIKE '%{$value}%' or Tag LIKE '%{$value}') OR ";
            } else {
                $sql .= "(Tag LIKE '{$value}%' or Tag LIKE '%{$value}%' or Tag LIKE '%{$value}')) ORDER BY `{$sortorder}` {$sortord} LIMIT {$offset},{$length}";
            }
        }
        if ($query = mysqli_query($this->Link, $sql)) {
            while ($result = mysqli_fetch_assoc($query)) {
                $sql       = "SELECT `Name`,`Avatar` FROM {$this->Table_User} where `ID`={$result['Publisher']}";
                $user      = mysqli_query($this->Link, $sql);
                $Publisher = mysqli_fetch_assoc($user);
                $Exaes     = explode(',', $result['Example']);
                $example   = array('name' => '', 'url' => '');
                $examples  = array();
                foreach ($Exaes as $key => $value) {
                    if (!empty($value)) {
                        $example        = explode('->', $value);
                        $example        = array('name' => htmlspecialchars_decode(str_replace('<dot>', ',', $example[0]), ENT_QUOTES), 'url' => htmlspecialchars_decode(str_replace('<dot>', ',', $example[1]), ENT_QUOTES));
                        $examples[$key] = $example;
                    }
                }
                $result['Title']   = htmlspecialchars_decode($result['Title'], ENT_QUOTES);
                $result['Summary'] = htmlspecialchars_decode($result['Summary'], ENT_QUOTES);
                $result['Tag']     = explode(',', $result['Tag']);
                $result['Example'] = $examples;
                $result['Body']    = htmlspecialchars_decode($result['Body'], ENT_QUOTES);
                $article           = array($Publisher + $result);
                //合并数组
                $CallBack = array_merge_recursive($CallBack, $article);
            }
        }
        return $CallBack;
    }
    /**
     * 搜索机构
     * @param [type]  $id        [description]
     * @param [type]  $title     [description]
     * @param [type]  $input     [description]
     * @param [type]  $output    [description]
     * @param string  $filter    [description]
     * @param integer $offset    [description]
     * @param integer $length    [description]
     * @param string  $sortorder [description]
     * @param string  $sortord   [description]
     */
    public function Search($id, $title, $input, $output, $filter = 'publish', $offset = 0, $length = 50, $sortorder = 'ID', $sortord = 'DESC')
    {
        //函数返回值
        $CallBack = array();
        $id       = trim($id);
        $title    = trim($title);
        if (!empty($id) && is_numeric($id)) {
            $sql = "SELECT * FROM {$this->Table} where ID={$id}";
        } else {
            if ($filter == 'ALL') {
                $sql = "SELECT * FROM {$this->Table} where (Title LIKE '{$title}%' or Title LIKE '%{$title}%' or Title LIKE '%{$title}') AND (Input LIKE '{$input}%' or Input LIKE '%{$input}%' or Input LIKE '%{$input}') AND (Output LIKE '{$output}%' or Output LIKE '%{$output}%' or Output LIKE '%{$output}') ORDER BY `{$sortorder}` {$sortord} LIMIT {$offset},{$length}";
            } else {
                $sql = "SELECT * FROM {$this->Table} where (Title LIKE '{$title}%' or Title LIKE '%{$title}%' or Title LIKE '%{$title}') AND (Input LIKE '{$input}%' or Input LIKE '%{$input}%' or Input LIKE '%{$input}') AND (Output LIKE '{$output}%' or Output LIKE '%{$output}%' or Output LIKE '%{$output}') AND Status='{$filter}' ORDER BY `{$sortorder}` {$sortord} LIMIT {$offset},{$length}";
            }
        }
        if ($query = mysqli_query($this->Link, $sql)) {
            while ($result = mysqli_fetch_assoc($query)) {
                $sql       = "SELECT `Name`,`Avatar` FROM {$this->Table_User} where `ID`={$result['Publisher']}";
                $user      = mysqli_query($this->Link, $sql);
                $Publisher = mysqli_fetch_assoc($user);
                $Exaes     = explode(',', $result['Example']);
                $example   = array('name' => '', 'url' => '');
                $examples  = array();
                foreach ($Exaes as $key => $value) {
                    if (!empty($value)) {
                        $example        = explode('->', $value);
                        $example        = array('name' => htmlspecialchars_decode(str_replace('<dot>', ',', $example[0]), ENT_QUOTES), 'url' => htmlspecialchars_decode(str_replace('<dot>', ',', $example[1]), ENT_QUOTES));
                        $examples[$key] = $example;
                    }
                }
                $result['Title']   = htmlspecialchars_decode($result['Title'], ENT_QUOTES);
                $result['Summary'] = htmlspecialchars_decode($result['Summary'], ENT_QUOTES);
                $result['Tag']     = explode(',', $result['Tag']);
                $result['Example'] = $examples;
                $result['Body']    = htmlspecialchars_decode($result['Body'], ENT_QUOTES);
                $article           = array($Publisher + $result);
                //合并数组
                $CallBack = array_merge_recursive($CallBack, $article);
            }
        }
        return $CallBack;
    }
    /**
     * [SearchTotal description]
     * @param [type]  $id        [description]
     * @param [type]  $title     [description]
     * @param [type]  $input     [description]
     * @param [type]  $output    [description]
     * @param string  $filter    [description]
     * @param integer $offset    [description]
     * @param integer $length    [description]
     * @param string  $sortorder [description]
     * @param string  $sortord   [description]
     */
    public function SearchTotal($id, $title, $input, $output, $filter = 'publish', $offset = 0, $length = 50, $sortorder = 'ID', $sortord = 'DESC')
    {
        //函数返回值
        $CallBack = array();
        if (!empty($id) && is_numeric($id)) {
            $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where ID={$id}";
        } else {
            if ($filter == 'ALL') {
                $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where (Title LIKE '{$title}%' or Title LIKE '%{$title}%' or Title LIKE '%{$title}') AND (Input LIKE '{$input}%' or Input LIKE '%{$input}%' or Input LIKE '%{$input}') AND (Output LIKE '{$output}%' or Output LIKE '%{$output}%' or Output LIKE '%{$output}') ORDER BY `{$sortorder}` {$sortord} LIMIT {$offset},{$length}";
            } else {
                $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where (Title LIKE '{$title}%' or Title LIKE '%{$title}%' or Title LIKE '%{$title}') AND (Input LIKE '{$input}%' or Input LIKE '%{$input}%' or Input LIKE '%{$input}') AND (Output LIKE '{$output}%' or Output LIKE '%{$output}%' or Output LIKE '%{$output}') AND Status='{$filter}' ORDER BY `{$sortorder}` {$sortord} LIMIT {$offset},{$length}";
            }
        }
        if ($query = mysqli_query($this->Link, $sql)) {
            $Total = mysqli_fetch_assoc($query);
            return $Total['Total'];
        } else {
            return $Total['Total'] = 0;
        }
    }
    /**
     * [LoaderTotal description]
     * @param [type] $input  [description]
     * @param [type] $output [description]
     * @param string $filter [description]
     */
    public function LoaderTotal($input, $output, $filter = 'publish')
    {
        $tag = array();
        //把输入$input输出$output合并为tag标签值
        //并存入到$tag中
        if (is_array($input) && is_array($output)) {
            if (empty($input) || empty($output)) {
                return $CallBack;
            }
            //输入$input输出$output都为数组的情况
            foreach ($input as $Ikey => $inputvalue) {
                foreach ($output as $Okey => $outputvalue) {
                    $tag[] = $inputvalue . '-' . $outputvalue;
                }
            }
        } elseif (is_array($input) && !is_array($output)) {
            if (empty($input)) {
                return $CallBack;
            }
            //输入$input为数组,输出$output不是数组的情况
            foreach ($input as $Ikey => $inputvalue) {
                $tag[] = $inputvalue . '-' . $output;
            }
        } elseif (!is_array($input) && is_array($output)) {
            if (empty($output)) {
                return $CallBack;
            }
            //输入$input不是数组,输出$output为数组的情况
            foreach ($output as $Okey => $outputvalue) {
                $tag[] = $input . '-' . $outputvalue;
            }
        } else {
            //输入$input输出$output都不是数组的情况
            $tag[] = $input . '-' . $output;
        }
        //生成sql语句
        if (!empty($filter) && $filter == 'ALL') {
            $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where (";
        } else {
            $sql = "SELECT COUNT(*) AS Total FROM {$this->Table} where (Status='$filter') AND (";
        }
        foreach ($tag as $key => $value) {
            if ($key < count($tag) - 1) {
                $sql .= "(Tag LIKE '{$value}%' or Tag LIKE '%{$value}%' or Tag LIKE '%{$value}') OR ";
            } else {
                $sql .= "(Tag LIKE '{$value}%' or Tag LIKE '%{$value}%' or Tag LIKE '%{$value}'))";
            }
        }
        if ($query = mysqli_query($this->Link, $sql)) {
            $Total = mysqli_fetch_assoc($query);
            return $Total['Total'];
        } else {
            return $Total['Total'] = 0;
        }
    }
    /**
     * [Browse description]
     * @param [type] $id     [description]
     * @param string $filter [description]
     */
    public function Browse($id, $filter = 'publish')
    {
        if (!empty($id) && is_numeric($id)) {
            $sql = "SELECT * FROM {$this->Table} where ID={$id} AND Status='{$filter}'";
            if (!empty($filter) && $filter == 'ALL') {
                $sql = "SELECT * FROM {$this->Table} where ID={$id}";
            }
            $query  = mysqli_query($this->Link, $sql);
            $result = mysqli_fetch_assoc($query);

            if (empty($result)) {
                return;
            }
            $Exaes    = explode(',', $result['Example']);
            $example  = array('name' => '', 'url' => '');
            $examples = array();
            foreach ($Exaes as $key => $value) {
                if (!empty($value)) {
                    $example        = explode('->', $value);
                    $example        = array('name' => htmlspecialchars_decode(str_replace('<dot>', ',', $example[0]), ENT_QUOTES), 'url' => htmlspecialchars_decode(str_replace('<dot>', ',', $example[1]), ENT_QUOTES));
                    $examples[$key] = $example;
                }
            }
            $result['Title']   = htmlspecialchars_decode($result['Title'], ENT_QUOTES);
            $result['Summary'] = htmlspecialchars_decode($result['Summary'], ENT_QUOTES);
            $result['Example'] = $examples;
            $result['Body']    = htmlspecialchars_decode($result['Body'], ENT_QUOTES);
            $result['Tag']     = explode(',', $result['Tag']);
            //提取用户名
            $sql                 = "SELECT `Name`,`Avatar` FROM {$this->Table_User} where `ID`={$result['Publisher']}";
            $query               = mysqli_query($this->Link, $sql);
            $Publisher           = mysqli_fetch_assoc($query);
            $Publisher           = array('ID' => $result['Publisher'], 'Name' => $Publisher['Name'], 'Avatar' => $Publisher['Avatar']);
            $result['Publisher'] = $Publisher;

            //点击量设置
            $hit = "Hit" . $id;
            if (empty($_SESSION[$hit])) {
                $sql            = "UPDATE {$this->Table} SET `HitCount`=HitCount+1  WHERE `ID`='{$id}'";
                $query          = mysqli_query($this->Link, $sql);
                $_SESSION[$hit] = $result['HitCount'];
            }

            return $result;
        }
    }
    /**
     * 加载我的机构
     * @param [type] $id [description]
     */
    public function MyArticle($id, $filter = 'ALL')
    {
        if (!empty($id) && is_numeric($id) && !empty($filter)) {
            if ($filter == 'ALL') {
                $sql = "SELECT * FROM {$this->Table} where `Publisher`={$id}";
            } else {
                $sql = "SELECT * FROM {$this->Table} where `Status`='{$filter}' AND `Publisher`={$id}";
            }
            $query = mysqli_query($this->Link, $sql);

            $article = array();
            while ($result = mysqli_fetch_assoc($query)) {
                $article = array_merge_recursive($article, array($result));
            }
            return $article;
        }
    }
    /**
     * 机构内容审核
     * @param [type] $id    [description]
     * @param [type] $audit [description]
     */
    public function Audit($id, $audit)
    {
        if (!empty($id) && is_numeric($id) && !empty($audit)) {
            $sql   = "UPDATE {$this->Table} SET `Status`='{$audit}'  WHERE `ID`='{$id}'";
            $query = mysqli_query($this->Link, $sql);
            $msg   = '';
            if (mysqli_affected_rows($this->Link) <= 0) {
                $msg = "设置失败！";
                return $msg;
            } else {
                $msg = "设置成功！";
                return $msg;
            }
        }
    }
    /**
     * 设置首页轮播
     * @param [type] $id       [description]
     * @param [type] $carousel [description]
     */
    public function SetCarousel($id, $carousel)
    {
        if (!empty($id) && is_numeric($id) && !empty($carousel)) {
            $sql   = "UPDATE {$this->Table} SET `Carousel`='{$carousel}'  WHERE `ID`='{$id}'";
            $query = mysqli_query($this->Link, $sql);
            if (mysqli_affected_rows($this->Link) <= 0) {
                $_SESSION['Notice'] = "设置失败！";
                return $_SESSION['Notice'];
            } else {
                $_SESSION['Notice'] = "设置成功！";
                return $_SESSION['Notice'];
            }
        } else {
            $_SESSION['Notice'] = "提交信息有误！";
            return $_SESSION['Notice'];
        }
    }
    /**
     * 加载首页轮播
     * @param [type] $length 加载数量(默认为6)
     */
    public function CarouselLoader($length = 6)
    {
        if (is_numeric($length)) {
            $sql   = "SELECT * FROM {$this->Table} where `Carousel`<>'' AND Status='publish' ORDER BY `ID` DESC LIMIT 0,{$length}";
            $query = mysqli_query($this->Link, $sql);

            $article = array();
            while ($result = mysqli_fetch_assoc($query)) {
                $article = array_merge_recursive($article, array($result));
            }
            return $article;
        }
    }
}
