<?php

include "./phpqrcode/qrlib.php";

$text='10447915125|01|F001|00000001|IGV|TOasdasdTAL|FECHA|6|RUC_CLIENTE|hibl4oMU3ow8hKcL9a0xfC9uXUE=';
QRcode::png($text, "10447915125-F001-00000001.png", 'Q',15, 0);


?>