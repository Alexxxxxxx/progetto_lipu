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
		getHeaderHTML("ITIS G.Galilei","Studenti",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Studenti</h1>
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
                        <form action="studenti.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
	                        	<!--<input type="checkbox" onClick="toggle(this);" id="all">-->
								<?php if($_SESSION['is_admin']) : ?>
	                        	<a title="Add New" href="studenti.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
								<button type="submit" value="delete" title="Delete Selected"  name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
                            	</button>
								<?php endif; ?>
                        	</div>
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
										<tr>
											<th>Matricola</label></th>
											<th>Cognome</th>
											<th>Nome</th>
											<th>Classe</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * 
										            FROM alunni 
													ORDER BY cognome, nome;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL)
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
												echo "<td><input type=\"checkbox\" onClick=\"unAll()\" name=\"elem[]\" value=\"$row[4]\" id=\"$row[4]\"> $row[4]</td>";
												echo "<td>$row[0]</td>";
												echo "<td>$row[1]</td>";
												echo "<td>[$row[8]]</td>";
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
						 $matricola="";
						 $cognome="";
						 $nome="";
						 $datan="";
						 $cod_fisc="";
						 $e_mail="";
						 $tel="";
						 $cell="";
						 $classe="";
						 $cognome_pa="";
						 $nome_pa="";
						 $telefono_pa="";
						 $cognome_ma="";
						 $nome_ma="";
						 $cell_ma="";
						 $email_pa="";
						 $email_ma="";
						 $email_gen="";
						 ?>
						<div class="row">
                            <div class="col-lg-6">
								    <form action="studenti.php" method="POST">
        
        
<!-- riga 1---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Matricola</label>
															<input type="text" name="matricola" class="form-control" onkeyup="limitText(this,8)"  value="<?php echo $matricola; ?>" >
					                                    </div>
					                                </div>
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Classe</label>
															<input type="text" name="classe" class="form-control" onkeyup="limitText(this,8)" value="<?php echo $classe; ?>" >
					                                    </div>
					                                </div>
												
													<div class="col-lg-4">
														<div class="form-group">
															<label>Cognome</label>
															<input type="text" name="cognome" class="form-control" onkeyup="limitText(this,60)" value="<?php echo $cognome; ?>" >
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Nome</label>
															<input type="text"  name="nome" class="form-control" onkeyup="limitText(this,60)" value="<?php echo $nome; ?>" >
					                                    </div>
					                                </div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Data nascita</label>
															<input type="date"  name="datan" class="form-control" value="<?php echo $datan; ?> " >
					                                    </div>
					                                </div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>C.Fiscale</label>
															<input type="text"  name="cod_fisc" class="form-control" onkeyup="limitText(this,16)" value="<?php echo $cod_fisc; ?>" >
														</div>
													</div>
					                            </div>
<!-- riga 2---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>Telefono</label>
															<input type="text"  name="tel" class="form-control" onkeyup="limitText(this,16)" value="<?php echo $tel; ?>" >
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Cellulare</label>
															<input type="text" name="cell" class="form-control" onkeyup="limitText(this,16)" value="<?php echo $cell; ?>" >
					                                    </div>
					                                </div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>e-mail</label>
															<input type="text" name="e_mail" class="form-control" value="<?php echo $e_mail; ?>" >
					                                    </div>
					                                </div>
					                            </div>
<!-- riga 3---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
												    <div class="col-lg-4">
														<div class="form-group">
															<label>PADRE</label>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Cognome</label>
															<input type="text"  name="cognome_pa" class="form-control" onkeyup="limitText(this,60)" value="<?php echo $cognome_pa; ?>" >
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Nome</label>
															<input type="text"  name="nome_pa" class="form-control" onkeyup="limitText(this,60)" value="<?php echo $nome_pa; ?>" >
					                                    </div>
					                                </div>
												</div>
<!-- riga 4---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
											    <div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; rif. </label>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Telefono</label>
															<input type="text" name="telefono_pa" class="form-control" onkeyup="limitText(this,16)" value="<?php echo $telefono_pa; ?>" >
					                                    </div>
					                                </div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>e-mail</label>
															<input type="text"  name="email_pa" class="form-control" value="<?php echo $email_pa; ?>" >
					                                    </div>
					                                </div>
					                            </div>
