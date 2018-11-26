<?php 
	$uploaddir = '';
	$file = file_get_contents($_GET["nomeArquivo"]);
	$size = filesize($_GET["nomeArquivo"]);
	$quotedFileName = '"'. basename($_GET["nomeArquivo"]) .'"';

	$quotedFileName = rawurlencode($quotedFileName);
	$len = strlen($quotedFileName);

	$quotedFileName = substr($quotedFileName, 3, ($len - 6));
	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename*=UTF-8\'\'' . $quotedFileName);
	header('Content-Transfer-Encoding: binary');
	header('Connection: Keep-Alive');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . $size);
	flush();
	echo $file;

	echo "<script>window.location.href = '/Conversor';</script>";
?>