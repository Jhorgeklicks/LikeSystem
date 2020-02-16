 <?php
	 session_start();
		include 'includes/functions.php';
	include 'includes/header.php';
	if(!isset($_SESSION['id']) && !isset($_SESSION['name']) && !isset($_SESSION['image'])){
		header("Location: login.php");
	}else{
		$id = $_SESSION['id'];
		$username = $_SESSION['name'];
		$image = $_SESSION['image'];
	}
 ?>



<header class="head">
	<div class="head_logo">
		<a href="postpage.php">Likes<span class="head_logo--color">System</span></a>
	</div>
	<div class="head-right">
		<div class="head_notification">
			<div>🔔<span>0</span></div>
		</div>
			<div class="head_info">

				<p>
					<div class="img_box1"><img class="head_info--img" style="background-image: url('img/<?php echo $image?>');"></div>
					<span class="head_info--notice"></span>
				</p>
		</div>
		<button type="button" id="logout">Logout</button>
	</div>
</header>

<main>
	<div class="posts" id="pushNotification">
	<?php
				$id = $_SESSION['id'];
				$sql = "SELECT Post_Id FROM Posts WHERE User_Id ='$id'";
				$query = mysqli_query($conn, $sql);

					$postid = mysqli_fetch_assoc($query);
					$postid = implode('',$postid);

					$sql = "SELECT * FROM likes LEFT JOIN posts ON likes.Post_Id = posts.Post_Id WHERE likeS.Post_Id = '$postid'";;
					$query = mysqli_query($conn, $sql);
					// echo @mysqli_num_rows($query);
				while($row = mysqli_fetch_assoc($query) ){ ?>

				<section>
					<div class="notification">
						<div class="img_box1"><img class="head_info--img" style="background-image: url('img/<?php echo $row['Liked_Image'] ;?>');">
						</div>
						<div class="info_box">
							<div><span class="bold"><?php echo $row['User_Liked']; ?></span> Liked your Post on <span class="italic">"<?php echo substr($row['Post_Title'], 0, 70); ?>"</span></div>
						</div>
					</div>
				</section>

		<?php	}
	 ?>

	</div>
</main>
<?php
	if(isset($_GET['status'])){
		$str = $_GET['status'];

		if($str = "viewed"){
			 			$id = $_SESSION['id'];
						$sql = "SELECT Post_Id FROM Posts WHERE User_Id ='$id'";
						$query = mysqli_query($conn, $sql);

							$postid = mysqli_fetch_assoc($query);
							$postid = @implode('',$postid);

							$sql = "SELECT * FROM likes WHERE Post_Id = '$postid';";
							$query = mysqli_query($conn, $sql);

							if(mysqli_num_rows($query) > 0){
								$sql = "UPDATE `likes` SET `Status`= 'seen' WHERE Post_Id = '$postid' ;";
								$query = mysqli_query($conn, $sql);
								if($query){
									// echo "UPdated";
									return true;
								}
							}else{
								$sql = "UPDATE `likes` SET `Status`= 'seen' WHERE Post_Id = '$postid' ;";
								$query = mysqli_query($conn, $sql);
							}
			}
		}
 ?>

 <?php
	include 'includes/footer.php';
 ?>
