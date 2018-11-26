<?php
	include("Conversor.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>ASPFit 変換</title>
	<meta charset="shift-jis">
	<link href="lib/css/bootstrap.min.css" rel="stylesheet">
	<script src="lib/js/jquery.min.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>

    <style type="text/css">
		.file-upload {
		    position: absolute;
		    top: 0;
		    left: 0;
		    width:100%;
		    height:100%;
		    opacity: 0;
		    cursor: pointer;
		}
	</style>
</head>
	<body>
		<div class="container">
			<div class="panel-group">
				<div class="panel panel-primary">
      				<div class="panel-heading"><h2>ASPFit 変換</h2></div>
      				<div class="panel-body">
      					<form enctype="multipart/form-data" id="form" method="POST">
						    <div class="input-group">
						        <input type="text" id="label" class="form-control file-upload-text" disabled placeholder="ファイルを選択" />
						        <span class="input-group-btn">
						            <button type="button" class="btn btn-primary file-upload-btn">
						                .DAT ファイルを選択
						                <input type="file" class="file-upload" name="file" />
						            </button>
						        </span>
						    </div>
						</form>
						<div style="text-align: center;" class="form-group">
						    	<br />
						    	<input id="submit" disabled="disabled" class="btn btn-primary btn-lg" onclick="hideErrorMessage()" type="submit" value="変換" />
						    	
						    </div>
      				</div>
  				</div>
  			</div>
  			<?php 
	    		if (countFiles("download") || countFiles("files")) {
			?>
  			<div class="panel-group">
				<div class="panel panel-primary">
      				<div class="panel-heading"><h2>ファイル</h2></div>
      				<div class="panel-body">
      					<div style="text-align: center;" class="form-group">
						<div class="panel-heading"><h2>変換済み　ファイル</h2></div>
								<div class="panel-body">
								<?php 
									$d = dir("download");
									while ($file = $d->read()) {
										if ($file != "." and $file != ".." and substr($file, (strlen($file) -4), strlen($file)) != ".php") {
											echo "<p><a href='download/download.php?nomeArquivo=" . $file ."'>" . $file . "</a></p>";
										}
									}
								?>
							</div>
						</div>
						<div style="text-align: center;" class="form-group">
							<div class="panel-heading"><h2>変換前　ファイル</h2></div>
							<div class="panel-body">
								<?php 
									$d = dir("files");
									while ($file = $d->read()) {
										if ($file != "." and $file != ".." and substr($file, (strlen($file) -4), strlen($file)) != ".php") {
											echo "<p><a href='files/download.php?nomeArquivo=" . $file ."'>" . $file . "</a></p>";
										}
									}
								?>
							</div>
						</div>
						
					<br />
						<div style="text-align: center;" class="form-group">
							<button id='removeAll' onclick='removeFiles()' class='btn btn-danger btn-lg'>ファイル削除</button>
								<?php 
						    		echo "<script>$(location).href('/index.php');</script>";
						    		}
						    	 ?>
						</div>
      				</div>
  				</div>
  			</div>
  			<?php 
  				if (isset($_GET["error"]) && $_GET["error"]) {
  					echo '<div id="error" class="alert alert-danger">.DAT　ファイルデータのみ変換可能</div>';
  				}
  			 ?>
		</div>
		<script type="text/javascript">

			function hideErrorMessage() {
				$("#error").hide();
				$("#removeAll").show();
				$( "#form" ).submit();

			}

			function removeFiles() {
				$.ajax({
				  url: "delete.php",
				  context: document.body
				}).done(function() {
					window.location.href = '/Conversor';
				});

				
			};

	        function initializeFileUploads() {
	            $('.file-upload').change(function () {
	                var file = $(this).val();

	                $("#submit").prop('disabled', false);

	                var f = file.split("\\");
	                $(this).closest('.input-group').find('.file-upload-text').val(f[f.length - 1]);
	            });
	            $('.file-upload-btn').click(function () {
	                $(this).find('.file-upload').trigger('click');
	            });
	            $('.file-upload').click(function (e) {
	                e.stopPropagation();
	            });
	        }


        // On document load:
        $(function() {
            initializeFileUploads();
        });
    </script>
	</body>
</html>