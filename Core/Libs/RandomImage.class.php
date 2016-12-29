<?php
/**
 * Created by PhpStorm.
 * User: milo
 * Date: 11/4/2016
 * Time: 4:03 PM
 */
namespace Core\Libs;
defined('CORE_PATH') or exit();
class RandomImage {
    private $_code;
    private $_codeLen = 6;
    private $_width = 150;
    private $_height = 50;
    private $_img;
    private $_fontSize = 18;
    private $_fontColor;
    private $_fontFace;
    private $_strings=array();
    private $_string;
    private static $_instance;
    private function __construct()
    {
        $this->_fontFace="./Core/Libs/font/msyh.ttf";
    }
    public static  function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function __clone()
    {

    }
    private function _createCode() {

        for ($i = 0; $i < $this->_codeLen; $i++)
        {
            $num=mt_rand(1,3);
            if ($num==1)
            {
                $this->_code .= chr(mt_rand(48,57));
            }
            else if ($num==2)
            {
                $this->_code .= chr(mt_rand(65,90));
            }
            else
            {
                $this->_code .= chr(mt_rand(97,122));
            }

        }
    }
    private function _createBg() {
        $this->_img = imagecreatetruecolor($this->_width, $this->_height);
        $color = imagecolorallocate($this->_img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
        imagefilledrectangle($this->_img,0,$this->_height,$this->_width,0,$color);
    }
    private function _createStr() {
        for ($i=0;$i<$this->_codeLen;$i++)
        {
            $this->_fontColor = imagecolorallocate($this->_img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imagettftext($this->_img,$this->_fontSize,mt_rand(-20,20),$i*25,$this->_height / 1.5,$this->_fontColor,$this->_fontFace,$this->_code[$i]);
        }

    }
    private function _createLine() {
        for ($i=0;$i<10;$i++) {
            $color = imagecolorallocate($this->_img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->_img,mt_rand(0,$this->_width),mt_rand(0,$this->_height),mt_rand(0,$this->_width),mt_rand(0,$this->_height),$color);
        }
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->_img,mt_rand(1,5),mt_rand(0,$this->_width),mt_rand(0,$this->_height),'*',$color);
        }
    }
    private function _outPut() {
        header('Content-type:image/png');
        imagepng($this->_img);
        imagedestroy($this->_img);
    }
    public function doImg(int $len) {
        if ($len<=10&&$len>=1)
        {
            $this->_codeLen=$len;
            $this->_width=$len*25;
            $this->_createBg();
            $this->_createCode();
            $this->_createLine();
            $this->_createStr();
            $this->_outPut();
        }
        else
        {
            exit();
        }

    }
    public function doImgZh($string,$len,$height=0)
    {
        $this->_string=iconv('utf-8','gbk',$string);
        $this->_codeLen=$len;
        $this->_width=$len*40;
        if ($height==0)
        {
            $this->_height=40*$len;
        }
        else
        {
            $this->_height=$height;
        }
        $this->_strings=$string;
        if (!empty($this->_strings))
        {
            $code=$this->_string;
        }
        else
        {
            $code='123';
        }
        $this->_img=imagecreatetruecolor($this->_width,$this->_height);
        $bkc=imagecolorallocate($this->_img,250,220,250);
        imagefill($this->_img,0,0,$bkc);
        for($i=0;$i<$this->_codeLen;$i++){
            $fontColor=imagecolorallocate($this->_img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
            $codex=iconv("GB2312","UTF-8",substr($code,$i*2,2));
            imagettftext($this->_img,mt_rand(4*$this->_codeLen,4*$this->_codeLen),mt_rand(1,1),36*$i+20,mt_rand($this->_height/3,$this->_height),$fontColor,$this->_fontFace,$codex);
        }
        $this->_outPut();
    }
    public function getCode()
    {
        return strtolower($this->_code);
    }

}
