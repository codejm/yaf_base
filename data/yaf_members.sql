/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : codejm

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2014-08-25 16:44:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yaf_members
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
  `reg_ip_port` char(6) NOT NULL DEFAULT '' COMMENT '注册ip端口',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间,time',
  `email` char(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `email_checked` tinyint(1) DEFAULT '0' COMMENT '邮箱是否验证,radio',
  `role_type` char(10) NOT NULL DEFAULT '0' COMMENT '角色',
  `mobile` char(15) DEFAULT '' COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态,radio',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `role_id` (`role_type`),
  KEY `phone` (`mobile`),
  KEY `regdate` (`regdate`),
  KEY `regip` (`regip`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of yaf_members
-- ----------------------------
INSERT INTO `yaf_members` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '0', 'members/201408/22/fa1175cf0208eaaa690832b8b5179b0e655ad0d21408702385.jpg', '', '127.0.0.1', '34845', '2014', 'codejm@qq.com', '0', 'admin', '', '1');
