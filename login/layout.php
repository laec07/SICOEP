<?php
	session_start();
	session_destroy();
	setcookie('usuario','',time()-100);
	setcookie('clave','',time()-100);
	header('Location:index.php');
?>