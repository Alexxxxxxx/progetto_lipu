<?php
	require_once 'session.php'; 
	require_once 'settings.php';
	require_once 'library.php';

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header('location: login.php');

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
	if(!$_POST){
		$classe="";
		if(isset($_GET['classe'])&&isset($_GET['orario'])) {
			$classe=$_GET['classe'];
		getHeaderHTML('ITIS G.Galilei','Orario '.$classe,$dblipu);
		
?>
			<div class="modal in" tabindex="-1" role="dialog" aria-labelledby="cntrInfoModalLabel" id="cntrInfoModal">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
							<h4 class="modal-title" id="cntrInfoModalLabel"><?php echo 'Orario '.$classe ?></h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12">
								<!--  <body background="background.png"> -->
								  <img class = "img-responsive" src="<?php echo $pathImgPg.'\ImgOrario\\'.$classe.'.png';?>" align="center" >;
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
		}
	}
		getFooterHTML('$(window).load(function(){$("#cntrInfoModal").modal("show");});');
	//	Chiudo la connessione
	$connection->close();
?>
