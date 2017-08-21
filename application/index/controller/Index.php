<?php
namespace app\index\controller;

use app\index\controller\Auth;
use app\index\model\User;
use app\index\model\Record;
use \think\Request;
class Index extends Auth
{
    protected $record;
    protected $user;
   
    protected function _initialize()
    {
        parent::_initialize();
        $this->record = new Record;
        $this->user = new User;

    }
   
     //活动主页
    public function index(Request $request)
    {   
        // if (time()>1497801600){
        //     $this->redirect('index/end/index');
        // }
        $info = session('user');

        if ($money = $request->param('money') && $info['status'] == 0) {
            $this->assign('showSub','flex');//这个区间是通过助力他人吸引来的用户的money
            $this->assign('money',$money);
        }
        $helpInfo = $this->package($info['id']);//今日的总实时排行
        $helpList = $this->powergroup($info['id']); //当前助力的前十名
    
        if ($info['status']) {
            //助力总金额和比例
            $sum_money = $this->user->where(['id'=>$info['id']])->field('help_money')->find();
            $this->assign('sum_money',round($sum_money['help_money'], 2));
            $this->assign('bar',($sum_money['help_money'] / 1000 * 100));
        } 
        
        $time = time();
        $token = md5($time.SHARE.session('user.id'));//分享朋友圈的token
       

        $this->assign('helpInfo',$helpInfo);
        $this->assign('time', $time);
        $this->assign('token', $token);
        $this->assign('helpList', $helpList);
        return $this->fetch();
    }
    //好友助力页面
	public function bargain(Request $request)
	{
        // if (time()>1497801600){
        //     $this->redirect('index/end/index');
        // }
        $id = $request->param('helpto');
        if ($id == session('user.id')) {
            $this->redirect('index/index');
        }
        $str = md5($request->param('time').SHARE.$id);
        if (strcmp($str, $request->param('token'))) {
            $this->error('token验证失败','index/index');//分享的token验证错误
        }
        
        $info = $this->user->where(['id'=>$id])->find();//要帮助谁抢房租
        if (!$info) {
           $this->redirect('index/index/index');
        }
        if (!$info->status) {
            echo '<script>alert("您的好友没有添加资料，暂不能帮助他抢钱")</script>';
            $this->redirect('index/index/index');
        }
        
        $helpList = $this->powergroup($id);//查找当前要帮助好友的助力团最新前10名

        //是否已经帮助过
        $res = $this->record->where(['u_id' => $id,'h_id'=>session('user.id')])->find();
        if ($res) {
            $this->assign('haveHelp',true);
        } else {
            $this->assign('haveHelp',false);
        }

       
        $helpInfo = $this->package($id);//组装助力好友头像，昵称，助力金额，助力时间成新的数组
        $info = $info->toArray();
        $info['help_money'] = round($info['help_money'], 2);

        $this->assign('helpInfo',$helpInfo);
        $this->assign('helpList',$helpList);
        $this->assign('info',$info);
        $this->assign('bar',($info['help_money'] / 1000 * 100));

        return $this->fetch();
	}
    
    //参与活动信息提交
    public function joinAct(Request $request)
    {
        
        $where = ['phone'=> $request->param('tel')];
        $result = $this->user->where($where)->find();

        if ($result) {
            $data = [
                'errcode'=> 1,
                'info' =>'此手机号码已经参与活动'
            ];
            return json_encode($data);
        }

        $save = [
            'status' => 1,
            'phone'  => trim($request->param('tel')),
            'real_name' => trim($request->param('username'))
        ]; 

        if ($money = $request->param('money')) {
            $save['status'] = 2;
            $save['help_money'] = $money;
            $save['help_num'] = 1;
            $save['m_money'] = $money;

            $data = [
                'u_id' => session('user.id'),
                'h_id' => session('user.id'),
                'h_money'       => $money,
                'register_time' => time(),
                ];
            $this->record->create($data);
        }
        $where = ['id'=> session('user.id')];
        $info = $this->user->save($save,$where);
        session('user.status',$save['status']);
       
        if ($info) {
            $data = [
                    'errcode'=> 0,
                    'info' =>'加入成功，快快抢房租吧'
                ];
            if ($money = $request->param('money')) {
                $data['info'] = '加入成功,喊到'. $money .'元,快邀请好友来帮你';
            }
        } else {
             $data = [
                    'errcode'=> 1,
                    'info' =>'加入失败，稍后再试'
                ];
            
        }
        return json_encode($data);
    }
    //最新助力排行榜，当天的
    private function package($id)
    {
        $date = strtotime(date('Y-m-d'));
        $data = $this->user->where('help_money','>',0)->where('update_time','>',$date)->order('help_money desc')->limit(10)->select();
        if (empty($data)) {
            $data = $this->user->where('help_money','>',0)->order('help_money desc')->limit(10)->select();
        }
        return $data;
    }
    //助力团
    private function powergroup($uid,$page=1) {
        //组装助力好友头像，昵称，助力金额，助力时间成新的数组
        $offset = ($page - 1) * 10; 
        $data = $this->record->where(['u_id'=>$uid])->where('h_id','neq',$uid)->order('register_time desc')->limit($offset,10)->select();
        $helpList = [];

        foreach ($data as $key => $value) {
             if ($value->h_id != session('user.id')) {

                $helpList[$value->h_id] = [
                                    'h_money' => $value->h_money,
                                    'register_time' => date('Y-m-d h:i:s',$value->register_time),
                                    'wx_headimgurl'=> $value->user->wx_headimgurl,
                                    'wx_name' => $value->user->wx_name,
                                ];
                                
            }
            
        }
        
        return $helpList ? $helpList : 1;
    }

