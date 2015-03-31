/**
 * Created by Administrator on 15-3-31.
 * @author 郑钟良<zzl@ourstu.com>
 */
$(function(){

    $('[data-role="copy_code"]').zclip({
        path: PUB+"/js/ext/zclip/ZeroClipboard.swf",
        copy: function () {
            return $(this).attr('data-code');
        },
        afterCopy: function () {
            $(this).html('已复制');
            toast.success('复制成功');
        }
    });
    $('[data-role="copy_code_url"]').zclip({
        path: PUB+"/js/ext/zclip/ZeroClipboard.swf",
        copy: function () {
            return $(this).attr('data-code-url');
        },
        afterCopy: function () {
            $(this).html('链接已复制');
            toast.success('复制链接成功');
        }
    });
});