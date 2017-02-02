<?php
	$id=time();
	$name =$id.'.png';
	$req=file_get_contents('php://input');
	$data=json_decode($req,true)['data'];
	file_put_contents(getcwd().'/../upload/'.$name, base64_decode(str_replace('data:image/png;base64,','',$data)));
	echo($id);
?>