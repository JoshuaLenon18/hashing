<?php
 // config.php
 define('DB_SERVER', 'localhost');
 define('DB_USERNAME', 'root');
 define('DB_PASSWORD', '' );
 define('DB_NAME', 'login_system');
 $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 if($conn === false){
 die("ERROR: Could not connect. " . mysqli_connect_error());
 }
 $recaptcha_site_key = '6LePXFUqAAAAABYdvbd9onP4-2gndxfkqUhVs5uI';
 $recaptcha_secret_key = '6LePXFUqAAAAAJPIIFzSzTXmyAT1S33ZeiQZsg4w';