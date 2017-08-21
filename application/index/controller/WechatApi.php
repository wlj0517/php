<?php
namespace app\index\controller;
class WechatApi
{	
	protected $appid;

	protected $appsecret;

	public function __construct($appid,$appsecret){

			$this->appid = $appid;

			$this->appsecret = $appsecret;

	}	
	//开发者接口，验证签名

    public function get_user_info(){

		if (!isset($_GET['code'])) {
			//触发微信返回code码
		
			$url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
          // file_put_contents('url.txt', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
   			$oauthurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=$url&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
			Header("Location: $oauthurl"); 
		} else {
			//获取code码，以获取openid
	    	$code = $_GET['code'];
			$api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code";

			$data = json_decode(file_get_contents($api),true);
			
			if (array_key_exists('openid', $data)) {
				$openid = $data['openid'];//获取到的openid
				$access_token = $data['access_token'];
				$oauth_api = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";

				$result = json_decode(file_get_contents($oauth_api),true);
				//file_put_contents('wechat.log', json_encode($result) . "\n",FILE_APPEND);
				return $result;
			}
			else {
				file_put_contents('wechaterror.log', json_encode($data) . "\n",FILE_APPEND);
				return $data;
			}
		}
 	}
}
?>
