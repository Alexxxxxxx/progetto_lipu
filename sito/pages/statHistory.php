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
		getHeaderHTML("ITIS","Searching - History",$dblipu);
	?>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Searching - HISTORY</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    		<form action="<?php echo "statHistory.php"; ?>" method="POST" onsubmit="return del();">
								<div class="text-right">
									<a href="">
										<img src="<?php echo $pathImgPg.'excel.png';?>" title="Export Table" alt="Excel" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatHistory')">
									</a>
									<!-- <button class="btn btn-default" onclick="exportExcel('dataTables-example', '<?php echo $_SESSION['DB_lipu'] ?>-StatHistory')">Export table</button> -->
								</div>

	                          	<div class="dataTable_wrapper">
			                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
			                                <thead>
			                                    <tr>
												    <th>Cntr</th>
													<th>Date/Time</th>
			                                        <th>Type</th>
													<th>Partner</th>
			                                        <th>F/M</th>
			                                        <th>Status</th>
													<th>Bk/Bl</th>
													<th>Order</th>
													<th>Seal 1</th>
													<th>Seal 2</th>
													<th>Line</th>
													<th>Ves/Voy</th>
													<!--<th>Voyage</th>-->
													<th>Weight</th>
													<!-- <th>Tare</th> 
													<th>Vgm</th> -->
													<th>Remarks</th>
													<!--<th>Edit</th>-->
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                <?php
			                                  $query = "SELECT DISTINCT movement.cntr,date,time,movement.sz,type.feet,movement.partner,movement.fm,movement.status,status.description,
																		bk,bl,movement.ord,movement.yard,pos,movement.line,ves,voy,cell,wt,movement.tare,vgm,remarks,seal1,seal2
														FROM movement,type,status 
														WHERE movement.sz=type.size_term
														AND movement.status=status.status
														AND (history=1 OR (history=0 AND (pos<>'' OR cell<>'')))
														AND date>='$dateStart'
														AND date<= '$dateEnd';";
												$result = querySql($connection,$query);

												if($result!=NULL){

													while($row = $result->fetch_array()){
														echo "<tr>";
														echo "<td>".$row['cntr']."</td>";//cntr
														echo "<td>".$row['date']." ".$row['time']."</td>";//date/time
														echo "<td>".$row['sz']." [".$row['feet']."]</td>";//size
														echo "<td>[".$row['partner']."]</td>";//partner
														echo "<td>[".$row['fm']."]</td>";//F/M
														echo "<td>".$row['status']."[".$row['description']."]</td>";//status
														
														$bkbl=trim($row['bk']);
														$bl=trim($row['bl']);
														if ($bkbl=="")
															if($bl=="")
																$bkbl="";
															else		
																$bkbl=trim($row['bl']);
														echo "<td>".$bkbl."</td>";//bk/bl
														echo "<td>".$row['ord']."</td>";//bk/bl
													    echo "<td>".$row['seal1']."</td>";//seal1
														echo "<td>".$row['seal2']."</td>";//seal2
														
														/*$poscel="P[".trim($row['pos'])."]";
														$cel=trim($row['cell']);
														if ($poscel=="P[]")
															if($cel=="")
																$poscel="";
															else		
																$poscel="C[".trim($cel)."]";
														echo "<td>".$poscel."</td>";//pos/cell*/
														
													    echo "<td>".$row['line']."</td>";//line
														echo "<td>".$row['ves']." ".$row['voy']."</td>";//ves/voy
														/*echo "<td>".$row['ves']."</td>";//ves
														echo "<td>".$row['voy']."</td>";//voy */
														echo "<td>".$row['wt']."</td>";//wt
														/*echo "<td>".$row['tare']."</td>";//tare
														$vgm='[N]';
														if ($row['vgm']==1) $vgm='[Y]';
														echo "<td>".$vgm."</td>";//vgm  */
														echo "<td>".$row['remarks']."</td>";//remarks
														//echo "<td><a href=\"form.php?id_container=".$row['cntr']."&date=".$row['date']."&time=".$row['time']."\"><img src=\"".$pathImgPg.'bd_edit.png'."\" title=\"edit\" align=\"left\" width=\"15\"></a></td>";
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