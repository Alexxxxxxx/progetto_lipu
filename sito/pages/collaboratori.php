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
		getHeaderHTML("ITIS G.Galilei","Collaboratori",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Collaboratori</h1>
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
                        <form action="collaboratori.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
	                        	<!--<input type="checkbox" onClick="toggle(this);" id="all">-->
								<?php if($_SESSION['is_admin']) : ?>
	                        	<a title="Add New" href="collaboratori.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
								<button type="submit" value="delete" title="Delete Selected"  name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
                            	</button>
								<?php endif; ?>
                        	</div>
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
										<tr>
											<th>Collaboratore</label></th>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * 
										            FROM collaboratori;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL)
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
												echo "<td><input type=\"checkbox\" onClick=\"unAll()\" name=\"elem[]\" value=\"$row[0]\" id=\"$row[0]\"> $row[0]</td>";
										?>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</form>

						<?php } else{ ?>
						<div class="row">
                            <div class="col-lg-6">
								<form action="collaboratori.php" method="POST">
                                    <div class="form-group">
                                    	<label>Collaboratore</label>
										<input name="collaboratore" type="text" size="5" class="form-control" onkeyup="limitText(this,30);">
                                    </div>
                                    <div class="form-group">
                                    	<!--<input type="submit" name="cmd" class="btn btn-default" value="add">-->
										
                                    	<a href="collaboratori.php" class="btn btn-warning">
                                    		Cancel
                                    	</a>
                                    	<button class="btn btn-success" type="submit" value="add" name="cmd">
                                    		Add
                                    	</button>
										
                                    </div>
								</form>
							</div>
						</div>
						<?php } ?>
					</div>
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
					$collaboratore = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE 
					            FROM collaboratori 
								WHERE collaboratore = '$collaboratore'";
					if($collaboratori!=$_SESSION['DB_lipu'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){
				if($_POST['collaboratore']!=NULL){
					$collaboratore = mysqli_real_escape_string($connection, $_POST['collaboratore']);
					if($collaboratore!=""){
						$is_admin=$_POST['is_admin'];
						$query = "INSERT INTO collaboratori (collaboratore) VALUES ('$collaboratore');";
						insertSql($connection,$query);
				}
			}
		}
		header("location: collaboratori.php");
	}

?>
