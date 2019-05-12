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
		getHeaderHTML("ITIS G.Galilei","Cartella Clinica",$dblipu);
	?>
	
	<script>
		function changeTab(tab_index) {
			$('#tab-header button').removeClass("active");
			$("#" + tab_index + "_a").addClass("active");
			
			$('.tab-form').removeClass("tab-form-active");
			$("#" + tab_index + "").addClass("tab-form-active");
		}
	</script>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cartella Clinica</h1>
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
                        <div id="tab-section">
							<div id="tab-header">
								<button class="tab active" id="1_a" onclick="changeTab(1)">
									<h3>Riepilogo</h3>
								</button>
								<button class="tab" id="2_a" onclick="changeTab(2)">
									<h3>Diagnosi</h3>
								</button>
								<button class="tab" id="3_a" onclick="changeTab(3)">
									<h3>Esami</h3>
								</button>
								<button class="tab" id="4_a" onclick="changeTab(4)">
									<h3>Terapie</h3>
								</button>
								<button class="tab" id="5_a" onclick="changeTab(5)">
									<h3>Varie</h3>
								</button>
							</div>
							<br><br><br>
							<div id="tab-body">
								<!-- INIZIO FORM RIEPILOGO -->
								<form id="1" class="tab-form tab-form-active" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Specie</label>
										<select name="nome_comune" type="text" class="form-control">
											<?php
												$query = "SELECT nome_comune FROM specie;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Data consegna</label>
										<input name="data_consegna" type="date" class="form-control">
										<label>Data rinvenimento</label>
										<input name="data_rinvenimento" type="date" class="form-control">
										<label>Età</label>
										<input name="eta" type="text" class="form-control" maxLength="3">
										<label>Causa ricovero</label>
										<input name="causa" type="text" class="form-control" maxLength="50">
										<label>Altra causa</label>
										<input name="altro" type="text" class="form-control" maxLength="50">
										<label>Triage</label>
										<input name="triage" type="text" class="form-control" maxLength="50">
									</div>
								</form>
								<!-- FINE FORM RIEPILOGO -->
								<!-- INIZIO FORM DIAGNOSI -->
								<form id="2" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Diagnosi</label>
										<input name="diagnosi" type="text" class="form-control">
										<label>Veterinario</label>
										<select name="veterinario" type="text" class="form-control">
											<?php
												$query = "SELECT veterinario FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Triage</label>
										<select name="triage" type="text" class="form-control">
											<?php
												$query = "SELECT triage FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Lesione 1</label>
										<select name="lesione1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='lesione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Lesione 2</label>
										<select name="lesione2" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='lesione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Lesione 3</label>
										<select name="lesione3" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='lesione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Lesione 4</label>
										<select name="lesione4" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='lesione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Distretto 1</label>
										<select name="distretto1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='distretto';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Distretto 2</label>
										<select name="distretto2" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='distretto';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Distretto 3</label>
										<select name="distretto3" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='distretto';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Distretto 4</label>
										<select name="distretto4" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='distretto';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Tipo Frattura 1</label>
										<select name="frattura1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='frattura';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Tipo Frattura 2</label>
										<select name="frattura2" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='frattura';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Tipo Frattura 3</label>
										<select name="frattura3" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='frattura';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Tipo Frattura 4</label>
										<select name="frattura4" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='frattura';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Locazione 1</label>
										<select name="localizzazione1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='locazione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Locazione 2</label>
										<select name="localizzazione2" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='locazione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Locazione 3</label>
										<select name="localizzazione3" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='locazione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Locazione 4</label>
										<select name="localizzazione4" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='locazione';";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
									</div>
								</form>
								<!-- FINE FORM DIAGNOSI -->
								<!-- INIZIO FORM ESAMI -->
								<form id="3" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Esami</label>
										<select name="nome_comune" type="text" class="form-control">
											<?php
												$query = "SELECT nome_scientifico FROM specie;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
									</div>
								</form>
								<!-- FINE FORM ESAMI -->
								<!-- INIZIO FORM TERAPIE -->
								<form id="4" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Terapie</label>
										<select name="nome_comune" type="text" class="form-control">
											<?php
												$query = "SELECT nome_scientifico FROM specie;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
									</div>
								</form>
								<!-- FINE FORM TERAPIE -->
								<!-- INIZIO FORM VARIE -->
								<form id="5" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Data prima visita</label>
										<input name="data_prima_visita" type="date" class="form-control">
										<label>Sensorio</label>
										<select name="sensorio" type="text" class="form-control">
											<?php
												$query = "SELECT sensorio_centrale FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Grasso</label>
										<select name="grasso" type="text" class="form-control">
											<?php
												$query = "SELECT grasso FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Muscolatura</label>
										<select name="muscolatura" type="text" class="form-control">
											<?php
												$query = "SELECT muscolatura FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Piumaggio/Pelliccia</label>
										<select name="piumaggio" type="text" class="form-control">
											<?php
												$query = "SELECT piumaggio FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Peso</label>
										<input name="peso" type="number" class="form-control">
										<label>Temperatura</label>
										<input name="temperatura" type="number" class="form-control">
										<label>Disidratazione</label>
										<select name="disidratazione" type="text" class="form-control">
											<?php
												$query = "SELECT disidratazione FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Mucose</label>
										<select name="mucose" type="text" class="form-control">
											<?php
												$query = "SELECT mucose FROM diagnosi;";
												$result = querySql($connection,$query);
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value=''>$row[0]</option>";
													}
												}
											?>
										</select>
									</div>
								</form>
								<!-- FINE FORM VARIE -->
							</div>
						</div>
						<?php
							}  
						?>
						
					</div>
				</div>
				<center>
					<div class="form-group">
						<?php 
							echo "<a href='cartella_clinica.php' class='btn btn-warning'>Cancel</a>";
						?>
						<input name='btn' value="Save" type='submit' class='btn btn-success'>
					</div>
				</center>
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
					$coordinatori = mysqli_real_escape_string($connection, $_POST['elem'][$i]);
					$query = "DELETE 
					            FROM coordinatori 
								WHERE classe = '$classe'";
					if($coordinatori!=$_SESSION['DB_lipu'])
						insertSql($connection,$query);
					$i++;
				}
			}
			else if($_POST['cmd']=="add"){
				if($_POST['coordinatore']!=NULL){
					$coordinatore = mysqli_real_escape_string($connection, $_POST['coordinatore']);
					if($coordinatore!=""){
						$classe = mysqli_real_escape_string($connection, $_POST['classe']);
						$query = "INSERT INTO coordinatori (coordinatore,classe) VALUES ('$coordinatore','$classe');";
						insertSql($connection,$query);
				}
			}
		}
		header("location: coordinatori.php");
	}

?>
