/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteBookList", function(){
		var bookId = $(this).data("bookid"),
			hitURL = baseURL + "deleteBookList",
			currentRow = $(this);

		$.confirm(
            {
                title :'书籍管理',
                content : '\n' + '您确定要删除此项目吗?',
                buttons: {
                    确认:function () {
                        jQuery.ajax({
                            type : "POST",
                            dataType : "json",
                            url : hitURL,
                            data : { bookId : bookId }
                        }).done(function(data){
                            console.log(data);
                            currentRow.parents('tr').remove();
                            if(data.status = true)  {$.alert("\n" + "用户已成功删除"); }
                            else if(data.status = false){ $.alert("\n" + "用户删除失败"); }
                            else { $.alert("\n" + "拒绝访问..!"); }
                        });
                    },
                    取消:function () {

                    }
                }
            }
		)

	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
