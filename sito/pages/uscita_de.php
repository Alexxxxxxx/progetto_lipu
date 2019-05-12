<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	//	Se il terminal non è stato settato l'utente non ha effettuato il login
	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	//	Apertura della connessione
	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
?>

<?php

    //Inizializza i campi
    if(isset($_GET['matricola']))
    {
        $matricola = mysqli_real_escape_string($connection, $_GET['matricola']);
       
    }
    else
    {
        $matricola = mysqli_real_escape_string($connection, $_POST['matricola']);
       
    }

    $cntr = trim($cntr);
	$date = date("Y-m-d");
    $time = date("H:i:s");
    $type = "";
    $tare = "";
    $status = "";
    $partner = "";
    $seal1 = "";
    $seal2 = "";
    $seal3 = "";
    $seal4 = "";
    $weight = "";
    $bk_bl = "";
    $order = "";
    $vessel = "NONE";
    $voyage = "NONE";
    $pol = "";
    $pod = "";
    $yard = "";
    $pos = "";
    $driver = "";
    $plate = "";
    $remarks = "";
	$query = "SELECT * 
	            FROM alunni
				WHERE matricola=$matricola;";

								$result = querySql($connection,$query);
								if($result!=NULL){
									$row = $result->fetch_array();

										$bk_bl=$row[15];
										$order=$row[17];
										$vessel = $row[18];
										$voyage = $row[19];
										$pol=$row[20];
										$pod=$row[21];
										$coarri = $row[33];
										$fm=$row["fm"];

										$close = 0; //	Come predefinito setto il viaggio come non chiuso
										$query_vesvoy = "SELECT close FROM voyage WHERE voyage='$voyage' AND vessel='$vessel';";
										$result_vesvoy = querySql($connection,$query_vesvoy);
										if($result_vesvoy!=NULL){
											$row_vesvoy = $result_vesvoy->fetch_array();
											$close = $row_vesvoy[0];
										}
								}

            if($result!=NULL){
                $type = $row[2];
				$fm = $row[3]; 
                $tare = $row[4];
                $status = $row[5];
                $partner = $row[9];
                $seal1 = $row[10];
                $seal2 = $row[11];
                $seal3 = $row[12];
                $seal4 = $row[13];
                $weight = $row[14];

                $bk_bl = $row[15];
                $order = $row[17];
                $vessel = $row[18];
                $voyage = $row[19];
                $pol = $row[20];
                $pod = $row[21];
                $yard = $row[24];
                $pos = $row[25];
				$vesvoy = $vessel . ',' . $voyage;
				if ($fm=="M"){
					$seal1 = "";
                    $seal2 = "";
                    $seal3 = "";
                    $seal4 = "";
					$bk_bl = "";
					$order = "";
					$vessel="";
					$voyage="";
					$pol="";
					$pod="";
				}
            }

    if(isset($_GET['status']))
        $status = $_GET['status'];

    if(isset($_GET['date']))
        $date = $_GET['date'];

    if(isset($_GET['time']))
        $time = $_GET['time'];

    if(isset($_GET['type']))
        $type = $_GET['type'];

    if(isset($_GET['partner']))
        $partner = $_GET['partner'];

    if(isset($_GET['seal1']))
        $seal1 = $_GET['seal1'];

    if(isset($_GET['seal2']))
        $seal2 = $_GET['seal2'];

    if(isset($_GET['seal3']))
        $seal3 = $_GET['seal3'];

    if(isset($_GET['seal4']))
        $seal4 = $_GET['seal4'];

    if(isset($_GET['weight']))
        $weight = $_GET['weight'];

    if(isset($_GET['bk_bl']))
        $bk_bl = $_GET['bk_bl'];

    if(isset($_GET['order']))
        $order = $_GET['order'];

    if(isset($_GET['vesvoy']))
        $vesvoy = $_GET['vesvoy'];
    else
        $vesvoy = $vessel . ',' . $voyage;

    if(isset($_GET['pol']))
        $pol = $_GET['pol'];

    if(isset($_GET['pod']))
        $pod = $_GET['pod'];

    if(isset($_GET['yard']))
        $yard = $_GET['yard'];

    if(isset($_GET['pos']))
        $pos = $_GET['pos'];

    if(isset($_GET['driver']))
        $driver = $_GET['driver'];

    if(isset($_GET['plate']))
        $plate = $_GET['plate'];

    if(isset($_GET['remarks']))
        $remarks = $_GET['remarks'];
