<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";
	require_once "../lib/PHPExcel.php";

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
	$dateStart=$_GET['date_start'];
	$dateEnd=$_GET['date_end'];
	if(!$_POST){
		getHeaderHTML("ITIS","Statistics - EMPTY/FULL",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Statistics - EMPTY/FULL</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    		<form action="<?php echo "statEF.php"; ?>" method="POST" onsubmit="return del();">
								<div class="text-right">
									<a href="">
										<img src="<?php echo $pathImgPg.'excel.png';?>" title="Export Table" alt="Excel" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatisticsEF')">
									</a>
									<!-- <button class="btn btn-default" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatisticsEF')">Export table</button> -->
								</div>

	                          	<div class="dataTable_wrapper">
			                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
			                                <thead>
			                                    <tr>
			                                        <th>Type</th>
			                                        <th>Description</th>
			                                        <th>Full</th>
			                                        <th>Empty</th>
													<th>From</th>
													<th>UpTo</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                <?php
			                                  /*$query = "SELECT type.size_term,type.description,n_full,n_empty 
														FROM type,(SELECT sz,COUNT(*) AS n_full
																	FROM movement 
																	WHERE yard <> '' 
																	AND fm='F'
																	AND date >= '$dateStart' AND (datec<='$dateEnd' OR datec IS NULL)
																	GROUP BY sz) AS T1,
																  (SELECT sz,COUNT(*) AS n_empty
																	FROM movement,type 
																	WHERE yard <> '' 
																	AND fm='M'
																	AND date >= '$dateStart' AND (datec<='$dateEnd' OR datec IS NULL)
																	GROUP BY sz ) AS T2
														WHERE T1.sz=type.size_term
														AND T2.sz=type.size_term;";*/
											 $query = "SELECT DISTINCT type.size_term,type.description,n_full,n_empty 
														FROM (type LEFT OUTER JOIN (SELECT sz,COUNT(*) AS n_full 
																					FROM movement 
																					WHERE ((movement.status IN (SELECT status FROM status WHERE gate_in=1) AND interchange=1) 
																					     OR (movement.status IN (SELECT status FROM status WHERE discharging=1) AND coarri=1)) 
																					AND fm='F' 
																					AND date <= '$dateEnd' 
																					AND (datec>='$dateStart' OR datec IS NULL) 
																					GROUP BY sz) AS T1 ON T1.sz=type.size_term) 
																   LEFT OUTER JOIN (SELECT sz,COUNT(*) AS n_empty 
																					FROM movement 
																					WHERE ((movement.status IN (SELECT status FROM status WHERE gate_in=1) AND interchange=1) 
																					     OR (movement.status IN (SELECT status FROM status WHERE discharging=1) AND coarri=1))
																					AND fm='M' 
																					AND date <= '$dateEnd' 
																					AND (datec>='$dateStart' OR datec IS NULL) 
																					GROUP BY sz ) AS T2 ON T2.sz=type.size_term;";
																					
												$result = querySql($connection,$query);

												if($result!=NULL){

													while($row = $result->fetch_array()){
														echo "<tr>";
														echo "<td>$row[0]</td>";//size
														echo "<td>$row[1]</td>";//description
														if($row[2]<>"") echo "<td>$row[2]</td>";//num_full
														else echo "<td>0</td>";//num_full
														if($row[3]<>"") echo "<td>$row[3]</td>";//num_empty
														else echo "<td>0</td>";//num_empty
														echo "<td>$dateStart</td>";//from
														echo "<td>$dateEnd</td>";//upto
														echo "</tr>";
														}

													}
												?>
											</tbody>
										</table>
								</div>
							</form>
						<?php
	getFooterHTML();
	}

	$connection->close();


?>