ALTER TABLE  `ocenter_rank_user` ADD  `role_id` INT( 11 ) NOT NULL AFTER  `id`;
ALTER TABLE  `ocenter_field` ADD  `role_id` INT( 11 ) NOT NULL AFTER  `id`;
--
-- 表的结构 `ocenter_role`
--

DROP TABLE IF EXISTS `ocenter_role`;
CREATE TABLE IF NOT EXISTS `ocenter_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL COMMENT '英文标识',
  `title` varchar(25) NOT NULL COMMENT '中文标题',
  `description` varchar(500) NOT NULL COMMENT '描述',
  `type` tinyint(4) NOT NULL COMMENT '预留字段(类型：是否需要邀请注册等)',
  `sort` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=1;

--
-- 表的结构 `ocenter_role_config`
--

DROP TABLE IF EXISTS `ocenter_role_config`;
CREATE TABLE IF NOT EXISTS `ocenter_role_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL COMMENT '标识',
  `type` varchar(25) NOT NULL COMMENT '归类标识',
  `value` text NOT NULL COMMENT '配置值',
  `data` text NOT NULL COMMENT '该配置的其它值',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='角色配置表' AUTO_INCREMENT=1;

--
-- 表的结构 `ocenter_user_role`
--

DROP TABLE IF EXISTS `ocenter_user_role`;
CREATE TABLE IF NOT EXISTS `ocenter_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色关联' AUTO_INCREMENT=1;

ALTER TABLE  `ocenter_avatar` ADD  `role_id` INT( 11 ) NOT NULL AFTER  `id`;