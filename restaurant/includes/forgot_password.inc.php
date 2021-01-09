<?php 

include 'connect.php';

if (isset($_POST['submit_email'])) {
	$email = $_POST['email'];
	
    $email_h = password_hash($email, PASSWORD_DEFAULT);

	$q = mysqli_query($conn,"SELECT * FROM users where email = '$email' ") or die(mysqli_error($conn));
	
	mysqli_query($conn,"UPDATE users set token = '$email_h' where email = '$email' ") or die(mysqli_error($conn));
	
	$url = "https://tugkaran.com/create-password.php?email=".$email."&token=".$email_h;

	if (mysqli_num_rows($q) > 0) {
	    
	    header("Location: ../forgot_password.php?send=success");
	    
		$to = $email;
        $subject = "Reset your password to Tugkaran website.";
        
        $message = "
        <html>
        <body>
        <p>The link is below.</p>
        <a href='.$url.'>$url</a>
        </body>
        </html>
        ";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From: <tugkaran.com>' . "\r\n";
        
        mail($to,$subject,$message,$headers);
	} else {
		header("Location: ../forgot_password.php?send=error");
	}
}

 ?>
