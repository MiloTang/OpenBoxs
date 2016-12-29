<?php
namespace WeiShop\Controller;
use Core\Libs\BaseController;
use Core\Libs\QRcode;

class IndexController extends BaseController
{
   public function index()
   {
      $arr=array('衣服A','衣服B','衣服C','衣服D','衣服E','衣服F','衣服G','衣服H','衣服I',
          '衣服J','衣服K','衣服L','衣服M',
         '衣服N','衣服O','衣服P','衣服Q','衣服R','衣服S');
      $this->assign('arr',$arr);
      $this->assign('title','微购');
      $this->display('index.html');
   }
   public function member()
   {
      $this->assign('title','微购');
      $this->display('member.html');
   }
}