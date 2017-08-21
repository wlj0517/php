<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
	protected $autoWriteTimestamp = true;
	protected $updateTime = 'update_time';
	public function record()
	{
		return $this->hasMany('Record','u_id');
	}
	//所有当前用户
	public function list()
	{
		return $this->order('status desc')->select();
	}
	public function userInfo($where, $data)
	{
		//查看是否存在这个用户存在返回信息
		$info = $this->where($where)->find();
		if ($info) {
			return $info;
		}else {
			//不存在则插入用户信息
			$this->save($data);
			$info = $this->where($where)->find();
			return $info;
		}
	}
	public function oneInfo($where)
	{
		$info = $this->where($where)->find();
		if ($info->status == 1) {
			$recordData = $info->record;
			return $recordData;
		}
	}
	
}