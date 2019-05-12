<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";
	require_once "../lib/PHPExcel.php";

	//	Se il terminal non è stato settato l'utente non ha effettuato il login
	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	if(!$_SESSION['is_admin']) {
		die("Permesso negato!");
	}
	
	//	Apertura della connessione
	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);

    //  Inizializza i campi
    if(isset($_GET['id']))
    {
        $id = mysqli_real_escape_string($connection, $_GET['id']);
    }
	if(isset($_GET['nome_comune']))
	{
		$nome_comune = mysqli_real_escape_string($connection, $_GET['nome_comune']);
	}
	if(isset($_GET['nome_scientifico']))
	{
		$nome_scientifico = mysqli_real_escape_string($connection, $_GET['nome_scientifico']);
	}
	if(isset($_GET['spec']))
	{
		$spec = mysqli_real_escape_string($connection, $_GET['spec']);
	}
	if(isset($_GET['id_modified']))
	{
		$id_modified = mysqli_real_escape_string($connection, $_GET['id_modified']);
	}
	
	getHeaderHTML("LIPU Provincia di Livorno","Modifica Specie",$dblipu);
?>
	
	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
				<?php
					if(isset($_GET['btn']))
					{
						echo "<h1 class='page-header'>Visualizza Modifica</h1>";
					}
					else
					{
						if(isset($_GET['id']))
						{
							echo "<h1 class='page-header'>Modifica Specie #$id</h1>";
						}
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
					
							<?php
								if(isset($_GET['id'])):
							?>
							
							<!-- Modifica Specie -->
							<form action="modifica_specie.php" method="GET">
								<div class="form-group">
									<label>Nome comune</label>
									<input name="nome_comune" type="text" class="form-control" maxLength="50">
									<label>Nome scientifico</label>
									<input name="nome_scientifico" type="text" class="form-control" maxLength="50">
									<label>Spec</label>
									<input name="spec" type="text" class="form-control" maxLength="1">
									<?php
										echo "<input name='id_modified' value='$id' type='hidden' class='form-control'>"
									?>
								</div>
								<div class="form-group">
									
									<?php 
										echo "<a href='modifica_specie.php?id=$id' class='btn btn-warning'>Cancel</a>";
									?>
									<input name='btn' value="Save" type='submit' class='btn btn-success'>
								</div>
							</form>
							
							<?php
								endif;
							
								if(isset($_GET['btn'])):
							?>
								
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
											$query = "UPDATE specie
														SET nome_comune='$nome_comune',
															nome_scientifico='$nome_scientifico',
															spec=$spec
													  WHERE id_specie=$id_modified;";
											updateSql($connection,$query);
										?>
									</tbody>
								</table>
							</div>
							
							<?php
								endif;
							?>
				
					</div>
				</div>
			</div>
		</div>
	<?php
				
	getFooterHTML();
	$connection->close();
?>