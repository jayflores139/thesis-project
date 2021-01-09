<?php
	
	$email = 'joemy@gmail.com';

	$e = bin2hex(random_bytes(16));

  $ee = password_hash($email, PASSWORD_DEFAULT);

  $EEE = password_verify($email, $ee);

  if ($EEE === true) {
    echo "string";
  } else {
    echo "dsdsd";
  }

?>