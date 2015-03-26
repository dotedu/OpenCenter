/**
 * Created by Administrator on 15-3-25.
 * @author 郑钟良<zzl@ourstu.com>
 */
$(function(){
   $('[data-role="exchange"]').click(function(){
       var id=$(this).attr('data-id');
       if(id<=0){
           toast.error('请选择兑换类型！');
       }
       var title=$(this).attr('data-title');
       var myModalTrigger = new ModalTrigger({
           'type':'ajax',
           'url':U('Ucenter/Invite/exchange')+'&id='+id,
           'title':'兑换 '+title+' 邀请名额'
       });
       myModalTrigger.show();
   });

    $('[data-role="create_invite"]').click(function(){
        var id=$(this).attr('data-id');
        if(id<=0){
            toast.error('请选择要生成的类型！');
        }
        var title=$(this).attr('data-title');
        var myModalTrigger = new ModalTrigger({
            'type':'ajax',
            'url':U('Ucenter/Invite/createCode')+'&id='+id,
            'title':'生成 '+title+' 邀请码'
        });
        myModalTrigger.show();
    });
});