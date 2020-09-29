/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : accident_statement

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-09-29 18:49:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for information
-- ----------------------------
DROP TABLE IF EXISTS `information`;
CREATE TABLE `information` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `a_reg_num` varchar(255) DEFAULT NULL,
  `a_owner_phone` varchar(255) DEFAULT NULL,
  `a_driver_name` varchar(255) DEFAULT NULL,
  `a_driver_id_code` varchar(255) DEFAULT NULL,
  `a_owner_name` varchar(255) DEFAULT NULL,
  `a_driver_license` varchar(255) DEFAULT NULL,
  `a_state_no` varchar(255) DEFAULT NULL,
  `a_brand` varchar(255) DEFAULT NULL,
  `a_model` varchar(255) DEFAULT NULL,
  `a_owner_address` varchar(255) DEFAULT NULL,
  `a_owner_email` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `a_kind` varchar(255) DEFAULT NULL,
  `affected_vehicle` int(5) DEFAULT NULL,
  `affected_assets` int(5) DEFAULT NULL,
  `affected_person` int(5) DEFAULT NULL,
  `b_license` varchar(255) DEFAULT NULL,
  `b_phone` varchar(255) DEFAULT NULL,
  `event_time` varchar(255) DEFAULT NULL,
  `incident_place` varchar(255) DEFAULT NULL,
  `event_lat` float DEFAULT NULL,
  `event_lng` float DEFAULT NULL,
  `event_description` longblob DEFAULT NULL,
  `registered_police` varchar(255) DEFAULT NULL,
  `police_detail` varchar(255) DEFAULT NULL,
  `a_was_driving` varchar(255) DEFAULT NULL,
  `a_tpvca_insurer` varchar(255) DEFAULT NULL,
  `a_want_kasko` varchar(255) DEFAULT NULL,
  `a_kasko_insurer` varchar(255) DEFAULT '',
  `photo_page` longblob DEFAULT NULL,
  `scheme_page` longblob DEFAULT NULL,
  `review_page` longblob DEFAULT NULL,
  `source_canvas` longblob DEFAULT NULL,
  `a_sign_canvas` longblob DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of information
-- ----------------------------
