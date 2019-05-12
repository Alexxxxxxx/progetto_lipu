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
										<img src="<?php echo $pathImgPg.'excel.png';?>" title="Export Table" alt="Excel" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatisticsFM')">
									</a>
									<!-- <button class="btn btn-default" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatisticsFM')">Export table</button> -->
								</div>

	                          	<div class="dataTable_wrapper">
			                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
			                                <thead>
			                                    <tr>
			                                        <th>In</th>
			                                        <th>Out</th>
			                                        <th>Tot</th>
			                                        <th>Date</th>
													<th>F/M</th>
													<!--<th>From</th>
													<th>UpTo</th>-->
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                <?php
			                                 $totIin=0;
											 $totIout=0;
											 $fm='F'; //$_GET['fm'];
											 $queryFTi = "SELECT SUM(feet/20) AS totin 
														   FROM movement,type 
														   WHERE ((movement.status IN (SELECT status FROM status WHERE gate_in=1) AND interchange=1) 
																	OR (movement.status IN (SELECT status FROM status WHERE discharging=1) AND coarri=1)) 
															AND movement.sz=type.size_term 
															AND fm='$fm' 
															AND (date<'$dateStart');"; 

											 $result = querySql($connection,$queryFTi);

												if($result!=NULL){
													$row = $result->fetch_array();
													$totIin=intval($row['totin']);
												}
											 $queryFTo = "SELECT SUM(feet/20) AS totout 
														   FROM movement,type 
														   WHERE ((movement.status IN (SELECT status FROM status WHERE gate_out=1) AND interchange=1) 
																	OR (movement.status IN (SELECT status FROM status WHERE loading=1) AND codeco=1)) 
															AND movement.sz=type.size_term 
															AND fm='$fm' 
															AND (date<'$dateStart');"; 
											 $result = querySql($connection,$queryFTo);

												if($result!=NULL){
													$row = $result->fetch_array();
													$totIout=intval($row['totout']);
												}
											$totFi=$totIin-$totIout;
											$dayb=day_before(substr($dateStart, 8, 2),substr($dateStart, 5, 2),substr($dateStart, 0, 4)); 
											echo "<tr>";
											echo "<td>...</td>";//TotIn
											echo "<td>...</td>";//TotOut
											echo "<td>$totFi</td>";//TotGen
											echo "<td>$dayb</td>";//Date
											echo "<td>$fm</td>";//FM
											/*echo "<td>$dateStart</td>";//from
											echo "<td>$dateEnd</td>";//upto*/
											echo "</tr>";
		
											$queryF = "SELECT * 
														FROM 
															(SELECT date as data,SUM(feet/20) AS q_in 
															  FROM movement,type 
															  WHERE ((movement.status IN (SELECT status FROM status WHERE gate_in=1) AND interchange=1) 
																	  OR (movement.status IN (SELECT status FROM status WHERE discharging=1) AND coarri=1)) 
																	  AND movement.sz=type.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T1 
															LEFT JOIN 
															(SELECT date,SUM(feet/20) AS q_out 
															  FROM movement,type 
															  WHERE ((movement.status IN (SELECT status FROM status WHERE gate_out=1) AND interchange=1) 
																	  OR (movement.status IN (SELECT status FROM status WHERE loading=1) AND codeco=1)) 
																	  AND movement.sz=type.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T2 ON T1.data=T2.date
													  UNION
													  SELECT * 
													   FROM 
															(SELECT date as data,SUM(feet/20) AS q_in 
															  FROM movement,type 
															  WHERE ((movement.status IN (SELECT status FROM status WHERE gate_in=1) AND interchange=1) 
																	  OR (movement.status IN (SELECT status FROM status WHERE discharging=1) AND coarri=1)) 
																	  AND movement.sz=type.size_term AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T3 
															RIGHT JOIN 
															(SELECT date,SUM(feet/20) AS q_out FROM movement,type 
															  WHERE ((movement.status IN (SELECT status FROM status WHERE gate_out=1) AND interchange=1) 
																	  OR (movement.status IN (SELECT status FROM status WHERE loading=1) AND codeco=1)) 
																	  AND movement.sz=type.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T4 ON T3.data=T4.date;";

												$result = querySql($connection,$queryF);

												if($result!=NULL){

													while($row = $result->fetch_array()){
														$in=intval($row['q_in']);
														$out=intval($row['q_out']);
														$totFi=$totFi+$in-$out;
														echo "<tr>";
														echo "<td>$in</td>";//In
														echo "<td>$out</td>";//Out
														echo "<td>$totFi</td>";//TotGen
														echo "<td>".$row['data']."</td>";//Date
														/*echo "<td>$dateStart</td>";//from
														echo "<td>$dateEnd</td>";//upto*/
														echo "<td>$fm</td>";//FM
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