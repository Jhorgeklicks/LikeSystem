<?php
session_start();
include '../includes/functions.php';

if(isset($_POST['user']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_FILES['file'])){

	$username 	= getPost($conn,'user');
	$email 		= getPost($conn,'email');
	$password 	= getPost($conn,'pass');

	$file = $_FILES['file'];

	if(empty($username) || empty($email) || empty($password) || empty($file)){
			echo "<span class='error'>All fields must be field</span>";
	}else{
		if(strlen($password) < 5){
			echo "<span class='error'>Password must be at least 5 characters</span>";
		}else{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

				echo "<span class='error'>'$email' not valid, please use a valid Email</span>";
			}else{
				$fileName = $file['name'];
				$fileTemp = $file['tmp_name'];
				$fileError = $file['error'];
				$fileSize = $file['size'];

				$fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
				$allowedExt = array('png','jpg','jpeg');

				if(!in_array($fileExt,$allowedExt)){
					echo "<span class='error'>$fileName not valid</span>";
				}else{
					if($fileError !== 0){
						echo "<span class='error'>Unable to Upload File,Use a different Image</span>";
					}else{
						if($fileSize > 10000000 || $fileSize < 625){
							echo "<span class='error'>File size not allowed </span>";
						}else{
							$myimage = date("Ymis");
							$newfileName = $myimage.'.'.$fileExt;
							// echo $newfileName;
							move_uploaded_file($fileTemp, '../img/'.$newfileName);

							// echo "'$username','$email','$password','$newfileName'";

							$sql = "SELECT * FROM Users WHERE User_Email = '$email';";
							$query = mysqli_query($conn, $sql);
							if(mysqli_num_rows($query) > 0){
								echo "<span class='error'>$email already Exist</span>";
							}elseif(mysqli_num_rows($query) === 0){
								$sql = "INSERT INTO Users(User_Name,User_Email,User_Password,User_Image)VALUES('$username','$email','$password','$newfileName')" ;

								$query = mysqli_query($conn, $sql);
								if($query){
									echo "<span class='success'>User has been Registered Successfully </span>";
								}else{
									echo "<span class='error'>Registration failed, Please Try Again later </span>";
								}
							}
						}
					}
				}

			}
		}
	}

	// echo "my name is ".$username;
}

if(isset($_POST['u_email']) && isset($_POST['u_pass'])){
		$email = getPost($conn, 'u_email');
		$password = getPost($conn, 'u_pass');

		if(empty($email) || empty($password)){
			echo "<span class='error'>Please Enter Your Details to Login</span>";
		}else{
			$sql = "SELECT * FROM Users WHERE User_Email = '$email' AND User_Password = '$password' LIMIT 1";
			$query = mysqli_query($conn, $sql);

			$result = mysqli_num_rows($query);

			if($result !== 1 ){
				echo "<span class='error'>Email and password do not match, Please Try Again</span>";
			}elseif($result === 1){
				$row = mysqli_fetch_assoc($query);

				 $_SESSION['id'] = $row['User_Id'];
				 $_SESSION['name'] = $row['User_Name'];
				 $_SESSION['image'] = $row['User_Image'];
				 $_SESSION['password'] = $row['User_Password'];
				 return true;
			}
		}
	}

	if(isset($_POST['action']) && isset($_POST['action']) =="insertPost"){
		$userId = getPost($conn,'u_id');
		$userName = getPost($conn,'u_name');
		$userImage = getPost($conn,'u_image');
		$postTitle = getPost($conn,'title');
		$postContent = getPost($conn,'content');
		$postDate = date("Y-m-d  G:i a");

		if(empty($userId) || empty($userName)|| empty($userImage)|| empty($postTitle)|| empty($postContent)){
			echo "Please enter All fields, Thanks";
		}else{
			$sql = "INSERT INTO posts(Post_Title,Post_Content,User_Id,User_Name,User_Image,Post_Date)
			VALUES('$postTitle','$postContent','$userId','$userName','$userImage','$postDate');";

			$query = mysqli_query($conn, $sql);

			if($query){
				echo "Post Published Successfully";
			}else{
				echo "Failed To Publish Post, Please Try Again Later";
			}
		}

	}

	// GRABS ALL POSTS FROM THE DATABASE

	if(isset($_POST['maction']) && isset($_POST['maction']) =="grabposts"){
		$posts = '';
		$sql = "SELECT posts.Post_Id, posts.User_Id,posts.Post_Content, posts.Post_Title,posts.Post_Date, posts.User_Name, posts.User_Image FROM posts INNER JOIN users ON users.User_Id = posts.User_Id ORDER BY posts.Post_Id DESC ";
		$query = mysqli_query($conn, $sql);

		if(mysqli_num_rows($query) < 1){
			echo '<h3 style="color:#fff; padding: 2rem;">There are No Post</h3>';
		}else{
			while($row = mysqli_fetch_assoc($query) ){
				$total = countPostLikes($conn, $row['Post_Id']);
				$posts .= '
							<section>
								<div class="posts_info">
									<p>
										<div class="img-box">
											<img style="background-image: url(\'img/'. $row['User_Image'].'\')" >
										</div>
										<h4>'. $row['User_Name'].'</h4>
										<h5 class="liked">'.$total.'</h5>
										</p>
											<h3>'.$row['Post_Date'].'</h3>
										</div>

										<div class="posts_content">
											<h4>'. $row['Post_Title'] .'</h4>
											<p>'. $row['Post_Content'].'</p>
										</div>
										<div class="posts_like">
											<div class="like" data-getid = "'. $row['Post_Id'].'" >Like👍</div>
											<input type="hidden" class="postid" value="'. $row['Post_Id'].'">
										</div>
									</section>
								';
							}
							echo $posts;
	}
}

	if(isset($_POST['laction']) && isset($_POST['laction']) =="logout"){
		session_destroy();
		session_unset();

		unset($_SESSION['name']);
		unset($_SESSION['id']);
		unset($_SESSION['User_Name']);
		unset($_SESSION['password']);
		unset($_SESSION['post_id']);

		return true;

	}

	if(isset($_POST['act']) && isset($_POST['act']) == 'like'){
		$u_name 	 = getPost($conn, 'u_name');
		$u_id 		 = getPost($conn, 'u_id');
		$post_id 	 = getPost($conn, 'post_id');
		$liked_image = mysqli_real_escape_string($conn, $_POST['u_image']);

		$like = 1;

		$sql = "SELECT * FROM likes WHERE User_Id = '$u_id' AND Post_Id = '$post_id' AND User_Liked = '$u_name';";
		$query = mysqli_query($conn, $sql);
		if(mysqli_num_rows($query) > 0){
			echo "Hello $u_name, You have already liked this post";
			exit();
		}elseif(mysqli_num_rows($query) === 0){
			$sql = "INSERT INTO Likes(Likes, User_Id , Post_Id , Liked_Image,User_Liked)
				VALUES($like, $u_id, $post_id,'$liked_image', '$u_name')";
				$query = mysqli_query($conn, $sql);
				if($query){
					// return true;
				}else{
					echo "query like Error";
				}
		}
	}
