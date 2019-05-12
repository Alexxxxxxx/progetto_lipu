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
		getHeaderHTML("ITIS G.Galilei","Docenti",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Docenti</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    	<?php if(!$_GET){ ?>
                        <form action="docenti.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
	                        	<!--<input type="checkbox" onClick="toggle(this);" id="all">-->
								 <?php if($_SESSION['is_admin']) : ?>
									<a title="Add New" href="docenti.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
									<button type="submit" value="delete" title="Delete Selected"  name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
									</button>
								<?php endif; ?>
                        	</div>
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
										<tr>
											<th>Docente</label></th>
											<th>Tel</th>
											<th>Ricevimento</th>
											<th>Aula</th>
											<th>Ora</th>
											<th>Orario</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * 
										            FROM docenti;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL)
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
												echo "<td><input type=\"checkbox\" onClick=\"unAll()\" name=\"elem[]\" value=\"$row[0]\" id=\"$row[0]\"> $row[0]</td>";
												echo "<td>$row[5]</td>";
												echo "<td>$row[1]</td>";
												echo "<td>$row[2]</td>";
												echo "<td>$row[3]</td>";
												//echo "<td><a href=\"docenti.php?classe=$row[0]&orario=$row[4]\" target=\"_blank\">VEDI</a></td>";
												echo "<td><a href=\"docenti.php?docente=$row[0]&orario=$row[4]\" target=\"_blank\"><img src=\"".$pathImgPg.'sk.png'."\" title=\"Vedi Orario\" align=\"center\" width=\"20\"></a></td>";
												
										?>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</form>

						<?php } else{
						if (isset($_GET['NEW'])){?>
						<div class="row">
                            <div class="col-lg-6">
								<form action="docenti.php" method="POST">
                                    <div class="form-group">
                                    	<label>Docente</label>
										<input name="docente" type="text" size="5" class="form-control" onkeyup="limitText(this,30);">
                                    </div>
									<div class="form-group">
                                    	<label>Ricevimento</label>
										<input name="ricevimento" type="text" size="5" class="form-control" onkeyup="limitText(this,25);">
                                    </div>
                                    <div class="form-group">
                                    	<label>Ora ricevimento</label>
										<input name="oraric" type="text" size="5" class="form-control" onkeyup="limitText(this,10);">
                                    </div>
									<div class="form-group">
                                    	<label>Aula</label>
										<input name="ora" type="text" size="5" class="form-control" onkeyup="limitText(this,10);">
                                    </div>
									<div class="form-group">
                                    	<label>Telefono</label>
										<input name="tel" type="text" size="5" class="form-control" onkeyup="limitText(this,15);">
                                    </div>
									<div class="form-group">
                                    	<label>File orario</label>
										<input name="orario" type="text" size="5" class="form-control" onkeyup="limitText(this,80);">
                                    </div>
                                    
                                    <div class="form-group">
                                    	<!--<input type="submit" name="cmd" class="btn btn-default" value="add">-->
                                    	<a href="Docenti.php" class="btn btn-warning">
                                    		Cancel
                                    	</a>
                                    	<button class="btn btn-success" type="submit" value="add" name="cmd">
                                    		Add
                                    	</button>
                                    </div>
								</form>
							</div>
						</div>
						<?php }
                        if (isset($_GET['docente'])){ 
						
							$docente=$_GET['docente'];
							$orario=$_GET['orario'];
							
						?>	
							
						<div class="row">
                            
							<form action="docenti.php" method="POST">
								<div class="col-lg-10">
									<div class="row">
                                    	
										<img class = "img-responsive" src="<?php  echo $pathImgPg.'\ImgOrarioDoc\\'.$orario;?>" align="left" >
										<!--<a href="docenti.php" class="btn btn-success">
                                    		Chiudi
                                    	</a>-->
								</div>
                                    
							</form>
						</div>
						<?php } 
			} ?>
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
					$docente = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE FROM Docenti WHERE Docente = '$docente'";
					if($docente!=$_SESSION['DB_lipu'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){
				if($_POST['docente']!=NULL){
					$docente = mysqli_real_escape_string($connection, $_POST['docente']);
					if($docente!=""){
						$tel = mysqli_real_escape_string($connection, $_POST['tel']);
						$ricevimento = mysqli_real_escape_string($connection, $_POST['ricevimento']);
						$oraric = mysqli_real_escape_string($connection, $_POST['oraric']);
						$aula = mysqli_real_escape_string($connection, $_POST['aula']);
						$orario = mysqli_real_escape_string($connection, $_POST['orario']);
						$query = "INSERT INTO docenti (docente,ricevimento,oraric,aula,orario,tel) VALUES ('$docente','$ricevimento','$oraric','$aula','$orario','$tel');";
						//die($query);
						insertSql($connection,$query);
				}
			}
		}
		header("location: Docenti.php");
	}

?>
