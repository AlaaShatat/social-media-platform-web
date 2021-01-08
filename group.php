
<?php 
            require 'assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: hello/");
            $connect =new connection ;
            $con = $connect->conn;   
            $userloggedin= $_SESSION['user']->get_id(); 
            $userloggedin_query=mysqli_query($con, "SELECT * FROM users WHERE id='$userloggedin' ");
             $user= mysqli_fetch_array($userloggedin_query);
        
            echo '
                 <!DOCTYPE html>
                    <html>
                        <head>
                                <link rel="stylesheet" type="text/css" href="styling/style.css">
                                <link rel="stylesheet" href="main.css">
                                <link rel="stylesheet" type=text/css href="styling/bootstrap.css">
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Chatverse | Newsfeed</title>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                <script src="assets/js/bootstrap.js"></script>
                                <script src="assets/js/bootbox.min.js"></script>
                                <link rel="icon" href="assets/img/icn_logo.png">
            
                                 <!--Navigation Bar-->
                                 <div id="nav">
                                    <a href=""><img src="assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                    <input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
                                        <div id="navbuttons">
                                                <button><a href='.$_SESSION["user"]->get_id().'><img src="'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                                <button><a href="messages" ><img src="assets/img/icn_msg.png"></a></button>
                                                <button><img src="assets/img/icn_notification.png"></button>
                                                <button id="arrow"><img src="assets/img/icn_settings.png"></button>
                                                <ul id="menu">
                                                        <li><a href="settings">Account Settings</li>
                                                        <li><a href="assets/operation/logout.php">Logout</a></li>
                                                </ul>
                                            </div> 
                                        </div>
                                <div style="height:40px; background-color: white;"></div>
                                <script>
                                var arrow = document.getElementById("arrow");
                                var menu = document.getElementById("menu");  
                                arrow.onclick = function() {
                                    if(menu.style.display == "block")menu.style.display = "none"
                                    else menu.style.display = "block";}
                                 </script>
                            </head>
                        <body>'
?>
    <?php
       // $sql="SELECT * FROM groups WHERE admin='$userloggedi"
    
       /* if (isset($_POST['post_group'])) 
        {
            $post= new Post($con,$userloggedin);
            //it takes body and user to fro now we make it none just in the start 
            $post->submitpost($_POST['post_text'],$group_name);
            header("Location:group.php");
        }*/




    ?>

<div class="group_info">
    <img src="assets/img/group image.jpg" alt="cover photo">
    <div class="wrapper">
            
            
            <div class="main_column column">
                <div id="postDiv" style="margin-bottom: 60px;">
                    <form action="group.php" class="post_form" style="width: 80%;height: 60px;border-radius: 5px;margin-right: 5px;border:1px solid rgb(224, 219, 219);font-size: 13px;" method="POST">
                        <textarea name="post_text" id ="post_text" placeholder="Post Something?"></textarea>
                        <br>
                        <input type="submit" name="post_group" id="post_button" value="post">
                        <hr>
                    </form>          
                </div>
                <div class="posts_area"> </div>
                <img id="loading" src="assets/img/loading.gif">
            </div>

            <script>/*
		var userloggedin ='<?php echo $userloggedin; ?>';

		$(document).ready(function(){

			$('#loading').show();
			// ajax for loading posts 
			$.ajax({
				url:"assets/operation/ajax_group.php",
				type:"POST",
				data:"page=1&userloggedin=" + userloggedin,
				cache:false,

				success:function(data)
				{
					$('#loading').hide(); //dont show loading sign again 
					$('.posts_area').html(data);
				}
			});  //end of ajax
		$(window).scroll(function(){
		var height=$('.posts_area').height(); //div containing posts
		var scroll_top=$(this).scrollTop();
		var page=$('.posts_area').find('.nextpage').val();//   created int post class
		var nomoreposts=$('.posts_area').find('.nomoreposts').val();
		//alert("hello");

		// function to scroll to the bottom //rl moshkla msh radi yd5ol  el if aslnn
		if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && nomoreposts=='false')
		{
			
			$('#loading').show();
			alert("hello");
			var ajaxReq = $.ajax({
			url:"assets/operation/ajax.php",
			type:"POST",
			data:"page=" + page + "&userloggedin=" + userloggedin,
			cache:false,

				success:function(response)
				{
					$('.posts_area').find('.nextpage').remove();
					$('.posts_area').find('.nomoreposts').remove();

					$('#loading').hide();
					$('.posts_area').append(response);//add new posts to the existing posts
				}
			});  

		}//end if

		return false;


		});//end $(window).scroll(function(){*/



		});
*/
	</script>

    </div>





</div>
 </body>
</html>