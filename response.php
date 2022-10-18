<?php
//you can print text, image, barcode and QR code by sending request from your website. You just need to send data in JSON format
$a = array();
//sending text entry
$obj1 = (object) $a;	
$obj1->type = 0;//text
$obj1->content = 'My Title';//any string	
$obj1->bold = 1;//0 if no, 1 if yes
$obj1->align =2;//0 if left, 1 if center, 2 if right
$obj1->format = 3;//0 if normal, 1 if double Height, 2 if double Height + Width, 3 if double Width, 4 if small
array_push($a,$obj1);


echo json_encode($a,JSON_FORCE_OBJECT);
//Note that same sequence will be used for printing content
?>