?>

<?php
	if(!$_POST) :
?>

<!-- Mostra la form -->

<?php getHeaderHTML("ITIS", "Gate Out - DATA ENTRY",$dblipu); ?>

<div id="page-wrapper">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Gate Out - DATA ENTRY</h1>
		</div>
	</div>

    <?php
        //In caso di successo, mostra l'alert
        if(isset($_GET['err'])) :
    ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="alert alert-danger">

            <?php
                			switch ($_GET['err']) {
								case 1:
									echo "Cntr error: Null code or not found.";
									break;

								case 2:
									echo "Can't update previous movement.";
									break;

								case 3:
									echo "Can't insert new movement.";
									break;

								case 4:
									echo "Invalid status.";
									break;

								case 8:
									echo "Data entry error: Invalid Bk/Bl-Order.";
									break;

								case 10:
									echo "Data entry error: Invalid Seal.";
									break;

								case 13:
									echo "Data entry error: Invalid date/time.";
									break;

								case 15:
									echo "Data entry error: Invalid Driver/Plate.";
									break;

								case 16:
			                        echo "Data entry error: Invalid date/time according to container's last movement.";
			                        break;

								default:
									echo "Something went wrong!";
                    		}
                ?>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <form action="gate_out_de.php" method="POST">
        <input type="hidden" name="line" value="<?php echo $line; ?>">
        <input type="hidden" name="cntr" value="<?php echo $cntr; ?>">
<!-- riga 1---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Line</label>
															<input type="text" class="form-control" value="<?php echo $row[0]; ?>" disabled>
					                                    </div>
					                                </div>
												<div class="col-lg-4">
													<div class="form-group">
				                                    	<label>Vessel-Voyage</label>
														<?php
														 if($fm=="F"){
														  echo '<select name="vesvoy" class="form-control" disabled>';
													      echo 'option value="NONE,NONE">NONE NONE </option>';

														  $query_vesvoy = "SELECT voyage.vessel,voyage.voyage
															                   FROM vessel,voyage
															                  WHERE voyage.vessel=vessel.vessel
																			    AND voyage.line='$line' AND vessel.line='$line'
																				AND vessel.vessel<>'NONE';";
														}
													     else {
														  echo '<select name="vesvoy" class="form-control">';
														  echo '<option value="NONE,NONE">NONE NONE </option>';
														  $query_vesvoy = "SELECT voyage.vessel,voyage.voyage
															                   FROM vessel,voyage
															                  WHERE voyage.vessel=vessel.vessel
																			    AND voyage.line='$line' AND vessel.line='$line'
																				AND voyage.close=0
																				AND voyage.cycle='E'
																				AND vessel.vessel<>'NONE';";
														 }
															//	Calcolo status adatti all'uscita

															$result_vesvoy = querySql($connection,$query_vesvoy);

															if($result_vesvoy!=NULL){
																while($row_vesvoy = $result_vesvoy->fetch_array()){
																	echo "<option value=\"$row_vesvoy[0],$row_vesvoy[1]\"";
																	if($vesvoy==($row_vesvoy[0].",".$row_vesvoy[1]))
																		echo " selected";
																	echo ">$row_vesvoy[0] $row_vesvoy[1]</option>";
																}
															}
														?>
														</select>
				                                    </div>
				                                </div>
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Partner</label>
															<input type="text" class="form-control" value="<?php echo $row[9]; ?>" disabled>
					                                    </div>
					                                </div>
					                            </div>
<!-- riga 2---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Container</label>
															<input type="text" class="form-control" value="<?php echo $row[1]; ?>" disabled>
					                                    </div>
					                                </div>
					                                <div class="col-lg-4">
														<div class="form-group">
					                                    	<label>Type</label>
															<input type="text" class="form-control" value="<?php
															//	Calcolo status adatti all'uscita
															$query_type = "SELECT size_term,description,tare FROM type WHERE size_term='$row[2]';";
															$result_type = querySql($connection,$query_type);
															if($result_type!=NULL){
															   $row_type = $result_type->fetch_array();
															   echo "$row_type[0] [$row_type[1],$row_type[2]]";}?>" disabled>
					                                    </div>
					                                </div>
					                                <div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Weight</label>
															<input type="text" class="form-control" value="<?php echo $row[14]; ?>" disabled>
					                                    </div>
					                                </div>
					                            </div>
