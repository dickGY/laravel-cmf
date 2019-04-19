/*
Navicat MySQL Data Transfer

Source Server         : 我的
Source Server Version : 50637
Source Host           : 39.106.216.27:3306
Source Database       : laravel_cmf

Target Server Type    : MYSQL
Target Server Version : 50637
File Encoding         : 65001

Date: 2019-04-19 11:04:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_status` tinyint(3) unsigned DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常,2:未验证',
  `user_pass` varchar(64) DEFAULT '' COMMENT '登录密码;cmf_password加密',
  `user_nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户昵称',
  `last_login_ip` varchar(15) DEFAULT '' COMMENT '最后登录ip',
  `mobile` varchar(20) DEFAULT '' COMMENT '中国手机不带国家代码，国际手机号格式为：国家代码-手机号',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `role_id` int(11) DEFAULT NULL COMMENT '角色主键',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `create_time` datetime DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`),
  KEY `user_nickname` (`user_nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('2', '1', '14e1b600b1fd579f47433b88e8d85291', 'admin', '', '18710204057', '2404401897@qq.com', '1', '0000-00-00 00:00:00', '2019-04-09 15:17:52');
INSERT INTO `admin` VALUES ('3', '1', '14e1b600b1fd579f47433b88e8d85291', '葛羽', '', '18710204056', '18710204057@QQ.com', '2', null, '2019-04-09 16:20:50');

-- ----------------------------
-- Table structure for auth_access
-- ----------------------------
DROP TABLE IF EXISTS `auth_access`;
CREATE TABLE `auth_access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色',
  `rule_route` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_route`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
-- Records of auth_access
-- ----------------------------
INSERT INTO `auth_access` VALUES ('13', '2', '/');
INSERT INTO `auth_access` VALUES ('14', '2', '/admin/role');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `status` tinyint(3) unsigned DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `name` varchar(100) DEFAULT '' COMMENT '规则描述',
  `param` varchar(100) DEFAULT '' COMMENT '额外url参数',
  `route` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='权限规则表';

-- ----------------------------
-- Records of auth_rule
-- ----------------------------
INSERT INTO `auth_rule` VALUES ('1', '1', '系统管理', null, '/');
INSERT INTO `auth_rule` VALUES ('2', '1', '管理员列表', null, '/admin/administrator');
INSERT INTO `auth_rule` VALUES ('3', '1', '角色列表', null, '/admin/role');
INSERT INTO `auth_rule` VALUES ('7', '1', '系统管理', null, '//');
INSERT INTO `auth_rule` VALUES ('8', '1', '新增', null, '/admin/saveRole');
INSERT INTO `auth_rule` VALUES ('9', '1', '编辑', null, '/admin/doSaveRole');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) DEFAULT NULL COMMENT '菜单名称',
  `p_id` int(11) DEFAULT '0' COMMENT '父级主键',
  `route` varchar(255) DEFAULT NULL COMMENT '路由',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `param` varchar(100) DEFAULT NULL COMMENT '参数',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` tinyint(1) DEFAULT '0' COMMENT '状态   0显示 1隐藏',
  `sort` int(11) DEFAULT '1000' COMMENT '排序',
  `level` tinyint(1) DEFAULT NULL COMMENT '层级   1顶级  2二级    3三级 4 四级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '系统管理', '0', '/', '&#xe6a9;', null, null, '0', '1000', '1');
INSERT INTO `menu` VALUES ('2', '管理员列表', '1', '/admin/administrator', null, null, null, '0', '1000', '2');
INSERT INTO `menu` VALUES ('3', '角色列表', '1', '/admin/role', null, null, null, '0', '11', '2');
INSERT INTO `menu` VALUES ('4', '新增', '3', '/admin/saveRole', null, null, null, '1', '1000', '3');
INSERT INTO `menu` VALUES ('5', '编辑', '3', '/admin/doSaveRole', null, null, null, '1', '1000', '3');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(1) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` tinyint(1) DEFAULT '0' COMMENT '状态     0启用   1禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '将拥有网站所有权限', '0');
INSERT INTO `role` VALUES ('2', '文章管理员', '由超级管理员分配权限', '0');
