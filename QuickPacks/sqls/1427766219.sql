REPLACE INTO `ocenter_menu` (`id`, `title`, `pid`, `sort`, `url`, `hide`, `tip`, `group`, `is_dev`, `icon`) VALUES
(1000, '邀请注册', 0, 4, 'Invite/index', 0, '', '', 0, ''),
(1001, '类型管理', 1000, 0, 'Invite/index', 0, '', '邀请码管理', 0, ''),
(1002, '编辑验证码类型', 1001, 0, 'Invite/edit', 1, '', '', 0, ''),
(1003, '邀请码列表', 1000, 0, 'Invite/invite', 0, '', '邀请码管理', 0, ''),
(1004, '邀请注册配置', 1000, 0, 'Invite/config', 0, '', '基础配置', 0, '');