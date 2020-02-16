 <?php
	 session_start();
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
			<div id="mynotification">🔔<span>0</span></div>
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
<aside>
	<button type="submit" id="pub_post">Publish Post</button>
</aside>

<main>
	<div class="posts" id="post-cover">

	</div>
</main>


<!-- Post Modal -->
<div id="PostModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="change_title"> Post Data</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form method="POST" id="post_data">
					<div class="form-group">
						<label for="title">Post Title :</label>
						<input type="text" name="title" id="title" class="form-control" placeholder="Enter Post Title">
					</div>
					<div class="form-group">
						<label for="content">Post Content :</label>
						<textarea rows="3" cols="10" id="content" name="content" class="form-control" placeholder="Please Enter the Post content here"></textarea>
					</div>
					<input type="hidden" name="u_id" value="<?php echo $id;?>">
					<input type="hidden" name="u_image" value="<?php echo $image;?>">
					<input type="hidden" name="u_name" value="<?php echo $username;?>">
					<center>
						<div class="form-group">
							<button type="submit" class="btn-post">Publish</button>
						</div>
					</center>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="LikeModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
				<form method="POST" id="likepost">
					<input type="hidden" name="u_id" value="<?php echo $id;?>">
					<input type="hidden" name="u_name" value="<?php echo $username;?>">
					<input type="hidden" name="u_image" value="<?php echo $image;?>">
					<input type="hidden" name="post_id" id="postId" value="">
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
      </div>
    </div>
  </div>
</div>

 <?php
	include 'includes/footer.php';
 ?>
