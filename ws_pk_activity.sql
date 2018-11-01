/*
 Navicat Premium Data Transfer

 Source Server         : ws-测试-zy
 Source Server Type    : MySQL
 Source Server Version : 50636
 Source Host           : 124.160.36.10:3307
 Source Schema         : ws_shop

 Target Server Type    : MySQL
 Target Server Version : 50636
 File Encoding         : 65001

 Date: 19/12/2017 09:34:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ws_pk_activity
-- ----------------------------
DROP TABLE IF EXISTS `ws_pk_activity`;
CREATE TABLE `ws_pk_activity` (
  `pk_activity_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) unsigned DEFAULT NULL COMMENT '产品线ID',
  `activity_title` varchar(50) DEFAULT '' COMMENT '活动标题',
  `activity_img` varchar(150) DEFAULT '' COMMENT '活动海报',
  `join_user_type` tinyint(1) DEFAULT '0' COMMENT '0全部，1部分',
  `join_user` varchar(100) DEFAULT NULL COMMENT '参与人 json',
  `allow_out` tinyint(1) unsigned DEFAULT '0' COMMENT '是否允许中途退出 1允许',
  `quota_type` tinyint(1) DEFAULT '0' COMMENT '0业绩 1邀请',
  `quota` varchar(100) DEFAULT NULL COMMENT '指标',
  `pk_money` varchar(100) DEFAULT NULL COMMENT 'pk金额',
  `threshold` int(11) unsigned DEFAULT '0' COMMENT '门槛',
  `activity_start_time` int(10) unsigned DEFAULT '0' COMMENT '活动开始时间',
  `activity_end_time` int(10) unsigned DEFAULT '0' COMMENT '活动结束时间',
  `sign_start_time` int(10) DEFAULT NULL COMMENT '报名开始时间',
  `sign_end_time` int(10) unsigned DEFAULT '0' COMMENT '报名结束时间',
  `reward` varchar(250) DEFAULT '' COMMENT '公司奖励',
  `is_delete` tinyint(1) unsigned DEFAULT '0' COMMENT '1已删除',
  PRIMARY KEY (`pk_activity_id`),
  KEY `admin_id` (`admin_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ws_pk_activity
-- ----------------------------
BEGIN;
INSERT INTO `ws_pk_activity` VALUES (1, 22260, '标题', '', 0, '{\"type\":1,\"set\":[20,21,22,23]}', 1, 0, '{\"type\":1,\"set\":{\"20\":1,\"21\":2,\"23\":1}}', '[100,200,300,400]', 100, 1514131200, 1514563200, 1514131200, 1514563200, '沙发斯蒂芬胜多负少', 0);
INSERT INTO `ws_pk_activity` VALUES (4, 22260, 'sss', 'http://oss.ruishan666.com/image/testzy/171102/586692574041/3.jpg', 1, '{\"type\":\"1\",\"set\":[\"1\"]}', 1, 1, '{\"type\":\"1\"}', '[\"11\",\"11\",\"1\"]', 11, 1513008000, 1513872000, 1511798400, 1514304000, '', 0);
INSERT INTO `ws_pk_activity` VALUES (5, 22260, 'sss', '', 0, '{\"type\":\"0\"}', 1, 0, '{\"type\":\"0\"}', '[\"11\",\"11\",\"1\"]', 11, 1513008000, 1513872720, 1511799060, 1514304720, '', 0);
INSERT INTO `ws_pk_activity` VALUES (6, 22260, 'sss', '', 0, '{\"type\":\"0\"}', 1, 0, '{\"type\":\"0\"}', '[\"11\",\"11\",\"1\"]', 11, 1513008000, 1513872720, 1511799060, 1514304720, '', 0);
INSERT INTO `ws_pk_activity` VALUES (7, 22260, 'sss2222', '', 0, '{\"type\":\"0\"}', 1, 0, '{\"type\":\"0\"}', '[\"11\",\"11\",\"1\"]', 11, 1513008000, 1513872720, 1511799060, 1514304720, '', 0);
INSERT INTO `ws_pk_activity` VALUES (8, 22260, 'sss2222', '', 0, '{\"type\":\"0\"}', 1, 0, '{\"type\":\"0\"}', '[\"11\",\"11\",\"1\"]', 11, 1513008000, 1513872720, 1511799060, 1514304720, '', 0);
INSERT INTO `ws_pk_activity` VALUES (9, 22240, '第一项活动', 'http://oss.ruishan666.com/image/testzy/171214/238671882579/63ebdefaa188193.jpg', 1, '{\"type\":\"1\",\"set\":[\"20\",\"21\",\"22\"]}', 1, 1, '{\"type\":\"1\"}', '[\"3\",\"4\",\"5\"]', 33, 1513008000, 1515168000, 1513526400, 1514908800, '', 0);
INSERT INTO `ws_pk_activity` VALUES (10, 22262, 'e', 'http://oss.ruishan666.com/image/testzy/171123/427636538020/5ea80b36abf6f445959e1db80d6c2fe9.jpeg', 0, '{\"type\":\"0\"}', 1, 0, '{\"type\":\"0\"}', '[\"2\"]', 2, 1513008000, 1513568613, 1513526400, 1513526400, '', 0);
INSERT INTO `ws_pk_activity` VALUES (11, 22262, 'e', 'http://oss.ruishan666.com/image/testzy/171123/427636538020/5ea80b36abf6f445959e1db80d6c2fe9.jpeg', 0, '{\"type\":\"0\"}', 1, 0, '{\"type\":\"0\"}', '[\"2\"]', 2, 1513008000, 1513568613, 1513526400, 1513526400, '', 0);
INSERT INTO `ws_pk_activity` VALUES (12, 22240, '111', 'http://oss.ruishan666.com/image/testzy/171214/238711255519/984c06f0a250e37b16b242c780f1f400.jpg', 1, '{\"type\":\"1\",\"set\":[\"21\"]}', 1, 1, '{\"type\":\"1\"}', '[\"500\"]', 12, 1513008000, 1514390400, 1512576000, 1514563200, '', 1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
