<?php
// 注册模块
class AgentAction extends CommonAction
{

    public function _initialize()
    {
        header("Content-Type:text/html; charset=utf-8");
        $this->_inject_check(0); // 调用过滤函数
        $this->_Config_name(); // 调用参数
        $this->_checkUser();
    }

    public function cody()
    {
        // ===================================二级验证
        $UrlID = (int) $_GET['c_id'];
        if (empty($UrlID)) {
            $this->error('二级密码错误!');
            exit();
        }
        if (! empty($_SESSION['user_pwd2'])) {
            $url = __URL__ . "/codys/Urlsz/$UrlID";
            $this->_boxx($url);
            exit();
        }
        $cody = M('cody');
        $list = $cody->where("c_id=$UrlID")
            ->field('c_id')
            ->find();
        if ($list) {
            $this->assign('vo', $list);
            $this->display('Public:cody');
            exit();
        } else {
            $this->error('二级密码错误!');
            exit();
        }
    }

    public function codys()
    {
        // =============================二级验证后调转页面
        $Urlsz = (int) $_POST['Urlsz'];
        if (empty($_SESSION['user_pwd2'])) {
            $pass = $_POST['oldpassword'];
            $member = M('member');
            if (! $member->autoCheckToken($_POST)) {
                $this->error('页面过期请刷新页面!');
                exit();
            }
            if (empty($pass)) {
                $this->error('二级密码错误!');
                exit();
            }
            $where = array();
            $where['id'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['password2'] = md5($pass);
            $list = $member->where($where)->field('id,is_agent')->find();
            if ($list == false) {
                $this->error('二级密码错误!');
                exit();
            }
            $_SESSION['user_pwd2'] = 1;
        } else {
            $Urlsz = $_GET['Urlsz'];
        }
        switch ($Urlsz) {
            case 1:
                
                $_SESSION['Urlszpass'] = 'MyssXiGua';
                $bUrl = __URL__ . '/agents'; // 申请代理
                $this->_boxx($bUrl);
                break;
            case 9:
                if ($list['is_agent'] >= 2) {
                    $this->error('您已经是服务中心!');
                    exit();
                }
                $_SESSION['Urlszpass'] = 'MyssX';
                $bUrl = __URL__ . '/agents3'; // 申请代理
                $this->_boxx($bUrl);
                break;
            case 2:
                $_SESSION['Urlszpass'] = 'MyssShuiPuTao';
                $bUrl = __URL__ . '/menber'; // 未开通会员
                $this->_boxx($bUrl);
                break;
            
            case 3:
                $_SESSION['Urlszpass'] = 'Myssmenberok';
                $bUrl = __URL__ . '/menberok'; // 已开通会员
                $this->_boxx($bUrl);
                break;
                
            case 11:
                $_SESSION['Urlszpass'] = 'MyssmenberUpLevel';
                $bUrl = __URL__ . '/memberuplevel'; // 原点升级晋级审核
                $this->_boxx($bUrl);
                break;
            case 12:
                $_SESSION['Urlszpass'] = 'agentIndex';
                $bUrl = __URL__ . '/agentIndex'; // 服务中心主页
                $this->_boxx($bUrl);
                break;
            
            case 4:
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
                $bUrl = __URL__ . '/adminAgents'; // 后台确认服务中心
                $this->_boxx($bUrl);
                break;
            
            case 5:
                
                $_SESSION['Urlszpass'] = 'MyssXiGu';
                $bUrl = __URL__ . '/agents1'; // 申请代理
                $this->_boxx($bUrl);
                break;
            
            case 6:
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGu';
                $bUrl = __URL__ . '/adminAgents1'; // 后台确认
                $this->_boxx($bUrl);
                break;
            
            case 10:
                $_SESSION['UrlPTPass'] = 'MyssGuanX';
                $bUrl = __URL__ . '/adminAgents3'; // 后台确认
                $this->_boxx($bUrl);
                break;
            
            case 7:
                
                $_SESSION['Urlszpass'] = 'MyssXiG';
                $bUrl = __URL__ . '/agents2'; // 申请代理
                $this->_boxx($bUrl);
                break;
            
            case 8:
                $_SESSION['UrlPTPass'] = 'MyssGuanXiG';
                $bUrl = __URL__ . '/adminAgents2'; // 后台确认
                $this->_boxx($bUrl);
                break;
            
            default:
                $this->error('二级密码错误!');
                exit();
        }
    }

    public function agents($Urlsz = 0)
    {
        // ======================================申请会员中心/服务中心/服务中心
        if ($_SESSION['Urlszpass'] == 'MyssXiGua') {
            $fee_rs = M('fee')->find();
            
            $member = M('member');
            $where = array();
            // 查询条件
            $where['id'] = $_SESSION[C('USER_AUTH_KEY')];
            $field = '*';
            $member_rs = $member->where($where)
                ->field($field)
                ->find();
            
            if ($member_rs) {
                // 会员级别
                switch ($member_rs['l_nums']) {
                    case 0:
                        $agent_status = '未申请商家!';
                        break;
                    case 1:
                        $agent_status = '申请正在审核中!';
                        break;
                    case 2:
                        $agent_status = '商家已开通!';
                        break;
                }
                
                $this->assign('fee_s6', $fee_rs['i1']);
                $this->assign('agent_level', 0);
                $this->assign('agent_status', $agent_status);
                $this->assign('member_rs', $member_rs);
                
                $Agent_Us_Name = C('Agent_Us_Name');
                $Aname = explode("|", $Agent_Us_Name);
                $this->assign('Aname', $Aname);
                
                $this->display('agents');
            } else {
                $this->error('操作失败!');
                exit();
            }
        } else {
            $this->error('错误!');
            exit();
        }
    }

    public function agents3($Urlsz = 0)
    {
        // ======================================申请会员中心/服务中心/服务中心
        if ($_SESSION['Urlszpass'] == 'MyssX') {
            $fee_rs = M('fee')->find();
            
            $member = M('member');
            $where = array();
            // 查询条件
            $where['id'] = $_SESSION[C('USER_AUTH_KEY')];
            $field = '*';
            $member_rs = $member->where($where)
                ->field($field)
                ->find();
            
            if ($member_rs) {
                // 会员级别
                switch ($member_rs['is_agent']) {
                    case 0:
                        $agent_status = '未申请服务中心!';
                        break;
                    case 1:
                        $agent_status = '申请正在审核中!';
                        break;
                    case 2:
                        $agent_status = '服务中心已开通!';
                        break;
                }
                
                $this->assign('fee_s6', $fee_rs['i1']);
                $this->assign('agent_level', 0);
                $this->assign('agent_status', $agent_status);
                $this->assign('member_rs', $member_rs);
                
                $Agent_Us_Name = C('Agent_Us_Name');
                $Aname = explode("|", $Agent_Us_Name);
                $this->assign('Aname', $Aname);
                
                $this->display('agents3');
            } else {
                $this->error('操作失败!');
                exit();
            }
        } else {
            $this->error('错误!');
            exit();
        }
    }

    public function agents1($Urlsz = 0)
    {
        // ======================================申请会员中心/服务中心/服务中心
        if ($_SESSION['Urlszpass'] == 'MyssXiGu') {
            $fee_rs = M('fee')->find();
            
            $member = M('member');
            $where = array();
            // 查询条件
            $where['id'] = $_SESSION[C('USER_AUTH_KEY')];
            $field = '*';
            $member_rs = $member->where($where)
                ->field($field)
                ->find();
            
            if ($member_rs) {
                // 会员级别
                switch ($member_rs['is_cc']) {
                    case 0:
                        $agent_status = '未申请现金卡!';
                        break;
                    case 1:
                        $agent_status = '申请正在审核中!';
                        break;
                    case 2:
                        $agent_status = '油卡已申请成功!';
                        break;
                }
                
                $this->assign('fee_s6', $fee_rs['i1']);
                $this->assign('str9', $fee_rs['str9']);
                $this->assign('agent_level', 0);
                $this->assign('agent_status', $agent_status);
                $this->assign('member_rs', $member_rs);
                
                $Agent_Us_Name = C('Agent_Us_Name');
                $Aname = explode("|", $Agent_Us_Name);
                $this->assign('Aname', $Aname);
                
                $this->display('agents1');
            } else {
                $this->error('操作失败!');
                exit();
            }
        } else {
            $this->error('错误!');
            exit();
        }
    }

    public function agents2($Urlsz = 0)
    {
        // ======================================申请会员中心/服务中心/服务中心
        if ($_SESSION['Urlszpass'] == 'MyssXiG') {
            $fee_rs = M('fee')->find();
            
            $member = M('member');
            $where = array();
            // 查询条件
            $where['id'] = $_SESSION[C('USER_AUTH_KEY')];
            $field = '*';
            $member_rs = $member->where($where)
                ->field($field)
                ->find();
            
            if ($member_rs) {
                // 会员级别
                switch ($member_rs['is_p']) {
                    case 0:
                        $agent_status = '未申请省代理!';
                        break;
                    case 1:
                        $agent_status = '申请正在审核中!';
                        break;
                    case 2:
                        $agent_status = '省代理已申请成功!';
                        break;
                }
                
                switch ($member_rs['is_c']) {
                    case 0:
                        $agent_status1 = '未申请市代理!';
                        break;
                    case 1:
                        $agent_status1 = '申请正在审核中!';
                        break;
                    case 2:
                        $agent_status1 = '市代理已申请成功!';
                        break;
                }
                switch ($member_rs['is_cty']) {
                    case 0:
                        $agent_status2 = '未申请县!';
                        break;
                    case 1:
                        $agent_status2 = '申请正在审核中!';
                        break;
                    case 2:
                        $agent_status2 = '县代理已申请成功!';
                        break;
                }
                
                $this->assign('fee_s6', $fee_rs['i1']);
                $this->assign('str9', $fee_rs['str9']);
                $this->assign('agent_level', 0);
                $this->assign('agent_status', $agent_status);
                $this->assign('agent_status1', $agent_status1);
                $this->assign('agent_status2', $agent_status2);
                $this->assign('member_rs', $member_rs);
                
                $Agent_Us_Name = C('Agent_Us_Name');
                $Aname = explode("|", $Agent_Us_Name);
                $this->assign('Aname', $Aname);
                
                $this->display('agents2');
            } else {
                $this->error('操作失败!');
                exit();
            }
        } else {
            $this->error('错误!');
            exit();
        }
    }

    public function agentsAC2()
    {
        // ================================申请会员中心中转函数
        $content = $_POST['content'];
        $agentMax = $_POST['agentMax'];
        $shoplx = (int) $_POST['shoplx'];
        $shop_a = $_POST['shop_a'];
        $shop_b = $_POST['shop_b'];
        $fee = M('fee');
        $fee_rs = $fee->where('s9,s14,s11,str9')->find(1);
        $s11 = $fee_rs['s11'];
        
        $str9 = $fee_rs['str9'];
        $one_mm = 1;
        $where = array();
        if ($shoplx == 1) {
            $where['is_p'] = 0;
        }
        if ($shoplx == 2) {
            $where['is_c'] = 0;
        }
        if ($shoplx == 3) {
            $where['is_cty'] = 0;
        }
        $member = M('member');
        $id = $_SESSION[C('USER_AUTH_KEY')];
        
        $where['id'] = $id;
        
        $member_rs = $member->where($where)
            ->field('*')
            ->find();
        
        if ($member_rs) {
            
            $agent_use = $member_rs['agent_use'];
            
            if ($member_rs['is_pay'] == 0) {
                $this->error('临时会员不能申请!');
                exit();
            }
            
            // if($agent_use < $str9){
            // $this->error ('奖金余额不足!');
            // exit;
            // }
            
            if ($member_rs['is_p'] == 1) {
                $this->error('有申请还没通过审核!');
                exit();
            }
            if ($member_rs['is_c'] == 1) {
                $this->error('有申请还没通过审核!');
                exit();
            }
            if ($member_rs['is_cty'] == 1) {
                $this->error('有申请还没通过审核!');
                exit();
            }
            
            if (empty($content)) {
                $this->error('请输入备注!');
                exit();
            }
            
            if ($member_rs['is_p'] == 0 && $shoplx == 1) {
                $nowdate = time();
                $result = $member->query("update __TABLE__ set verify='" . $content . "',is_p=1,is_cha=1,jia_nums=1,idt=$nowdate where id=" . $id);
            }
            if ($member_rs['is_c'] == 0 && $shoplx == 2) {
                $nowdate = time();
                $result = $member->query("update __TABLE__ set verify='" . $content . "',is_c=1,is_cha=1,jia_nums=2,idt=$nowdate where id=" . $id);
            }
            if ($member_rs['is_cty'] == 0 && $shoplx == 3) {
                $nowdate = time();
                $result = $member->query("update __TABLE__ set verify='" . $content . "',is_cty=1,is_cha=1,jia_nums=3,idt=$nowdate where id=" . $id);
            }
            
            $bUrl = __URL__ . '/agents2';
            $this->_box(1, '申请成功！', $bUrl, 2);
        } else {
            $this->error('非法操作');
            exit();
        }
    }

    public function agentsAC1()
    {
        // ================================申请会员中心中转函数
        $content = $_POST['content'];
        $agentMax = $_POST['agentMax'];
        $shoplx = (int) $_POST['shoplx'];
        // 复投类型
        $futou = $_POST['futou'];
        $shop_b = $_POST['shop_b'];
        // 填写的单数
        $nums = $_POST['nums'];
        if ($nums == 0) {
            $this->error('请填写单数！');
            exit();
        }
        if ($futou == 1) {
            $this->error('请选择复投类型！');
            exit();
        }
        $fee = M('fee');
        $fee_rs = $fee->where('s9,s14,s11,str9')->find(1);
        // 注册金额
        $s9 = $fee_rs['s9'];
        // 报单中心奖励比例
        $str9 = $fee_rs['str9'];
        $one_mm = 1;
        
        $member = D('member');
        // 登录会员ID
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $where = array();
        $where['id'] = $id;
        // 查询会员表数据
        $member_rs = $member->where($where)->field('*')->find();
        // 若存在会员表数据
        if ($member_rs) {
            // 已经复投单数+现在提交的复投单数
            $f4 = $member_rs['is_cc'] + $nums;
            // 剩余可以复投单数
            $sum = 50 - $member_rs['is_cc'];
            // 总单数不能大于50
            if ($nums > 50) {
                $this->error('一次最多只能复投50单！');
                exit();
            } else {
                // 前台输入单数总金额：单数*每单注册金额
                $picmoney = $nums * $s9;
                // 投资额*10%
                $summoney = $member_rs['cpzj'] * 0.1;
                // 注册单数大于等于25之后，前10次任意复投，10次之后满投资额的10%才可以复投。
                if ($member_rs['f4'] >= 25) {
                    // 复投次数 > 10次
                    if ($member_rs['jia_nums'] > 10) {
                
                        // 复投金额小于投资额的10%，不允许复投
                        if ($picmoney < $summoney) {
                            $this->error('您已经复投超过10次，必须满'.$summoney.'才可复投！');
                            exit();
                        }
                    }
                }
                // 单数
                $sum = $nums;
            }
            // 复投金额：单数*每单金额
            $money = $sum * $s9;
            if ($member_rs['agent_xf'] < $money && $futou == 3) {
                $this->error('复投币不足！');
                exit();
            }
            if ($member_rs['agent_use'] < $money && $futou == 2) {
                $this->error('现金币不足！');
                exit();
            }
            // 注册时投资金额
            $agent_xf = $member_rs['cpzj'];
            $data = array();
            // 现在时间
            $nowdate = strtotime(date('c'));
            // 历史记录表
            $history = M('history');
            // 复投币复投
            if ($futou == 3) {
                // ID
                $data['uid'] = $member_rs['id'];
                // 会员编号
                $data['user_id'] = $member_rs['user_id'];
                // 复投币复投
                $data['action_type'] = 24;
                // 时间
                $data['pdt'] = $nowdate;
                // 复投金额
                $data['epoints'] = $money;
                $data['did'] = 0;
                $data['allp'] = 0;
                $data['bz'] = '24';
                // 添加历史记录表数据
                $history->create();
                $history->add($data);
                // 更新会员表数据
                $result = $member->query("update __TABLE__ set is_cc=is_cc+" . $sum .",jia_nums=jia_nums+1". ",agent_xf=agent_xf-$money where id=" . $id);
            } else {
                // ID
                $data['uid'] = $member_rs['id'];
                // 会员编号
                $data['user_id'] = $member_rs['user_id'];
                // 现金币复投
                $data['action_type'] = 25;
                // 时间
                $data['pdt'] = $nowdate;
                // 复投金额
                $data['epoints'] = $money;
                $data['did'] = 0;
                $data['allp'] = 0;
                $data['bz'] = '25';
                // 添加历史记录表数据
                $history->create();
                $history->add($data);
                // 更新会员表数据
                $result = $member->query("update __TABLE__ set is_cc=is_cc+" . $sum .",jia_nums=jia_nums+1". ",agent_use=agent_use-$money where id=" . $id);
            }
            
            // 分红包记录表
            $member->jiaDan($member_rs['id'], $member_rs['user_id'], $nowdate, 0, 0, $sum, 0, 2);
            $member->tz($member_rs['p_path'], $money);
            // 推荐奖
            $member->tuijj($member_rs['re_path'], $member_rs['user_id'], $money);
            // 见点奖
            $member->jiandianjiang($member_rs['p_path'], $member_rs['user_id']);
            // 领导奖
            $member->lingdao22($member_rs['p_path'], $member_rs['user_id'], $money);
            // 合伙人级别
            $member->sh_level();
            
            $bUrl = __URL__ . '/agents1';
            $this->_box(1, '复投成功！', $bUrl, 2);
        } else {
            $this->error('非法操作');
            exit();
        }
    }

    public function agentsAC3()
    {
        // ================================申请会员中心中转函数
        $content = $_POST['content'];
        $agentMax = $_POST['agentMax'];
        $shoplx = (int) $_POST['shoplx'];
        $shop_a = $_POST['shop_a'];
        $shop_b = $_POST['shop_b'];
        $fee = M('fee');
        $fee_rs = $fee->where('s9,s14,s11')->find(1);
        $s11 = $fee_rs['s11'];
        // $one_mm = $s9[0];
        $one_mm = 1;
        
        /*
         * if($shoplx==1){
         * if($shop_a == "请选择"){
         * $this->error('请输入服务中心区域!');
         * }
         * }else{
         * if($shop_a == "请选择" || $shop_b == "请选择"){
         * $this->error('请输入服务中心区域!');
         * }
         * }
         */
        
        $member = M('member');
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $where = array();
        $where['id'] = $id;
        
        $member_rs = $member->where($where)
            ->field('*')
            ->find();
        if ($member_rs) {
            
            if ($member_rs['is_pay'] == 0) {
                $this->error('临时会员不能申请!');
                exit();
            }
            if ($member_rs['is_agent'] == 1) {
                $this->error('上次申请还没通过审核!');
                exit();
            }
            
            // $bqycount=0;
            // if($shoplx==1){
            // $bqycount = $member->where("is_agent>0 and shop_a=".$shop_a)->count;
            // }elseif($shoplx==2){
            // $bqycount = $member->where("is_agent>0 and shop_b=".$shop_b)->count;
            // }
            // if($bqycount>0){
            // $this->error('本区域的服务中心已经存在!');
            // exit;
            // }
            
            if (empty($content)) {
                $this->error('请输入备注!');
                exit();
            }
            
            if ($member_rs['l_nums'] == 0) {
                $nowdate = time();
                $result = $member->query("update __TABLE__ set verify='" . $content . "',is_agent=1,shoplx=" . $shoplx . ",shop_a='" . $shop_a . "',shop_b='" . $shop_b . "',idt=$nowdate where id=" . $id);
            }
            
            $bUrl = __URL__ . '/agents3';
            $this->_box(1, '申请成功！', $bUrl, 2);
        } else {
            $this->error('非法操作');
            exit();
        }
    }

    public function agentsAC()
    {
        // ================================申请会员中心中转函数
        $content = $_POST['content'];
        $agentMax = $_POST['agentMax'];
        $shoplx = (int) $_POST['shoplx'];
        $shop_a = $_POST['shop_a'];
        $shop_b = $_POST['shop_b'];
        $fee = M('fee');
        $fee_rs = $fee->where('s9,s14,s11')->find(1);
        $s11 = $fee_rs['s11'];
        // $one_mm = $s9[0];
        $one_mm = 1;
        
        /*
         * if($shoplx==1){
         * if($shop_a == "请选择"){
         * $this->error('请输入服务中心区域!');
         * }
         * }else{
         * if($shop_a == "请选择" || $shop_b == "请选择"){
         * $this->error('请输入服务中心区域!');
         * }
         * }
         */
        
        $member = M('member');
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $where = array();
        $where['id'] = $id;
        
        $member_rs = $member->where($where)
            ->field('*')
            ->find();
        if ($member_rs) {
            
            if ($member_rs['is_pay'] == 0) {
                $this->error('临时会员不能申请!');
                exit();
            }
            if ($member_rs['l_nums'] == 1) {
                $this->error('上次申请还没通过审核!');
                exit();
            }
            
            if (empty($content)) {
                $this->error('请输入备注!');
                exit();
            }
            
            if ($member_rs['l_nums'] == 0) {
                $nowdate = time();
                $result = $member->query("update __TABLE__ set verify='" . $content . "',l_nums=1,shoplx=" . $shoplx . ",shop_a='" . $shop_a . "',shop_b='" . $shop_b . "',idt=$nowdate where id=" . $id);
            }
            
            $bUrl = __URL__ . '/agents';
            $this->_box(1, '申请成功！', $bUrl, 2);
        } else {
            $this->error('非法操作');
            exit();
        }
    }
    
    // 未开通会员
    public function menber($Urlsz = 0)
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao') {
            $member = M('member');
            $map = array();
            $id = $_SESSION[C('USER_AUTH_KEY')];
            $user_id = $_SESSION['loginUseracc'];
            $gid = (int) $_GET['bj_id'];
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['user_name'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            // 是否支付
            $map['bk4'] = array('eq',0);
            // 报单中心以下会员都可以查看
            $map['p_path'] = array( 'like',','.$id.',');
            // 查询字段
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)->field($field)->order('bk4 asc,register_time desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('list', $list); // 数据输出到模板
            $where = array();
            $where['user_id'] = $user_id;
            $member_rs = $member->where($where)->field('*')->find();
            $this->assign('frs', $member_rs);
            $this->display('menber');
            exit();
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    
    // 原点升级审核列表
    public function memberuplevel($Urlsz = 0)
    {
        // 列表过滤器，生成查询Map对象
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $member = M('member');
        $where = array();
        $where['p_path'] = array('like',"%" . $id . "%");
        $member_rs = $member->where($where)->field('*')->find();
        $promo = M('promo');
        $map = array();
        // 查询字段
        $field = '*';
        // =====================分页开始==============================================
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $promo->where($map)->count(); // 总页数
        $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
        $page_where = 'user_id=' . $member_rs['user_id']; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $this->assign('page', $show); // 分页变量输出到模板
        $list = $promo->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage() . ',' . $listrows)->select();
        $this->assign('list', $list); // 数据输出到模板
        // =================================================
        $this->assign('frs', $member_rs); // 注册币
        $this->display('memberuplevel');
        exit();
    }
    
    // 已开通会员
    public function menberok($Urlsz = 0)
    {
        // 列表过滤器，生成查询Map对象
        $member = M('member');
        $map = array();
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $user_id = $_SESSION['loginUseracc'];
        $gid = (int) $_GET['bj_id'];
        // 报单中心以下会员都可以查看
        $map['p_path'] = array( 'like',','.$id.',');
        // 是否支付
        $map['bk4'] = array( 'gt',0);
        $UserID = $_POST['UserID'];
        if (! empty($UserID)) {
            import("@.ORG.KuoZhan"); // 导入扩展类
            $KuoZhan = new KuoZhan();
            if ($KuoZhan->is_utf8($UserID) == false) {
                $UserID = iconv('GB2312', 'UTF-8', $UserID);
            }
            unset($KuoZhan);
            $where['user_name'] = array(
                'like',
                "%" . $UserID . "%"
            );
            $where['user_id'] = array(
                'like',
                "%" . $UserID . "%"
            );
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            $UserID = urlencode($UserID);
        }
        // 查询字段
        $field = '*';
        // =====================分页开始==============================================
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $member->where($map)->count(); // 总页数
        $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
        $page_where = 'UserID=' . $UserID; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $this->assign('page', $show); // 分页变量输出到模板
        $list = $member->where($map)->field($field)->order('bk4 asc,register_time desc')->page($Page->getPage() . ',' . $listrows)->select();
        $this->assign('list', $list); // 数据输出到模板
        $where = array();
        $where['user_id'] = $user_id;
        $member_rs = $member->where($where)->field('*')->find();
        $this->assign('frs', $member_rs);
        $this->display('menberok');
        exit();
    }
    // 开通会员
    public function menberAC()
    {
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $OpID = $_POST['tabledb'];
        if (! isset($OpID) || empty($OpID)) {
            $bUrl = __URL__ . '/menber';
            $this->_box(0, '请选择要开通的会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '开通会员':
                $this->_menberOpenUse($OpID, 1);
                break;
            
            case '删除会员':
                $this->_menberDelUse($OpID);
                break;
            default:
                $bUrl = __URL__ . '/menber';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }
    // 服务中心晋级确认
    public function agentUpLevelConfirm(){
        // 获取复选框的值
        $OpID = $_POST['tabledb'];
        if (! isset($OpID) || empty($OpID)) {
            $bUrl = __URL__ . '/memberuplevel';
            $this->_box(0, '没有该会员！', $bUrl, 1);
            exit();
        }
        if ($_SESSION['Urlszpass'] == 'MyssmenberUpLevel'){
            $i = 0;
            foreach ($OpID as $vo){
                $i++;
                $where = array();
                $where['id'] = $vo;
                $where['is_pay'] = 0;
                $promo = M('promo');
                $member = D('member');
                $fee = M ('fee');
                $fee_rs =$fee->field('s1,s2,s9,s4,s5')->find();
                $s2 =explode('|',$fee_rs['s2']);//单量
                $s3 =explode('|',$fee_rs['s9']);//每单金额
                $promo_rs = $promo->where($where)->find();
                if (!$promo_rs) {
                    $this->error('会员已经升过级,请刷新页面重试！');
                    exit;
                }
                $promo->query("update xt_promo set is_pay=1 where `id`=".$vo);
                $member_where = array();
                $member_where['user_id'] = $promo_rs['user_id'];
                $member_rs = $member->where($member_where)->find();
                $newlv = $promo_rs['up_level'];
                $oldlv  = $promo_rs['u_level'];
                //差额
                $need_m = $newlv-$oldlv;
                //单量
                $need_dl = bcdiv($need_m, $s3[0]);
                if($oldlv >=$newlv){
                    $this->error('只能向上升级');
                    exit;
                }
                if($oldlv >=40000){
                    $this->error('已经是最高级，无法再升级！');
                    exit;
                }
                //统计单数
                $member->xiangJiao($member_rs['id'], $need_dl);
                $member->tz($member_rs['p_path'],$need_m);
                //各种奖项
                $member->tuijj($member_rs['p_path'],$member_rs['user_id'],$need_m);
                $member->lingdao22($member_rs['p_path'],$member_rs['user_id'],$need_m);
                $member->sh_level();
                $member->baodanfei($member_rs['shop_id'],$member_rs['user_id'],$need_m,$member_rs['is_agent']);
                $member->dsfenhong($member_rs['p_path'],$member_rs['user_id'],$need_m);
                $member->query("update __TABLE__ set is_xf=0,u_level=1".",cpzj=".$newlv.",f4=f4+".$need_dl." where `id`=".$member_rs['id']);
                // 分红包记录表
                $nowdate = strtotime ("now");
                $member->jiaDan($member_rs['id'], $member_rs['user_id'], $nowdate, 0, 0, $need_dl, 0, 1);
            
                unset($member,$fee,$promo);
            }
            if($OpID) {
                $bUrl = __URL__.'/memberuplevel/';
                $this->_box(1,'晋级成功！',$bUrl,3);
            }else{
                $this->error('晋级失败！');
                exit;
            }
        }else{
            $this->error('错误！');
            exit;
        }
    }
    
    // =============================================开通会员
    private function _menberOpenUse($OpID = 0, $reg_money = 0)
    {
        if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao') {
            $member = D('member');
            $fee = M('fee');
            $gouwu = D('Gouwu');
            $shouru = M('shouru');
            $blist = M('blist');
            $Guzhi = A('Guzhi');
            if (! $member->autoCheckToken($_POST)) {
                $this->error('页面过期，请刷新页面！');
                exit();
            }
            // 被开通会员参数
            $where = array();
            $where['id'] = array('in',$OpID); // 被开通会员id数组
            $where['is_pay'] = 0; // 未开通的
            $field = '*';
            $vo = $member->where($where)->field($field)->order('id asc')->select();
            $fee_rs = $fee->field('str18,str19')->find();
            // 服务中心参数
            $where_two = array();
            $field_two = '*';
            $ID = $_SESSION[C('USER_AUTH_KEY')];
            $where_two['id'] = $ID;
            $nowdate = strtotime(date('c'));
            $nowday = strtotime(date('Y-m-d'));
            $nowmonth = date('m');
//             $member->emptyTime();
            foreach ($vo as $voo) {
                $rs = $member->where($where_two)
                    ->field($field_two)
                    ->find(); // 找出登录会员(必须为服务中心并且已经登录)
                if (! $rs) {
                    $this->error('会员错误！');
                    exit();
                }
                $ppath = $voo['p_path'];
                // 上级未开通不能开通下级员工
                $frs_where['is_pay'] = array(
                    'eq',
                    0
                );
                $frs_where['id'] = $voo['father_id'];
                $frs = $member->where($frs_where)->find();
                
                $us_money = $rs['agent_cash'];
                $money_b = $voo['cpzj'];
                
                if ($us_money < $money_b) {
                    $bUrl = __URL__ . '/menber';
                    $this->_box(0, '电子余额不足！', $bUrl, 1);
                    exit();
                }
                $r_id = $rs['id'];
                $is_agent = $rs['is_agent'];
                if ($reg_money == 1) {
                    $result = $member->execute("update __TABLE__ set `agent_cash`=agent_cash-" . $money_b . " where `id`=" . $ID);
                }
                if ($result) {
                    if ($reg_money == 1) {
                        $kt_cont = "开通会员";
                    }
                    // 奖金历史记录表
                    $member->addencAdd($rs['id'], $voo['user_id'], $money_b, 26, 0, 0, 0, $kt_cont); 
                    // 分红包记录表
                    $member->jiaDan($voo['id'], $voo['user_id'], $nowdate, 0, 0, $voo['f4'], 0, 0);
                                                                                               
                    // 给推荐人添加推荐人数和单数
                    $member->query("update __TABLE__ set `re_nums`=re_nums+1,re_f4=re_f4+" . $voo['f4'] . " where `id`=" . $voo['re_id']);
                    // 购物车管理
                    $gouwu->query("update __TABLE__ set `lx`=1 where `uid`=" . $voo['id']);
                    
                    $nnrs = $member->where('is_pay>0')
                        ->field('n_pai')
                        ->order('n_pai desc')
                        ->find();
                    $mynpai = ((int) $nnrs['n_pai']) + 1;
                    
                    $data = array();
                    $data['is_pay'] = 1;
                    $data['pdt'] = $nowdate;
                    $data['open'] = 0;
                    $data['get_date'] = $nowday;
                    $data['fanli_time'] = $nowday - 1; // 当天没有分红奖
                    $data['n_pai'] = $mynpai;
                    $data['is_zy'] = $voo['id'];
                    $data['kt_id'] = $r_id;
                    
                    if ($voo['f4'] == 50) {
                        $data['adt'] = $nowdate;
                        $data['is_agent'] = 2;
                    }
                    // 开通会员
                    $result = $member->where('id=' . $voo['id'])->save($data);
                    unset($data, $varray);
                    $data = array();
                    $data['uid'] = $voo['id'];
                    $data['user_id'] = $voo['user_id'];
                    $data['in_money'] = $voo['cpzj'];
                    $data['in_time'] = time();
                    $data['in_bz'] = "新会员加入";
                    $shouru->add($data);
                    unset($data);
                    
                    //统计单数
                    $member->xiangJiao($voo['id'], 1);
                    // 算出奖金
                    $member->getusjj($voo['id'], 1, $voo['cpzj']);
                }
            }
            unset($member, $where, $where_two, $rs);
            if ($vo) {
                unset($vo);
                $bUrl = __URL__ . '/menber';
                $this->_box(1, '开通会员成功！', $bUrl, 2);
                exit();
            } else {
                unset($vo);
                $bUrl = __URL__ . '/menber';
                $this->_box(0, '开通会员失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _menberDelUse($OpID = 0)
    {
        // =========================================删除会员
        if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao') {
            $member = M('member');
            $where['is_pay'] = 0;
            foreach ($OpID as $voo) {
                $rs = $member->find($voo);
                if ($rs) {
                    $whe['father_name'] = $rs['user_id'];
                    $rss = $member->where($whe)
                        ->field('id')
                        ->find();
                    if ($rss) {
                        $bUrl = __URL__ . '/menber';
                        $this->error('该 ' . $rs['user_id'] . ' 会员有下级会员，不能删除！');
                        exit();
                    } else {
                        $where['id'] = $voo;
                        $member->where($where)->delete();
                    }
                } else {
                    $this->error('错误!');
                }
            }
            $bUrl = __URL__ . '/menber';
            $this->_box(1, '删除会员！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误!');
        }
    }
    
    // 未开通会员
    public function frontMenber($Urlsz = 0)
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['Urlszpass'] == 'MyssDaShuiPuTao') {
            $member = M('member');
            $map = array();
            $user_id = $_SESSION['loginUseracc'];
            $gid = (int) $_GET['bj_id'];
            // 服务中心ID
            $map['bk5'] = $user_id;
            // 是否支付
            $map['bk4'] = array( 'gt',0);
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['user_name'] = array( 'like',"%" . $UserID . "%");
                $where['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            
            // 查询字段
            $field = "*";
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('register_time desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
            $this->display('frontMenber');
            exit();
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminAgents3()
    {
        // =====================================后台服务中心管理
        $this->_Admin_checkUser();
        if ($_SESSION['UrlPTPass'] == 'MyssGuanX') {
            $member = M('member');
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            // $map['is_del'] = array('eq',0);
            $map['is_agent'] = array(
                'gt',
                0
            );
            if (method_exists($this, '_filter')) {
                $this->_filter($map);
            }
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
                                         // =================================================
            
            $Agent_Us_Name = C('Agent_Us_Name');
            $Aname = explode("|", $Agent_Us_Name);
            $this->assign('Aname', $Aname);
            
            $this->display('adminAgents3');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminAgents()
    {
        // =====================================后台服务中心管理
        $this->_Admin_checkUser();
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua') {
            $member = M('member');
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            // $map['is_del'] = array('eq',0);
            $map['l_nums'] = array(
                'gt',
                0
            );
            if (method_exists($this, '_filter')) {
                $this->_filter($map);
            }
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
                                         // =================================================
            
            $Agent_Us_Name = C('Agent_Us_Name');
            $Aname = explode("|", $Agent_Us_Name);
            $this->assign('Aname', $Aname);
            
            $this->display('adminAgents');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminAgents1()
    {
        // =====================================后台服务中心管理
        $this->_Admin_checkUser();
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGu') {
            $member = M('member');
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            // $map['is_del'] = array('eq',0);
            $map['is_cc'] = array(
                'gt',
                0
            );
            if (method_exists($this, '_filter')) {
                $this->_filter($map);
            }
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
                                         // =================================================
            
            $Agent_Us_Name = C('Agent_Us_Name');
            $Aname = explode("|", $Agent_Us_Name);
            $this->assign('Aname', $Aname);
            
            $this->display('adminAgents1');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminAgents2()
    {
        // =====================================后台服务中心管理
        $this->_Admin_checkUser();
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiG') {
            $member = M('member');
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            // $map['is_del'] = array('eq',0);
            $map['is_cha'] = array(
                'gt',
                0
            );
            if (method_exists($this, '_filter')) {
                $this->_filter($map);
            }
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
                                         // =================================================
            
            $Agent_Us_Name = C('Agent_Us_Name');
            $Aname = explode("|", $Agent_Us_Name);
            $this->assign('Aname', $Aname);
            
            $this->display('adminAgents2');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminAgentsShow()
    {
        // 查看详细信息
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua') {
            $member = M('member');
            $ID = (int) $_GET['Sid'];
            $where = array();
            $where['id'] = $ID;
            $srs = $member->where($where)
                ->field('user_id,verify')
                ->find();
            $this->assign('srs', $srs);
            unset($member, $where, $srs);
            $this->display('adminAgentsShow');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminAgentsAC3()
    { // 审核服务中心(服务中心)申请
        $this->_Admin_checkUser();
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $XGid = $_POST['tabledb'];
        $member = M('member');
        // if (!$member->autoCheckToken($_POST)){
        // $this->error('页面过期，请刷新页面！');
        // exit;
        // }
        
        unset($member);
        if (! isset($XGid) || empty($XGid)) {
            $bUrl = __URL__ . '/adminAgents';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '确认':
                $this->_adminAgentsConfirm3($XGid);
                break;
            case '删除':
                $this->_adminAgentsDel3($XGid);
                break;
            default:
                $bUrl = __URL__ . '/adminAgents3';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }

    public function adminAgentsAC()
    { // 审核服务中心(服务中心)申请
        $this->_Admin_checkUser();
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $XGid = $_POST['tabledb'];
        $member = M('member');
        // if (!$member->autoCheckToken($_POST)){
        // $this->error('页面过期，请刷新页面！');
        // exit;
        // }
        
        unset($member);
        if (! isset($XGid) || empty($XGid)) {
            $bUrl = __URL__ . '/adminAgents';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '确认':
                $this->_adminAgentsConfirm($XGid);
                break;
            case '删除':
                $this->_adminAgentsDel($XGid);
                break;
            default:
                $bUrl = __URL__ . '/adminAgents';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }

    public function adminAgentsAC1()
    { // 审核服务中心(服务中心)申请
        $this->_Admin_checkUser();
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $XGid = $_POST['tabledb'];
        $member = M('member');
        // if (!$member->autoCheckToken($_POST)){
        // $this->error('页面过期，请刷新页面！');
        // exit;
        // }
        unset($member);
        if (! isset($XGid) || empty($XGid)) {
            $bUrl = __URL__ . '/adminAgents1';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '确认':
                $this->_adminAgentsConfirm1($XGid);
                break;
            case '删除':
                $this->_adminAgentsDel1($XGid);
                break;
            default:
                $bUrl = __URL__ . '/adminAgents1';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }

    public function adminAgentsAC2()
    { // 审核服务中心(服务中心)申请
        $this->_Admin_checkUser();
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $XGid = $_POST['tabledb'];
        
        $member = M('member');
        // if (!$member->autoCheckToken($_POST)){
        // $this->error('页面过期，请刷新页面！');
        // exit;
        // }
        
        unset($member);
        if (! isset($XGid) || empty($XGid)) {
            $bUrl = __URL__ . '/adminAgents1';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '确认':
                $this->_adminAgentsConfirm2($XGid);
                break;
            case '删除':
                $this->_adminAgentsDel2($XGid);
                break;
            default:
                $bUrl = __URL__ . '/adminAgents2';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }

    private function _adminAgentsConfirm2($XGid = 0)
    {
        // ==========================================确认申请服务中心
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiG') {
            $member = D('member');
            
            $fee = M('fee');
            $fee_rs = $fee->field('str9')->find(1);
            $str9 = $fee_rs['str9'];
            $where['id'] = array(
                'in',
                $XGid
            );
            $where['is_cha'] = 1;
            $rs = $member->where($where)
                ->field('*')
                ->select();
            
            $data = array();
            $history = M('history');
            $rewhere = array();
            // $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
            foreach ($rs as $rss) {
                
                $myreid = $rss['re_id'];
                $shoplx = $rss['shoplx'];
                
                $data['user_id'] = $rss['user_id'];
                $data['uid'] = $rss['uid'];
                $data['action_type'] = '申请油卡';
                $data['pdt'] = $nowdate;
                $data['epoints'] = $rss['agent_no'];
                $data['bz'] = '申请油卡';
                $data['did'] = 0;
                $data['allp'] = 0;
                $history->add($data);
                $sel = $rss['jia_nums'];
                if ($sel == 1) {
                    $member->query("UPDATE __TABLE__ SET is_cha=2,is_p=2,jia_nums=0 where id=" . $rss['id']); // 开通
                }
                if ($sel == 2) {
                    $member->query("UPDATE __TABLE__ SET is_cha=2,is_c=2,jia_nums=0 where id=" . $rss['id']); // 开通
                }
                if ($sel == 3) {
                    $member->query("UPDATE __TABLE__ SET is_cha=2,is_cty=2,jia_nums=0 where id=" . $rss['id']); // 开通
                }
            }
            
            unset($member, $where, $rs, $history, $data, $rewhere);
            $bUrl = __URL__ . '/adminAgents2';
            
            $this->_box(1, '确认申请！', $bUrl, 1);
            
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _adminAgentsConfirm1($XGid = 0)
    {
        // ==========================================确认申请服务中心
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGu') {
            $member = D('member');
            
            $fee = M('fee');
            $fee_rs = $fee->field('str9')->find(1);
            $str9 = $fee_rs['str9'];
            $where['id'] = array(
                'in',
                $XGid
            );
            $where['is_cc'] = 1;
            $rs = $member->where($where)
                ->field('*')
                ->select();
            
            $data = array();
            $history = M('history');
            $rewhere = array();
            // $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
            foreach ($rs as $rss) {
                
                $myreid = $rss['re_id'];
                $shoplx = $rss['shoplx'];
                
                $data['user_id'] = $rss['user_id'];
                $data['uid'] = $rss['uid'];
                $data['action_type'] = '申请油卡';
                $data['pdt'] = $nowdate;
                $data['epoints'] = $rss['agent_no'];
                $data['bz'] = '申请油卡';
                $data['did'] = 0;
                $data['allp'] = 0;
                $history->add($data);
                $member->query("UPDATE __TABLE__ SET is_cc=2,r_nums=r_nums+1 where id=" . $rss['id']); // 开通
                if ($rss['is_fenh'] == 0) {
                    $member->youka($rss['id'], $rss['user_id']);
                }
            }
            
            unset($member, $where, $rs, $history, $data, $rewhere);
            $bUrl = __URL__ . '/adminAgents1';
            
            $this->_box(1, '确认申请！', $bUrl, 1);
            
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _adminAgentsConfirm3($XGid = 0)
    {
        // ==========================================确认申请服务中心
        if ($_SESSION['UrlPTPass'] == 'MyssGuanX') {
            $member = D('member');
            $where['id'] = array(
                'in',
                $XGid
            );
            $where['is_agent'] = 1;
            $rs = $member->where($where)
                ->field('*')
                ->select();
            
            $data = array();
            $history = M('history');
            $rewhere = array();
            // $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
            foreach ($rs as $rss) {
                
                $myreid = $rss['re_id'];
                $shoplx = $rss['shoplx'];
                
                $data['user_id'] = $rss['user_id'];
                $data['uid'] = $rss['uid'];
                $data['action_type'] = '申请成为服务中心';
                $data['pdt'] = $nowdate;
                $data['epoints'] = $rss['agent_no'];
                $data['bz'] = '申请成为服务中心';
                $data['did'] = 0;
                $data['allp'] = 0;
                $history->add($data);
                
                $member->query("UPDATE __TABLE__ SET is_agent=2,adt=$nowdate,agent_max=0 where id=" . $rss['id']); // 开通
            }
            unset($member, $where, $rs, $history, $data, $rewhere);
            $bUrl = __URL__ . '/adminAgents3';
            $this->_box(1, '确认申请！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _adminAgentsConfirm($XGid = 0)
    {
        // ==========================================确认申请服务中心
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua') {
            $member = D('member');
            $where['id'] = array(
                'in',
                $XGid
            );
            $where['l_nums'] = 1;
            $rs = $member->where($where)
                ->field('*')
                ->select();
            
            $data = array();
            $history = M('history');
            $rewhere = array();
            // $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
            foreach ($rs as $rss) {
                
                $myreid = $rss['re_id'];
                $shoplx = $rss['shoplx'];
                
                $data['user_id'] = $rss['user_id'];
                $data['uid'] = $rss['uid'];
                $data['action_type'] = '申请成为商家';
                $data['pdt'] = $nowdate;
                $data['epoints'] = $rss['agent_no'];
                $data['bz'] = '申请成为商家';
                $data['did'] = 0;
                $data['allp'] = 0;
                $history->add($data);
                
                $member->query("UPDATE __TABLE__ SET l_nums=2,adt=$nowdate,agent_max=0 where id=" . $rss['id']); // 开通
            }
            unset($member, $where, $rs, $history, $data, $rewhere);
            $bUrl = __URL__ . '/adminAgents';
            $this->_box(1, '确认申请！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }

    public function cate($id = 0)
    {
        $member = M('member');
        $res = $member->where('id=' . $id)
            ->field('id,kt_id,is_agent')
            ->find();
        // print_r($res);die;
        
        if ($res) {
            
            if ($res['is_agent'] == 2) {
                
                $arr = $res['id'];
            } else {
                $ar = $res['kt_id'];
                $arr = $res['id'];
                $arr = $this->cate($ar);
            }
            
            return $arr;
        }
    }

    public function adminAgentsCoirmAC()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua') {
            // $this->_checkUser();
            $member = M('member');
            $content = $_POST['content'];
            $userid = trim($_POST['userid']);
            $where['user_id'] = $userid;
            // $rs=$member->where($where)->find();
            $member_rs = $member->where($where)
                ->field('id,is_agent,is_pay,user_id,user_name,agent_max,is_agent')
                ->find();
            
            if ($member_rs) {
                if ($member_rs['is_pay'] == 0) {
                    $this->error('临时代理商不能授权服务中心!');
                    exit();
                }
                if ($member_rs['is_agent'] == 1) {
                    $this->error('上次申请还没通过审核!');
                    exit();
                }
                if ($member_rs['is_agent'] == 2) {
                    $this->error('该代理商已是服务中心!');
                    exit();
                }
                if (empty($content)) {
                    $this->error('请输入备注!');
                    exit();
                }
                
                if ($member_rs['is_agent'] == 0) {
                    $nowdate = time();
                    $result = $member->query("update __TABLE__ set verify='" . $content . "',is_agent=2,idt=$nowdate,adt={$nowdate} where id=" . $member_rs['id']);
                }
                
                $bUrl = __URL__ . '/adminAgents';
                $this->_box(1, '授权成功！', $bUrl, 2);
            } else {
                $this->error('会员不存在！');
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _adminAgentsDel1($XGid = 0)
    {
        // =======================================删除申请服务中心信息
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGu') {
            $member = M('member');
            $rewhere = array();
            $where['is_cc'] = array(
                'gt',
                0
            );
            $where['id'] = array(
                'in',
                $XGid
            );
            $rs = $member->where($where)->select();
            foreach ($rs as $rss) {
                $member->query("UPDATE __TABLE__ SET is_cc=0,idt=0 where id>1 and id = " . $rss['id']);
            }
            
            // $shop->where($where)->delete();
            unset($member, $where, $rs, $rewhere);
            $bUrl = __URL__ . '/adminAgents1';
            $this->_box('操作成功', '删除申请！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误!');
            exit();
        }
    }

    private function _adminAgentsDel($XGid = 0)
    {
        // =======================================删除申请服务中心信息
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua') {
            $member = M('member');
            $rewhere = array();
            $where['l_nums'] = array(
                'gt',
                0
            );
            $where['id'] = array(
                'in',
                $XGid
            );
            $rs = $member->where($where)->select();
            foreach ($rs as $rss) {
                $member->query("UPDATE __TABLE__ SET l_nums=0,idt=0,adt=0,new_agent=0,shoplx=0,shop_a='',shop_b='' where id>1 and id = " . $rss['id']);
            }
            
            // $shop->where($where)->delete();
            unset($member, $where, $rs, $rewhere);
            $bUrl = __URL__ . '/adminAgents';
            $this->_box('操作成功', '删除申请！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误!');
            exit();
        }
    }

    private function _adminAgentsDel3($XGid = 0)
    {
        // =======================================删除申请服务中心信息
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua') {
            $member = M('member');
            $rewhere = array();
            $where['is_agent'] = array(
                'gt',
                0
            );
            $where['id'] = array(
                'in',
                $XGid
            );
            $rs = $member->where($where)->select();
            foreach ($rs as $rss) {
                $member->query("UPDATE __TABLE__ SET is_agent=0,idt=0,adt=0,new_agent=0,shoplx=0,shop_a='',shop_b='' where id>1 and id = " . $rss['id']);
            }
            
            // $shop->where($where)->delete();
            unset($member, $where, $rs, $rewhere);
            $bUrl = __URL__ . '/adminAgents';
            $this->_box('操作成功', '删除申请！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误!');
            exit();
        }
    }
    // 服务中心表
    public function financeDaoChu_BD()
    {
        $this->_Admin_checkUser();
        // 导出excel
        set_time_limit(0);
        
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Member-Agent.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        
        $member = M('member'); // 奖金表
        
        $map = array();
        $map['id'] = array(
            'gt',
            0
        );
        $map['is_agent'] = array(
            'gt',
            0
        );
        $field = '*';
        $list = $member->where($map)
            ->field($field)
            ->order('idt asc,adt asc')
            ->select();
        
        $title = "服务中心表 导出时间:" . date("Y-m-d   H:i:s");
        
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        // 输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="9"   align="center">' . $title . '</td></tr>';
        // 输出字段名
        echo '<tr  align=center>';
        echo "<td>序号</td>";
        echo "<td>会员编号</td>";
        echo "<td>姓名</td>";
        echo "<td>联系电话</td>";
        echo "<td>申请时间</td>";
        echo "<td>确认时间</td>";
        echo "<td>类型</td>";
        echo "<td>服务中心区域</td>";
        echo "<td>剩余注册币</td>";
        echo '</tr>';
        // 输出内容
        
        // dump($list);exit;
        
        $i = 0;
        foreach ($list as $row) {
            $i ++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            } else {
                $num = $i;
            }
            if ($row['shoplx'] == 1) {
                $nnn = '服务中心';
            } elseif ($row['shoplx'] == 2) {
                $nnn = '县/区代理商';
            } else {
                $nnn = '市级代理商';
            }
            
            echo '<tr align=center>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>" . $row['user_tel'] . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['idt']) . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['adt']) . "</td>";
            echo "<td>" . $nnn . "</td>";
            echo "<td>" . $row['shop_a'] . " / " . $row['shop_b'] . "</td>";
            echo "<td>" . $row['agent_cash'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    }
}
?>