<?php
    include('TripleDES.php');

    $des = new Crypt_TripleDES();

    $des->setKey('427462d296572567b7a30335e4439426e5c7a675e325b6c7a7e');
 
 	$session = 55;
    //echo $des->decrypt($des->encrypt($plaintext));
    $encryptedSession = $des->encrypt($session);
    
    $desEncryptedSession = $des->decrypt($encryptedSession);
    
    echo "SESSION ENCRIPTADA: ".$encryptedSession."<br>";
    echo "SESSION DESENCRIPTADA: ".$desEncryptedSession;
 ?>
