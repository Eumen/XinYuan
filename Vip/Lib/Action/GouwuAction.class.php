<?php
class GouwuAction extends CommonAction{

    function _initialize() {
		$this->_inject_check(0); //调用过滤函数
		$this->_checkUser();
		$this->check_us_gq();
		header("Content-Type:text/html; charset=utf-8");
	}

    //二级验证
    public function Cody(){
        $this->_checkUser();
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
		$list   =  $cody->where("c_id=$UrlID")->field('c_id')->find();
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
	public function Codys() {
		$Urlsz = $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass = $_POST['oldpassword'];
			$member = M('member');
			if (!$member->autoCheckToken($_POST)) {
				$this->error('页面过期请刷新页面!');
				exit ();
			}
			if (empty ($pass)) {
				$this->error('二级密码错误!');
				exit ();
			}
			$where = array ();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $member->where($where)->field('id')->find();
			if ($list == false) {
				$this->error('二级密码错误!');
				exit ();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz) {
			case 1;
				$_SESSION['UrlszUserpass'] = 'MyssGuanChanPin';
				$bUrl = __URL__ . '/pro_index';
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlszUserpass'] = 'MyssWuliuList';
				$bUrl = __URL__ . '/adminLogistics';
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlszUserpass'] = 'ACmilan';
				$bUrl = __URL__ . '/Buycp';
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlszUserpass'] = 'manlian';
				$bUrl = __URL__ . '/BuycpInfo';
				$this->_boxx($bUrl);
				break;
			case 6;
    			$_SESSION['UrlszUserpass'] = 'mallIndex';
    			$bUrl = __URL__ . '/mallIndex';
				$this->_boxx($bUrl);
    			break;
				exit;
			default;
			case 5;
				$_SESSION['UrlszUserpass'] = 'ACmil';
				$bUrl = __URL__ . '/dizhiadd';
				$this->_boxx($bUrl);
				break;
				$this->error('二级密码错误!');
				break;
		}
	}


    //会员表
    public function financeDaoChu_MM(){
        //导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Member.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");
			$shopping = M ('gouwu');
			$product = M('product');
    $UserID = $_REQUEST['UserID'];
    $ss_type = (int) $_REQUEST['type'];
    $map = array();
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
			if($ss_type==0){
				$map['bk3'] = array('egt',0);
			}elseif($ss_type==1){
				$map['bk3'] = array('eq',0);
			}elseif($ss_type==2){
				$map['bk3'] = array('eq',1);
			}elseif($ss_type==3){
				$map['bk3'] = array('eq',2);
			}
    //查询字段
    $field   = '*';
    //=====================分页开始==============================================
    import ( "@.ORG.ZQPage" );  //导入分页类
    $count = $shopping->where($map)->count();//总页数
    $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		    $page_where = 'UserID='.$UserID.'&bk3='.$ss_type;//分页条件
    $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
    //===============(总页数,每页显示记录数,css样式 0-9)
    $show = $Page->show();//分页变量
    $this->assign('page',$show);//分页变量输出到模板
    $list = $shopping ->where($map)->field($field)->page($Page->getPage().','.$listrows)->select();
    $this->assign('list',$list);//数据输出到模板
    //=================================================
    foreach($list as $vv){
    	$ttid = $vv['did'];
    	$trs = $product->where('id='.$ttid)->find();
    	$voo[$ttid] = $trs['name'];
    }
    $this->assign('voo',$voo);
        $gouwu = M ('gouwu');  //购物表
        $map = array();
		$map['id'] = array('gt',0);
		$map['bk3'] = array('egt',0);
        $field   = '*';
		$list = $gouwu->where($map)->field($field)->order('time asc')->select();

        $title   =   "会员表 导出时间:".date("Y-m-d   H:i:s");

        echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo   '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">'   .   $title   .   '</td></tr>';
        //   输出字段名
        echo   '<tr  align=center>';
        echo   "<td>序号</td>";
        echo   "<td>会员编号</td>";
        echo   "<td>购货时间</td>";
        echo   "<td>收货人</td>";
        echo   "<td>收货地址</td>";
        echo   "<td>电话</td>";
        echo   "<td>产品名称</td>";
        echo   "<td>数量</td>";
        echo   "<td>总价</td>";
        echo   "<td>确认发货人</td>";
        echo   "<td>确认时间</td>";
        echo   "<td>确认收货人</td>";
        echo   "<td>确认收货时间</td>";
        echo   "<td>状态</td>";
        echo   '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach($list as $row)   {
    $i++;
    $num = strlen($i);
    if ($num == 1){
        $num = '000'.$i;
    }elseif ($num == 2){
        $num = '00'.$i;
    }elseif ($num == 3){
        $num = '0'.$i;
    }else{
    	$num = $i;
    }
    echo   '<tr align=center>';
    echo   '<td>'   .  chr(28).$num   .   '</td>';
    echo   "<td>"   .   $row['user_id'].  "</td>";
     echo   "<td>"   .   date("Y-m-d H:i:s",$row['time']).  "</td>";
    echo   "<td>"   .   $row['user_name'].  "</td>";
    echo   "<td>"   .   $row['address'].  "</td>";
    echo   "<td>"   .   $row['tel']. "</td>";
    echo   "<td>"   .   $voo[$row['did']].  "</td>";
    echo   "<td>"   .   $row['count'].  "</td>";
    echo   "<td>"   .   $row['money'].  "</td>";
    echo   "<td>"   .   $row['confirm_send_id'].  "</td>";
    echo   "<td>"   .   $row['confirm_send_time'].  "</td>";
    echo   "<td>"   .   $row['confirm_receive_id'].  "</td>";
    echo   "<td>"   .   $row['confirm_receive_time'].  "</td>";
    if ($row['bk3'] == 1) {
        echo   "<td>"   .   "已发货".  "</td>";
    } else if ($row['bk3'] == 0){
        echo   "<td>"   .   "未发货".  "</td>";
    } else if ($row['bk3'] == 2){
        echo   "<td>"   .   "已收货".  "</td>";
    }

    echo   '</tr>';
        }
        echo   '</table>';
    }
	//显示产品信息
    public function Cpcontent() {
		$member = M('member');
		$product = M ('product');
		$PID = (int) $_GET['id'];
		// 检索会员表
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $member->where($map)->find();
		// 检索产品表
		$where = array();
		$where['id'] = $PID;
		$where['yc_cp'] = array('eq',0);
		$prs = $product->where($where)->field('*')->find();
		if ($prs){
			$this->assign('prs',$prs);
			// 零售价
        	$w_money = $prs['sale_price'];
        	// 会员价
        	$e_money = $prs['vip_price'];
			$cc[$prs['sale_price']] = $w_money;
			$cc[$prs['vip_price']] = $e_money;
			$cc[$prs['stock_count']] = $prs['stock_count'];
	        $this->assign('cc',$cc);
			$this->assign('f_rs', $f_rs);
			$this->display('Cpcontent');
		}
	}

