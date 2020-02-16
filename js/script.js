$(document).ready(function(){
	$("#msg").show();

	$("body").on("click","#regbtn",function(evt){
		evt.preventDefault();
		$("#msg").show('fadeIn');

		$.ajax({
			type  :"POST",
			url   : "ajaxphp/action.php",
			data  : new FormData($("#myform")[0]),
			contentType : false,
			cache : false,
			processData: false,
			success: (response) =>{
				console.log(response);
				$("#msg").html(response);

				setTimeout(function(){
					$("#msg").hide('fadeOut')
				}, 5000);

				var cname = $("#msg span").attr('class');
				if(cname !== 'error'){
					window.location = "login.php";
				}
			}
		})
	})

	$("body").on("click","#loginbtn",function(evt){
		evt.preventDefault();
		$("#msg").show();

		$.ajax({
			type  :"POST",
			url   : "ajaxphp/action.php",
			data  : $("#form").serialize(),
			success: (response) =>{
				console.log(response);
				$("#msg").html(response);

				setTimeout(function(){
					$("#msg").hide()
				}, 5000);
				window.location = "postpage.php";
			}
		})
	});
	// when the btn for post modal is clicked
	$("#pub_post").click(function(evt){
		evt.preventDefault();
		$("#PostModal").modal('show');
	});

	// INSERT POST INTO POST DB
		$(".btn-post").click(function(evt){
				evt.preventDefault();
				$.ajax({
					type  : "POST",
					url   : "ajaxphp/action.php",
					data  : $("#post_data").serialize()+"&action=insertPost",
					success : (response) =>{
						alert(response);
						$("#PostModal").modal('hide');
						fetchAllPost();
						$("#post_data")[0].reset();

					}
				});
		});


		// FUNCTION TO FETCH ALL POST
		function fetchAllPost(){
			let maction = 'grabposts';
				$.ajax({
					type  : "POST",
					url   : "ajaxphp/action.php",
					data  : {maction:maction},
					success : (response) =>{
						// console.log(response);
						$("#post-cover").html(response);
					}
				});
		}
fetchAllPost();


// logout
	$("#logout").click(function(){
		let laction = 'logout';
		$.ajax({
					type  : "POST",
					url   : "ajaxphp/action.php",
					data  : {laction:laction},
					success : (response) =>{
						console.log(response);
						window.location = "login.php";
					}
				});
		});
// like button
	 	 		$("body").on("click",".like",function(){
	 	 			var postid = $(this).closest(".posts_like").find("input").attr("type","hidden").val();
	 	 			$("#postId").val(postid);

					var getDataId = $(this).closest(".posts_like").find("div").data("getid");	 	 			// console.log(postid);
	 	 			// $("#LikeModal").modal('show');

	 	 			let form = $("#likepost");

	 	 			$.ajax({
	 	 				type   : "POST",
	 	 				url    : "ajaxphp/action.php",
	 	 				data   : form.serialize()+"&act=like",
	 	 				success: (response) =>{
	 	 					alert(response);
	 	 					fetchAllPost();
	 	 				}
	 	 			});
	 	 		});

	 	 fetchAllNotification();
	 	 function fetchAllNotification(){
	 	 	let notification = 'notification';
	 	 	$.ajax({
	 	 		type   : "POST",
	 	 		url    : "ajaxphp/action.php",
	 	 		data   : {notification:notification},
	 	 		success: (response) =>{
	 	 			// console.log(response);
	 	 			$(".head_notification>div span").html(response);
	 	 			fetchAllPost();
	 	 		}
	 	 	});
	 	 }

	 	 //add event listener to notification
	 	 $("#mynotification").click(function(){
	 	 	window.location = 'notification.php?status=viewed';

	 	 });


// function to fetch notifcation page with ajax call
	 	//  function notificationDetails(){
	 	//  	let notDetails ='notDetails';
	 	//  	$.ajax({
	 	//  		type   : "POST",
	 	//  		url    : "ajaxphp/action.php",
	 	//  		data   : {notDetails:notDetails},
	 	//  		success: (response) =>{
	 	//  			$("#pushNotification").html(response);
	 	//  		}
	 	//  	});
	 	//  }
	 	// notificationDetails();

// SET ALL VIEWED NOTIFICATION T0 SEEN FUNCTION
function UpdateViewedNotification(){
		// let update ='update';
	 	 	$.ajax({
	 	 		type   : "GET",
	 	 		url    : "notification.php",
	 	 		// data   : {update:update},
	 	 		dataType : "json",
	 	 		success: (response) =>{
	 	 			console.log(response);
	 	 		}
	 	 	});
}
UpdateViewedNotification();

});