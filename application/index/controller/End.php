<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Auth;
use app\index\model\User;
use app\index\model\Record;

class End extends Auth
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
    public function index()
    {   
        
        $info = $this->user->where(['id'=>session('user.id')])->find();
        $info = $info->toArray();
        
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
        $this->assign('phone', $info['phone']);
        $this->assign('bar',($info['help_money'] / 1000 * 100));
        return $this->fetch();
    }
    //组装数组
    private function package($id)
    {
        $date = strtotime(date('Y-m-d'));
        $data = $this->user->where('help_money','>',0)->where('update_time','>',$date)->order('help_money desc')->limit(10)->select();
        return $data;
    }
    //助力团
    private function powergroup($uid,$page=1) {
        //组装助力好友头像，昵称，助力金额，助力时间成新的数组
        $offset = ($page - 1) * 10; 
        $data = $this->record->where(['u_id'=>$uid])->order('register_time desc')->limit($offset,10)->select();
        $helpList = [];
        foreach ($data as $key => $value) {

            if ($value->h_id != session('user.id')) {

                $helpList[$value->h_id] = [
                                    'h_money' => $value->h_money,
                                    'register_time' => $value->register_time,
                                    'wx_headimgurl'=> $value->user->wx_headimgurl,
                                    'wx_name' => $value->user->wx_name,
                                ];
                                
            }
            
        }
        
        return $helpList ? $helpList : 1;
    }
}