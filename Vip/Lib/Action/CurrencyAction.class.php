<?php 

class CurrencyAction extends CommonAction {
	
	function _initialize() {
		ob_clean();
		$this->_inject_check(0);//调用过滤函数
		$this->_checkUser();
		$this->_Config_name();//调用参数
		header("Content-Type:text/html; charset=utf-8");
	}

	public function cody(){
		//===================================二级验证
		$UrlID = (int) $_GET['c_id'];
		if (empty($UrlID)){
			$this->error('二级密码错误!');
			exit;
		}
		if(!empty($_SESSION['password2'])){
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
			if(empty($_SESSION['password2'])){
				$pass  = $_POST['oldpassword'];
				$member   =  M ('member');
				if (!$member->autoCheckToken($_POST)){
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
				$list = $member->where($where)->field('id,is_agent')->find();
				if($list == false){
					$this->error('二级密码错误!');
					exit();
				}
				$_SESSION['password2'] = 1;
			}else{
				$Urlsz = $_GET['Urlsz'];
			}
			switch ($Urlsz){
				case 1;
					$_SESSION['Urlszpass'] = 'MyssPaoYingTao';
					$bUrl = __URL__.'/withdraw';//
					$this->_boxx($bUrl);
					break;
				case 2;
					$_SESSION['Urlspass'] = 'MyssGuanPaoYingTao';
					$bUrl = __URL__.'/adminCurrency';//
					$this->_boxx($bUrl);
					break;
				
				default;
					$this->error('二级密码错误!');
					exit;
			}
		}

	//===================================================货币提现
	public function withdraw($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){
			$withdraw = M('withdraw');
			$member = M('member');
			$fee_rs = M ('fee')-> find(1);
			// 提现手续费
			$s3=$fee_rs['s3'];
			// 最低提现额度
			$s9=$fee_rs['s9'];
			$map['user_id'] = $_SESSION['loginUseracc'];
			$field  = "*,money*{$s3} as chmoney,epoint*{$s9} as chmoney_two";
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $withdraw->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $Page = new ZQPage($count,$listrows,1);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $withdraw->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;
			$field = '*';
			$rs = $member ->where($where)->field($field)->find();
			$fee_rs = M ('fee') -> find();
			// 提现手续费
			$this -> assign('menber',$fee_rs['s3']);
			// 最低提现额度
			$this -> assign('minn',$fee_rs['s9']);
			$this->assign('type',$ID);
			$this->assign('rs',$rs);
			unset($withdraw,$member,$where,$ID,$field,$rs);
			$this->display ('withdraw');
			return;
		}else{
			$this->error ('错误!');
			exit;
		}
	}

	//=================================================提现提交
	public function frontCurrencyConfirm(){
		if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){  //提现权限session认证
			$money = (int) trim($_POST['money']);
			$ttype = (int) trim($_POST['ttype']);
			$member = M ('member');
			if (empty($money) || !is_numeric($money)){
				$this->error('金额不能为空!');
				exit;
			}
			if ($money < 100){
			    $this->error ('金额不能小于100!');
			    exit;
			}
			if (strlen($money) > 12){
				$this->error ('金额太大!');
				exit;
			}
			if ($money <= 0){
				$this->error ('金额输入不正确!');
				exit;
			}
			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];

			if($ID == 1){
				$inUserID =  $_POST['UserID'];           //要提现的会员帐号
			}else{
				$inUserID =  $_SESSION['loginUseracc'];  //登录的会员帐号 user_id
			}
			$withdraw = M ('withdraw');
			$where['user_id'] = $inUserID;
			$field ='*';
			$member_rs = $member ->where($where)->field($field)->find();
			if (!$member_rs){
				$this->error('没有该会员!');
				exit;
			}
			$AgentUse = $member_rs['cash'];
			if ($AgentUse < $money){
				$this->error('账户金额不足!');
				exit;
			}
			$s_nowd = strtotime(date("Y-m-d"));
			$e_nowd = $s_nowd+3600*24;

			$where2 = array();
			$where2['user_id'] = $member_rs['user_id'];   //申请提现会员ID
			$where2['withdraw_time'] = array(array('egt',$s_nowd),array('lt',$e_nowd));
			$field1 = 'id';
			$vo5 = $withdraw ->where($where2)->sum("money");
			if ($vo5>10000){
				$this->error('每天每个账户最高提现 10000 元!');
				exit;
			}
			$where1 = array();
			$where1['user_id'] = $member_rs['user_id'];   //申请提现会员ID
			$where1['is_pay'] = 0;            //申请提现是否通过
			$where1['withdraw_type'] = $ttype;
			$field1 = 'id';
			$vo3 = $withdraw ->where($where1)->field($field1)->find();
			if ($vo3){
				$this->error('上次提现还没通过审核!');
				exit;
			}
			$fee_rs = M ('fee') -> find();
			$s9 = $fee_rs['s9'];
			$ks_m = $fee_rs['s3'];
			$hB = $s9;//最低提现额

			$bank_name = $member_rs['bank'];  //开户银行
			$bank_card = $member_rs['bankcard_number'];  //银行卡号
			$user_name = $member_rs['user_name'];   //开户姓名
			$bank_address = $member_rs['bank_address'];   //开户地址
			$tel = $member_rs['tel'];   //电话
			$ePoints_two = $money - ($money * $ks_m / 100);  //提现扣税
			$nowdate = strtotime(date('c'));
			//开始事务处理
			$withdraw->startTrans();
			//插入提现表
			$data                 = array();
			$data['uid']          = $member_rs['id'];
			$data['user_id']      = $inUserID;
			$data['withdraw_time'] = $nowdate;
			$data['money']        = $money;
			$data['epoint']       = $ePoints_two;
			$data['is_pay']       = 0;
			$data['bank']    = $bank_name;  //银行名称
			$data['bankid']    = $bank_card;  //银行地址
			$data['user_name']    = $user_name;  //开户名称
			$data['bank_address'] = $bank_address;
			$data['tel'] = $tel;
			$data['withdraw_type'] = $ttype;
			$rs2 = $withdraw->add($data);
			unset($data,$vo3,$where1);
			if ($rs2){
				//提交事务
				$member->execute("UPDATE __TABLE__ SET cash=cash-{$money} WHERE id={$member_rs['id']}");
				$withdraw->commit();
				$bUrl = __URL__.'/frontCurrency';
				$this->_box(1,'提现申请已提交，24小时之内到账！',$bUrl,1);
				exit;
			}else{
				//事务回滚：
				$withdraw->rollback();
				$this->error('货币提现失败！');
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}
	
	//=============撤销提现
	public function frontCurrencyDel(){
	    if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){
			$withdraw = M ('withdraw');
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$id = (int) $_GET['id'];
	    	$where = array();
	    	$where['id']  = $id;
	        $where['uid'] = $uid;   //申请提现会员ID
	        $where['is_pay'] = 0;            //申请提现是否通过
	        $field = 'id,money,uid';
	        $trs = $withdraw ->where($where)->field($field)->find();
	        if ($trs){
	        	$ttype = $trs['t_type'];
	            $member = M ('member');
	            if($ttype==1){
	            	$member->execute("UPDATE __TABLE__ SET agent_cf=agent_cf+{$trs['money']} WHERE id={$trs['uid']}");
	            }else{
	            	$member->execute("UPDATE __TABLE__ SET agent_use=agent_use+{$trs['money']} WHERE id={$trs['uid']}");
	            }
	            $withdraw->where($where)->delete();
	            $bUrl = __URL__.'/frontCurrency';
                $this->_box(1,'撤销提现！',$bUrl,1);
                exit;
	        }else{
	        	$this->error('没有该记录!');
                exit;
	        }
	    }else{
            $this->error('错误!');
            exit;
        }
	}
	//===============================================提现管理
	public function adminCurrency($Urlsz=0){
	   $this->_Admin_checkUser();
		if ($_SESSION['Urlspass'] == 'MyssGuanPaoYingTao'){
			$withdraw = M ('withdraw');
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			//$page_where = 'user_id=' . $_POST[userId].'&recharge_time>='.$_POST['sNowDate'].'&recharge_time<='.$_POST['endNowDate'];//分页条件
			if(!empty($_POST['userId'])){
				$page_where['user_id'] = array('eq',$_POST['userId']);
			}
			$count = $withdraw->where($page_where)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $withdraw->where($page_where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			
			$m_count = $withdraw->where($page_where)->sum('money');
			$this->assign('m_count',$m_count);
	
			$title = '提现管理';
			$this->assign('title',$title);
			$this->display('adminCurrency');
			unset($_POST, $list);
			exit();
		}else{
			$this->error('错误!');
			exit;
		}
	}
	
	
	public function withdrawAdd(){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$fee = M ('fee');
			$s3 = $fee->field('s3')->find();
			
			$fck = M ('member');
			if (!$fck->autoCheckToken($_POST)){
				$this->error('页面过期，请刷新页面！');
				exit;
			}
			$userId = $_POST['userId'];
			$userName = $_POST['userName'];
			$ePoints = $_POST['money'];
			$withdrawType = (int)$_POST['withdrawType'];
			$bankId = $_POST['bankId'];
			$bank = $_POST['bank'];
			$tel = $_POST['tel'];
			if (is_numeric($ePoints) == false){
				$this->error('金额错误，请重新输入！');
				exit;
			}
			if (!empty($userId) && !empty($userName)&& !empty($ePoints)){
				$where = array();
				$where['user_id'] = $userId;
				$where['user_name'] = $userName;
				$frs = $fck->where($where)->field('user_id, user_name')->find();
				if ($frs){
					$withdraw = M ('withdraw');
					$data = array();
					$data['user_id'] = $frs['user_id'];
					$data['user_name'] = $frs['user_name'];
					$data['money'] = $ePoints;
					$data['epoint'] = $ePoints * ((100 - $s3['s3'])/100);
					$data['withdraw_type'] = $rechargeType;
					$data['bankid'] = $bankId;
					$data['bank'] = $bank;
					$data['tel'] = $tel;
					$data['is_pay'] = 1;
					$data['withdraw_time'] = strtotime(date('c'));
					$data['update_time'] = strtotime(date('c'));
					$result = $withdraw->add($data);
					unset($data,$withdraw);
					$bUrl = __URL__.'/adminCurrency';
					$this->_box(1,'确认充值成功！',$bUrl,1);
					//$this->_adminCurrencyRechargeOpen($rearray);
				}else{
					$this->error('没有该会员，请重新输入!');
				}
				unset($fck,$frs,$where,$_POST);
			}else{
				$this->error('错误!');
			}
		}else{
			$this->error('错误!');
		}
	}
	
