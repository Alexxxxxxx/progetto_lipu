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
		getHeaderHTML("ITIS G.Galilei","Deleghe",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Deleghe</h1>
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
                        <form action="deleghe.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
								<?php //if($_SESSION['is_admin']) : ?>
	                        	<a title="Add New" href="deleghe.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
								<button type="submit" value="delete" title="Delete Selected"  name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
                            	</button>
								<?php //endif; ?>
                        	</div>
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
										<tr>
											<th>Matricola</label></th>
											<th>Alunno</th>
											<th>Classe</th>
											<th>Delegati</th>
											<th>Deleganti</th>
											<th>Modifica</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * 
										            FROM deleghe;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL)
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
												echo "<td><input type=\"checkbox\" onClick=\"unAll()\" name=\"elem[]\" value=\"$row[4]\" id=\"$row[4]\"> $row[4]</td>";
												echo "<td>$row[0]</td>";
												echo "<td>$row[1]</td>";
												echo "<td>$row[2]</td>";
												echo "<td>$row[3]</td>";
												echo "<td><a href=\"deleghe.php?matricola=$row[4]&EDIT=1\" ><img src=\"".$pathImgPg.'edit.png'."\" title=\"Modifica\" align=\"center\" width=\"20\"></a></td>";
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
						if (isset($_GET['NEW'])){
						$query="SELECT * 
						          FROM Alunni
								  WHERE matricola NOT IN (SELECT matricola FROM deleghe)
								  ORDER BY cognome,nome,classe;";
						$res = querySql($connection,$query);
						?>
						<div class="row">
                            <div class="col-lg-6">
								<form action="deleghe.php" method="POST">
									<div class="form-group">
                                    	<label>Alunno</label>
										<select name="matricola" class="form-control" >
										<?php

											if($res!=NULL){
												while($row = $res->fetch_array()){
													    $stud=$row[0]." ".$row[1]." (".$row[8].")";
														echo '<option value="'.$row[4].'">'.$stud.'</option>';
													}
											}
										?>
										</select>
									</div>

                                    <div class="form-group">
                                    	<label>Delegati</label>
										<input name="delegati" type="text" size="5" class="form-control" onkeyup="limitText(this,200);">
                                    </div>
									<div class="form-group">
                                    	<label>Deleganti</label>
										<input name="deleganti" type="text" size="5" class="form-control" onkeyup="limitText(this,200);">
                                    </div>
                                    <div class="form-group">
                                    	<a href="deleghe.php" class="btn btn-warning">
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
                        if (isset($_GET['matricola'])){
							$matricola=$_GET['matricola'];
							if (isset($_GET['EDIT'])){ 
								$query = "SELECT * 
										  FROM deleghe
										  WHERE matricola='$matricola';";
								$result = querySql($connection,$query);
								if($result!=NULL){
									$row = $result->fetch_array();
									$matricola=$row[4];
									$alunno=$row[0];
									$classe=$row[1];
									$delegati=$row[2];
									$deleganti=$row[3];
									
						?>
								<div class="row">
									<div class="col-lg-6">
										<form action="deleghe.php" method="POST">
											<div class="form-group">
												
											<div class="form-group">
												<label>Matricola</label>
												<input type="text" class="form-control" value="<?php echo $matricola; ?>" disabled>
												<input type="hidden" name="matricola" class="form-control" value="<?php echo $matricola; ?>" >
											</div>
											<div class="form-group">
												<label>Alunno</label>
												<input type="text" class="form-control" value="<?php echo $alunno; ?>" disabled>
											</div>
											<div class="form-group">
												<label>Classe</label>
												<input type="text" class="form-control" value="<?php echo $classe; ?>" disabled>
											</div>
											<div class="form-group">
												<label>Delegati</label>
												<input name="delegati" type="text" size="5" class="form-control" value="<?php echo $delegati; ?>" onkeyup="limitText(this,200);">
											</div>
											<div class="form-group">
												<label>Deleganti</label>
												<input name="deleganti" type="text" size="5" class="form-control" value="<?php echo $deleganti; ?>" onkeyup="limitText(this,200);">
											</div>
											<div class="form-group">
												<!--<input type="submit" name="cmd" class="btn btn-default" value="add">-->
												<a href="deleghe.php" class="btn btn-warning">
													Cancel
												</a>
												<button class="btn btn-success" type="submit" value="update" name="cmd">
													Update
												</button>
											</div>
										</form>
									</div>
								</div>
								<?php	
									
							    }
						    }
							
						?>	
							
						
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
					$matricola = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE FROM deleghe WHERE matricola = '$matricola'";
					if($deleghe!=$_SESSION['DB_lipu'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){
				if($_POST['matricola']!=NULL){
					$matricola = mysqli_real_escape_string($connection, $_POST['matricola']);
					if($matricola!=""){
						$deleganti=mysqli_real_escape_string($connection,$_POST['deleganti']);
						$delegati=mysqli_real_escape_string($connection,$_POST['delegati']);
						$query = "SELECT * 
								  FROM alunni
								  WHERE matricola='$matricola';";
						$result = querySql($connection,$query);
						if($result!=NULL){
							$row = $result->fetch_array();
							$cognome=$row[0]; 
							$nome=$row[1];
							$alunno=$cognome." ".$nome;
							$classe=$row[8];						
							$query = "INSERT INTO deleghe (alunno,classe,delegati,deleganti,matricola,cognome,nome) VALUES ('$alunno','$classe','$delegati','$deleganti','$matricola','$cognome','$nome');";
							insertSql($connection,$query);
						}
					}
				}
			}
			else if($_POST['cmd']=="update"){
				if($_POST['matricola']!=NULL){
					$matricola = mysqli_real_escape_string($connection, $_POST['matricola']);
					if($matricola!=""){
						$deleganti=mysqli_real_escape_string($connection,$_POST['deleganti']);
						$delegati=mysqli_real_escape_string($connection,$_POST['delegati']);
						$query = "SELECT * 
								  FROM alunni
								  WHERE matricola='$matricola';";
						$result = querySql($connection,$query);
						if($result!=NULL){
							$row = $result->fetch_array();
							$cognome=$row[0]; 
							$nome=$row[1];
							$alunno=$cognome." ".$nome;
							$classe=$row[8];				
							$query = "UPDATE deleghe 
						                 SET alunno='$alunno',classe='$classe',delegati='$delegati',deleganti='$deleganti',cognome='$cognome',nome='$nome'
								       WHERE matricola = '$matricola'";

							insertSql($connection,$query);
						}
				}
			}
		}
		header("location: deleghe.php");
	}

?>
