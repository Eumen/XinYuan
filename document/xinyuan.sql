﻿# Host: localhost  (Version: 5.5.53)
# Date: 2018-04-17 20:43:42
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "xy_access"
#

DROP TABLE IF EXISTS `xy_access`;
CREATE TABLE `xy_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `groupId` (`role_id`) USING BTREE,
  KEY `nodeId` (`node_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限表';

#
# Data for table "xy_access"
#

/*!40000 ALTER TABLE `xy_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_access` ENABLE KEYS */;

#
# Structure for table "xy_address"
#

DROP TABLE IF EXISTS `xy_address`;
CREATE TABLE `xy_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT '' COMMENT '用户名',
  `user_name` varchar(255) DEFAULT '' COMMENT '用户姓名',
  `address` varchar(255) DEFAULT '' COMMENT '地址',
  `tel` varchar(255) DEFAULT '' COMMENT '电话',
  `default` varchar(255) DEFAULT '0' COMMENT '0:非默认1：默认',
  `bz` varchar(255) DEFAULT '' COMMENT '备注',
  `code` varchar(255) DEFAULT '' COMMENT '邮编',
  `update_flag` varchar(255) DEFAULT '0' COMMENT '更新标志',
  `update_time` varchar(255) DEFAULT '' COMMENT '更新时间',
  `delete_flag` varchar(255) DEFAULT '0' COMMENT '删除标志',
  `delete_time` varchar(255) DEFAULT '' COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段1',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段2',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='地址表';

#
# Data for table "xy_address"
#

/*!40000 ALTER TABLE `xy_address` DISABLE KEYS */;
INSERT INTO `xy_address` VALUES (6,'aaa','123123','123123','123123','0','','','0','','0','',NULL,NULL,NULL),(7,'carNo1','aaa','aaa','aaa','0','','','0','','0','',NULL,NULL,NULL),(8,'carNo1','123123','123123','123123','0','','','0','','0','',NULL,NULL,NULL),(9,'carNo1','123123','123123','321321','0','','','0','','0','',NULL,NULL,NULL),(10,'carNo1','123123','123123','123123','1','','','0','','0','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `xy_address` ENABLE KEYS */;

#
# Structure for table "xy_bonushistory"
#

DROP TABLE IF EXISTS `xy_bonushistory`;
CREATE TABLE `xy_bonushistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT '' COMMENT '流入用户名',
  `user_name` varchar(255) DEFAULT '' COMMENT '流入用户姓名',
  `produce_userid` varchar(255) DEFAULT '' COMMENT '产生用户名',
  `produce_username` varchar(255) DEFAULT '' COMMENT '产生用户姓名',
  `action_type` varchar(255) DEFAULT '' COMMENT '奖金传递类型',
  `time` varchar(255) DEFAULT '' COMMENT '产生奖金时间',
  `money` varchar(255) DEFAULT '' COMMENT '发生金额',
  `in_money` varchar(255) DEFAULT '' COMMENT '到账金额',
  `bz` varchar(255) DEFAULT '' COMMENT '备注',
  `update_flag` varchar(255) DEFAULT '0' COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT '0' COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT '' COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT '' COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段1',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资金流向表';

#
# Data for table "xy_bonushistory"
#

/*!40000 ALTER TABLE `xy_bonushistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_bonushistory` ENABLE KEYS */;

#
# Structure for table "xy_bonussummary"
#

DROP TABLE IF EXISTS `xy_bonussummary`;
CREATE TABLE `xy_bonussummary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` varchar(255) DEFAULT NULL COMMENT '总奖金',
  `re_money` varchar(255) DEFAULT NULL COMMENT '推荐奖金',
  `point_money` varchar(255) DEFAULT NULL COMMENT '见点奖',
  `reg_money` varchar(255) DEFAULT NULL COMMENT '报单奖',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `time` varchar(255) DEFAULT NULL COMMENT '结算时间',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='平台奖金汇总表';

#
# Data for table "xy_bonussummary"
#

/*!40000 ALTER TABLE `xy_bonussummary` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_bonussummary` ENABLE KEYS */;

#
# Structure for table "xy_cody"
#