<!-- riga 5---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
												    <div class="col-lg-4">
														<div class="form-group">
															<label>MADRE</label>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Cognome</label>
															<input type="text"  name="cognome_ma" class="form-control" onkeyup="limitText(this,60)" value="<?php echo $cognome_ma; ?>" >
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Nome</label>
															<input type="text"  name="nome_ma" class="form-control" onkeyup="limitText(this,60)" value="<?php echo $nome_ma; ?>" >
					                                    </div>
					                                </div>
												</div>
<!-- riga 6---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
											    <div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; rif. </label>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Telefono</label>
															<input type="text"  name="cell_ma" class="form-control" onkeyup="limitText(this,16)" value="<?php echo $cell_ma; ?>" >
					                                    </div>
					                                </div>
													<div class="col-lg-4">
														<div class="form-group">
					                                    	<label>e-mail</label>
															<input type="text" name="email_ma" class="form-control" value="<?php echo $email_ma; ?>" >
					                                    </div>
					                                </div>
					                            </div>
<!-- riga 7---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; rif. </label>
														</div>
													</div>
												    <div class="col-lg-4">
														<div class="form-group">
					                                    	<label>e-mail genitori</label>
															<input type="text" name="email_gen" class="form-control" value="<?php echo $email_gen; ?>" >
					                                    </div>
					                                </div>
					                            </div>												
<!-- riga 8---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->	
												<div class="row">
													<div class="col-lg-4">
														<!--<input type="submit" name="cmd" class="btn btn-default" value="add">-->
														<a href="studenti.php" class="btn btn-warning">
															Cancel
														</a>
														<button class="btn btn-success" type="submit" value="add" name="cmd">
															Add
														</button>
													</div>
												</div>
					                    </form>
							</div>
						</div>
					</div>
						<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
<?php
	getFooterHTML();
	}
	else{ 
			if($_POST['cmd']=="delete"){
				$i = 0;
				while(isset($_POST['elem'][$i])){
					$matricola = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE FROM alunni WHERE matricola = '$matricola'";
					if($studenti!=$_SESSION['DB_lipu'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){

				if($_POST['matricola']!=NULL){
					$matricola = mysqli_real_escape_string($connection, $_POST['matricola']);
					if($matricola!=""){
						 $cognome=mysqli_real_escape_string($connection, $_POST['cognome']);
						 $nome=mysqli_real_escape_string($connection, $_POST['nome']);
						 $datan=mysqli_real_escape_string($connection, $_POST['datan']);
						 $datan=substr($datan, 6)."-".substr($datan, 3, 2)."-".substr($datan, 0, 2);
						 $cod_fisc=mysqli_real_escape_string($connection, $_POST['cod_fisc']);
						 $e_mail=mysqli_real_escape_string($connection, $_POST['e_mail']);
						 $tel=mysqli_real_escape_string($connection, $_POST['tel']);
						 $cell=mysqli_real_escape_string($connection, $_POST['cell']);
						 $classe=mysqli_real_escape_string($connection, $_POST['classe']);
						 $cognome_pa=mysqli_real_escape_string($connection, $_POST['cognome_pa']);
						 $nome_pa=mysqli_real_escape_string($connection, $_POST['nome_pa']);
						 $telefono_pa=mysqli_real_escape_string($connection, $_POST['telefono_pa']);
						 $cognome_ma=mysqli_real_escape_string($connection, $_POST['cognome_ma']);
						 $nome_ma=mysqli_real_escape_string($connection, $_POST['nome_ma']);
						 $cell_ma=mysqli_real_escape_string($connection, $_POST['cell_ma']);
						 $email_pa=mysqli_real_escape_string($connection, $_POST['email_pa']);
						 $email_ma=mysqli_real_escape_string($connection, $_POST['email_ma']);
						 $email_gen=mysqli_real_escape_string($connection, $_POST['email_gen']);
						 $query = "INSERT INTO alunni (cognome,nome,datan,cod_fisc,matricola,e_mail,tel,cell,classe,cognome_pa,nome_pa,telefono_pa,cognome_ma,nome_ma,cell_ma,email_pa,email_ma,email_gen) 
										 VALUES ('$cognome','$nome','$datan','$cod_fisc','$matricola','$e_mail','$tel','$cell','$classe','$cognome_pa','$nome_pa','$telefono_pa',
										         '$cognome_ma','$nome_ma','$cell_ma','$email_pa','$email_ma','$email_gen');";
						insertSql($connection,$query);
				}
			}
		}
		header("location: studenti.php");
	}

?>
