<?php

class PublicAction extends CommonAction
{

    public function _initialize()
    {
        header("Content-Type:text/html; charset=utf-8");
        $this->_inject_check(1); // 调用过滤函数
        $this->_Config_name(); // 调用参数
    }
    
    // 过滤查询字段
    function _filter(&$map)
    {
        $map['title'] = array( 'like',"%" . $_POST['name'] . "%");
    }
    // 顶部页面
    public function top()
    {
        C('SHOW_RUN_TIME', false); // 运行时间显示
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }
    // 尾部页面
    public function footer()
    {
        C('SHOW_RUN_TIME', false); // 运行时间显示
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }
    // 用户登录页面
    public function login()
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s1')->find();
        $this->assign('s1', $fee_rs['s1']);
        unset($fee, $fee_rs);
        $this->display('login');
    }
    public function index()
    {
        // 如果通过认证跳转到首页
        redirect(__APP__);
    }
    // 用户登出
    public function LogOut()
    {
        $_SESSION = array();
        $this->assign('jumpUrl', __URL__ . '/login/');
        $this->success('退出成功！');
    }
    
    // 登录检测
    public function checkLogin()
    {
        if (empty($_POST['account'])) {
            $this->error('请输入帐号！');
        } elseif (empty($_POST['password'])) {
            $this->error('请输入密码！');
        } elseif (empty($_POST['verify'])) {
            $this->error('请输入验证码！');
        }
        $map = array();
        $map['user_id'] = $_POST['account'];
        if ($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误！');
        }
        import('@.ORG.RBAC');
        $fck = M('member');
        $field = 'id,user_id,user_name,password,password2,register_time,last_login_time,is_agent,cash,point,bk8,us_img,grade,is_agent';
        $authInfo = $fck->where($map)->field($field)->find();
        // 使用用户名、密码和状态的方式进行认证
        if (false == $authInfo) {
            $this->error('帐号不存在或已禁用！');
        } else {
            if ($authInfo['password'] != md5($_POST['password'])) {
                $this->error('密码错误！');
                exit();
        }
        $news = M('news');
        $news_result = $news->where('status = 0')->field('title')->select();
        $_SESSION['news'] = $news_result; // 新闻信息
        $_SESSION[C('USER_AUTH_KEY')] = $authInfo['id'];
        $_SESSION['loginUseracc'] = $authInfo['user_id']; // 用户名
        $_SESSION['loginUserName'] = $authInfo['user_name']; // 用户姓名
        $_SESSION['register_time'] = $authInfo['register_time'];// 注册时间
        $_SESSION['lastLoginTime'] = $authInfo['last_login_time'];// 最近登录时间
        $_SESSION['login_isAgent'] = $authInfo['is_agent']; // 是否服务中心
        $_SESSION['cash'] = $authInfo['cash']; // 现金币
        $_SESSION['point'] = $authInfo['point']; // 积分币
        $_SESSION['bk8'] = $authInfo['bk8']; // 基金
        if(empty($authInfo['us_img'])){
            $_SESSION['us_img'] = "__PUBLIC__/Images/mctxico.jpg";
        } else {
            $_SESSION['us_img'] = $authInfo['us_img']; // 用户头像
        }
        $_SESSION['UserMktimes'] = mktime();
        $_SESSION['grade'] = $authInfo['grade']; // 级别
        $_SESSION['is_agent'] = $authInfo['is_agent']; // 服务中心
        // 身份确认 = 用户名+识别字符+密码
        $_SESSION['login_sf_list_u'] = md5($authInfo['user_id'] . 'wodetp_new_1012!@#' . $authInfo['password'] . $_SERVER['HTTP_USER_AGENT']);
        // 登录状态（多点登录设置）
        $user_type = md5($_SERVER['HTTP_USER_AGENT'] . 'wtp' . rand(0, 999999));
        $_SESSION['login_user_type'] = $user_type;
        $where['id'] = $authInfo['id'];
        $fck->where($where)->setField('last_login_time',mktime()); 
        $fck->execute("update __TABLE__ set last_login_time=" . time() . ",last_login_ip='" . $_SERVER['REMOTE_ADDR'] . "' where id=" . $authInfo['id']);
        // 缓存访问权限
        RBAC::saveAccessList();
        $this->success('登录成功！');
        }
    }
    // 二级密码验证
    public function cody()
    {
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
        $fck = M('cody');
        $list = $fck->where("c_id=$UrlID")->getField('c_id');
        
        if (! empty($list)) {
            $this->assign('vo', $list);
            $this->display('cody');
            exit();
        } else {
            $this->error('二级密码错误!');
            exit();
        }
    }
    // 二级验证后调转页面
    public function codys()
    {
        $Urlsz = $_POST['Urlsz'];
        if (empty($_SESSION['user_pwd2'])) {
            $pass = $_POST['oldpassword'];
            $fck = M('fck');
            if (! $fck->autoCheckToken($_POST)) {
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
            $list = $fck->where($where)
                ->field('id')
                ->find();
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
                $_SESSION['DLTZURL02'] = 'updateUserInfo';
                $bUrl = __URL__ . '/updateUserInfo'; // 修改资料
                $this->_boxx($bUrl);
                break;
            case 2:
                $_SESSION['DLTZURL01'] = 'password';
                $bUrl = __URL__ . '/password'; // 修改密码
                $this->_boxx($bUrl);
                break;
            case 3:
                $_SESSION['DLTZURL01'] = 'pprofile';
                $bUrl = __URL__ . '/pprofile'; // 修改密码
                $this->_boxx($bUrl);
                break;
            case 4:
                $_SESSION['DLTZURL01'] = 'OURNEWS';
                $bUrl = __URL__ . '/News'; // 修改密码
                $this->_boxx($bUrl);
                break;
            default:
                $this->error('二级密码错误!');
                break;
        }
    }

    public function verify()
    {
        ob_clean();
        $type = isset($_GET['type']) ? $_GET['type'] : 'gif';
        import("@.ORG.Image");
        Image::buildImageVerify();
    }
}
?>