<?php
	include 'db.php';


	function getPost($conn,$post){
		return mysqli_real_escape_string($conn, $_POST[$post]);
	}

	function execute_query($conn, $sql){
		return mysqli_query($conn, $sql);
	}

	function if_user_has_already_liked($conn, $userId, $contentId){
		$sql = "SELECT * FROM likes WHERE User_Id = '$userId' AND Post_Id = '$contentId';";
		$query = mysqli_query($conn, $sql);
		$result = mysqli_num_rows($query);

		if($result > 0){
			return true;
		}else{
			return false;
		}
	}

	function countPostLikes($conn, $contentId){
		$sql ="SELECT * FROM Likes where Post_Id ='$contentId';";
		$query = mysqli_query($conn, $sql);
		$total = mysqli_num_rows($query);

		if($total === 0 || $total === 1){
			return $total . " like";
		}else{
			return $total. " Likes";
		}
	}
 ?>