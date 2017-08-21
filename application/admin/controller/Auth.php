<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\admin\model\Admin;
class Auth extends Controller
{

	protected $is_check_login = [''];

	public function _initialize()
	{
		if(!$this->checkLogin() && (in_array(Request::instance()->action(), $this->is_check_login) || $this->is_check_login[0] == '*'))
		{
			$this->error('您还没有登录请先登录', url('admin/auth/login'));
		}
	}

	public function checkLogin()
	{
		return session('?admin');
	}


	public function login()
	{
		return $this->fetch();
	}

	public function doLogin()
	{
		$info = Admin::where(['name' => input('post.name'), 'pwd' => md5(input('post.pwd'))])->field('id,name')->find();
		if($info){
			session('admin' ,$info->toArray());
			$this->success('登录成功,欢迎回来','admin/admin/index');
		}else{
			$this->error('登录失败,重新登录','admin/auth/login');
		}
	}

	
	public function logout()
	{
		session(null);

		$this->success('退出成功！','admin/auth/login');
	}
	
}
