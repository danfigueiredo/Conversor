<?php
	delete("download", "C:\\VertrigoServ\\www\\Conversor\\download\\");
	delete("files", "C:\\VertrigoServ\\www\\Conversor\\files\\");

	function delete($dir, $realPath) {
		$d = dir($dir);
		while ($file = $d->read()) {
			if ($file != "." and $file != ".." and substr($file, (strlen($file) -4), strlen($file)) != ".php") {
				unlink($realPath . $file);
			}
		}
	}

?>