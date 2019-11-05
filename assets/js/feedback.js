/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deletefeedback", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "delete_feedback",
			currentRow = $(this);

		$.confirm({
			title: '意见反馈\n!',
			content: '\n' + '您确定要删除此反馈吗?',
			buttons: {
                确认:function () {
                    jQuery.ajax({
                        type : "POST",
                        dataType : "json",
                        url : hitURL,
                        data : { id : id }
                    }).done(function(data){
                        console.log(data);
                        currentRow.parents('tr').remove();
                        if(data.status = true)  {$.alert("\n" + "已成功删除"); }
                        else if(data.status = false) { $.alert("\n" + "删除失败"); }
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