<!-- riga 3---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">

													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>BK/BL</label>
															<?php
																if($fm=="F")
																	echo '<input type="text" class="form-control" value="'.$row[15].'" disabled>';
																else
																	echo '<input type="text" name="bk_bl" class="form-control incheck-alphanum incheck-uppercase" maxlength="12" value="'.$bk_bl.'" >';
															?>

					                                    </div>
													</div>
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Order</label>
															<?php
																if($fm=="F")
																	echo '<input type="text" class="form-control" value="'.$row[17].'" disabled>';
																else
																	echo '<input type="text" name="order" maxlength="12" class="form-control incheck-uppercase" value="'.$order.'" >';
															?>

					                                    </div>
					                                </div>
													<div class="col-lg-2">
													<div class="form-group">
				                                    	<label>POL</label>
														<select name="pol" class="form-control">
														<?php
														  if ($fm=='M')
															echo '<option value="" selected>NONE</option>';
														   else
															echo '<option value="">NONE</option>';
																// Elenco possibili porti
																$query_ports = "SELECT DISTINCT port FROM port WHERE line='$line'";//" AND fm='$row[3]';";
																$result_ports = querySql($connection,$query_ports);
																if($result_ports!=NULL){
																	while($row_ports = $result_ports->fetch_array()){
																		echo "<option value=\"$row_ports[0]\"";
																		if(trim($row_ports[0])==trim($pol))
																			echo " selected";
																		echo ">$row_ports[0]</option>";
																	}
																}
															?>
														</select>
				                                    </div>
				                                </div>
				                                <div class="col-lg-2">
													<div class="form-group">
				                                    	<label>POD</label>
														<select name="pod" class="form-control">
														<?php
														  if ($fm=='M')
															echo '<option value="" selected>NONE</option>';
														   else
															echo '<option value="">NONE</option>';

																// Elenco possibili porti dopo aver reimpostato all'inizio il result settings
																$result_ports->data_seek(0);
																if($result_ports!=NULL){
																	while($row_ports = $result_ports->fetch_array()){
																		echo "<option value=\"$row_ports[0]\"";
																		if(trim($row_ports[0])==trim($pod))
																			echo " selected";
																		echo ">$row_ports[0]</option>";
																	}
																}
															?>
														</select>
				                                    </div>
				                                </div>
												</div>
<!-- riga 4---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
													<div class="row">
														<div class="col-lg-2">
															<div class="form-group">
																<label>Terminal</label>
																<input type="text" class="form-control" value="<?php echo strtoupper($_SESSION['DB_lipu']); ?>" disabled>
															</div>
														</div>
														<div class="col-lg-2">
															<div class="form-group">
																<label>Yard</label>
																<input type="text" class="form-control" value="<?php echo $row[24]; ?>" disabled>
															</div>
														</div>
														<div class="col-lg-2">
															<div class="form-group">
																<label>Position (CCRRTT)</label>
																<input type="text" class="form-control" value="<?php echo $row[25]; ?>" disabled>
															</div>
														</div>
													</div>
<!-- riga 5---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
													<div class="row">
														<div class="col-lg-2">
															<div class="form-group">
																<label>Date (yyyy-mm-dd)</label>
																<input name="date" type="text" maxlength="10" class="form-control incheck-date" value="<?php echo $date; ?>">
															</div>
														</div>
														<div class="col-lg-2">
															<div class="form-group">
																<label>Time (hh:mm:ss)</label>
																<input name="time" type="text" maxlength="8" class="form-control incheck-time" value="<?php echo $time; ?>">
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
																<label>Status</label>
																<select name="status" class="form-control">
																<option value="">SELECT STATUS</option>
																<?php
																	//	Calcolo status adatti all'uscita
																	$query_status = "SELECT * FROM status WHERE gate_out='1' AND fm='$row[3]';";
																	$result_status = querySql($connection,$query_status);
																	if($result_status!=NULL){
																		while($row_status = $result_status->fetch_array()){
																			echo "<option value=\"$row_status[0]\"";
																			if($row_status[0]==$status)
																				echo " selected";
																			echo ">$row_status[0] [$row_status[1]]</option>";
																		}
																	}
																?>
																</select>
															</div>
														</div>
													</div>
