<?php
class RegAction extends CommonAction{
 // 初始化方法
	function _initialize() {
// 		$this->_inject_check(0);//调用过滤函数
 		$this->_Config_name();
// 		$this->_checkUser();
		header("Content-Type:text/html; charset=utf-8");
	}
	/**
 * 注册处理
 * **/
	//前台注册
	public function us_reg(){
 // 会员表
		$member = M ('member');
		// 参数表
		$fee = M ('fee');
		// 取得二维码传递的ID作为推荐人ID
		$reid = $_GET['rid'];
		// 查询参数表
		$fee_rs = $fee->field('s1')->find();
		$this->assign('s1',$fee_rs['s1']);
		//检测推荐人
		$this->display();
	}
	//前台注册处理
	public function regAC() {
		$member = M ('member');  //注册表
		if (strlen($_POST['user_id']) < 1){
			$this->error('用户名不能为空！');
			exit;
		}
		/**=======前台数据验证===开始=============**/
		// 验证密码
		if(strlen($_POST['password']) < 6 or strlen($_POST['password']) > 16){
	    $this->error('密码应该6-16位之间！');
	    exit;
		}
		// 验证电话号码
		if(empty($_POST['tel'])){
	    $this->error('请填写电话号码！');
	    exit;
		}
		// 验证电话号码
		if(strlen($_POST['tel']) != 11){
		    $this->error('电话号码必须是11位！');
		    exit;
		}
		// 节点关系
	    if(empty($_POST['father_id'])){
	    $this->error('请填写你的朋友帐号！');
	    exit;
		}
		unset($authInfoo,$mappp);
		$fwhere = array();//检测帐号是否存在
		$fwhere['user_id'] = trim($_POST['user_id']);
		// 验证用户名
		$frs = $member->where($fwhere)->field('id')->find();
		if ($frs){
		    $this->error('该用户名已存在！');
		    exit;
		}
		$kk = stripos($fwhere['user_id'],'-');
		if($kk){
		    $this->error('用户名中不能有扛(-)符号！');
		    exit;
		}
		unset($fwhere,$frs);
		/**=======前台数据验证===结束===============**/
		// 待存储数据对象
		$data = array();
		// 获取推荐会员帐号
		$RID = trim($_POST['rid']);
		$mapp  = array();
		$mapp['user_id']	= $RID;
		$mapp['bk4'] = 1;
		// 查询推荐人
		$authInfoo = $member->where($mapp)->field('id,user_id,bk1,re_path')->find();
		if ($authInfoo){
			$data['re_path'] = $authInfoo['re_path'].$authInfoo['id'].',';  //推荐路径
			$data['re_id'] = $authInfoo['id'];  //推荐人ID
			$data['re_name'] = $authInfoo['user_id'];   //推荐人帐号
			$data['bk1'] = $authInfoo['bk1'] + 1;   //推荐绝对层数
		}else{
			$this->error('推荐人不存在！');
			exit;
		}
		unset($authInfoo,$mapp);
		//检测上节点人
		$FID = trim($_POST['father_id']);  //上节点帐号
		$mappp  = array();
		$mappp['user_id'] = $FID;
		$authInfoo = $member->where($mappp)->field('id,p_path,bk2,user_id')->find();
		if ($authInfoo){
			$data['p_path'] = $authInfoo['p_path'].$authInfoo['id'].',';  //绝对路径
			$data['father_id'] = $authInfoo['id']; //上节点ID
			$data['father_name'] = $authInfoo['user_id'];   //上节点帐号
			$data['bk2'] = $authInfoo['bk2'] + 1;   //路径绝对层数
			
		} else {
			$this->error('填写的朋友关系不存在！');
			exit;
		}
		unset($mappp,$authInfoo);
		//检测报单中心
		$authInfoo = $this->find_shopid($RID);
		// 报单中心的用户名
	    $data['bk5'] = $authInfoo['user_id'];
	    // 报单中心姓名
	    $data['bk6'] = $authInfoo['user_name'];
		// 查询参数表
		$fee  = M ('fee') -> find();
		// 投资金额
		$s1 = $fee['s1'];
		// 注册成功提示消息
		$s11 = $fee['s11'];
		// 当前日期
		$data['user_id']   = $_POST['user_id'];
		$data['status'] = 0;  //状态：0:正常 1：禁止登录
		$data['password']  = md5(trim($_POST['password']));  //一级密码加密
		$data['pwd1']  = trim($_POST['password']);   //一级密码不加密
		$data['user_name'] = $_POST['user_name'];   //姓名
		$data['tel']  = $_POST['tel']; //联系电话
		$data['bk4'] = 0; //是否支付 0：未支付 1：已支付
		$data['register_time']  = time(); //注册时间
		$data['grade']   = 0;  //注册等级 0:普通用户 1：会员 2：管理员
		$data['money']  = 0;  //注册金额
		$data['cash']  = 0;  //现金币
		$data['point']  = 0;  //积分
		$data['us_img']  = "__PUBLIC__/Images/mctxico.jpg";
		$result = $member->add($data);
		unset($data,$member);
		if($result) {
			echo "<script>";
			echo "alert('您的用户名：".$_POST['user_id'].'\r\n'.$s11."');";
			echo "window.location='".__APP__."/Public/login/';";
			echo "</script>";
			exit;
		} else {
			$this->error('会员注册失败！');
			exit;
		}
	}
	// 递归检测报单中心
	public function find_shopid($user_id) {
	    $member = M('member');
	    $mappp  = array();
	    $mappp['user_id'] = $user_id;
	    $authInfoo = $member->where($mappp)->field('user_id,user_name,is_agent,father_id,father_name')->find();
	    if ($authInfoo['is_agent'] == 1){
	        return $authInfoo;
	    } else {
	        $authInfoo = $this->find_shopid($authInfoo['father_name']);
	        return $authInfoo;
	    }
	}
	
	// 找回密码
	public function find_pw_s() {
			if(empty($_POST['user_id']) || empty($_POST['tel'])) {
				$errarry['err']='<font color=red>注：用户名或者手机号不能为空！</font>';
				$this->assign('errarry',$errarry);
				$this->display('find_pw');
			}
			// 验证用户是否存在
			$ptname=$_POST['user_id'];
			$tel=$_POST['tel'];
			$member = M('member');
			$rs=$member->where("user_id='".$ptname."'")->field('id,tel,user_id,user_name,pwd1,pwd2')->find();
			if ($rs==false){
				$errarry['err']='<font color=red>注：没有此用户，请正确填写登录用户名！</font>';
				$this->assign('errarry',$errarry);
				$this->display('find_pw');
			}else{
			    // 验证手机号
				if($tel<>$rs['tel']){
					$errarry['err']='<font color=red>注：手机号码错误，请正确填写绑定手机号！</font>';
					$this->assign('errarry',$errarry);
					$this->display('find_pw');
				}else{
				    $this->display('find_pw_s');
				}
			}
	}
}
?>