<?php
namespace app\admin\controller;

use think\View;
use think\Controller;
use app\admin\controller\Auth;
use app\admin\model\Admin as AdminModel;
use app\index\model\User;
use app\index\model\Record;
use think\Request;
class Admin extends Auth
{
	protected $is_check_login = ['*'];

	/**
	 * 这是首页
	 */ 
	public function index()
	{
		return $this->fetch();
	}
	
	public function list(User $user)
	{
		//admin的ID为1，院校id为2，网资讯3
		//from_stu 1为网络咨询  2 为院校
		if (session('admin.id') == 2) {
			$where = ['from_stu'=>2];
		} else if (session('admin.id') == 3) {
			$where = ['from_stu'=>1];
		} else {
			$where = '';
		}
		$list = $user->where($where)->order('ispay desc')->order('status desc')->order('help_money desc')->paginate(10);

		//将缴费的和没有缴费的人数查询出来
        $isPay = $user->where('ispay=1')->count();
        $isNotPay = $user->where('ispay=0')->count();
       //将缴费的和没有缴费的显示在模板中
		$this->assign('isPay',$isPay);
		$this->assign('isNotPay',$isNotPay);

		// 把分页数据赋值给模板变量list
		$this->assign('list',$list);
		
		return $this->fetch();
	}
	public function details(Request $request)
	{
		$id = $request->param('id');
		//组装助力好友头像，昵称，助力金额，助力时间成新的数组
        $data = Record::all(['u_id'=>$id]);
        $helpInfo = [];
        foreach ($data as $key => $value) {
            $helpInfo[$value->h_id] = [
                    'h_money' => $value->h_money,
                    'register_time' => $value->register_time,
                    'wx_headimgurl'=> $value->user->wx_headimgurl,
                    'wx_name' => $value->user->wx_name,
                ];
        }
        $this->assign('helpInfo',$helpInfo);
        return $this->fetch();
	}
	public function search(Request $request)
	{
		$phone = $request->param('phone');
		$info = User::where(['phone'=>$phone])->find();
		
		if ($info) {
			$info = $info->toArray();
			$data = [
				'errcode' => 0,
				'info' => $info
			 ];
		} else {
			$data = [
				'errcode' => 1
			];
		}
		return json_encode($data);
	}
	//点击修改学生缴费的状态
	public function isPayStatus($id){

	    $user = new User();

	    $res = $user->where('id',$id)->setField('ispay', 1);
	    if($res){
           $this->redirect('admin/admin/list');
	    }

	}

}