<!-- riga 6---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Seal 1</label>
															<input name="seal1" type="text" class="form-control incheck-alphanum incheck-uppercase" maxlength="20" value="<?php echo $seal1; ?>">
					                                    </div>
					                                </div>
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Seal 2</label>
															<input name="seal2" type="text" class="form-control incheck-alphanum incheck-uppercase" maxlength="20" value="<?php echo $seal2; ?>">
					                                    </div>
					                                </div>
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Seal 3</label>
															<input name="seal3" type="text" class="form-control incheck-alphanum incheck-uppercase" maxlength="20" value="<?php echo $seal3; ?>">
					                                    </div>
					                                </div>
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Seal 4</label>
															<input name="seal4" type="text" class="form-control incheck-alphanum incheck-uppercase" maxlength="20" value="<?php echo $seal4; ?>">
					                                    </div>
					                                </div>
					                            </div>
<!-- riga 7---------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
												<div class="row">
													<div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Driver</label>
															<input name="driver" type="text" maxlength="20" class="form-control incheck-uppercase" value="<?php echo $driver; ?>">
					                                    </div>
					                                </div>
					                                <div class="col-lg-2">
														<div class="form-group">
					                                    	<label>Plate</label>
															<input name="plate" type="text" maxlength="7" class="form-control incheck-alphanum incheck-uppercase" value="<?php echo $plate; ?>">
					                                    </div>
					                                </div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Remarks</label>
															<input name="remarks" maxlength="60" class="form-control incheck-uppercase" value="<?php echo $remarks; ?>">
														</div>
													</div>
					                            </div>

												<div class="row">
													<div class="col-lg-2">
												        <div class="form-group">
												            <input type="submit" class="btn btn-default" value="Submit">
												        </div>
													</div>
												</div>
					                            </form>

</div>

<?php getFooterHTML(); ?>

<?php else : ?>

