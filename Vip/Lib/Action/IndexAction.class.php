<?php

class IndexAction extends CommonAction
{
    // 框架首页
    public function index()
    {
        ob_clean();
        $this->_checkUser();
        $this->_Config_name(); // 调用参数
        $fck = M('member');
        $map = array();
        $map['id'] = $_SESSION[C('USER_AUTH_KEY')];
        $field = 'id,user_id,user_name,password,password2,register_time,last_login_time,is_agent,cash,point,bk8,us_img,grade,is_agent';
        $authInfo = $fck->where($map)
            ->field($field)
            ->find();
        // 使用用户名、密码和状态的方式进行认证
        if (false == $authInfo) {
            $this->error('帐号不存在或已禁用！');
        } else {
            $news = M('news');
            $news_result = $news->where('status = 0')
                ->field('title')
                ->select();
            $_SESSION['news'] = $news_result; // 新闻信息
            $_SESSION[C('USER_AUTH_KEY')] = $authInfo['id'];
            $_SESSION['loginUseracc'] = $authInfo['user_id']; // 用户名
            $_SESSION['loginUserName'] = $authInfo['user_name']; // 用户姓名
            $_SESSION['register_time'] = $authInfo['register_time']; // 注册时间
            $_SESSION['lastLoginTime'] = $authInfo['last_login_time']; // 最近登录时间
            $_SESSION['login_isAgent'] = $authInfo['is_agent']; // 是否服务中心
            $_SESSION['cash'] = $authInfo['cash']; // 现金币
            $_SESSION['point'] = $authInfo['point']; // 积分币
            $_SESSION['bk8'] = $authInfo['bk8']; // 基金
            if (empty($authInfo['us_img'])) {
                $_SESSION['us_img'] = "__PUBLIC__/Images/mctxico.jpg";
            } else {
                $_SESSION['us_img'] = $authInfo['us_img']; // 用户头像
            }
            $_SESSION['UserMktimes'] = mktime();
            $_SESSION['grade'] = $authInfo['grade']; // 级别
            $_SESSION['is_agent'] = $authInfo['is_agent']; // 服务中心
            
            $this->display('index');
        }
    }
}
?>