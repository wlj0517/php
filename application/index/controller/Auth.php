<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Wxjssdk;
use think\Request;
class Auth extends Controller 
{
	protected function _initialize()
    {
    	// $time = strtotime('2017-06-19 00:00:00');
    	// if (time() > $time) {

    	// }
    	
    	// file_put_contents('access.log','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] . '----'.$_SERVER['REMOTE_ADDR'] . '----'.date('Y-m-d H:i:s') . "\n",FILE_APPEND);
    	
		session('url','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		if (Request::instance()->param('from_stu') == 2) {
			$from = 2;
		}else {
			$from = 1;
		}
		
		session('from_stu',$from);
		$jssdk = new Wxjssdk;
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('signPackage',$signPackage);
		$this->assign('css_rand_num',mt_rand(1,3));
    	$this->assign('js_rand_num',mt_rand(1,3));
		if(!session('user')){
			$this->redirect('Wxlogin/login');
		}
	}
	
}