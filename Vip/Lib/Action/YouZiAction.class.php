<?php
class YouZiAction extends CommonAction
{
    function _initialize()
    {
        $this->_inject_check(0); // 调用过滤函数
        $this->_checkUser();
        $this->_Admin_checkUser(); // 后台权限检测
        $this->_Config_name(); // 调用参数
        header("Content-Type:text/html; charset=utf-8");
    }
    // 二级密码验证
    public function cody()
    {
        $UrlID = (int) $_GET['c_id'];
        if (empty($UrlID)) {
            $this->error('二级密码错误!');
            exit();
        }
        if (! empty($_SESSION['password2'])) {
            $url = __URL__ . "/codys/Urlsz/$UrlID";
            $this->_boxx($url);
            exit();
        }
        $cody = M('cody');
        $list = $cody->where("c_id=$UrlID")->field('c_id')->find();
        if ($list) {
            $this->assign('vo', $list);
            $this->display('Public:cody');
            exit();
        } else {
            $this->error('二级密码错误!');
            exit();
        }
    }
    // 二级密码验证后调转页面
    public function codys()
    {
        $Urlsz = $_POST['Urlsz'];
        if (empty($_SESSION['password2'])) {
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
            $list = $member->where($where)->field('id')->find();
            if ($list == false) {
                $this->error('二级密码错误!');
                exit();
            }
            $_SESSION['password2'] = 1;
        } else {
            $Urlsz = $_GET['Urlsz'];
        }
        switch ($Urlsz) {
            case 1:
                $_SESSION['UrlPTPass'] = 'MyssShenShuiPuTao';
                $bUrl = __URL__ . '/auditMenber'; // 审核会员
                $this->_boxx($bUrl);
                break;
            case 2:
                $_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
                $bUrl = __URL__ . '/adminMenber'; // 会员管理
                $this->_boxx($bUrl);
                break;
            case 3:
                $_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
                $bUrl = __URL__ . '/setParameter'; // 参数设置
                $this->_boxx($bUrl);
                break;
            case 6:
                $_SESSION['UrlPTPass'] = 'MyssGuanPaoYingTao';
                $bUrl = __URL__ . '/adminCurrency'; // 提现管理
                $this->_boxx($bUrl);
                break;
            case 8:
                $_SESSION['UrlPTPass'] = 'MyssPiPa';
                $bUrl = __URL__ . '/adminFinanceTableShow'; // 奖金查询
                $this->_boxx($bUrl);
                break;
            case 9:
                $_SESSION['UrlPTPass'] = 'MyssQingKong';
                $bUrl = __URL__ . '/delTable'; // 清空数据
                $this->_boxx($bUrl);
                break;
            case 12:
                $_SESSION['UrlPTPass'] = 'MyssGuanMangGuo';
                $bUrl = __URL__ . '/adminCurrencyRecharge'; // 充值管理
                $this->_boxx($bUrl);
                break;
            case 18:
                $_SESSION['UrlPTPass'] = 'MyssMoneyFlows';
                $bUrl = __URL__ . '/adminmoneyflows'; // 财务流向管理
                $this->_boxx($bUrl);
                break;
            case 19:
                $_SESSION['UrlPTPass'] = 'MyssadminMenberJL';
                $bUrl = __URL__ . '/adminMenberJL';
                $this->_boxx($bUrl);
                break;
            case 21:
                $_SESSION['UrlPTPass'] = 'adminIndex';
                $bUrl = __URL__ . '/adminIndex'; // 管理员初始页面
                $this->_boxx($bUrl);
                break;
            case 24:
                $_SESSION['UrlPTPass'] = 'MyssWuliuList';
                $bUrl = __URL__ . '/adminLogistics'; // 物流管理
                $this->_boxx($bUrl);
                break;
            case 26:
                $_SESSION['UrlPTPass'] = 'MyssGuanChanPin';
                $bUrl = __URL__ . '/pro_index'; // 产品管理
                $this->_boxx($bUrl);
                break;
            default:
                $this->error('二级密码错误!');
                break;
        }
    }
    // 奖金查询(所有期所有会员)
    public function adminFinanceTable()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPiPa') {
            $this->check_prem('adminFinanceTable');
            $bonus = M('bonus'); // 奖金表
            $fee = M('fee'); // 参数表
            $times = M('times'); // 结算时间表
            $fee_rs = $fee->field('s18,s13')->find();
            $fee_s7 = explode('|', $fee_rs['s13']);
            $this->assign('fee_s7', $fee_s7); // 输出奖项名称数组
            
            $where = array();
            $sql = '';
            if (isset($_REQUEST['FanNowDate'])) { // 日期查询
                if (! empty($_REQUEST['FanNowDate'])) {
                    $time1 = strtotime($_REQUEST['FanNowDate']); // 这天 00:00:00
                    $time2 = strtotime($_REQUEST['FanNowDate']) + 3600 * 24 - 1; // 这天 23:59:59
                    $sql = "where e_date >= $time1 and e_date <= $time2";
                }
            }
            $sql2 = "where 1";
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = count($bonus->query("select id from __TABLE__ " . $sql . " group by did")); // 总记录数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'FanNowDate=' . $_REQUEST['FanNowDate']; // 分页条件
            if (! empty($page_where)) {
                $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            } else {
                $Page = new ZQPage($count, $listrows, 1, 0, 3);
            }
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $status_rs = ($Page->getPage() - 1) * $listrows;
            $list = $bonus->query("select e_date,did,sum(b0) as b0,sum(b8) as b8,sum(b9) as b9,sum(b10) as b10,sum(b11) as b11,sum(b12) as b12,sum(b13) as b13,sum(b14) as b14,sum(b15) as b15,sum(b16) as b16,sum(b17) as b17,sum(b18) as b18,sum(b19) as b19,sum(b20) as b20 from __TABLE__ " . $sql2 . " group by did  order by did desc limit " . $status_rs . "," . $listrows);
            
