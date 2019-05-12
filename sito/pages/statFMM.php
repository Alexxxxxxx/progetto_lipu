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
		getHeaderHTML("ITIS","Statistics - EMPTY",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Statistics - EMPTY</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    		<form action="<?php echo "statFMM.php"; ?>" method="POST" onsubmit="return del();">
								<div class="text-right">
									<a href="">
										<img src="<?php echo $pathImgPg.'excel.png';?>" title="Export Table" alt="Excel" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatisticsFMM')">
									</a>
									<!-- <button class="btn btn-default" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatisticsFMM')">Export table</button> -->
								</div>

	                          	<div class="dataTable_wrapper">
			                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
			                                <thead>
			                                    <tr>
			                                        <th>Date</th>
			                                        <th>In</th>
			                                        <th>Out</th>
			                                        <th>Tot</th>
													<th>F/M</th>
													<!--<th>From</th>
													<th>UpTo</th>-->
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                <?php
											 $totIin=0;
											 $totIout=0;
											 $fm='M'; //$_GET['fm'];
											 /*$queryFTi = "
														   WHERE ((movement.status IN (SELECT status FROM status WHERE gate_in=1) AND interchange=1) 
																	OR (movement.status IN (SELECT status FROM status WHERE discharging=1) AND coarri=1)) 
														   WHERE ((movement.status IN (SELECT status FROM status WHERE gate_out=1) AND interchange=1) 
																	  OR (movement.status IN (SELECT status FROM status WHERE loading=1) AND codeco=1)) 
															*/
											$queryFTi = "SELECT SUM(feet/20) AS totin 
														   FROM movement,(SELECT DISTINCT size_term, feet FROM type) AS T0 
														   WHERE movement.status IN (SELECT status FROM status WHERE in_out='I')  
															AND movement.sz=T0.size_term 
															AND fm='$fm' 
															AND (date<'$dateStart');";
											 $result = querySql($connection,$queryFTi);

												if($result!=NULL){
													$row = $result->fetch_array();
													$totIin=intval($row['totin']);
												}
											 $queryFTo = "SELECT SUM(feet/20) AS totout 
														   FROM movement,(SELECT DISTINCT size_term, feet FROM type) AS T0 
														   WHERE movement.status IN (SELECT status FROM status WHERE in_out='O') 
															AND movement.sz=T0.size_term 
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
											echo "<td>$dayb</td>";//Date
											echo "<td>...</td>";//TotIn
											echo "<td>...</td>";//TotOut
											echo "<td>$totFi</td>";//TotGen
											echo "<td>$fm</td>";//FM
											echo "</tr>";
											
											$queryF="SELECT date,movement.fm,feet,in_out
		                                               FROM	movement, (SELECT DISTINCT size_term, feet FROM type) AS TS1,status
													   WHERE movement.sz=TS1.size_term
													     AND movement.status=status.status
														 AND movement.fm='$fm' 
														 AND (date>='$dateStart' AND date<='$dateEnd')
													   ORDER BY date,in_out;";
											//die($queryF);		  
											$result = querySql($connection,$queryF);

											if($result!=NULL){
												$rs_ok=($row = $result->fetch_array());
												if($rs_ok){
													$dt=$row['date'];
													if($dt>$dateStart){
														$dti=$dt;
														$dt=$dateStart;
														while ($dt<$dti){
															echo "<tr>";
															echo "<td>$dt</td>";//Date
															echo "<td>0</td>";//In
															echo "<td>0</td>";//Out
															echo "<td>$totFi</td>";//TotGen
															echo "<td>$fm</td>";//FM
															echo "</tr>";	
															$dt=day_after(substr($dt, 8, 2),substr($dt, 5, 2),substr($dt, 0, 4));
														} 
													}
												}
												while ($rs_ok){
													$dt=$row['date'];
													$qin=0;
													$qout=0;
													while($row['date']==$dt){
													 $qt=intval($row['feet']/20);
													 if($row['in_out']=='I')
													   $qin+=$qt;
													 else 
													   $qout+=$qt;
												
													 $rs_ok=($row = $result->fetch_array());
													 if (!$rs_ok) break;
													 
													}
													$totFi=$totFi+$qin-$qout;
													echo "<tr>";
													echo "<td>$dt</td>";//Date
													echo "<td>$qin</td>";//In
													echo "<td>$qout</td>";//Out
													echo "<td>$totFi</td>";//TotGen
													echo "<td>$fm</td>";//FM
													echo "</tr>";
													$dtsuc=day_after(substr($dt, 8, 2),substr($dt, 5, 2),substr($dt, 0, 4));
													if ($row['date']!=$dtsuc){
														while (($row['date']!=$dtsuc) && ($dtsuc<=$dateEnd)){
															echo "<tr>";
															echo "<td>$dtsuc</td>";//Date
															echo "<td>0</td>";//In
															echo "<td>0</td>";//Out
															echo "<td>$totFi</td>";//TotGen
															echo "<td>$fm</td>";//FM
															echo "</tr>";	
															$dtsuc=day_after(substr($dtsuc, 8, 2),substr($dtsuc, 5, 2),substr($dtsuc, 0, 4));
														}
													}
													if(!$rs_ok)	break;
												}	  
											}
											
											
											
											/*$queryF = "SELECT * 
														FROM 
															(SELECT date as data,SUM(feet/20) AS q_in 
															  FROM movement,(SELECT DISTINCT size_term, feet FROM type) AS TS1 
															  WHERE movement.status IN (SELECT status FROM status WHERE in_out='I') 
																	  AND movement.sz=TS1.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T1 
															LEFT JOIN 
															(SELECT date,SUM(feet/20) AS q_out 
															  FROM movement,(SELECT DISTINCT size_term, feet FROM type) AS TS2 
															  WHERE movement.status IN (SELECT status FROM status WHERE in_out='O') 
																	  AND movement.sz=TS2.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T2 ON T1.data=T2.date
													  UNION
													  SELECT * 
													   FROM 
															(SELECT date as data,SUM(feet/20) AS q_in 
															  FROM movement,(SELECT DISTINCT size_term, feet FROM type) AS TS3 
															  WHERE movement.status IN (SELECT status FROM status WHERE in_out='I') 
																	  AND movement.sz=TS3.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T3 
															RIGHT JOIN 
															(SELECT date,SUM(feet/20) AS q_out 
															  FROM movement,(SELECT DISTINCT size_term, feet FROM type) AS TS4 
															  WHERE movement.status IN (SELECT status FROM status WHERE in_out='O') 
																	  AND movement.sz=TS4.size_term 
																	  AND fm='$fm' 
																	  AND (date>='$dateStart' AND date<='$dateEnd') 
															  GROUP BY date) AS T4 ON T3.data=T4.date;";
//die($queryF);
												$result = querySql($connection,$queryF);

												if($result!=NULL){
														$i=0;
														while($row = $result->fetch_array()){
															
															if($row['data']==NULL)
																$dt=$row['date'];
															else
																$dt=$row['data'];
															
															$qin=intval($row['q_in']);
															$qout=intval($row['q_out']);
															
															$cntr_io[$i][0] = $dt;
															$cntr_io[$i][1] = $qin;
															$cntr_io[$i][2] = $qout;
															$i++;
														}
														foreach ($cntr_io as $key => $row) {
																	$data[$key]  = $row[0];
																	$q_in[$key] = $row[1];
																	$q_out[$key] = $row[2];
														}			
												
														array_multisort($data, SORT_ASC, $cntr_io);
														for($j=0;$j<$i;$j++){
														  $row=$cntr_io[$j];
														  $totFi=intval($totFi)+intval($row[1])-intval($row[2]);
														  echo "<tr>";
														  echo "<td>$row[0]</td>";//Date
														  echo "<td>$row[1]</td>";//In
														  echo "<td>$row[2]</td>";//Out
														  echo "<td>$totFi</td>";//TotGen
														  echo "<td>$fm</td>";//FM
														  echo "</tr>";
														} 
												}*/
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