    public function Buycp() { //购买产品页
		// 检索会员表
		$member = M('member');
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $member->where($map)->find();
		$product = M('product');
		$where = array();
		// 产品分类类型
		$ss_type = (int) $_REQUEST['tp'];
		if($ss_type>0){
			$where['cptype'] = array('eq',$ss_type);
		}
		$this->assign('tp',$ss_type);
		// 未被屏蔽的产品
		$where['yc_cp'] = array('eq',0);
        // 查询商品分类表
		$cptype = M('cptype');
		$tplist = $cptype->where('status=0')->order('id asc')->select();
		$this->assign('tplist',$tplist);

		$order = 'id asc';
	    $field   = '*';
        //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $product->where($where)->count();//总页数
   		$listrows = 20;//每页显示的记录数
        $page_where = 'tp='.$ss_type;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $product->where($where)->field($field)->order('id asc')->page($Page->getPage().','.$listrows)->select();
        //=================================================
        foreach($list as $voo){
            // 零售价
			$w_money = $voo['sale_price'];
			// 会员价
			$e_money = $voo['vip_price'];
			$cc[$voo['id']] = $w_money;
			$cc[$voo['cid']] = $e_money;
        }
        $this->assign('cc',$cc);
		$this->assign('list',$list);//数据输出到模板
		$this->assign('f_rs', $f_rs);
		$this->display('Buycp');
	}

