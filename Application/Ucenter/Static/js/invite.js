/**
 * Created by Administrator on 15-3-25.
 * @author 郑钟良<zzl@ourstu.com>
 */
$(function () {
    $('[data-role="exchange"]').click(function () {
        var id = $(this).attr('data-id');
        if (id <= 0) {
            toast.error('请选择兑换类型！');
        }
        var title = $(this).attr('data-title');
        var myModalTrigger = new ModalTrigger({
            'type': 'ajax',
            'url': U('Ucenter/Invite/exchange') + '&id=' + id,
            'title': '兑换 ' + title + ' 邀请名额'
        });
        myModalTrigger.show();
    });

    $('[data-role="create_invite"]').click(function () {
        var id = $(this).attr('data-id');
        if (id <= 0) {
            toast.error('请选择要生成的类型！');
        }
        var title = $(this).attr('data-title');
        var myModalTrigger = new ModalTrigger({
            'type': 'ajax',
            'url': U('Ucenter/Invite/createCode') + '&id=' + id,
            'title': '生成 ' + title + ' 邀请码'
        });
        myModalTrigger.show();
    });

    $('[data-role="copy_code"]').zclip({
        path: "__PUBLIC__/js/ext/zclip/ZeroClipboard.swf",
        copy: function () {
            return $(this).attr('data-code');
        },
        afterCopy: function () {
            $(this).html('已复制');
            toast.success('复制成功');
        }
    });
    $('[data-role="copy_code_url"]').zclip({
        path: "__PUBLIC__/js/ext/zclip/ZeroClipboard.swf",
        copy: function () {
            return $(this).attr('data-code-url');
        },
        afterCopy: function () {
            $(this).html('链接已复制');
            toast.success('复制链接成功');
        }
    });
    $('[data-role="back_copy_code"]').click(function () {
        if (confirm('确定退还邀请码？')) {
            var data_id = $(this).attr('data-id');
            $.post(U('Ucenter/Invite/backCode'), {id: data_id}, function (msg) {
                if (msg.status) {
                    toast.success('操作成功！');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);
                } else {
                    handleAjax(msg);
                }
            }, 'json');
        }
    });
});