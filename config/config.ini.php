<?php
/**
 * Config Library v1.1.3
 * 网站基础配置文件
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-3-10T19:30Z
 */

/** 主机地址 */
define('DB_HOST', 'localhost');

/** 主机类型 */
define('DB_TYPE', 'mysql');

/** MySQL数据库用户名 */
define('DB_USER', '数据库用户名');

/** MySQL数据库密码 */
define('DB_PASSWORD', '数据库密码');

/** 网站数据库的名称 */
define('DB_NAME', '数据库名字');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库用户表名 */
define('DB_USER_TABLE', 'user');
/** 数据库文章表名 */
define('DB_ARTICLE_TABLE', 'article');
/** 数据库网站管理表名 */
define('DB_MANAGE_TABLE', 'manage');

/** 邮箱主机 */
define('MAIL_HOST', '邮箱主机');
/** 邮箱账号 */
define('MAIL_USER', '邮箱账号');
/** 邮箱密码 */
define('MAIL_PASSWORD', '邮箱密码');
/** 邮箱名字 */
define('MAIL_NAME', '邮箱显示名字');

/**
 * 身份认证密钥与盐。
 * @ CIPHER 加密算法
 * @ KEY 密钥
 * @ MODE 加密模式
 */
define('CIPHER', MCRYPT_RIJNDAEL_256);
define('KEY', '32位加密密钥');
define('MODE', MCRYPT_MODE_CBC);
