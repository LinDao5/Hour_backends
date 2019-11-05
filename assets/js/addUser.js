/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addUserForm = $("#addUser");
	
	var validator = addUserForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "\n" + "这是必填栏" },
			email : { required : "\n" + "这是必填栏。", email : "请输入有效的电子邮件地址", remote : "电子邮件已被接收\n" },
			password : { required : "\n" + "这是必填栏。" },
			cpassword : {required : "\n" + "这是必填栏。", equalTo: "请输入相同的密码\n" },
			mobile : { required : "\n" + "这是必填栏。", digits : "请只输入数字" },
			role : { required : "\n" + "这是必填栏。", selected : "请至少选择一个选项\n" }
		}
	});
});
