<?php
class RechargeAction extends CommonAction{
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(0);//调用过滤函数
		$this->_Config_name();//调用参数
		$this->_checkUser();
	}
	
	public function cody(){
		//===================================二级验证
		$UrlID = (int) $_GET['c_id'];
		if (empty($UrlID)){
			$this->error('二级密码错误!');
			exit;
		}
		if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$cody   =  M ('cody');
		$list	=  $cody->where("c_id=$UrlID")->field('c_id')->find();
		if ($list){
			$this->assign('vo',$list);
			$this->display('Public:cody');
			exit;
		}else{
			$this->error('二级密码错误!');
			exit;
		}
	}
	public function codys(){
		//=============================二级验证后调转页面
		$Urlsz = (int) $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass  = $_POST['oldpassword'];
			$fck   =  M ('member');
			if (!$fck->autoCheckToken($_POST)){
				$this->error('页面过期请刷新页面!');
				exit();
			}
			if (empty($pass)){
				$this->error('二级密码错误!');
				exit();
			}
	
			$where = array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['password2'] = md5($pass);
			$list = $fck->where($where)->field('id,is_agent')->find();
			if($list == false){
				$this->error('二级密码错误!');
				exit();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz){
			case 1;
			$_SESSION['Urlszpass'] = 'MyssMangGuo';
			$bUrl = __URL__.'/currencyRecharge';//货币充值
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['UrlPTPass'] = 'MyssGuanMangGuo';
			$bUrl = __URL__.'/adminCurrencyRecharge';//后台充值管理
			$this->_boxx($bUrl);
			break;
			case 3;
			$_SESSION['Urlszpass'] = 'MyssonlineRecharge';
			$bUrl = __URL__.'/onlineRecharge';
			$this->_boxx($bUrl);
			break;
			case 4;
			$_SESSION['UrlPTPass'] = 'MyssadminonlineRecharge';
			$bUrl = __URL__.'/adminonlineRecharge';
			$this->_boxx($bUrl);
			break;
			case 5;
			$_SESSION['UrlPTPass'] = 'MyssaAiXin';
			$bUrl = __URL__.'/aixin';
			$this->_boxx($bUrl);
			break;
			default;
			$this->error('二级密码错误!');
			exit;
		}
	}
	
	//==========================货币充值
	public function currencyRechargeAC(){
		if ($_SESSION['Urlszpass'] == 'MyssMangGuo'){
			$fck = M ('fck');
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$rs = $fck -> field('is_pay,user_id') -> find($ID);
			if($rs['is_pay'] == 0){
				$this->error('临时会员不能充值！');
				exit;
			}
			$inUserID=$rs['user_id'];
	
			$ePoints = trim($_POST['ePoints']);
			$stype = (int) trim($_POST['stype']);
			$chongzhi = M('chongzhi');
			if (!$chongzhi->autoCheckToken($_POST)){
				$this->error('页面过期，请刷新页面！');
				exit;
			}
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error('金额不能为空!');
				exit;
			}
			// if (strlen($ePoints)>9){
			// 	$this->error ('金额太大!');
			// 	exit;
			// }
			if ($ePoints<=0){
				$this->error ('金额格式不对!');
				exit;
			}
			if($stype>1){
				$stype=1;
			}
	
			$id =  $_SESSION[C('USER_AUTH_KEY')];
			$where = array();
			$where['uid'] = $id;
			$where['is_pay'] = 0;
			$field1 = 'id';
			$vo3 = $chongzhi ->where($where)->field($field1)->find();
			if ($vo3){
				$this->error('上次充值还没通过审核!');
				exit;
			}
			
			//开始事务处理
			$chongzhi->startTrans();
	
			//充值表
//			$_money = trim($_POST['_money']);  //已汇款数额
			$_money = $ePoints;  //已汇款数额
			$_num = trim($_POST['_num']);  // 汇款到账号
			$_year = trim($_POST['_year']); // 年
			$_month = trim($_POST['_month']);  //月
			$_date = trim($_POST['_date']);  //日
			$_hour = trim($_POST['_hour']);  //小时
			$_minute = trim($_POST['_minute']);  //小时
	
	
//			if (empty($_money) || !is_numeric($_money)){
//				$this->error('请输入数字或金额不能为空!');
//				exit;
//			}
			if (empty($_num)){
				$this->error('账号不能为空!');
				exit;
			}
			if (empty($_year) || !is_numeric($_year)){
				$this->error('请输入数字或年不能为空!');
				exit;
			}
			if (empty($_month) || !is_numeric($_month)){
				$this->error('请输入数字或月不能为空!');
				exit;
			}
			if (empty($_date) || !is_numeric($_date)){
				$this->error('请输入数字或日不能为空!');
				exit;
			}
			if (empty($_hour) || !is_numeric($_hour)){
				$this->error('请输入数字或小时不能为空!');
				exit;
			}
			if (empty($_minute) || !is_numeric($_minute) || $_minute>60){
				$this->error('请输入数字或分钟不能为空或者输入数字错误!');
				exit;
			}
	
	
			//$nowdate = strtotime(date('c'));
			$nowdate = strtotime(date($_year.'-'. $_month.'-'.$_date.' '. $_hour.':'.$_minute.':00'));
	
			$data = array();
			$data['uid']     = $id;
			$data['user_id'] = $inUserID;
			$data['huikuan'] = $_money;
			$data['zhuanghao'] = $_num;
			$data['rdt']     = $nowdate;
			$data['epoint']  = $ePoints;
			$data['is_pay']  = 0;
			$data['stype']  = $stype;
	
			$rs2 = $chongzhi->add($data);
			unset($data,$id);
			if ($rs2){
				//提交事务
				$chongzhi->commit();
				$bUrl = __URL__.'/currencyRecharge';
				$this->_box(1,'充值申请成功，请等待后台审核！',$bUrl,1);
				exit;
			}else{
				//事务回滚：
				$chongzhi->rollback();
				$this->error('货币充值失败');
				exit;
			}
		}else{
			$this->error ('错误!');
			exit;
		}
	}
	
	//==============================充值管理
	public function adminCurrencyRecharge(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$recharge = M ('recharge');
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			//$page_where = 'user_id=' . $_POST[userId].'&recharge_time>='.$_POST['sNowDate'].'&recharge_time<='.$_POST['endNowDate'];//分页条件
			if(!empty($_POST['userId'])){
				$page_where['user_id'] = array('eq',$_POST['userId']);
			}
			if(!empty($_POST['sNowDate'])){
				$page_where['recharge_time'] = array('gt',$_POST['sNowDate']);
			}
			if(!empty($_POST['endNowDate'])){
				$page_where['recharge_time'] = array('lt',$_POST['endNowDate']);
			}
			$count = $recharge->where($page_where)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $recharge->where($page_where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			
			$m_count = $recharge->where($page_where)->sum('money');
			$this->assign('m_count',$m_count);
	
			$title = '充值管理';
			$this->assign('title',$title);
			$this->display('adminCurrencyRecharge');
			unset($_POST, $list);
			exit();
		}else{
			$this->error('错误!');
			exit;
		}
	}
	public function adminCurrencyRechargeAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$fck = M ('member');
		if (!$fck->autoCheckToken($_POST)){
			$this->error('页面过期，请刷新页面！');
			exit;
		}
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminCurrencyRecharge';
			$this->_box(1,'请选择！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '确认';
			$this->_adminCurrencyRechargeOpen($PTid);
			break;
			case '删除';
			$this->_adminCurrencyRechargeDel($PTid);
			break;
			default;
			$bUrl = __URL__.'/adminCurrencyRecharge';
			$this->_box(0,'没有该记录！',$bUrl,1);
			break;
		}
	}
	
	public function adminCurrencyRechargeAdd(){
		//为会员充值
	   $fck = M ('member');
		if (!$fck->autoCheckToken($_POST)){
			$this->error('页面过期，请刷新页面！');
			exit;
		}
		$userId = $_POST['userId'];
		$userName = $_POST['userName'];
		$ePoints = $_POST['ePoints'];
		$rechargeType = (int)$_POST['rechargeType'];
		if (is_numeric($ePoints) == false){
			$this->error('金额错误，请重新输入！');
			exit;
		}
		if (!empty($userId) && !empty($ePoints)){
			$where = array();
			$where['user_id'] = $userId;
			$frs = $fck->where($where)->field('user_id,user_name')->find();
			if ($frs){
				$recharge = M ('recharge');
				$data = array();
				$data['user_id'] = $frs['user_id'];
				$data['user_name'] = $frs['user_name'];
				$data['money'] = $ePoints;
				$data['recharge_type'] = $rechargeType;
				$data['is_pay'] = 0;
				$data['recharge_time'] = strtotime(date('c'));
				$result = $recharge->add($data);
				unset($data,$recharge);
				$bUrl = __URL__.'/adminCurrencyRecharge';
				$this->_box(1,'申请充值成功！',$bUrl,1);
			}else{
				$this->error('没有该会员，请重新输入!');
			}
			unset($fck,$frs,$where,$UserID,$ePoints);
		}else{
			$this->error('错误!');
		}
	}
	
	private function _adminCurrencyRechargeOpen($PTid){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
		    $length_arr = count($PTid);
		    if($length_arr > 1){
		    $this->error('一次只能确认一个！');
		    exit;
		    }
			$recharge = M ('recharge');
			$member = M ('member');
			$bonushistory = M ('bonushistory');
			//开始事务处理
			$recharge->startTrans();
			//插入充值表
			$where = array();
			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$recharge_rs = $recharge ->where($where)->field('money,user_id,recharge_type')->find();
			$data['update_time'] = strtotime(date('c'));
			$data['is_pay'] = 1;
			$rs = $recharge->where($where)->save($data);
			if ($rs){
			    //提交事务
			    if ($recharge_rs['recharge_type'] == 0) {
			        $rs2 = $member->execute("UPDATE __TABLE__ SET point=point+{$recharge_rs['money']} WHERE user_id ='{$recharge_rs['user_id']}'");
			        // 添加充值会员历史记录
			        $data = array();
			        $data['user_id'] = $recharge_rs['user_id'];
			        $data['user_name'] = $recharge_rs['user_name'];
			        $data['produce_userid'] = $_SESSION['loginUseracc'];
			        $data['produce_username'] = $_SESSION['loginUserName'];
			        $data['action_type'] = 6;
			        $data['time'] = mktime();
			        $data['money'] = 0;
			        $data['in_money'] = $recharge_rs['money'];
			        $data['bz'] = '会员充值';
			        $bonushistory->add($data);
			        unset($data);
			        $rs3 = $member->execute("UPDATE __TABLE__ SET point=point+{$recharge_rs['money']} WHERE user_id ='{$recharge_rs['user_id']}'");
			        
			        // 添加操作者历史记录
			        $data = array();
			        $data['user_id'] = $_SESSION['loginUseracc'];
			        $data['user_name'] = $_SESSION['loginUserName'];
			        $data['produce_userid'] = $recharge_rs['user_id'];
			        $data['produce_username'] = $recharge_rs['user_name'];
			        $data['action_type'] = 6;
			        $data['time'] = mktime();
			        $data['money'] = 0;
			        $data['in_money'] = -$recharge_rs['money'];
			        $data['bz'] = '会员充值';
			        $bonushistory->add($data);
			        unset($data);
			    } else {
			        $rs2 = $member->execute("UPDATE __TABLE__ SET cash=cash+{$recharge_rs['money']} WHERE user_id ='{$recharge_rs['user_id']}'");
			        // 添加充值会员历史记录
			        $data = array();
			        $data['user_id'] = $recharge_rs['user_id'];
			        $data['user_name'] = $recharge_rs['user_name'];
			        $data['produce_userid'] = $_SESSION['loginUseracc'];
			        $data['produce_username'] = $_SESSION['loginUserName'];
			        $data['action_type'] = 6;
			        $data['time'] = mktime();
			        $data['money'] = $recharge_rs['money'];
			        $data['in_money'] = 0;
			        $data['bz'] = '会员充值';
			        $bonushistory->add($data);
			        unset($data);
			         
			        $rs3 = $member->execute("UPDATE __TABLE__ SET cash=cash-{$recharge_rs['money']} WHERE user_id ='{$_SESSION['loginUseracc']}'");
			        // 添加操作者历史记录
			        $data = array();
			        $data['user_id'] = $_SESSION['loginUseracc'];
			        $data['user_name'] = $_SESSION['loginUserName'];
			        $data['produce_userid'] = $recharge_rs['user_id'];
			        $data['produce_username'] = $recharge_rs['user_name'];
			        $data['action_type'] = 6;
			        $data['time'] = mktime();
			        $data['money'] = -$recharge_rs['money'];
			        $data['in_money'] = 0;
			        $data['bz'] = '会员充值';
			        $bonushistory->add($data);
			        unset($data);
			    }
			    if ($rs2&&$rs3) {
			        $recharge->commit();
			        $bUrl = __URL__.'/adminCurrencyRecharge';
			        $this->_box(1,'确认充值成功！',$bUrl,1);
			        exit;
			    } else {
			        //事务回滚：
			        $recharge->rollback();
			        $this->error('确认充值失败！');
			        exit;
			    }
			    unset($recharge,$where,$rs,$data,$member);
			    
			}else{
			    //事务回滚：
			    $recharge->rollback();
			    $this->error('确认充值失败！');
			    exit;
			}
			
		}else{
			$this->error('充值失败，请刷新页面重试!');
			exit;
		}
	}
	private function _adminCurrencyRechargeDel($PTid){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$User = M ('recharge');
			$where = array();
			//$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $User->where($where)->delete();
			if ($rs){
				$bUrl = __URL__.'/adminCurrencyRecharge';
				$this->_box(1,'删除成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminCurrencyRecharge';
				$this->_box(0,'删除失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
			exit;
		}
	}
	
	//在线充值
	public function onlineRecharge(){
		if ($_SESSION['Urlszpass'] == 'MyssonlineRecharge'){
			$remit = M('remit');
			$fck = M('fck');
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
			$field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $remit->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $Page = new ZQPage($count,$listrows,1);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $remit->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$fwhere = array();
			$fwhere['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field = '*';
			$frs = $fck ->where($fwhere)->field($field)->find();
			$this->assign('frs',$frs);
			$fee = M('fee');
			$fee_rs = $fee ->field('str10')-> find();
			$str4 = $fee_rs['str10'];//汇率
			//$str4 = 1;
			$this->assign('str4',$str4);

			$this->display ();
			return;
		}else{
			$this->error ('错误!');
			exit;
		}
	}
    
    //在线充值订单确认
	public function onlineRechargeAC(){
		if ($_SESSION['Urlszpass'] == 'MyssonlineRecharge'){
			$fck = M ('fck');
			$remit = M('remit');

			$fee = M('fee');
			$fee_rs = $fee ->field('str10')-> find();
			$str4 = $fee_rs['str10'];//汇率
			//$str4 = 1;

			$id =  $_SESSION[C('USER_AUTH_KEY')];
			$rs = $fck -> field('is_pay,user_id') -> find($id);
			if($rs['is_pay']==0){
				$this->error('临时会员不能充值!');
				exit;
			}
			$inUserID=$rs['user_id'];

			$ePoints = trim($_POST['ePoints']);
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error('金额不能为空!');
				exit;
			}
			if (strlen($ePoints)>9){
				$this->error ('金额太大!');
				exit;
			}
			if ($ePoints<=0){
				$this->error ('金额格式不对!');
				exit;
			}
			$ePoints = ((int)($ePoints*100))/100;
			$inmoney = $ePoints*$str4;
			$inmoney = ((int)($inmoney*100))/100;
			
		

			$orok = 0;
			while($orok==0){
				$orderid = $this->makeOrder();

				$where = array();
				$where['orderid'] = array('eq',$orderid);
				$nn = $remit->where($where)->count();
				if($nn==0){
					$orok = 1;
				}
			}
			$bank_code = trim($_POST['bank_code']);
			$this->assign('orderid',$orderid);
			$this->assign('ePoints',$ePoints);
			$this->assign('inmoney',$inmoney);
			$this->assign('bank_code',$bank_code);
			$this->assign('inUserID',$inUserID);
			$this->display();
		}else{
			$this->error ('错误!');
			exit;
		}
	}
	
	//提交在线充值
	public function onlineRechargeOK(){
		if ($_SESSION['Urlszpass'] == 'MyssonlineRecharge'){
			$fck = M ('fck');
			$remit = M('remit');
			$fee = M('fee');
			$fee_rs = $fee ->field('str10')-> find();
			$str4 = $fee_rs['str10'];//汇率
			//$str4 = 1;

			$id =  $_SESSION[C('USER_AUTH_KEY')];
			$rs = $fck -> field('is_pay,user_id') -> find($id);
			if(!$rs){
				$this->error('会员数据错误，请重新登录！');
				exit;
			}
			$inUserID = $rs['user_id'];

			$ePoints = trim($_POST['ePoints']);
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error('金额不能为空!');
				exit;
			}
			if (strlen($ePoints)>9){
				$this->error ('金额太大!');
				exit;
			}
			if ($ePoints<=0){
				$this->error ('金额格式不对!');
				exit;
			}
			$ePoints = ((int)($ePoints*100))/100;
			$inmoney = $ePoints*$str4;
			$amount = ((int)($inmoney*100))/100;
			
			

			$orderid = trim($_POST['orderid']);

			$orok = 0;
			while($orok==0){
				if(empty($orderid)){
					$orderid = $this->makeOrder();
				}
				$where = array();
				$where['orderid'] = array('eq',$orderid);
				$nn = $remit->where($where)->count();
				if($nn==0){
					$orok = 1;
				}else{
					$orderid = $this->makeOrder();
				}
			}

			$data = array();
			$data['uid']     = $id;
			$data['user_id'] = $inUserID;
			$data['amount'] = $ePoints;
			$data['kh_money'] = $amount;
			$data['or_time'] = mktime();
			$data['orderid'] = $orderid;
			$result = $remit->add($data);
			unset($data);

			if ($result){

				$hxb = A('Hxpay');

				$hxb->Hx_pay($orderid,$amount);


				$this->display("Hxpay_onlineRechargeOK");//环讯

			}else{
				$this->error('生成支付订单失败！');
				exit;
			}
		}else{
			$this->error ('错误!');
			exit;
		}
	}
	
	//后台管理在线充值
	public function adminonlineRecharge(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssadminonlineRecharge'){
			$remit = M('remit');
			$UserID = $_REQUEST['UserID'];
			$ss_type = (int) $_REQUEST['type'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$map['user_id'] = array('like',"%".$UserID."%");
				$UserID = urlencode($UserID);
			}
			if($ss_type==1){
				$map['is_pay'] = array('egt',0);
			}elseif($ss_type==2){
				$map['is_pay'] = array('egt',1);
			}
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $remit->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $remit->where($map)->field($field)->order('or_time desc,id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================


			$this->display ();
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	
	//后台处理在线充值
	public function adminonlineRechargeAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminonlineRecharge';
			$this->_box(0,'请选择内容！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '删除';
				$this->adminonlineRechargeDel($PTid);
				break;
		default;
			$bUrl = __URL__.'/adminonlineRecharge';
			$this->_box(0,'没有该内容！',$bUrl,1);
			break;
		}
	}

	//后台处理在线充值-删除
	private function adminonlineRechargeDel($PTid=0){
		$this->_Admin_checkUser();
		if($_SESSION['UrlPTPass'] == 'MyssadminonlineRecharge'){
			$remit = M ('remit');
			$where['id'] = array ('in',$PTid);
			$where['is_pay'] = array ('eq',0);
			$trs = $remit->where($where)->delete();
			if ($trs){
				$bUrl = __URL__.'/adminonlineRecharge';
				$this->_box(1,'删除成功！',$bUrl,1);
				exit;
			}else{
				$this->error('删除失败！');
			}
		}else{
			$this->error('错误!');
		}
	}
	
	//生成订单号
	private function makeOrder(){
//     	$Order_pre='100';
    	
    	$Order = date("Y").date("m").date("d").date("H").date("i").date("s"). mt_rand(100000,999999);
    	return  $Order;
    }
	

}
?>