	public function shopCar(){
		// 查询会员表信息
		$member = M('member');
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $member->where($map)->find();
		// 现金币
		$cash = $f_rs['cash'];
		$point = $f_rs['point'];
		$this->assign('f_rs',$f_rs);
		$id = $_REQUEST['id'];
		$arr = $_SESSION["shopping"];
		if(empty($arr)){
			$url = __URL__.'/Buycp';
			$this->_box(0,'您的购物车里没有商品！',$url,1);
			exit;
		}
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$path .= $str[0].',';
			$ids[$str[0]] = $str[1];
		}
		// 查询商品信息
		$product = M('product');
		$where['id'] = array('in','0'. $path .'0');
		$list = $product -> where($where) ->select();
		foreach ($list as $lvo){
		    if ($f_rs['grade'] > 0) {
		        $w_money = $lvo['vip_price'];
		    } else {
		        $w_money = $lvo['sale_price'];
		    }
			//物品总价
			$ep[$lvo['id']] = $ids[$lvo['id']] * $w_money;
			$num[$lvo['id']] = $ids[$lvo['id']];
			//所有商品总价
			$eps += $ids[$lvo['id']] * $w_money;
			$sum += $ids[$lvo['id']];
			$cc[$lvo['id']] = $w_money;
		}
		$bza = $_SESSION["shopping_bz"];
		$blrs = explode("|",$bza);
		$bzz = array();
		foreach($blrs as $vvv){
			$vava = explode(",",$vvv);
			$bzz[$vava[0]] = $vava[1];
		}
		$this->assign('bzz',$bzz);
		$this->assign('cc',$cc);
		$this->assign('list',$list);
		$this->assign('path',$path);
		$this->assign('ids',$ids);
		$this->assign('num',$num);
		$this->assign('sum',$sum);
		$this->assign('eps',$eps);
		$this->assign('ep',$ep);
		$this->display('shopCar');

	}

	public function delBuyList(){
		$ID = $_REQUEST['id'];
		$shopping_id ='';
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				unset($rs[$key]);
			}else{
				if(empty($shopping_id)){
					$shopping_id = $vo;
				}else{
					$shopping_id .= '|'.$vo;
				}
			}
		}
		$_SESSION["shopping"] = $shopping_id;
		$this->success("删除成功！");
	}
	public function reset(){
		//清空购物车
		$_SESSION["shopping"] = array();
		$_SESSION["shopping_bz"] = array();
		$url = __URL__.'/Buycp';
		$this->success("清空完成！");
	}
	public function chang(){
		$ID = $_GET['DID'];
		$nums = $_GET['nums'];
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$shopping_id = '';
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				$str[1] = $nums;
			}
			$s_id = $str[0].','.$str[1];
			if(empty($shopping_id)){
				$shopping_id = $s_id;
			}else{
				$shopping_id .= '|'.$s_id;
			}
		}
		$_SESSION["shopping"] = $shopping_id;
	}

	public function chang_bz(){
		$ID = $_GET['DID'];
		$nums = trim($_GET['bzz']);

		if (!empty($nums)){
			import ( "@.ORG.KuoZhan" );  //导入扩展类
    $KuoZhan = new KuoZhan();
    if ($KuoZhan->is_utf8($nums) == false){
        $nums = iconv('GB2312','UTF-8',$nums);
    }
    unset($KuoZhan);
		}
		if(empty($_SESSION["shopping_bz"])){
			$_SESSION["shopping_bz"] = $ID.",".$nums;
		}
		$arr = $_SESSION["shopping_bz"];

		$rs = explode('|',$arr);
		$shopping_id = '';
		$tong = 0;
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				$tong = 1;
				$str[1] = $nums;
			}
			$s_id = $str[0].','.$str[1];
			if(empty($shopping_id)){
				$shopping_id = $s_id;
			}else{
				$shopping_id .= '|'.$s_id;
			}
		}
		if($tong==0){
			$shopping_id .= "|".$ID.",".$nums;
		}
		$_SESSION["shopping_bz"] = $shopping_id;
	}
