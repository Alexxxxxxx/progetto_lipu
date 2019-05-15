<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
	if(!$_POST){
		getHeaderHTML("LIPU Provincia di Livorno","Consegnanti",$dblipu);
		
	if(isset($_GET['pf_ente']))
	{
		$pf_ente = mysqli_real_escape_string($connection, $_GET['pf_ente']);
	}
	if(isset($_GET['ragione_sociale']))
	{
		$ragione_sociale = mysqli_real_escape_string($connection, $_GET['ragione_sociale']);
	}
?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php
					if(isset($_GET['NEW'])) {
						echo "<h1 class='page-header'>Aggiunta nuovo Consegnante</h1>";
					}
					else if(isset($_GET['btn'])) {
						echo "<h1 class='page-header'>Visualizza Modifica</h1>";
					}
					else {
						echo "<h1 class='page-header'>Elenco Consegnanti</h1>";
					}
				?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
					
                    	<?php if(isset($_GET['NEW'])):?>
						
						<!-- Aggiunta nuovo Consegnante DA MODIFICARE -->
						<form action="specie.php" method="GET">
							<div class="form-group">
								<label>Nome comune</label>
								<input name="nome_comune" type="text" class="form-control" maxLength="50">
								<label>Nome scientifico</label>
								<input name="nome_scientifico" type="text" class="form-control" maxLength="50">
								<label>Spec</label>
								<input name="spec" type="text" class="form-control" maxLength="1">
							</div>
							<div class="form-group">
								
								<?php 
									echo "<a href='specie.php?NEW=1' class='btn btn-warning'>Cancel</a>";
								?>
								<input name='btn' value="Save" type='submit' class='btn btn-success'>
							</div>
						</form>
						
						<?php
							endif; //$_GET['NEW']
							if(isset($_GET['btn'])):
						?>
							
						<!-- Visualizzazione Modifica -->
						<div class="dataTable_wrapper">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<!--<th>ID</th>-->
										<th>Nome Comune</th>
										<th>Nome Scientifico</th>
										<th>Spec</th>
									</tr>
								</thead>
								<tbody>									
									<?php
										//	Visualizza modifica
										echo "<tr>";
										echo "<td>$nome_comune</td>";
										echo "<td>$nome_scientifico</td>";
										echo "<td>$spec</td>";
										echo "</tr>";
									
										// Salvataggio modifica (DB)
										$query = "INSERT INTO specie (nome_comune,nome_scientifico,spec)
													   VALUES ('$nome_comune','$nome_scientifico',$spec);";
										updateSql($connection,$query);
									?>
								</tbody>
							</table>
						</div>
						
						<?php
							endif; //$_GET['btn']
							if(!$_GET){ 
						?>
                        <form action="classi.php" method="POST" onsubmit="return del();">
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
										<tr>
											<th>Pf Ente</th>
											<th>Ragione Sociale</th>
											<?php if($_SESSION['is_admin']) : ?>
											<th>Modifica</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * 
										            FROM consegnante;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL)
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
												echo "<td>$row[1]</td>";
												echo "<td>$row[2]</td>";
												if($_SESSION['is_admin'])
													echo "<td><a href=\"modifica_consegnante.php?id=$row[0]\"><img src=\"".$pathImgPg.'edit.png'."\" title=\"Modifica\" align=\"center\" width=\"20\"></a></td>";
										?>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</form>

						<?php
                        if (isset($_GET['classe'])){ 
						
							$classe=$_GET['classe'];
							
						?>	
							
						<div class="row">
                            
							<form action="classi.php" method="POST">
								<div class="col-lg-10">
									<div class="row">
                                    	
										<img class = "img-responsive" src="<?php echo $pathImgPg.'\ImgOrario\\'.$classe.'.png';?>" align="left" >
										<!--<a href="classi.php" class="btn btn-success">
                                    		Chiudi
                                    	</a>-->
								</div>
                                    
							</form>
						</div>
						

			<!--<div class="modal in" tabindex="-1" role="dialog" aria-labelledby="cntrInfoModalLabel" id="cntrInfoModal">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="cntrInfoModalLabel"><?php echo 'Orario '.$classe ?></h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12">
								  <img class = "img-responsive" src="<?php echo $pathImgPg.'\ImgOrario\\'.$classe.'.png';?>" align="center" >
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>-->
<?php
		
	}
	
	//getFooterHTML('$(window).load(function(){$("#cntrInfoModal").modal("show");});');
?>					
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
getFooterHTML('$(window).load(function(){$("#cntrInfoModal").modal("show");});');
	//getFooterHTML();
	}
	else{
			if($_POST['cmd']=="delete"){
				$i = 0;
				while(isset($_POST['elem'][$i])){
					$classe = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE FROM classi WHERE classe = '$classe'";
					if($classi!=$_SESSION['DB_lipu'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){
				if($_POST['classe']!=NULL){
					$classe = mysqli_real_escape_string($connection, $_POST['classe']);
					if($classe!=""){
						$articolata = mysqli_real_escape_string($connection, $_POST['articolata']);
						$aula = mysqli_real_escape_string($connection, $_POST['aula']);
						$coordinatore=mysqli_real_escape_string($connection,$_POST['coordinatore']);
						$ref_asl=mysqli_real_escape_string($connection,$_POST['ref_asl']);
			
						$query = "INSERT INTO classi (classe,articolata,aula,coordinatore,ref_asl) VALUES ('$classe','$articolata','$aula','$coordinatore','$ref_asl');";
						insertSql($connection,$query);
				}
			}
		}
		header("location: classi.php");
	}

?>
