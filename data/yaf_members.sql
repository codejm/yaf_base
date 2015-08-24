/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50622
 Source Host           : 127.0.0.1
 Source Database       : yaf_demo

 Target Server Type    : MySQL
 Target Server Version : 50622
 File Encoding         : utf-8

 Date: 08/24/2015 18:30:53 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `yaf_members`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_members`;
CREATE TABLE `yaf_members` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `username` char(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(100) NOT NULL DEFAULT '' COMMENT '密码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别,radio',
  `face` char(120) DEFAULT NULL COMMENT '头像,file',
  `aboutme` char(255) DEFAULT NULL COMMENT '关于我,textarea',
  `regip` char(15) NOT NULL DEFAULT '' COMMENT '注册ip',
  `regipport` char(6) NOT NULL DEFAULT '' COMMENT '注册ip端口',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间,time',
  `email` char(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `emailchecked` tinyint(1) DEFAULT '0' COMMENT '邮箱是否验证,radio',
  `rid` smallint(5) NOT NULL DEFAULT '0' COMMENT '角色',
  `mobile` char(15) DEFAULT '' COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态,radio',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `phone` (`mobile`),
  KEY `regdate` (`regdate`),
  KEY `regip` (`regip`),
  KEY `role_id` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
--  Records of `yaf_members`
-- ----------------------------
BEGIN;
INSERT INTO `yaf_members` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', 'members/201411/07/6cf4cf00e5314e8e262c0091bee8a74150981e961415360580.jpg', '按时发送方的<b>sdadfasdaaa事实上事实上</b>', '127.0.0.1', '', '1409002464', 'codejm@qq.com', '0', '1', '', '1'), ('2', 'codejm', '21232f297a57a5a743894a0e4a801fc3', '0', null, '', '127.0.0.1', '', '1411711347', 'codejm@163.com', '0', '2', '', '1'), ('3', 'super_admin', '21232f297a57a5a743894a0e4a801fc3', '0', null, null, '127.0.0.1', '', '1440412080', 'codejm@163.com', '0', '0', '', '1');
COMMIT;

-- ----------------------------
--  Table structure for `yaf_news`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_news`;
CREATE TABLE `yaf_news` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `img` varchar(120) DEFAULT NULL COMMENT '头图,file,hidden',
  `remark` varchar(500) DEFAULT NULL COMMENT '描述,textarea,hidden',
  `detail` text NOT NULL COMMENT '详情,textareas,hidden',
  `dateline` int(10) DEFAULT NULL COMMENT '创建时间,time',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间,time,hidden',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='新闻';

-- ----------------------------
--  Records of `yaf_news`
-- ----------------------------
BEGIN;
INSERT INTO `yaf_news` VALUES ('2', '事实上', 'news/201409/26/407b2254080a54c60630e8411cfa8f9aec1a1fac1411714688.jpg', '', 'asdds上打法的', '1411714578', '1411714578', '1');
COMMIT;

-- ----------------------------
--  Table structure for `yaf_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_permissions`;
CREATE TABLE `yaf_permissions` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `fid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` char(100) NOT NULL COMMENT '权限名称',
  `path` char(64) NOT NULL COMMENT '验证路径',
  `ismenu` tinyint(1) DEFAULT '0' COMMENT '是否在菜单显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='权限';

-- ----------------------------
--  Records of `yaf_permissions`
-- ----------------------------
BEGIN;
INSERT INTO `yaf_permissions` VALUES ('1', '0', '后台主页', 'backend/index/index', '-1'), ('2', '6', '用户列表', 'backend/members/index', '1'), ('3', '6', '添加用户', 'backend/members/add', '1'), ('4', '6', '编辑用户', 'backend/members/edit', '0'), ('5', '6', '删除用户', 'backend/members/del', '0'), ('6', '0', '用户管理', 'backend/members', '-1'), ('7', '6', '用户审核', 'backend/members/status', '0'), ('8', '6', '用户批量删除', 'backend/members/batch', '0'), ('9', '0', '新闻管理', 'backend/news', '-1'), ('10', '9', '添加新闻', 'backend/news/add', '1'), ('11', '9', '编辑新闻', 'backend/news/edit', '0'), ('12', '9', '删除新闻', 'backend/news/del', '0'), ('13', '9', '新闻列表', 'backend/news/index', '1'), ('14', '9', '新闻审核', 'backend/news/status', '0'), ('15', '9', '新闻批量删除', 'backend/news/batch', '0'), ('16', '6', '角色管理', 'backend/roles/index', '1'), ('17', '6', '修改权限', 'backend/roles/editPermission', '0'), ('18', '6', '添加角色', 'backend/roles/add', '1'), ('19', '6', '编辑角色', 'backend/roles/edit', '0'), ('20', '6', '删除角色', 'backend/roles/del', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yaf_rolepermissions`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_rolepermissions`;
CREATE TABLE `yaf_rolepermissions` (
  `rid` int(8) unsigned NOT NULL COMMENT '角色id',
  `pid` int(8) unsigned NOT NULL COMMENT '权限id',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`rid`,`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权';

-- ----------------------------
--  Records of `yaf_rolepermissions`
-- ----------------------------
BEGIN;
INSERT INTO `yaf_rolepermissions` VALUES ('1', '1', '1440152878'), ('1', '2', '1440152878'), ('1', '3', '1440152878'), ('1', '4', '1440152878'), ('1', '5', '1440152878'), ('1', '6', '1440152878'), ('1', '7', '1440152878'), ('1', '8', '1440152878'), ('1', '9', '1440152878'), ('1', '10', '1440152878'), ('1', '11', '1440152878'), ('1', '12', '1440152878'), ('1', '13', '1440152878'), ('1', '14', '1440152878'), ('1', '16', '1440152878'), ('1', '17', '1440152878'), ('1', '18', '0'), ('1', '19', '0'), ('1', '20', '0'), ('2', '1', '1440411967'), ('2', '2', '1440411967'), ('2', '3', '1440411967'), ('2', '4', '1440411967'), ('2', '5', '1440411967'), ('2', '6', '1440411967'), ('2', '7', '1440411967'), ('2', '8', '1440411967'), ('2', '9', '1440411967'), ('2', '10', '1440411967'), ('2', '11', '1440411967'), ('2', '12', '1440411967'), ('2', '13', '1440411967'), ('2', '14', '1440411967'), ('2', '15', '1440411967');
COMMIT;

-- ----------------------------
--  Table structure for `yaf_roles`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_roles`;
CREATE TABLE `yaf_roles` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` char(100) NOT NULL COMMENT '角色名称',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '添加时间,time',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态,radio',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
--  Records of `yaf_roles`
-- ----------------------------
BEGIN;
INSERT INTO `yaf_roles` VALUES ('1', 'root', '0', '1'), ('2', 'root1', '1440153993', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
