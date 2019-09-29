<?php


	function qr_create($string){
		
	}

	$needlestring = "sagfsdljgalkj13fas";

	require 'phpqrcode/qrlib.php';
	
	QRcode::png($needlestring, 'codes/qr-id-'.time().'.png'); // creates file