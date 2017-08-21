<?php 
namespace app\index\controller;

class Wechat
{
	//验证服务器配置token
	public function valid()
	{
	
		$echoStr = $_GET["echostr"];
		if ($this->checkSignature()) {
			echo $echoStr;
			exit;
		}
  	}
  	//公众号菜单
  	public function subButton()
  	{
	    $token = $this->getTOKEN(APPID,APPSECRET);
	    $menu = [];
	    $menu['button'] = [];
	    $menu['button'][] = [
	                    'name' => '关于千锋',
	                    'sub_button' =>[
	                        [
	                            "type"=>"view",
	                            "name"=>"了解千锋",
	                            "url"=>"http://wap.mobiletrain.org/into.html"
	                        ],
	                        [
	                            "type"=>"view",
	                            "name"=>"全国分校",
	                            "url"=>"http://wap.mobiletrain.org/about.html?weixinlzf="
	                        ],
	                        [
	                            "type"=>"view",
	                            "name"=>"课程了解",
	                            "url"=>"http://wap.mobiletrain.org/index.html?weixinlzf="
	                        ],
	                        [
	                            "type"=>"view",
	                            "name"=>"免费视频",
	                            "url"=>"http://www.mobiletrain.org/video/?weixinlzf="
	                        ],
	                      ]
	                    ];
	    $menu['button'][] = [
	                     "type"=>"view",
	                     "name"=>"就业喜报",
	                     "url"=>"http://wap.mobiletrain.org/jyxz.html"
	                    ];
	    $menu['button'][] = [
	                    "type"=> "view", 
	                    "name"=> "在线咨询", 
	                    "url"=>"http://www34.53kf.com/m.php?cid=72132404&arg=10132404&style=3&language=cn&lytype=0&charset=gbk&kflist=off&kf=18889916,18894416&zdkf_type=3&referer=http%3A%2F%2Fwww.mobiletrain.org%2F&keyword=&tfrom=1&tpl=crystal_blue&timeStamp=1465801075136&ucust_id=&token_53kf=afe8dc461ebeac43f086bb3ab0441524&random_53kf=611366/?weixinlzf",
	                    ];
	    $data = json_encode($menu,JSON_UNESCAPED_UNICODE);
	    $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token";
	    echo  myMethod($url,'post',$data);
  	}
  	//获取access_token
	public function getTOKEN($appid, $secret)
	{
	    if (file_exists(TOKEN_CACHE)) {
	        $tokenStr = file_get_contents(TOKEN_CACHE);
	        $tokenStr = json_decode($tokenStr,true);
	        //判断文件是否过期
	        if (filectime(TOKEN_CACHE) + $tokenStr['expires_in'] > time()) {
	          return $tokenStr['access_token'];
	        }
	        unlink(TOKEN_CACHE);
	    }
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
	    $result = myMethod($url,'get');
	   // echo $result;
	    file_put_contents('token.txt',$result);
	    $tokenStr = json_decode($result,true);
	    return $tokenStr['access_token'];
	}
	//关键字回复
  	public function index()
  	{
		//get post data, May be due to the different environments
		if (PHP_VERSION >= 7) {
		 	$postStr = file_get_contents('php://input'); 
		} else {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		}
		$xml = simplexml_load_string($postStr);
		$responseMsg = '<xml>
		                  <ToUserName><![CDATA[%s]]></ToUserName>
		                  <FromUserName><![CDATA[%s]]></FromUserName>
		                  <CreateTime>%s</CreateTime>
		                  <MsgType><![CDATA[text]]></MsgType>
		                  <Content><![CDATA[%s]]></Content>
		              </xml>';
		if ($xml->Content == 'iOS视频') {
			$Content ='千锋教育iOS开发视频 提取码 : shw2 
			http://pan.baidu.com/share/init?shareid=781481298&uk=5265166281 

			iOS初级开发视频_Objective-C编程语言
			2 iOS中级开发视频_UI编程
			 2.1 iOS中级开发视频_列表视图应用
			 2.2 iOS中级开发视频_多视图与多控制器管理
			 2.3 iOS中级开发视频_多控制器实现抽屉布局效果
			 2.4 iOS中级开发视频_集合视图实现瀑布流布局效果
			3 iOS中级开发视频_多线程技术 4 千锋教育iOS中级开发视频_网络编程';
		} else if ($xml->Content == 'Android视频') {
			$Content ='千锋教育Android开发视频 提取码: z1ab  
			http://pan.baidu.com/share/init?shareid=752475571&uk=5265166281 
			千锋教育Android初级开发视频_Java编程语言
			2 千锋教育Android中级开发视频';
		} else if ($xml->Content == 'HTML5视频') {
			$Content ='千锋教育HTML5开发视频 
			http://pan.baidu.com/share/init?shareid=977862466&uk=526516628 
			提取码 : s8gf  
			千锋教育HTML5初级开发视频_HTML与CSS基础 
			2 千锋教育HTML5初级开发视频_JavaScript语言基础 
			3 千锋教育HTML5初级开发视频_jQuery基础 
			4 千锋教育HTML5初级开发视频_CSS3基础';
		} else if ($xml->Content == 'UI视频') {
			$Content ='千锋教育UI设计视频 
			http://pan.baidu.com/share/init?shareid=1458682021&uk=526516628
			提取码 : 5xiw1 

			千锋教育UI初级设计视频_Photoshop基础入门';
		} else if ($xml->Content == 'PHP视频') {
			$Content ='千锋教育PHP开发视频 提取码 : 6y6f 
			http://pan.baidu.com/share/init?shareid=4228918993&uk=5265166281 
			千锋教育PHP初级开发视频_HTML与CSS基础
			2 千锋教育PHP初级开发视频_PHP基础语法';
		} else {
			$Content ='亲看到这条消息说明我们收到您的留言啦！
			【/玫瑰小千/玫瑰送你的福利/玫瑰】
			千锋免费视频资源下载：http://www.mobiletrain.org/video/
			一定要正确回复相应关键词哟。
			例如【iOS视频、Android视频、HTML5视频、UI视频、PHP视频】
			/呲牙有问题直接加小千微信 jiushiwo233
			';
		}
		//$Content ='就说你要干啥吧';
		$responseXML = sprintf($responseMsg,$xml->FromUserName,$xml->ToUserName,time(),$Content);
		echo $responseXML;
    }
    
	private function checkSignature()
	{
	    // you must define TOKEN by yourself
	    if (!defined("TOKEN")) {
	        throw new Exception('TOKEN is not defined!');
	    }
	    
	    $signature = $_GET["signature"];
	    $timestamp = $_GET["timestamp"];
	    $nonce = $_GET["nonce"];
	        		
			$token = TOKEN;
			$tmpArr = array($token, $timestamp, $nonce);
	        // use SORT_STRING rule
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
	}
}
