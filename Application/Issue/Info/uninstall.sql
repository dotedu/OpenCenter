DROP TABLE IF EXISTS `thinkox_issue`;
DROP TABLE IF EXISTS `thinkox_issue_content`;


/*删除menu相关数据*/
set @tmp_id=0;
select @tmp_id:= id from `thinkox_menu` where `title` = '专辑';
delete from `thinkox_menu` where  `id` = @tmp_id or (`pid` = @tmp_id  and `pid` !=0);
delete from `thinkox_menu` where  `title` = '专辑';
/*删除相应的后台菜单*/
delete from `thinkox_menu` where  `url` like 'Issue/%';
/*删除相应的权限节点*/
delete from `thinkox_auth_rule` where  `module` = 'Issue';