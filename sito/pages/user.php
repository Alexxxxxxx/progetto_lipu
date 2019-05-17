<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	if(isset($_SESSION['DB_lipu']) && $_SESSION['is_admin'] == 1)
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
	if(!$_POST){
		getHeaderHTML("LIPU","Operatori",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Operatori</h1>
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
                        <form action="user.php" method="POST" onsubmit="return del();">
	                        <div align="right">
	                        	<a title="Deselect All" onClick="toggle(false);" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-unchecked"></i></a>
	                        	<a title="Select All" onClick="toggle(true);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-check"></i></a>
	                        	<!--<input type="checkbox" onClick="toggle(this);" id="all">-->
	                        	<a title="Add New" href="user.php?NEW=1" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
								<button type="submit" value="delete" title="Delete Selected"  name="cmd" class="btn btn-danger btn-circle">
									<i class="fa fa-times"></i>
                            	</button>
                        	</div>
                          	<div class="dataTable_wrapper">
	                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
										<tr>
											<th>User</label></th>
											<th>Password</th>
											<th>Type</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * FROM user;";
										$result = querySql($connection,$query);
										$j = 0;
										if($result!=NULL)
											while($row = $result->fetch_array()){
												$j++;
												echo "<tr>";
												echo "<td><input type=\"checkbox\" onClick=\"unAll()\" name=\"elem[]\" value=\"$row[0]\" id=\"$row[0]\"> $row[0]</td>";
												echo "<td>*******</td>";
												echo "<td>";
												if($row["is_admin"]==1)
													echo "ADMIN";
												else if($row["is_admin"]==0)
													echo "VETERINARIO";	
												else
													echo "USER";
												echo "</td>";
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
								<form action="user.php" method="POST">
                                    <div class="form-group">
                                    	<label>User</label>
										<input name="user" type="text" size="5" class="form-control" onkeyup="limitText(this,20);">
                                    </div>
                                    <div class="form-group">
                                    	<label>Password</label>
										<input name="password" type="password" size="5" class="form-control">
                                    </div>
                                    <div class="form-group">
                                    	<label>Type</label>
										<select name="is_admin">
											<option value="-1">USER</option>
											<option value="0">VETERINARIO</option>
											<option value="1">ADMIN</option>
										</select>
                                    </div>
                                    <div class="form-group">
                                    	<!--<input type="submit" name="cmd" class="btn btn-default" value="add">-->
                                    	<a href="user.php" class="btn btn-warning">
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
					$user = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE FROM user WHERE user = '$user'";
					if($user!=$_SESSION['DB_username'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){
				if($_POST['user']!=NULL){
					$user = mysqli_real_escape_string($connection, $_POST['user']);
					if($user!=""){
						$password = mysqli_real_escape_string($connection, $_POST['password']);
						$is_admin=$_POST['is_admin'];
						$password = crypt($password, $seed);
						$query = "INSERT INTO user (user,password,is_admin) VALUES ('$user','$password','$is_admin');";
						insertSql($connection,$query);
				}
			}
		}
		header("location: user.php");
	}

?>
