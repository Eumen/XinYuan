<?php

class FckModel extends CommonModel
{
    // 数据库名称
    public function xiangJiao($Pid = 0, $DanShu = 1)
    {
        // ========================================== 往上统计单数
        $where = array();
        $where['id'] = $Pid;
        $field = 'treeplace,father_id';
        $vo = $this->where($where)
            ->field($field)
            ->find();
        if ($vo) {
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
            $table = $this->tablePrefix . 'fck';
            if ($TPe == 0 && $Fid > 0) {
                $this->execute("update " . $table . " Set `l`=l+$DanShu, `shangqi_l`=shangqi_l+$DanShu  where `id`=" . $Fid);
            } elseif ($TPe == 1 && $Fid > 0) {
                $this->execute("update " . $table . " Set `r`=r+$DanShu, `shangqi_r`=shangqi_r+$DanShu  where `id`=" . $Fid);
            } elseif ($TPe == 2 && $Fid > 0) {
                $this->execute("update " . $table . " Set `lr`=lr+$DanShu, `shangqi_lr`=shangqi_lr+$DanShu  where `id`=" . $Fid);
            }
            if ($Fid > 0)
                $this->xiangJiao($Fid, $DanShu);
        }
        unset($where, $field, $vo);
    }

    public function addencAdd($ID = 0, $inUserID = 0, $money = 0, $name = null, $UID = 0, $time = 0, $acttime = 0, $bz = "")
    {
        // 添加 到数据表
        if ($UID > 0) {
            $where = array();
            $where['id'] = $UID;
            $frs = $this->where($where)
                ->field('nickname')
                ->find();
            $name_two = $name;
            $name = $frs['nickname'] . ' 开通会员 ' . $inUserID;
            $inUserID = $frs['nickname'];
        } else {
            $name_two = $name;
        }
        
        $data = array();
        $history = M('history');
        
        $data['user_id'] = $inUserID;
        $data['uid'] = $ID;
        $data['action_type'] = $name;
        if ($time > 0) {
            $data['pdt'] = $time;
        } else {
            $data['pdt'] = mktime();
        }
        $data['epoints'] = $money;
        if (! empty($bz)) {
            $data['bz'] = $bz;
        } else {
            $data['bz'] = $name;
        }
        $data['did'] = 0;
        $data['type'] = 1;
        $data['allp'] = 0;
        if ($acttime > 0) {
            $data['act_pdt'] = $acttime;
        }
        $result = $history->add($data);
        unset($data, $history);
    }
    
    /**
     * 添加到分红包数据表
     * @param 用户ID $uid
     * @param 用户名 $user_id
     * @param 分红开始时间 $adt
     * @param 分红截止时间 $pdt
     * @param 已分红金额 $money
     * @param 单数 $danshu
     * @param 是否出局 $is_pay
     * @param 加单类型0：注册，1升级，2复投 $out_level
     */
    public function jiaDan($uid = 0, $user_id = 0, $adt = 0, $pdt = 0, $money = 0, $danshu = 0, $is_pay = 0, $out_level = 0)
    {
        $data = array();
        $jiadan = M('jiadan');
    
        $data['uid'] = $uid;
        $data['user_id'] = $user_id;
        $data['adt'] = $adt;
        $data['pdt'] = $pdt;
        $data['money'] = $money;
        $data['danshu'] = $danshu;
        $data['is_pay'] = $is_pay;
        $data['out_level'] = $out_level;
        
        $result = $jiadan->add($data);
        unset($data, $jiadan);
    }

    public function huikuiAdd($ID = 0, $tz = 0, $zk, $money = 0, $nowdate = null)
    {
        // 添加 到数据表
        $data = array();
        $huikui = M('huikui');
        $data['uid'] = $ID;
        $data['touzi'] = $tz;
        $data['zhuangkuang'] = $zk;
        $data['hk'] = $money;
        $data['time_hk'] = $nowdate;
        $huikui->add($data);
        unset($data, $huikui);
    }
    
