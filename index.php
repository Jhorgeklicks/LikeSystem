 <?php
	include 'includes/header.php';
 ?>
 <div id="wrapper">
     <h2 class="header">Register to view and like Posts</h2>
     <div class="login">
         <a href="login.php" class="login_btn">Login &raquo;&raquo;</a>
     </div>
     <form id="myform" method="POST" enctype="multipart/form-data">
         <center>
             <div id="msg"></div>
         </center>
         <div class="group">
             <label for="user">Username :</label>
             <input type="text" name="user" id="user" placeholder="username">
         </div>
         <div class="group">
             <label for="email">Email :</label>
             <input type="email" name="email" id="email" placeholder="example@gmail.com">
         </div>
         <div class="group">
             <label for="pass">Password :</label>
             <input type="password" name="pass" id="pass" placeholder="secret pin">
         </div>
         <div class="group">
             <label for="file">Select a file :</label>
             <input type="file" name="file" id="file">
         </div>
         <center><button type="submit" id="regbtn">Register</button></center>
     </form>
 </div>
 <?php
	include 'includes/footer.php';
 ?>
