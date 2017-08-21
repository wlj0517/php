<?php
namespace app\index\controller;
use app\index\model\User;
use app\index\model\Record;
use think\Db;

/**
* 	
*/
class Demo 
{
	
	  protected $record;
    protected $user;
   
    public function __construct()
    {
       $this->record = new Record;
        $this->user = new User;
       
    }


    public function index(){
    	  $total = $this->user->count();
          $regis = $this->user->where('status','>',0)->count();
          //$WtwoHundred = $this->user->where('status','>',0)->where('help_money','<',200)->where('help_money','>',0)->count();
          $wFH = $this->user->where('help_money','>',300)->count();
$wSH = $this->user->where('help_money','>',500)->count();
       //   $wEH = $this->user->where('help_money','<',900)->where('help_money','>',700)->count();
          $wNH = $this->user->where('help_money','>',800)->count();
          $per = $this->user->where('help_money','1000')->count();
          $sumMoney = $this->user->sum('help_money');
          echo '<font size="4">总人数:' . $total . '</font><br/>'; 
          echo '<font size="4">报名抢红包人数:' . $regis . '</font><br/>'; 
          echo '<font size="4">1000元人数:' . $per . '</font><br/>';
          echo '<font size="4">总红包金额:' . intval($sumMoney) . '</font><br/>';
        //  echo '<font size="4">200以下:' . $WtwoHundred . '</font><br/>'; 
          echo '<font size="4">300以上:' . $wFH . '</font><br/>'; 
         echo '<font size="4">500以上:' . $wSH . '</font><br/>'; 
         echo '<font size="4">800以上:' . $wNH . '</font><br/>'; 
        

    }
   public function ceshi(){
    file_put_contents('ceshi.txt', 'data');
   }
  
}