DROP TABLE IF EXISTS `xy_cody`;
CREATE TABLE `xy_cody` (
  `c_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cody_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

#
# Data for table "xy_cody"
#

/*!40000 ALTER TABLE `xy_cody` DISABLE KEYS */;
INSERT INTO `xy_cody` VALUES (1,'profile'),(2,'password'),(3,'Jj_FA'),(4,'4'),(5,'5'),(6,'6'),(7,'7'),(8,'8'),(9,'9'),(10,'10'),(11,'11'),(12,'12'),(13,'13'),(14,'14'),(15,'15'),(16,'16'),(17,'17'),(18,'18'),(19,'19'),(20,'20'),(21,'21'),(22,'22'),(23,'23'),(24,'24'),(25,'25'),(26,'26'),(27,'27'),(28,'28'),(29,'29'),(30,'30');
/*!40000 ALTER TABLE `xy_cody` ENABLE KEYS */;

#
# Structure for table "xy_cptype"
#

DROP TABLE IF EXISTS `xy_cptype`;
CREATE TABLE `xy_cptype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tpname` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分类名',
  `b_id` int(11) NOT NULL DEFAULT '0',
  `s_id` int(11) NOT NULL DEFAULT '0',
  `t_pai` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "xy_cptype"
#

/*!40000 ALTER TABLE `xy_cptype` DISABLE KEYS */;
INSERT INTO `xy_cptype` VALUES (1,'汽车美容',0,0,0,0),(2,'饮料',0,0,0,0),(4,'家居',0,0,0,0),(5,'手机数码',0,0,0,0),(6,'户外运动',0,0,0,0),(7,'服装',0,0,0,0),(8,'家用电器',0,0,0,0),(9,'电脑/办公',0,0,0,0),(10,'美妆个护',0,0,0,0),(11,'房产/汽车用品',0,0,0,0),(12,'母婴/玩具乐器',0,0,0,0),(13,'食品/酒类/生鲜/特产',0,0,0,0),(14,'艺术/礼品鲜花',0,0,0,0),(15,'医药保健/计生情趣',0,0,0,0),(16,'图书/音像/电子书',0,0,0,0),(17,'机票/酒店/旅游/生活',0,0,0,0);
/*!40000 ALTER TABLE `xy_cptype` ENABLE KEYS */;

#
# Structure for table "xy_fee"
#

DROP TABLE IF EXISTS `xy_fee`;
CREATE TABLE `xy_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s1` varchar(255) DEFAULT NULL COMMENT '投资金额',
  `s2` varchar(255) DEFAULT NULL COMMENT '管理费',
  `s3` varchar(255) DEFAULT NULL COMMENT '提现手续费',
  `s4` varchar(255) DEFAULT NULL COMMENT '关闭网站提示信息',
  `s5` varchar(255) DEFAULT NULL COMMENT '级别',
  `s6` varchar(255) DEFAULT NULL COMMENT '推荐奖',
  `s7` varchar(255) DEFAULT NULL COMMENT '见点奖',
  `s8` varchar(255) DEFAULT NULL COMMENT '报单奖',
  `s9` varchar(255) DEFAULT NULL COMMENT '最低提现额度',
  `s10` varchar(255) DEFAULT NULL COMMENT '开户银行信息',
  `s11` varchar(255) DEFAULT NULL COMMENT '注册成功信息',
  `s12` varchar(255) DEFAULT NULL COMMENT '充值成功信息',
  `s13` varchar(255) DEFAULT NULL COMMENT '登陆背景',
  `s14` varchar(255) DEFAULT NULL COMMENT '主页背景',
  `s15` varchar(255) DEFAULT '' COMMENT '见点奖层数',
  `s16` varchar(255) DEFAULT '' COMMENT '充值账户',
  `s17` varchar(255) DEFAULT NULL COMMENT '众筹基金',
  `s18` varchar(255) DEFAULT '' COMMENT '奖金名称',
  `s19` varchar(255) DEFAULT '' COMMENT '汇款信息',
  `s20` varchar(255) DEFAULT '' COMMENT '是否关闭登录 0：开启 1：关闭',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台参数表';

#
# Data for table "xy_fee"
#

/*!40000 ALTER TABLE `xy_fee` DISABLE KEYS */;
INSERT INTO `xy_fee` VALUES (1,'3000','','5','网站关闭升级中，请互相转告！','普通用户|会员','300','100','200','100','农业银行|工商银行|招商银行|建设银行|中国银行','恭喜您注册成功，激活会员将有更多福利等您领取！','','','','10','carNo1','10','直推奖|见点奖|报单奖|众筹基金|现金币|积分币','您已汇款成功，请耐心等待管理员审核！',NULL);
/*!40000 ALTER TABLE `xy_fee` ENABLE KEYS */;

#
# Structure for table "xy_form_class"
#

DROP TABLE IF EXISTS `xy_form_class`;
CREATE TABLE `xy_form_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `baile` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "xy_form_class"
#

/*!40000 ALTER TABLE `xy_form_class` DISABLE KEYS */;
INSERT INTO `xy_form_class` VALUES (1,'新闻公告',0);
/*!40000 ALTER TABLE `xy_form_class` ENABLE KEYS */;

#
# Structure for table "xy_gouwu"
#

DROP TABLE IF EXISTS `xy_gouwu`;
CREATE TABLE `xy_gouwu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `money` varchar(255) DEFAULT NULL COMMENT '金额',
  `time` varchar(255) DEFAULT NULL COMMENT '购物时间',
  `ispay` varchar(255) DEFAULT NULL COMMENT '支付与否：0：未支付 1：已支付',
  `count` varchar(255) DEFAULT NULL COMMENT '数量',
  `price` varchar(255) DEFAULT NULL COMMENT '单价',
  `address` varchar(255) DEFAULT NULL COMMENT '邮寄地址',
  `receive_id` varchar(255) DEFAULT NULL COMMENT '收货人用户名',
  `receive_name` varchar(255) DEFAULT NULL COMMENT '收货人姓名',
  `tel` varchar(255) DEFAULT NULL COMMENT '收货人联系电话',
  `send_id` varchar(255) DEFAULT NULL COMMENT '发货人用户名',
  `send_name` varchar(255) DEFAULT NULL COMMENT '发货人姓名',
  `confirm_send_id` varchar(255) DEFAULT NULL COMMENT '确认发货用户名',
  `confirm_send_name` varchar(255) DEFAULT NULL COMMENT '确认发货姓名',
  `confirm_send_time` varchar(255) DEFAULT NULL COMMENT '确认发货时间',
  `confirm_receive_id` varchar(255) DEFAULT NULL COMMENT '确认收货用户名',
  `confirm_receive_name` varchar(255) DEFAULT NULL COMMENT '确认收货姓名',
  `confirm_receive_time` varchar(255) DEFAULT NULL COMMENT '确认收货时间',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '商品ID',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='购物表';

#
# Data for table "xy_gouwu"
#

/*!40000 ALTER TABLE `xy_gouwu` DISABLE KEYS */;
INSERT INTO `xy_gouwu` VALUES (1,'carNo1',NULL,'372','1523646675','0','4','93','大连','carNo1','李雷','1587845121','carNo1','李雷',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL),(2,'carNo1',NULL,'372','1523646769','0','4','93','大连','carNo1','李雷','1587845121','carNo1','李雷',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL),(3,'carNo1','李雷','186','1523647651','0','2','93','大连','carNo1','李雷','1587845121','carNo1','李雷',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'carNo1','tom','93','1523647788','0','1','93','米国白宫','carNo1','tom','15845127845','carNo1','tom',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL),(5,'carNo1','123123','30','1523928498','0','6','5','123123','carNo1','123123','123123','carNo1','123123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'4',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `xy_gouwu` ENABLE KEYS */;

#
# Structure for table "xy_member"
#

DROP TABLE IF EXISTS `xy_member`;
CREATE TABLE `xy_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆用户名',
  `user_name` varchar(255) DEFAULT '' COMMENT '实名',
  `tel` varchar(255) DEFAULT '' COMMENT '手机号',
  `last_login_time` varchar(255) DEFAULT '' COMMENT '上次登录时间',
  `last_login_ip` varchar(255) DEFAULT '' COMMENT '上次登录ip',
  `status` varchar(255) DEFAULT '0' COMMENT '0:正常1：禁止登陆',
  `password` varchar(255) DEFAULT '' COMMENT '密码',
  `password2` varchar(255) DEFAULT '' COMMENT '二级密码',
  `pwd1` varchar(255) DEFAULT '' COMMENT '未加密密码',
  `pwd2` varchar(255) DEFAULT '' COMMENT '未加密密码',
  `wechat` varchar(255) DEFAULT '' COMMENT '微信',
  `bank` varchar(255) DEFAULT '' COMMENT '开户银行',
  `bankcard_number` varchar(255) DEFAULT '' COMMENT '银行卡号',
  `bank_province` varchar(255) DEFAULT '' COMMENT '开户省份',
  `bank_city` varchar(255) DEFAULT '' COMMENT '开户城市',
  `bank_address` varchar(255) DEFAULT '' COMMENT '开户详细地址',
  `register_time` varchar(255) DEFAULT '' COMMENT '注册时间',
  `re_id` varchar(255) DEFAULT '' COMMENT '推荐人ID',
  `re_name` varchar(255) DEFAULT '' COMMENT '推荐人姓名',
  `father_id` varchar(255) DEFAULT '' COMMENT '节点人ID',
  `father_name` varchar(255) DEFAULT '' COMMENT '节点人姓名',
  `grade` varchar(255) DEFAULT '0' COMMENT '0:普通用户 1:会员 2：管理员',
  `money` varchar(255) DEFAULT '0' COMMENT '注册金额',
  `cash` varchar(255) DEFAULT '0' COMMENT '现金币',
  `point` varchar(255) DEFAULT '0' COMMENT '积分',
  `recommend_sum` varchar(255) DEFAULT '0' COMMENT '推荐人数',
  `team_sum` varchar(255) DEFAULT '0' COMMENT '团队人数',
  `prem` varchar(255) DEFAULT '' COMMENT '权限',
  `re_path` varchar(255) DEFAULT '' COMMENT '推荐路径',
  `p_path` varchar(255) DEFAULT '' COMMENT '节点路径',
  `is_agent` varchar(255) DEFAULT '0' COMMENT '是否是服务中心 0：不是1：是',
  `is_seller` varchar(255) DEFAULT '0' COMMENT '是否是联盟商家 0：不是 1：是',
  `update_flag` varchar(255) DEFAULT '0' COMMENT '更新标志：0：未更新1：已更新',
  `update_time` varchar(255) DEFAULT '' COMMENT '更新时间',
  `delete_flag` varchar(255) DEFAULT '0' COMMENT '删除标志',
  `delete_time` varchar(255) DEFAULT '' COMMENT '删除时间',
  `re_money` varchar(255) DEFAULT '0' COMMENT '复投金额',
  `bk1` varchar(255) DEFAULT '' COMMENT '推荐绝对层数',
  `bk2` varchar(255) DEFAULT '' COMMENT '节点绝对层数',
  `bk3` varchar(255) DEFAULT '' COMMENT '多点登录',
  `bk4` varchar(255) DEFAULT '0' COMMENT '是否支付 0：未支付 1：已支付',
  `bk5` varchar(255) DEFAULT '' COMMENT '服务中心ID',
  `bk6` varchar(255) DEFAULT '' COMMENT '服务中心姓名',
  `bk7` varchar(255) DEFAULT '' COMMENT '开通时间',
  `bk8` varchar(255) DEFAULT '0' COMMENT '众筹基金',
  `bk9` varchar(255) DEFAULT '' COMMENT '开通用户ID',
  `bk10` varchar(255) DEFAULT NULL COMMENT '备用字段10',
  `user_code` varchar(255) DEFAULT '' COMMENT '身份证号',
  `us_img` varchar(255) DEFAULT '' COMMENT '用户头像',
  `is_fenh` varchar(255) DEFAULT '0' COMMENT '是否开启奖金',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='会员表';

#
# Data for table "xy_member"
#

/*!40000 ALTER TABLE `xy_member` DISABLE KEYS */;
INSERT INTO `xy_member` VALUES (1,'carNo1','公司','15677145136','1523966864','::1','0','4297f44b13955235245b2497399d7a93','4297f44b13955235245b2497399d7a93','123123','123123','1','工商银行','6222023400003222805','广西','南宁','民族大道支行','1523608131','0','0','0','0','2','3000','4970','4000','0','0','0',',',',','1','1','0',NULL,'0',NULL,'0','0','0','27df0ac97e7bba653cda1664a7a22bbc','1','carNo1',NULL,'1523699005','1000',NULL,NULL,'211224198901267212','/Public/Uploads/1avatar_150_150.jpg','0'),(2,'aaa','啊三','15678455446','1523801698','::1','0','4297f44b13955235245b2497399d7a93',NULL,'123123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1523608131','1','carNo1',NULL,NULL,'0','3000',NULL,NULL,NULL,NULL,NULL,',1,',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,'18fcf6c53bdb24f60c261a2bec465624','1','carNo1',NULL,'1523699005','100',NULL,NULL,NULL,NULL,'1'),(3,'bbb','啊B','15874586666','1523646257',NULL,'0','4297f44b13955235245b2497399d7a93',NULL,'123123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1523608260','1','carNo1',NULL,NULL,'0','3000',NULL,NULL,NULL,NULL,NULL,',1,',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,'6f53877dff62fc19d5371043172405a6','0','carNo1',NULL,'1523699005','100',NULL,NULL,NULL,NULL,'1'),(4,'123123',NULL,'15678450412',NULL,NULL,'0','4297f44b13955235245b2497399d7a93',NULL,'123123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1523775753','1','carNo1',NULL,NULL,'0','0','0','0',NULL,NULL,NULL,',1,',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'ccc',NULL,'15878450415','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523800672','1','carNo1','','','0','0','0','0','0','0','',',1,','','0','0','0','','0','','0','1','','','0','','','','0',NULL,NULL,'','','0'),(6,'test',NULL,'15677145136','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523961963','1','carNo1','2','aaa','0','0','0','0','0','0','',',1,','2,','0','0','0','','0','','0','1','1','','0','','','','0',NULL,NULL,'','','0'),(7,'test1',NULL,'15677145268','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962059','1','carNo1','2','aaa','0','0','0','0','0','0','',',1,','2,','0','0','0','','0','','0','1','1','','0','','','','0',NULL,NULL,'','','0'),(8,'test2',NULL,'15677145268','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962129','1','carNo1','2','aaa','0','0','0','0','0','0','',',1,','2,','0','0','0','','0','','0','1','1','','0','','','','0',NULL,NULL,'','','0'),(9,'test3',NULL,'15677145136','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962250','1','carNo1','7','test1','0','0','0','0','0','0','',',1,','2,7,','0','0','0','','0','','0','1','2','','0','','','','0',NULL,NULL,'','','0'),(10,'test4',NULL,'1584564','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962299','1','carNo1','7','test1','0','0','0','0','0','0','',',1,','2,7,','0','0','0','','0','','0','1','2','','0','','','','0',NULL,NULL,'','','0'),(11,'test5',NULL,'15677005136','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962472','1','carNo1','2','aaa','0','0','0','0','0','0','',',1,','2,','0','0','0','','0','','0','1','1','','0','','','','0',NULL,NULL,'','','0'),(12,'test7',NULL,'15878451222','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962610','1','carNo1','11','test5','0','0','0','0','0','0','',',1,','2,11,','0','0','0','','0','','0','1','2','','0','','','','0',NULL,NULL,'','','0'),(13,'test8',NULL,'15688464564','','','0','4297f44b13955235245b2497399d7a93','','123123','','','','','','','','1523962686','1','carNo1','11','test5','0','0','0','0','0','0','',',1,','2,11,','0','0','0','','0','','0','1','2','','0','','','','0',NULL,NULL,'','','0');
/*!40000 ALTER TABLE `xy_member` ENABLE KEYS */;

#
# Structure for table "xy_message"
#

DROP TABLE IF EXISTS `xy_message`;
CREATE TABLE `xy_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `user_id` varchar(255) DEFAULT NULL COMMENT '编辑人用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '编辑人姓名',
  `create_time` varchar(255) DEFAULT NULL COMMENT '创建时间',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `status` varchar(255) DEFAULT NULL COMMENT '0:显示 1：不显示',
  `msg_type` varchar(255) DEFAULT NULL COMMENT '类型',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `re_content` varchar(255) DEFAULT NULL COMMENT '回复内容',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `s_user_id` varchar(255) DEFAULT NULL COMMENT '收件人',
  `s_user_name` varchar(255) DEFAULT NULL COMMENT '收件人姓名',
  `s_read` varchar(255) DEFAULT NULL COMMENT '收件人是否已读',
  `f_read` varchar(255) DEFAULT NULL COMMENT '发件人是否已读',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='留言板';

#
# Data for table "xy_message"
#

/*!40000 ALTER TABLE `xy_message` DISABLE KEYS */;
INSERT INTO `xy_message` VALUES (1,'123','123',NULL,'carNo1','公司','1523747597',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'carNo1','公司','1','1'),(2,'回复：123','123123',NULL,'carNo1','公司','1523747637',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'carNo1','公司',NULL,NULL);
/*!40000 ALTER TABLE `xy_message` ENABLE KEYS */;

#
# Structure for table "xy_news"
#

DROP TABLE IF EXISTS `xy_news`;
CREATE TABLE `xy_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `user_id` varchar(255) DEFAULT NULL COMMENT '编辑人用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '编辑人姓名',
  `create_time` varchar(255) DEFAULT NULL COMMENT '创建时间',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `status` varchar(255) DEFAULT NULL COMMENT '0:显示 1：不显示',
  `news_type` varchar(255) DEFAULT NULL COMMENT '类型',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `baile` varchar(255) DEFAULT NULL COMMENT '是否置顶',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='新闻公告表';

#
# Data for table "xy_news"
#

/*!40000 ALTER TABLE `xy_news` DISABLE KEYS */;
INSERT INTO `xy_news` VALUES (1,'2014年10月1号，系统正式上线','<p>没有最好，只有更好。</p>',NULL,'1',NULL,'1523744895','1523891717','0','1',NULL,NULL,NULL,NULL,NULL,NULL,'1'),(3,'产品使用注意事项','<p>&nbsp;1.使用产品过程中，注意以下几个细节</p>',NULL,'1',NULL,'1523747773','1523891754','0','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'同学是相濡以沫的挚交','<p><span style=\"color: rgb(51, 51, 51); font-family: Arial, &quot;Helvetica Neue&quot;, Helvetica, &quot;Hiragino Sans GB&quot;, STHeiti, &quot;WenQuanYi Micro Hei&quot;, &quot;Microsoft Yahei&quot;, sans-serif; font-size: 16px; text-indent: 32px;\">光荏苒，光阴',NULL,'1',NULL,'1523891853',NULL,'0','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'踏足着春迹，寻找梦的开始','<p>&nbsp;<img src=\"/Public/Uploads/836ff97443eb59ae8405fdddee4d3e02.jpg\" width=\"400\" height=\"233\" alt=\"\" /><a href=\"http://chuntian.sanwen8.cn/\" target=\"_blank\" style=\"text-decoration-line: none; color: rgb(68, 68, 68); font-family: arial, &quot;Microsoft',NULL,'1',NULL,'1523891940',NULL,'0','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'不要笑，CEO看哭了，有一天互联网会发展成这样','<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 128, 255); font-family: punctuation, 微软雅黑, Tohoma; font-size: 14px; background-color: rgb(36, 99, 157);\">开互联网未来发展趋势第一篇：智能家居</strong></p>\r\n<p><span style=\"background-color: rgb(36, 99, 157); color:',NULL,'1',NULL,'1523892121',NULL,'0','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `xy_news` ENABLE KEYS */;

#
# Structure for table "xy_personbonusdetail"
#

DROP TABLE IF EXISTS `xy_personbonusdetail`;
CREATE TABLE `xy_personbonusdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `money` varchar(255) DEFAULT NULL COMMENT '奖金金额',
  `son_id` varchar(255) DEFAULT NULL COMMENT '产生奖金节点用户名',
  `son_name` varchar(255) DEFAULT NULL COMMENT '产生奖金节点姓名',
  `bonus_type` varchar(255) DEFAULT NULL COMMENT '奖金类型',
  `bz` varchar(255) DEFAULT NULL COMMENT '备注',
  `time` varchar(255) DEFAULT NULL COMMENT '奖金结算时间',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk6` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='个人奖金详细';

#
# Data for table "xy_personbonusdetail"
#

/*!40000 ALTER TABLE `xy_personbonusdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_personbonusdetail` ENABLE KEYS */;

#
# Structure for table "xy_personbonussum"
#

DROP TABLE IF EXISTS `xy_personbonussum`;
CREATE TABLE `xy_personbonussum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `money` varchar(255) DEFAULT NULL COMMENT '总奖金',
  `re_money` varchar(255) DEFAULT NULL COMMENT '推荐奖金',
  `point_money` varchar(255) DEFAULT NULL COMMENT '见点奖',
  `reg_money` varchar(255) DEFAULT NULL COMMENT '报单奖',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='个人奖金汇总表';

#
# Data for table "xy_personbonussum"
#

/*!40000 ALTER TABLE `xy_personbonussum` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_personbonussum` ENABLE KEYS */;

#
# Structure for table "xy_product"
#

DROP TABLE IF EXISTS `xy_product`;
CREATE TABLE `xy_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL COMMENT '上传产品的用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '上传产品的用户姓名',
  `shopName` varchar(255) DEFAULT NULL COMMENT '店名',
  `name` varchar(255) DEFAULT NULL COMMENT '产品名',
  `sell_time` varchar(255) DEFAULT NULL COMMENT '上架时间',
  `price` varchar(255) DEFAULT NULL COMMENT '成本价',
  `sale_price` varchar(255) DEFAULT NULL COMMENT '零售价',
  `whole_sale_price` varchar(255) DEFAULT NULL COMMENT '批发价',
  `vip_price` varchar(255) DEFAULT NULL COMMENT '会员价',
  `img1` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `img2` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `img3` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `img4` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `img5` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `img6` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `stock_count` varchar(255) DEFAULT NULL COMMENT '库存',
  `cptype` varchar(255) DEFAULT NULL COMMENT '产品分类类型',
  `yc_cp` varchar(255) DEFAULT '0' COMMENT '产品是否被屏蔽 0：否 1:是',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `content` varchar(255) DEFAULT NULL COMMENT '商品详情描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='产品表';

#
# Data for table "xy_product"
#

/*!40000 ALTER TABLE `xy_product` DISABLE KEYS */;
INSERT INTO `xy_product` VALUES (4,'aaa','啊三','天猫旗舰店','红牛','1523818127','1','6','4','5','__PUBLIC__/Uploads/image/2018041602483222.jpg',NULL,NULL,NULL,NULL,NULL,'100','2','0',NULL,NULL,NULL,NULL,'<p>&nbsp;活力燃烧！</p>'),(5,'aaa','啊三','京东旗舰店','苹果笔记本','1523818231','2000','8000','5000','6000','__PUBLIC__/Uploads/image/2018041602501566.jpg',NULL,NULL,NULL,NULL,NULL,'100','9','0',NULL,NULL,NULL,NULL,'<p>&nbsp;速度极限！</p>'),(6,'aaa','啊三','华为旗舰店','华为P10','1523818304','1000','2800','2000','2500','__PUBLIC__/Uploads/image/2018041602512917.jpg',NULL,NULL,NULL,NULL,NULL,'200','5','0',NULL,NULL,NULL,NULL,'<p>&nbsp;高清摄像~</p>'),(8,'aaa','啊三','阿迪达斯旗舰店','阿迪达斯酷跑','1523818912','100','500','300','400','__PUBLIC__/Uploads/image/2018041603014782.jpeg',NULL,NULL,NULL,NULL,NULL,'500','7','0',NULL,NULL,NULL,NULL,'');
/*!40000 ALTER TABLE `xy_product` ENABLE KEYS */;

#
# Structure for table "xy_recharge"
#

DROP TABLE IF EXISTS `xy_recharge`;
CREATE TABLE `xy_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `bankid` varchar(255) DEFAULT NULL COMMENT '充值卡号',
  `bank` varchar(255) DEFAULT NULL COMMENT '充值银行',
  `money` varchar(255) DEFAULT NULL COMMENT '充值金额',
  `epoint` varchar(255) DEFAULT NULL COMMENT '到账金额',
  `recharge_time` varchar(255) DEFAULT NULL COMMENT '时间',
  `recharge_type` varchar(255) DEFAULT NULL COMMENT '类型',
  `bz` varchar(255) DEFAULT NULL COMMENT '备注',
  `tel` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `is_pay` varchar(255) DEFAULT NULL COMMENT '0:未支付 1：已支付',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='充值记录表';

#
# Data for table "xy_recharge"
#

/*!40000 ALTER TABLE `xy_recharge` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_recharge` ENABLE KEYS */;

#
# Structure for table "xy_region"
#

DROP TABLE IF EXISTS `xy_region`;
CREATE TABLE `xy_region` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `name` varchar(120) NOT NULL DEFAULT '' COMMENT '地区名字',
  `region_type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '地区类型：0：国家 1：省 2：市 3：区县',
  `agency_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '机构',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`pid`),
  KEY `region_type` (`region_type`),
  KEY `agency_id` (`agency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3409 DEFAULT CHARSET=utf8;

#
# Data for table "xy_region"
#

/*!40000 ALTER TABLE `xy_region` DISABLE KEYS */;
INSERT INTO `xy_region` VALUES (1,0,'中国',0,0),(2,1,'北京',1,0),(3,1,'安徽',1,0),(4,1,'福建',1,0),(5,1,'甘肃',1,0),(6,1,'广东',1,0),(7,1,'广西',1,0),(8,1,'贵州',1,0),(9,1,'海南',1,0),(10,1,'河北',1,0),(11,1,'河南',1,0),(12,1,'黑龙江',1,0),(13,1,'湖北',1,0),(14,1,'湖南',1,0),(15,1,'吉林',1,0),(16,1,'江苏',1,0),(17,1,'江西',1,0),(18,1,'辽宁',1,0),(19,1,'内蒙古',1,0),(20,1,'宁夏',1,0),(21,1,'青海',1,0),(22,1,'山东',1,0),(23,1,'山西',1,0),(24,1,'陕西',1,0),(25,1,'上海',1,0),(26,1,'四川',1,0),(27,1,'天津',1,0),(28,1,'西藏',1,0),(29,1,'新疆',1,0),(30,1,'云南',1,0),(31,1,'浙江',1,0),(32,1,'重庆',1,0),(33,1,'香港',1,0),(34,1,'澳门',1,0),(35,1,'台湾',1,0),(36,3,'安庆',2,0),(37,3,'蚌埠',2,0),(38,3,'巢湖',2,0),(39,3,'池州',2,0),(40,3,'滁州',2,0),(41,3,'阜阳',2,0),(42,3,'淮北',2,0),(43,3,'淮南',2,0),(44,3,'黄山',2,0),(45,3,'六安',2,0),(46,3,'马鞍山',2,0),(47,3,'宿州',2,0),(48,3,'铜陵',2,0),(49,3,'芜湖',2,0),(50,3,'宣城',2,0),(51,3,'亳州',2,0),(52,2,'北京',2,0),(53,4,'福州',2,0),(54,4,'龙岩',2,0),(55,4,'南平',2,0),(56,4,'宁德',2,0),(57,4,'莆田',2,0),(58,4,'泉州',2,0),(59,4,'三明',2,0),(60,4,'厦门',2,0),(61,4,'漳州',2,0),(62,5,'兰州',2,0),(63,5,'白银',2,0),(64,5,'定西',2,0),(65,5,'甘南',2,0),(66,5,'嘉峪关',2,0),(67,5,'金昌',2,0),(68,5,'酒泉',2,0),(69,5,'临夏',2,0),(70,5,'陇南',2,0),(71,5,'平凉',2,0),(72,5,'庆阳',2,0),(73,5,'天水',2,0),(74,5,'武威',2,0),(75,5,'张掖',2,0),(76,6,'广州',2,0),(77,6,'深圳',2,0),(78,6,'潮州',2,0),(79,6,'东莞',2,0),(80,6,'佛山',2,0),(81,6,'河源',2,0),(82,6,'惠州',2,0),(83,6,'江门',2,0),(84,6,'揭阳',2,0),(85,6,'茂名',2,0),(86,6,'梅州',2,0),(87,6,'清远',2,0),(88,6,'汕头',2,0),(89,6,'汕尾',2,0),(90,6,'韶关',2,0),(91,6,'阳江',2,0),(92,6,'云浮',2,0),(93,6,'湛江',2,0),(94,6,'肇庆',2,0),(95,6,'中山',2,0),(96,6,'珠海',2,0),(97,7,'南宁',2,0),(98,7,'桂林',2,0),(99,7,'百色',2,0),(100,7,'北海',2,0),(101,7,'崇左',2,0),(102,7,'防城港',2,0),(103,7,'贵港',2,0),(104,7,'河池',2,0),(105,7,'贺州',2,0),(106,7,'来宾',2,0),(107,7,'柳州',2,0),(108,7,'钦州',2,0),(109,7,'梧州',2,0),(110,7,'玉林',2,0),(111,8,'贵阳',2,0),(112,8,'安顺',2,0),(113,8,'毕节',2,0),(114,8,'六盘水',2,0),(115,8,'黔东南',2,0),(116,8,'黔南',2,0),(117,8,'黔西南',2,0),(118,8,'铜仁',2,0),(119,8,'遵义',2,0),(120,9,'海口',2,0),(121,9,'三亚',2,0),(122,9,'白沙',2,0),(123,9,'保亭',2,0),(124,9,'昌江',2,0),(125,9,'澄迈县',2,0),(126,9,'定安县',2,0),(127,9,'东方',2,0),(128,9,'乐东',2,0),(129,9,'临高县',2,0),(130,9,'陵水',2,0),(131,9,'琼海',2,0),(132,9,'琼中',2,0),(133,9,'屯昌县',2,0),(134,9,'万宁',2,0),(135,9,'文昌',2,0),(136,9,'五指山',2,0),(137,9,'儋州',2,0),(138,10,'石家庄',2,0),(139,10,'保定',2,0),(140,10,'沧州',2,0),(141,10,'承德',2,0),(142,10,'邯郸',2,0),(143,10,'衡水',2,0),(144,10,'廊坊',2,0),(145,10,'秦皇岛',2,0),(146,10,'唐山',2,0),(147,10,'邢台',2,0),(148,10,'张家口',2,0),(149,11,'郑州',2,0),(150,11,'洛阳',2,0),(151,11,'开封',2,0),(152,11,'安阳',2,0),(153,11,'鹤壁',2,0),(154,11,'济源',2,0),(155,11,'焦作',2,0),(156,11,'南阳',2,0),(157,11,'平顶山',2,0),(158,11,'三门峡',2,0),(159,11,'商丘',2,0),(160,11,'新乡',2,0),(161,11,'信阳',2,0),(162,11,'许昌',2,0),(163,11,'周口',2,0),(164,11,'驻马店',2,0),(165,11,'漯河',2,0),(166,11,'濮阳',2,0),(167,12,'哈尔滨',2,0),(168,12,'大庆',2,0),(169,12,'大兴安岭',2,0),(170,12,'鹤岗',2,0),(171,12,'黑河',2,0),(172,12,'鸡西',2,0),(173,12,'佳木斯',2,0),(174,12,'牡丹江',2,0),(175,12,'七台河',2,0),(176,12,'齐齐哈尔',2,0),(177,12,'双鸭山',2,0),(178,12,'绥化',2,0),(179,12,'伊春',2,0),(180,13,'武汉',2,0),(181,13,'仙桃',2,0),(182,13,'鄂州',2,0),(183,13,'黄冈',2,0),(184,13,'黄石',2,0),(185,13,'荆门',2,0),(186,13,'荆州',2,0),(187,13,'潜江',2,0),(188,13,'神农架林区',2,0),(189,13,'十堰',2,0),(190,13,'随州',2,0),(191,13,'天门',2,0),(192,13,'咸宁',2,0),(193,13,'襄樊',2,0),(194,13,'孝感',2,0),(195,13,'宜昌',2,0),(196,13,'恩施',2,0),(197,14,'长沙',2,0),(198,14,'张家界',2,0),(199,14,'常德',2,0),(200,14,'郴州',2,0),(201,14,'衡阳',2,0),(202,14,'怀化',2,0),(203,14,'娄底',2,0),(204,14,'邵阳',2,0),(205,14,'湘潭',2,0),(206,14,'湘西',2,0),(207,14,'益阳',2,0),(208,14,'永州',2,0),(209,14,'岳阳',2,0),(210,14,'株洲',2,0),(211,15,'长春',2,0),(212,15,'吉林',2,0),(213,15,'白城',2,0),(214,15,'白山',2,0),(215,15,'辽源',2,0),(216,15,'四平',2,0),(217,15,'松原',2,0),(218,15,'通化',2,0),(219,15,'延边',2,0),(220,16,'南京',2,0),(221,16,'苏州',2,0),(222,16,'无锡',2,0),(223,16,'常州',2,0),(224,16,'淮安',2,0),(225,16,'连云港',2,0),(226,16,'南通',2,0),(227,16,'宿迁',2,0),(228,16,'泰州',2,0),(229,16,'徐州',2,0),(230,16,'盐城',2,0),(231,16,'扬州',2,0),(232,16,'镇江',2,0),(233,17,'南昌',2,0),(234,17,'抚州',2,0),(235,17,'赣州',2,0),(236,17,'吉安',2,0),(237,17,'景德镇',2,0),(238,17,'九江',2,0),(239,17,'萍乡',2,0),(240,17,'上饶',2,0),(241,17,'新余',2,0),(242,17,'宜春',2,0),(243,17,'鹰潭',2,0),(244,18,'沈阳',2,0),(245,18,'大连',2,0),(246,18,'鞍山',2,0),(247,18,'本溪',2,0),(248,18,'朝阳',2,0),(249,18,'丹东',2,0),(250,18,'抚顺',2,0),(251,18,'阜新',2,0),(252,18,'葫芦岛',2,0),(253,18,'锦州',2,0),(254,18,'辽阳',2,0),(255,18,'盘锦',2,0),(256,18,'铁岭',2,0),(257,18,'营口',2,0),(258,19,'呼和浩特',2,0),(259,19,'阿拉善盟',2,0),(260,19,'巴彦淖尔盟',2,0),(261,19,'包头',2,0),(262,19,'赤峰',2,0),(263,19,'鄂尔多斯',2,0),(264,19,'呼伦贝尔',2,0),(265,19,'通辽',2,0),(266,19,'乌海',2,0),(267,19,'乌兰察布市',2,0),(268,19,'锡林郭勒盟',2,0),(269,19,'兴安盟',2,0),(270,20,'银川',2,0),(271,20,'固原',2,0),(272,20,'石嘴山',2,0),(273,20,'吴忠',2,0),(274,20,'中卫',2,0),(275,21,'西宁',2,0),(276,21,'果洛',2,0),(277,21,'海北',2,0),(278,21,'海东',2,0),(279,21,'海南',2,0),(280,21,'海西',2,0),(281,21,'黄南',2,0),(282,21,'玉树',2,0),(283,22,'济南',2,0),(284,22,'青岛',2,0),(285,22,'滨州',2,0),(286,22,'德州',2,0),(287,22,'东营',2,0),(288,22,'菏泽',2,0),(289,22,'济宁',2,0),(290,22,'莱芜',2,0),(291,22,'聊城',2,0),(292,22,'临沂',2,0),(293,22,'日照',2,0),(294,22,'泰安',2,0),(295,22,'威海',2,0),(296,22,'潍坊',2,0),(297,22,'烟台',2,0),(298,22,'枣庄',2,0),(299,22,'淄博',2,0),(300,23,'太原',2,0),(301,23,'长治',2,0),(302,23,'大同',2,0),(303,23,'晋城',2,0),(304,23,'晋中',2,0),(305,23,'临汾',2,0),(306,23,'吕梁',2,0),(307,23,'朔州',2,0),(308,23,'忻州',2,0),(309,23,'阳泉',2,0),(310,23,'运城',2,0),(311,24,'西安',2,0),(312,24,'安康',2,0),(313,24,'宝鸡',2,0),(314,24,'汉中',2,0),(315,24,'商洛',2,0),(316,24,'铜川',2,0),(317,24,'渭南',2,0),(318,24,'咸阳',2,0),(319,24,'延安',2,0),(320,24,'榆林',2,0),(321,25,'上海',2,0),(322,26,'成都',2,0),(323,26,'绵阳',2,0),(324,26,'阿坝',2,0),(325,26,'巴中',2,0),(326,26,'达州',2,0),(327,26,'德阳',2,0),(328,26,'甘孜',2,0),(329,26,'广安',2,0),(330,26,'广元',2,0),(331,26,'乐山',2,0),(332,26,'凉山',2,0),(333,26,'眉山',2,0),(334,26,'南充',2,0),(335,26,'内江',2,0),(336,26,'攀枝花',2,0),(337,26,'遂宁',2,0),(338,26,'雅安',2,0),(339,26,'宜宾',2,0),(340,26,'资阳',2,0),(341,26,'自贡',2,0),(342,26,'泸州',2,0),(343,27,'天津',2,0),(344,28,'拉萨',2,0),(345,28,'阿里',2,0),(346,28,'昌都',2,0),(347,28,'林芝',2,0),(348,28,'那曲',2,0),(349,28,'日喀则',2,0),(350,28,'山南',2,0),(351,29,'乌鲁木齐',2,0),(352,29,'阿克苏',2,0),(353,29,'阿拉尔',2,0),(354,29,'巴音郭楞',2,0),(355,29,'博尔塔拉',2,0),(356,29,'昌吉',2,0),(357,29,'哈密',2,0),(358,29,'和田',2,0),(359,29,'喀什',2,0),(360,29,'克拉玛依',2,0),(361,29,'克孜勒苏',2,0),(362,29,'石河子',2,0),(363,29,'图木舒克',2,0),(364,29,'吐鲁番',2,0),(365,29,'五家渠',2,0),(366,29,'伊犁',2,0),(367,30,'昆明',2,0),(368,30,'怒江',2,0),(369,30,'普洱',2,0),(370,30,'丽江',2,0),(371,30,'保山',2,0),(372,30,'楚雄',2,0),(373,30,'大理',2,0),(374,30,'德宏',2,0),(375,30,'迪庆',2,0),(376,30,'红河',2,0),(377,30,'临沧',2,0),(378,30,'曲靖',2,0),(379,30,'文山',2,0),(380,30,'西双版纳',2,0),(381,30,'玉溪',2,0),(382,30,'昭通',2,0),(383,31,'杭州',2,0),(384,31,'湖州',2,0),(385,31,'嘉兴',2,0),(386,31,'金华',2,0),(387,31,'丽水',2,0),(388,31,'宁波',2,0),(389,31,'绍兴',2,0),(390,31,'台州',2,0),(391,31,'温州',2,0),(392,31,'舟山',2,0),(393,31,'衢州',2,0),(394,32,'重庆',2,0),(395,33,'香港',2,0),(396,34,'澳门',2,0),(397,35,'台湾',2,0),(398,36,'迎江区',3,0),(399,36,'大观区',3,0),(400,36,'宜秀区',3,0),(401,36,'桐城市',3,0),(402,36,'怀宁县',3,0),(403,36,'枞阳县',3,0),(404,36,'潜山县',3,0),(405,36,'太湖县',3,0),(406,36,'宿松县',3,0),(407,36,'望江县',3,0),(408,36,'岳西县',3,0),(409,37,'中市区',3,0),(410,37,'东市区',3,0),(411,37,'西市区',3,0),(412,37,'郊区',3,0),(413,37,'怀远县',3,0),(414,37,'五河县',3,0),(415,37,'固镇县',3,0),(416,38,'居巢区',3,0),(417,38,'庐江县',3,0),(418,38,'无为县',3,0),(419,38,'含山县',3,0),(420,38,'和县',3,0),(421,39,'贵池区',3,0),(422,39,'东至县',3,0),(423,39,'石台县',3,0),(424,39,'青阳县',3,0),(425,40,'琅琊区',3,0),(426,40,'南谯区',3,0),(427,40,'天长市',3,0),(428,40,'明光市',3,0),(429,40,'来安县',3,0),(430,40,'全椒县',3,0),(431,40,'定远县',3,0),(432,40,'凤阳县',3,0),(433,41,'蚌山区',3,0),(434,41,'龙子湖区',3,0),(435,41,'禹会区',3,0),(436,41,'淮上区',3,0),(437,41,'颍州区',3,0),(438,41,'颍东区',3,0),(439,41,'颍泉区',3,0),(440,41,'界首市',3,0),(441,41,'临泉县',3,0),(442,41,'太和县',3,0),(443,41,'阜南县',3,0),(444,41,'颖上县',3,0),(445,42,'相山区',3,0),(446,42,'杜集区',3,0),(447,42,'烈山区',3,0),(448,42,'濉溪县',3,0),(449,43,'田家庵区',3,0),(450,43,'大通区',3,0),(451,43,'谢家集区',3,0),(452,43,'八公山区',3,0),(453,43,'潘集区',3,0),(454,43,'凤台县',3,0),(455,44,'屯溪区',3,0),(456,44,'黄山区',3,0),(457,44,'徽州区',3,0),(458,44,'歙县',3,0),(459,44,'休宁县',3,0),(460,44,'黟县',3,0),(461,44,'祁门县',3,0),(462,45,'金安区',3,0),(463,45,'裕安区',3,0),(464,45,'寿县',3,0),(465,45,'霍邱县',3,0),(466,45,'舒城县',3,0),(467,45,'金寨县',3,0),(468,45,'霍山县',3,0),(469,46,'雨山区',3,0),(470,46,'花山区',3,0),(471,46,'金家庄区',3,0),(472,46,'当涂县',3,0),(473,47,'埇桥区',3,0),(474,47,'砀山县',3,0),(475,47,'萧县',3,0),(476,47,'灵璧县',3,0),(477,47,'泗县',3,0),(478,48,'铜官山区',3,0),(479,48,'狮子山区',3,0),(480,48,'郊区',3,0),(481,48,'铜陵县',3,0),(482,49,'镜湖区',3,0),(483,49,'弋江区',3,0),(484,49,'鸠江区',3,0),(485,49,'三山区',3,0),(486,49,'芜湖县',3,0),(487,49,'繁昌县',3,0),(488,49,'南陵县',3,0),(489,50,'宣州区',3,0),(490,50,'宁国市',3,0),(491,50,'郎溪县',3,0),(492,50,'广德县',3,0),(493,50,'泾县',3,0),(494,50,'绩溪县',3,0),(495,50,'旌德县',3,0),(496,51,'涡阳县',3,0),(497,51,'蒙城县',3,0),(498,51,'利辛县',3,0),(499,51,'谯城区',3,0),(500,52,'东城区',3,0),(501,52,'西城区',3,0),(502,52,'海淀区',3,0),(503,52,'朝阳区',3,0),(504,52,'崇文区',3,0),(505,52,'宣武区',3,0),(506,52,'丰台区',3,0),(507,52,'石景山区',3,0),(508,52,'房山区',3,0),(509,52,'门头沟区',3,0),(510,52,'通州区',3,0),(511,52,'顺义区',3,0),(512,52,'昌平区',3,0),(513,52,'怀柔区',3,0),(514,52,'平谷区',3,0),(515,52,'大兴区',3,0),(516,52,'密云县',3,0),(517,52,'延庆县',3,0),(518,53,'鼓楼区',3,0),(519,53,'台江区',3,0),(520,53,'仓山区',3,0),(521,53,'马尾区',3,0),(522,53,'晋安区',3,0),(523,53,'福清市',3,0),(524,53,'长乐市',3,0),(525,53,'闽侯县',3,0),(526,53,'连江县',3,0),(527,53,'罗源县',3,0),(528,53,'闽清县',3,0),(529,53,'永泰县',3,0),(530,53,'平潭县',3,0),(531,54,'新罗区',3,0),(532,54,'漳平市',3,0),(533,54,'长汀县',3,0),(534,54,'永定县',3,0),(535,54,'上杭县',3,0),(536,54,'武平县',3,0),(537,54,'连城县',3,0),(538,55,'延平区',3,0),(539,55,'邵武市',3,0),(540,55,'武夷山市',3,0),(541,55,'建瓯市',3,0),(542,55,'建阳市',3,0),(543,55,'顺昌县',3,0),(544,55,'浦城县',3,0),(545,55,'光泽县',3,0),(546,55,'松溪县',3,0),(547,55,'政和县',3,0),(548,56,'蕉城区',3,0),(549,56,'福安市',3,0),(550,56,'福鼎市',3,0),(551,56,'霞浦县',3,0),(552,56,'古田县',3,0),(553,56,'屏南县',3,0),(554,56,'寿宁县',3,0),(555,56,'周宁县',3,0),(556,56,'柘荣县',3,0),(557,57,'城厢区',3,0),(558,57,'涵江区',3,0),(559,57,'荔城区',3,0),(560,57,'秀屿区',3,0),(561,57,'仙游县',3,0),(562,58,'鲤城区',3,0),(563,58,'丰泽区',3,0),(564,58,'洛江区',3,0),(565,58,'清濛开发区',3,0),(566,58,'泉港区',3,0),(567,58,'石狮市',3,0),(568,58,'晋江市',3,0),(569,58,'南安市',3,0),(570,58,'惠安县',3,0),(571,58,'安溪县',3,0),(572,58,'永春县',3,0),(573,58,'德化县',3,0),(574,58,'金门县',3,0),(575,59,'梅列区',3,0),(576,59,'三元区',3,0),(577,59,'永安市',3,0),(578,59,'明溪县',3,0),(579,59,'清流县',3,0),(580,59,'宁化县',3,0),(581,59,'大田县',3,0),(582,59,'尤溪县',3,0),(583,59,'沙县',3,0),(584,59,'将乐县',3,0),(585,59,'泰宁县',3,0),(586,59,'建宁县',3,0),(587,60,'思明区',3,0),(588,60,'海沧区',3,0),(589,60,'湖里区',3,0),(590,60,'集美区',3,0),(591,60,'同安区',3,0),(592,60,'翔安区',3,0),(593,61,'芗城区',3,0),(594,61,'龙文区',3,0),(595,61,'龙海市',3,0),(596,61,'云霄县',3,0),(597,61,'漳浦县',3,0),(598,61,'诏安县',3,0),(599,61,'长泰县',3,0),(600,61,'东山县',3,0),(601,61,'南靖县',3,0),(602,61,'平和县',3,0),(603,61,'华安县',3,0),(604,62,'皋兰县',3,0),(605,62,'城关区',3,0),(606,62,'七里河区',3,0),(607,62,'西固区',3,0),(608,62,'安宁区',3,0),(609,62,'红古区',3,0),(610,62,'永登县',3,0),(611,62,'榆中县',3,0),(612,63,'白银区',3,0),(613,63,'平川区',3,0),(614,63,'会宁县',3,0),(615,63,'景泰县',3,0),(616,63,'靖远县',3,0),(617,64,'临洮县',3,0),(618,64,'陇西县',3,0),(619,64,'通渭县',3,0),(620,64,'渭源县',3,0),(621,64,'漳县',3,0),(622,64,'岷县',3,0),(623,64,'安定区',3,0),(624,64,'安定区',3,0),(625,65,'合作市',3,0),(626,65,'临潭县',3,0),(627,65,'卓尼县',3,0),(628,65,'舟曲县',3,0),(629,65,'迭部县',3,0),(630,65,'玛曲县',3,0),(631,65,'碌曲县',3,0),(632,65,'夏河县',3,0),(633,66,'嘉峪关市',3,0),(634,67,'金川区',3,0),(635,67,'永昌县',3,0),(636,68,'肃州区',3,0),(637,68,'玉门市',3,0),(638,68,'敦煌市',3,0),(639,68,'金塔县',3,0),(640,68,'瓜州县',3,0),(641,68,'肃北',3,0),(642,68,'阿克塞',3,0),(643,69,'临夏市',3,0),(644,69,'临夏县',3,0),(645,69,'康乐县',3,0),(646,69,'永靖县',3,0),(647,69,'广河县',3,0),(648,69,'和政县',3,0),(649,69,'东乡族自治县',3,0),(650,69,'积石山',3,0),(651,70,'成县',3,0),(652,70,'徽县',3,0),(653,70,'康县',3,0),(654,70,'礼县',3,0),(655,70,'两当县',3,0),(656,70,'文县',3,0),(657,70,'西和县',3,0),(658,70,'宕昌县',3,0),(659,70,'武都区',3,0),(660,71,'崇信县',3,0),(661,71,'华亭县',3,0),(662,71,'静宁县',3,0),(663,71,'灵台县',3,0),(664,71,'崆峒区',3,0),(665,71,'庄浪县',3,0),(666,71,'泾川县',3,0),(667,72,'合水县',3,0),(668,72,'华池县',3,0),(669,72,'环县',3,0),(670,72,'宁县',3,0),(671,72,'庆城县',3,0),(672,72,'西峰区',3,0),(673,72,'镇原县',3,0),(674,72,'正宁县',3,0),(675,73,'甘谷县',3,0),(676,73,'秦安县',3,0),(677,73,'清水县',3,0),(678,73,'秦州区',3,0),(679,73,'麦积区',3,0),(680,73,'武山县',3,0),(681,73,'张家川',3,0),(682,74,'古浪县',3,0),(683,74,'民勤县',3,0),(684,74,'天祝',3,0),(685,74,'凉州区',3,0),(686,75,'高台县',3,0),(687,75,'临泽县',3,0),(688,75,'民乐县',3,0),(689,75,'山丹县',3,0),(690,75,'肃南',3,0),(691,75,'甘州区',3,0),(692,76,'从化市',3,0),(693,76,'天河区',3,0),(694,76,'东山区',3,0),(695,76,'白云区',3,0),(696,76,'海珠区',3,0),(697,76,'荔湾区',3,0),(698,76,'越秀区',3,0),(699,76,'黄埔区',3,0),(700,76,'番禺区',3,0),(701,76,'花都区',3,0),(702,76,'增城区',3,0),(703,76,'从化区',3,0),(704,76,'市郊',3,0),(705,77,'福田区',3,0),(706,77,'罗湖区',3,0),(707,77,'南山区',3,0),(708,77,'宝安区',3,0),(709,77,'龙岗区',3,0),(710,77,'盐田区',3,0),(711,78,'湘桥区',3,0),(712,78,'潮安县',3,0),(713,78,'饶平县',3,0),(714,79,'南城区',3,0),(715,79,'东城区',3,0),(716,79,'万江区',3,0),(717,79,'莞城区',3,0),(718,79,'石龙镇',3,0),(719,79,'虎门镇',3,0),(720,79,'麻涌镇',3,0),(721,79,'道滘镇',3,0),(722,79,'石碣镇',3,0),(723,79,'沙田镇',3,0),(724,79,'望牛墩镇',3,0),(725,79,'洪梅镇',3,0),(726,79,'茶山镇',3,0),(727,79,'寮步镇',3,0),(728,79,'大岭山镇',3,0),(729,79,'大朗镇',3,0),(730,79,'黄江镇',3,0),(731,79,'樟木头',3,0),(732,79,'凤岗镇',3,0),(733,79,'塘厦镇',3,0),(734,79,'谢岗镇',3,0),(735,79,'厚街镇',3,0),(736,79,'清溪镇',3,0),(737,79,'常平镇',3,0),(738,79,'桥头镇',3,0),(739,79,'横沥镇',3,0),(740,79,'东坑镇',3,0),(741,79,'企石镇',3,0),(742,79,'石排镇',3,0),(743,79,'长安镇',3,0),(744,79,'中堂镇',3,0),(745,79,'高埗镇',3,0),(746,80,'禅城区',3,0),(747,80,'南海区',3,0),(748,80,'顺德区',3,0),(749,80,'三水区',3,0),(750,80,'高明区',3,0),(751,81,'东源县',3,0),(752,81,'和平县',3,0),(753,81,'源城区',3,0),(754,81,'连平县',3,0),(755,81,'龙川县',3,0),(756,81,'紫金县',3,0),(757,82,'惠阳区',3,0),(758,82,'惠城区',3,0),(759,82,'大亚湾',3,0),(760,82,'博罗县',3,0),(761,82,'惠东县',3,0),(762,82,'龙门县',3,0),(763,83,'江海区',3,0),(764,83,'蓬江区',3,0),(765,83,'新会区',3,0),(766,83,'台山市',3,0),(767,83,'开平市',3,0),(768,83,'鹤山市',3,0),(769,83,'恩平市',3,0),(770,84,'榕城区',3,0),(771,84,'普宁市',3,0),(772,84,'揭东县',3,0),(773,84,'揭西县',3,0),(774,84,'惠来县',3,0),(775,85,'茂南区',3,0),(776,85,'茂港区',3,0),(777,85,'高州市',3,0),(778,85,'化州市',3,0),(779,85,'信宜市',3,0),(780,85,'电白县',3,0),(781,86,'梅县',3,0),(782,86,'梅江区',3,0),(783,86,'兴宁市',3,0),(784,86,'大埔县',3,0),(785,86,'丰顺县',3,0),(786,86,'五华县',3,0),(787,86,'平远县',3,0),(788,86,'蕉岭县',3,0),(789,87,'清城区',3,0),(790,87,'英德市',3,0),(791,87,'连州市',3,0),(792,87,'佛冈县',3,0),(793,87,'阳山县',3,0),(794,87,'清新县',3,0),(795,87,'连山',3,0),(796,87,'连南',3,0),(797,88,'南澳县',3,0),(798,88,'潮阳区',3,0),(799,88,'澄海区',3,0),(800,88,'龙湖区',3,0),(801,88,'金平区',3,0),(802,88,'濠江区',3,0),(803,88,'潮南区',3,0),(804,89,'城区',3,0),(805,89,'陆丰市',3,0),(806,89,'海丰县',3,0),(807,89,'陆河县',3,0),(808,90,'曲江县',3,0),(809,90,'浈江区',3,0),(810,90,'武江区',3,0),(811,90,'曲江区',3,0),(812,90,'乐昌市',3,0),(813,90,'南雄市',3,0),(814,90,'始兴县',3,0),(815,90,'仁化县',3,0),(816,90,'翁源县',3,0),(817,90,'新丰县',3,0),(818,90,'乳源',3,0),(819,91,'江城区',3,0),(820,91,'阳春市',3,0),(821,91,'阳西县',3,0),(822,91,'阳东县',3,0),(823,92,'云城区',3,0),(824,92,'罗定市',3,0),(825,92,'新兴县',3,0),(826,92,'郁南县',3,0),(827,92,'云安县',3,0),(828,93,'赤坎区',3,0),(829,93,'霞山区',3,0),(830,93,'坡头区',3,0),(831,93,'麻章区',3,0),(832,93,'廉江市',3,0),(833,93,'雷州市',3,0),(834,93,'吴川市',3,0),(835,93,'遂溪县',3,0),(836,93,'徐闻县',3,0),(837,94,'肇庆市',3,0),(838,94,'高要市',3,0),(839,94,'四会市',3,0),(840,94,'广宁县',3,0),(841,94,'怀集县',3,0),(842,94,'封开县',3,0),(843,94,'德庆县',3,0),(844,95,'石岐街道',3,0),(845,95,'东区街道',3,0),(846,95,'西区街道',3,0),(847,95,'环城街道',3,0),(848,95,'中山港街道',3,0),(849,95,'五桂山街道',3,0),(850,96,'香洲区',3,0),(851,96,'斗门区',3,0),(852,96,'金湾区',3,0),(853,97,'邕宁区',3,0),(854,97,'青秀区',3,0),(855,97,'兴宁区',3,0),(856,97,'良庆区',3,0),(857,97,'西乡塘区',3,0),(858,97,'江南区',3,0),(859,97,'武鸣县',3,0),(860,97,'隆安县',3,0),(861,97,'马山县',3,0),(862,97,'上林县',3,0),(863,97,'宾阳县',3,0),(864,97,'横县',3,0),(865,98,'秀峰区',3,0),(866,98,'叠彩区',3,0),(867,98,'象山区',3,0),(868,98,'七星区',3,0),(869,98,'雁山区',3,0),(870,98,'阳朔县',3,0),(871,98,'临桂县',3,0),(872,98,'灵川县',3,0),(873,98,'全州县',3,0),(874,98,'平乐县',3,0),(875,98,'兴安县',3,0),(876,98,'灌阳县',3,0),(877,98,'荔浦县',3,0),(878,98,'资源县',3,0),(879,98,'永福县',3,0),(880,98,'龙胜',3,0),(881,98,'恭城',3,0),(882,99,'右江区',3,0),(883,99,'凌云县',3,0),(884,99,'平果县',3,0),(885,99,'西林县',3,0),(886,99,'乐业县',3,0),(887,99,'德保县',3,0),(888,99,'田林县',3,0),(889,99,'田阳县',3,0),(890,99,'靖西县',3,0),(891,99,'田东县',3,0),(892,99,'那坡县',3,0),(893,99,'隆林',3,0),(894,100,'海城区',3,0),(895,100,'银海区',3,0),(896,100,'铁山港区',3,0),(897,100,'合浦县',3,0),(898,101,'江州区',3,0),(899,101,'凭祥市',3,0),(900,101,'宁明县',3,0),(901,101,'扶绥县',3,0),(902,101,'龙州县',3,0),(903,101,'大新县',3,0),(904,101,'天等县',3,0),(905,102,'港口区',3,0),(906,102,'防城区',3,0),(907,102,'东兴市',3,0),(908,102,'上思县',3,0),(909,103,'港北区',3,0),(910,103,'港南区',3,0),(911,103,'覃塘区',3,0),(912,103,'桂平市',3,0),(913,103,'平南县',3,0),(914,104,'金城江区',3,0),(915,104,'宜州市',3,0),(916,104,'天峨县',3,0),(917,104,'凤山县',3,0),(918,104,'南丹县',3,0),(919,104,'东兰县',3,0),(920,104,'都安',3,0),(921,104,'罗城',3,0),(922,104,'巴马',3,0),(923,104,'环江',3,0),(924,104,'大化',3,0),(925,105,'八步区',3,0),(926,105,'钟山县',3,0),(927,105,'昭平县',3,0),(928,105,'富川',3,0),(929,106,'兴宾区',3,0),(930,106,'合山市',3,0),(931,106,'象州县',3,0),(932,106,'武宣县',3,0),(933,106,'忻城县',3,0),(934,106,'金秀',3,0),(935,107,'城中区',3,0),(936,107,'鱼峰区',3,0),(937,107,'柳北区',3,0),(938,107,'柳南区',3,0),(939,107,'柳江县',3,0),(940,107,'柳城县',3,0),(941,107,'鹿寨县',3,0),(942,107,'融安县',3,0),(943,107,'融水',3,0),(944,107,'三江',3,0),(945,108,'钦南区',3,0),(946,108,'钦北区',3,0),(947,108,'灵山县',3,0),(948,108,'浦北县',3,0),(949,109,'万秀区',3,0),(950,109,'蝶山区',3,0),(951,109,'长洲区',3,0),(952,109,'岑溪市',3,0),(953,109,'苍梧县',3,0),(954,109,'藤县',3,0),(955,109,'蒙山县',3,0),(956,110,'玉州区',3,0),(957,110,'北流市',3,0),(958,110,'容县',3,0),(959,110,'陆川县',3,0),(960,110,'博白县',3,0),(961,110,'兴业县',3,0),(962,111,'南明区',3,0),(963,111,'云岩区',3,0),(964,111,'花溪区',3,0),(965,111,'乌当区',3,0),(966,111,'白云区',3,0),(967,111,'小河区',3,0),(968,111,'金阳新区',3,0),(969,111,'新天园区',3,0),(970,111,'清镇市',3,0),(971,111,'开阳县',3,0),(972,111,'修文县',3,0),(973,111,'息烽县',3,0),(974,112,'西秀区',3,0),(975,112,'关岭',3,0),(976,112,'镇宁',3,0),(977,112,'紫云',3,0),(978,112,'平坝县',3,0),(979,112,'普定县',3,0),(980,113,'毕节市',3,0),(981,113,'大方县',3,0),(982,113,'黔西县',3,0),(983,113,'金沙县',3,0),(984,113,'织金县',3,0),(985,113,'纳雍县',3,0),(986,113,'赫章县',3,0),(987,113,'威宁',3,0),(988,114,'钟山区',3,0),(989,114,'六枝特区',3,0),(990,114,'水城县',3,0),(991,114,'盘县',3,0),(992,115,'凯里市',3,0),(993,115,'黄平县',3,0),(994,115,'施秉县',3,0),(995,115,'三穗县',3,0),(996,115,'镇远县',3,0),(997,115,'岑巩县',3,0),(998,115,'天柱县',3,0),(999,115,'锦屏县',3,0),(1000,115,'剑河县',3,0),(1001,115,'台江县',3,0),(1002,115,'黎平县',3,0),(1003,115,'榕江县',3,0),(1004,115,'从江县',3,0),(1005,115,'雷山县',3,0),(1006,115,'麻江县',3,0),(1007,115,'丹寨县',3,0),(1008,116,'都匀市',3,0),(1009,116,'福泉市',3,0),(1010,116,'荔波县',3,0),(1011,116,'贵定县',3,0),(1012,116,'瓮安县',3,0),(1013,116,'独山县',3,0),(1014,116,'平塘县',3,0),(1015,116,'罗甸县',3,0),(1016,116,'长顺县',3,0),(1017,116,'龙里县',3,0),(1018,116,'惠水县',3,0),(1019,116,'三都',3,0),(1020,117,'兴义市',3,0),(1021,117,'兴仁县',3,0),(1022,117,'普安县',3,0),(1023,117,'晴隆县',3,0),(1024,117,'贞丰县',3,0),(1025,117,'望谟县',3,0),(1026,117,'册亨县',3,0),(1027,117,'安龙县',3,0),(1028,118,'铜仁市',3,0),(1029,118,'江口县',3,0),(1030,118,'石阡县',3,0),(1031,118,'思南县',3,0),(1032,118,'德江县',3,0),(1033,118,'玉屏',3,0),(1034,118,'印江',3,0),(1035,118,'沿河',3,0),(1036,118,'松桃',3,0),(1037,118,'万山特区',3,0),(1038,119,'红花岗区',3,0),(1039,119,'务川县',3,0),(1040,119,'道真县',3,0),(1041,119,'汇川区',3,0),(1042,119,'赤水市',3,0),(1043,119,'仁怀市',3,0),(1044,119,'遵义县',3,0),(1045,119,'桐梓县',3,0),(1046,119,'绥阳县',3,0),(1047,119,'正安县',3,0),(1048,119,'凤冈县',3,0),(1049,119,'湄潭县',3,0),(1050,119,'余庆县',3,0),(1051,119,'习水县',3,0),(1052,119,'道真',3,0),(1053,119,'务川',3,0),(1054,120,'秀英区',3,0),(1055,120,'龙华区',3,0),(1056,120,'琼山区',3,0),(1057,120,'美兰区',3,0),(1058,137,'市区',3,0),(1059,137,'洋浦开发区',3,0),(1060,137,'那大镇',3,0),(1061,137,'王五镇',3,0),(1062,137,'雅星镇',3,0),(1063,137,'大成镇',3,0),(1064,137,'中和镇',3,0),(1065,137,'峨蔓镇',3,0),(1066,137,'南丰镇',3,0),(1067,137,'白马井镇',3,0),(1068,137,'兰洋镇',3,0),(1069,137,'和庆镇',3,0),(1070,137,'海头镇',3,0),(1071,137,'排浦镇',3,0),(1072,137,'东成镇',3,0),(1073,137,'光村镇',3,0),(1074,137,'木棠镇',3,0),(1075,137,'新州镇',3,0),(1076,137,'三都镇',3,0),(1077,137,'其他',3,0),(1078,138,'长安区',3,0),(1079,138,'桥东区',3,0),(1080,138,'桥西区',3,0),(1081,138,'新华区',3,0),(1082,138,'裕华区',3,0),(1083,138,'井陉矿区',3,0),(1084,138,'高新区',3,0),(1085,138,'辛集市',3,0),(1086,138,'藁城市',3,0),(1087,138,'晋州市',3,0),(1088,138,'新乐市',3,0),(1089,138,'鹿泉市',3,0),(1090,138,'井陉县',3,0),(1091,138,'正定县',3,0),(1092,138,'栾城县',3,0),(1093,138,'行唐县',3,0),(1094,138,'灵寿县',3,0),(1095,138,'高邑县',3,0),(1096,138,'深泽县',3,0),(1097,138,'赞皇县',3,0),(1098,138,'无极县',3,0),(1099,138,'平山县',3,0),(1100,138,'元氏县',3,0),(1101,138,'赵县',3,0),(1102,139,'新市区',3,0),(1103,139,'南市区',3,0),(1104,139,'北市区',3,0),(1105,139,'涿州市',3,0),(1106,139,'定州市',3,0),(1107,139,'安国市',3,0),(1108,139,'高碑店市',3,0),(1109,139,'满城县',3,0),(1110,139,'清苑县',3,0),(1111,139,'涞水县',3,0),(1112,139,'阜平县',3,0),(1113,139,'徐水县',3,0),(1114,139,'定兴县',3,0),(1115,139,'唐县',3,0),(1116,139,'高阳县',3,0),(1117,139,'容城县',3,0),(1118,139,'涞源县',3,0),(1119,139,'望都县',3,0),(1120,139,'安新县',3,0),(1121,139,'易县',3,0),(1122,139,'曲阳县',3,0),(1123,139,'蠡县',3,0),(1124,139,'顺平县',3,0),(1125,139,'博野县',3,0),(1126,139,'雄县',3,0),(1127,140,'运河区',3,0),(1128,140,'新华区',3,0),(1129,140,'泊头市',3,0),(1130,140,'任丘市',3,0),(1131,140,'黄骅市',3,0),(1132,140,'河间市',3,0),(1133,140,'沧县',3,0),(1134,140,'青县',3,0),(1135,140,'东光县',3,0),(1136,140,'海兴县',3,0),(1137,140,'盐山县',3,0),(1138,140,'肃宁县',3,0),(1139,140,'南皮县',3,0),(1140,140,'吴桥县',3,0),(1141,140,'献县',3,0),(1142,140,'孟村',3,0),(1143,141,'双桥区',3,0),(1144,141,'双滦区',3,0),(1145,141,'鹰手营子矿区',3,0),(1146,141,'承德县',3,0),(1147,141,'兴隆县',3,0),(1148,141,'平泉县',3,0),(1149,141,'滦平县',3,0),(1150,141,'隆化县',3,0),(1151,141,'丰宁',3,0),(1152,141,'宽城',3,0),(1153,141,'围场',3,0),(1154,142,'从台区',3,0),(1155,142,'复兴区',3,0),(1156,142,'邯山区',3,0),(1157,142,'峰峰矿区',3,0),(1158,142,'武安市',3,0),(1159,142,'邯郸县',3,0),(1160,142,'临漳县',3,0),(1161,142,'成安县',3,0),(1162,142,'大名县',3,0),(1163,142,'涉县',3,0),(1164,142,'磁县',3,0),(1165,142,'肥乡县',3,0),(1166,142,'永年县',3,0),(1167,142,'邱县',3,0),(1168,142,'鸡泽县',3,0),(1169,142,'广平县',3,0),(1170,142,'馆陶县',3,0),(1171,142,'魏县',3,0),(1172,142,'曲周县',3,0),(1173,143,'桃城区',3,0),(1174,143,'冀州市',3,0),(1175,143,'深州市',3,0),(1176,143,'枣强县',3,0),(1177,143,'武邑县',3,0),(1178,143,'武强县',3,0),(1179,143,'饶阳县',3,0),(1180,143,'安平县',3,0),(1181,143,'故城县',3,0),(1182,143,'景县',3,0),(1183,143,'阜城县',3,0),(1184,144,'安次区',3,0),(1185,144,'广阳区',3,0),(1186,144,'霸州市',3,0),(1187,144,'三河市',3,0),(1188,144,'固安县',3,0),(1189,144,'永清县',3,0),(1190,144,'香河县',3,0),(1191,144,'大城县',3,0),(1192,144,'文安县',3,0),(1193,144,'大厂',3,0),(1194,145,'海港区',3,0),(1195,145,'山海关区',3,0),(1196,145,'北戴河区',3,0),(1197,145,'昌黎县',3,0),(1198,145,'抚宁县',3,0),(1199,145,'卢龙县',3,0),(1200,145,'青龙',3,0),(1201,146,'路北区',3,0),(1202,146,'路南区',3,0),(1203,146,'古冶区',3,0),(1204,146,'开平区',3,0),(1205,146,'丰南区',3,0),(1206,146,'丰润区',3,0),(1207,146,'遵化市',3,0),(1208,146,'迁安市',3,0),(1209,146,'滦县',3,0),(1210,146,'滦南县',3,0),(1211,146,'乐亭县',3,0),(1212,146,'迁西县',3,0),(1213,146,'玉田县',3,0),(1214,146,'唐海县',3,0),(1215,147,'桥东区',3,0),(1216,147,'桥西区',3,0),(1217,147,'南宫市',3,0),(1218,147,'沙河市',3,0),(1219,147,'邢台县',3,0),(1220,147,'临城县',3,0),(1221,147,'内丘县',3,0),(1222,147,'柏乡县',3,0),(1223,147,'隆尧县',3,0),(1224,147,'任县',3,0),(1225,147,'南和县',3,0),(1226,147,'宁晋县',3,0),(1227,147,'巨鹿县',3,0),(1228,147,'新河县',3,0),(1229,147,'广宗县',3,0),(1230,147,'平乡县',3,0),(1231,147,'威县',3,0),(1232,147,'清河县',3,0),(1233,147,'临西县',3,0),(1234,148,'桥西区',3,0),(1235,148,'桥东区',3,0),(1236,148,'宣化区',3,0),(1237,148,'下花园区',3,0),(1238,148,'宣化县',3,0),(1239,148,'张北县',3,0),(1240,148,'康保县',3,0),(1241,148,'沽源县',3,0),(1242,148,'尚义县',3,0),(1243,148,'蔚县',3,0),(1244,148,'阳原县',3,0),(1245,148,'怀安县',3,0),(1246,148,'万全县',3,0),(1247,148,'怀来县',3,0),(1248,148,'涿鹿县',3,0),(1249,148,'赤城县',3,0),(1250,148,'崇礼县',3,0),(1251,149,'金水区',3,0),(1252,149,'邙山区',3,0),(1253,149,'二七区',3,0),(1254,149,'管城区',3,0),(1255,149,'中原区',3,0),(1256,149,'上街区',3,0),(1257,149,'惠济区',3,0),(1258,149,'郑东新区',3,0),(1259,149,'经济技术开发区',3,0),(1260,149,'高新开发区',3,0),(1261,149,'出口加工区',3,0),(1262,149,'巩义市',3,0),(1263,149,'荥阳市',3,0),(1264,149,'新密市',3,0),(1265,149,'新郑市',3,0),(1266,149,'登封市',3,0),(1267,149,'中牟县',3,0),(1268,150,'西工区',3,0),(1269,150,'老城区',3,0),(1270,150,'涧西区',3,0),(1271,150,'瀍河回族区',3,0),(1272,150,'洛龙区',3,0),(1273,150,'吉利区',3,0),(1274,150,'偃师市',3,0),(1275,150,'孟津县',3,0),(1276,150,'新安县',3,0),(1277,150,'栾川县',3,0),(1278,150,'嵩县',3,0),(1279,150,'汝阳县',3,0),(1280,150,'宜阳县',3,0),(1281,150,'洛宁县',3,0),(1282,150,'伊川县',3,0),(1283,151,'鼓楼区',3,0),(1284,151,'龙亭区',3,0),(1285,151,'顺河回族区',3,0),(1286,151,'金明区',3,0),(1287,151,'禹王台区',3,0),(1288,151,'杞县',3,0),(1289,151,'通许县',3,0),(1290,151,'尉氏县',3,0),(1291,151,'开封县',3,0),(1292,151,'兰考县',3,0),(1293,152,'北关区',3,0),(1294,152,'文峰区',3,0),(1295,152,'殷都区',3,0),(1296,152,'龙安区',3,0),(1297,152,'林州市',3,0),(1298,152,'安阳县',3,0),(1299,152,'汤阴县',3,0),(1300,152,'滑县',3,0),(1301,152,'内黄县',3,0),(1302,153,'淇滨区',3,0),(1303,153,'山城区',3,0),(1304,153,'鹤山区',3,0),(1305,153,'浚县',3,0),(1306,153,'淇县',3,0),(1307,154,'济源市',3,0),(1308,155,'解放区',3,0),(1309,155,'中站区',3,0),(1310,155,'马村区',3,0),(1311,155,'山阳区',3,0),(1312,155,'沁阳市',3,0),(1313,155,'孟州市',3,0),(1314,155,'修武县',3,0),(1315,155,'博爱县',3,0),(1316,155,'武陟县',3,0),(1317,155,'温县',3,0),(1318,156,'卧龙区',3,0),(1319,156,'宛城区',3,0),(1320,156,'邓州市',3,0),(1321,156,'南召县',3,0),(1322,156,'方城县',3,0),(1323,156,'西峡县',3,0),(1324,156,'镇平县',3,0),(1325,156,'内乡县',3,0),(1326,156,'淅川县',3,0),(1327,156,'社旗县',3,0),(1328,156,'唐河县',3,0),(1329,156,'新野县',3,0),(1330,156,'桐柏县',3,0),(1331,157,'新华区',3,0),(1332,157,'卫东区',3,0),(1333,157,'湛河区',3,0),(1334,157,'石龙区',3,0),(1335,157,'舞钢市',3,0),(1336,157,'汝州市',3,0),(1337,157,'宝丰县',3,0),(1338,157,'叶县',3,0),(1339,157,'鲁山县',3,0),(1340,157,'郏县',3,0),(1341,158,'湖滨区',3,0),(1342,158,'义马市',3,0),(1343,158,'灵宝市',3,0),(1344,158,'渑池县',3,0),(1345,158,'陕县',3,0),(1346,158,'卢氏县',3,0),(1347,159,'梁园区',3,0),(1348,159,'睢阳区',3,0),(1349,159,'永城市',3,0),(1350,159,'民权县',3,0),(1351,159,'睢县',3,0),(1352,159,'宁陵县',3,0),(1353,159,'虞城县',3,0),(1354,159,'柘城县',3,0),(1355,159,'夏邑县',3,0),(1356,160,'卫滨区',3,0),(1357,160,'红旗区',3,0),(1358,160,'凤泉区',3,0),(1359,160,'牧野区',3,0),(1360,160,'卫辉市',3,0),(1361,160,'辉县市',3,0),(1362,160,'新乡县',3,0),(1363,160,'获嘉县',3,0),(1364,160,'原阳县',3,0),(1365,160,'延津县',3,0),(1366,160,'封丘县',3,0),(1367,160,'长垣县',3,0),(1368,161,'浉河区',3,0),(1369,161,'平桥区',3,0),(1370,161,'罗山县',3,0),(1371,161,'光山县',3,0),(1372,161,'新县',3,0),(1373,161,'商城县',3,0),(1374,161,'固始县',3,0),(1375,161,'潢川县',3,0),(1376,161,'淮滨县',3,0),(1377,161,'息县',3,0),(1378,162,'魏都区',3,0),(1379,162,'禹州市',3,0),(1380,162,'长葛市',3,0),(1381,162,'许昌县',3,0),(1382,162,'鄢陵县',3,0),(1383,162,'襄城县',3,0),(1384,163,'川汇区',3,0),(1385,163,'项城市',3,0),(1386,163,'扶沟县',3,0),(1387,163,'西华县',3,0),(1388,163,'商水县',3,0),(1389,163,'沈丘县',3,0),(1390,163,'郸城县',3,0),(1391,163,'淮阳县',3,0),(1392,163,'太康县',3,0),(1393,163,'鹿邑县',3,0),(1394,164,'驿城区',3,0),(1395,164,'西平县',3,0),(1396,164,'上蔡县',3,0),(1397,164,'平舆县',3,0),(1398,164,'正阳县',3,0),(1399,164,'确山县',3,0),(1400,164,'泌阳县',3,0),(1401,164,'汝南县',3,0),(1402,164,'遂平县',3,0),(1403,164,'新蔡县',3,0),(1404,165,'郾城区',3,0),(1405,165,'源汇区',3,0),(1406,165,'召陵区',3,0),(1407,165,'舞阳县',3,0),(1408,165,'临颍县',3,0),(1409,166,'华龙区',3,0),(1410,166,'清丰县',3,0),(1411,166,'南乐县',3,0),(1412,166,'范县',3,0),(1413,166,'台前县',3,0),(1414,166,'濮阳县',3,0),(1415,167,'道里区',3,0),(1416,167,'南岗区',3,0),(1417,167,'动力区',3,0),(1418,167,'平房区',3,0),(1419,167,'香坊区',3,0),(1420,167,'太平区',3,0),(1421,167,'道外区',3,0),(1422,167,'阿城区',3,0),(1423,167,'呼兰区',3,0),(1424,167,'松北区',3,0),(1425,167,'尚志市',3,0),(1426,167,'双城市',3,0),(1427,167,'五常市',3,0),(1428,167,'方正县',3,0),(1429,167,'宾县',3,0),(1430,167,'依兰县',3,0),(1431,167,'巴彦县',3,0),(1432,167,'通河县',3,0),(1433,167,'木兰县',3,0),(1434,167,'延寿县',3,0),(1435,168,'萨尔图区',3,0),(1436,168,'红岗区',3,0),(1437,168,'龙凤区',3,0),(1438,168,'让胡路区',3,0),(1439,168,'大同区',3,0),(1440,168,'肇州县',3,0),(1441,168,'肇源县',3,0),(1442,168,'林甸县',3,0),(1443,168,'杜尔伯特',3,0),(1444,169,'呼玛县',3,0),(1445,169,'漠河县',3,0),(1446,169,'塔河县',3,0),(1447,170,'兴山区',3,0),(1448,170,'工农区',3,0),(1449,170,'南山区',3,0),(1450,170,'兴安区',3,0),(1451,170,'向阳区',3,0),(1452,170,'东山区',3,0),(1453,170,'萝北县',3,0),(1454,170,'绥滨县',3,0),(1455,171,'爱辉区',3,0),(1456,171,'五大连池市',3,0),(1457,171,'北安市',3,0),(1458,171,'嫩江县',3,0),(1459,171,'逊克县',3,0),(1460,171,'孙吴县',3,0),(1461,172,'鸡冠区',3,0),(1462,172,'恒山区',3,0),(1463,172,'城子河区',3,0),(1464,172,'滴道区',3,0),(1465,172,'梨树区',3,0),(1466,172,'虎林市',3,0),(1467,172,'密山市',3,0),(1468,172,'鸡东县',3,0),(1469,173,'前进区',3,0),(1470,173,'郊区',3,0),(1471,173,'向阳区',3,0),(1472,173,'东风区',3,0),(1473,173,'同江市',3,0),(1474,173,'富锦市',3,0),(1475,173,'桦南县',3,0),(1476,173,'桦川县',3,0),(1477,173,'汤原县',3,0),(1478,173,'抚远县',3,0),(1479,174,'爱民区',3,0),(1480,174,'东安区',3,0),(1481,174,'阳明区',3,0),(1482,174,'西安区',3,0),(1483,174,'绥芬河市',3,0),(1484,174,'海林市',3,0),(1485,174,'宁安市',3,0),(1486,174,'穆棱市',3,0),(1487,174,'东宁县',3,0),(1488,174,'林口县',3,0),(1489,175,'桃山区',3,0),(1490,175,'新兴区',3,0),(1491,175,'茄子河区',3,0),(1492,175,'勃利县',3,0),(1493,176,'龙沙区',3,0),(1494,176,'昂昂溪区',3,0),(1495,176,'铁峰区',3,0),(1496,176,'建华区',3,0),(1497,176,'富拉尔基区',3,0),(1498,176,'碾子山区',3,0),(1499,176,'梅里斯达斡尔区',3,0),(1500,176,'讷河市',3,0),(1501,176,'龙江县',3,0),(1502,176,'依安县',3,0),(1503,176,'泰来县',3,0),(1504,176,'甘南县',3,0),(1505,176,'富裕县',3,0),(1506,176,'克山县',3,0),(1507,176,'克东县',3,0),(1508,176,'拜泉县',3,0),(1509,177,'尖山区',3,0),(1510,177,'岭东区',3,0),(1511,177,'四方台区',3,0),(1512,177,'宝山区',3,0),(1513,177,'集贤县',3,0),(1514,177,'友谊县',3,0),(1515,177,'宝清县',3,0),(1516,177,'饶河县',3,0),(1517,178,'北林区',3,0),(1518,178,'安达市',3,0),(1519,178,'肇东市',3,0),(1520,178,'海伦市',3,0),(1521,178,'望奎县',3,0),(1522,178,'兰西县',3,0),(1523,178,'青冈县',3,0),(1524,178,'庆安县',3,0),(1525,178,'明水县',3,0),(1526,178,'绥棱县',3,0),(1527,179,'伊春区',3,0),(1528,179,'带岭区',3,0),(1529,179,'南岔区',3,0),(1530,179,'金山屯区',3,0),(1531,179,'西林区',3,0),(1532,179,'美溪区',3,0),(1533,179,'乌马河区',3,0),(1534,179,'翠峦区',3,0),(1535,179,'友好区',3,0),(1536,179,'上甘岭区',3,0),(1537,179,'五营区',3,0),(1538,179,'红星区',3,0),(1539,179,'新青区',3,0),(1540,179,'汤旺河区',3,0),(1541,179,'乌伊岭区',3,0),(1542,179,'铁力市',3,0),(1543,179,'嘉荫县',3,0),(1544,180,'江岸区',3,0),(1545,180,'武昌区',3,0),(1546,180,'江汉区',3,0),(1547,180,'硚口区',3,0),(1548,180,'汉阳区',3,0),(1549,180,'青山区',3,0),(1550,180,'洪山区',3,0),(1551,180,'东西湖区',3,0),(1552,180,'汉南区',3,0),(1553,180,'蔡甸区',3,0),(1554,180,'江夏区',3,0),(1555,180,'黄陂区',3,0),(1556,180,'新洲区',3,0),(1557,180,'经济开发区',3,0),(1558,181,'仙桃市',3,0),(1559,182,'鄂城区',3,0),(1560,182,'华容区',3,0),(1561,182,'梁子湖区',3,0),(1562,183,'黄州区',3,0),(1563,183,'麻城市',3,0),(1564,183,'武穴市',3,0),(1565,183,'团风县',3,0),(1566,183,'红安县',3,0),(1567,183,'罗田县',3,0),(1568,183,'英山县',3,0),(1569,183,'浠水县',3,0),(1570,183,'蕲春县',3,0),(1571,183,'黄梅县',3,0),(1572,184,'黄石港区',3,0),(1573,184,'西塞山区',3,0),(1574,184,'下陆区',3,0),(1575,184,'铁山区',3,0),(1576,184,'大冶市',3,0),(1577,184,'阳新县',3,0),(1578,185,'东宝区',3,0),(1579,185,'掇刀区',3,0),(1580,185,'钟祥市',3,0),(1581,185,'京山县',3,0),(1582,185,'沙洋县',3,0),(1583,186,'沙市区',3,0),(1584,186,'荆州区',3,0),(1585,186,'石首市',3,0),(1586,186,'洪湖市',3,0),(1587,186,'松滋市',3,0),(1588,186,'公安县',3,0),(1589,186,'监利县',3,0),(1590,186,'江陵县',3,0),(1591,187,'潜江市',3,0),(1592,188,'神农架林区',3,0),(1593,189,'张湾区',3,0),(1594,189,'茅箭区',3,0),(1595,189,'丹江口市',3,0),(1596,189,'郧县',3,0),(1597,189,'郧西县',3,0),(1598,189,'竹山县',3,0),(1599,189,'竹溪县',3,0),(1600,189,'房县',3,0),(1601,190,'曾都区',3,0),(1602,190,'广水市',3,0),(1603,191,'天门市',3,0),(1604,192,'咸安区',3,0),(1605,192,'赤壁市',3,0),(1606,192,'嘉鱼县',3,0),(1607,192,'通城县',3,0),(1608,192,'崇阳县',3,0),(1609,192,'通山县',3,0),(1610,193,'襄城区',3,0),(1611,193,'樊城区',3,0),(1612,193,'襄阳区',3,0),(1613,193,'老河口市',3,0),(1614,193,'枣阳市',3,0),(1615,193,'宜城市',3,0),(1616,193,'南漳县',3,0),(1617,193,'谷城县',3,0),(1618,193,'保康县',3,0),(1619,194,'孝南区',3,0),(1620,194,'应城市',3,0),(1621,194,'安陆市',3,0),(1622,194,'汉川市',3,0),(1623,194,'孝昌县',3,0),(1624,194,'大悟县',3,0),(1625,194,'云梦县',3,0),(1626,195,'长阳',3,0),(1627,195,'五峰',3,0),(1628,195,'西陵区',3,0),(1629,195,'伍家岗区',3,0),(1630,195,'点军区',3,0),(1631,195,'猇亭区',3,0),(1632,195,'夷陵区',3,0),(1633,195,'宜都市',3,0),(1634,195,'当阳市',3,0),(1635,195,'枝江市',3,0),(1636,195,'远安县',3,0),(1637,195,'兴山县',3,0),(1638,195,'秭归县',3,0),(1639,196,'恩施市',3,0),(1640,196,'利川市',3,0),(1641,196,'建始县',3,0),(1642,196,'巴东县',3,0),(1643,196,'宣恩县',3,0),(1644,196,'咸丰县',3,0),(1645,196,'来凤县',3,0),(1646,196,'鹤峰县',3,0),(1647,197,'岳麓区',3,0),(1648,197,'芙蓉区',3,0),(1649,197,'天心区',3,0),(1650,197,'开福区',3,0),(1651,197,'雨花区',3,0),(1652,197,'开发区',3,0),(1653,197,'浏阳市',3,0),(1654,197,'长沙县',3,0),(1655,197,'望城县',3,0),(1656,197,'宁乡县',3,0),(1657,198,'永定区',3,0),(1658,198,'武陵源区',3,0),(1659,198,'慈利县',3,0),(1660,198,'桑植县',3,0),(1661,199,'武陵区',3,0),(1662,199,'鼎城区',3,0),(1663,199,'津市市',3,0),(1664,199,'安乡县',3,0),(1665,199,'汉寿县',3,0),(1666,199,'澧县',3,0),(1667,199,'临澧县',3,0),(1668,199,'桃源县',3,0),(1669,199,'石门县',3,0),(1670,200,'北湖区',3,0),(1671,200,'苏仙区',3,0),(1672,200,'资兴市',3,0),(1673,200,'桂阳县',3,0),(1674,200,'宜章县',3,0),(1675,200,'永兴县',3,0),(1676,200,'嘉禾县',3,0),(1677,200,'临武县',3,0),(1678,200,'汝城县',3,0),(1679,200,'桂东县',3,0),(1680,200,'安仁县',3,0),(1681,201,'雁峰区',3,0),(1682,201,'珠晖区',3,0),(1683,201,'石鼓区',3,0),(1684,201,'蒸湘区',3,0),(1685,201,'南岳区',3,0),(1686,201,'耒阳市',3,0),(1687,201,'常宁市',3,0),(1688,201,'衡阳县',3,0),(1689,201,'衡南县',3,0),(1690,201,'衡山县',3,0),(1691,201,'衡东县',3,0),(1692,201,'祁东县',3,0),(1693,202,'鹤城区',3,0),(1694,202,'靖州',3,0),(1695,202,'麻阳',3,0),(1696,202,'通道',3,0),(1697,202,'新晃',3,0),(1698,202,'芷江',3,0),(1699,202,'沅陵县',3,0),(1700,202,'辰溪县',3,0),(1701,202,'溆浦县',3,0),(1702,202,'中方县',3,0),(1703,202,'会同县',3,0),(1704,202,'洪江市',3,0),(1705,203,'娄星区',3,0),(1706,203,'冷水江市',3,0),(1707,203,'涟源市',3,0),(1708,203,'双峰县',3,0),(1709,203,'新化县',3,0),(1710,204,'城步',3,0),(1711,204,'双清区',3,0),(1712,204,'大祥区',3,0),(1713,204,'北塔区',3,0),(1714,204,'武冈市',3,0),(1715,204,'邵东县',3,0),(1716,204,'新邵县',3,0),(1717,204,'邵阳县',3,0),(1718,204,'隆回县',3,0),(1719,204,'洞口县',3,0),(1720,204,'绥宁县',3,0),(1721,204,'新宁县',3,0),(1722,205,'岳塘区',3,0),(1723,205,'雨湖区',3,0),(1724,205,'湘乡市',3,0),(1725,205,'韶山市',3,0),(1726,205,'湘潭县',3,0),(1727,206,'吉首市',3,0),(1728,206,'泸溪县',3,0),(1729,206,'凤凰县',3,0),(1730,206,'花垣县',3,0),(1731,206,'保靖县',3,0),(1732,206,'古丈县',3,0),(1733,206,'永顺县',3,0),(1734,206,'龙山县',3,0),(1735,207,'赫山区',3,0),(1736,207,'资阳区',3,0),(1737,207,'沅江市',3,0),(1738,207,'南县',3,0),(1739,207,'桃江县',3,0),(1740,207,'安化县',3,0),(1741,208,'江华',3,0),(1742,208,'冷水滩区',3,0),(1743,208,'零陵区',3,0),(1744,208,'祁阳县',3,0),(1745,208,'东安县',3,0),(1746,208,'双牌县',3,0),(1747,208,'道县',3,0),(1748,208,'江永县',3,0),(1749,208,'宁远县',3,0),(1750,208,'蓝山县',3,0),(1751,208,'新田县',3,0),(1752,209,'岳阳楼区',3,0),(1753,209,'君山区',3,0),(1754,209,'云溪区',3,0),(1755,209,'汨罗市',3,0),(1756,209,'临湘市',3,0),(1757,209,'岳阳县',3,0),(1758,209,'华容县',3,0),(1759,209,'湘阴县',3,0),(1760,209,'平江县',3,0),(1761,210,'天元区',3,0),(1762,210,'荷塘区',3,0),(1763,210,'芦淞区',3,0),(1764,210,'石峰区',3,0),(1765,210,'醴陵市',3,0),(1766,210,'株洲县',3,0),(1767,210,'攸县',3,0),(1768,210,'茶陵县',3,0),(1769,210,'炎陵县',3,0),(1770,211,'朝阳区',3,0),(1771,211,'宽城区',3,0),(1772,211,'二道区',3,0),(1773,211,'南关区',3,0),(1774,211,'绿园区',3,0),(1775,211,'双阳区',3,0),(1776,211,'净月潭开发区',3,0),(1777,211,'高新技术开发区',3,0),(1778,211,'经济技术开发区',3,0),(1779,211,'汽车产业开发区',3,0),(1780,211,'德惠市',3,0),(1781,211,'九台市',3,0),(1782,211,'榆树市',3,0),(1783,211,'农安县',3,0),(1784,212,'船营区',3,0),(1785,212,'昌邑区',3,0),(1786,212,'龙潭区',3,0),(1787,212,'丰满区',3,0),(1788,212,'蛟河市',3,0),(1789,212,'桦甸市',3,0),(1790,212,'舒兰市',3,0),(1791,212,'磐石市',3,0),(1792,212,'永吉县',3,0),(1793,213,'洮北区',3,0),(1794,213,'洮南市',3,0),(1795,213,'大安市',3,0),(1796,213,'镇赉县',3,0),(1797,213,'通榆县',3,0),(1798,214,'江源区',3,0),(1799,214,'八道江区',3,0),(1800,214,'长白',3,0),(1801,214,'临江市',3,0),(1802,214,'抚松县',3,0),(1803,214,'靖宇县',3,0),(1804,215,'龙山区',3,0),(1805,215,'西安区',3,0),(1806,215,'东丰县',3,0),(1807,215,'东辽县',3,0),(1808,216,'铁西区',3,0),(1809,216,'铁东区',3,0),(1810,216,'伊通',3,0),(1811,216,'公主岭市',3,0),(1812,216,'双辽市',3,0),(1813,216,'梨树县',3,0),(1814,217,'前郭尔罗斯',3,0),(1815,217,'宁江区',3,0),(1816,217,'长岭县',3,0),(1817,217,'乾安县',3,0),(1818,217,'扶余县',3,0),(1819,218,'东昌区',3,0),(1820,218,'二道江区',3,0),(1821,218,'梅河口市',3,0),(1822,218,'集安市',3,0),(1823,218,'通化县',3,0),(1824,218,'辉南县',3,0),(1825,218,'柳河县',3,0),(1826,219,'延吉市',3,0),(1827,219,'图们市',3,0),(1828,219,'敦化市',3,0),(1829,219,'珲春市',3,0),(1830,219,'龙井市',3,0),(1831,219,'和龙市',3,0),(1832,219,'安图县',3,0),(1833,219,'汪清县',3,0),(1834,220,'玄武区',3,0),(1835,220,'鼓楼区',3,0),(1836,220,'白下区',3,0),(1837,220,'建邺区',3,0),(1838,220,'秦淮区',3,0),(1839,220,'雨花台区',3,0),(1840,220,'下关区',3,0),(1841,220,'栖霞区',3,0),(1842,220,'浦口区',3,0),(1843,220,'江宁区',3,0),(1844,220,'六合区',3,0),(1845,220,'溧水县',3,0),(1846,220,'高淳县',3,0),(1847,221,'沧浪区',3,0),(1848,221,'金阊区',3,0),(1849,221,'平江区',3,0),(1850,221,'虎丘区',3,0),(1851,221,'吴中区',3,0),(1852,221,'相城区',3,0),(1853,221,'园区',3,0),(1854,221,'新区',3,0),(1855,221,'常熟市',3,0),(1856,221,'张家港市',3,0),(1857,221,'玉山镇',3,0),(1858,221,'巴城镇',3,0),(1859,221,'周市镇',3,0),(1860,221,'陆家镇',3,0),(1861,221,'花桥镇',3,0),(1862,221,'淀山湖镇',3,0),(1863,221,'张浦镇',3,0),(1864,221,'周庄镇',3,0),(1865,221,'千灯镇',3,0),(1866,221,'锦溪镇',3,0),(1867,221,'开发区',3,0),(1868,221,'吴江市',3,0),(1869,221,'太仓市',3,0),(1870,222,'崇安区',3,0),(1871,222,'北塘区',3,0),(1872,222,'南长区',3,0),(1873,222,'锡山区',3,0),(1874,222,'惠山区',3,0),(1875,222,'滨湖区',3,0),(1876,222,'新区',3,0),(1877,222,'江阴市',3,0),(1878,222,'宜兴市',3,0),(1879,223,'天宁区',3,0),(1880,223,'钟楼区',3,0),(1881,223,'戚墅堰区',3,0),(1882,223,'郊区',3,0),(1883,223,'新北区',3,0),(1884,223,'武进区',3,0),(1885,223,'溧阳市',3,0),(1886,223,'金坛市',3,0),(1887,224,'清河区',3,0),(1888,224,'清浦区',3,0),(1889,224,'楚州区',3,0),(1890,224,'淮阴区',3,0),(1891,224,'涟水县',3,0),(1892,224,'洪泽县',3,0),(1893,224,'盱眙县',3,0),(1894,224,'金湖县',3,0),(1895,225,'新浦区',3,0),(1896,225,'连云区',3,0),(1897,225,'海州区',3,0),(1898,225,'赣榆县',3,0),(1899,225,'东海县',3,0),(1900,225,'灌云县',3,0),(1901,225,'灌南县',3,0),(1902,226,'崇川区',3,0),(1903,226,'港闸区',3,0),(1904,226,'经济开发区',3,0),(1905,226,'启东市',3,0),(1906,226,'如皋市',3,0),(1907,226,'通州市',3,0),(1908,226,'海门市',3,0),(1909,226,'海安县',3,0),(1910,226,'如东县',3,0),(1911,227,'宿城区',3,0),(1912,227,'宿豫区',3,0),(1913,227,'宿豫县',3,0),(1914,227,'沭阳县',3,0),(1915,227,'泗阳县',3,0),(1916,227,'泗洪县',3,0),(1917,228,'海陵区',3,0),(1918,228,'高港区',3,0),(1919,228,'兴化市',3,0),(1920,228,'靖江市',3,0),(1921,228,'泰兴市',3,0),(1922,228,'姜堰市',3,0),(1923,229,'云龙区',3,0),(1924,229,'鼓楼区',3,0),(1925,229,'九里区',3,0),(1926,229,'贾汪区',3,0),(1927,229,'泉山区',3,0),(1928,229,'新沂市',3,0),(1929,229,'邳州市',3,0),(1930,229,'丰县',3,0),(1931,229,'沛县',3,0),(1932,229,'铜山县',3,0),(1933,229,'睢宁县',3,0),(1934,230,'城区',3,0),(1935,230,'亭湖区',3,0),(1936,230,'盐都区',3,0),(1937,230,'盐都县',3,0),(1938,230,'东台市',3,0),(1939,230,'大丰市',3,0),(1940,230,'响水县',3,0),(1941,230,'滨海县',3,0),(1942,230,'阜宁县',3,0),(1943,230,'射阳县',3,0),(1944,230,'建湖县',3,0),(1945,231,'广陵区',3,0),(1946,231,'维扬区',3,0),(1947,231,'邗江区',3,0),(1948,231,'仪征市',3,0),(1949,231,'高邮市',3,0),(1950,231,'江都市',3,0),(1951,231,'宝应县',3,0),(1952,232,'京口区',3,0),(1953,232,'润州区',3,0),(1954,232,'丹徒区',3,0),(1955,232,'丹阳市',3,0),(1956,232,'扬中市',3,0),(1957,232,'句容市',3,0),(1958,233,'东湖区',3,0),(1959,233,'西湖区',3,0),(1960,233,'青云谱区',3,0),(1961,233,'湾里区',3,0),(1962,233,'青山湖区',3,0),(1963,233,'红谷滩新区',3,0),(1964,233,'昌北区',3,0),(1965,233,'高新区',3,0),(1966,233,'南昌县',3,0),(1967,233,'新建县',3,0),(1968,233,'安义县',3,0),(1969,233,'进贤县',3,0),(1970,234,'临川区',3,0),(1971,234,'南城县',3,0),(1972,234,'黎川县',3,0),(1973,234,'南丰县',3,0),(1974,234,'崇仁县',3,0),(1975,234,'乐安县',3,0),(1976,234,'宜黄县',3,0),(1977,234,'金溪县',3,0),(1978,234,'资溪县',3,0),(1979,234,'东乡县',3,0),(1980,234,'广昌县',3,0),(1981,235,'章贡区',3,0),(1982,235,'于都县',3,0),(1983,235,'瑞金市',3,0),(1984,235,'南康市',3,0),(1985,235,'赣县',3,0),(1986,235,'信丰县',3,0),(1987,235,'大余县',3,0),(1988,235,'上犹县',3,0),(1989,235,'崇义县',3,0),(1990,235,'安远县',3,0),(1991,235,'龙南县',3,0),(1992,235,'定南县',3,0),(1993,235,'全南县',3,0),(1994,235,'宁都县',3,0),(1995,235,'兴国县',3,0),(1996,235,'会昌县',3,0),(1997,235,'寻乌县',3,0),(1998,235,'石城县',3,0),(1999,236,'安福县',3,0),(2000,236,'吉州区',3,0),(2001,236,'青原区',3,0),(2002,236,'井冈山市',3,0),(2003,236,'吉安县',3,0),(2004,236,'吉水县',3,0),(2005,236,'峡江县',3,0),(2006,236,'新干县',3,0),(2007,236,'永丰县',3,0),(2008,236,'泰和县',3,0),(2009,236,'遂川县',3,0),(2010,236,'万安县',3,0),(2011,236,'永新县',3,0),(2012,237,'珠山区',3,0),(2013,237,'昌江区',3,0),(2014,237,'乐平市',3,0),(2015,237,'浮梁县',3,0),(2016,238,'浔阳区',3,0),(2017,238,'庐山区',3,0),(2018,238,'瑞昌市',3,0),(2019,238,'九江县',3,0),(2020,238,'武宁县',3,0),(2021,238,'修水县',3,0),(2022,238,'永修县',3,0),(2023,238,'德安县',3,0),(2024,238,'星子县',3,0),(2025,238,'都昌县',3,0),(2026,238,'湖口县',3,0),(2027,238,'彭泽县',3,0),(2028,239,'安源区',3,0),(2029,239,'湘东区',3,0),(2030,239,'莲花县',3,0),(2031,239,'芦溪县',3,0),(2032,239,'上栗县',3,0),(2033,240,'信州区',3,0),(2034,240,'德兴市',3,0),(2035,240,'上饶县',3,0),(2036,240,'广丰县',3,0),(2037,240,'玉山县',3,0),(2038,240,'铅山县',3,0),(2039,240,'横峰县',3,0),(2040,240,'弋阳县',3,0),(2041,240,'余干县',3,0),(2042,240,'波阳县',3,0),(2043,240,'万年县',3,0),(2044,240,'婺源县',3,0),(2045,241,'渝水区',3,0),(2046,241,'分宜县',3,0),(2047,242,'袁州区',3,0),(2048,242,'丰城市',3,0),(2049,242,'樟树市',3,0),(2050,242,'高安市',3,0),(2051,242,'奉新县',3,0),(2052,242,'万载县',3,0),(2053,242,'上高县',3,0),(2054,242,'宜丰县',3,0),(2055,242,'靖安县',3,0),(2056,242,'铜鼓县',3,0),(2057,243,'月湖区',3,0),(2058,243,'贵溪市',3,0),(2059,243,'余江县',3,0),(2060,244,'沈河区',3,0),(2061,244,'皇姑区',3,0),(2062,244,'和平区',3,0),(2063,244,'大东区',3,0),(2064,244,'铁西区',3,0),(2065,244,'苏家屯区',3,0),(2066,244,'东陵区',3,0),(2067,244,'沈北新区',3,0),(2068,244,'于洪区',3,0),(2069,244,'浑南新区',3,0),(2070,244,'新民市',3,0),(2071,244,'辽中县',3,0),(2072,244,'康平县',3,0),(2073,244,'法库县',3,0),(2074,245,'西岗区',3,0),(2075,245,'中山区',3,0),(2076,245,'沙河口区',3,0),(2077,245,'甘井子区',3,0),(2078,245,'旅顺口区',3,0),(2079,245,'金州区',3,0),(2080,245,'开发区',3,0),(2081,245,'瓦房店市',3,0),(2082,245,'普兰店市',3,0),(2083,245,'庄河市',3,0),(2084,245,'长海县',3,0),(2085,246,'铁东区',3,0),(2086,246,'铁西区',3,0),(2087,246,'立山区',3,0),(2088,246,'千山区',3,0),(2089,246,'岫岩',3,0),(2090,246,'海城市',3,0),(2091,246,'台安县',3,0),(2092,247,'本溪',3,0),(2093,247,'平山区',3,0),(2094,247,'明山区',3,0),(2095,247,'溪湖区',3,0),(2096,247,'南芬区',3,0),(2097,247,'桓仁',3,0),(2098,248,'双塔区',3,0),(2099,248,'龙城区',3,0),(2100,248,'喀喇沁左翼蒙古族自治县',3,0),(2101,248,'北票市',3,0),(2102,248,'凌源市',3,0),(2103,248,'朝阳县',3,0),(2104,248,'建平县',3,0),(2105,249,'振兴区',3,0),(2106,249,'元宝区',3,0),(2107,249,'振安区',3,0),(2108,249,'宽甸',3,0),(2109,249,'东港市',3,0),(2110,249,'凤城市',3,0),(2111,250,'顺城区',3,0),(2112,250,'新抚区',3,0),(2113,250,'东洲区',3,0),(2114,250,'望花区',3,0),(2115,250,'清原',3,0),(2116,250,'新宾',3,0),(2117,250,'抚顺县',3,0),(2118,251,'阜新',3,0),(2119,251,'海州区',3,0),(2120,251,'新邱区',3,0),(2121,251,'太平区',3,0),(2122,251,'清河门区',3,0),(2123,251,'细河区',3,0),(2124,251,'彰武县',3,0),(2125,252,'龙港区',3,0),(2126,252,'南票区',3,0),(2127,252,'连山区',3,0),(2128,252,'兴城市',3,0),(2129,252,'绥中县',3,0),(2130,252,'建昌县',3,0),(2131,253,'太和区',3,0),(2132,253,'古塔区',3,0),(2133,253,'凌河区',3,0),(2134,253,'凌海市',3,0),(2135,253,'北镇市',3,0),(2136,253,'黑山县',3,0),(2137,253,'义县',3,0),(2138,254,'白塔区',3,0),(2139,254,'文圣区',3,0),(2140,254,'宏伟区',3,0),(2141,254,'太子河区',3,0),(2142,254,'弓长岭区',3,0),(2143,254,'灯塔市',3,0),(2144,254,'辽阳县',3,0),(2145,255,'双台子区',3,0),(2146,255,'兴隆台区',3,0),(2147,255,'大洼县',3,0),(2148,255,'盘山县',3,0),(2149,256,'银州区',3,0),(2150,256,'清河区',3,0),(2151,256,'调兵山市',3,0),(2152,256,'开原市',3,0),(2153,256,'铁岭县',3,0),(2154,256,'西丰县',3,0),(2155,256,'昌图县',3,0),(2156,257,'站前区',3,0),(2157,257,'西市区',3,0),(2158,257,'鲅鱼圈区',3,0),(2159,257,'老边区',3,0),(2160,257,'盖州市',3,0),(2161,257,'大石桥市',3,0),(2162,258,'回民区',3,0),(2163,258,'玉泉区',3,0),(2164,258,'新城区',3,0),(2165,258,'赛罕区',3,0),(2166,258,'清水河县',3,0),(2167,258,'土默特左旗',3,0),(2168,258,'托克托县',3,0),(2169,258,'和林格尔县',3,0),(2170,258,'武川县',3,0),(2171,259,'阿拉善左旗',3,0),(2172,259,'阿拉善右旗',3,0),(2173,259,'额济纳旗',3,0),(2174,260,'临河区',3,0),(2175,260,'五原县',3,0),(2176,260,'磴口县',3,0),(2177,260,'乌拉特前旗',3,0),(2178,260,'乌拉特中旗',3,0),(2179,260,'乌拉特后旗',3,0),(2180,260,'杭锦后旗',3,0),(2181,261,'昆都仑区',3,0),(2182,261,'青山区',3,0),(2183,261,'东河区',3,0),(2184,261,'九原区',3,0),(2185,261,'石拐区',3,0),(2186,261,'白云矿区',3,0),(2187,261,'土默特右旗',3,0),(2188,261,'固阳县',3,0),(2189,261,'达尔罕茂明安联合旗',3,0),(2190,262,'红山区',3,0),(2191,262,'元宝山区',3,0),(2192,262,'松山区',3,0),(2193,262,'阿鲁科尔沁旗',3,0),(2194,262,'巴林左旗',3,0),(2195,262,'巴林右旗',3,0),(2196,262,'林西县',3,0),(2197,262,'克什克腾旗',3,0),(2198,262,'翁牛特旗',3,0),(2199,262,'喀喇沁旗',3,0),(2200,262,'宁城县',3,0),(2201,262,'敖汉旗',3,0),(2202,263,'东胜区',3,0),(2203,263,'达拉特旗',3,0),(2204,263,'准格尔旗',3,0),(2205,263,'鄂托克前旗',3,0),(2206,263,'鄂托克旗',3,0),(2207,263,'杭锦旗',3,0),(2208,263,'乌审旗',3,0),(2209,263,'伊金霍洛旗',3,0),(2210,264,'海拉尔区',3,0),(2211,264,'莫力达瓦',3,0),(2212,264,'满洲里市',3,0),(2213,264,'牙克石市',3,0),(2214,264,'扎兰屯市',3,0),(2215,264,'额尔古纳市',3,0),(2216,264,'根河市',3,0),(2217,264,'阿荣旗',3,0),(2218,264,'鄂伦春自治旗',3,0),(2219,264,'鄂温克族自治旗',3,0),(2220,264,'陈巴尔虎旗',3,0),(2221,264,'新巴尔虎左旗',3,0),(2222,264,'新巴尔虎右旗',3,0),(2223,265,'科尔沁区',3,0),(2224,265,'霍林郭勒市',3,0),(2225,265,'科尔沁左翼中旗',3,0),(2226,265,'科尔沁左翼后旗',3,0),(2227,265,'开鲁县',3,0),(2228,265,'库伦旗',3,0),(2229,265,'奈曼旗',3,0),(2230,265,'扎鲁特旗',3,0),(2231,266,'海勃湾区',3,0),(2232,266,'乌达区',3,0),(2233,266,'海南区',3,0),(2234,267,'化德县',3,0),(2235,267,'集宁区',3,0),(2236,267,'丰镇市',3,0),(2237,267,'卓资县',3,0),(2238,267,'商都县',3,0),(2239,267,'兴和县',3,0),(2240,267,'凉城县',3,0),(2241,267,'察哈尔右翼前旗',3,0),(2242,267,'察哈尔右翼中旗',3,0),(2243,267,'察哈尔右翼后旗',3,0),(2244,267,'四子王旗',3,0),(2245,268,'二连浩特市',3,0),(2246,268,'锡林浩特市',3,0),(2247,268,'阿巴嘎旗',3,0),(2248,268,'苏尼特左旗',3,0),(2249,268,'苏尼特右旗',3,0),(2250,268,'东乌珠穆沁旗',3,0),(2251,268,'西乌珠穆沁旗',3,0),(2252,268,'太仆寺旗',3,0),(2253,268,'镶黄旗',3,0),(2254,268,'正镶白旗',3,0),(2255,268,'正蓝旗',3,0),(2256,268,'多伦县',3,0),(2257,269,'乌兰浩特市',3,0),(2258,269,'阿尔山市',3,0),(2259,269,'科尔沁右翼前旗',3,0),(2260,269,'科尔沁右翼中旗',3,0),(2261,269,'扎赉特旗',3,0),(2262,269,'突泉县',3,0),(2263,270,'西夏区',3,0),(2264,270,'金凤区',3,0),(2265,270,'兴庆区',3,0),(2266,270,'灵武市',3,0),(2267,270,'永宁县',3,0),(2268,270,'贺兰县',3,0),(2269,271,'原州区',3,0),(2270,271,'海原县',3,0),(2271,271,'西吉县',3,0),(2272,271,'隆德县',3,0),(2273,271,'泾源县',3,0),(2274,271,'彭阳县',3,0),(2275,272,'惠农县',3,0),(2276,272,'大武口区',3,0),(2277,272,'惠农区',3,0),(2278,272,'陶乐县',3,0),(2279,272,'平罗县',3,0),(2280,273,'利通区',3,0),(2281,273,'中卫县',3,0),(2282,273,'青铜峡市',3,0),(2283,273,'中宁县',3,0),(2284,273,'盐池县',3,0),(2285,273,'同心县',3,0),(2286,274,'沙坡头区',3,0),(2287,274,'海原县',3,0),(2288,274,'中宁县',3,0),(2289,275,'城中区',3,0),(2290,275,'城东区',3,0),(2291,275,'城西区',3,0),(2292,275,'城北区',3,0),(2293,275,'湟中县',3,0),(2294,275,'湟源县',3,0),(2295,275,'大通',3,0),(2296,276,'玛沁县',3,0),(2297,276,'班玛县',3,0),(2298,276,'甘德县',3,0),(2299,276,'达日县',3,0),(2300,276,'久治县',3,0),(2301,276,'玛多县',3,0),(2302,277,'海晏县',3,0),(2303,277,'祁连县',3,0),(2304,277,'刚察县',3,0),(2305,277,'门源',3,0),(2306,278,'平安县',3,0),(2307,278,'乐都县',3,0),(2308,278,'民和',3,0),(2309,278,'互助',3,0),(2310,278,'化隆',3,0),(2311,278,'循化',3,0),(2312,279,'共和县',3,0),(2313,279,'同德县',3,0),(2314,279,'贵德县',3,0),(2315,279,'兴海县',3,0),(2316,279,'贵南县',3,0),(2317,280,'德令哈市',3,0),(2318,280,'格尔木市',3,0),(2319,280,'乌兰县',3,0),(2320,280,'都兰县',3,0),(2321,280,'天峻县',3,0),(2322,281,'同仁县',3,0),(2323,281,'尖扎县',3,0),(2324,281,'泽库县',3,0),(2325,281,'河南蒙古族自治县',3,0),(2326,282,'玉树县',3,0),(2327,282,'杂多县',3,0),(2328,282,'称多县',3,0),(2329,282,'治多县',3,0),(2330,282,'囊谦县',3,0),(2331,282,'曲麻莱县',3,0),(2332,283,'市中区',3,0),(2333,283,'历下区',3,0),(2334,283,'天桥区',3,0),(2335,283,'槐荫区',3,0),(2336,283,'历城区',3,0),(2337,283,'长清区',3,0),(2338,283,'章丘市',3,0),(2339,283,'平阴县',3,0),(2340,283,'济阳县',3,0),(2341,283,'商河县',3,0),(2342,284,'市南区',3,0),(2343,284,'市北区',3,0),(2344,284,'城阳区',3,0),(2345,284,'四方区',3,0),(2346,284,'李沧区',3,0),(2347,284,'黄岛区',3,0),(2348,284,'崂山区',3,0),(2349,284,'胶州市',3,0),(2350,284,'即墨市',3,0),(2351,284,'平度市',3,0),(2352,284,'胶南市',3,0),(2353,284,'莱西市',3,0),(2354,285,'滨城区',3,0),(2355,285,'惠民县',3,0),(2356,285,'阳信县',3,0),(2357,285,'无棣县',3,0),(2358,285,'沾化县',3,0),(2359,285,'博兴县',3,0),(2360,285,'邹平县',3,0),(2361,286,'德城区',3,0),(2362,286,'陵县',3,0),(2363,286,'乐陵市',3,0),(2364,286,'禹城市',3,0),(2365,286,'宁津县',3,0),(2366,286,'庆云县',3,0),(2367,286,'临邑县',3,0),(2368,286,'齐河县',3,0),(2369,286,'平原县',3,0),(2370,286,'夏津县',3,0),(2371,286,'武城县',3,0),(2372,287,'东营区',3,0),(2373,287,'河口区',3,0),(2374,287,'垦利县',3,0),(2375,287,'利津县',3,0),(2376,287,'广饶县',3,0),(2377,288,'牡丹区',3,0),(2378,288,'曹县',3,0),(2379,288,'单县',3,0),(2380,288,'成武县',3,0),(2381,288,'巨野县',3,0),(2382,288,'郓城县',3,0),(2383,288,'鄄城县',3,0),(2384,288,'定陶县',3,0),(2385,288,'东明县',3,0),(2386,289,'市中区',3,0),(2387,289,'任城区',3,0),(2388,289,'曲阜市',3,0),(2389,289,'兖州市',3,0),(2390,289,'邹城市',3,0),(2391,289,'微山县',3,0),(2392,289,'鱼台县',3,0),(2393,289,'金乡县',3,0),(2394,289,'嘉祥县',3,0),(2395,289,'汶上县',3,0),(2396,289,'泗水县',3,0),(2397,289,'梁山县',3,0),(2398,290,'莱城区',3,0),(2399,290,'钢城区',3,0),(2400,291,'东昌府区',3,0),(2401,291,'临清市',3,0),(2402,291,'阳谷县',3,0),(2403,291,'莘县',3,0),(2404,291,'茌平县',3,0),(2405,291,'东阿县',3,0),(2406,291,'冠县',3,0),(2407,291,'高唐县',3,0),(2408,292,'兰山区',3,0),(2409,292,'罗庄区',3,0),(2410,292,'河东区',3,0),(2411,292,'沂南县',3,0),(2412,292,'郯城县',3,0),(2413,292,'沂水县',3,0),(2414,292,'苍山县',3,0),(2415,292,'费县',3,0),(2416,292,'平邑县',3,0),(2417,292,'莒南县',3,0),(2418,292,'蒙阴县',3,0),(2419,292,'临沭县',3,0),(2420,293,'东港区',3,0),(2421,293,'岚山区',3,0),(2422,293,'五莲县',3,0),(2423,293,'莒县',3,0),(2424,294,'泰山区',3,0),(2425,294,'岱岳区',3,0),(2426,294,'新泰市',3,0),(2427,294,'肥城市',3,0),(2428,294,'宁阳县',3,0),(2429,294,'东平县',3,0),(2430,295,'荣成市',3,0),(2431,295,'乳山市',3,0),(2432,295,'环翠区',3,0),(2433,295,'文登市',3,0),(2434,296,'潍城区',3,0),(2435,296,'寒亭区',3,0),(2436,296,'坊子区',3,0),(2437,296,'奎文区',3,0),(2438,296,'青州市',3,0),(2439,296,'诸城市',3,0),(2440,296,'寿光市',3,0),(2441,296,'安丘市',3,0),(2442,296,'高密市',3,0),(2443,296,'昌邑市',3,0),(2444,296,'临朐县',3,0),(2445,296,'昌乐县',3,0),(2446,297,'芝罘区',3,0),(2447,297,'福山区',3,0),(2448,297,'牟平区',3,0),(2449,297,'莱山区',3,0),(2450,297,'开发区',3,0),(2451,297,'龙口市',3,0),(2452,297,'莱阳市',3,0),(2453,297,'莱州市',3,0),(2454,297,'蓬莱市',3,0),(2455,297,'招远市',3,0),(2456,297,'栖霞市',3,0),(2457,297,'海阳市',3,0),(2458,297,'长岛县',3,0),(2459,298,'市中区',3,0),(2460,298,'山亭区',3,0),(2461,298,'峄城区',3,0),(2462,298,'台儿庄区',3,0),(2463,298,'薛城区',3,0),(2464,298,'滕州市',3,0),(2465,299,'张店区',3,0),(2466,299,'临淄区',3,0),(2467,299,'淄川区',3,0),(2468,299,'博山区',3,0),(2469,299,'周村区',3,0),(2470,299,'桓台县',3,0),(2471,299,'高青县',3,0),(2472,299,'沂源县',3,0),(2473,300,'杏花岭区',3,0),(2474,300,'小店区',3,0),(2475,300,'迎泽区',3,0),(2476,300,'尖草坪区',3,0),(2477,300,'万柏林区',3,0),(2478,300,'晋源区',3,0),(2479,300,'高新开发区',3,0),(2480,300,'民营经济开发区',3,0),(2481,300,'经济技术开发区',3,0),(2482,300,'清徐县',3,0),(2483,300,'阳曲县',3,0),(2484,300,'娄烦县',3,0),(2485,300,'古交市',3,0),(2486,301,'城区',3,0),(2487,301,'郊区',3,0),(2488,301,'沁县',3,0),(2489,301,'潞城市',3,0),(2490,301,'长治县',3,0),(2491,301,'襄垣县',3,0),(2492,301,'屯留县',3,0),(2493,301,'平顺县',3,0),(2494,301,'黎城县',3,0),(2495,301,'壶关县',3,0),(2496,301,'长子县',3,0),(2497,301,'武乡县',3,0),(2498,301,'沁源县',3,0),(2499,302,'城区',3,0),(2500,302,'矿区',3,0),(2501,302,'南郊区',3,0),(2502,302,'新荣区',3,0),(2503,302,'阳高县',3,0),(2504,302,'天镇县',3,0),(2505,302,'广灵县',3,0),(2506,302,'灵丘县',3,0),(2507,302,'浑源县',3,0),(2508,302,'左云县',3,0),(2509,302,'大同县',3,0),(2510,303,'城区',3,0),(2511,303,'高平市',3,0),(2512,303,'沁水县',3,0),(2513,303,'阳城县',3,0),(2514,303,'陵川县',3,0),(2515,303,'泽州县',3,0),(2516,304,'榆次区',3,0),(2517,304,'介休市',3,0),(2518,304,'榆社县',3,0),(2519,304,'左权县',3,0),(2520,304,'和顺县',3,0),(2521,304,'昔阳县',3,0),(2522,304,'寿阳县',3,0),(2523,304,'太谷县',3,0),(2524,304,'祁县',3,0),(2525,304,'平遥县',3,0),(2526,304,'灵石县',3,0),(2527,305,'尧都区',3,0),(2528,305,'侯马市',3,0),(2529,305,'霍州市',3,0),(2530,305,'曲沃县',3,0),(2531,305,'翼城县',3,0),(2532,305,'襄汾县',3,0),(2533,305,'洪洞县',3,0),(2534,305,'吉县',3,0),(2535,305,'安泽县',3,0),(2536,305,'浮山县',3,0),(2537,305,'古县',3,0),(2538,305,'乡宁县',3,0),(2539,305,'大宁县',3,0),(2540,305,'隰县',3,0),(2541,305,'永和县',3,0),(2542,305,'蒲县',3,0),(2543,305,'汾西县',3,0),(2544,306,'离石市',3,0),(2545,306,'离石区',3,0),(2546,306,'孝义市',3,0),(2547,306,'汾阳市',3,0),(2548,306,'文水县',3,0),(2549,306,'交城县',3,0),(2550,306,'兴县',3,0),(2551,306,'临县',3,0),(2552,306,'柳林县',3,0),(2553,306,'石楼县',3,0),(2554,306,'岚县',3,0),(2555,306,'方山县',3,0),(2556,306,'中阳县',3,0),(2557,306,'交口县',3,0),(2558,307,'朔城区',3,0),(2559,307,'平鲁区',3,0),(2560,307,'山阴县',3,0),(2561,307,'应县',3,0),(2562,307,'右玉县',3,0),(2563,307,'怀仁县',3,0),(2564,308,'忻府区',3,0),(2565,308,'原平市',3,0),(2566,308,'定襄县',3,0),(2567,308,'五台县',3,0),(2568,308,'代县',3,0),(2569,308,'繁峙县',3,0),(2570,308,'宁武县',3,0),(2571,308,'静乐县',3,0),(2572,308,'神池县',3,0),(2573,308,'五寨县',3,0),(2574,308,'岢岚县',3,0),(2575,308,'河曲县',3,0),(2576,308,'保德县',3,0),(2577,308,'偏关县',3,0),(2578,309,'城区',3,0),(2579,309,'矿区',3,0),(2580,309,'郊区',3,0),(2581,309,'平定县',3,0),(2582,309,'盂县',3,0),(2583,310,'盐湖区',3,0),(2584,310,'永济市',3,0),(2585,310,'河津市',3,0),(2586,310,'临猗县',3,0),(2587,310,'万荣县',3,0),(2588,310,'闻喜县',3,0),(2589,310,'稷山县',3,0),(2590,310,'新绛县',3,0),(2591,310,'绛县',3,0),(2592,310,'垣曲县',3,0),(2593,310,'夏县',3,0),(2594,310,'平陆县',3,0),(2595,310,'芮城县',3,0),(2596,311,'莲湖区',3,0),(2597,311,'新城区',3,0),(2598,311,'碑林区',3,0),(2599,311,'雁塔区',3,0),(2600,311,'灞桥区',3,0),(2601,311,'未央区',3,0),(2602,311,'阎良区',3,0),(2603,311,'临潼区',3,0),(2604,311,'长安区',3,0),(2605,311,'蓝田县',3,0),(2606,311,'周至县',3,0),(2607,311,'户县',3,0),(2608,311,'高陵县',3,0),(2609,312,'汉滨区',3,0),(2610,312,'汉阴县',3,0),(2611,312,'石泉县',3,0),(2612,312,'宁陕县',3,0),(2613,312,'紫阳县',3,0),(2614,312,'岚皋县',3,0),(2615,312,'平利县',3,0),(2616,312,'镇坪县',3,0),(2617,312,'旬阳县',3,0),(2618,312,'白河县',3,0),(2619,313,'陈仓区',3,0),(2620,313,'渭滨区',3,0),(2621,313,'金台区',3,0),(2622,313,'凤翔县',3,0),(2623,313,'岐山县',3,0),(2624,313,'扶风县',3,0),(2625,313,'眉县',3,0),(2626,313,'陇县',3,0),(2627,313,'千阳县',3,0),(2628,313,'麟游县',3,0),(2629,313,'凤县',3,0),(2630,313,'太白县',3,0),(2631,314,'汉台区',3,0),(2632,314,'南郑县',3,0),(2633,314,'城固县',3,0),(2634,314,'洋县',3,0),(2635,314,'西乡县',3,0),(2636,314,'勉县',3,0),(2637,314,'宁强县',3,0),(2638,314,'略阳县',3,0),(2639,314,'镇巴县',3,0),(2640,314,'留坝县',3,0),(2641,314,'佛坪县',3,0),(2642,315,'商州区',3,0),(2643,315,'洛南县',3,0),(2644,315,'丹凤县',3,0),(2645,315,'商南县',3,0),(2646,315,'山阳县',3,0),(2647,315,'镇安县',3,0),(2648,315,'柞水县',3,0),(2649,316,'耀州区',3,0),(2650,316,'王益区',3,0),(2651,316,'印台区',3,0),(2652,316,'宜君县',3,0),(2653,317,'临渭区',3,0),(2654,317,'韩城市',3,0),(2655,317,'华阴市',3,0),(2656,317,'华县',3,0),(2657,317,'潼关县',3,0),(2658,317,'大荔县',3,0),(2659,317,'合阳县',3,0),(2660,317,'澄城县',3,0),(2661,317,'蒲城县',3,0),(2662,317,'白水县',3,0),(2663,317,'富平县',3,0),(2664,318,'秦都区',3,0),(2665,318,'渭城区',3,0),(2666,318,'杨陵区',3,0),(2667,318,'兴平市',3,0),(2668,318,'三原县',3,0),(2669,318,'泾阳县',3,0),(2670,318,'乾县',3,0),(2671,318,'礼泉县',3,0),(2672,318,'永寿县',3,0),(2673,318,'彬县',3,0),(2674,318,'长武县',3,0),(2675,318,'旬邑县',3,0),(2676,318,'淳化县',3,0),(2677,318,'武功县',3,0),(2678,319,'吴起县',3,0),(2679,319,'宝塔区',3,0),(2680,319,'延长县',3,0),(2681,319,'延川县',3,0),(2682,319,'子长县',3,0),(2683,319,'安塞县',3,0),(2684,319,'志丹县',3,0),(2685,319,'甘泉县',3,0),(2686,319,'富县',3,0),(2687,319,'洛川县',3,0),(2688,319,'宜川县',3,0),(2689,319,'黄龙县',3,0),(2690,319,'黄陵县',3,0),(2691,320,'榆阳区',3,0),(2692,320,'神木县',3,0),(2693,320,'府谷县',3,0),(2694,320,'横山县',3,0),(2695,320,'靖边县',3,0),(2696,320,'定边县',3,0),(2697,320,'绥德县',3,0),(2698,320,'米脂县',3,0),(2699,320,'佳县',3,0),(2700,320,'吴堡县',3,0),(2701,320,'清涧县',3,0),(2702,320,'子洲县',3,0),(2703,321,'长宁区',3,0),(2704,321,'闸北区',3,0),(2705,321,'闵行区',3,0),(2706,321,'徐汇区',3,0),(2707,321,'浦东新区',3,0),(2708,321,'杨浦区',3,0),(2709,321,'普陀区',3,0),(2710,321,'静安区',3,0),(2711,321,'卢湾区',3,0),(2712,321,'虹口区',3,0),(2713,321,'黄浦区',3,0),(2714,321,'南汇区',3,0),(2715,321,'松江区',3,0),(2716,321,'嘉定区',3,0),(2717,321,'宝山区',3,0),(2718,321,'青浦区',3,0),(2719,321,'金山区',3,0),(2720,321,'奉贤区',3,0),(2721,321,'崇明县',3,0),(2722,322,'青羊区',3,0),(2723,322,'锦江区',3,0),(2724,322,'金牛区',3,0),(2725,322,'武侯区',3,0),(2726,322,'成华区',3,0),(2727,322,'龙泉驿区',3,0),(2728,322,'青白江区',3,0),(2729,322,'新都区',3,0),(2730,322,'温江区',3,0),(2731,322,'高新区',3,0),(2732,322,'高新西区',3,0),(2733,322,'都江堰市',3,0),(2734,322,'彭州市',3,0),(2735,322,'邛崃市',3,0),(2736,322,'崇州市',3,0),(2737,322,'金堂县',3,0),(2738,322,'双流县',3,0),(2739,322,'郫县',3,0),(2740,322,'大邑县',3,0),(2741,322,'蒲江县',3,0),(2742,322,'新津县',3,0),(2743,322,'都江堰市',3,0),(2744,322,'彭州市',3,0),(2745,322,'邛崃市',3,0),(2746,322,'崇州市',3,0),(2747,322,'金堂县',3,0),(2748,322,'双流县',3,0),(2749,322,'郫县',3,0),(2750,322,'大邑县',3,0),(2751,322,'蒲江县',3,0),(2752,322,'新津县',3,0),(2753,323,'涪城区',3,0),(2754,323,'游仙区',3,0),(2755,323,'江油市',3,0),(2756,323,'盐亭县',3,0),(2757,323,'三台县',3,0),(2758,323,'平武县',3,0),(2759,323,'安县',3,0),(2760,323,'梓潼县',3,0),(2761,323,'北川县',3,0),(2762,324,'马尔康县',3,0),(2763,324,'汶川县',3,0),(2764,324,'理县',3,0),(2765,324,'茂县',3,0),(2766,324,'松潘县',3,0),(2767,324,'九寨沟县',3,0),(2768,324,'金川县',3,0),(2769,324,'小金县',3,0),(2770,324,'黑水县',3,0),(2771,324,'壤塘县',3,0),(2772,324,'阿坝县',3,0),(2773,324,'若尔盖县',3,0),(2774,324,'红原县',3,0),(2775,325,'巴州区',3,0),(2776,325,'通江县',3,0),(2777,325,'南江县',3,0),(2778,325,'平昌县',3,0),(2779,326,'通川区',3,0),(2780,326,'万源市',3,0),(2781,326,'达县',3,0),(2782,326,'宣汉县',3,0),(2783,326,'开江县',3,0),(2784,326,'大竹县',3,0),(2785,326,'渠县',3,0),(2786,327,'旌阳区',3,0),(2787,327,'广汉市',3,0),(2788,327,'什邡市',3,0),(2789,327,'绵竹市',3,0),(2790,327,'罗江县',3,0),(2791,327,'中江县',3,0),(2792,328,'康定县',3,0),(2793,328,'丹巴县',3,0),(2794,328,'泸定县',3,0),(2795,328,'炉霍县',3,0),(2796,328,'九龙县',3,0),(2797,328,'甘孜县',3,0),(2798,328,'雅江县',3,0),(2799,328,'新龙县',3,0),(2800,328,'道孚县',3,0),(2801,328,'白玉县',3,0),(2802,328,'理塘县',3,0),(2803,328,'德格县',3,0),(2804,328,'乡城县',3,0),(2805,328,'石渠县',3,0),(2806,328,'稻城县',3,0),(2807,328,'色达县',3,0),(2808,328,'巴塘县',3,0),(2809,328,'得荣县',3,0),(2810,329,'广安区',3,0),(2811,329,'华蓥市',3,0),(2812,329,'岳池县',3,0),(2813,329,'武胜县',3,0),(2814,329,'邻水县',3,0),(2815,330,'利州区',3,0),(2816,330,'元坝区',3,0),(2817,330,'朝天区',3,0),(2818,330,'旺苍县',3,0),(2819,330,'青川县',3,0),(2820,330,'剑阁县',3,0),(2821,330,'苍溪县',3,0),(2822,331,'峨眉山市',3,0),(2823,331,'乐山市',3,0),(2824,331,'犍为县',3,0),(2825,331,'井研县',3,0),(2826,331,'夹江县',3,0),(2827,331,'沐川县',3,0),(2828,331,'峨边',3,0),(2829,331,'马边',3,0),(2830,332,'西昌市',3,0),(2831,332,'盐源县',3,0),(2832,332,'德昌县',3,0),(2833,332,'会理县',3,0),(2834,332,'会东县',3,0),(2835,332,'宁南县',3,0),(2836,332,'普格县',3,0),(2837,332,'布拖县',3,0),(2838,332,'金阳县',3,0),(2839,332,'昭觉县',3,0),(2840,332,'喜德县',3,0),(2841,332,'冕宁县',3,0),(2842,332,'越西县',3,0),(2843,332,'甘洛县',3,0),(2844,332,'美姑县',3,0),(2845,332,'雷波县',3,0),(2846,332,'木里',3,0),(2847,333,'东坡区',3,0),(2848,333,'仁寿县',3,0),(2849,333,'彭山县',3,0),(2850,333,'洪雅县',3,0),(2851,333,'丹棱县',3,0),(2852,333,'青神县',3,0),(2853,334,'阆中市',3,0),(2854,334,'南部县',3,0),(2855,334,'营山县',3,0),(2856,334,'蓬安县',3,0),(2857,334,'仪陇县',3,0),(2858,334,'顺庆区',3,0),(2859,334,'高坪区',3,0),(2860,334,'嘉陵区',3,0),(2861,334,'西充县',3,0),(2862,335,'市中区',3,0),(2863,335,'东兴区',3,0),(2864,335,'威远县',3,0),(2865,335,'资中县',3,0),(2866,335,'隆昌县',3,0),(2867,336,'东  区',3,0),(2868,336,'西  区',3,0),(2869,336,'仁和区',3,0),(2870,336,'米易县',3,0),(2871,336,'盐边县',3,0),(2872,337,'船山区',3,0),(2873,337,'安居区',3,0),(2874,337,'蓬溪县',3,0),(2875,337,'射洪县',3,0),(2876,337,'大英县',3,0),(2877,338,'雨城区',3,0),(2878,338,'名山县',3,0),(2879,338,'荥经县',3,0),(2880,338,'汉源县',3,0),(2881,338,'石棉县',3,0),(2882,338,'天全县',3,0),(2883,338,'芦山县',3,0),(2884,338,'宝兴县',3,0),(2885,339,'翠屏区',3,0),(2886,339,'宜宾县',3,0),(2887,339,'南溪县',3,0),(2888,339,'江安县',3,0),(2889,339,'长宁县',3,0),(2890,339,'高县',3,0),(2891,339,'珙县',3,0),(2892,339,'筠连县',3,0),(2893,339,'兴文县',3,0),(2894,339,'屏山县',3,0),(2895,340,'雁江区',3,0),(2896,340,'简阳市',3,0),(2897,340,'安岳县',3,0),(2898,340,'乐至县',3,0),(2899,341,'大安区',3,0),(2900,341,'自流井区',3,0),(2901,341,'贡井区',3,0),(2902,341,'沿滩区',3,0),(2903,341,'荣县',3,0),(2904,341,'富顺县',3,0),(2905,342,'江阳区',3,0),(2906,342,'纳溪区',3,0),(2907,342,'龙马潭区',3,0),(2908,342,'泸县',3,0),(2909,342,'合江县',3,0),(2910,342,'叙永县',3,0),(2911,342,'古蔺县',3,0),(2912,343,'和平区',3,0),(2913,343,'河西区',3,0),(2914,343,'南开区',3,0),(2915,343,'河北区',3,0),(2916,343,'河东区',3,0),(2917,343,'红桥区',3,0),(2918,343,'东丽区',3,0),(2919,343,'津南区',3,0),(2920,343,'西青区',3,0),(2921,343,'北辰区',3,0),(2922,343,'塘沽区',3,0),(2923,343,'汉沽区',3,0),(2924,343,'大港区',3,0),(2925,343,'武清区',3,0),(2926,343,'宝坻区',3,0),(2927,343,'经济开发区',3,0),(2928,343,'宁河县',3,0),(2929,343,'静海县',3,0),(2930,343,'蓟县',3,0),(2931,344,'城关区',3,0),(2932,344,'林周县',3,0),(2933,344,'当雄县',3,0),(2934,344,'尼木县',3,0),(2935,344,'曲水县',3,0),(2936,344,'堆龙德庆县',3,0),(2937,344,'达孜县',3,0),(2938,344,'墨竹工卡县',3,0),(2939,345,'噶尔县',3,0),(2940,345,'普兰县',3,0),(2941,345,'札达县',3,0),(2942,345,'日土县',3,0),(2943,345,'革吉县',3,0),(2944,345,'改则县',3,0),(2945,345,'措勤县',3,0),(2946,346,'昌都县',3,0),(2947,346,'江达县',3,0),(2948,346,'贡觉县',3,0),(2949,346,'类乌齐县',3,0),(2950,346,'丁青县',3,0),(2951,346,'察雅县',3,0),(2952,346,'八宿县',3,0),(2953,346,'左贡县',3,0),(2954,346,'芒康县',3,0),(2955,346,'洛隆县',3,0),(2956,346,'边坝县',3,0),(2957,347,'林芝县',3,0),(2958,347,'工布江达县',3,0),(2959,347,'米林县',3,0),(2960,347,'墨脱县',3,0),(2961,347,'波密县',3,0),(2962,347,'察隅县',3,0),(2963,347,'朗县',3,0),(2964,348,'那曲县',3,0),(2965,348,'嘉黎县',3,0),(2966,348,'比如县',3,0),(2967,348,'聂荣县',3,0),(2968,348,'安多县',3,0),(2969,348,'申扎县',3,0),(2970,348,'索县',3,0),(2971,348,'班戈县',3,0),(2972,348,'巴青县',3,0),(2973,348,'尼玛县',3,0),(2974,349,'日喀则市',3,0),(2975,349,'南木林县',3,0),(2976,349,'江孜县',3,0),(2977,349,'定日县',3,0),(2978,349,'萨迦县',3,0),(2979,349,'拉孜县',3,0),(2980,349,'昂仁县',3,0),(2981,349,'谢通门县',3,0),(2982,349,'白朗县',3,0),(2983,349,'仁布县',3,0),(2984,349,'康马县',3,0),(2985,349,'定结县',3,0),(2986,349,'仲巴县',3,0),(2987,349,'亚东县',3,0),(2988,349,'吉隆县',3,0),(2989,349,'聂拉木县',3,0),(2990,349,'萨嘎县',3,0),(2991,349,'岗巴县',3,0),(2992,350,'乃东县',3,0),(2993,350,'扎囊县',3,0),(2994,350,'贡嘎县',3,0),(2995,350,'桑日县',3,0),(2996,350,'琼结县',3,0),(2997,350,'曲松县',3,0),(2998,350,'措美县',3,0),(2999,350,'洛扎县',3,0),(3000,350,'加查县',3,0),(3001,350,'隆子县',3,0),(3002,350,'错那县',3,0),(3003,350,'浪卡子县',3,0),(3004,351,'天山区',3,0),(3005,351,'沙依巴克区',3,0),(3006,351,'新市区',3,0),(3007,351,'水磨沟区',3,0),(3008,351,'头屯河区',3,0),(3009,351,'达坂城区',3,0),(3010,351,'米东区',3,0),(3011,351,'乌鲁木齐县',3,0),(3012,352,'阿克苏市',3,0),(3013,352,'温宿县',3,0),(3014,352,'库车县',3,0),(3015,352,'沙雅县',3,0),(3016,352,'新和县',3,0),(3017,352,'拜城县',3,0),(3018,352,'乌什县',3,0),(3019,352,'阿瓦提县',3,0),(3020,352,'柯坪县',3,0),(3021,353,'阿拉尔市',3,0),(3022,354,'库尔勒市',3,0),(3023,354,'轮台县',3,0),(3024,354,'尉犁县',3,0),(3025,354,'若羌县',3,0),(3026,354,'且末县',3,0),(3027,354,'焉耆',3,0),(3028,354,'和静县',3,0),(3029,354,'和硕县',3,0),(3030,354,'博湖县',3,0),(3031,355,'博乐市',3,0),(3032,355,'精河县',3,0),(3033,355,'温泉县',3,0),(3034,356,'呼图壁县',3,0),(3035,356,'米泉市',3,0),(3036,356,'昌吉市',3,0),(3037,356,'阜康市',3,0),(3038,356,'玛纳斯县',3,0),(3039,356,'奇台县',3,0),(3040,356,'吉木萨尔县',3,0),(3041,356,'木垒',3,0),(3042,357,'哈密市',3,0),(3043,357,'伊吾县',3,0),(3044,357,'巴里坤',3,0),(3045,358,'和田市',3,0),(3046,358,'和田县',3,0),(3047,358,'墨玉县',3,0),(3048,358,'皮山县',3,0),(3049,358,'洛浦县',3,0),(3050,358,'策勒县',3,0),(3051,358,'于田县',3,0),(3052,358,'民丰县',3,0),(3053,359,'喀什市',3,0),(3054,359,'疏附县',3,0),(3055,359,'疏勒县',3,0),(3056,359,'英吉沙县',3,0),(3057,359,'泽普县',3,0),(3058,359,'莎车县',3,0),(3059,359,'叶城县',3,0),(3060,359,'麦盖提县',3,0),(3061,359,'岳普湖县',3,0),(3062,359,'伽师县',3,0),(3063,359,'巴楚县',3,0),(3064,359,'塔什库尔干',3,0),(3065,360,'克拉玛依市',3,0),(3066,361,'阿图什市',3,0),(3067,361,'阿克陶县',3,0),(3068,361,'阿合奇县',3,0),(3069,361,'乌恰县',3,0),(3070,362,'石河子市',3,0),(3071,363,'图木舒克市',3,0),(3072,364,'吐鲁番市',3,0),(3073,364,'鄯善县',3,0),(3074,364,'托克逊县',3,0),(3075,365,'五家渠市',3,0),(3076,366,'阿勒泰市',3,0),(3077,366,'布克赛尔',3,0),(3078,366,'伊宁市',3,0),(3079,366,'布尔津县',3,0),(3080,366,'奎屯市',3,0),(3081,366,'乌苏市',3,0),(3082,366,'额敏县',3,0),(3083,366,'富蕴县',3,0),(3084,366,'伊宁县',3,0),(3085,366,'福海县',3,0),(3086,366,'霍城县',3,0),(3087,366,'沙湾县',3,0),(3088,366,'巩留县',3,0),(3089,366,'哈巴河县',3,0),(3090,366,'托里县',3,0),(3091,366,'青河县',3,0),(3092,366,'新源县',3,0),(3093,366,'裕民县',3,0),(3094,366,'和布克赛尔',3,0),(3095,366,'吉木乃县',3,0),(3096,366,'昭苏县',3,0),(3097,366,'特克斯县',3,0),(3098,366,'尼勒克县',3,0),(3099,366,'察布查尔',3,0),(3100,367,'盘龙区',3,0),(3101,367,'五华区',3,0),(3102,367,'官渡区',3,0),(3103,367,'西山区',3,0),(3104,367,'东川区',3,0),(3105,367,'安宁市',3,0),(3106,367,'呈贡县',3,0),(3107,367,'晋宁县',3,0),(3108,367,'富民县',3,0),(3109,367,'宜良县',3,0),(3110,367,'嵩明县',3,0),(3111,367,'石林县',3,0),(3112,367,'禄劝',3,0),(3113,367,'寻甸',3,0),(3114,368,'兰坪',3,0),(3115,368,'泸水县',3,0),(3116,368,'福贡县',3,0),(3117,368,'贡山',3,0),(3118,369,'宁洱',3,0),(3119,369,'思茅区',3,0),(3120,369,'墨江',3,0),(3121,369,'景东',3,0),(3122,369,'景谷',3,0),(3123,369,'镇沅',3,0),(3124,369,'江城',3,0),(3125,369,'孟连',3,0),(3126,369,'澜沧',3,0),(3127,369,'西盟',3,0),(3128,370,'古城区',3,0),(3129,370,'宁蒗',3,0),(3130,370,'玉龙',3,0),(3131,370,'永胜县',3,0),(3132,370,'华坪县',3,0),(3133,371,'隆阳区',3,0),(3134,371,'施甸县',3,0),(3135,371,'腾冲县',3,0),(3136,371,'龙陵县',3,0),(3137,371,'昌宁县',3,0),(3138,372,'楚雄市',3,0),(3139,372,'双柏县',3,0),(3140,372,'牟定县',3,0),(3141,372,'南华县',3,0),(3142,372,'姚安县',3,0),(3143,372,'大姚县',3,0),(3144,372,'永仁县',3,0),(3145,372,'元谋县',3,0),(3146,372,'武定县',3,0),(3147,372,'禄丰县',3,0),(3148,373,'大理市',3,0),(3149,373,'祥云县',3,0),(3150,373,'宾川县',3,0),(3151,373,'弥渡县',3,0),(3152,373,'永平县',3,0),(3153,373,'云龙县',3,0),(3154,373,'洱源县',3,0),(3155,373,'剑川县',3,0),(3156,373,'鹤庆县',3,0),(3157,373,'漾濞',3,0),(3158,373,'南涧',3,0),(3159,373,'巍山',3,0),(3160,374,'潞西市',3,0),(3161,374,'瑞丽市',3,0),(3162,374,'梁河县',3,0),(3163,374,'盈江县',3,0),(3164,374,'陇川县',3,0),(3165,375,'香格里拉县',3,0),(3166,375,'德钦县',3,0),(3167,375,'维西',3,0),(3168,376,'泸西县',3,0),(3169,376,'蒙自县',3,0),(3170,376,'个旧市',3,0),(3171,376,'开远市',3,0),(3172,376,'绿春县',3,0),(3173,376,'建水县',3,0),(3174,376,'石屏县',3,0),(3175,376,'弥勒县',3,0),(3176,376,'元阳县',3,0),(3177,376,'红河县',3,0),(3178,376,'金平',3,0),(3179,376,'河口',3,0),(3180,376,'屏边',3,0),(3181,377,'临翔区',3,0),(3182,377,'凤庆县',3,0),(3183,377,'云县',3,0),(3184,377,'永德县',3,0),(3185,377,'镇康县',3,0),(3186,377,'双江',3,0),(3187,377,'耿马',3,0),(3188,377,'沧源',3,0),(3189,378,'麒麟区',3,0),(3190,378,'宣威市',3,0),(3191,378,'马龙县',3,0),(3192,378,'陆良县',3,0),(3193,378,'师宗县',3,0),(3194,378,'罗平县',3,0),(3195,378,'富源县',3,0),(3196,378,'会泽县',3,0),(3197,378,'沾益县',3,0),(3198,379,'文山县',3,0),(3199,379,'砚山县',3,0),(3200,379,'西畴县',3,0),(3201,379,'麻栗坡县',3,0),(3202,379,'马关县',3,0),(3203,379,'丘北县',3,0),(3204,379,'广南县',3,0),(3205,379,'富宁县',3,0),(3206,380,'景洪市',3,0),(3207,380,'勐海县',3,0),(3208,380,'勐腊县',3,0),(3209,381,'红塔区',3,0),(3210,381,'江川县',3,0),(3211,381,'澄江县',3,0),(3212,381,'通海县',3,0),(3213,381,'华宁县',3,0),(3214,381,'易门县',3,0),(3215,381,'峨山',3,0),(3216,381,'新平',3,0),(3217,381,'元江',3,0),(3218,382,'昭阳区',3,0),(3219,382,'鲁甸县',3,0),(3220,382,'巧家县',3,0),(3221,382,'盐津县',3,0),(3222,382,'大关县',3,0),(3223,382,'永善县',3,0),(3224,382,'绥江县',3,0),(3225,382,'镇雄县',3,0),(3226,382,'彝良县',3,0),(3227,382,'威信县',3,0),(3228,382,'水富县',3,0),(3229,383,'西湖区',3,0),(3230,383,'上城区',3,0),(3231,383,'下城区',3,0),(3232,383,'拱墅区',3,0),(3233,383,'滨江区',3,0),(3234,383,'江干区',3,0),(3235,383,'萧山区',3,0),(3236,383,'余杭区',3,0),(3237,383,'市郊',3,0),(3238,383,'建德市',3,0),(3239,383,'富阳市',3,0),(3240,383,'临安市',3,0),(3241,383,'桐庐县',3,0),(3242,383,'淳安县',3,0),(3243,384,'吴兴区',3,0),(3244,384,'南浔区',3,0),(3245,384,'德清县',3,0),(3246,384,'长兴县',3,0),(3247,384,'安吉县',3,0),(3248,385,'南湖区',3,0),(3249,385,'秀洲区',3,0),(3250,385,'海宁市',3,0),(3251,385,'嘉善县',3,0),(3252,385,'平湖市',3,0),(3253,385,'桐乡市',3,0),(3254,385,'海盐县',3,0),(3255,386,'婺城区',3,0),(3256,386,'金东区',3,0),(3257,386,'兰溪市',3,0),(3258,386,'市区',3,0),(3259,386,'佛堂镇',3,0),(3260,386,'上溪镇',3,0),(3261,386,'义亭镇',3,0),(3262,386,'大陈镇',3,0),(3263,386,'苏溪镇',3,0),(3264,386,'赤岸镇',3,0),(3265,386,'东阳市',3,0),(3266,386,'永康市',3,0),(3267,386,'武义县',3,0),(3268,386,'浦江县',3,0),(3269,386,'磐安县',3,0),(3270,387,'莲都区',3,0),(3271,387,'龙泉市',3,0),(3272,387,'青田县',3,0),(3273,387,'缙云县',3,0),(3274,387,'遂昌县',3,0),(3275,387,'松阳县',3,0),(3276,387,'云和县',3,0),(3277,387,'庆元县',3,0),(3278,387,'景宁',3,0),(3279,388,'海曙区',3,0),(3280,388,'江东区',3,0),(3281,388,'江北区',3,0),(3282,388,'镇海区',3,0),(3283,388,'北仑区',3,0),(3284,388,'鄞州区',3,0),(3285,388,'余姚市',3,0),(3286,388,'慈溪市',3,0),(3287,388,'奉化市',3,0),(3288,388,'象山县',3,0),(3289,388,'宁海县',3,0),(3290,389,'越城区',3,0),(3291,389,'上虞市',3,0),(3292,389,'嵊州市',3,0),(3293,389,'绍兴县',3,0),(3294,389,'新昌县',3,0),(3295,389,'诸暨市',3,0),(3296,390,'椒江区',3,0),(3297,390,'黄岩区',3,0),(3298,390,'路桥区',3,0),(3299,390,'温岭市',3,0),(3300,390,'临海市',3,0),(3301,390,'玉环县',3,0),(3302,390,'三门县',3,0),(3303,390,'天台县',3,0),(3304,390,'仙居县',3,0),(3305,391,'鹿城区',3,0),(3306,391,'龙湾区',3,0),(3307,391,'瓯海区',3,0),(3308,391,'瑞安市',3,0),(3309,391,'乐清市',3,0),(3310,391,'洞头县',3,0),(3311,391,'永嘉县',3,0),(3312,391,'平阳县',3,0),(3313,391,'苍南县',3,0),(3314,391,'文成县',3,0),(3315,391,'泰顺县',3,0),(3316,392,'定海区',3,0),(3317,392,'普陀区',3,0),(3318,392,'岱山县',3,0),(3319,392,'嵊泗县',3,0),(3320,393,'衢州市',3,0),(3321,393,'江山市',3,0),(3322,393,'常山县',3,0),(3323,393,'开化县',3,0),(3324,393,'龙游县',3,0),(3325,394,'合川区',3,0),(3326,394,'江津区',3,0),(3327,394,'南川区',3,0),(3328,394,'永川区',3,0),(3329,394,'南岸区',3,0),(3330,394,'渝北区',3,0),(3331,394,'万盛区',3,0),(3332,394,'大渡口区',3,0),(3333,394,'万州区',3,0),(3334,394,'北碚区',3,0),(3335,394,'沙坪坝区',3,0),(3336,394,'巴南区',3,0),(3337,394,'涪陵区',3,0),(3338,394,'江北区',3,0),(3339,394,'九龙坡区',3,0),(3340,394,'渝中区',3,0),(3341,394,'黔江开发区',3,0),(3342,394,'长寿区',3,0),(3343,394,'双桥区',3,0),(3344,394,'綦江县',3,0),(3345,394,'潼南县',3,0),(3346,394,'铜梁县',3,0),(3347,394,'大足县',3,0),(3348,394,'荣昌县',3,0),(3349,394,'璧山县',3,0),(3350,394,'垫江县',3,0),(3351,394,'武隆县',3,0),(3352,394,'丰都县',3,0),(3353,394,'城口县',3,0),(3354,394,'梁平县',3,0),(3355,394,'开县',3,0),(3356,394,'巫溪县',3,0),(3357,394,'巫山县',3,0),(3358,394,'奉节县',3,0),(3359,394,'云阳县',3,0),(3360,394,'忠县',3,0),(3361,394,'石柱',3,0),(3362,394,'彭水',3,0),(3363,394,'酉阳',3,0),(3364,394,'秀山',3,0),(3365,395,'沙田区',3,0),(3366,395,'东区',3,0),(3367,395,'观塘区',3,0),(3368,395,'黄大仙区',3,0),(3369,395,'九龙城区',3,0),(3370,395,'屯门区',3,0),(3371,395,'葵青区',3,0),(3372,395,'元朗区',3,0),(3373,395,'深水埗区',3,0),(3374,395,'西贡区',3,0),(3375,395,'大埔区',3,0),(3376,395,'湾仔区',3,0),(3377,395,'油尖旺区',3,0),(3378,395,'北区',3,0),(3379,395,'南区',3,0),(3380,395,'荃湾区',3,0),(3381,395,'中西区',3,0),(3382,395,'离岛区',3,0),(3383,396,'澳门',3,0),(3384,397,'台北',3,0),(3385,397,'高雄',3,0),(3386,397,'基隆',3,0),(3387,397,'台中',3,0),(3388,397,'台南',3,0),(3389,397,'新竹',3,0),(3390,397,'嘉义',3,0),(3391,397,'宜兰县',3,0),(3392,397,'桃园县',3,0),(3393,397,'苗栗县',3,0),(3394,397,'彰化县',3,0),(3395,397,'南投县',3,0),(3396,397,'云林县',3,0),(3397,397,'屏东县',3,0),(3398,397,'台东县',3,0),(3399,397,'花莲县',3,0),(3400,397,'澎湖县',3,0),(3401,3,'合肥',2,0),(3402,3401,'庐阳区',3,0),(3403,3401,'瑶海区',3,0),(3404,3401,'蜀山区',3,0),(3405,3401,'包河区',3,0),(3406,3401,'长丰县',3,0),(3407,3401,'肥东县',3,0),(3408,3401,'肥西县',3,0);
/*!40000 ALTER TABLE `xy_region` ENABLE KEYS */;

#
# Structure for table "xy_selectdetail"
#

DROP TABLE IF EXISTS `xy_selectdetail`;
CREATE TABLE `xy_selectdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `select_name` varchar(255) DEFAULT NULL COMMENT '下拉项名字',
  `option1` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `option2` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `option3` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `option4` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `option5` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `option6` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `option7` varchar(255) DEFAULT NULL COMMENT '下拉内容',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='下拉列表选项表';

#
# Data for table "xy_selectdetail"
#

/*!40000 ALTER TABLE `xy_selectdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_selectdetail` ENABLE KEYS */;

#
# Structure for table "xy_transfer"
#

DROP TABLE IF EXISTS `xy_transfer`;
CREATE TABLE `xy_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in_user_id` varchar(255) DEFAULT NULL COMMENT '转入用户名',
  `in_user_name` varchar(255) DEFAULT NULL COMMENT '转入用户姓名',
  `out_user_id` varchar(255) DEFAULT NULL COMMENT '转出用户名',
  `out_user_name` varchar(255) DEFAULT NULL COMMENT '转出用户姓名',
  `money` varchar(255) DEFAULT NULL COMMENT '金额',
  `transfer_time` varchar(255) DEFAULT NULL COMMENT '时间',
  `transfer_type` varchar(255) DEFAULT NULL COMMENT '类型',
  `bz` varchar(255) DEFAULT NULL COMMENT '备注',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  `bk1` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk2` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk3` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk4` varchar(255) DEFAULT NULL COMMENT '备用字段',
  `bk5` varchar(255) DEFAULT NULL COMMENT '备用字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='转账记录表';

#
# Data for table "xy_transfer"
#

/*!40000 ALTER TABLE `xy_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_transfer` ENABLE KEYS */;

#
# Structure for table "xy_withdraw"
#

DROP TABLE IF EXISTS `xy_withdraw`;
CREATE TABLE `xy_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户名',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `bankid` varchar(255) DEFAULT NULL COMMENT '提现卡号',
  `bank` varchar(255) DEFAULT NULL COMMENT '提现银行',
  `money` varchar(255) DEFAULT NULL COMMENT '提现金额',
  `epoint` varchar(255) DEFAULT NULL COMMENT '到账金额',
  `withdraw_time` varchar(255) DEFAULT NULL COMMENT '时间',
  `withdraw_type` varchar(255) DEFAULT NULL COMMENT '类型',
  `bz` varchar(255) DEFAULT NULL COMMENT '备注',
  `tel` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `is_pay` varchar(255) DEFAULT NULL COMMENT '0:未支付 1：已支付',
  `update_flag` varchar(255) DEFAULT NULL COMMENT '更新标志',
  `delete_flag` varchar(255) DEFAULT NULL COMMENT '删除标志',
  `update_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `delete_time` varchar(255) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='提现记录表';

#
# Data for table "xy_withdraw"
#

/*!40000 ALTER TABLE `xy_withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `xy_withdraw` ENABLE KEYS */;