public function dizhiAdd(){
		$address = M('address');
		// 用户名
		$user_id = $_SESSION['loginUseracc'];
		// 根据用户名检索用户地址信息
		$where = array();
		$where['user_id'] = $user_id;
		$aList = $address->field("*")->where($where)->select();
		$this->assign('aList',$aList);
        // 查询会员表信息
		$member = M('member');
		$member_rs = $member->where($where)->find();
		$this->assign('member_rs',$member_rs);
		unset($where,$address);
		$this -> display();
	}
	public function ShoppingListAdd(){
	    // 检索地址信息
		$address = M('address');
		$user_id = $_SESSION['loginUseracc'];
		$where = array();
		$where['user_id'] = $user_id;
		$aList = $address->where($where)->select();
		$this->assign('aList',$aList);
		// 检索会员表信息
		$member = M('member');
		$member_rs = $member->where($where)->find();
		$this->assign('member_rs',$member_rs);
        unset($where,$member);
		// 购物车信息分割
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$ids[$str[0]] = $str[1];
			$path .= $str[0].',';
		}
		// 检索产品表信息
		$pora = M('product');
		$where['id'] = array('in','0'. $path .'0');
		$list = $pora -> where($where) ->select();
		foreach ($list as $lvo){
			$w_money = $lvo['vip_price'];
			//物品总价
			$ep[$lvo['id']] = $ids[$lvo['id']] * $w_money;
			//所有商品总价
			$eps += $ids[$lvo['id']] * $w_money;
			$sum += $ids[$lvo['id']];
			$cc[$lvo['id']] = $w_money;
		}
		$bza = $_SESSION["shopping_bz"];
		$blrs = explode("|",$bza);
		$bzz = array();
		foreach($blrs as $vvv){
			$vava = explode(",",$vvv);
			$bzz[$vava[0]] = $vava[1];
		}
		$this->assign('bzz',$bzz);
		$this->assign('cc',$cc);
		$this->assign('list',$list);
		$this->assign('path',$path);
		$this->assign('ids',$ids);
		$this->assign('sum',$sum);
		$this->assign('eps',$eps);
		$this->assign('ep',$ep);

		$this -> display('ShoppingListAdd');
	}

	public function addAddress() {
		$address = M('address');
		$user_id = $_SESSION['loginUseracc'];
		$did = $_POST['ID'];
		$name = $_POST['user_name'];
		$are = $_POST['address'];
		$tel= $_POST['tel'];

		$data['user_id'] = $user_id;
		$data['user_name'] = $name;
		$data['address'] = $are;
		$data['tel'] = $tel;
		$data['default'] = 0;
		if(empty($did)){
			$result = $address->add($data);
		}else{
			$result = $address->where('id='.$did)->save($data);
		}
		if($result){
			$url = __URL__.'/dizhiAdd';
			$this->_box(0,'添加成功！',$url,1);
			exit;
		}else{
			$this->error('添加失败');
		}
	}
    // 设为默认地址
	public function moren(){
		$address = M('address');
		$id = $_GET['ID'];
		$user_id = $_SESSION['loginUseracc'];
		$rs  = $address->where('id='.$id)->setField('default',1);
		$rs2 = $address->where("id !=".$id." and user_id= '".$user_id."'")->setField('default',0);
		if($rs && $rs2){
			echo $id;
		}else{
			echo '0';
		}
	}
    // 修改地址
	public function addadr(){
		$address = M('address');
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->find();
		$this->assign('rs',$rs);
		$this->assign('did',$id);
		$this -> display('addadr');
	}
    // 删除地址
	public function delAdr(){
		$address = M('address');
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->delete();
		if($rs){
			$url = __URL__.'/dizhiAdd';
			$this->_box(1,'删除地址成功！',$url,1);
			exit;
		}else{
			$this->error('删除失败');
		}
	}
    // 购物结算
	public function  ShopingSave(){
		$Id = (int) $_SESSION[C('USER_AUTH_KEY')];
		$address = M('address');
        // 价格
		$prices = $_POST['prices'];
		// 购物车商品判定
		$arr = $_SESSION["shopping"];
		if(empty($arr)){
			$this->error("您的购物车里面没有商品！");
			exit;
		}
		$pora = M('product');
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$p_rs = $pora->where('id='.$str[0])->find();
			if(!$p_rs){
				$this->error("您所购买的产品暂时没货！");
				exit;
			}
		}
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$path .= $str[0].',';
			$ids[$str[0]] = $str[1];
		}
        // 支付类型选择
		if($_POST['sel'] == null){
			$this->error('请选择支付类型!!');
			exit;
		}
		// 会员表查询，判断二级密码
		$member = D('member');
		$member_rs = $member->where('id='.$Id) ->find();
		$pw = md5(trim($_POST['password2']));
		if($member_rs['password2'] != $pw){
			$this->error('二级密码输入错误!!');
			exit;
		}
		// 地址判定
		$aid = $_POST['adid'];
		$ars = $address->where('id='.$aid)->find();
		if(!$ars){
			$this->error('请选择收货地址!');
			exit;
		}
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$gouwu = M('gouwu');
		// 待存入数据库数据
		$gwd = array();
		// 邮寄地址
		$gwd['address'] = $ars['address'];
		// 用户名
		$gwd['user_id'] = $member_rs['user_id'];
		// 用户姓名
		$gwd['user_name']    = $ars['user_name'];
		// 购物时间
		$gwd['time'] = strtotime(date('c'));
		// 是否支付
		$gwd['ispay'] = 0;
		// 收货人用户名
		$gwd['receive_id'] = $ars['user_id'];
		// 收货人姓名
		$gwd['receive_name'] = $ars['user_name'];
		// 收货人联系电话
		$gwd['tel'] = $ars['tel'];
        if($_POST['sel']==1){
    		if($member_rs['cash'] < $prices){
    			$this->error("您的现金币余额不足！");
    			exit;
    		}
        }
        // 1 :3.8 积分：现金比例
        $cash_tmp = bcdiv($prices*3.8, 4.8,2);
        $point_tmp = bcdiv($prices, 4.8,2);
		if($_POST['sel']==2){
		    if($member_rs['cash'] < $cash_tmp){
		        $this->error("您的现金币余额不足！");
		        exit;
		    }
    		if($member_rs['point'] < $point_tmp){
    			$this->error("您的积分币余额不足！");
    			exit;
    		}
	   }
	   // 查询产品信息
	   $where = array();
	   $where['id'] = array('in','0'. $path .'0');
	   $prs = $pora->where($where)->select();
		foreach ($prs as $vo){
			$w_money = $vo['vip_price'];
			// 产品ID
			$gwd['bk1'] = $vo['id'];
			// 单价
			$gwd['price'] = $w_money;
			// 数量
			$gwd['count'] = $ids[$vo['id']];
			// 总金额
			$gwd['money'] = $ids[$vo['id']]*$w_money;
			
			$gouwu->add($gwd);
		}
		// 1为现金币支付 2为现金币+积分币支付
		if($_POST['sel']==1){
			$rs = $member->query("update __TABLE__ set cash=cash-".$prices." where id=".$id);
			// 添加历史记录
			$bonushistory = M('bonushistory');
			$data = array();
			$data['user_id'] = $member_rs['user_id'];
			$data['user_name'] = $member_rs['user_name'];
			$data['produce_userid'] = $member_rs['user_id'];
			$data['produce_username'] = $member_rs['user_name'];
			$data['action_type'] = 4;
			$data['time'] = mktime();
			$data['money'] = -$prices;
			$data['bz'] = '商城购物';
			$bonushistory->add($data);
		}
		if($_POST['sel']==2){
			$rs = $member->query("update __TABLE__ set cash=cash-".$cash_tmp.",point=point-".$point_tmp." where id=".$id);
			// 添加历史记录
			$bonushistory = M('bonushistory');
			$data = array();
			$data['user_id'] = $member_rs['user_id'];
			$data['user_name'] = $member_rs['user_name'];
			$data['produce_userid'] = $member_rs['user_id'];
			$data['produce_username'] = $member_rs['user_name'];
			$data['action_type'] = 4;
			$data['time'] = mktime();
			$data['money'] = -$cash_tmp;
			$data['in_money'] = -$point_tmp;
			$data['bz'] = '商城购物';
			$bonushistory->add($data);
		}
		if($rs !== false){
			$_SESSION["shopping"]='';
			$_SESSION["shopping_bz"]='';
			$url = __URL__.'/BuycpInfo/';
			$this->_box(1,'购买成功！',$url,1);
			exit;
		}else{
			$this->error("购买失败！");
			exit;
		}
	}

	public function BuycpInfo() {//购买信息
		$cp = M('product');
        $member = M('member');
        $gouwu = M('gouwu');
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $user_id = $_SESSION['loginUseracc'];
        // 根据用户名检索用户地址信息
        $map['user_id'] = $user_id;
        // =====================分页开始==============================================
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $gouwu->where($map)->count(); // 总页数
        $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
//         $page_where = 'UserID=' . $user_id; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $this->assign('page', $show); // 分页变量输出到模板
        $where = "xy_gouwu.id>0 and xy_gouwu.user_id = '" . $user_id . "'";
        $field = 'xy_member.user_id,xy_member.user_name,xy_product.name,xy_gouwu.*';
        $join = 'left join xy_member ON xy_gouwu.user_id=xy_member.user_id'; // 连表查询
        $join1 = 'left join xy_product ON xy_gouwu.bk1=xy_product.id'; // 连表查询
        $list = $gouwu->where($where)
            ->field($field)
            ->join($join)
            ->join($join1)
            ->order('time desc')
            ->page($Page->getPage() . ',' . $listrows)
            ->select();
        $rs1 = $gouwu->where($map)->sum('money');
        $this->assign('count', $rs1);
        $this->assign('list', $list);
        $this->display('BuycpInfo');
	}
	
	//产品表查询
	public function pro_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('product');
			$title = $_REQUEST['stitle'];
			$map = array();
			if(strlen($title)>0){
				$map['name'] = array('like','%'. $title .'%');
			}
			$map['id'] = array('gt',0);
			$orderBy = 'sell_time desc,id desc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $product->where($map)->count();//总页数
	   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
	   		$listrows = 10;//每页显示的记录数
	        $page_where = 'stitle=' . $title ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $product->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================
	        $this->display();
		}else{
    $this->error('错误!');
        }
	}
	//产品表显示修改
	public function pro_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('product');
		$where = array();
		$where['id'] = $EDid;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
			$this->us_fckeditor('content',$rs['content'],400,"96%");

			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);

			$this->display();
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	//产品表修改保存
	public function pro_edit_save(){
		$this->_Admin_checkUser();
		$product = M ('product');
		$data = array();
		// 产品名称
		$name = trim($_POST['name']);
		//联盟商家用户名
		$user_id = trim($_POST['user_id']);
		// 联盟商家店名
		$shopName = trim($_POST['shopName']);
		// 库存
		$stock_count = trim($_POST['stock_count']);
		// 产品分类
		$cptype = trim($_POST['cptype']);
		$cptype = (int)$cptype;
		// 成本价
		$price = $_POST['price'];
		// 零售价
		$sale_price = $_POST['sale_price'];
		// 会员价
		$vip_price = $_POST['vip_price'];
		// 批发价
		$whole_sale_price = $_POST['whole_sale_price'];
		// 商品详情描述
		$content = stripslashes($_POST['content']);
		// 商品图片
		$img1 = $_POST['img1'];
		// 上架时间
		$ctime = trim($_POST['sell_time']);
		$ctime = strtotime($ctime);
		if (empty($name)){
			$this->error('产品名称不能为空!');
			exit;
		}
		if (empty($user_id)){
		    $this->error('联盟商家用户名不能为空!');
		    exit;
		}
		if (empty($shopName)){
		    $this->error('联盟商家店名不能为空!');
		    exit;
		}
		if (empty($stock_count)){
			$this->error('库存不能为空!');
			exit;
		}
		if (empty($sale_price)||!is_numeric($sale_price)
		    ||empty($vip_price)||!is_numeric($vip_price) ||empty($whole_sale_price)||!is_numeric($whole_sale_price)){
			$this->error('价格不能为空!');
			exit;
		}
		$member = M ('member');
		$where = array();
		$where['user_id'] = $user_id;
		$member_rs = $member->where($where)->field('user_name')->find();
		if (!$member_rs) {
		    $this->error('该联盟商家不存在!');
		    exit;
		}
		if(!empty($ctime)){
			$data['sell_time'] = $ctime;
		}
		$data['id'] = $_POST['ID'];
		$data['name'] = $name;
		$data['user_id'] = $user_id;
		$data['user_name'] = $member_rs['user_name'];
		$data['shopName'] = $shopName;
		$data['stock_count'] = $stock_count;
		$data['cptype'] = $cptype;
		$data['price'] = $price;
		$data['sale_price'] = $sale_price;
		$data['vip_price'] = $vip_price;
		$data['whole_sale_price'] = $whole_sale_price;
		$data['content'] = $content;
		$data['cptype'] = $cptype;
		$data['img1'] = $img1;
		$data['sell_time'] = $ctime;
		
		$rs = $product->save($data);
		if (!$rs){
			$this->error('编辑失败！');
			exit;
		}
		$bUrl = __URL__.'/pro_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	//产品表操作（启用禁用删除）
	public function pro_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){
			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);

			$this->us_fckeditor('content',"",400,"96%");
			$this->display('pro_add');
			exit;
		}
		$product = M ('product');
		switch ($action){
			case '删除';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'操作成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'操作失败',$bUrl,1);
				}
				break;
			case '屏蔽产品';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',1);
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'屏蔽产品成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'屏蔽产品失败',$bUrl,1);
				}
				break;
			case '解除屏蔽';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',0);
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'解除屏蔽成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'解除屏蔽失败',$bUrl,1);
				}
				break;
			default;
				$bUrl = __URL__.'/pro_index';
				$this->_box(0,'操作失败',$bUrl,1);
				break;
		}
	}

	//产品表添加保存
	public function pro_inserts(){
		$this->_Admin_checkUser();
		$product = M('product');
		$data = array();
		// 产品名称
		$name = trim($_POST['name']);
		//联盟商家用户名
		$user_id = trim($_POST['user_id']);
		// 联盟商家店名
		$shopName = trim($_POST['shopName']);
		// 库存
		$stock_count = trim($_POST['stock_count']);
		// 产品分类
		$cptype = trim($_POST['cptype']);
		$cptype = (int)$cptype;
		// 成本价
		$price = $_POST['price'];
		// 零售价
		$sale_price = $_POST['sale_price'];
		// 会员价
		$vip_price = $_POST['vip_price'];
		// 批发价
		$whole_sale_price = $_POST['whole_sale_price'];
		// 商品详情描述
		$content = stripslashes($_POST['content']);
		// 商品图片
		$img1 = $_POST['img1'];
		$ctime = strtotime($ctime);
		if (empty($name)){
			$this->error('产品名称不能为空!');
			exit;
		}
		if (empty($user_id)){
		    $this->error('联盟商家用户名不能为空!');
		    exit;
		}
		if (empty($shopName)){
		    $this->error('联盟商家店名不能为空!');
		    exit;
		}
		if (empty($stock_count)){
			$this->error('库存不能为空!');
			exit;
		}
		if (empty($sale_price)||!is_numeric($sale_price)
		    ||empty($vip_price)||!is_numeric($vip_price) ||empty($whole_sale_price)||!is_numeric($whole_sale_price)){
			$this->error('价格不能为空!');
			exit;
		}
		$member = M ('member');
		$where = array();
		$where['user_id'] = $user_id;
		$member_rs = $member->where($where)->field('user_name')->find();
		if (!$member_rs) {
		    $this->error('该联盟商家不存在!');
		    exit;
		}
		$data['name'] = $name;
		$data['user_id'] = $user_id;
		$data['user_name'] = $member_rs['user_name'];
		$data['shopName'] = $shopName;
		$data['stock_count'] = $stock_count;
		$data['cptype'] = $cptype;
		$data['price'] = $price;
		$data['sale_price'] = $sale_price;
		$data['vip_price'] = $vip_price;
		$data['whole_sale_price'] = $whole_sale_price;
		$data['content'] = $content;
		$data['cptype'] = $cptype;
		$data['img1'] = $img1;
		$data['sell_time'] = mktime();
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/pro_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	public function cptype_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('cptype');
			$map = array();
			$map['id'] = array('gt',0);
			$orderBy = 'id asc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $product->where($map)->count();//总页数
	   		$listrows = 20;//每页显示的记录数
	        $page_where = "" ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $product->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================

	        $this->display();
		}else{
    $this->error('错误!');
        }
	}

	public function cptype_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('cptype');
		$where = array();
		$where['id'] = $EDid;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
			$this->display();
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	public function cptype_edit_save(){
		$this->_Admin_checkUser();
		$cptype = M ('cptype');
		$title = trim($_POST['title']);
		if (empty($title)){
			$this->error('分类名不能为空!');
			exit;
		}
		$data = array();
		$data['tpname'] = $title;
		$data['id'] = $_POST['id'];
		$rs = $cptype->save($data);
		if (!$rs){
			$this->error('编辑失败！');
			exit;
		}
		$bUrl = __URL__.'/cptype_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	//处理
	public function cptype_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){
			$this->display('cptype_add');
			exit;
		}
		$product = M ('cptype');
		switch ($action){
			case '删除';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/cptype_index';
					$this->_box(1,'操作成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/cptype_index';
					$this->_box(0,'操作失败',$bUrl,1);
				}
				break;
			default;
			$bUrl = __URL__.'/cptype_index';
			$this->_box(0,'操作失败',$bUrl,1);
			break;
		}
	}
	
	//产品表添加保存
	public function cptype_inserts(){
		$this->_Admin_checkUser();
		$product = M('cptype');
		$title = trim($_POST['title']);
		if (empty($title)){
			$this->error('分类名不能为空!');
			exit;
		}
		$data = array();
		$data['tpname'] = $title;
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/cptype_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	public function adminLogistics(){
		$this->_checkUser();//检测用户是否登录
		//物流管理
		if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
			$shopping = M ('gouwu');
			$product = M('product');
			$member = M('member');
			$sessionID = $_SESSION[C('USER_AUTH_KEY')];
            $ss_type = (int) $_REQUEST['type'];
            $map = array();
		  if($ss_type==0){
		  		// TODO 暂时注掉bk3条件，后续再改
				//$map['bk3'] = array('egt',0);
			}elseif($ss_type==1){
				$map['bk3'] = array('eq',0);
			}elseif($ss_type==2){
				$map['bk3'] = array('eq',1);
			}elseif($ss_type==3){
				$map['bk3'] = array('eq',2);
			}
			// 根据p_path 查询下面会员ID
			$where = array();
			$where['p_path'] = array('like',"%,".$sessionID.",%");
			$member_rs = $member->where($where)->field('user_id')->select();
			$idArray = array();
			foreach ($member_rs as $value){
			    array_push($idArray,$value['user_id']);
			}
			// 物流管理员和后台可以查看所有物流信息
			$member_rs2 = $member->where('id ='.$sessionID)->find();
			if ($member_rs2['id'] != '1' && $member_rs2['user_id'] != 'cc') {
			    $map['user_id'] = array('in',$idArray);
			}
		    //查询字段
		    $field   = '*';
		    //=====================分页开始==============================================
		    import ( "@.ORG.ZQPage" );  //导入分页类
		    $count = $shopping->where($map)->count();//总页数
		    $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
				    $page_where = '&type='.$ss_type;//分页条件
		    $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
		    //===============(总页数,每页显示记录数,css样式 0-9)
		    $show = $Page->show();//分页变量
		    $this->assign('page',$show);//分页变量输出到模板
		    $list = $shopping ->where($map)->field($field)->page($Page->getPage().','.$listrows)->select();
		    $this->assign('list',$list);//数据输出到模板
		    //=================================================
		    foreach($list as $vv){
		    	$ttid = $vv['bk1'];
		    	$trs = $product->where('id='.$ttid)->find();
		    	$voo[$ttid] = $trs['name'];
		    }
		    $this->assign('voo',$voo);
		    $title = '物流管理';
		    $this->assign('title',$title);
		    $this->display('adminLogistics');
		}else{
			$this->error('错误!');
			exit;
		}
	}

    public function adminLogisticsAC(){
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $XGid = $_POST['tabledb'];
        if (!isset($XGid) || empty($XGid)){
    $bUrl = __URL__.'/adminLogistics';
    $this->_box(0,'请选择货物！',$bUrl,1);
    exit;
        }
        switch ($action){
    case '确认发货';
        $this->_adminLogisticsOK($XGid);
        break;
    case '确定收货';
        $this->_adminLogisticsDone($XGid);
        break;
    case '删除';
        $this->_adminLogisticsDel($XGid);
        break;
	        default;
	    $bUrl = __URL__.'/adminLogistics';
	    $this->_box(0,'没有该货物！',$bUrl,1);
	    break;
        }
    }

    private function _adminLogisticsOK($XGid)
    {
        // 确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList') {
            
            $sessionID = $_SESSION[C('USER_AUTH_KEY')];
            // 查询会员表
            $member = M('member');
            $member_rs2 = $member->where('id =' . $sessionID)->find();
            $shopping = M('gouwu');
            $where = array();
            $where['id'] = array(
                'in',
                $XGid
            );
            $where['bk3'] = array(
                'eq',
                0
            );
            $valuearray = array(
                'bk3' => '1',
                'confirm_send_time' => mktime(),
                'confirm_send_id' => $member_rs2['user_id'],
                'confirm_send_name' => $member_rs2['user_name']
            );
            $stock_rs = $shopping->where($where)->field("count")->select();
            $count = 0;
            foreach ($stock_rs as $value){
                $count += $value['count'];
            }
            $result = $shopping->where($where)->setField($valuearray);
            if ($result) {
                $member_rs2 = $member->where('id =' . $sessionID)->find();
                $rs = $member->query("UPDATE `xy_member` SET agency_count=agency_count - ".$count." where id=" . $sessionID);
            }
            unset($shopping, $where);
            
            $bUrl = __URL__ . '/adminLogistics';
            $this->_box(1, '发货成功！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误!');
        }
    }

    private function _adminLogisticsDone($XGid){
    	//确认收货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
    $shopping = M ('gouwu');
    $where = array();
    $where['id'] = array ('in',$XGid);
    $where['bk3'] = array ('egt',0);
    $sessionID = $_SESSION[C('USER_AUTH_KEY')];
    $member = M ('member');
    $member_rs2 = $member->where('id ='.$sessionID)->find();

    $valuearray = array(
    	'bk3' => '2',
    	'confirm_receive_time' => mktime(),
        'confirm_receive_id'=> $member_rs2['user_id'],
        'confirm_receive_name'=> $member_rs2['user_name']
    );

    $shopping->where($where)->setField($valuearray);
    unset($shopping,$where);

    $bUrl = __URL__.'/adminLogistics';
    $this->_box(1,'确认收货成功！',$bUrl,1);
    exit;
        }else{
    $this->error('错误!');
    exit;
        }
    }

    private function _adminLogisticsDel($XGid){
    	//删除物流
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
    $shopping = M ('gouwu');
    $where = array();
    $where['id'] = array ('in',$XGid);
    $shopping->where($where)->delete();
    unset($shopping,$where);

    $bUrl = __URL__.'/adminLogistics';
    $this->_box(1,'删除成功！',$bUrl,1);
    exit;
        }else{
    $this->error('错误!');
        }
    }

    
    /**
     * 上传图片
     * **/
	public function upload_fengcai_pp() {
		$this->_Admin_checkUser();//后台权限检测
        if(!empty($_FILES)) {
    //如果有文件上传 上传附件
    $this->_upload_fengcai_pp();
        }
    }

    protected function _upload_fengcai_pp()
    {
        header("content-type:text/html;charset=utf-8");
        $this->_Admin_checkUser();//后台权限检测
        // 文件上传处理函数
        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize  = 1048576 * 2 ;// TODO 50M   3M 3292200 1M 1048576
        //设置上传文件类型
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');
        //设置附件上传目录
        $upload->savePath =  './Public/Uploads/image/';
        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;
       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图
       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';
       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';
       //设置上传文件规则
		$upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);
       //删除原图
       $upload->thumbRemoveOrigin = true;
        if(!$upload->upload()) {
        //捕获上传异常
        $error_p=$upload->getErrorMsg();
        echo "<script>alert('".$error_p."');history.back();</script>";
            }else {
        //取得成功上传的文件信息
        $uploadList = $upload->getUploadFileInfo();
        $U_path=$uploadList[0]['savepath'];
        $U_nname=$uploadList[0]['savename'];
        $U_inpath=(str_replace('./Public/','__PUBLIC__/',$U_path)).$U_nname;
    
        echo "<script>window.parent.form1.img1.value='".$U_inpath."';</script>";
        echo "<span style='font-size:12px;'>上传完成！</span>";
        exit;

        }
    }

}
?>