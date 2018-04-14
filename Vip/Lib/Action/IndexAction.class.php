<?php
class IndexAction extends CommonAction {
	// 框架首页
	public function index() {
		ob_clean();
		$this->_checkUser();
		$this->_Config_name();//调用参数
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$fck = D ('member');

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$field = '*';
		$fck_rs = $fck -> field($field) -> find($id);
		
		$reid = $fck_rs['re_id'];
		$rers = $fck->where('id='.$reid)->field('user_tel')->find();
		
		$webcount = $fck->where('id>0')->count();
		$this->assign('webcount',$webcount);
		
		$reusertel = $rers['user_tel'];
		$this->assign('reusertel',$reusertel);

		$k=explode(",",$fck_rs['prem']);
		$this -> assign('k',$k);
		
		$this->assign('fck_rs',$fck_rs);
		//当前日期  
		$sdefaultDate = date("Y-m-d");  

		//$first =1 表示每周星期一为开始日期 0表示每周日为开始日期  
		$first=1;  
		//获取当前周的第几天 周日是 0 周一到周六是 1 - 6  
		$w=date('w',strtotime($sdefaultDate)); 

		//获取本周开始日期，如果$w是0，则表示周日，减去 6 天  
		$week_start=date('Y-m-d',strtotime("$sdefaultDate -".($w ? $w - $first : 6).' days'));
		$week_strt=strtotime("$sdefaultDate -".($w ? $w - $first : 6).' days');

//本周结束日期  
// $week_end=date('Y-m-d',strtotime("$week_start +6 days"));
$week_end=strtotime("$week_start +6 days");


		// $fck->emptyMonthTime();
// 		$fck->emptywTime();
// 		$fck->getLevel();
// 		$fck->sh_level();
		$ydate = strtotime(date('Y-m-d'));//当天时间
		$end_date =$ydate + (24*3600);//当天结束时间

		$fee_rs = M('fee')->field('s2,i4,str29,str3')->find();
		$fee_i4 = $fee_rs['i4'];
		$gg = $fee_rs['str29'];
		$b_money = $fee_rs['str3'];
		$this -> assign('gg',$gg);
		$this -> assign('b_money',$b_money);
		$this -> assign('fee_i4',$fee_i4);
		
		$map = array();
		$map['s_uid']   = $id;   //会员ID
		$map['s_read'] = 0;     // 0 为未读
        $info_count = M ('msg') -> where($map) -> count(); //总记录数
		$this -> assign('info_count',$info_count);

		$arss = $this->_cheakPrem();
        $this->assign('arss',$arss);
        
//         $Guzhi = A("Guzhi");
//         $Guzhi->stock_past_due();
        
//		$fck -> mr_fenhong(1);
//		$this->aotu_clearings();
		
		$this->display('index');
	}

//3. 生成原始的二维码(不生成图片文件)  
function scerweima2($url=''){  
    require_once 'phpqrcode.php';  
    $value = $url;                  //二维码内容  
    $errorCorrectionLevel = 'L';    //容错级别   
    $matrixPointSize = 5;           //生成图片大小    
    //生成二维码图片  
    $QR = QRcode::png($value,false,$errorCorrectionLevel, $matrixPointSize, 2);  
}  
}
?>