<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";
	require_once "../lib/PHPExcel.php";

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");
	//	Apertura della connessione
	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);

	if(!$_POST){
		getHeaderHTML("LIPU","Specie",$dblipu);
		
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
	?>
	
	<script type="text/javascript" src="ajax.js"></script>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
				<?php
					if(isset($_GET['NEW'])) {
						echo "<h1 class='page-header'>Aggiunta nuova Specie</h1>";
					}
					else if(isset($_GET['btn'])) {
						echo "<h1 class='page-header'>Visualizza Modifica</h1>";
					}
					else {
						echo "<h1 class='page-header'>Elenco Specie</h1>";
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
						
						<!-- Aggiunta nuova Specie -->
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
						
						<?php if($_SESSION['is_admin'] == 1) : ?>
						<form action="specie.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
	                        	<!--<input type="checkbox" onClick="toggle(this);" id="all">-->
	                        	<a title="Add New" href="specie.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
								<button type="submit" value="delete" title="Delete Selected"  name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
                            	</button>
                        	</div>
						</form>
						<?php endif; ?>
						
						<div class="dataTable_wrapper">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>ID Specie</th>
										<th>Nome Comune</th>
										<th>Nome Scientifico</th>
										<th>Spec</th>
										<?php if($_SESSION['is_admin'] == 1) : ?>
										<th>Modifica</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody>
								<?php
									//	Elenco specie
									$query = "SELECT * 
												FROM specie 
												ORDER BY nome_comune;";
									$result = querySql($connection,$query);
									$j = 0;
									if($result!=NULL){
										if($result!=NULL)
										while($row = $result->fetch_array()){
											$j++;
											echo "<tr>";
											echo "<td><input type=\"checkbox\" onClick=\"unAll()\" name=\"elem[]\" value=\"$row[0]\" id=\"$row[0]\"> $row[0]</td>";
											echo "<td>$row[1]</td>";
											echo "<td>$row[2]</td>";
											echo "<td>$row[3]</td>";
											if($_SESSION['is_admin'] == 1)
												echo "<td><a href=\"modifica_specie.php?id=$row[0]\"><img src=\"".$pathImgPg.'edit.png'."\" title=\"Modifica\" align=\"center\" width=\"20\"></a></td>";
											echo "</tr>";
											}
										}
								?>
								</tbody>
							</table>
						</div>
				
				<?php } 
							
	getFooterHTML();
	}
	
	//	Chiudo la connessione
	$connection->close();


?>
