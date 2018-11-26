<?php
	$nomeArquivo = "";
	$uploadfile = "";

	if (isset($_FILES['file'])) {

		$ext = explode("." ,$_FILES['file']['name']);

		$ext = $ext[count($ext) - 1];

		if (strtoupper($ext) =="DAT") {
			$uploaddir = 'C:\\VertrigoServ\\www\\Conversor\\files\\';
			$nomeArquivo = $_FILES['file']['name'];
		 	$nomeArquivo = str_replace(" ", "", $nomeArquivo);
		 	$nomeArquivo = str_replace("　", "", $nomeArquivo);
			$uploadfile = $uploaddir . basename($nomeArquivo);
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
			$lines = file ("files/" . $nomeArquivo);

			$isEOR = false;
			$countEOR = 0;

			$fp = fopen("download/" . $nomeArquivo, "w+");
			foreach ($lines as $row) {

				if(strstr($row, "EOR")) {
					$countEOR++;
					$isEOR = $countEOR == 2 ? true : false;
				} elseif (strstr($row, "EOF")) {
					$countEOR = 0;
					$isEOR = false;
				}

				$returno = converterLinha($row, $isEOR);

				$convertida = empty($returno) ? $row : $returno;
				fwrite($fp, $convertida);
			}
			if (fclose($fp)) {
				//redirect_url("download/download.php?nomeArquivo=" . $nomeArquivo);
				redirect_url("/Conversor/");
			}
			exit();
		} else {
			redirect_url("?error=1");
		}

	}

	function countFiles($dir) {
		$count = 0;
		$d = dir($dir);
		while ($file = $d->read()) {
			if ($file != "." and $file != ".." and substr($file, (strlen($file) -4), strlen($file)) != ".php") {
				$count++;
			}
		}

		return $count;
	}

	function redirect_url($path) {
	  header("location:".$path);
	}
		function converterLinha($row, $isEOR) {

				if (strstr($row, "FILTER_MODE NO_FILTER") || strstr($row, "FILTER_TYPE NONE") || strstr($row, "FORM ASPHERIC")) {
					return null; 
				} 

				if (strstr($row, "ASPHERIC_COEFF")) {
					return ASPHERIC_COEFF($row);
				} elseif (strstr($row, " MOD")) {
					return MOD($row);
				} elseif (strstr($row, "CX")) {
					return CX($row);
				} elseif (strstr($row, "CZ")) {
					return CZ($row);
				} elseif (strstr($row, "CUTOFF")) {
					return CUTOFF($row);
				} elseif (strstr($row, "ASSESSMENT_LENGTH")) {
					return ASSESSMENT_LENGTH($row);
				} elseif (strstr($row, "NUMBER_MOD_POINTS")) {
					return NUMBER_MOD_POINTS($row);
				} elseif (strstr($row, "ASPHERIC_RADIUS")) {
					return ASPHERIC_RADIUS($row);
				} elseif (strstr($row, "ASPHERIC_K")) {
					return ASPHERIC_K($row);
				} elseif (!strstr($row, "EOR") && $isEOR) {
					return mudarParaPadraoAntigo($row);
				}
			}


			function ASPHERIC_COEFF($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);
				$str2 = $str[2];
				$str3 = mudarParaPadraoAntigo($str[3]);

				return $str0 . " " . $str1 . " " . $str2 . " " . $str3;
			}

			function MOD($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);
				$str2 = $str[2];

				return $str0 . " " . $str1 . " " . $str2;
			}

			function CX($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = $str[1];
				$str2 = mudarParaPadraoAntigo($str[2]);
				$str3 = $str[3];
				$str4 = mudarParaPadraoAntigo($str[4]);
				$str5 = $str[5];

				return $str0 . " " . $str1 . " " . $str2 . " " . $str3 . " " . $str4. " " . $str5;
			}

			function CZ($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = $str[1];
				$str2 = mudarParaPadraoAntigo($str[2]);
				$str3 = $str[3];
				$str4 = mudarParaPadraoAntigo($str[4]);
				$str5 = $str[5];

				return $str0 . " " . $str1 . " " . $str2 . " " . $str3 . " " . $str4. " " . $str5;
			}

			function CUTOFF($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);
				$str2 = $str[2];
				$str3 = $str[3];
				$str4 = mudarParaPadraoAntigo($str[4]);

				return $str0 . " " . $str1 . " " . $str2 . " " . $str3 . " " . $str4;
			}

			function ASSESSMENT_LENGTH($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);
				$str2 = $str[2];

				return $str0 . " " . $str1 . " " . $str2;
			}

			function ASPHERIC_RADIUS($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);
				$str2 = $str[2];

				return $str0 . " " . $str1 . " " . $str2;
			}

			function NUMBER_MOD_POINTS($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);

				return $str0 . " " . $str1;
			}
			function ASPHERIC_K($row) {
				$str = explode(" ", $row);
				$str0 = $str[0];
				$str1 = mudarParaPadraoAntigo($str[1]);

				return $str0 . " " . $str1;
			}

			function isNegativo($str) {

				if (strstr($str, "e-")) {
					$array = explode("e-", $str);
					$str = $array[0];
				}

				return strstr($str, "-") ? true : false;
			}

			function mudarParaPadraoAntigo($str) {
				$count = 0;
				$e = "e+";
				if (isNegativo($str)) {
					$count++;
				}

				if (strstr($str, "e-")) {
					$e = "e-";
				}
				$strNew = "";

				$strArray = explode($e, $str);
				$strNew = substr($strArray[0], 0, (8 + $count));
				$strNew = $strNew . $e . $strArray[1];

				return $strNew;
			}


?>