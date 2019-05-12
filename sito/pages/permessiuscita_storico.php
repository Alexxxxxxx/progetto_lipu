<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";
	//require_once "../lib/PHPExcel.php";

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");
	

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);

	getHeaderHTML("ITIS","Storico PDF Permessi Uscita",$dblipu);
?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">STORICO PDF PERMESSI USCITA</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->


		  <?php
				if(isset($_GET['matricola']) && isset($_GET['data']) && isset($_GET['ora'])) :
		  ?>

		  <div class="modal in" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" id="pdfModal">
			  <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <h4 class="modal-title" id="pdfModalLabel"><?php echo "Permesso uscita matricola: ".$_GET['matricola'] ?></h4>
					  </div>
					  <div class="modal-body">
						  <?php if(isset($_GET['succ'])) : ?>
							  <div class="alert alert-success">
								  Permesso uscita matricola <strong><?php echo $_GET['matricola'] ?></strong> aggiornato!
							  </div>
					  		<?php endif; ?>
						  <iframe type="application/pdf" src="<?php echo "pdf_perm_uscita.php?matricola=$_GET[matricola]&ora=$_GET[ora]&data=$_GET[data]&preview=1" ?>" style="width:100%;height:40em"></iframe>
					  </div>
						<div class="modal-footer">

							<a id="download-button" type="button" class="btn btn-default" href="<?php echo "pdf_perm_uscita.php?matricola=$_GET[matricola]&ora=$_GET[ora]&data=$_GET[data]&preview=0" ?>" target="_blank">Conferma e Scarica</a>

							<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
				      </div>
				  </div>
			  </div>
		  </div>

		  <?php
		  		//Termine if per finestra PDF
				endif;
			?>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">

		                         	<div class="dataTable_wrapper">
			                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
			                                <thead>
			                                    <tr>
			                                       <!-- <th>Seq</th>-->
												    <th>Permesso n.</th>
												    <th>Cognome</th>
			                                        <th>Nome</th>
			                                    	<th>Matricola</th>
													<th>Classe</th>
													<th>Data</th>
													<th>Ora</th>
			                                        <th>PDF</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                <?php
			                                   	$query = "SELECT * 
												            FROM alunni,permessi 
															WHERE alunni.matricola=permessi.matricola
																AND stmp=1 
															ORDER BY data DESC, ora DESC,cognome,nome;";
												//die($query);
												$result = querySql($connection,$query);
												$j = 0;
												if($result!=NULL){
													while($row = $result->fetch_array()){
														$j++;
														echo "<tr>";
														echo "<td>".$row['numero']."</td>";
														echo "<td>".$row['cognome']."</td>";
														echo "<td>".$row['nome']."</td>";
														echo "<td>".$row['matricola']."</td>";
														echo "<td>".$row['classe']."</td>";
														echo "<td>".$row['data']."</td>";
														echo "<td>".$row['ora']."</td>";
														echo "<td><a href=\"?matricola=$row[matricola]&data=$row[data]&ora=$row[ora]\"><img src=\"".$pathImgPg.'pdf.png'."\" title=\"Preview\" align=\"center\" width=\"20\"></a></td>";															
														echo "</tr>";
														}
													}
												?>
											</tbody>
										</table>
								</div>
						<?php
	getFooterHTML('$(window).load(function(){$("#pdfModal").modal("show"); $("#download-button").click(function(){window.location = window.location.href.split("?")[0];})});');

	//	Chiudo la connessione
	$connection->close();
?>
