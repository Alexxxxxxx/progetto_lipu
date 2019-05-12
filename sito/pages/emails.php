<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	if(isset($_SESSION['DB_lipu']) && $_SESSION['is_admin'])
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
	if(!$_POST){
		getHeaderHTML("ITIS","EDI Email List",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">EDI Email List</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    	<?php if(!isset($_GET['NEW'])){ ?>
                    	<?php if(isset($_GET['ERR'])){ ?>
                    		<div class="alert alert-danger">
                    		<?php
                    		if($_GET['ERR']==1)
                    			echo "DELETE ERROR";
                    		else
                    			echo "INSERT ERROR";
                    		?>
                    		</div>
                    	<?php } ?>
                        <form action="emails.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
	                        	<!--<input type="checkbox" onClick="toggle(this);" id="all">-->
	                        	<a title="Add New"  href="emails.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
								<button type="submit" title="Delete Selected" value="delete" name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
                            	</button>
                        	</div>
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
	                                    <tr>
                                            <th>Select</th>
	                                        <th>Email</th>
	                                        <th>Description</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                <?php
	                                   	$query = "SELECT * FROM edimail;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL){
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
                                                echo "<td><input type=\"checkbox\" name=\"elem[]\" value=\"$row[0]\" id=\"$row[0]\"></td>";
												echo "<td>$row[0]</td>";
												echo "<td>$row[1]</td>";
												echo "</tr>";
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</form>

						<?php } else{ ?>
						<div class="row">
                            <div class="col-lg-6">
								<form action="emails.php" method="POST">
                                    <div class="form-group">
                                    	<label>Email</label>
										<input name="email" type="text" size="5" class="form-control" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                    	<label>Description</label>
										<input name="description" type="text" size="10" class="form-control" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                    	<!--<input type="submit" name="cmd" class="btn btn-default" value="add">-->
                                    	<a href="emails.php" class="btn btn-warning">
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
		$error = 0;
		if($_POST['cmd']=="delete"){
			$i = 0;
			while(isset($_POST['elem'][$i])){
				$email = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
				$query = "DELETE FROM edimail WHERE email = '$email'";
				if(insertSql($connection,$query)==-1)
					$error = 1;
				$i++;
			}
		}
		else if($_POST['cmd']=="add"){
			if($_POST['email']!=NULL){
				$email = mysqli_real_escape_string($connection, $_POST['email']);
				if($email!=""){
					$description = mysqli_real_escape_string($connection, $_POST['description']);
					$query = "INSERT INTO edimail (email,description) VALUES ('$email','$description');";
					if(insertSql($connection,$query)==-1)
						$error = 2;
				}
			}
		}
		if($error!=0)
			header("location: emails.php?ERR=".$error);
		else
			header("location: emails.php");
	}

?>