    // 对碰1：1
    public function touch1to1(&$Encash, $xL = 0, $xR = 0, &$NumS = 0)
    {
        $xL = floor($xL);
        $xR = floor($xR);
        
        if ($xL > 0 && $xR > 0) {
            if ($xL > $xR) {
                $NumS = $xR;
                $xL = $xL - $NumS;
                $xR = $xR - $NumS;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            if ($xL < $xR) {
                $NumS = $xL;
                $xL = $xL - $NumS;
                $xR = $xR - $NumS;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            if ($xL == $xR) {
                $NumS = $xL;
                $xL = 0;
                $xR = 0;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            $Encash['2'] = $NumS;
        } else {
            $NumS = 0;
            $Encash['0'] = 0;
            $Encash['1'] = 0;
        }
    }
    // 静态分红
    public function fenhong()
    {
        $fee = M('Fee');
        // str1每单分红金额 s5分红倍数
        $fee_rs = $fee->field('str1,s5')->find(1);
        $str1 = $fee_rs['str1'];
        $s5 = $fee_rs['s5'];
        // 检索分红包表数据
        $jiadan = M('Jiadan');
        $data = Array();
        $where = Array();
        
        $field = 'id,is_fenh,u_level,re_nums,user_id,agent_sfw,agent_sf,agent_sfo,day_feng,f4,is_cc,tz_nums';
        $lirs = $this->where('id>0 and is_pay=1 and is_sf=0 and is_fenh=0')
            ->field($field)
            ->order('id desc')
            ->select();
        // $lirs = $this->where('id>0 and is_pay=1 and is_sf=0 and is_fenh=0')->field($field)->order('id desc')->select();
        // print_r($lirs);die;
        ini_set("max_execution_time", 0);
        foreach ($lirs as $k => $v) {
            // 待更新到会员表金钱
            $fck_money = 0;
            $where['is_pay'] = 0;
            $where['user_id'] = $v['user_id'];
            $jiadan_rs = $jiadan->where($where)->field('*')->select();
            foreach ($jiadan_rs as $key => $value) {
                // 更新的条件
                $condition['id'] = $value['id'];
                // 分红包表ID
                $id = $value['id'];
                // 单数
                $jd_danshu = $value['danshu'];
                // 应分红金额
                $jd_money = bcmul($jd_danshu, $str1,2);
                // 已分红金额
                $jd_oldMoney = $value['money'];;
                // 总金额
                $jd_sumMoney = $str1 * $jd_danshu * $s5;
                if ($jd_money >= $jd_sumMoney - $jd_oldMoney) {
                    // 超出部分去掉，按剩余部分分红，设为出局
                    $jd_money = $jd_sumMoney - $jd_oldMoney;
                    $fck_money += $jd_money;
                    $nowdate = strtotime(date('Y-m-d'));
                    // 待更新数据
                    $data['money'] = $jd_oldMoney + $jd_money;
                    $data['is_pay'] = 1;
                    $data['pdt'] = $nowdate;
                    // 更新到分红记录表
                    $jiadan->where($condition)->save($data);
                } else {
                    $fck_money += $jd_money;
                    // 待更新数据
                    $data['money'] = $jd_oldMoney + $jd_money;
                    $data['is_pay'] = 0;
                    $data['pdt'] = 0;
                    // 更新到分红记录表
                    $jiadan->where($condition)->save($data);
                }
            }
            // 会员表ID
            $myid = $v['id'];
            // 会员表用户名
            $inUserID = $v['user_id'];
            if ($fck_money > 0) {
                // 1为静态分红
                $this->rw_bonus($myid, $inUserID, 1, $fck_money);
                $this->execute("update __TABLE__ set is_sf=1,tz_nums=tz_nums+{$fck_money} where id=" . $myid);
            }
        }
    }
    // 计算奖金
    public function getusjj($uid, $type = 0, $money = 0)
    {
        $mrs = $this->where('id=' . $uid)->find();
        if ($mrs) {
            $this->tz($mrs['p_path'], $money);
            $this->tuijj($mrs['re_path'], $mrs['user_id'], $money);
            $this->jiandianjiang($mrs['p_path'], $mrs['user_id']);
            // $this->pingheng($mrs['p_path'],$mrs['user_id'],$mrs['p_level']);
            $this->lingdao22($mrs['p_path'], $mrs['user_id'], $money);
            // $this->grade($mrs['p_path'],$mrs['user_id'],$money);
            $this->sh_level();
            // $this->getLevel();
            
            $this->baodanfei($mrs['shop_id'], $mrs['user_id'], $money, $mrs['is_agent']);
            $this->dsfenhong($mrs['p_path'], $mrs['user_id'], $money);
        }
        unset($mrs);
    }
    /**
     * 投资业绩统计
     * $p_path : 节点路径
     * $money  :金额
     * */
    public function tz($p_path, $money)
    {
        $fck = M('fck');
        $lirs = $this->where('id in (0' . $p_path . '0)')
            ->field('id,is_fenh,u_level,re_nums,user_id')
            ->order('rdt desc')
            ->select();
        foreach ($lirs as $key => $v) {
            // 统计业绩之后加到会员表
            $this->execute("update __TABLE__ set ach=ach+{$money},ach_s=ach_s+{$money} where id=" . $v['id']);
        }
    }
    
    /**
     * 直推奖 间推奖 隔推奖
     * $re_path : 推荐路径
     * $inUserID：当前正在投资的会员
     * $money  :金额
     * */
    public function tuijj($re_path = 0, $inUserID = 0, $money = 0)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s11,s4')->find(1);
        // 直推奖比例参数分割
        $s11 = explode("|", $fee_rs['s11']);
        // 查询所有直推路径下的会员数据
        $lirs = $this->where('id in (0' . $re_path . '0)  and is_fenh=0')
            ->field('id,re_nums,is_fenh')
            ->order('id desc')
            ->select();
        $i = 0;
        // 循环分配奖金
        foreach ($lirs as $lrs) {
            $money_count = 0;
            $myid = $lrs['id'];
            $is_fenh = $lrs['is_fenh'];
            // 按照直推奖比例算出奖金
            $prii = $s11[$i] / 100;
            $money_count = bcmul($prii, $money, 2);
            if ($i == 0) {
                $mm = 2;
            }
            if ($i == 1) {
                $mm = 3;
            }
            if ($i == 2) {
                $mm = 4;
            }
            if ($money_count > 0 && $is_fenh == 0 && $i < 3) {
                // 2为直推奖 3为间推奖 4为隔推奖
                $this->rw_bonus($myid, $inUserID, $mm, $money_count);
            }
            $i ++;
        }
        unset($fee, $fee_rs, $s13, $lirs, $lrs);
    }
    
    /**
     * 见点奖
     * $p_path : 节点路径
     * $inUserID：当前正在投资的会员
     * $money  :金额
     * */
    public function jiandianjiang($p_path, $inUserID)
    {
        $fee = M('fee');
        // str5为见点奖比例 s13为见点奖层数
        $fee_rs = $fee->field('s13,str5')->find(1);
        $s13 = explode("|", $fee_rs['s13']);
        $str5 = $fee_rs['str5'];
        // 检索节点路径数据
        $lirs = $this->where('id in (0' . $p_path . '0)  and is_fenh=0')
            ->field('id,re_nums,is_fenh,re_nums')
            ->order('id desc')
            ->select();
        $i = 0;
        foreach ($lirs as $lrs) {
            $money_count = 0;
            $myid = $lrs['id'];
            $is_fenh = $lrs['is_fenh'];
            $re_nums = $lrs['re_nums'];
            // 推荐0-2人
            if ($re_nums >= 0 && $re_nums <= 2) {
                $k = $s13[0];
            }
            // 推荐3-4人
            if ($re_nums > 2 && $re_nums <= 4) {
                $k = $s13[1];
            }
            // 推荐5人以上
            if ($re_nums > 4) {
                $k = $s13[2];
            }
            // 见点奖比例
            $money_count = $str5;
            if ($k > $i && $is_fenh == 0) {
                // ID 用户名 见点奖标志 金额
                $this->rw_bonus($myid, $inUserID, 5, $money_count);
            }
            $i++;
        }
        unset($fee, $fee_rs, $s13, $lirs, $lrs);
    }

    public function pingheng($p_path, $inUserID, $p_level)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s12,s14')->find(1);
        $s14 = $fee_rs['s14'];
        $s12 = $fee_rs['s12'];
        $lirs = $this->where('id in (0' . $p_path . '0) and is_fenh=0')
            ->field('id,re_nums,is_fenh,re_nums,p_level,is_p')
            ->order('id desc')
            ->select();
        $i = 0;
        foreach ($lirs as $lrs) {
            $money_count = 0;
            $myid = $lrs['id'];
            $is_p = $lrs['is_p'];
            $p_level2 = $lrs['p_level'];
            $is_fenh = $lrs['is_fenh'];
            $num = $p_level - $p_level2;
            $nums = pow(2, $num);
            $p_nums = $nums / 2;
            $count = $this->where('p_level =' . $p_level)->count();
            $money_count = $s12;
            if ($s14 > $i && $is_fenh == 0 && $is_p < $num && $count >= $p_nums) {
                
                $this->rw_bonus($myid, $inUserID, 4, $money_count);
                $this->execute("update __TABLE__ set is_p={$num} where id=" . $myid);
            }
            $i ++;
        }
        unset($fee, $fee_rs, $s13, $lirs, $lrs);
    }
    /**
     * 领导奖
     * $p_path ：节点路径
     * $inUserID：正在投资的会员ID
     * $money:投资的金额
     * **/
    public function lingdao22($p_path, $inUserID, $money)
    {
        $fee = M('fee');
        // 领导奖比例：合伙人，市场总监，市场监理，市场董事
        $fee_rs = $fee->field('s4')->find(1);
        $s4 = explode("|", $fee_rs['s4']);
        // 搜索节点路径下的会员数据
        $lirs = $this->where('id in (0' . $p_path . '0)  and is_fenh=0')
            ->field('id,re_nums,is_fenh,sh_level')
            ->order('id asc')
            ->select();
        // 循环分配奖金
        foreach ($lirs as $lrs) {
            $money_count = 0;
            $myid = $lrs['id'];
            $is_fenh = $lrs['is_fenh'];
            // 合伙人级别
            $sh_level = $lrs['sh_level'];
            $small_level = $this->where('id in (0' . $p_path . '0) and id>' . $myid . '')->max('sh_level');
            if ($small_level >= $sh_level) {
                continue;
            } else {
                $mm = $s4[$sh_level - 1] - $s4[$small_level - 1];
                $prii = $mm / 100;
            }
            // 根据投资金额领导奖比例算出应得金额
            $money_count = bcmul($money, $prii, 2);
            if ($money_count > 0 && $is_fenh == 0) {
                // 6为领导奖
                $this->rw_bonus($myid, $inUserID, 6, $money_count);
            }
        }
        unset($fee, $fee_rs, $s13, $lirs, $lrs);
    }
    // 
    /**
     * 报单奖
     * $uid ：
     * $inUserID：正在投资的会员ID
     * $cpzj:投资的金额
     * **/
    public function baodanfei($uid, $inUserID, $cpzj = 0)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('str9,s7')->find();
        // 报单费比例
        $str9 = $fee_rs['str9'] / 100;
        // 报单推报单比例
        $s7 = $fee_rs['s7'] / 100;
        // 报单奖励金额
        $money_count = bcmul($cpzj, $str9, 2);
        // 检索报单中心数据
        $frs = $this->where('id=' . $uid . ' and is_pay=1 ')
            ->field('id,user_id,re_path,u_level,re_id')
            ->find();
        if ($frs) {
            $myid = $frs['id'];
            if ($money_count > 0) {
                // 7为报单中心
                $this->rw_bonus($myid, $inUserID, 7, $money_count);
            }
            // 报单中心的推荐人ID
            $uid = $frs['re_id'];
            $one = $this->where('id=' . $uid . ' and is_pay=1 ')
                ->field('id,user_id,is_agent')
                ->find();
            // 如果推荐人也为报单中心
            if ($one['is_agent'] == 2) {
                // 报单中心推报单中心的奖励金额
                $money = bcmul($cpzj, $s7, 2);
                if ($money > 0) {
                    $this->rw_bonus($one['id'], $inUserID, 7, $money);
                }
            }
        }
        unset($fee, $fee_rs, $frs, $s14);
    }
    // 董事分红
    public function dsfenhong($p_path, $inUserID, $money)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s6')->find();
        // 董事分红比例
        $s6 = $fee_rs['s6'] / 100;
        // 查询所有级别达到全国董事的会员数据
        $lirs = $this->where('is_fenh=0 and sh_level=5')
            ->field('id,re_nums,is_fenh,sh_level')
            ->order('id desc')
            ->select();
        // 查询级别为全国董事的人员数量
        $count = $this->where('sh_level =5')->count();
        // 算出董事分红的金额
        $money_a = bcmul($money, $s6, 2);
        // 算出全国董事应得的加权平均分红的金额
        $money_count = bcdiv($money_a, $count, 2);
        foreach ($lirs as $lrs) {
            // 对应全国董事的ID
            $myid = $lrs['id'];
            $is_fenh = $lrs['is_fenh'];
            if ($money_count > 0 && $is_fenh == 0) {
                // myid 是全国董事对应的ID,   8为全国董事分红的key，$money_count全国董事应分红的金额
                $this->rw_bonus($myid, $inUserID, 8, $money_count);
            }
        }
        unset($fee, $fee_rs, $s13, $lirs, $lrs);
    }
    
    /**
     * 方法功能：检测是否达到对应领导级别，达到则提升至对应级别
     * **/
    public function sh_level()
    {
        // 取得会员数据
        $list = $this->where('id>0')
            ->field('id,ach,sh_level,p_path')
            ->order('id asc')
            ->select();
        foreach ($list as $key => $value) {
            // id
            $myid = $value['id'];
            // 领导等级
            $sh_level = $value['sh_level'];
            // 节点路径
            $p_path = $value['p_path'];
            // 团队总业绩
            $nowdate = strtotime(date('Y-m-d'));
            $ach = $this->where('p_path like "%,' . $myid . ',%" and is_pay=1 and pdt<' . $nowdate)->sum('cpzj');
            if (empty($ach)) {
                $ach = 0.00;
            }
            // 查询对应父节点的数量 **可能出现问题的点***
            $count = $this->where('father_id =' . $myid)->count();
            if ($count == 2) {
                // 合伙人
                if ($sh_level < 1) {
                    $one11 = $this->where('treeplace=0 and father_id=' . $myid)
                        ->field('id,user_id,ach')
                        ->find();
                    $nowdate = strtotime(date('Y-m-d'));
                    $ach1 = $this->where('p_path like "%,' . $one11['id'] . ',%" and is_pay=1 and pdt<' . $nowdate)->sum('cpzj');
                    if (empty($ach1)) {
                        $ach1 = 0.00;
                    }
                    $one22 = $this->where('treeplace=1 and father_id=' . $myid)
                        ->field('id,user_id,ach')
                        ->find();
                    $ach2 = $one22['ach'];
                    $nowdate = strtotime(date('Y-m-d'));
                    $ach2 = $this->where('p_path like "%,' . $one22['id'] . ',%" and is_pay=1 and pdt<' . $nowdate)->sum('cpzj');
                    if (empty($ach2)) {
                        $ach2 = 0.00;
                    }
                    if ($ach >= 160000) {
                        $this->execute("update __TABLE__ set sh_level=1,sh_one=sh_one+1 where id=" . $myid);
                        
                        $lirs = $this->where('id in (0' . $p_path . '0)')
                            ->field('id')
                            ->order('id desc')
                            ->select();
                        foreach ($lirs as $lrs) {
                            $uid = $lrs['id'];
                            $this->execute("update __TABLE__ set sh_one=sh_one+1 where id=" . $uid);
                        }
                        unset($lirs, $uid, $one11, $one22, $ach2, $ach1);
                    }
                }
                
                // 市场总监
                if ($value['sh_level'] < 2) {
                    $one11 = $this->where('treeplace=0 and father_id=' . $myid)
                        ->field('id,user_id,sh_one')
                        ->find();
                    $sh_one1 = $one11['sh_one'];
                    $one22 = $this->where('treeplace=1 and father_id=' . $myid)
                        ->field('id,user_id,sh_one')
                        ->find();
                    $sh_one2 = $one22['sh_one'];
                    if ($sh_one1 > 0 && $sh_one2 > 0) {
                        $this->execute("update __TABLE__ set sh_level=2,sh_two=sh_two+1 where id=" . $myid);
                        
                        $lirs = $this->where('id in (0' . $p_path . '0)')
                            ->field('id')
                            ->order('id desc')
                            ->select();
                        foreach ($lirs as $lrs) {
                            $uid = $lrs['id'];
                            $this->execute("update __TABLE__ set sh_two=sh_two+1 where id=" . $uid);
                        }
                        unset($lirs, $uid, $one11, $one22);
                    }
                }
                // 市场监理
                if ($value['sh_level'] < 3) {
                    $one11 = $this->where('treeplace=0 and father_id=' . $myid)
                        ->field('id,user_id,sh_two')
                        ->find();
                    $sh_two1 = $one11['sh_two'];
                    $one22 = $this->where('treeplace=1 and father_id=' . $myid)
                        ->field('id,user_id,sh_two')
                        ->find();
                    $sh_two2 = $one22['sh_two'];
                    $shnums = $sh_two1 + $sh_two2;
                    if ($sh_two1 > 0 && $sh_two2 > 0 && $shnums > 2) {
                        $this->execute("update __TABLE__ set sh_level=3,sh_three=sh_three+1 where id=" . $myid);
                        
                        $lirs = $this->where('id in (0' . $p_path . '0)')
                            ->field('id')
                            ->order('id desc')
                            ->select();
                        foreach ($lirs as $lrs) {
                            $uid = $lrs['id'];
                            $this->execute("update __TABLE__ set sh_three=sh_three+1 where id=" . $uid);
                        }
                        unset($lirs, $uid, $one11, $one22);
                    }
                }
                // 市场董事
                if ($value['sh_level'] < 4) {
                    $one11 = $this->where('treeplace=0 and father_id=' . $myid)
                        ->field('id,user_id,sh_three')
                        ->find();
                    $sh_three1 = $one11['sh_three'];
                    $one22 = $this->where('treeplace=1 and father_id=' . $myid)
                        ->field('id,user_id,sh_three')
                        ->find();
                    $sh_three2 = $one22['sh_three'];
                    $shThreeNums = $sh_three1 + $sh_three2;
                    if ($sh_three1 > 1 && $sh_three2 > 1 && $shThreeNums > 2) {
                        $this->execute("update __TABLE__ set sh_level=4,sh_four=sh_four+1 where id=" . $myid);
                        
                        $lirs = $this->where('id in (0' . $p_path . '0)')
                            ->field('id')
                            ->order('id desc')
                            ->select();
                        foreach ($lirs as $lrs) {
                            $uid = $lrs['id'];
                            $this->execute("update __TABLE__ set sh_four=sh_four+1 where id=" . $uid);
                        }
                        unset($lirs, $uid, $one11, $one22);
                    }
                }
                // 全国董事
                if ($value['sh_level'] < 5) {
                    $one11 = $this->where('treeplace=0 and father_id=' . $myid)
                        ->field('id,user_id,sh_four,ach')
                        ->find();
                    $sh_four1 = $one11['sh_four'];
                    $nowdate = strtotime(date('Y-m-d'));
                    $ach1 = $this->where('p_path like "%,' . $one11['id'] . ',%" and is_pay=1 and pdt<' . $nowdate)->sum('cpzj');
                    if (empty($ach1)) {
                        $ach1 = 0.00;
                    }
                    $one22 = $this->where('treeplace=1 and father_id=' . $myid)
                        ->field('id,user_id,sh_four,ach')
                        ->find();
                    $sh_four2 = $one22['sh_four'];
                    $nowdate = strtotime(date('Y-m-d'));
                    $ach2 = $this->where('p_path like "%,' . $one22['id'] . ',%" and is_pay=1 and pdt<' . $nowdate)->sum('cpzj');
                    if (empty($ach2)) {
                        $ach2 = 0.00;
                    }
                    $miannums = min($ach1, $ach2);
                    $shnums22 = $sh_four1 + $sh_four2;
                    if ($sh_four1 > 1 && $sh_four2 > 1 && $shnums22 > 2) {
                        $this->execute("update __TABLE__ set sh_level=5 where id=" . $myid);
                        
                        unset($lirs, $uid, $one11, $one22);
                    }
                }
                // $count11=$this->where('father_id ='.$uuid1.' and is_pay>=1')->count();
                // $count22=$this->where('father_id ='.$uuid2.' and is_pay>=1')->count();
            }
        }
    }
    
    // 统计单数
    public function countnums($ppath)
    {
        $lirs = $this->where('id in (0' . $ppath . '0)')
            ->field('id')
            ->order('p_level desc')
            ->select();
        foreach ($lirs as $lrs) {
            $myid = $lrs['id'];
            $this->execute("update __TABLE__ set p_nums=p_nums+1 where id=" . $myid);
        }
    }
    
    // 出局奖
    public function out()
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s1,s7')->find(1);
        $s1 = $fee_rs['s1'];
        $s7 = $fee_rs['s7'];
        $list = $this->where('is_path=0 and is_fenh=0')
            ->field('id,re_id,user_id,re_path,p_path')
            ->order('id asc')
            ->select();
        foreach ($list as $key => $value) {
            $myid = $value['id'];
            $count = $this->where('father_id =' . $myid . ' and is_pay>=1')->count();
            if ($count == 2) {
                $one11 = $this->where('treeplace=0 and father_id=' . $myid)
                    ->field('id,user_id,p_nums')
                    ->find();
                $uuid1 = $one11['id'];
                $one22 = $this->where('treeplace=1 and father_id=' . $myid)
                    ->field('id,user_id,p_nums')
                    ->find();
                $uuid2 = $one22['id'];
                $count11 = $this->where('father_id =' . $uuid1 . ' and is_pay>=1')->count();
                $count22 = $this->where('father_id =' . $uuid2 . ' and is_pay>=1')->count();
                if ($count11 >= 2 && $count22 >= 2) {
                    $money_count = $s1;
                    if ($money_count > 0) {
                        $this->rw_bonus($value['id'], $value['user_id'], 3, $money_count);
                        $this->outnums($value['p_path']);
                    }
                    $one = $this->where('id=' . $value['re_id'])
                        ->field('id,user_id')
                        ->find();
                    $money = $s7;
                    if ($money > 0) {
                        $this->rw_bonus($one['id'], $value['user_id'], 3, $money);
                    }
                    $this->execute("update __TABLE__ set is_path=1,outnums=outnums+1 where id=" . $value['id']);
                }
            }
        }
    }
    // 统计出局人数
    public function outnums($re_path)
    {
        $lirs = $this->where('id in (0' . $re_path . '0)')
            ->field('id')
            ->order('id desc')
            ->select();
        foreach ($lirs as $lrs) {
            $myid = $lrs['id'];
            $this->execute("update __TABLE__ set outnums=outnums+1 where id=" . $myid);
        }
    }
    
    // 升级
    public function getLevel()
    {
        $list = $this->where('re_nums>4')
            ->field('id,re_id,user_id,sh_level,re_path,re_nums,father_id,p_path')
            ->order('id asc')
            ->select();
        
        foreach ($list as $key => $value) {
            $myid = $value['id'];
            $p_path = $value['p_path'];
            // 一级合伙人
            if ($value['sh_level'] == 0) {
                $count = $this->where('father_id =' . $myid . '  and outnums>0')->count();
                if ($count > 1 && $value['re_nums'] > 4) {
                    $this->execute("update __TABLE__ set sh_level=1,sh_one=sh_one+1 where id=" . $myid);
                    
                    $lirs = $this->where('id in (0' . $p_path . '0)')
                        ->field('id')
                        ->order('id desc')
                        ->select();
                    foreach ($lirs as $lrs) {
                        $uid = $lrs['id'];
                        $this->execute("update __TABLE__ set sh_one=sh_one+1 where id=" . $uid);
                    }
                    unset($lirs, $uid);
                }
            }
            // 二级合伙人
            if ($value['re_nums'] > 4 && $value['sh_level'] < 2) {
                $count = $this->where('father_id =' . $myid . ' and sh_one>4')->count();
                if ($count > 1) {
                    $this->execute("update __TABLE__ set sh_level=2,sh_two=sh_two+1 where id=" . $myid);
                    
                    $lirs = $this->where('id in (0' . $p_path . '0)')
                        ->field('id')
                        ->order('id desc')
                        ->select();
                    foreach ($lirs as $lrs) {
                        $uid = $lrs['id'];
                        $this->execute("update __TABLE__ set sh_two=sh_two+1 where id=" . $uid);
                    }
                    unset($lirs, $uid);
                }
            }
            // 三级合伙人
            if ($value['re_nums'] > 4 && $value['sh_level'] < 3) {
                $count = $this->where('father_id =' . $myid . '  and sh_two>4')->count();
                if ($count > 1) {
                    $this->execute("update __TABLE__ set sh_level=3,sh_three=sh_three+1 where id=" . $myid);
                    $lirs = $this->where('id in (0' . $p_path . '0)')
                        ->field('id')
                        ->order('id desc')
                        ->select();
                    foreach ($lirs as $lrs) {
                        $uid = $lrs['id'];
                        $this->execute("update __TABLE__ set sh_three=sh_three+1 where id=" . $uid);
                    }
                    unset($lirs, $uid);
                }
            }
            // 四级合伙人
            if ($value['re_nums'] > 4 && $value['sh_level'] < 4) {
                $count = $this->where('father_id =' . $myid . '  and sh_three>4')->count();
                if ($count > 1) {
                    $this->execute("update __TABLE__ set sh_level=4,sh_four=sh_four+1 where id=" . $myid);
                    $lirs = $this->where('id in (0' . $p_path . '0)')
                        ->field('id')
                        ->order('id desc')
                        ->select();
                    foreach ($lirs as $lrs) {
                        $uid = $lrs['id'];
                        $this->execute("update __TABLE__ set sh_four=sh_four+1 where id=" . $uid);
                    }
                    unset($lirs, $uid);
                }
            }
            
            // 五级合伙人
            if ($value['re_nums'] > 40 && $value['sh_level'] < 5) {
                $count = $this->where('re_id =' . $myid . '  and sh_four>4')->count();
                if ($count > 1) {
                    $this->execute("update __TABLE__ set sh_level=5 where id=" . $myid);
                }
            }
        }
    }

    public function shangpin()
    {
        $fee = M('Fee');
        $gouwu = M('gouwu');
        $address = M('address');
        $fee_rs = $fee->field('s1,s9')->find(1);
        $s1 = $fee_rs['s1'];
        $s9 = $fee_rs['s9'];
        $list = $this->where('agent_cf>=' . $s1)
            ->field('*')
            ->select();
        foreach ($list as $key => $v) {
            $this->execute("update __TABLE__ set agent_cf=agent_cf-{$s1} where id=" . $v['id']);
            $ars = $address->where('id=' . $v['id'])->find();
            $gwd = array();
            $gwd['uid'] = $v['id'];
            $gwd['user_id'] = $v['user_id'];
            $gwd['lx'] = 1;
            $gwd['ispay'] = 0;
            $gwd['pdt'] = mktime();
            $gwd['us_name'] = $v['user_name'];
            ;
            $gwd['us_address'] = $ars['address'];
            $gwd['us_tel'] = $ars['tel'];
            $gwd['did'] = 赠送;
            $gwd['money'] = $s9;
            $gwd['shu'] = 1;
            $gwd['cprice'] = $s9;
            // $gwd['countid'] = ;
            
            $gouwu->add($gwd);
        }
    }

    public function fenxiao($repath, $user_id)
    {
        $fee = M('Fee');
        
        $fee_rs = $fee->field('s6,s5,s12,s4')->find(1);
        $s6 = $fee_rs['s6'];
        $s5 = $fee_rs['s5'];
        $s12 = $fee_rs['s12'];
        $s4 = $fee_rs['s4'];
        $lirs = $this->where('id in (0' . $repath . '0)')
            ->field('id,is_fenh,u_level,is_fenh,re_nums,user_id')
            ->order('id desc')
            ->select();
        $i = 0;
        
        foreach ($lirs as $k => $v) {
            
            if ($i == 0 && $v['is_fenh'] == 0) {
                $money = $s6;
                $this->rw_bonus($v['id'], $user_id, 1, $money);
            }
            if ($i == 1 && $v['is_fenh'] == 0) {
                $money = $s12;
                $this->rw_bonus($v['id'], $user_id, 2, $money);
            }
            if ($i == 2 && $v['is_fenh'] == 0) {
                $money = $s5;
                $this->rw_bonus($v['id'], $user_id, 3, $money);
            }
            
            if ($i > 2 && $v['is_fenh'] == 0 && $i < 15) {
                $money = $s4;
                
                $this->rw_bonus($v['id'], $user_id, 4, $money);
            }
            
            $i ++;
        }
    }

    public function daili($s_province, $s_city, $s_county, $user_id, $money)
    {
        $fee = M('Fee');
        $fee_rs = $fee->field('s4,s7,s11')->find(1);
        $s4 = $fee_rs['s4']; // 省
        $s7 = $fee_rs['s7']; // 市
        $s11 = $fee_rs['s11'] / 100; // 县
        
        $list = $this->where('u_level>3')
            ->field('id,s_county,s_city,s_province,is_fenh,u_level')
            ->select();
        
        foreach ($list as $key => $value) {
            if ($value['is_fenh'] == 0) {
                $myid = $value['id'];
                
                if ($value['s_county'] == $s_county && $value['u_level'] == 4) {
                    
                    $money_count = bcmul($money, $s11, 2);
                    $this->rw_bonus($myid, $user_id, 7, $money_count);
                }
            }
        }
    }
    
    // 奖金池
    public function jjc($user_id, $sum)
    {
        $fee = M('Fee');
        $fee_rs = $fee->field('str4')->find(1);
        $str4 = explode("|", $fee_rs['str4']);
        
        $fck = M('Fck');
        
        $list = $fck->where('u_level>=9')
            ->field('id,user_id,gdt,u_level')
            ->select();
        
        foreach ($list as $key => $value) {
            
            $uLevel = $value['u_level'];
            
            if ($uLevel == 9) {
                $pice = $str4[0];
            }
            if ($uLevel == 10) {
                $pice = $str4[0] + $str4[1];
            }
            if ($uLevel == 11) {
                $pice = $str4[0] + $str4[1] + $str4[2];
            }
            if ($uLevel == 12) {
                $pice = $str4[0] + $str4[1] + $str4[2] + $str4[3];
            }
            $money = $sum * $pice / 100;
            if ($money) {
                $this->rw_bonus($value['id'], $user_id, 6, $money);
                $this->execute("update __TABLE__ set gdt={$nowdate} where id=" . $value['id']);
            }
        }
    }
    
    // 扶持奖
    public function fuchi($fid)
    {
        $fee = M('fee');
        $fck = M('fck');
        $fee_rs = $fee->field('s12')->find(1);
        $s12 = $fee_rs['s12'];
        $count = $fck->where('father_id=' . $fid)->count();
        $one = $fck->where('id=' . $fid)->find();
        if ($count >= 2) {
            $money_count = $s12;
            $this->rw_bonus($one['father_id'], $one['user_id'], 3, $money_count);
            $this->jjc($one['user_id'], $money_count);
        }
        unset($fee, $fee_rs, $fck, $one, $count);
    }
    
    // 对碰奖
    public function duipeng($ppath, $level)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('str1,s11,s1')->find(1);
        $s1 = explode("|", $fee_rs['s1']); // 各级对碰比例
        $s11 = $fee_rs['s11']; // 各级对碰比例
        
        $str1 = explode("|", $fee_rs['str1']); // 封顶
        $one_mm = $s11;
        // $fck_array = 'is_pay>=1 and (shangqi_l>0 or shangqi_r>0) and id in (0'.$ppath.'0)';
        $fck_array = 'is_pay>=1 and  id in (0' . $ppath . '0)';
        $field = '*';
        $frs = $this->where($fck_array)
            ->field($field)
            ->select();
        // BenQiL BenQiR ShangQiL ShangQiR
        foreach ($frs as $vo) {
            $list = $this->where('father_id=' . $vo['id'])
                ->order('id asc')
                ->select();
            
            $l_ach = $list[0]['ach'] + $list[0]['cpzj'];
            $r_ach = $list[1]['ach'] + $list[1]['cpzj'];
            $l_nums = $list[0]['l_nums'];
            $r_nums = $list[1]['r_nums'];
            
            $lo = $l_ach / $s11;
            $ro = $r_ach / $s11;
            $lo = floor($lo);
            $ro = floor($ro);
            $L = 0;
            $R = 0;
            
            $L = ($l_ach - $l_nums * $s11) / $s11;
            $R = ($r_ach - $r_nums * $s11) / $s11;
            $L = floor($L);
            $R = floor($R);
            
            // $L = $vo['shangqi_l'];
            // $R = $vo['shangqi_r'];
            $sq_l = $vo['shangqi_l'];
            $sq_r = $vo['shangqi_r'];
            $z_date = $vo['z_date'];
            $Encash = array();
            $NumS = 0; // 碰数
            $money = 0; // 对碰奖金额
            $Ls = 0; // 左剩余
            $Rs = 0; // 右剩余
            $this->touch1to1($Encash, $lo, $ro, $NumS);
            $Ls = $lo - $Encash['0'];
            $Rs = $ro - $Encash['1'];
            $myid = $vo['id'];
            $myusid = $vo['user_id'];
            $myulv = $vo['u_level'];
            $ss = $myulv - 1;
            $feng = $vo['day_feng'];
            $is_fenh = $vo['is_fenh'];
            $reid = $vo['re_id'];
            $repath = $vo['re_path'];
            $relevel = $vo['re_level'];
            $ul = $s1[$ss] / 100;
            $aa = $str1[$ss];
            $money = $one_mm * $NumS * $ul; // 对碰奖 奖金
            if ($money > $aa) {
                $money = $aa;
            }
            if ($feng >= $aa) {
                $money = 0;
            } else {
                $jfeng = $feng + $money;
                if ($jfeng > $aa) {
                    $money = $aa - $feng;
                }
            }
            // echo $Ls;
            // $result = $this->query('UPDATE __TABLE__ SET `shangqi_l`='. $Ls .',peng_num=peng_num+' . $NumS . ',`shangqi_r`='. $Rs .' where `id`='. $vo['id'].' and shangqi_l='.$sq_l.' and shangqi_r='.$sq_r);
            $result = $this->query('UPDATE __TABLE__ SET `ls`=' . $lo . ',`l_nums`=' . $Ls . ',`rs`=' . $ro . ',peng_num=peng_num+' . $NumS . ',`r_nums`=' . $Rs . ' where `id`=' . $vo['id']);
            $money_count = $money;
            if ($money_count > 0) {
                $this->rw_bonus($myid, $myusid, 2, $money_count);
                $this->jjc($myusid, $money_count);
                
                if ($z_date == 0) {
                    $time = time();
                    $this->query('UPDATE __TABLE__ SET  `z_date`=' . $time . ' where `id`=' . $vo['id']);
                }
                
                // 领导奖
                // $this->guanglij($repath,$myusid,$money_count);
                // 互助奖
                // $this->Huzhufenhong($myid,$relevel,$myusid,$money_count);
            }
        }
        unset($fee, $fee_rs, $frs, $vo);
    }
    
    // 领导奖
    public function lingdaojiang($repath, $inUserID = 0, $money = 0)
    {
        $fee = M('fee');
        // s4为领导奖 s5分红倍数 s7报单推报单 str6充值账户
        $fee_rs = $fee->field('s4,s5,s7,str6')->find(1);
        $s5 = explode("|", $fee_rs['s5']);
        $s7 = $fee_rs['s7'];
        $str6 = $fee_rs['str6'];
        $s4 = $fee_rs['s4'];
        // 给上5代
        $lirs = $this->where('id in (0' . $repath . '0)')
            ->field('id,is_fenh,u_level,re_nums,user_id,fh_nums,c_date')
            ->order('rdt desc')
            ->select();
        $i = 0;
        foreach ($lirs as $lrs) {
            $money_count = 0;
            $myid = $lrs['id'];
            
            $uLevel = $lrs['u_level'];
            $myusid = $lrs['user_id'];
            $feng = $lrs['fh_nums'];
            $c_date = $lrs['c_date'];
            $k = $s7;
            if ($k > $i && $uLevel >= 4) {
                $prii = $s5[$i] / 100;
                $money_count = bcmul($prii, $s4, 2);
                
                if ($feng >= $str6) {
                    $money_count = 0;
                } else {
                    $jfeng = $feng + $money_count;
                    if ($jfeng > $str6) {
                        $money_count = $str6 - $feng;
                    }
                }
                
                if ($money_count > 0) {
                    $this->rw_bonus($myid, $inUserID, 4, $money_count);
                    $this->jjc($myusid, $money_count);
                    
                    if ($c_date == 0) {
                        $time = time();
                        $this->query('UPDATE __TABLE__ SET  `c_date`=' . $time . ' where `id`=' . $lrs['id']);
                    }
                }
            }
            $i ++;
        }
        unset($lirs, $lrs);
        unset($fee, $fee_rs);
    }

    public function svip($ppath, $level)
    {
        $lirs = $this->where('id in (0' . $ppath . '0)')
            ->field('id,is_fenh,u_level,re_nums,user_id')
            ->order('rdt desc')
            ->select();
        foreach ($lirs as $key => $v) {
            if ($level >= 4) {
                $this->execute("update __TABLE__ set vip4=vip4+1 where id=" . $v['id']);
            }
            if ($level >= 5) {
                $this->execute("update __TABLE__ set vip4=vip4+1, vip5=vip5+1 where id=" . $v['id']);
            }
            
            if ($level >= 5) {
                $this->execute("update __TABLE__ set vip4=vip4+1, vip5=vip5+1 where id=" . $v['id']);
            }
            
            if ($level >= 9) {
                $this->execute("update __TABLE__ set vip4=vip4+1, vip5=vip5+1, vip6=vip6+1 where id=" . $v['id']);
            }
        }
    }
    
    // 业绩,vip,周计算
    public function yeji($ppath, $level, $money)
    {
        $fck = M('fck');
        $lirs = $this->where('id in (0' . $ppath . '0)')
            ->field('id,is_fenh,u_level,re_nums,user_id')
            ->order('rdt desc')
            ->select();
        foreach ($lirs as $key => $v) {
            if ($level >= 4) {
                $this->execute("update __TABLE__ set vip4=vip4+1 where id=" . $v['id']);
            }
        }
        
        $nowdate = time();
        $list = $fck->where('u_level>=5')
            ->field('*')
            ->select();
        foreach ($list as $key => $value) {
            $ulevel = $value['u_level'];
            $l = $value['l'];
            $r = $value['r'];
            $ach = $value['ach'];
            $re_nums = $value['re_nums'];
            $zdt = $value['zdt'];
            
            $shang_l = $value['shang_l'];
            $shang_r = $value['shang_r'];
            $shang_nums = $value['shang_nums'];
            $shang_ach = $value['shang_ach'];
            
            if ($zdt == 0) {
                $zdt = $value['pdt'];
            }
            // $outdate=$t+60*60*24*30;
            $outdate = $zdt + 30;
            if ($nowdate >= $outdate) {
                // 新增
                $ls = $l - $shang_l;
                $rs = $r - $shang_r;
                $num = $re_nums - $shang_nums;
                if ($ulevel == 5) {
                    if ($ls >= 6 && $rs >= 6 && $num >= 6) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=tz_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel == 6) {
                    if ($ls >= 8 && $rs >= 8 && $num >= 6) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=tz_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel == 7) {
                    if ($ls >= 12 && $rs >= 12 && $num >= 6) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=tz_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel == 8) {
                    if ($ls >= 18 && $rs >= 18 && $num >= 6) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=tz_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},tz_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel >= 9) {
                    $res = $fck->where('father_id=' . $value['id'])
                        ->order('id desc')
                        ->select();
                    $l_nums = $res[0]['ach'] + $res[0]['cpzj'];
                    $r_nums = $lis[1]['ach'] + $res[0]['cpzj'];
                    $achs = $ach - $shang_ach;
                }
                
                if ($ulevel == 9) {
                    if ($l_nums > 20000 || $r_nums > 20000) {
                        $one = 1;
                    } else {
                        $one = 0;
                    }
                    
                    if ($ls >= 24 && $rs >= 24 && $num >= 6 && $achs >= 40000 && $one == 0) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=jia_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel == 10) {
                    if ($l_nums > 30000 || $r_nums > 30000) {
                        $one = 1;
                    } else {
                        $one = 0;
                    }
                    
                    if ($ls >= 36 && $rs >= 36 && $num >= 6 && $achs >= 60000 && $one == 0) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=jia_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel == 11) {
                    if ($l_nums > 80000 || $r_nums > 80000) {
                        $one = 1;
                    } else {
                        $one = 0;
                    }
                    
                    if ($ls >= 50 && $rs >= 50 && $num >= 6 && $achs >= 150000 && $one == 0) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=jia_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=0 where id=" . $value['id']);
                    }
                }
                
                if ($ulevel == 12) {
                    if ($l_nums > 160000 || $r_nums > 160000) {
                        $one = 1;
                    } else {
                        $one = 0;
                    }
                    
                    if ($ls >= 75 && $rs >= 75 && $num >= 6 && $achs >= 300000 && $one == 0) {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=jia_nums+1 where id=" . $value['id']);
                    } else {
                        $thi->execute("update __TABLE__ set shang_l={$ls},shang_r={$rs},shang_nums={$num},shang_ach={$achs},jia_nums=0 where id=" . $value['id']);
                    }
                }
            }
        }
    }

    public function getReid($id)
    {
        $rs = $this->where('id=' . $id)
            ->field('id,re_nums,is_fenh')
            ->find();
        return array(
            're_id' => $rs['id'],
            're_nums' => $rs['re_nums'],
            'is_fenh' => $rs['is_fenh']
        );
    }
    
    // 劳务奖b3
    public function guanglij($repath, $inUserID = 0, $money = 0)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s7')->find(1);
        $s7 = explode("|", $fee_rs['s7']); // 代数
        
        $lirs = $this->where('id in (0' . $repath . '0)')
            ->field('id,u_level,re_nums,is_fenh')
            ->order('re_level desc')
            ->limit(1)
            ->select();
        
        $i = 1;
        foreach ($lirs as $lrs) {
            $myid = $lrs['id'];
            $is_fenh = $lrs['is_fenh'];
            $re_nums = $lrs['re_nums'];
            
            if ($re_nums > 10) {
                $re_nums = 10;
            }
            
            $sss = $re_nums - 1;
            $myccc = $s7[$sss] / 100;
            
            $money_count = bcmul($myccc, $money, 2);
            
            if ($money_count > 0 && $is_fenh == 0) {
                $this->rw_bonus($myid, $inUserID, 5, $money_count);
            }
            
            $i ++;
        }
        unset($fee, $fee_rs, $s15, $lirs, $lrs);
    }
    
    // 互助奖(加权平分)
    public function Huzhufenhong($uid, $relevel, $inUserID, $money)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s12')->find(1);
        $s12 = $fee_rs['s12'];
        
        $prii = $s12 / 100;
        $b5_money = bcmul($prii, $money, 2);
        $max_re_level = $relevel + 2;
        $where1 = "is_pay>0 and re_path like '%," . $uid . ",%' and re_level<=" . $max_re_level;
        $rs_count1 = $this->where($where1)->count();
        if ($rs_count1 > 0) {
            $rs = $this->where($where1)->select();
            foreach ($rs as $vo) {
                $money_count = 0;
                $myid = $vo['id'];
                $mis_fenh = $vo['is_fenh'];
                $money_count = $b5_money / $rs_count1;
                if ($money_count > 0 && $mis_fenh == 0) {
                    $this->rw_bonus($myid, $inUserID, 6, $money_count);
                }
            }
        }
        unset($where1, $rs_count1, $rs);
    }
    
    // 每日分红
    public function mr_fenhong($type = 0)
    {
        $now_time = strtotime(date('Y-m-d'));
        $fee = M('fee');
        $promo = M('promo');
        $fee_rs = $fee->field('s1,s3,f_time')->find(1);
        $s15 = $fee_rs['s1'] / 100;
        $s3 = explode("|", $fee_rs['s3']);
        
        $f_time = $fee_rs['f_time'];
        if ($f_time < $now_time || $type == 1) {
            $result = $fee->execute("update __TABLE__ set f_time=" . $now_time . " where id=1 and f_time=" . $f_time);
            if ($result || $type == 1) {
                $where = "is_pay=1 and is_fenh=0 and is_lockfh=0 and fanli=0 and fanli_time<" . $now_time;
                $list = $this->where($where)
                    ->field('id,user_id,u_level,fanli_money,xy_money,fanli_time,re_path,cpzj')
                    ->select();
                foreach ($list as $lrs) {
                    $myid = $lrs['id'];
                    $inUserID = $lrs['user_id'];
                    $fanli_money = $lrs['fanli_money'];
                    $xy_money = $lrs['xx_money'];
                    $fanli_time = $lrs['fanli_time'];
                    $mycpzj = $lrs['cpzj'];
                    $myulv = $lrs['u_level'];
                    $repath = $lrs['re_path'];
                    
                    if ($myulv == 1) {
                        $beii = 2;
                    } elseif ($myulv == 2) {
                        $beii = 2;
                    } elseif ($myulv == 3) {
                        $beii = 2;
                    } elseif ($myulv == 4) {
                        $beii = 2;
                    } elseif ($myulv == 5) {
                        $beii = 2;
                    }
                    
                    // $pcount = $promo -> where('danshu=0 and uid='.$myid)->count();
                    // if($pcount>0){
                    // $small_level = $promo->where('danshu=0 and uid='.$myid)->min('u_level');
                    // $mycpzj = $s3[$small_level-1];
                    // }
                    
                    $maxfenhong = $mycpzj * $beii;
                    
                    $money_count = bcmul($s15, $mycpzj, 2);
                    
                    $all_g = $fanli_money + $money_count;
                    if ($all_g >= $maxfenhong) {
                        if ($fanli_money < $maxfenhong) {
                            $money_count = $maxfenhong - $fanli_money;
                        } else {
                            $money_count = 0;
                        }
                        $this->execute("update __TABLE__ set fanli=1 where id=" . $myid);
                    }
                    
                    if ($now_time > $fanli_time) {
                        $this->query("UPDATE __TABLE__ SET `fanli_time`=" . $now_time . " where `id`=" . $myid);
                        if ($money_count > 0) {
                            $this->query("UPDATE __TABLE__ SET `fanli_money`=fanli_money+" . $money_count . " where `id`=" . $myid);
                            
                            $this->rw_bonus($myid, $inUserID, 1, $money_count);
                            // 领导奖
                            $this->lingdaojiang($repath, $inUserID, $money_count);
                        }
                    }
                }
                unset($list, $lrs, $where);
            }
        }
        unset($fee_rs);
    }

    public function jingtaibufa($uid, $money)
    {
        echo $now_time = strtotime(date('Y-m-d'));
        $fee = M('fee');
        $fee_rs = $fee->field('s1,s3,f_time')->find(1);
        $s15 = $fee_rs['s1'] / 100;
        $s3 = explode("|", $fee_rs['s3']);
        
        $where = "is_pay=1 and is_fenh=0 and is_lockfh=0 and fanli=0 and id=" . $uid;
        $lrs = $this->where($where)
            ->field('id,user_id,u_level,fanli_money,xy_money,fanli_time,re_path,cpzj')
            ->find();
        if ($lrs) {
            $myid = $lrs['id'];
            $inUserID = $lrs['user_id'];
            $fanli_money = $lrs['fanli_money'];
            $xy_money = $lrs['xy_money'];
            // echo $fanli_time = $lrs['fanli_time'];
            $mycpzj = $lrs['cpzj'];
            $myulv = $lrs['u_level'];
            $repath = $lrs['re_path'];
            
            if ($myulv == 1) {
                $beii = 2;
            } elseif ($myulv == 2) {
                $beii = 2;
            } elseif ($myulv == 3) {
                $beii = 2;
            } elseif ($myulv == 4) {
                $beii = 2;
            } elseif ($myulv == 5) {
                $beii = 2;
            }
            
            $maxfenhong = $mycpzj * $beii;
            
            if ($fanli_time < $now_time) {
                $money_count = bcmul($s15, $mycpzj, 2);
            } else {
                $money_count = bcmul($s15, $money, 2);
            }
            
            $all_g = $fanli_money + $money_count;
            if ($all_g >= $maxfenhong) {
                if ($fanli_money < $maxfenhong) {
                    $money_count = $maxfenhong - $fanli_money;
                } else {
                    $money_count = 0;
                }
                $this->execute("update __TABLE__ set fanli=1 where id=" . $myid);
            }
            
            if ($now_time > $fanli_time) {
                $this->query("UPDATE __TABLE__ SET `fanli_time`=" . $now_time . " where `id`=" . $myid);
            }
            
            if ($money_count > 0) {
                $this->rw_bonus($myid, $inUserID, 1, $money_count);
                // 领导奖
                $this->lingdaojiang($repath, $inUserID, $money_count);
            }
        }
    }
    
    // 层奖和对碰奖的日封顶
    public function zfd_jj($uid, $money = 0)
    {
        $fee = M('fee');
        $fee_rs = $fee->field('str1')->find();
        $str1 = explode("|", $fee_rs['str1']); // 分红奖封顶
        
        $rs = $this->where('id=' . $uid)
            ->field('u_level,day_feng')
            ->find();
        if ($rs) {
            $day_feng = $rs['day_feng'];
            $feng = $str1[$rs['u_level'] - 1];
            if ($money > $feng) {
                $money = $feng;
            }
            
            if ($day_feng >= $feng) {
                $money = 0;
            } else {
                $tt_money = $money + $day_feng;
                if ($tt_money > $feng) {
                    $money = $feng - $day_feng;
                }
            }
        }
        
        return $money;
    }
    
    /**
     * 各种扣税以及奖金结算
     * @param 应得到奖金的会员ID $myid
     * @param 正在投资的会员ID $inUserID
     * @param 奖金类别 $bnum
     * @param 投资金额 $money_count
     * @param  $corid
     */
    public function rw_bonus($myid, $inUserID = 0, $bnum = 0, $money_count = 0, $corid = 0)
    {
        // 查询会员表数据
        $one = $this->where("id='" . $myid."'")->field('cash')->find();
        // 账户中现金币余额
        $cash = $one['cash'];
        $bonus = M('bonus');
        // $myid为应得到奖金的会员ID
        $bid = $this->_getTimeTableList($myid);
        // 待更新到现金账户数据
        // 加到奖金记录表
        $bonus->execute("UPDATE __TABLE__ SET b0=b0+" . $last_m . "," . $inbb . "=" . $inbb . "+" . $money_count . "  WHERE id={$bid}");
        // 加到会员表
        $this->execute("update __TABLE__ set " . $usqlc . ",cash=cash+" . $money_count . " where id=" . $myid);
        // 如果金额大于0，更新到货币历史记录表
        if ($money_count > 0) {
            $this->addencAdd($myid, $inUserID, $money_count, $bnum);
        }
        unset($bonus);
        unset($mrs);
    }
    /**
     * 每项奖金加到奖金记录表
     * @param unknown $uid
     */
    public function _getTimeTableList($uid)
    {
        $times = M('times');
        // 奖金表
        $bonus = M('bonus');
        $boid = 0;
        // 现在时间
        $nowdate = strtotime(date('Y-m-d')) + 3600 * 24 - 1;
        // 本期时间设置为现在时间
        $settime_two['benqi'] = $nowdate;
        $settime_two['type'] = 0;
        // 查询类型为0的时间表数据
        $trs = $times->where($settime_two)->find();
        // 如果当前时间，类型为0的数据不存在
        if (! $trs) {
            // 检索以前存在的类型为0的数据
            $rs3 = $times->where('type=0')->order('id desc')->find();
            // 如果存在以前的时间记录
            if ($rs3) {
                // 把本期数据作为上期数据
                $data['shangqi'] = $rs3['benqi'];
                // 把现在时间作为本期数据
                $data['benqi'] = $nowdate;
                $data['is_count'] = 0;
                $data['type'] = 0;
            } else {
                // 如果存在以前的时间记录，也就是新纪录
                $data['shangqi'] = strtotime('2010-01-01');
                $data['benqi'] = $nowdate;
                $data['is_count'] = 0;
                $data['type'] = 0;
            }
            $shangqi = $data['shangqi'];
            $benqi = $data['benqi'];
            unset($rs3);
            // 更新到时间记录表
            $boid = $times->add($data);
            unset($data);
        } else {
            // 如果当前时间存在记录
            $shangqi = $trs['shangqi'];
            $benqi = $trs['benqi'];
            $boid = $trs['id'];
        }
        $_SESSION['BONUSDID'] = $boid;
        $brs = $bonus->where("user_id='{$uid}' AND son_id='{$boid}'")->find();
        if ($brs) {
            $bid = $brs['id'];
        } else {
            $frs = $this->where("id={$uid}")->field('id,user_id')->find();
            $data = array();
            $data['did'] = $boid;
            $data['uid'] = $frs['id'];
            $data['user_id'] = $frs['user_id'];
            $data['e_date'] = $benqi;
            $data['s_date'] = $shangqi;
            $bid = $bonus->add($data);
        }
        return $bid;
    }
    
    // 分红添加记录
    public function add_xf($one_prices = 0, $cj_ss = 0)
    {
        $fenhong = M('fenhong');
        $data = array();
        // $data['uid'] = 1;
        // $data['user_id'] = $cj_ss;
        $data['f_num'] = $cj_ss;
        $data['f_money'] = $one_prices;
        $data['pdt'] = mktime();
        $fenhong->add($data);
        unset($fenhong, $data);
    }
    
    // 日封顶
    public function ap_rifengding()
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s7')->find();
        $s7 = explode("|", $fee_rs['s7']);
        
        $where = array();
        $where['b8'] = array(
            'gt',
            0
        );
        $mrs = $this->where($where)
            ->field('id,b8,day_feng,get_level')
            ->select();
        foreach ($mrs as $vo) {
            $day_feng = $vo['day_feng'];
            $ss = $vo['get_level'];
            $bbb = $vo['b8'];
            $fedd = $s7[$ss]; // 封顶
            $get_money = $bbb;
            $all_money = $bbb + $day_feng;
            $fdok = 0;
            if ($all_money >= $fedd) {
                $fdok = 1;
                $get_money = $fedd - $day_feng;
            }
            if ($get_money < 0) {
                $get_money = 0;
            }
            if ($get_money >= 0) {
                $this->query("UPDATE __TABLE__ SET `b8`=" . $get_money . ",day_feng=day_feng+" . $get_money . " where `id`=" . $vo['id']);
            }
            if ($get_money > 0) {
                if ($fdok == 1) {
                    $this->query("UPDATE __TABLE__ SET x_num=x_num+1 where `id`=" . $vo['id']);
                }
            }
        }
        unset($fee, $fee_rs, $s7, $where, $mrs);
    }
    
    // 总封顶
    public function ap_zongfengding()
    {
        $fee = M('fee');
        $fee_rs = $fee->field('s15')->find();
        $s15 = $fee_rs['s15'];
        
        $where = array();
        $where['b0'] = array(
            'gt',
            0
        );
        $where['_string'] = 'b0+zjj>' . $s15;
        $mrs = $this->where($where)
            ->field('id,b0,zjj')
            ->select();
        foreach ($mrs as $vo) {
            $zjj = $vo['zjj'];
            $bbb = $vo['b0'];
            $get_money = $s15 - $zjj;
            
            if ($get_money > 0) {
                $this->query("UPDATE __TABLE__ SET `b0`=" . $get_money . " where `id`=" . $vo['id']);
            }
        }
        unset($mrs);
    }
    
    // 奖金大汇总（包括扣税等）
    public function quanhuizong()
    {
        $this->execute('UPDATE __TABLE__ SET `b0`=b1+b2+b3+b4+b5+b6+b7+b8');
        
        $this->execute('UPDATE __TABLE__ SET `b0`=0,b1=0,b2=0,b3=0,b4=0,b5=0,b6=0,b7=0,b8=0,b9=0,b10=0 where is_fenh=1');
    }
    
    // 清空时间
    public function emptywTime()
    {
        // 当前日期
        $sdefaultDate = date("Y-m-d");
        // $first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $first = 1;
        // 获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $w = date('w', strtotime($sdefaultDate));
        // 获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        // $week_start=date('Y-m-d',strtotime("$sdefaultDate -".($w ? $w - $first : 6).' days'));
        $week_strt = strtotime("$sdefaultDate -" . ($w ? $w - $first : 6) . ' days');
        
        $this->query("UPDATE `xt_fck` SET `is_fh`=0,`is_sf`=0,_times=" . $week_strt . " WHERE _times !=" . $week_strt . "");
    }
    // 清空时间
    public function emptyTime()
    {
        $nowdate = strtotime(date('Y-m-d'));
        
        $this->query("UPDATE `xt_fck` SET `is_fh`=0,`is_sf`=0,_times=" . $nowdate . " WHERE _times !=" . $nowdate . "");
    }
    
    // 清空月封顶
    public function emptyMonthTime()
    { // zyq_date 记录当前月
        $nowmonth = date('m');
        
        $this->query("UPDATE `xt_fck` SET `agent_cf`=0,zyq_date=" . $nowmonth . " WHERE zyq_date !=" . $nowmonth . "");
    }

    public function gongpaixtsmall($uid)
    {
        $fck = M('fck');
        $mouid = $uid;
        $field = 'id,user_id,p_level,p_path,u_pai';
        $where = 'is_pay>0 and (p_path like "%,' . $mouid . ',%" or id=' . $mouid . ')';
        
        $re_rs = $fck->where($where)
            ->order('p_level asc,u_pai asc')
            ->field($field)
            ->select();
        $fck_where = array();
        foreach ($re_rs as $vo) {
            $faid = $vo['id'];
            $fck_where['is_pay'] = array(
                'egt',
                0
            );
            $fck_where['father_id'] = $faid;
            $count = $fck->where($fck_where)->count();
            if (is_numeric($count) == false) {
                $count = 0;
            }
            if ($count < 2) {
                $father_id = $vo['id'];
                $father_name = $vo['user_id'];
                $TreePlace = $count;
                $p_level = $vo['p_level'] + 1;
                $p_path = $vo['p_path'] . $vo['id'] . ',';
                $u_pai = $vo['u_pai'] * 2 + $TreePlace;
                
                $arry = array();
                $arry['father_id'] = $father_id;
                $arry['father_name'] = $father_name;
                $arry['treeplace'] = $TreePlace;
                $arry['p_level'] = $p_level;
                $arry['p_path'] = $p_path;
                $arry['u_pai'] = $u_pai;
                return $arry;
                break;
            }
        }
    }

    public function bobifengding()
    {
        $fee = M('fee');
        $bonus = M('bonus');
        $fee_rs = M('fee')->find();
        $table = $this->tablePrefix . 'fck';
        $z_money = 0; // 总支出
        $z_money = $this->where('is_pay = 1')->sum('b2');
        $times = M('times');
        $trs = $times->order('id desc')
            ->field('shangqi')
            ->find();
        if ($trs) {
            $benqi = $trs['shangqi'];
        } else {
            $benqi = strtotime(date('Y-m-d'));
        }
        $zsr_money = 0; // 总收入
        $zsr_money = $this->where('pdt>=' . $benqi . ' and is_pay=1')->sum('cpzj');
        $bl = $z_money / $zsr_money;
        $fbl = $fee_rs['s11'] / 100;
        if ($bl > $fbl) {
            // $bl = $fbl;
            // $xbl = $bl - $fbl;
            $z_o1 = $zsr_money * $fbl;
            $z_o2 = $z_o1 / $z_money;
            $this->query("UPDATE " . $table . " SET `b2`=b2*{$z_o2} where `is_pay`>=1 ");
        }
    }
    
    // 判断进入B网
    public function pd_into_websiteb($uid)
    {
        // $fck = D ('fck');
        $fck = new FckModel('fck');
        $fck2 = M('fck2');
        $where = "is_pay>0 and is_lock=0 and is_bb>=0 and id=" . $uid;
        $lrs = $fck->where($where)
            ->field('id,user_id,re_id,user_name,nickname,u_level')
            ->find();
        if ($lrs) {
            $myid = $lrs['id'];
            $result = $fck->execute("update __TABLE__ set is_bb=is_bb+1 where id=" . $myid . " and is_bb>=0");
            if ($result) {
                $data = array();
                $data['fck_id'] = $lrs['id'];
                $data['re_num'] = $lrs['re_id'];
                $data['user_id'] = $lrs['user_id'];
                $data['user_name'] = $lrs['user_name'];
                $data['nickname'] = $lrs['nickname'];
                $data['u_level'] = $lrs['u_level'];
                $data['ceng'] = 0;
                
                $farr = $fck->gongpaixt_Two_big_B();
                $data['father_id'] = $farr['father_id'];
                $data['father_name'] = $farr['father_name'];
                $data['treeplace'] = $farr['treeplace'];
                $data['p_level'] = $farr['p_level'];
                $data['p_path'] = $farr['p_path'];
                $data['u_pai'] = $farr['u_pai'];
                $data['is_pay'] = 1;
                $data['pdt'] = time();
                $ress = $fck2->add($data); // 添加
                $ppath = $data['p_path'];
                $inUserID = $data['user_id'];
                $ulevel = $data['u_level'];
                unset($data, $farr);
                if ($ress) {
                    // b网见点
                    $fck->jiandianjiang_bb($ppath, $inUserID, $ulevel);
                }
            }
        }
        unset($fck2, $lrs, $where, $fck);
    }
}

?>