	//处理提现
	public function adminCurrencyAC(){
		$this->_Admin_checkUser();//后台权限检测
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$member = M ('member');
		if (empty($PTid)){
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(0,'请选择！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '确认':
				$this->adminCurrencyConfirm($PTid);
				break;
			case '删除':
				$this->adminCurrencyDel($PTid);
				break;
		default:
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(0, '没有该记录！', $bUrl,1);
			break;
		}
	}
	
	//====================================================确认提现
	private function adminCurrencyConfirm($PTid){
			$withdraw = M ('withdraw');
			$where = array();
			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$data['update_time'] = strtotime(date('c'));
			$data['is_pay'] = 1;
			$rs = $withdraw->where($where)->save($data);
			if ($rs) {
			    unset($recharge,$where,$rs,$data);
			    $bUrl = __URL__.'/adminCurrency';
			    $this->_box(1,'确认提现成功！',$bUrl,1);
			    
			} else {
			    unset($recharge,$where,$rs,$data);
			    $bUrl = __URL__.'/adminCurrency';
			    $this->_box(0,'确认提现失败！',$bUrl,1);
			    exit;
			}
			
	}
	//删除提现
	private function adminCurrencyDel($PTid){
	if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$withdraw = M ('withdraw');
			$where = array();
			//$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $withdraw->where($where)->delete();
			if ($rs){
				$bUrl = __URL__.'/adminCurrency';
				$this->_box(1,'删除成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminCurrency';
				$this->_box(0,'删除失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
			exit;
		}
	}
    //导出excel
	public function DaoChu(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
			header("Content-Type:   application/vnd.ms-excel");
			header("Content-Disposition:   attachment;   filename=Cash.xls");
			header("Pragma:   no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires:   0");
			echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
			//   输出标题
			echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
			//   输出字段名
			echo   '<tr >';
			echo   "<td>会员编号</td>";
			echo   "<td>开户名</td>";
			echo   "<td>开户银行</td>";
			echo   "<td>银行帐号</td>";
			echo   "<td>提现金额</td>";
			echo   "<td>实发金额</td>";
			echo   "<td>提现时间</td>";
			echo   "<td>状态</td>";
			echo   '</tr>';
			//   输出内容
			$withdraw = M ('withdraw');
			$trs = $withdraw->select();
			foreach($trs as $row)   {

			if ($row['is_pay']==0){
			    $isPay = '未确认';
			}else{
			    $isPay = '已确认';
			}
			echo   '<tr>';
			echo   '<td>'   .   $row['user_id']   .   '</td>';
			echo   '<td>'   .   $row['user_name']   .   '</td>';
			echo   '<td>'   .   $row['bank_name']   .   '</td>';
			echo   "<td>"  .  chr(28).$row['bank_card'] .  "</td>";
			echo   '<td>'   .   $row['money']   .   '</td>';
			echo   '<td>'   .   $row['money_two']   .   '</td>';
			echo   '<td>'   .   date('Y-m-d',$row['rdt'])   .   '</td>';
			echo   '<td>'   .  $isPay    .   '</td>';
			echo   '</tr>';
			}
			echo   '</table>';
			}else{
				$this->error('错误!');
				exit;
			}
	}

	public function DaoChu1(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
			header("Content-Type:   application/vnd.ms-excel");
			header("Content-Disposition:   attachment;   filename=test.xls");
			header("Pragma:   no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires:   0");
			echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
			//   输出标题
			echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
			//   输出字段名
			echo   '<tr >';
			echo   "<td>会员编号</td>";
			echo   "<td>开户名</td>";
			echo   "<td>开户银行</td>";
			echo   "<td>银行帐号</td>";
			echo   "<td>提现金额</td>";
			echo   "<td>实发金额</td>";
			echo   "<td>提现时间</td>";
			echo   "<td>状态</td>";
			echo   '</tr>';
			//   输出内容
			$withdraw = M ('withdraw');
			$trs = $withdraw->select();
			foreach($trs as $row)   {
				if ($row['is_pay']==0){
				    $isPay = '未确认';
				}else{
				    $isPay = '已确认';
				}
				echo   '<tr>';
				echo   '<td>'   .   $row['user_id']   .   '</td>';
				echo   '<td>'   .   $row['user_name']   .   '</td>';
				echo   '<td>'   .   $row['bank_name']   .   '</td>';
				echo   "<td>,"  .  chr(28).$row['bank_card'] .  "</td>";
				echo   '<td>'   .   $row['money']   .   '</td>';
				echo   '<td>'   .   $row['money_two']   .   '</td>';
				echo   '<td>'   .   date('Y-m-d',$row['rdt'])   .   '</td>';
				echo   '<td>'   .  $isPay    .   '</td>';
				echo   '</tr>';
			}
			echo   '</table>';
		}else{
			$this->error('错误!');
			exit;
		}
	}
}
?>