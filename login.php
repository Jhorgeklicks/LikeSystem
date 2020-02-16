
<?php
	session_start();
	include 'includes/header.php';
 ?>
	<div id="wrapper">
		<h2 class="header">Login to view and like Posts</h2>
		<div class="signup">
			<a href="index.php" class="login_btn">&laquo;&laquo; SignUp</a>
		</div>
		<form id="form" method="POST">
			<center><div id="msg"></div></center>
			<div class="group">
				<label for="u_email">Email :</label>
				<input type="email" name="u_email" id="u_email" placeholder="example@gmail.com" required>
			</div>
			<div class="group">
				<label for="pass">Password :</label>
				<input type="password" name="u_pass" id="pass" placeholder="secret pin">
			</div>
			<center><button type="submit" id="loginbtn">Login</button></center>
		</form>
	</div>
 <?php
	include 'includes/footer.php';
 ?>