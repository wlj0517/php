<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\WechatApi;
use app\index\model\User;

class Wxlogin extends Controller
{
	
	public function login(User $user)
	{
		$obj = new WechatApi(APPID,APPSECRET);//填你的appid,appsecret
		$result = $obj->get_user_info();
		
		//file_put_contents('wechaterrcode.log', json_encode($result) . "\n",FILE_APPEND);
		//if ($result['openid']) {
		if (is_array($result) && array_key_exists('openid', $result)) {
			$where = [
				'wx_openid' => $result['openid']
			];
			// $result['nickname'] = preg_replace('/\\\u[a-z0-9]{4}/', '*', userTextEncode($result['nickname']));
			$data = [
				'wx_openid' 	=> $result['openid'],
				'wx_name'		=> $result['nickname'],
				'wx_headimgurl' => $result['headimgurl'],
				'create_time'	=> time(),
				'from_stu'		=> session('from_stu'),
			];
			$info = $user->userInfo($where, $data);
			if (!empty($info)){
				$data = $info->toArray();

				$data = [
					'status'		=> $data['status'],
					'id'			=> $data['id'],
					'wx_name' 		=> $data['wx_name'],				
					'wx_headimgurl' => $data['wx_headimgurl'],
					'from_stu'		=> $data['from_stu'],
					
				];
				session('user',$data);
				// if (time()>1497801600){
    //         		$this->redirect('index/end/index');
    //    			}else {
       				$this->redirect(session('url'));
       			//}
				
			}
		} else {
			$this->error('您打开的链接有错误，正在重新获取微信授权','index/index/index');
			
		}
	}
}