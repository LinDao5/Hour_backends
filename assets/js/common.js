/**
 * @author Kishor Mali
 */

jQuery(document).ready(function(){

    jQuery(document).on("click", ".deleteUser", function(){
        var userId = $(this).data("userid"),
            hitURL = baseURL + "deleteUser",
            currentRow = $(this);

         $.confirm({
            title: '后端管理\n!',
            content: '\n' + '你真的删除这个项目吗?',
            buttons: {
                确认: function () {
                        jQuery.ajax({
                            type : "POST",
                            dataType : "json",
                            url : hitURL,
                            data : { userId : userId }
                        }).done(function(data){
                            console.log( data);
                            currentRow.parents('tr').remove();
                            if(data.status = true) {$.alert("\n" + "用户已成功删除"); }
                            else if(data.status = false) { $.alert("\n" + "用户删除失败"); }
                            else { $.alert("\n" + "拒绝访问..!"); }
                        });

                },
                取消: function () {

                }
            }
        });

    });


    jQuery(document).on("click", ".searchList", function(){

    });

});