// fetch all notification
if(isset($_POST['notification']) && isset($_POST['notification']) == 'notification' ){
 			$id = $_SESSION['id'];
			$sql = "SELECT Post_Id FROM Posts WHERE User_Id ='$id'";
			$query = mysqli_query($conn, $sql);

				$postid = mysqli_fetch_assoc($query);
				$postid = @implode('',$postid);

				$sql = "SELECT * FROM likes WHERE Post_Id = '$postid' AND Status = 'unseen';";
				$query = mysqli_query($conn, $sql);
				echo @mysqli_num_rows($query);

}


// fetching all notification page
// if(isset($_POST['notDetails']) && isset($_POST['notDetails']) == 'notDetails' ){
	// 			$id = $_SESSION['id'];
	// 			$sql = "SELECT Post_Id FROM Posts WHERE User_Id ='$id'";
	// 			$query = mysqli_query($conn, $sql);

	// 				$postid = mysqli_fetch_assoc($query);
	// 				$postid = implode('',$postid);

	// 				$sql = "SELECT * FROM likes LEFT JOIN posts ON likes.Post_Id = posts.Post_Id WHERE likeS.Post_Id = '$postid'";;
	// 				$query = mysqli_query($conn, $sql);
	// 				// echo @mysqli_num_rows($query);
	// 		$output='';
	// 			while($row = mysqli_fetch_assoc($query) ){

	// 				$output .= '<section>
	// 					<div class="notification">
	// 						<div class="img_box1"><img class="head_info--img" style="background-image: url(\'img/'.$row['Liked_Image'].'\')">
	// 						</div>
	// 						<div class="info_box">
	// 							<div>'.$row['User_Liked'].' Liked your Post on "<span>'.substr($row['Post_Title'], 0, 70).'"</span></div>
	// 						</div>
	// 					</div>
	// 					</section>
	// 				';
	// }
	// 	echo $output;
// }

// UPDATING POST

// if(isset($_POST['update']) && isset($_POST['update']) == 'update' ){
//  			$id = $_SESSION['id'];
// 			$sql = "SELECT Post_Id FROM Posts WHERE User_Id ='$id'";
// 			$query = mysqli_query($conn, $sql);

// 				$postid = mysqli_fetch_assoc($query);
// 				$postid = @implode('',$postid);

// 				$sql = "SELECT * FROM likes WHERE Post_Id = '$postid' AND Status = 'unseen';";
// 				$query = mysqli_query($conn, $sql);

// 				if(mysqli_num_rows($query) > 0){
// 					$sql = "UPDATE `likes` SET `Status`= 'seen';";
// 					$query = mysqli_query($conn, $sql);
// 					if($query){
// 						echo "UPdated";
// 					}
// 				}
// }

 ?>


