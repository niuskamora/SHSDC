<?php
     include('RSA.php');
 
     $rsa = new Crypt_RSA();
     extract($rsa->createKey());
 
     $plaintext = 'terrafrost';
 
     $rsa->loadKey($privatekey);
     $ciphertext = $rsa->encrypt($plaintext);
 
     $rsa->loadKey($publickey);
     echo $rsa->decrypt($ciphertext);
 ?>