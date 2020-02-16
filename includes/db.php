<?php

	$conn = mysqli_connect("localhost","root","","LikeSystem");

	if(!$conn){
		echo mysqli_connect_errno("Failed");
	}

 ?>