            foreach ($list as $key => $value) {
                for ($i = 8; $i < 50; $i ++) {
                    if ($value['b' . $i] != 0) {
                        $this->assign('b' . $i, $value['b' . $i]);
                        $this->assign('id', $value['did']);
                    }
                }
            }
            $this->assign('list', $list); // 数据输出到模板
            // 各项奖每页汇总
            $count = array();
            foreach ($list as $vo) {
                for ($b = 0; $b <= 100; $b ++) {
                    $count[$b] += $vo['b' . $b];
                    $count[$b] = $this->_2Mal($count[$b], 2);
                }
            }
            // 奖项名称与显示
            $this->assign('b_b', $b_b);
            $this->assign('c_b', $c_b);
            $this->assign('count', $count);
            // 输出扣费奖索引
            $this->assign('ind', 7); // 数组索引 +1
            $this->display('adminFinanceTable');
        } else {
            $this->error('错误');
            exit();
        }
    }
    // 查询这一期得奖会员资金
    public function adminFinanceTableShow()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao') {
            $this->check_prem('adminFinanceTableShow');
            $bonus = M('bonus'); // 奖金表
            $fee = M('fee'); // 参数表
            $times = M('times'); // 结算时间表
            
            $fee_rs = $fee->field('s18,s13')->find();
            $fee_s7 = explode('|', $fee_rs['s13']);
            $this->assign('fee_s7', $fee_s7); // 输出奖项名称数组
            
            $UserID = $_REQUEST['UserID'];
            
            $where = array();
            $sql = '';
            
            $did = (int) $_REQUEST['did'];
            
            $field = '*';
            $sql = "b8<0";
            $sql2 = "where b8<0";
            // =====================分页开始==============================================92607291105
            import("@.ORG.ZQPage"); // 导入分页类
            $count = count($bonus->query("select id from __TABLE__ where did= " . $did . $sql)); // 总记录数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'did/' . $_REQUEST['did']; // 分页条件
            if (! empty($page_where)) {
                $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            } else {
                $Page = new ZQPage($count, $listrows, 1, 0, 3);
            }
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $status_rs = ($Page->getPage() - 1) * $listrows;
            $list = $bonus->query("select * from __TABLE__ where b8<0  order by did desc limit " . $status_rs . "," . $listrows);
            foreach ($list as $key => $value) {
                for ($i = 8; $i < 50; $i ++) {
                    if ($value['b' . $i] != 0) {
                        $this->assign('b' . $i, $value['b' . $i]);
                    }
                }
            }
            $this->assign('list', $list); // 数据输出到模板
            $this->assign('did', $did);
            // 查看的这期的结算时间
            $this->assign('confirm', $list[0]['e_date']);
            
            $count = array();
            foreach ($list as $vo) {
                for ($b = 0; $b <= 100; $b ++) {
                    $count[$b] += $vo['b' . $b];
                    $count[$b] = $this->_2Mal($count[$b], 2);
                }
            }
            // 奖项名称与显示
            $this->assign('b_b', $b_b);
            $this->assign('c_b', $c_b);
            $this->assign('count', $count);
            
            $this->assign('int', 7);
            
            $this->display('adminFinanceTableShow');
        } else {
            $this->error('错误');
            exit();
        }
    }

    public function adminFinanceTableList()
    {
        $this->check_prem('adminFinanceTableList');
        // 奖金明细
        if ($_SESSION['UrlPTPass'] == 'MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao') { // MyssShiLiu
            $times = M('times');
            $history = M('history');
            
            $UID = (int) $_GET['uid'];
            $did = (int) $_REQUEST['did'];
            
            $where = array();
            if (! empty($did)) {
                $rs = $times->find($did);
                if ($rs) {
                    $rs_day = $rs['benqi'];
                    $where['pdt'] = array(
                        array(
                            'gt',
                            $rs['shangqi']
                        ),
                        array(
                            'elt',
                            $rs_day
                        )
                    ); // 大于上期,小于等于本期
                } else {
                    $this->error('错误!');
                    exit();
                }
            }
            $where['uid'] = $UID;
            $where['type'] = 1;
            
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $history->where($where)->count(); // 总页数
                                                       // dump($history);exit;
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'did=' . (int) $_REQUEST['did']; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $history->where($where)
                ->field($field)
                ->order('id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
            $fee = M('fee'); // 参数表
            $fee_rs = $fee->field('s18,s13')->find();
            $fee_s7 = explode('|', $fee_rs['s13']);
            $this->assign('fee_s7', $fee_s7); // 输出奖项名称数组
            
            $this->display('adminFinanceTableList');
        } else {
            $this->error('错误!');
            exit();
        }
    }
    
    // 审核会员
    public function auditMenber($GPid = 0)
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
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
            
            $ID = $_SESSION[C('USER_AUTH_KEY')];
            
            $map['is_pay'] = array(
                'eq',
                0
            );
            
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
            $list = $member->where($map)
                ->field($field)
                ->order('is_pay,id,rdt desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            
            $this->assign('list', $list); // 数据输出到模板
            $this->display('auditMenber');
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function auditMenberData()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            // 查看会员详细信息
            $member = M('member');
            $ID = (int) $_GET['PT_id'];
            // 判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 11) {
                $this->error('数据错误!');
                exit();
            }
            $where = array();
            $where['id'] = $ID;
            $field = '*';
            $vo = $member->where($where)
                ->field($field)
                ->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $this->display();
            } else {
                $this->error('数据错误!');
                exit();
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function auditMenberData2()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            // 查看会员详细信息
            $member = M('member');
            $ID = (int) $_GET['PT_id'];
            // 判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 11) {
                $this->error('数据错误!');
                exit();
            }
            $where = array();
            $where['id'] = $ID;
            $field = '*';
            $vo = $member->where($where)
                ->field($field)
                ->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $this->display();
            } else {
                $this->error('数据错误!');
                exit();
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    public function auditMenberData2AC()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            
            $member = M('member');
            $data = array();
            
            $where['id'] = (int) $_POST['id'];
            $rs = $member->where('is_pay = 0')->find($where['id']);
            if (! $rs) {
                $this->error('非法操作!');
                exit();
            }
            
            $data['nickname'] = $_POST['NickName'];
            $rs = $member->where($data)->find();
            if ($rs) {
                if ($rs['id'] != $where['id']) {
                    $this->error('该会员名已经存在!');
                    exit();
                }
            }
            $data['bank'] = $_POST['BankName'];
            $data['bankcard_number'] = $_POST['bankcard_number'];
            $data['user_name'] = $_POST['UserName'];
            $data['bank_province'] = $_POST['BankProvince'];
            $data['bank_city'] = $_POST['BankCity'];
            $data['user_code'] = $_POST['UserCode'];
            $data['bank_address'] = $_POST['BankAddress'];
            $data['user_address'] = $_POST['UserAddress'];
            $data['user_post'] = $_POST['UserPost'];
            $data['user_tel'] = $_POST['UserTel'];
            $data['bank_province'] = $_POST['BankProvince'];
            $data['is_lock'] = $_POST['isLock'];
            
            $member->where($where)
                ->data($data)
                ->save();
            $bUrl = __URL__ . '/auditMenberData2/PT_id/' . $where['id'];
            $this->_box(1, '修改会员信息！', $bUrl, 1);
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function auditMenberAC()
    {
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $PTid = $_POST['tabledb'];
        if (! isset($PTid) || empty($PTid)) {
            $bUrl = __URL__ . '/auditMenber';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '开通会员':
                $this->_auditMenberOpenUser($PTid);
                break;
            case '设为空单':
                $this->_auditMenberOpenNull($PTid);
                break;
            case '删除会员':
                $this->_auditMenberDelUser($PTid);
                break;
            case '申请通过':
                $this->_AdminLevelAllow($PTid);
                break;
            case '拒绝通过':
                $this->_AdminLevelNo($PTid);
                break;
            default:
                $bUrl = __URL__ . '/auditMenber';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }
    
    // 审核会员升级-通过
    private function _AdminLevelAllow($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanUplevel') {
            $member = M('member');
            $where = array();
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['sel_level'] = array(
                'lt',
                90
            );
            $vo = $member->where($where)
                ->field('id,sel_level')
                ->select();
            foreach ($vo as $voo) {
                $where = array();
                $data = array();
                $where['id'] = $voo['id'];
                $data['u_level'] = $voo['sel_level'];
                $data['sel_level'] = 98;
                $member->where($where)
                    ->data($data)
                    ->save();
            }
            
            $bUrl = __URL__ . '/admin_level';
            $this->_box(1, '会员升级通过！', $bUrl, 1);
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    
    // 审核会员升级-拒绝
    private function _AdminLevelNo($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanUplevel') {
            $member = M('member');
            $where = array();
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['sel_level'] = array(
                'lt',
                90
            );
            $vo = $member->where($where)
                ->field('id')
                ->select();
            foreach ($vo as $voo) {
                $where = array();
                $data = array();
                $where['id'] = $voo['id'];
                $data['sel_level'] = 97;
                $member->where($where)
                    ->data($data)
                    ->save();
            }
            
            $bUrl = __URL__ . '/admin_level';
            $this->_box(1, '拒绝会员升级！', $bUrl, 1);
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    // 设为空单
    private function _auditMenberOpenNull($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $member = D('member');
            $where = array();
            if (! $member->autoCheckToken($_POST)) {
                $this->error('页面过期，请刷新页面！');
                exit();
            }
            $ID = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['is_pay'] = 0;
            $field = "id,u_level,re_id,cpzj,re_path,user_id,p_path,p_level,shop_id,f4";
            $vo = $member->where($where)
                ->order('rdt asc')
                ->field($field)
                ->select();
            $nowdate = strtotime(date('c'));
            $nowday = strtotime(date('Y-m-d'));
            $nowmonth = date('m');
            
            foreach ($vo as $voo) {
                $ppath = $voo['p_path'];
                // 上级未开通不能开通下级员工
                $frs_where['is_pay'] = array(
                    'eq',
                    0
                );
                $frs_where['id'] = $voo['father_id'];
                $frs = $member->where($frs_where)->find();
                if ($frs) {
                    $this->error('开通失败，上级未开通');
                    exit();
                }
                
                $nnrs = $member->where('is_pay>0')
                    ->field('n_pai')
                    ->order('n_pai desc')
                    ->find();
                $mynpai = ((int) $nnrs['n_pai']) + 1;
                
                $data = array();
                $data['is_pay'] = 2;
                $data['pdt'] = $nowdate;
                $data['open'] = 1;
                $data['get_date'] = $nowday;
                $data['fanli_time'] = $nowday;
                $data['n_pai'] = $mynpai;
                
                // $data['n_pai'] = $max_p;
                // $data['x_pai'] = $myppp;
                // 开通会员
                $result = $member->where('id=' . $voo['id'])->save($data);
                unset($data, $varray);
            }
            unset($member, $where, $field, $vo, $nowday);
            $bUrl = __URL__ . '/auditMenber';
            $this->_box(1, '设为空单！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }
    
    // 开通会员
    private function _auditMenberOpenUser($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $member = D('member');
            $shouru = M('shouru');
            $blist = M('blist');
            $gouwu = D('Gouwu');
            $fee = M('fee');
            $Guzhi = A('Guzhi');
            $fee_rs = $fee->field('s3')->find();
            $s3 = explode("|", $fee_rs['s3']);
            $where = array();
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['is_pay'] = 0;
            $field = "*";
            $vo = $member->where($where)
                ->field($field)
                ->order('id asc')
                ->select();
            $nowdate = strtotime(date('c'));
            $nowday = strtotime(date('Y-m-d'));
            $nowmonth = date('m');
            $member->emptyTime();
            foreach ($vo as $voo) {
                // 给推荐人添加推荐人数或单数
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
                $data['open'] = 1;
                $data['get_date'] = $nowday;
                $data['fanli_time'] = $nowday - 1; // 当天没有分红奖
                $data['n_pai'] = $mynpai;
                if ($voo['f4'] == 50) {
                    $data['adt'] = $nowdate;
                    $data['is_agent'] = 2;
                }
                
                $data['is_zy'] = $voo['id'];
                $data['kt_id'] = 1;
                $r_id = 1;
                $data['re_pathb'] = $r_id . ','; // 开通路径
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
                
                // 统计单数
                $member->xiangJiao($voo['id'], 1);
                // 分红包记录表
                $member->jiaDan($voo['id'], $voo['user_id'], $nowdate, 0, 0, $voo['f4'], 0, 0);
                // 算出奖金
                $member->getusjj($voo['id'], 1, $voo['cpzj']);
            }
            // $this->_clearing();
            unset($member, $field, $where, $vo);
            $bUrl = __URL__ . '/auditMenber';
            $this->_box(1, '开通会员成功！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _auditMenberDelUser($PTid = 0)
    {
        // 删除会员
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $member = M('member');
            $ispay = M('ispay');
            $where['is_pay'] = 0;
            // $where['id'] = array ('in',$PTid);
            foreach ($PTid as $voo) {
                $rs = $member->find($voo);
                if ($rs) {
                    $whe['father_name'] = $rs['user_id'];
                    $rss = $member->where($whe)->find();
                    if ($rss) {
                        $bUrl = __URL__ . '/auditMenber';
                        $this->error('该 ' . $rs['user_id'] . ' 会员有下级会员，不能删除！');
                        exit();
                    } else {
                        $where['id'] = $voo;
                        $a = $member->where($where)->delete();
                        $bUrl = __URL__ . '/auditMenber';
                        $this->_box(1, '删除会员！', $bUrl, 1);
                    }
                } else {
                    $this->error('错误!');
                }
            }
        } else {
            $this->error('错误!');
        }
    }

    public function adminMenber($GPid = 0)
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['type'];
            $map = array();
            // 模糊查询
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['user_name'] = array( 'like',"%" . $UserID . "%");
                $where['user_id'] = array( 'like', "%" . $UserID . "%");
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            $map['is_pay'] = array('egt',1);
            // 查询字段
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $listrows = 20; // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)->field($field)->order('register_time desc,id desc')->page($Page->getPage() . ',' . $listrows)->select();
            $money_count = $member->where($map)->sum('money');
            $this->assign('$money_count', $money_count);
            $f4_count = $member->where('id>1')->sum('money');
            $this->assign('f4_count22', $f4_count);
            $this->assign('list', $list); // 数据输出到模板
            $title = '会员管理';
            $this->assign('title', $title);
            $this->display('adminMenber');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    // 显示劳资详细
    public function BonusShow($GPid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $hi = M('history');
            $where = array();
            $where['Uid'] = $_REQUEST['PT_id'];
            $where['type'] = 19;
            
            $list = $hi->where($where)->select();
            $this->assign('list', $list);
            $this->display('BonusShow');
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    
    // 会员详细信息显示
    public function adminuserData()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle' || $_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            // 查看会员详细信息
            $member = M('member');
            $ID = (int) $_GET['PT_id'];
            // 判断获取数据的真实性 长度
            if (strlen($ID) > 11) {
                $this->error('数据错误!');
                exit();
            }
            $where = array();
            $where['id'] = $ID;
            $field = '*';
            // 查询会员表
            $vo = $member->where($where)->field($field)->find();
            $this->assign('b_bank', $vo);
            $this->assign('vo', $vo);
            if ($vo) {
                // 查询银行列表
                $fee = M('fee');
                $fee_s = $fee->field('s10')->find();
                $bank = explode('|', $fee_s['s10']);
                $this->assign('bank', $bank);
                $this->display();
            } else {
                $this->error('数据错误!');
                exit();
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    // 管理员修改会员信息保存
    public function adminuserDataSave()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle' || $_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $member = M('member');
            if (! $member->autoCheckToken($_POST)) {
                $this->error('页面过期，请刷新页面！');
            }
            $ID = (int) $_POST['ID'];
            $data = array();
            
            // ID
            $data['id'] = $_POST['ID'];
            // 用户名
            $data['user_name'] = $_POST['user_name'];
            // 一级密码不加密
            $data['pwd1'] = trim($_POST['pwd1']);
            // 二级密码不加密
            $data['pwd2'] = trim($_POST['pwd2']);
            // 一级密码加密
            $data['password'] = md5(trim($_POST['pwd1']));
            // 二级密码加密
            $data['password2'] = md5(trim($_POST['pwd2']));
            // 开户银行
            $data['bank'] = $_POST['bank'];
            // 开户银行卡号
            $data['bankcard_number'] = $_POST['bankcard_number'];
            // 开户银行省份
            $data['bank_province'] = $_POST['bank_province'];
            // 开户银行城市
            $data['bank_city'] = $_POST['bank_city'];
            // 开户银行详细地址
            $data['bank_address'] = $_POST['bank_address'];
            // 身份证号
            $data['user_code'] = $_POST['user_code'];
            // 手机号
            $data['tel'] = $_POST['tel'];
            // 现金币
            $data['cash'] = $_POST['cash'];
            // 积分
            $data['point'] = $_POST['point'];
            // 基金
            $data['bk8'] = $_POST['bk8'];
            
            $result = $member->save($data);
            unset($data);
            if ($result) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '资料修改成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '资料修改失败！', $bUrl, 1);
            }
        } else {
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(0, '数据错误！', $bUrl, 1);
            exit();
        }
    }

    public function slevel()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            // 查看会员详细信息
            $member = M('member');
            $ID = (int) $_GET['PT_id'];
            // 判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 15) {
                $this->error('数据错误!');
                exit();
            }
            $where = array();
            // 查询条件
            // $where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = $ID;
            $field = '*';
            $vo = $member->where($where)
                ->field($field)
                ->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $this->display();
            } else {
                $this->error('数据错误!');
                exit();
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function slevelsave()
    { // 升级保存数据
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            // 查看会员详细信息
            $member = D('member');
            $fee = M('fee');
            $ID = (int) $_POST['ID'];
            $slevel = (int) $_POST['slevel']; // 升级等级
                                              
            // 判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 15 or $ID <= 0) {
                $this->error('数据错误!');
                exit();
            }
            
            $fee_rs = $fee->find(1);
            if ($slevel <= 0 or $slevel >= 7) {
                $this->error('升级等级错误！');
                exit();
            }
            
            $where = array();
            // 查询条件
            // $where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = $ID;
            $field = '*';
            $vo = $member->where($where)
                ->field($field)
                ->find();
            if ($vo) {
                switch ($slevel) { // 通过注册等级从数据库中找出注册金额及认购单数
                    case 1:
                        $cpzj = $fee_rs['uf1']; // 注册金额
                        $F4 = $fee_rs['jf1']; // 自身认购单数
                        break;
                    case 2:
                        $cpzj = $fee_rs['uf2'];
                        $F4 = $fee_rs['jf2'];
                        break;
                    case 3:
                        $cpzj = $fee_rs['uf3'];
                        $F4 = $fee_rs['jf3'];
                        break;
                    case 4:
                        $cpzj = $fee_rs['uf4'];
                        $F4 = $fee_rs['jf4'];
                        break;
                    case 5:
                        $cpzj = $fee_rs['uf5'];
                        $F4 = $fee_rs['jf5'];
                        break;
                    case 6:
                        $cpzj = $fee_rs['uf6'];
                        $F4 = $fee_rs['jf6'];
                        break;
                }
                
                $number = $F4 - $vo['f4']; // 升级所需单数差
                $data = array();
                $data['u_level'] = $slevel; // 升级等级
                $data['cpzj'] = $cpzj; // 注册金额
                $data['f4'] = $F4; // 自身认购单数
                $member->where($where)
                    ->data($data)
                    ->save();
                
                $member->xiangJiao_lr($ID, $number); // 住上统计单数
                
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '会员升级！', $bUrl, 1);
                exit();
            } else {
                $this->error('数据错误!');
                exit();
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }

    public function adminMenberAC()
    {
        // 处理提交按钮
        $action = $_POST['action'];
        // 获取复选框的值
        $PTid = $_POST['tabledb'];
        if (! isset($PTid) || empty($PTid)) {
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit();
        }
        switch ($action) {
            case '开启会员':
                $this->_adminMenberOpen($PTid);
                break;
            case '锁定会员':
                $this->_adminMenberLock($PTid);
                break;
            case '奖金提现':
                $this->adminMenberCurrency($PTid);
                break;
            case '开启奖金':
                $this->adminMenberFenhong($PTid);
                break;
            case '删除会员':
                $this->adminMenberDel($PTid);
                break;
            case '关闭奖金':
                $this->_Lockfenh($PTid);
                break;
            case '设为实体服务中心':
                $this->_relAgent($PTid);
                break;
            case '解除实体服务中心':
                $this->_relAgentCancel($PTid);
                break;
            case '开启期限':
                $this->_OpenQd($PTid);
                break;
            case '关闭期限':
                $this->_LockQd($PTid);
                break;
            case '开启分红奖':
                $this->_OpenFh($PTid);
                break;
            case '关闭分红奖':
                $this->_LockFh($PTid);
                break;
            case '奖金转注册币':
                $this->adminMenberZhuan($PTid);
                break;
            case '设为报单中心':
                $this->_adminMenberAgent($PTid);
                break;
            case '设为代理商':
                $this->_adminMenberJB($PTid);
            case '取消代理商':
                $this->adminMenberJBcancel($PTid);
                break;
            case '设为物流管理':
                $this->_adminMenberWL($PTid);
            case '设为财务管理':
                $this->_adminMenberCw($PTid);
            case '取消管理员':
                $this->adminMenberWLcancel($PTid);
                break;
            default:
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }

    public function adminMenberDL()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $result = $member->execute('update __TABLE__ set agent_cash=agent_cash+agent_use,agent_use=0 where is_pay>0');
            
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '转换会员奖金为注册币！', $bUrl, 1);
        } else {
            $this->error('错误!');
        }
    }

    public function adminMenberZhuan($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array(
                'in',
                $PTid
            );
            $rs = $member->where($where)
                ->field('id')
                ->select();
            foreach ($rs as $vo) {
                $myid = $vo['id'];
                $member->execute('update __TABLE__ set agent_cash=agent_cash+agent_use,agent_use=0 where is_pay>0 and id=' . $myid . '');
            }
            unset($member, $where, $rs, $myid, $result);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '转换会员奖金为注册币！', $bUrl, 1);
        } else {
            $this->error('错误!');
        }
    }

    private function _adminMenberJB($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['is_pay'] = array(
                'gt',
                0
            );
            $where['is_jb'] = array(
                'eq',
                0
            );
            $rs = $member->where($where)->setField('is_jb', '1');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '设为代理商成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '设为代理商失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    public function adminMenberJBcancel($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array(
                'in',
                $PTid
            );
            $rs = $member->where($where)
                ->field('id')
                ->select();
            foreach ($rs as $vo) {
                $myid = $vo['id'];
                $member->execute('update __TABLE__ set is_jb=0 where is_pay>0 and is_jb>0 and id=' . $myid . '');
            }
            unset($member, $where, $rs, $myid, $result);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '取消代理商成功！', $bUrl, 1);
        } else {
            $this->error('错误2!');
        }
    }

    private function _adminMenberCw($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['is_pay'] = array(
                'gt',
                0
            );
            $where['is_aa'] = array(
                'eq',
                0
            );
            $rs = $member->where($where)->setField('is_aa', '1');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '设为物流管理成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '设为物流管理失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _adminMenberWL($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['is_pay'] = array(
                'gt',
                0
            );
            $where['is_aa'] = array(
                'eq',
                0
            );
            $rs = $member->where($where)->setField('is_aa', '2');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '设为物流管理成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '设为物流管理失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    public function adminMenberWLcancel($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array(
                'in',
                $PTid
            );
            $rs = $member->where($where)
                ->field('id')
                ->select();
            foreach ($rs as $vo) {
                $myid = $vo['id'];
                $member->execute('update __TABLE__ set is_aa=0 where is_pay>0 and is_aa>0 and id=' . $myid . '');
            }
            unset($member, $where, $rs, $myid, $result);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '取消管理员成功！', $bUrl, 1);
        } else {
            $this->error('错误2!');
        }
    }

    private function adminMenberDel($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $times = M('times');
            $bonus = M('bonus');
            $history = M('history');
            $chongzhi = M('chongzhi');
            $gouwu = M('gouwu');
            $tiqu = M('tiqu');
            $zhuanj = M('zhuanj');
            
            foreach ($PTid as $voo) {
                $rs = $member->find($voo);
                if ($rs) {
                    $id = $rs['id'];
                    $whe['id'] = $rs['father_id'];
                    $con = $member->where($whe)->count();
                    if ($id == 1) {
                        $bUrl = __URL__ . '/adminMenber';
                        $this->error('该 ' . $rs['user_id'] . ' 不能删除！');
                        exit();
                    }
                    if ($con == 2) {
                        $bUrl = __URL__ . '/adminMenber';
                        $this->error('该 ' . $rs['user_id'] . ' 会员有下级会员，不能删除！');
                        exit();
                    }
                    if ($con == 1) {
                        $this->set_Re_Path($id);
                        $this->set_P_Path($id);
                    }
                    $where = array();
                    $where['id'] = $voo;
                    $map['uid'] = $voo;
                    $bonus->where($map)->delete();
                    $history->where($map)->delete();
                    $chongzhi->where($map)->delete();
                    $times->where($map)->delete();
                    $tiqu->where($map)->delete();
                    $zhuanj->where($map)->delete();
                    $gouwu->where($map)->delete();
                    $member->where($where)->delete();
                    $bUrl = __URL__ . '/adminMenber';
                    $this->_box(1, '删除会员！', $bUrl, 1);
                }
            }
        } else {
            $this->error('错误!');
        }
    }
    
    // 修复推荐路径
    public function set_Re_Path($id)
    {
        $member = M("member");
        // 根据选择ID查询会员表
        $frs = $member->find($id);
        // 根据ID向下查询
        $member_rs = $member->where("re_id=" . $id)->select();
        foreach ($member_rs as $xr_vo) {
            // ID
            $id = $xr_vo['id'];
            // 推荐人ID
            $re_id = $xr_vo['re_id'];
            // 推荐路径
            $re_path = $xr_vo['re_path'];
            // 正确的推荐路径
            $path = $frs['re_path'] . $re_id . ',';
            // 如果路径正确继续查询
            if ($re_path != $path) {
                $this->error($id);
                // 执行路径更新
                $member->execute("UPDATE __TABLE__ SET re_path=" . $path . " where id= " . $id);
            }
            // 递归更新数据
            $this->set_Re_Path($id);
        }
    }

    public function set_P_Path($id)
    {
        $member = M("member");
        $frs = $member->find($id);
        
        $r_rs = $member->find($frs['father_id']);
        $xr_rs = $member->where("father_id=" . $id)->find();
        if ($xr_rs) {
            $p_level = $r_rs['p_level'] + 1;
            $p_path = $r_rs['p_path'] . $r_rs['id'] . ',';
            $member->execute("UPDATE __TABLE__ SET treeplace=" . $frs['treeplace'] . ",father_id=" . $r_rs['id'] . ",father_name='" . $r_rs['user_id'] . "',p_path='" . $p_path . "',p_level=" . $p_level . " where `id`= " . $xr_rs['id']);
            // 修改节点路径
            $f_where = array();
            $f_where['p_path'] = array(
                'like',
                '%,' . $xr_rs['id'] . ',%'
            );
            $ff_rs = $member->where($f_where)
                ->order('p_level asc')
                ->select();
            $r_where = array();
            foreach ($ff_rs as $fvo) {
                $r_where['id'] = $fvo['father_id'];
                $sr_rs = $member->where($r_where)->find();
                $p_level = $sr_rs['p_level'] + 1;
                $p_path = $sr_rs['p_path'] . $sr_rs['id'] . ',';
                $member->execute("UPDATE __TABLE__ SET p_path='" . $p_path . "',p_level=" . $p_level . " where `id`= " . $fvo['id']);
            }
        }
    }

    public function jiandan($Pid = 0, $DanShu = 1, $pdt, $t_rs)
    {
        // ========================================== 往上统计单数
        $member = M('member');
        $where = array();
        $where['id'] = $Pid;
        $field = 'treeplace,father_id,pdt';
        $vo = $member->where($where)
            ->field($field)
            ->find();
        if ($vo) {
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
            if ($pdt > $t_rs) {
                if ($TPe == 0 && $Fid > 0) {
                    $member->execute("update __TABLE__ Set `l`=l-$DanShu, `benqi_l`=benqi_l-$DanShu where `id`=" . $Fid);
                } elseif ($TPe == 1 && $Fid > 0) {
                    $member->execute("update __TABLE__ Set `r`=r-$DanShu, `benqi_r`=benqi_r-$DanShu  where `id`=" . $Fid);
                }
            } else {
                if ($TPe == 0 && $Fid > 0) {
                    $member->execute("update __TABLE__ Set `l`=l-$DanShu where `id`=" . $Fid);
                } elseif ($TPe == 1 && $Fid > 0) {
                    $member->execute("update __TABLE__ Set `r`=r-$DanShu  where `id`=" . $Fid);
                }
            }
            
            if ($Fid > 0)
                $this->jiandan($Fid, $DanShu, $pdt, $t_rs);
        }
        unset($where, $field, $vo, $pdt, $t_rs);
    }
    
    // 开启奖金
    private function adminMenberFenhong($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array('in',$PTid);
            $where['is_pay'] = array('gt',0);
            $rs = $member->where($where)->setField('is_fenh', '0');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启奖金成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启奖金失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }
    // 关闭奖金
    private function _Lockfenh($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['is_pay'] = array('egt',1);
            $where['_string'] = 'id>1';
            $where['id'] = array('in',$PTid);
            $rs = $member->where($where)->setField('is_fenh', '1');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '关闭奖金成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '关闭奖金失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }
    
    // 服务中心设置
    private function _relAgent($PTid = 0)
    {
        // 设置实体服务中心
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array('in',$PTid);
            $rs = $member->where($where)->setField('is_agent', '1');
    
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '服务中心设置成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '服务中心设置失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }
    
    // 服务中心解除
    private function _relAgentCancel($PTid = 0)
    {
        // 设置实体服务中心
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['is_aa'] = array('egt',1);
            $where['id'] = array('in',$PTid);
            $rs = $member->where($where)->setField('is_agent', '0');
    
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '实体服务中心解除成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '实体服务中心解除失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }
    
    // 开启会员
    private function _adminMenberOpen($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array('in',$PTid);
            $rs = $member->where($where)->setField('status', '0');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启会员成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启会员失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    private function _adminMenberLock($PTid = 0)
    {
        // 锁定会员
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['id'] = array('in', $PTid);
            $rs = $member->where($where)->setField('status', '1');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '锁定会员成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '锁定会员失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }
    
    // 设为服务中心
    private function _adminMenberAgent($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            
            $member = M('member');
            $where['id'] = array('in',$PTid);
            $where['is_agent'] = array('lt',1);
            $rs1 = $member->where($where)->setField('is_agent', '1');
            if ($rs1) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '设置服务中心成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '设置服务中心失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误！');
            exit();
        }
    }

    public function cate($id = 0)
    {
        $member = M('member');
        $res = $member->where('id=' . $id)->field('id,kt_id,is_agent')->find();
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
    
    // 开启分红奖
    private function _OpenFh($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $nowday = strtotime(date('Y-m-d'));
            $where['is_lockfh'] = array(
                'egt',
                1
            );
            $where['_string'] = 'id>1';
            $where['id'] = array(
                'in',
                $PTid
            );
            $varray = array(
                'is_lockfh' => '0',
                'fanli_time' => $nowday
            );
            $rs = $member->where($where)->setField($varray);
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启分红奖成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启分红奖失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }
    // 关闭分红奖
    private function _LockFh($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where['is_lockfh'] = array(
                'egt',
                0
            );
            $where['_string'] = 'id>1';
            $where['id'] = array(
                'in',
                $PTid
            );
            $rs = $member->where($where)->setField('is_lockfh', '1');
            
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '关闭分红奖成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '关闭分红奖失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }

    public function adminMenberUP()
    {
        // 会员晋级
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $PTid = (int) $_GET['UP_ID'];
            $rs = $member->find($PTid);
            
            if (! $rs) {
                $this->error('非法操作！');
                exit();
            }
            
            switch ($rs['u_level']) {
                case 1:
                    $member->query("UPDATE `xt_member` SET u_level=2,b12=2000 where id=" . $PTid);
                    break;
                case 2:
                    $member->query("UPDATE `xt_member` SET u_level=3,b12=4000 where id=" . $PTid);
                    break;
            }
            
            unset($member, $PTid);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '晋升！', $bUrl, 1);
        } else {
            $this->error('错误!');
        }
    }
    
    // =================================================管理员帮会员提现处理
    public function adminMenberCurrency($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $member = M('member');
            $where = array(); //
            $tiqu = M('tiqu');
            // 查询条件
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['agent_use'] = array(
                'egt',
                100
            );
            $field = 'id,user_id,agent_use,bank,bankcard_number,user_name';
            $member_rs = $member->where($where)
                ->field($field)
                ->select();
            
            $data = array();
            $tiqu_where = array();
            $eB = 0.02; // 提现税收
            $nowdate = strtotime(date('c'));
            foreach ($member_rs as $vo) {
                $is_qf = 0; // 区分上次有没有提现
                $ePoints = 0;
                $ePoints = $vo['agent_use'];
                
                $tiqu_where['uid'] = $vo['id'];
                $tiqu_where['is_pay'] = 0;
                $trs = $tiqu->where($tiqu_where)
                    ->field('id')
                    ->find();
                if ($trs) {
                    $is_qf = 1;
                }
                // 提现税收
                // if ($ePoints >= 10 && $ePoints <= 100){
                // $ePoints1 = $ePoints - 2;
                // }else{
                // $ePoints1 = $ePoints - $ePoints * $eB;//(/100);
                // }
                
                if ($is_qf == 0) {
                    $member->query("UPDATE `xt_member` SET `zsq`=zsq+agent_use,`agent_use`=0 where `id`=" . $vo['id']);
                    // 开始事务处理
                    $data['uid'] = $vo['id'];
                    $data['user_id'] = $vo['user_id'];
                    $data['rdt'] = $nowdate;
                    $data['money'] = $ePoints;
                    $data['money_two'] = $ePoints;
                    $data['is_pay'] = 1;
                    $data['user_name'] = $vo['user_name'];
                    $data['bank'] = $vo['bank'];
                    $data['bankcard_number'] = $vo['bankcard_number'];
                    $tiqu->add($data);
                }
            }
            unset($member, $where, $tiqu, $field, $member_rs, $data, $tiqu_where, $eB, $nowdate);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '奖金提现！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误!');
            exit();
        }
    }
    public function financeDaoChu_ChuN()
    {
        // 导出excel
        set_time_limit(0);
        
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Cashier.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        
        $m_page = (int) $_GET['p'];
        if (empty($m_page)) {
            $m_page = 1;
        }
        
        $times = M('times');
        $Numso = array();
        $Numss = array();
        $map = 'is_count=0';
        // 查询字段
        $field = '*';
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $times->where($map)->count(); // 总页数
        $listrows = C('PAGE_LISTROWS'); // 每页显示的记录数
        $s_p = $listrows * ($m_page - 1) + 1;
        $e_p = $listrows * ($m_page);
        
        $title = "当期出纳 第" . $s_p . "-" . $e_p . "条 导出时间:" . date("Y-m-d   H:i:s");
        
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        // 输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="6"   align="center">' . $title . '</td></tr>';
        // 输出字段名
        echo '<tr  align=center>';
        echo "<td>期数</td>";
        echo "<td>结算时间</td>";
        echo "<td>当期收入</td>";
        echo "<td>当期支出</td>";
        echo "<td>当期盈利</td>";
        echo "<td>拨出比例</td>";
        echo '</tr>';
        // 输出内容
        
        $rs = $times->where($map)
            ->order(' id desc')
            ->find();
        $Numso['0'] = 0;
        $Numso['1'] = 0;
        $Numso['2'] = 0;
        if ($rs) {
            $eDate = strtotime(date('c')); // time()
            $sDate = $rs['benqi']; // 时间
            
            $this->MiHouTaoBenQi($eDate, $sDate, $Numso, 0);
        }
        
        $page_where = ''; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $list = $times->where($map)
            ->field($field)
            ->order('id desc')
            ->page($Page->getPage() . ',' . $listrows)
            ->select();
        
        // dump($list);exit;
        
        $occ = 1;
        $Numso['1'] = $Numso['1'] + $Numso['0'];
        $Numso['3'] = $Numso['3'] + $Numso['0'];
        $maxnn = 0;
        foreach ($list as $Roo) {
            
            $eDate = $Roo['benqi']; // 本期时间
            $sDate = $Roo['shangqi']; // 上期时间
            $Numsd = array();
            $Numsd[$occ][0] = $eDate;
            $Numsd[$occ][1] = $sDate;
            
            $this->MiHouTaoBenQi($eDate, $sDate, $Numss, 1);
            // $Numoo = $Numss['0']; //当期收入
            $Numss[$occ]['0'] = $Numss['0'];
            $Dopp = M('bonus');
            $field = '*';
            $where = " s_date>= '" . $sDate . "' And e_date<= '" . $eDate . "' ";
            $rsc = $Dopp->where($where)
                ->field($field)
                ->select();
            $Numss[$occ]['1'] = 0;
            $nnn = 0;
            foreach ($rsc as $Roc) {
                $nnn ++;
                $Numss[$occ]['1'] += $Roc['b0']; // 当期支出
                $Numb2[$occ]['1'] += $Roc['b1'];
                $Numb3[$occ]['1'] += $Roc['b2'];
                $Numb4[$occ]['1'] += $Roc['b3'];
                // $Numoo += $Roc['b9'];//当期收入
            }
            $maxnn += $nnn;
            $Numoo = $Numss['0']; // 当期收入
            $Numss[$occ]['2'] = $Numoo - $Numss[$occ]['1']; // 本期赢利
            $Numss[$occ]['3'] = substr(floor(($Numss[$occ]['1'] / $Numoo) * 100), 0, 3); // 本期拔比
            $Numso['1'] += $Numoo; // 收入合计
            $Numso['2'] += $Numss[$occ]['1']; // 支出合计
            $Numso['3'] += $Numss[$occ]['2']; // 赢利合计
            $Numso['4'] = substr(floor(($Numso['2'] / $Numso['1']) * 100), 0, 3); // 总拔比
            $Numss[$occ]['4'] = substr(($Numb2[$occ]['1'] / $Numoo) * 100, 0, 4); // 小区奖金拔比
            $Numss[$occ]['5'] = substr(($Numb3[$occ]['1'] / $Numoo) * 100, 0, 4); // 互助基金拔比
            $Numss[$occ]['6'] = substr(($Numb4[$occ]['1'] / $Numoo) * 100, 0, 4); // 管理基金拔比
            $Numss[$occ]['7'] = $Numb2[$occ]['1']; // 小区奖金
            $Numss[$occ]['8'] = $Numb3[$occ]['1']; // 互助基金
            $Numss[$occ]['9'] = $Numb4[$occ]['1']; // 管理基金
            $Numso['5'] += $Numb2[$occ]['1']; // 小区奖金合计
            $Numso['6'] += $Numb3[$occ]['1']; // 互助基金合计
            $Numso['7'] += $Numb4[$occ]['1']; // 管理基金合计
            $Numso['8'] = substr(($Numso['5'] / $Numso['1']) * 100, 0, 4); // 小区奖金总拔比
            $Numso['9'] = substr(($Numso['6'] / $Numso['1']) * 100, 0, 4); // 互助基金总拔比
            $Numso['10'] = substr(($Numso['7'] / $Numso['1']) * 100, 0, 4); // 管理基金总拔比
            $occ ++;
        }
        
        $i = 0;
        foreach ($list as $row) {
            $i ++;
            echo '<tr align=center>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . date("Y-m-d H:i:s", $row['benqi']) . '</td>';
            echo '<td>' . $Numss[$i][0] . '</td>';
            echo '<td>' . $Numss[$i][1] . '</td>';
            echo '<td>' . $Numss[$i][2] . '</td>';
            echo '<td>' . $Numss[$i][3] . ' % </td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    public function financeDaoChu_JJCX()
    {
        // 导出excel
        set_time_limit(0);
        
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Bonus-query.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        
        $m_page = (int) $_REQUEST['p'];
        if (empty($m_page)) {
            $m_page = 1;
        }
        $fee = M('fee'); // 参数表
        $times = M('times');
        $bonus = M('bonus'); // 奖金表
        $fee_rs = $fee->field('s18')->find();
        $fee_s7 = explode('|', $fee_rs['s18']);
        
        $where = array();
        $sql = '';
        if (isset($_REQUEST['FanNowDate'])) { // 日期查询
            if (! empty($_REQUEST['FanNowDate'])) {
                $time1 = strtotime($_REQUEST['FanNowDate']); // 这天 00:00:00
                $time2 = strtotime($_REQUEST['FanNowDate']) + 3600 * 24 - 1; // 这天 23:59:59
                $sql = "where e_date >= $time1 and e_date <= $time2";
            }
        }
        
        $field = '*';
        import("@.ORG.ZQPage"); // 导入分页类
        $count = count($bonus->query("select id from __TABLE__ " . $sql . " group by did")); // 总记录数
        $listrows = C('PAGE_LISTROWS'); // 每页显示的记录数
        $page_where = 'FanNowDate=' . $_REQUEST['FanNowDate']; // 分页条件
        if (! empty($page_where)) {
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        } else {
            $Page = new ZQPage($count, $listrows, 1, 0, 3);
        }
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $status_rs = ($Page->getPage() - 1) * $listrows;
        $list = $bonus->query("select e_date,did,sum(b0) as b0,sum(b1) as b1,sum(b2) as b2,sum(b3) as b3,sum(b4) as b4,sum(b5) as b5,sum(b6) as b6,sum(b7) as b7,sum(b8) as b8,max(type) as type from __TABLE__ " . $sql . " group by did  order by did desc limit " . $status_rs . "," . $listrows);
        // =================================================
        
        $s_p = $listrows * ($m_page - 1) + 1;
        $e_p = $listrows * ($m_page);
        
        $title = "奖金查询 第" . $s_p . "-" . $e_p . "条 导出时间:" . date("Y-m-d   H:i:s");
        
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        // 输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">' . $title . '</td></tr>';
        // 输出字段名
        echo '<tr  align=center>';
        echo "<td>结算时间</td>";
        echo "<td>" . $fee_s7[0] . "</td>";
        echo "<td>" . $fee_s7[1] . "</td>";
        echo "<td>" . $fee_s7[2] . "</td>";
        echo "<td>" . $fee_s7[3] . "</td>";
        echo "<td>" . $fee_s7[4] . "</td>";
        echo "<td>" . $fee_s7[5] . "</td>";
        echo "<td>" . $fee_s7[6] . "</td>";
        echo "<td>合计</td>";
        echo "<td>实发</td>";
        echo '</tr>';
        // 输出内容
        
        // dump($list);exit;
        
        $i = 0;
        foreach ($list as $row) {
            $i ++;
            $mmm = $row['b1'] + $row['b2'] + $row['b3'] + $row['b4'] + $row['b5'] + $row['b6'] + $row['b7'];
            echo '<tr align=center>';
            echo '<td>' . date("Y-m-d H:i:s", $row['e_date']) . '</td>';
            echo "<td>" . $row['b1'] . "</td>";
            echo "<td>" . $row['b2'] . "</td>";
            echo "<td>" . $row['b3'] . "</td>";
            echo "<td>" . $row['b4'] . "</td>";
            echo "<td>" . $row['b5'] . "</td>";
            echo "<td>" . $row['b6'] . "</td>";
            echo "<td>" . $row['b7'] . "</td>";
            echo "<td>" . $mmm . "</td>";
            echo "<td>" . $row['b0'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    }
    
    // 会员表
    public function financeDaoChu_MM()
    {
        // 导出excel
        set_time_limit(0);
        
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Member.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        
        $member = M('member'); // 奖金表
        
        $map = array();
        $map['id'] = array(
            'gt',
            0
        );
        $field = '*';
        $list = $member->where($map)->field($field)->order('register_time asc')->select();
        
        $title = "会员表 导出时间:" . date("Y-m-d   H:i:s");
        
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        // 输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">' . $title . '</td></tr>';
        // 输出字段名
        echo '<tr  align=center>';
        echo "<td>序号</td>";
        echo "<td>会员编号</td>";
        echo "<td>姓名</td>";
        echo "<td>银行卡号</td>";
        echo "<td>开户行地址</td>";
        echo "<td>联系电话</td>";
        echo "<td>身份证号</td>";
        echo "<td>注册时间</td>";
        echo "<td>开通时间</td>";
        echo "<td>现金币</td>";
        echo "<td>积分</td>";
        echo "<td>剩余基金</td>";
        echo '</tr>';
        // 输出内容
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
            echo '<tr align=center>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>" . sprintf('%s', (string) chr(28) . $row['bankcard_number'] . chr(28)) . "</td>";
            echo "<td>" . $row['bank_province'] . $row['bank_city'] . $row['bank_address'] . "</td>";
            echo "<td>" . $row['tel'] . "&nbsp;</td>";
            echo "<td>" . sprintf('%s', (string) chr(28) . $row['user_code'] . chr(28)) . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['register_time']) . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['bk7']) . "</td>";
            echo "<td>" . $row['cash'] . "</td>";
            echo "<td>" . $row['point'] . "</td>";
            echo "<td>" . $row['bk8'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    }
    
    // 报单中心表
    public function financeDaoChu_BD()
    {
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
        
        $title = "报单中心表 导出时间:" . date("Y-m-d   H:i:s");
        
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
        echo "<td>报单中心区域</td>";
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
                $nnn = '报单中心';
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

    public function financeDaoChu()
    {
        // 导出excel
        // if ($_SESSION['UrlPTPass'] =='MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
        $title = "数据库名:test,   数据表:test,   备份日期:" . date("Y-m-d   H:i:s");
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=test.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        // 输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">' . $title . '</td></tr>';
        // 输出字段名
        echo '<tr  align=center>';
        echo "<td>银行卡号</td>";
        echo "<td>姓名</td>";
        echo "<td>银行名称</td>";
        echo "<td>省份</td>";
        echo "<td>城市</td>";
        echo "<td>金额</td>";
        echo "<td>所有人的排序</td>";
        echo '</tr>';
        // 输出内容
        $did = (int) $_GET['did'];
        $bonus = M('bonus');
        $map = 'xt_bonus.b0>0 and xt_bonus.did=' . $did;
        // 查询字段
        $field = 'xt_bonus.id,xt_bonus.uid,xt_bonus.did,s_date,e_date,xt_bonus.b0,xt_bonus.b1,xt_bonus.b2,xt_bonus.b3';
        $field .= ',xt_bonus.b4,xt_bonus.b5,xt_bonus.b6,xt_bonus.b7,xt_bonus.b8,xt_bonus.b9,xt_bonus.b10';
        $field .= ',xt_member.user_id,xt_member.user_tel,xt_member.bankcard_number';
        $field .= ',xt_member.user_name,xt_member.user_address,xt_member.nickname,xt_member.user_phone,xt_member.bank_province,xt_member.user_tel';
        $field .= ',xt_member.user_code,xt_member.bank_city,xt_member.bank,xt_member.bank_address';
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $bonus->where($map)->count(); // 总页数
        $listrows = 1000000; // 每页显示的记录数
        $page_where = ''; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $this->assign('page', $show); // 分页变量输出到模板
        $join = 'left join xt_member ON xt_bonus.uid=xt_member.id'; // 连表查询
        $list = $bonus->where($map)
            ->field($field)
            ->join($join)
            ->Distinct(true)
            ->order('id asc')
            ->page($Page->getPage() . ',' . $listrows)
            ->select();
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
            }
            echo '<tr align=center>';
            echo '<td>' . sprintf('%s', (string) chr(28) . $row['bankcard_number'] . chr(28)) . '</td>';
            echo '<td>' . $row['user_name'] . '</td>';
            echo "<td>" . $row['bank'] . "</td>";
            echo '<td>' . $row['bank_province'] . '</td>';
            echo '<td>' . $row['bank_city'] . '</td>';
            echo '<td>' . $row['b0'] . '</td>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        // }else{
        // $this->error('错误!');
        // exit;
        // }
    }

    public function financeDaoChuTwo1()
    {
        // 导出WPS
        if ($_SESSION['UrlPTPass'] == 'MyssGuanPaoYingTao' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao') {
            $title = "数据库名:test,   数据表:test,   备份日期:" . date("Y-m-d   H:i:s");
            header("Content-Type:   application/vnd.ms-excel");
            header("Content-Disposition:   attachment;   filename=test.xls");
            header("Pragma:   no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires:   0");
            echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
            // 输出标题
            echo '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">' . $title . '</td></tr>';
            // 输出字段名
            echo '<tr  align=center>';
            echo "<td>会员编号</td>";
            echo "<td>开会名</td>";
            echo "<td>开户银行</td>";
            echo "<td>银行账户</td>";
            echo "<td>提现金额</td>";
            echo "<td>提现时间</td>";
            echo "<td>所有人的排序</td>";
            echo '</tr>';
            // 输出内容
            $did = (int) $_GET['did'];
            $bonus = M('bonus');
            $map = 'xt_bonus.b0>0 and xt_bonus.did=' . $did;
            // 查询字段
            $field = 'xt_bonus.id,xt_bonus.uid,xt_bonus.did,s_date,e_date,xt_bonus.b0,xt_bonus.b1,xt_bonus.b2,xt_bonus.b3';
            $field .= ',xt_bonus.b4,xt_bonus.b5,xt_bonus.b6,xt_bonus.b7,xt_bonus.b8,xt_bonus.b9,xt_bonus.b10';
            $field .= ',xt_member.user_id,xt_member.user_tel,xt_member.bankcard_number';
            $field .= ',xt_member.user_name,xt_member.user_address,xt_member.nickname,xt_member.user_phone,xt_member.bank_province,xt_member.user_tel';
            $field .= ',xt_member.user_code,xt_member.bank_city,xt_member.bank,xt_member.bank_address';
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $bonus->where($map)->count(); // 总页数
            $listrows = 1000000; // 每页显示的记录数
            $page_where = ''; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $join = 'left join xt_member ON xt_bonus.uid=xt_member.id'; // 连表查询
            $list = $bonus->where($map)
                ->field($field)
                ->join($join)
                ->Distinct(true)
                ->order('id asc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
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
                }
                $date = date('Y-m-d H:i:s', $row['rdt']);
                
                echo '<tr align=center>';
                echo "<td>'" . $row['user_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo "<td>" . $row['bank'] . "</td>";
                echo '<td>' . $row['bankcard_number'] . '</td>';
                echo '<td>' . $row['money'] . '</td>';
                echo '<td>' . $date . '</td>';
                echo "<td>'" . $num . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            $this->error('错误!');
            exit();
        }
    }

    public function financeDaoChuTwo()
    {
        // 导出WPS
        // if ($_SESSION['UrlPTPass'] =='MyssGuanPaoYingTao' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
        $title = "数据库名:test,   数据表:test,   备份日期:" . date("Y-m-d   H:i:s");
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=test.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        // 输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">' . $title . '</td></tr>';
        // 输出字段名
        echo '<tr  align=center>';
        echo "<td>银行卡号</td>";
        echo "<td>姓名</td>";
        echo "<td>银行名称</td>";
        echo "<td>省份</td>";
        echo "<td>城市</td>";
        echo "<td>金额</td>";
        echo "<td>所有人的排序</td>";
        echo '</tr>';
        // 输出内容
        $did = (int) $_GET['did'];
        $bonus = M('bonus');
        $map = 'xt_bonus.b0>0 and xt_bonus.did=' . $did;
        // 查询字段
        $field = 'xt_bonus.id,xt_bonus.uid,xt_bonus.did,s_date,e_date,xt_bonus.b0,xt_bonus.b1,xt_bonus.b2,xt_bonus.b3';
        $field .= ',xt_bonus.b4,xt_bonus.b5,xt_bonus.b6,xt_bonus.b7,xt_bonus.b8,xt_bonus.b9,xt_bonus.b10';
        $field .= ',xt_member.user_id,xt_member.user_tel,xt_member.bankcard_number';
        $field .= ',xt_member.user_name,xt_member.user_address,xt_member.nickname,xt_member.user_phone,xt_member.bank_province,xt_member.user_tel';
        $field .= ',xt_member.user_code,xt_member.bank_city,xt_member.bank,xt_member.bank_address';
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $bonus->where($map)->count(); // 总页数
        $listrows = 1000000; // 每页显示的记录数
        $page_where = ''; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $this->assign('page', $show); // 分页变量输出到模板
        $join = 'left join xt_member ON xt_bonus.uid=xt_member.id'; // 连表查询
        $list = $bonus->where($map)
            ->field($field)
            ->join($join)
            ->Distinct(true)
            ->order('id asc')
            ->page($Page->getPage() . ',' . $listrows)
            ->select();
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
            }
            echo '<tr align=center>';
            echo "<td>'" . sprintf('%s', (string) chr(28) . $row['bankcard_number'] . chr(28)) . '</td>';
            echo '<td>' . $row['user_name'] . '</td>';
            echo "<td>" . $row['bank'] . "</td>";
            echo '<td>' . $row['bank_province'] . '</td>';
            echo '<td>' . $row['bank_city'] . '</td>';
            echo '<td>' . $row['b0'] . '</td>';
            echo "<td>'" . $num . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        // }else{
        // $this->error('错误!');
        // exit;
        // }
    }

    public function financeDaoChuTXT()
    {
        // 导出TXT
        if ($_SESSION['UrlPTPass'] == 'MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao') {
            // 输出内容
            $did = (int) $_GET['did'];
            $bonus = M('bonus');
            $map = 'xt_bonus.b0>0 and xt_bonus.did=' . $did;
            // 查询字段
            $field = 'xt_bonus.id,xt_bonus.uid,xt_bonus.did,s_date,e_date,xt_bonus.b0,xt_bonus.b1,xt_bonus.b2,xt_bonus.b3';
            $field .= ',xt_bonus.b4,xt_bonus.b5,xt_bonus.b6,xt_bonus.b7,xt_bonus.b8,xt_bonus.b9,xt_bonus.b10';
            $field .= ',xt_member.user_id,xt_member.user_tel,xt_member.bankcard_number';
            $field .= ',xt_member.user_name,xt_member.user_address,xt_member.nickname,xt_member.user_phone,xt_member.bank_province,xt_member.user_tel';
            $field .= ',xt_member.user_code,xt_member.bank_city,xt_member.bank,xt_member.bank_address';
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $bonus->where($map)->count(); // 总页数
            $listrows = 1000000; // 每页显示的记录数
            $page_where = ''; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $join = 'left join xt_member ON xt_bonus.uid=xt_member.id'; // 连表查询
            $list = $bonus->where($map)
                ->field($field)
                ->join($join)
                ->Distinct(true)
                ->order('id asc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $i = 0;
            $ko = "";
            $m_ko = 0;
            foreach ($list as $row) {
                $i ++;
                $num = strlen($i);
                if ($num == 1) {
                    $num = '000' . $i;
                } elseif ($num == 2) {
                    $num = '00' . $i;
                } elseif ($num == 3) {
                    $num = '0' . $i;
                }
                $ko .= $row['bankcard_number'] . "|" . $row['user_name'] . "|" . $row['bank'] . "|" . $row['bank_province'] . "|" . $row['bank_city'] . "|" . $row['b0'] . "|" . $num . "\r\n";
                $m_ko += $row['b0'];
                $e_da = $row['e_date'];
            }
            $m_ko = $this->_2Mal($m_ko, 2);
            $content = $num . "|" . $m_ko . "\r\n" . $ko;
            
            header('Content-Type: text/x-delimtext;');
            header("Content-Disposition: attachment; filename=xt_" . date('Y-m-d H:i:s', $e_da) . ".txt");
            header("Pragma: no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires: 0");
            echo $content;
            exit();
        } else {
            $this->error('错误!');
            exit();
        }
    }
    
    // 参数设置
    public function setParameter()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $fee = M('fee');
            $fee_rs = $fee->find();
            $fee_s1 = $fee_rs['s1'];
            $fee_s2 = $fee_rs['s2'];
            $fee_s3 = $fee_rs['s3'];
            $fee_s4 = $fee_rs['s4'];
            $fee_s5 = $fee_rs['s5'];
            $fee_s6 = $fee_rs['s6'];
            $fee_s7 = $fee_rs['s7'];
            $fee_s8 = $fee_rs['s8'];
            $fee_s9 = $fee_rs['s9'];
            $fee_s10 = $fee_rs['s10'];
            $fee_s11 = $fee_rs['s11'];
            $fee_s12 = $fee_rs['s12'];
            $fee_s13 = $fee_rs['s13'];
            $fee_s14 = $fee_rs['s14'];
            $fee_s15 = $fee_rs['s15'];
            $fee_s16 = $fee_rs['s16'];
            $fee_s17 = $fee_rs['s17'];
            $fee_s18 = $fee_rs['s18'];
            $fee_s19 = $fee_rs['s19'];
            $this->assign('fee_s1', $fee_s1);
            $this->assign('fee_s2', $fee_s2);
            $this->assign('fee_s3', $fee_s3);
            $this->assign('fee_s4', $fee_s4);
            $this->assign('fee_s5', $fee_s5);
            $this->assign('fee_s6', $fee_s6);
            $this->assign('fee_s7', $fee_s7);
            $this->assign('fee_s8', $fee_s8);
            $this->assign('fee_s9', $fee_s9);
            $this->assign('fee_s10', $fee_s10);
            $this->assign('fee_s11', $fee_s11);
            $this->assign('fee_s12', $fee_s12);
            $this->assign('fee_s13', $fee_s13);
            $this->assign('fee_s14', $fee_s14);
            $this->assign('fee_s15', $fee_s15);
            $this->assign('fee_s16', $fee_s16);
            $this->assign('fee_s17', $fee_s17);
            $this->assign('fee_s18', $fee_s18);
            $this->assign('fee_s19', $fee_s19);
            
            $this->display('setParameter');
        } else {
            $this->error('错误!');
            exit();
        }
    }

    public function setParameterSave()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $fee = M('fee');
            $member = M('member');
            $rs = $fee->find();
            $s1 = $_POST['s1'];
            $s2 = $_POST['s2'];
            $s3 = $_POST['s3'];
            $s4 = $_POST['s4'];
            $s5 = $_POST['s5'];
            $s6 = $_POST['s6'];
            $s7 = $_POST['s7'];
            $s8 = $_POST['s8'];
            $s9 = $_POST['s9'];
            $s10 = $_POST['s10'];
            $s11 = $_POST['s11'];
            $s12 = $_POST['s12'];
            $s13 = $_POST['s13'];
            $s14 = $_POST['s14'];
            $s15 = $_POST['s15'];
            $s16 = $_POST['s16'];
            $s17 = $_POST['s17'];
            $s18 = $_POST['s18'];
            $s19 = $_POST['s19'];
            $s20 = $_POST['s20'];
            //待存入数据库数据
            $where = array();
            $where['id'] = 1;
            $data = array();
            $data['s1'] = trim($s1);
            $data['s2'] = trim($s2);
            $data['s3'] = trim($s3);
            $data['s4'] = trim($s4);
            $data['s5'] = trim($s5);
            $data['s6'] = trim($s6);
            $data['s7'] = trim($s7);
            $data['s8'] = trim($s8);
            $data['s9'] = trim($s9);
            $data['s10'] = trim($s10);
            $data['s11'] = trim($s11);
            $data['s12'] = trim($s12);
            $data['s13'] = trim($s13);
            $data['s14'] = trim($s14);
            $data['s15'] = trim($s15);
            $data['s16'] = trim($s16);
            $data['s17'] = trim($s17);
            $data['s18'] = trim($s18);
            $data['s19'] = trim($s19);
//             $data['s20'] = trim($s20);
            $fee->where($where)->data($data)->save();
            $this->success('参数设置！');
            exit();
        } else {
            $this->error('错误!');
            exit();
        }
    }
    
    // 参数设置
    public function setParameter_B()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCPB') {
            $fee = M('fee');
            $fee_rs = $fee->find();
            
            $fee_str21 = $fee_rs['str21'];
            $fee_str22 = $fee_rs['str22'];
            $fee_str23 = $fee_rs['str23'];
            
            $this->assign('fee_str21', $fee_str21);
            $this->assign('fee_str22', $fee_str22);
            $this->assign('fee_str23', $fee_str23);
            
            $this->display();
        } else {
            $this->error('错误!');
            exit();
        }
    }
    public function MenberBonus()
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $member = M('member');
            $UserID = trim($_REQUEST['UserID']);
            $ss_type = (int) $_REQUEST['type'];
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
            $map['is_pay'] = 1;
            // 查询字段
            $field = 'id,user_id,nickname,bank,bankcard_number,user_name,user_address,user_tel,rdt,f4,cpzj,pdt,u_level,zjj,agent_use,is_lock,f3,b3';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('pdt desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            
            $this->assign('list', $list); // 数据输出到模板
            $title = '会员管理';
            $this->assign('title', $title);
            $this->display('MenberBonus');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    public function MenberBonusSave()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $member = M('member');
            $fee_rs = M('fee')->find();
            $fee_s7 = explode('|', $fee_rs['s7']);
            
            $date = strtotime($_POST['date']);
            $lz = (int) $_POST['lz'];
            $lzbz = $_POST['lzbz'];
            
            $userautoid = (int) $_POST['userautoid'];
            
            if ($lz <= 0) {
                $this->error('请录入正确的劳资金额!');
                exit();
            }
            
            $rs = $member->field('user_id,id')->find($userautoid);
            if ($rs) {
                $member->query("update __TABLE__ set b3=b3+$lz where id=" . $userautoid);
                $this->input_bonus_2($rs['user_id'], $rs['id'], $fee_s7[2], $lz, $lzbz, $date); // 写进明细
                
                $bUrl = __URL__ . '/MenberBonus';
                $this->_box(1, '劳资录入！', $bUrl, 1);
            } else {
                $this->error('数据错误!');
                exit();
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    public function delTable()
    {
        // 清空数据库
        $this->display();
    }

    public function delTableExe()
    {
        $member = M('member');
        if (! $member->autoCheckToken($_POST)) {
            $this->error('页面过期，请刷新页面！');
            exit();
        }
        unset($member);
        $this->_delTable();
        exit();
    }

    private function _delTableBonus()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssQingKong') {
            // 删除指定记录
            // $name=$this->getActionName();
            $model = M('member');
            $model2 = M('bonus');
            $model3 = M('history');
            $model4 = M('bonushistory');
            $model5 = M('times');
            $model6 = M('cash');
            
            $sql = "`agent_cash`=0,`zjj`=0";
            $model->execute("UPDATE __TABLE__ SET " . $sql);
            $model6->execute("UPDATE __TABLE__ SET x1=0");
            
            $model2->where('id > 0')->delete();
            $model3->where('id > 0')->delete();
            $model4->where('id > 0')->delete();
            $model5->where('id > 0')->delete();
            
            $bUrl = __URL__ . '/delTable';
            $this->_box(1, '部分清空数据完成！', $bUrl, 1);
            exit();
        } else {
            $bUrl = __URL__ . '/delTable';
            $this->_box(0, '清空数据失败！', $bUrl, 1);
            exit();
        }
    }

    private function _delTable()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssQingKong') {
            // 删除指定记录
            // $name=$this->getActionName();
            $model = M('member');
            $model2 = M('bonus');
            $model41 = M('bonus1');
            $model3 = M('history');
            $model4 = M('msg');
            $model5 = M('times');
            $model40 = M('times1');
            $model6 = M('tiqu');
            $model7 = M('zhuanj');
            $model8 = M('shop');
            $model9 = M('jiadan');
            $model10 = M('chongzhi');
            
            $model12 = M('orders');
            $model13 = M('huikui');
            // $model14 = M ('product');
            $model15 = M('gouwu');
            $model16 = M('xiaof');
            $model17 = M('promo');
            $model18 = M('fenhong');
            $model19 = M('peng');
            $model20 = M('ulevel');
            $model21 = M('address');
            $model22 = M('shouru');
            $model23 = M('remit');
            $model24 = M('cash');
            $model25 = M('xfhistory');
            $model26 = M('game');
            $model27 = M('gupiao');
            $model28 = M('hgupiao');
            $model29 = M('gp_sell');
            
            $model30 = M('gp');
            $model31 = M('blist');
            $model32 = M('cashhistory');
            $model33 = M('bonushistory');
            $model34 = M('cashpp');
            
            $model->where('id > 1')->delete();
            $model2->where('id > 0')->delete();
            $model3->where('id > 0')->delete();
            $model4->where('id > 0')->delete();
            $model5->where('id > 0')->delete();
            $model6->where('id > 0')->delete();
            $model7->where('id > 0')->delete();
            $model8->where('id > 0')->delete();
            $model9->where('id > 0')->delete();
            $model10->where('id > 0')->delete();
            
            $model12->where('id > 0')->delete();
            $model13->where('id > 0')->delete();
            // $model14->where('id > 0')->delete();
            $model15->where('ID > 0')->delete();
            $model16->where('ID > 0')->delete();
            $model17->where('ID > 0')->delete();
            $model18->where('id > 0')->delete();
            $model19->where('id > 0')->delete();
            $model20->where('id > 0')->delete();
            $model21->where('id > 1')->delete();
            $model22->where('id > 0')->delete();
            $model23->where('id > 0')->delete();
            $model24->where('id > 0')->delete();
            $model25->where('id > 0')->delete();
            $model26->where('id > 0')->delete();
            $model27->where('id > 0')->delete();
            $model28->where('id > 0')->delete();
            $model29->where('id > 0')->delete();
            $model31->where('id > 0')->delete();
            $model32->where('id > 0')->delete();
            $model33->where('id > 0')->delete();
            $model34->where('id > 0')->delete();
            $model40->where('id > 0')->delete();
            $model41->where('id > 0')->delete();
            
            $nowdate = time();
            // 数据清0
            
            $nowday = strtotime(date('Y-m-d'));
            // $nowday=strtotime(date('Y-m-d H:i:s')); //测试 使用
            $have_gp = 100000;
            $fh_gp = 10000;
            $fx_numb = $fh_gp / 10;
            $open_pri = 1;
            
            $model30->execute("UPDATE __TABLE__ SET opening=" . $open_pri . ",buy_num=0,sell_num=0,turnover=0,yt_sellnum=0,gp_quantity=0");
            
            $sql .= "`l`=0,`r`=0,`shangqi_l`=0,`shangqi_r`=0,`idt`=0,";
            $sql .= "`benqi_l`=0,`benqi_r`=0,`lr`=0,`shangqi_lr`=0,`benqi_lr`=0,";
            $sql .= "`agent_max`=0,`lssq`=0,`agent_use`=0,`is_agent`=2,`agent_cash`=0,";
            $sql .= "`u_level`=1,`zjj`=0,`wlf`=0,`zsq`=0,`re_money`=0,";
            $sql .= "`cz_epoint`=0,b0=0,b1=0,b2=0,b3=0,b4=0,";
            $sql .= "`b5`=0,b6=0,b7=0,b8=0,b9=0,b10=0,b11=0,b12=0,re_nums=0,man_ceng=0,";
            $sql .= "re_peat_money=0,cpzj=0,duipeng=0,_times=0,fanli=0,fanli_time=$nowday,fanli_num=0,day_feng=0,get_date=$nowday,get_numb=0,";
            $sql .= "get_level=0,is_xf=0,xf_money=0,is_zy=0,zyi_date=0,zyq_date=0,down_num=0,agent_xf=0,agent_kt=0,agent_gp=0,gp_num=0,xy_money=0,";
            $sql .= "peng_num=0,re_f4=0,agent_cf=0,is_aa=0,is_bb=0,is_cc=0,is_fh=0,ach=0,tz_nums=0,shangqi_use=0,shangqi_tz=0,gdt=0,re_pathb=0,kt_id=0,pg_nums=0,fh_nums=0,is_cha=0,tx_num=0,xx_money=0,x_pai=1,is_pp=0,is_p=0,x_out=1,x_num=0,agent_sfw=0,agent_sf=1000,agent_sfo=2000,fanli_money=0,wlf_money=0,";
            $sql .= "re_nums_b=0,vip4=0,vip5=0,vip6=0,zdt=0,shang_l=0,shang_r=0,shang_nums=0,shang_ach=0,z_date=0,c_date=0,jia_nums=0,re_nums_l=0,re_nums_r=0,";
            $sql .= "buy_gupiao=0,ls=0,rs=0,l_nums=0,r_nums=0,email=456,p_nums=0,sh_level=1,agent_zc=0,in_gupiao=0,out_gupiao=0,flat_gupiao=0,give_gupiao=0";
            
            $model->execute("UPDATE __TABLE__ SET " . $sql);
            
            for ($i = 1; $i <= 2; $i ++) { // member1 ~ member5 表 (清空只留800000)
                $member_other = M('member' . $i);
                $member_other->where('id > 1')->delete();
            }
            $nowweek = date("w");
            if ($nowweek == 0) {
                $nowweek = 7;
            }
            $kou_w = $nowweek - 1;
            $weekday = $nowday - $kou_w * 24 * 3600;
            
            // fee表,记载清空操作的时间(时间截)
            $fee = M('fee');
            $fee_rs = $fee->field('id')->find();
            $where = array();
            $data = array();
            $data['id'] = $fee_rs['id'];
            $data['create_time'] = time();
            $data['f_time'] = $weekday;
            $data['us_num'] = 1;
            // $data['a_money'] = 0;
            // $data['b_money'] = 0;
            $data['ff_num'] = 1;
            $data['gp_one'] = $open_pri;
            $data['gp_fxnum'] = $fx_numb;
            $data['gp_senum'] = 0;
            $data['gp_cnum'] = 0;
            $rs = $fee->save($data);
            
            $card = M('card');
            $card->query("update __TABLE__ set is_sell=0,bid=0,buser_id='',b_time=0");
            
            $bUrl = __URL__ . '/delTable';
            $this->_box(1, '清空数据！', $bUrl, 1);
            exit();
        } else {
            $bUrl = __URL__ . '/delTable';
            $this->_box(0, '清空数据！', $bUrl, 1);
            exit();
        }
    }

    public function menber()
    {
        // 列表过滤器，生成查询Map对象
        $member = M('member');
        $map = array();
        $id = $PT_id;
        $map['re_id'] = (int) $_GET['PT_id'];
        $UserID = $_POST['UserID'];
        if (! empty($UserID)) {
            $map['user_id'] = array( 'like',"%" . $UserID . "%");
        }
        // 查询字段
        $field = 'id,user_id,nickname,bank,bankcard_number,user_name,user_address,user_tel,rdt,f4,cpzj,is_pay';
        // =====================分页开始==============================================
        import("@.ORG.ZQPage"); // 导入分页类
        $count = $member->where($map)->count(); // 总页数
        $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
        $page_where = 'UserID=' . $UserID; // 分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        // ===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show(); // 分页变量
        $this->assign('page', $show); // 分页变量输出到模板
        $list = $member->where($map)->field($field) ->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
        $this->assign('list', $list); // 数据输出到模板
        $where = array();
        $where['id'] = $id;
        $member_rs = $member->where($where)->field('agent_cash') ->find();
        $this->assign('frs', $member_rs); // 注册币
        $this->display('menber');
        exit();
    }
    public function adminmoneyflows()
    {
        // 货币流向
        if ($_SESSION['UrlPTPass'] == 'MyssMoneyFlows') {
            $member = M('member');
            $history = M('history');
            $sDate = $_REQUEST['S_Date'];
            $eDate = $_REQUEST['E_Date'];
            $UserID = $_REQUEST['UserID'];
            
            $ss_type = (int) $_REQUEST['tp'];
            $map['_string'] = "1=1";
            $s_Date = 0;
            $e_Date = 0;
            if (! empty($sDate)) {
                $s_Date = strtotime($sDate);
            } else {
                $sDate = "2000-01-01";
            }
            if (! empty($eDate)) {
                $e_Date = strtotime($eDate);
            } else {
                $eDate = date("Y-m-d");
            }
            if ($s_Date > $e_Date && $e_Date > 0) {
                $temp_d = $s_Date;
                $s_Date = $e_Date;
                $e_Date = $temp_d;
            }
            if ($s_Date > 0) {
                $map['_string'] .= " and pdt>=" . $s_Date;
            }
            if ($e_Date > 0) {
                $e_Date = $e_Date + 3600 * 24 - 1;
                $map['_string'] .= " and pdt<=" . $e_Date;
            }
            if ($ss_type > 0) {
                if ($ss_type == 15) {
                    $map['action_type'] = array('lt',7);
                } else if ($ss_type > 15) {
                    $map['action_type'] = $ss_type;
                } else {
                    $map['action_type'] = array('eq',$ss_type);
                }
            }
            if (! empty($UserID)) {
                import("@.ORG.KuoZhan"); // 导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                
                unset($KuoZhan);
                $where = array();
                $where['user_id'] = array('eq',$UserID);
                $usrs = $member->where($where)
                    ->field('id,user_id')
                    ->find();
                if ($usrs) {
                    $usid = $usrs['id'];
                    $usuid = $usrs['user_id'];
                    $map['_string'] .= " and (uid=" . $usid . " or user_id='" . $usuid . "')";
                } else {
                    $map['_string'] .= " and id=0";
                }
                unset($where, $usrs);
                $UserID = urlencode($UserID);
            }
            $this->assign('S_Date', $sDate);
            $this->assign('E_Date', $eDate);
            $this->assign('ry', $ss_type);
            $this->assign('UserID', $UserID);
            // 查询字段
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $history->where($map)->count(); // 总页数
            $listrows = 20; // 每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&S_Date=' . $sDate . '&E_Date=' . $eDate . '&tp=' . $ss_type; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $history->where($map)
                ->field($field)
                ->order('pdt desc,id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            
            $this->assign('list', $list); // 数据输出到模板
                                         // =================================================
                                         // dump($history);
            
            $fee = M('fee'); // 参数表
            $fee_rs = $fee->field('s18')->find();
            $fee_s7 = explode('|', $fee_rs['s18']);
            $this->assign('fee_s7', $fee_s7); // 输出奖项名称数组
            
            $this->display();
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    // 会员升级
    public function adminUserUp($GPid = 0)
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            $ulevel = M('ulevel');
            $UserID = $_POST['UserID'];
            if (! empty($UserID)) {
                $map['user_id'] = array(
                    'like',
                    "%" . $UserID . "%"
                );
            }
            
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $ulevel->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $page_where = 'UserID=' . $UserID; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $ulevel->where($map)
                ->field($field)
                ->order('id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            
            $this->assign('list', $list); // 数据输出到模板
            $title = '会员升级管理';
            $this->display('adminuserUp');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    public function adminUserUpAC($GPid = 0)
    {
        // 列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            // 处理提交按钮
            $action = $_POST['action'];
            // 获取复选框的值
            $PTid = $_POST['tabledb'];
            if (! isset($PTid) || empty($PTid)) {
                $bUrl = __URL__ . '/adminUserUp';
                $this->_box(0, '请选择会员！', $bUrl, 1);
                exit();
            }
            switch ($action) {
                case '确认升级':
                    $this->_adminUserUpOK($PTid);
                    break;
                case '删除':
                    $this->_adminUserUpDel($PTid);
                    break;
                default:
                    $bUrl = __URL__ . '/adminUserUp';
                    $this->_box(0, '没有该会员！', $bUrl, 1);
                    break;
            }
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    private function _adminUserUpOK($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            $member = D('member');
            $ulevel = M('ulevel');
            $where = array();
            $where['id'] = array(
                'in',
                $PTid
            );
            $where['is_pay'] = 0;
            $field = '*';
            $vo = $ulevel->where($where)
                ->field($field)
                ->select();
            $member_where = array();
            $nowdate = strtotime(date('c'));
            foreach ($vo as $voo) {
                $ulevel->query("UPDATE `xt_ulevel` SET `pdt`=$nowdate,`is_pay`=1 where `id`=" . $voo['id']);
                $money = 0;
                $money = $voo['money']; // 金额
                $member->query("update `xt_member` set `cpzj`=cpzj+" . $money . ",u_level=" . $voo['up_level'] . "  where `id`=" . $voo['uid']);
            }
            unset($member, $where, $field, $vo);
            $bUrl = __URL__ . '/adminUserUp';
            $this->_box(1, '升级会员成功！', $bUrl, 1);
            exit();
        } else {
            $this->error('错误！');
            exit();
        }
    }
    private function _adminUserUpDel($PTid = 0)
    {
        // 删除会员
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            $member = M('member');
            $ispay = M('ispay');
            $ulevle = M('ulevel');
            $where['id'] = array('in',$PTid);
            $where['is_pay'] = array( 'eq', 0 );
            $rss1 = $ulevle->where($where)->delete();
            if ($rss1) {
                $bUrl = __URL__ . '/adminUserUp';
                $this->_box(1, '删除升级申请成功！', $bUrl, 1);
                exit();
            } else {
                $bUrl = __URL__ . '/adminUserUp';
                $this->_box(0, '删除升级申请失败！', $bUrl, 1);
                exit();
            }
        } else {
            $this->error('错误!');
        }
    }

    public function adminMenberJL()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssadminMenberJL') {
            $member = M('member');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['type'];
            
            $map = array();
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
            $uulv = (int) $_REQUEST['ulevel'];
            if (! empty($uulv)) {
                $map['u_level'] = array(
                    'eq',
                    $uulv
                );
            }
            $map['is_pay'] = array(
                'egt',
                1
            );
            $map['u_level'] = array(
                'egt',
                4
            );
            // 查询字段
            $field = '*';
            // =====================分页开始==============================================
            import("@.ORG.ZQPage"); // 导入分页类
            $count = $member->where($map)->count(); // 总页数
            $listrows = C('ONE_PAGE_RE'); // 每页显示的记录数
            $listrows = 20; // 每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&ulevel=' . $uulv; // 分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            // ===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show(); // 分页变量
            $this->assign('page', $show); // 分页变量输出到模板
            $list = $member->where($map)
                ->field($field)
                ->order('pdt desc,id desc')
                ->page($Page->getPage() . ',' . $listrows)
                ->select();
            $this->assign('list', $list); // 数据输出到模板
            $title = '会员管理';
            $this->assign('title', $title);
            $this->display('adminMenberJL');
            return;
        } else {
            $this->error('数据错误!');
            exit();
        }
    }
    public function upload_fengcai_aa()
    {
        if (! empty($_FILES)) {
            // 如果有文件上传 上传附件
            $this->_upload_fengcai_aa();
        }
    }

    protected function _upload_fengcai_aa()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数
        
        // 载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        
        // 设置上传文件大小
        $upload->maxSize = 1048576 * 20; // TODO 50M 3M 3292200 1M 1048576
        // 设置上传文件类型
        $upload->allowExts = explode(',', 'flv');
        // 设置附件上传目录
        $upload->savePath = './Public/Uploads/media/';
        // 设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;
        // 设置需要生成缩略图的文件前缀
        $upload->thumbPrefix = 'm_'; // 生产2张缩略图
        // 设置缩略图最大宽度
        $upload->thumbMaxWidth = '800';
        // 设置缩略图最大高度
        $upload->thumbMaxHeight = '600';
        // 设置上传文件规则
        $upload->saveRule = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(1, 100);
        // 删除原图
        $upload->thumbRemoveOrigin = true;
        if (! $upload->upload()) {
            // 捕获上传异常
            $error_p = $upload->getErrorMsg();
            echo "<script>alert('" . $error_p . "');history.back();</script>";
        } else {
            // 取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path = $uploadList[0]['savepath'];
            $U_nname = $uploadList[0]['savename'];
            $U_inpath = (str_replace('./Public/', '__PUBLIC__/', $U_path)) . $U_nname;
            
            echo "<script>window.parent.myform.str21.value='" . $U_inpath . "';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit();
        }
    }
    public function upload_fengcai_bb()
    {
        if (! empty($_FILES)) {
            // 如果有文件上传 上传附件
            $this->_upload_fengcai_bb();
        }
    }
    protected function _upload_fengcai_bb()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数
        
        // 载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        // 设置上传文件大小
        $upload->maxSize = 1048576 * 2; // TODO 50M 3M 3292200 1M 1048576
        // 设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        // 设置附件上传目录
        $upload->savePath = './Public/Uploads/';
        // 设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;
        // 设置需要生成缩略图的文件前缀
        $upload->thumbPrefix = 'm_'; // 生产2张缩略图
        // 设置缩略图最大宽度
        $upload->thumbMaxWidth = '800';
        // 设置缩略图最大高度
        $upload->thumbMaxHeight = '600';
        // 设置上传文件规则
        $upload->saveRule = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(1, 100);
        // 删除原图
        $upload->thumbRemoveOrigin = true;
        if (! $upload->upload()) {
            // 捕获上传异常
            $error_p = $upload->getErrorMsg();
            echo "<script>alert('" . $error_p . "');history.back();</script>";
        } else {
            // 取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path = $uploadList[0]['savepath'];
            $U_nname = $uploadList[0]['savename'];
            $U_inpath = (str_replace('./Public/', '__PUBLIC__/', $U_path)) . $U_nname;
            
            echo "<script>window.parent.myform.str22.value='" . $U_inpath . "';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit();
        }
    }
    public function upload_fengcai_cc()
    {
        if (! empty($_FILES)) {
            // 如果有文件上传 上传附件
            $this->_upload_fengcai_cc();
        }
    }

    protected function _upload_fengcai_cc()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数
        // 载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        // 设置上传文件大小
        $upload->maxSize = 1048576 * 2; // TODO 50M 3M 3292200 1M 1048576
        // 设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        // 设置附件上传目录
        $upload->savePath = './Public/Uploads/';
        // 设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;
        // 设置需要生成缩略图的文件前缀
        $upload->thumbPrefix = 'm_'; // 生产2张缩略图
        // 设置缩略图最大宽度
        $upload->thumbMaxWidth = '800';
        // 设置缩略图最大高度
        $upload->thumbMaxHeight = '600';
        // 设置上传文件规则
        $upload->saveRule = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(1, 100);
        // 删除原图
        $upload->thumbRemoveOrigin = true;
        if (! $upload->upload()) {
            // 捕获上传异常
            $error_p = $upload->getErrorMsg();
            echo "<script>alert('" . $error_p . "');history.back();</script>";
        } else {
            // 取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path = $uploadList[0]['savepath'];
            $U_nname = $uploadList[0]['savename'];
            $U_inpath = (str_replace('./Public/', '__PUBLIC__/', $U_path)) . $U_nname;
            echo "<script>window.parent.myform.str23.value='" . $U_inpath . "';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit();
        }
    }
}
?>