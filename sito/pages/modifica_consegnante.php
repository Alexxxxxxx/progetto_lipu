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
	if(isset($_GET['id_modified']))
    {
        $id_modified = mysqli_real_escape_string($connection, $_GET['id_modified']);
    }
	if(isset($_GET['pf_ente']))
	{
		$pf_ente = mysqli_real_escape_string($connection, $_GET['pf_ente']);
	}
	if(isset($_GET['ragione_sociale']))
	{
		$ragione_sociale = mysqli_real_escape_string($connection, $_GET['ragione_sociale']);
	}
	
	getHeaderHTML("LIPU Provincia di Livorno","Modifica Consegnante",$dblipu);
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
							echo "<h1 class='page-header'>Modifica Consegnante #$id</h1>";
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
							<form action="modifica_consegnante.php" method="GET">
								<div class="form-group">
									<label>Pf Ente</label>
									<input name="pf_ente" type="text" class="form-control" maxLength="1">
									<label>Ragione Sociale</label>
									<input name="ragione_sociale" type="text" class="form-control" maxLength="50">
									<?php
										echo "<input name='id_modified' value='$id' type='hidden' class='form-control'>"
									?>
								</div>
								<div class="form-group">
									
									<?php 
										echo "<a href='modifica_consegnante.php?id=$id' class='btn btn-warning'>Cancel</a>";
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
											<th>Pf Ente</th>
											<th>Ragione Sociale</th>
	                                    </tr>
	                                </thead>
	                                <tbody>									
										<?php
											//	Visualizza modifica
											echo "<tr>";
											echo "<td>$pf_ente</td>";
											echo "<td>$ragione_sociale</td>";
											echo "</tr>";
										
											// Salvataggio modifica (DB)
											$query = "UPDATE consegnante
														SET pf_ente='$pf_ente',
															ragione_sociale='$ragione_sociale'
													  WHERE id_consegnante=$id_modified;";
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