    public function help(Request $request)
    {
        
        $text =  $request->param('text');//当前用户id

        if (!strpos($text, '全国第一')) {
            //语音匹配失败终止
            return json_encode(['errcode'=>0,'info'=>$text]);
        }

        $id = $request->param('u_id') ? $request->param('u_id') : session('user.id');
        $info = $this->user->where(['id'=>$id])->find();
        //$money = $request->param('h_money');//改成现在随机出现金额
        //查看如果u_id 参数存在就是帮助别人抢
        if ($request->param('u_id')) {
            if ($info['help_money'] < 300) {
                $money = randmon(3,5);
            } else if ($info['help_money'] < 500) {
                $money = randmon(2,3);
            } else if ($info['help_money'] < 700) {
                $money = randmon(1,2);
            } else if ($info['help_money'] < 900) {
                $money = randmon(0.5,1);
            } else if ($info['help_money'] < 1000) {
                $money = randmon(0.2,0.5);
            } else {
                $money = randmon(2,3);
            }
            //当前用户如果没有参加活动就随机取一个金额，引导报名
            if (session('user.status') == 0) {
                $randMoney = randmon(10,15);
            }
        } else {
           $money = randmon(10,15);//随机产生5-12元
        }

        $status = 0;
        $time = 0;
        //助力金额加上之前的大于1000将本次助力金额做出修改
        // if (($info->help_money + $money > 1000) && $info->status != 3 && $info->help_money != 1000)
        if (($info->help_money + $money >= 1000) && $info->help_money < 1000)
        {
            $money = (100000 - $info->help_money*100)/100;
            $status = 3;
            $time = time();
        }  
        if ($info->help_money >= 1000) {
            $money=0;
            $status = 3;
        }
        if ($request->param('u_id')) {
            //好友助力区间
            $data = [
                'u_id' => $request->param('u_id'),
                'h_id' => session('user.id'),
                'h_money'       => $money,
                'register_time' => time(),
                ];

            $save = [
                'help_money' =>  $info->help_money + $money,
                'help_num'   =>  $info->help_num   + 1,
            ];
            $status ? $save['status'] = $status : $save['status'] = $info->status ; 

            $this->record->create($data);
        } else {
            if($info->m_money){
                $res = [
                'errcode'=> 0,
                'info' => '不要作弊哟,你已经喊过啦'
                 ];
                 return json_encode($res);
            } 
            //自己抢金额区间
            //data数组是写入助力表方便之后做当天数据统计 自己助力是u_id=h_id
            $data = [
                'u_id' => session('user.id'),
                'h_id' => session('user.id'),
                'h_money'       => $money,
                'register_time' => time(),
                ];
            $this->record->create($data);
            $save = [
                'help_money'=>  $info->help_money + $money,
                'help_num' =>  $info->help_num   + 1,
                'm_money' => $money,
                ];

            $status ? $save['status'] = $status : $save['status'] = 2 ;
             session('user.status',$save['status']);
        }
        if ($time) {
            $save['over_time'] = $time;
        }
        $result = $this->user->save($save,['id'=>$id]);
        if ($result) {
            $res = [
                'errcode'=> 1,
                'money'  => $money,
                'num_money' => $info->help_money + $money,
                'status'  =>$save['status'],
            ];
           
        } else {
            $res = [
                'errcode'=> 0,
                'money'  => $money,
                'num_money' => $info->help_money + $money,
                'status' => $save['status'],
                'info'      =>'失败啦，在试试'
            ];
        }
        if (isset($randMoney)){
            $res['randMoney'] = $randMoney;
        }
        
         return json_encode($res);
    }
    public function savevoice()
    {
        $data = json_decode(join('',array_keys($_POST)),true);
        $imgServerId = $data['serverId'];
        $tokenStr = file_get_contents(TOKEN_CACHE);
        $tokenStr = json_decode($tokenStr,true);
       copy("http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$tokenStr['access_token']}&media_id={$imgServerId}",
        "./{$imgServerId}.mp3");
    }
    
    public function helplist(Request $request)
    {
        $uid = $request->param('uid');
        $page = empty($request->param('page')) ? 1 :$request->param('page');
        $helpList = $this->powergroup($uid, $page);
       
        if ($helpList == 1) {
            $data = [
                'errcode' => 1,
                'info' => '帮助你的好友都在这里啦'
            ];
        } else {
            $data = [
                'errcode' => 2,
                'info' => $helpList
            ];
        }
        return json_encode($data);
    }
   
}
