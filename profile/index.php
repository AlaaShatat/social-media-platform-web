<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");

                //aquire the usernames
                $user_id = $_SESSION['user']->get_id();
                $target_id = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],"/",1)+1);
                $target_id = strtolower(substr($target_id,0,strlen($target_id)-1));
                //refetch the data
                $_SESSION['user'] = new user($user_id);
                $_SESSION['target'] = new user($target_id);
                //check if the target is the user
                $isVisitor = TRUE;
                if($user_id == $target_id) $isVisitor = FALSE;


                
             echo '
                    <!DOCTYPE html>
                        <html>
        
                            <head>
                                    <link rel="stylesheet" href="../profile/main.css">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Chatverse | '.$_SESSION["target"]->get_name().'</title>
                                    <link rel="icon" href="../assets/img/icn_logo.png">
        
                                    <!--Navigation Bar-->
                                    <div id="nav">
                                       <a href="../"><img src="../assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                       <input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
                                           <div id="navbuttons">
                                                   <button><a href="../'.$_SESSION["user"]->get_id().'"><img src="../'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                                   <button><img src="../assets/img/icn_msg.png"></button>
                                                   <button id="notiBtn"><img id="noti_img" src="../assets/img/icn_notification'.$_SESSION["user"]->get_noti_statues().'.png"></button>
                                                   <button id="arrow"><img src="../assets/img/icn_settings.png"></button>
                                                   <div id="noti">';
                                                   $noti = new notification($_SESSION['user']->get_id());
                                                   $noti->get_noti(); 
                                                   echo '</div>
                                                   
                                                   <ul id="menu">
                                                           <li><a href="../settings">Settings</li>
                                                           <li><a href="../assets/operation/logout.php">Logout</a></li>
                                                   </ul>
                                               </div> 
                                           </div>
                                   <div style="height:40px; background-color: white;"></div>
   
             
                                   <script>
                                   var arrow = document.getElementById("arrow");
                                   var notiBtn = document.getElementById("notiBtn");
   
                                   var menu = document.getElementById("menu");  
                                   var noti = document.getElementById("noti");
                                   arrow.onclick = function() {
                                       if(menu.style.display == "block")menu.style.display = "none"
                                       else menu.style.display = "block";}
                                   notiBtn.onclick = function() {
                                       if(noti.style.display == "block")noti.style.display = "none"
                                       else {
   
                                           var xhttp = new XMLHttpRequest();
                                           xhttp.onreadystatechange = function() {
                                             if (this.readyState == 4 && this.status == 200) {
                                              document.getElementById("noti_img").src = "../assets/img/icn_notification.png";
                                             }
                                           };
                                           xhttp.open("GET","../assets/operation/db_update.php");
                                           xhttp.send();
                                           noti.style.display = "block";
                                       }
                                   }
                                   </script>
   
   
                               </head>
                           <body>'
   ?>



        <div id="NCP">  
                <div id="cover">
                    <?php if(!$isVisitor) echo '<button id="coverBtn"><img src="../assets/img/icn_upload.png"></button>'?>
                    <img src=<?php echo "../".$target_id."/".$_SESSION['target']->get_cover_pic(); ?>>
                </div>
                <div id="PNB">
                    <div style="display: inline-block; margin: 0 5%;">
                        <img id="pp" src=<?php echo "../".$target_id."/".$_SESSION['target']->get_profile_pic(); ?>>
                        <?php if(!$isVisitor) echo '<button id="ppBtn"><img src="../assets/img/icn_upload.png"></button>' ;?>
                        <p><?php echo $_SESSION['target']->get_name(); ?></p>
                    </div>
                    <form id="buttons" method="GET" action="../assets/operation/friend_button.php">
                        <input  type="hidden" name = "target" value = "<?php echo $target_id ?>">
                        <?php
                        if($isVisitor){
                        if(friendship::isFriend($user_id,$target_id)) echo '<input type="submit" name="op" value="Unfriend">';
                        else if(friendship::isFrRequest($target_id,$user_id)) echo '<input type="submit" name="op" value="Accept"><input type="submit" name="op" value="Refuse">';
                        else if(!(friendship::isFrRequest($user_id,$target_id))) echo '<input type="submit" name="op" value="Add Friend">';
                        else echo '<input type="submit" name="op" value="Cancel Request">';}
                        ?>                                   
                    </form>
                </div>
        </div>



        <!-- User Details-->
        <div style="width:25%; margin: 20px 1%; height: 800px; display:inline-block; vertical-align:top;">

            <!-- user info section -->
            <div id="user_info" class="datablock">
            <img src="../assets/img/user_info.png"><p>User Info</p>
                    <hr>
                    <div style="padding:0 10px;"> 
                        <p><samp>Bio: </samp>
                        <?php
                         echo $_SESSION['target']->get_bio();
                         if(!$isVisitor) echo '<button id="bioBtn" style="float:right; background-color:transparent; border:0px;"><img style="width:15px; height:15px;; margin:0;" src="../assets/img/edit_txt_icon.png"></button>';
                         ?></p>
                        <p><samp>Email: </samp><?php echo $_SESSION['target']->get_email()?> </p>
                        <p><samp>Phone: </samp><?php echo $_SESSION['target']->get_phone()?> </p>
                        <p><samp>Gender: </samp><?php echo $_SESSION['target']->get_gender()?> </p>
                        <p><samp>Birthdate: </samp>
                        <?php
                        $date=date_create($_SESSION['target']->get_birth_date());
                        echo date_format($date,"Y/m/d");
                        ?></p>
                     </div>
                </div>

            <!-- friends section -->
            <div id="friendsblock" class="datablock">
            <img src="../assets/img/friends.png"><p>Friends  (<?php echo $_SESSION['target']->get_friends_no();?>)</p>
                <button id="friendsBtn">See More</button>
                <hr>
                <!-- friends units -->
                <div style="margin: 0 0 0 2%"> 
                <?php
                $friends = $_SESSION['target']->get_friends();
                $friends_no = $_SESSION['target']->get_friends_no();
                if($friends_no!=0){
                    $start = 0;
                    for($i=0; $i<6; $i++){
                    if($i == $friends_no) break;
                    $end = strpos($friends,",",$start + 1);
                    $friend = new user(substr($friends,$start,$end - $start));
                    $start = $end + 1;
                    echo'
                        <div class="dataunit">
                            <img src="../'. $friend->get_id()."/". $friend->get_profile_pic().'"><br>
                            <a href="../'.$friend->get_id().'">' . $friend->get_name() . '</a>
                        </div>';
                    }
                }
                else echo '<p style="text-align:center; color:brown; font-weight:bolder; font-size:150%; margin: 30px;">No Friends To Show</p>'
                ?>
                </div>
            </div>

            <!-- market section -->
            <?php if($_SESSION['user']->get_market_statues()==1){
            
            echo '
            
            <div id="marketblock" class="datablock">
            <img src="../assets/img/market.png"><p>Marketplace  ('.$_SESSION['target']->get_products_no().')</p>
                <button id="marketBtn">Open</button>
                <hr>

                <!-- products units -->
                <div style="margin: 0 0 0 2%">';
                

                if($_SESSION['target']->get_products_no()!=0){
                    $targetMarket = new marketplace($_SESSION['target']->get_id());
                    $targetMarket->show_some_products();
                }

                else echo '<p style="text-align:center; color:brown; font-weight:bolder; font-size:150%; margin: 30px;">No Products To Show</p>';
                echo'
                </div>
            </div>';}

            ?>

             <!-- any other section -->

         </div>
  

        <!-- Posts Section-->
        <div style="width:60%; margin: 20px 1%; height: 1000px; border: 2px black solid; display:inline-block;">

        </div>







        <div id="uploadPPBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/upload_pic.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="pp">
                    <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
                </form>
            </div>
        </div>

        <div id="uploadCoverBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/upload_pic.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="cover">
                    <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
                </form>
            </div>
        </div>
        <div id="uploadBioBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/update_bio.php" method="post">
                    <input style="background-color: white; width:70%;" type="text" name="bio"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload Bio" >
                </form>
            </div>
        </div>

        <div id="marketBox" class="modal">
            <div class="modal-mp-content">
            <span class="close">&times;</span>

            <?php 
            $targetMarket = new marketplace($_SESSION['target']->get_id());
            $targetMarket->show_all_products($_SESSION['user']->get_id());
            ?>

            </div>
            <?php if(!$isVisitor){
            echo '<div class="modal-ma-content">
                    <form action="../assets/operation/market.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="add_product">
                            <p>Product name:</p><input type="text" name="product_name">
                            <p>Product description:</p><textarea rows="8" type="textbox" name="product_desc"></textarea>
                            <p>Product image:</p><input style="background-color: gray; width:60%;" type="file" name="fileToUpload"><br></br>
                            <input type="submit" name="submit" value="Add Product" >
                    </form>
            </div>';} ?>
        </div>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>  //Cover and PP Buttons
                var marketBox = document.getElementById("marketBox");
                var marketBtn = document.getElementById("marketBtn");
                var closeMarket = document.getElementsByClassName("close")[3];
                marketBtn.onclick = function() {
                marketBox.style.display = "block";
                }
                closeMarket.onclick = function() {
                marketBox.style.display = "none";
                }
                //
                function x(id){
                    $.ajax({  
                        type:"POST",  
                        url:"../assets/operation/market.php",  
                        data:"type=remove_product"+'&id='+id,
                        success: location.reload()
                    }); 
                }
                function y(name){
                $.ajax({  
                    type:"POST",  
                    url:"../assets/operation/market.php",  
                    data:"type=notify"+'&name='+name,
                    success: location.reload(),
                }); 
                }
                //
                var ppBox = document.getElementById("uploadPPBox");
                var ppBtn = document.getElementById("ppBtn");
                var closePP = document.getElementsByClassName("close")[0];
                ppBtn.onclick = function() {
                ppBox.style.display = "block";
                }
                closePP.onclick = function() {
                ppBox.style.display = "none";
                }
                //
                var coverBox = document.getElementById("uploadCoverBox");
                var coverBtn = document.getElementById("coverBtn");
                var closeCover = document.getElementsByClassName("close")[1];
                coverBtn.onclick = function() {
                coverBox.style.display = "block";
                }
                closeCover.onclick = function() {
                coverBox.style.display = "none";
                }
                //
                var bioBox = document.getElementById("uploadBioBox");
                var bioBtn = document.getElementById("bioBtn");
                var closeBio = document.getElementsByClassName("close")[2];
                bioBtn.onclick = function() {
                bioBox.style.display = "block";
                }
                closeBio.onclick = function() {
                bioBox.style.display = "none";
                }
        </script>
    </body>  
</html>
