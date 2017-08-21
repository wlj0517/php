<?php
namespace app\index\model;

use think\Model;

class Record extends Model
{
	protected $registerTime = 'register_time';
	public function user()
	{
		return $this->belongsTo('User','h_id');
	}
}