<?php

    $url = "gate_out_de.php?line=$line&cntr=$cntr&";

	 $query = "SELECT * FROM movement,voyage
		          WHERE history=0 AND cntr='$cntr' AND movement.line='$line'
				    AND movement.ves=voyage.vessel
				    AND movement.line=voyage.line
					AND movement.voy=voyage.voyage
				    AND ((interchange=1 AND status IN (SELECT status FROM status WHERE gate_in=1))
						  OR (status IN (SELECT status FROM status WHERE discharging=1)));";

		$result = querySql($connection,$query);
    	$row = $result->fetch_array();

	
    //	Recupero le informazioni da modificare
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $url .= "date=$date&";

    $time = mysqli_real_escape_string($connection, $_POST['time']);
    $url .= "time=$time&";


	$status = mysqli_real_escape_string($connection, $_POST['status']);
    $url .= "status=$status&";

   if ($fm=="M"){
		$bk_bl = mysqli_real_escape_string($connection, $_POST['bk_bl']);
		$url .= "bk_bl=$bk_bl&";


		$order = mysqli_real_escape_string($connection, $_POST['order']);
		$url .= "order=$order&";

		$vesvoy = mysqli_real_escape_string($connection, $_POST['vesvoy']);
		$url .= "vesvoy=$vesvoy&";

		if($vesvoy!=""){
			$vesvoy_array = explode(',', $vesvoy);
			$vessel = $vesvoy_array[0];
			$voyage = $vesvoy_array[1];
		}
		else{
			$vessel = "";
			$voyage = "";
		}
    }

    $pol = mysqli_real_escape_string($connection, $_POST['pol']);
    $url .= "pol=$pol&";

    $pod = mysqli_real_escape_string($connection, $_POST['pod']);
    $url .= "pod=$pod&";

    $cell = "";

    $seal1 = mysqli_real_escape_string($connection, $_POST['seal1']);
    $url .= "seal1=$seal1&";

    $seal2 = mysqli_real_escape_string($connection, $_POST['seal2']);
    $url .= "seal2=$seal2&";

    $seal3 = mysqli_real_escape_string($connection, $_POST['seal3']);
    $url .= "seal3=$seal3&";

    $seal4 = mysqli_real_escape_string($connection, $_POST['seal4']);
    $url .= "seal4=$seal4&";

	$driver = mysqli_real_escape_string($connection, $_POST['driver']);
    $url .= "driver=$driver&";

    $plate = mysqli_real_escape_string($connection, $_POST['plate']);
    $url .= "plate=$plate&";

	$remarks = mysqli_real_escape_string($connection, $_POST['remarks']);
    $url .= "remarks=$remarks&";

			//***********************************************************************************
			$errDE=0;
			if(trim($driver)==""||trim($plate)=="") $errDE=15; //........Invalid Driver/Plate

			if(trim($date)=="" || trim($time)=="" || !validateDate($date) || !validateTime($time)) $errDE=13; //..................Invalid Data/Time

			//Controllo che data e ora non siano precedenti all'attuale
			$date_time = DateTime::createFromFormat('Y-m-d/H:i:s', ($date . '/' . $time));
			if($date_time === false) $errDE=13; //..................Invalid Data/Time
			else {
				$date_time_now = new DateTime();
				if($date_time > $date_time_now) $errDE=13; //..................Invalid Data/Time
				else {
					//Controllo che data ora non siano precedenti a quanto segnato nella tabella container
					$query_time = "SELECT date, time FROM container WHERE cntr = '$_POST[cntr]'";
					$connectionc = new mysqli($db_path,$db_user,$db_pass,"container");
					$result_time = querySql($connectionc, $query_time);
					if($result_time != NULL) {
						//Container presente nella tabella, procedi al controllo
						$time_arr = $result_time->fetch_array();
						$date_time_lastmov = DateTime::createFromFormat('Y-m-d/H:i:s', ($time_arr[0] . '/' . $time_arr[1]));
						if($date_time < $date_time_lastmov) $errDE=16; //..................Invalid Data/Time according to container's last movement
					}
				}
			}

			if($fm=='M'){
				if ((trim($bk_bl)=="")&&(trim($order)=="")) $errDE=8; //...Invalid Bk/Bl-Order
			}
			if(trim($status)=="") $errDE=4;//............................Invalid status
			if (trim($cntr)=="") $errDE=1; //............................Null code cntr
			if($fm=='F' && trim($seal1) == "") $errDE=10;	//.............Invalid seal
			
			//	Container ancora nel terminal?
				$query = "SELECT * FROM movement,voyage
							WHERE cntr='$cntr' AND movement.line='$line' AND history=0
							AND movement.ves=voyage.vessel
							AND movement.line=voyage.line
							AND movement.voy=voyage.voyage
							AND ((interchange=1 AND status IN (SELECT status FROM status WHERE gate_in=1))
							  OR (close=1 AND status IN (SELECT status FROM status WHERE discharging=1))
							  OR (close=0 AND coarri=1 AND status IN (SELECT status FROM status WHERE discharging=1)));";
				$result = querySql($connection,$query);
				if($result==NULL) $errDe=21; //cntr discarted: no history=0(not in terminal)
		    //***********************************************************************************
		
			if($errDE==0){
				//	Uso una transazione
				$connection->autocommit(FALSE);
				//	Provo a mettere nello storico il vecchio movimento
				$datec = $date; 
				$timec = $time; 
				// A gate out effettuato, il dateC e il timeC del movimento precedente vengano aggiornati alla ora di sistema attuale (corretto?)

				$query = "UPDATE movement
				          SET history=1, datec = '$datec',timec='$timec',user='".$_SESSION['DB_username']."'
				          WHERE cntr = '$row[1]' AND date = '$row[7]' AND time='$row[8]';"; //Correzione 20180226

				if(insertSql($connection,$query)) {
					$row[5] = $status;
					$row[6] = 'I'; //$Cycle;
					$row[7] = $date;
					$row[8] = $time;
					$row[10] = $seal1;
					$row[11] = $seal2;
					$row[12] = $seal3;
					$row[13] = $seal4;
					$row[15] = $bk_bl;
					$row[16] = $row[15];
					$row[17] = $order;
					$row[18] = $vessel;
					$row[19] = $voyage;
					$row[20] = $pol;
					$row[21] = $pod;
					$row[23] = strtoupper($db);

					//	Elimino informazioni non necessarie
					$row[24] = "";
					$row[25] = "";

					$row[26] = $driver;
					$row[27] = $plate;
					$row[28] = $remarks;
					$row[29] = 0;
					$row[30] = 0;
					$row[31] = 0;
					$row[32] = 0;
					$row[33] = 0;
					$row[34] = 0; //	Un cntr uscito non è subito nello storico deve essere fatto l'interchange!!!!!!
					$row[35] = $datec;
					$row[36] = $timec;
					$row[38] = $_SESSION['DB_username'];


					if(addMov($row,$connection)){
						$url = "gate_out.php?succ=1&cntr=$cntr";
					}
	            	else{
						$url .= "err=3";
	            	}
				}
				else{
					$url .= "err=2";
				}
			}
			else $url .= "err=".$errDE;

    header("location: $url");

?>

<?php endif; ?>

<?php
	$connection->close();
?>
