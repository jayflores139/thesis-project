<?php  

include 'connect.php';
session_start();

if (isset($_POST['submit'])) {
    $han = false;
    
    $email_url = $_POST['email_url'];
    $token_url = $_POST['token_url']; 

	$pass = $_POST['pass'];
	$pass2 = $_POST['pass2'];
	
	$q = mysqli_query($conn,"SELECT * FROM users where email = '$email_url' ");
	if (mysqli_num_rows($q) > 0) {
	    while ($qq = mysqli_fetch_array($q)){
	        
	        $password_verify = password_verify($email_url, $qq['token']);
	        
	        if ($password_verify === true) {
	            $han = true;
	        }
	    }
	}
	
	if ($han == true) {
	    if ($pass != $pass2) {	

		echo "Password does'nt match!";

    	} else {
        
            $password_hash = password_hash($pass, PASSWORD_DEFAULT);
            
    		$sql = mysqli_query($conn,"UPDATE users set password = '$password_hash', token = '' where email = '$email_url' ");
    
    		if ($sql == true) {
    			echo "Your password has been reset";
    		}
    
    	}   
	} 
}

?>