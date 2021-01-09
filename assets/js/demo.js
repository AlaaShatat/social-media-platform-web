$(document).ready(function() {

	

	//Button for profile post
	$('#submit_profile_post').click(function(){
		var formData = new FormData($("form.profile_post")[0]);

		$.ajax({
			type: "POST",
			url: "../includes/handlers/ajax_submit_profile_post.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(msg) {
				alert('Posted Successfully');
				location.reload();
			},
			error: function(e) {
				alert('Failed To Post');
			}
		});

	});


});
$(document).ready(function() {

	

	//Button for profile post
	$('#submit_group_post').click(function(){
		var formData = new FormData($("form.group_post")[0]);

		$.ajax({
			type: "POST",
			url: "../includes/handlers/ajax_submit_group_post.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(msg) {
				alert('Posted Successfully');
				location.reload();
			},
			error: function(e) {
				alert('Failed To Post');
			}
		});

	});


});


function getDropdownData(user, type) {

	if($(".dropdown_data_window").css("height") == "0px") {

		var pageName;

		if(type == 'notification') {
			pageName = "ajax_load_notifications.php";
			$("span").remove("#unread_notification");
		}
		else if (type == 'message') {
			pageName = "ajax_load_messages.php";
			$("span").remove("#unread_message");
		}

		var ajaxreq = $.ajax({
			url: "includes/handlers/" + pageName,
			type: "POST",
			data: "page=1&userLoggedIn=" + user,
			cache: false,

			success: function(response) {
				$(".dropdown_data_window").html(response);
				$(".dropdown_data_window").css({"padding" : "0px", "height": "280px", "border" : "1px solid #DADADA"});
				$("#dropdown_data_type").val(type);
			}

		});

	}
	else {
		$(".dropdown_data_window").html("");
		$(".dropdown_data_window").css({"padding" : "0px", "height": "0px", "border" : "none"});
	}

}












