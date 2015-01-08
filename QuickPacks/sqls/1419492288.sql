DELETE FROM `thinkox_menu` WHERE `url` like '%module/%';
INSERT INTO `thinkox_menu` ( `title`, `pid`, `sort`, `url`, `hide`, `tip`, `group`, `is_dev`) VALUES
( '云平台', 0, 999999, 'module/lists', 0, '', '', 0);
set @tmp_id=0;
select @tmp_id:= id from `thinkox_menu` where `title` = '云平台';
INSERT INTO `thinkox_menu` ( `title`, `pid`, `sort`, `url`, `hide`, `tip`, `group`, `is_dev`) VALUES
( '模块管理', @tmp_id, 0, 'module/lists', 0, '', '云平台', 0),
( '卸载模块', @tmp_id, 0, 'module/uninstall', 1, '', '云平台', 0),
( '模块安装', @tmp_id, 0, 'module/install', 1, '', '云平台', 0);