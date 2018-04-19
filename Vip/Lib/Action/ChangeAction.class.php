<?php
class ChangeAction extends CommonAction {
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(1);//调用过滤函数
		$this->_checkUser();
		$this->check_us_gq();
	}
	
	//二级密码验证
	public function cody(){
		$UrlID = (int)$_GET['c_id'];
		if (empty($UrlID)){
			$this->error('二级密码错误!');
			exit;
		}
		if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$member   =  M ('cody');
 $list	=  $member->where("c_id=$UrlID")->getField('c_id');
		if (!empty($list)){
			$this->assign('vo',$list);
			$this->display('Public:cody');
			exit;
		}else{
			$this->error('二级密码错误!');
			exit;
		}
	}
	//二级验证后调转页面
	public function codys(){
		$Urlsz = $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
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

			$where =array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['password2'] = md5($pass);
			$list = $member->where($where)->field('id')->find();
			if($list == false){
				$this->error('二级密码错误!');
				exit();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz){
			case 1:
				$_SESSION['DLTZURL02'] = 'changedata';
				$bUrl = __URL__.'/profile';//修改资料
				$this->_boxx($bUrl);
				break;
			case 2:
				$_SESSION['DLTZURL01'] = 'changepassword';
				$bUrl = __URL__.'/changepassword';//修改密码
				$this->_boxx($bUrl);
				break;
			case 3:
				$_SESSION['DLTZURL01'] = 'pprofile';
				$bUrl = __URL__.'/pprofile';//修改密码
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('二级密码错误!');
				break;
		}
	}
	
	/* ---------------显示用户修改资料界面---------------- */
	public function profile(){
		$member	 =	 M('member');
		$id   = $_SESSION[C('USER_AUTH_KEY')];
		//输出登录用户资料记录
		$vo	= $member -> getById($id);  //该登录会员记录
		if(empty($vo['us_img'])){
			$vo['us_img'] = "__PUBLIC__/Images/mctxico.jpg";
		}
		$this->assign('vo',$vo);
		$this->assign('img_src',$vo['us_img']);
		unset($vo);
		//输出银行
		$b_bank = $member -> where('id='.$id) -> field("bank,user_name") -> find();
		$this->assign('b_bank',$b_bank);
		unset($bank,$b_bank);
		$fee = M ('fee');
		$fee_s = $fee->field('*')->find();
		$bank = explode('|',$fee_s['s10']);
		$this->assign('bank',$bank);
		$this->display('profile');
	}

	/* --------------- 修改保存会员信息 ---------------- */
	public function changedataSave(){
		if ($_SESSION['DLTZURL02'] == 'changedata'){
			$member = M('member');
			$myw = array();
			$myw['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$mrs = $member->where($myw)->field('*')->find();
			if(!$mrs){
				$this->error('非法提交数据!');
				exit;
			}
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
			if(strlen(trim($_POST['tel'])) != 11){
			    $this->error('请输入11位手机号！');
			    exit;
			}
			$data = array();
			$data['id'] = $_SESSION[C('USER_AUTH_KEY')]; //主键
			$data['bank'] = $_POST['bank']; //银行名称
			$data['bankcard_number']  = $_POST['bankcard_number']; //银行卡号
			$data['user_name'] = $_POST['user_name']; //开户姓名
			$data['bank_province'] = $_POST['bank_province'];    //省份
			$data['bank_city'] = $_POST['bank_city']; //城市
			$data['bank_address'] = $_POST['bank_address'];     //开户地址
			$data['user_code'] = $_POST['user_code']; //身份证号码
			$data['tel']  = $_POST['tel'];  //联系电话
			// 一级密码不加密
			$data['pwd1'] = trim($_POST['password']);
			// 二级密码不加密
			$data['pwd2'] = trim($_POST['password2']);
			// 一级密码加密
			$data['password'] = md5(trim($_POST['password']));
			// 二级密码加密
			$data['password2'] = md5(trim($_POST['password2']));
			$usimg = trim($_POST['us_img']);// 用户头像
			if(!empty($usimg)){
				$data['us_img'] = $usimg;
			}
			$rs = $member->save($data);
			if($rs){
				$bUrl = __URL__.'/profile';
				$this->_box(1,'资料修改成功！',$bUrl,1);
			} else {
			    $this->_box(1,'资料修改成功！',$bUrl,1);
			}
		}else{
			$this->error('操作错误!');
			exit;
		}
	}
	
	/* ********************** 修改密码 ********************* */
	public function changepassword(){
		if ($_SESSION['DLTZURL01'] == 'changepassword'){
			$member = M('member');

			$id   = $_SESSION[C('USER_AUTH_KEY')];
			//输出登录用户资料记录
			$where = array();
			$where['id'] = array('eq',$id);
			$vo	= $member ->where($where)->find();
			$this->assign('vo',$vo);
			unset($vo);

			$this->display('changepassword');
		}else{
			$this->error('操作错误!');
			exit;
		}
	}


    /* ********************** 修改密码 ********************* */
    public function changepasswordSave(){
    	if ($_SESSION['DLTZURL01'] == 'changepassword'){
			$member    =   M('member');
			if(md5($_POST['verify']) != $_SESSION['verify']) {
				$this->error('验证码错误！');
				exit;
			}
	
			$myw = array();
			$myw['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$mrs = $member->where($myw)->field('id,wenti_dan')->find();
			if(!$mrs){
				$this->error('非法提交数据!');
				exit;
			}else{
				$mydaan = $mrs['wenti_dan'];
			}
	
//			$huida = trim($_POST['wenti_dan']);
//			if(empty($huida)){
//				$this->error('请输入底部的密保答案！');
//				exit;
//			}
//			if($huida!=$mydaan){
//				$this->error('密保答案验证不正确！');
//				exit;
//			}
	
			$map	=	array();
	
			//检测密码级别及获取旧密码
			if ($_POST['type'] == 1){
				$map['Password']  = pwdHash($_POST['oldpassword']);
			}elseif($_POST['type'] == 2){
				$map['passopen']  = pwdHash($_POST['oldpassword']);
			}elseif($_POST['type'] == 3){
				$map['passopentwo'] = pwdHash($_POST['oldpassword']);
			}else{
				$this->error('请选择修改密码级别！');
				exit;
			}
	
			//检查两次密码是否相等
			if($_POST['password'] != $_POST['repassword']){
				$this->error('两次输入的密码不相等！');
				exit;
			}
	
	 if(isset($_POST['account'])){
	     $map['user_id']	 =	 $_POST['account'];
	 }elseif(isset($_SESSION[C('USER_AUTH_KEY')])){
	     $map['id']	     =	 $_SESSION[C('USER_AUTH_KEY')];
	 }
	
	 //检查用户
			$result = $member->where($map)->field('id')->find();
	 if(!$result){
	     $this->error('旧密码错误！');
	 }else {
				//修改密码
				$pwds = pwdHash($_POST['password']);
				if ($_POST['type'] == 1){
					$member->where($map)->setField('pwd1',$_POST['password']);  //一级密码不加密
					$member->where($map)->setField('password',$pwds);    //一级密码加密
				}elseif($_POST['type'] == 2){
					$member->where($map)->setField('pwd2',$_POST['password']);  //二级密码不加密
					$member->where($map)->setField('passopen',$pwds);    //二级密码加密
				}elseif($_POST['type'] == 3){
					$member->where($map)->setField('pwd3',$_POST['password']);  //三级密码不加密
					$member->where($map)->setField('passopentwo',$pwds);   //三级密码加密
				}
				//9260729
				//$member->save();
			//生成认证条件
	 $mapp     =   array();
			// 支持使用绑定帐号登录
			$mapp['id']    = $_SESSION[C('USER_AUTH_KEY')];
			$mapp['user_id']	= $_SESSION['loginUseracc'];
			import ( '@.ORG.RBAC' );
	 $authInfoo = RBAC::authenticate($mapp);
	 if(false === $authInfoo) {
	     $this->LinkOut();
				$this->error('帐号不存在！');
				exit;
	 }else {
				//更新session
				$_SESSION['login_sf_list_u'] = md5($authInfoo['user_id'].'wodetp_new_1012!@#'.$authInfoo['password'].$_SERVER['HTTP_USER_AGENT']);
			}
				$bUrl = __URL__.'/changepassword';
				$this->_box(1,'修改密码成功！',$bUrl,1);
				exit;
	 }
    	}else{
			$this->error('操作错误!');
			exit;
		}
    }

    public function pprofile() {
		//列表过滤器，生成查询Map对象
		$id  = $_SESSION[C('USER_AUTH_KEY')];
		$member = M ('member');
		//会员
    $u_all = $member -> where('id='.$id)->field('*') -> find();
		$lev = $u_all['u_level']-1;

		$fee = M('fee');
		$fee_rs = $fee->field('s4,s10,a_money,b_money')->find();
		$s4 = explode('|',$fee_rs['s4']);
		$Level = explode('|',$fee_rs['s10']);
		$a_money = $fee_rs['a_money'];
		$b_money = $fee_rs['b_money'];
		$all_money = $a_money+$b_money;
		$all_money = number_format($all_money,2);
		$this->assign('all_money',$all_money);

		$this -> assign('mycg',$s4[$lev]);//会员级别
		$this -> assign('u_level',$Level[$lev]);//会员级别
		$this -> assign('rs',$u_all);
        $this->display();
    }
    
	/* 上传图片 */
	public function uploadImg(){
		import('@.ORG.UploadFile');
// 		$fileName = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);
		$fileName = $_SESSION[C('USER_AUTH_KEY')];
		$upload = new UploadFile();						// 实例化上传类
		$upload->maxSize = 1*1024*1024;					//设置上传图片的大小
		$upload->allowExts = array('jpg','jpeg','png','gif');	//设置上传图片的后缀
		$upload->uploadReplace = true;					//同名则替换
		$upload->saveRule = 'temp';					//设置上传头像命名规则(临时图片),修改了UploadFile上 传类
		$upload->saveRule = $fileName;
		//完整的头像路径
		$path = './Public/Uploads/';
		$upload->savePath = $path;
		if(!$upload->upload()) {						// 上传错误提示错误信息
			$this->ajaxReturn('',$upload->getErrorMsg(),0,'json');
		}else{										// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$temp_size = getimagesize($fileName.'.jpg');
// 			if($temp_size[0] < 100 || $temp_size[1] < 100){//判断宽和高是否符合头像要求
// 				$this->ajaxReturn(0,'图片宽或高不得小于100px!',0,'json');
// 			}
			$this->ajaxReturn(__ROOT__.'/Public/Uploads/'.$fileName.'.jpg',$info,1,'json');
		}
	}
    
	//裁剪并保存图像
	public function cropImg(){
		//图片裁剪数据
		$params = $_POST;						//裁剪参数
		if(!isset($params) && empty($params)){
			return;
		}
		//随时间生成文件名
// 		$randPath = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);
		$randPath = $_SESSION[C('USER_AUTH_KEY')];
		//头像目录地址
		$path = './Public/Uploads/';
		//要保存的图片
		$real_path = $path.$randPath.'.jpg';
		//临时图片地址
		$pic_path = $path.$randPath.'.jpg';
		import('@.ORG.ThinkImage.ThinkImage');
		$Think_img = new ThinkImage(THINKIMAGE_GD); 
		//裁剪原图
		$Think_img->open($pic_path)->crop($params['w'],$params['h'],$params['x'],$params['y'])->save($real_path);
		//生成缩略图
		$final_path = $path.$randPath.'avatar_150_150.jpg';
		$Think_img->open($pic_path)->thumb(150,150, 1)->save($final_path);
// 		$Think_img->open($real_path)->thumb(60,60, 1)->save($path.'avatar_60.jpg');
// 		$Think_img->open($real_path)->thumb(30,30, 1)->save($path.'avatar_30.jpg');
		$out_realpath = str_replace("./","/",__ROOT__.$final_path);
		echo "<script>window.parent.form1.img_src.src='".$out_realpath."';</script>";
		$real_path=(str_replace('./Public/','__PUBLIC__/',$out_realpath));
		echo "<script>window.parent.form1.img_src.value='".$real_path."';</script>";
		
		$member	 =	 M('member');
		$id   = $_SESSION[C('USER_AUTH_KEY')];
		//输出登录用户资料记录
		$vo	= $member -> getById($id);  //该登录会员记录
		if(empty($vo['us_img'])){
		    $vo['us_img'] = "__PUBLIC__/Images/mctxico.jpg";
		}
		$this->assign('vo',$vo);
		$this->assign('img_src',$out_realpath);
		$this->assign('img_value',$real_path);
		$this->assign('us_img',$real_path);
		unset($vo);
		//输出银行
		$b_bank = $member -> where('id='.$id) -> field("bank,user_name") -> find();
		$this->assign('b_bank',$b_bank);
		unset($bank,$b_bank);
		$fee = M ('fee');
		$fee_s = $fee->field('*')->find();
		$bank = explode('|',$fee_s['s10']);
		$this->assign('bank',$bank);
// 		$this->success('图像保存成功','profile');
		$this->display('profile');
	}

}
?>