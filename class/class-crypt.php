<?php
/**
 * CRYPT Library v1.1.3
 * 加密、解密类
 *
 * http://www.heitaolab.com/
 * Copyright 2015, 2016 黑桃Lab
 * Date: 2016-3-14T19:30Z
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.ini.php";
class CRYPT
{
    /** @var 加密算法 */
    private $cipher = CIPHER;

    /** @var 密钥 */
    private $key = KEY;

    /** @var 加密模式 */
    private $mode = MODE;

    /** @var 初始向量 */
    private $iv;

    /**
     * 初始化类
     */
    public function __construct()
    {
        if (!empty($this->cipher) && !empty($this->key) && !empty($this->mode)) {
            if (strlen($this->key) == 16 || strlen($this->key) == 24 || strlen($this->key) == 32) {
                $this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
            } else {
                die('密钥长度不正确！');
            }
        } else {
            die('加密配置有误！');
        }
    }
    /**
     * 加密数据
     * @param  [string] $data [要加密的数据]
     * @return [string]       [返回加密后的数据]
     */
    public function encode($data)
    {
        $ciphertext        = mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
        $ciphertext        = $this->iv . $ciphertext;
        $ciphertext_base64 = base64_encode($ciphertext);
        return trim($ciphertext_base64);
    }
    /**
     * 解密数据
     * @param  [string] $data [要解密的数据]
     * @return [string]       [返回解密后的数据]
     */
    public function decode($data)
    {
        $ciphertext_dec = base64_decode($data);
        $iv_dec         = substr($ciphertext_dec, 0, mcrypt_get_iv_size($this->cipher, $this->mode));
        $ciphertext_dec = substr($ciphertext_dec, mcrypt_get_iv_size($this->cipher, $this->mode));
        $plaintext_dec  = mcrypt_decrypt($this->cipher, $this->key, $ciphertext_dec, $this->mode, $iv_dec);
        return trim($plaintext_dec);
    }
}
