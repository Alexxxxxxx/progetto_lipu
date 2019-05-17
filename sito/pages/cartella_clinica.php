<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	if(isset($_SESSION['DB_lipu']))
	{
		if($_SESSION['is_admin'] == -1)
		{
			header("location: login.php");
		}
		$dblipu = $_SESSION['DB_lipu'];
	}
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
	
	if(isset($_GET['id_ricovero']))
	{
		$id_ricovero = mysqli_real_escape_string($connection, $_GET['id_ricovero']);
	}
	
	if(!$_POST){
		getHeaderHTML("LIPU","Cartella Clinica",$dblipu);
	?>
	
	<script>
		function changeTab(tab_index) {
			<?php
				//INSERIRE SALVATAGGIO FORM CORRENTE
			?>
			
			$('#tab-header button').removeClass("active");
			$("#" + tab_index + "_a").addClass("active");
			
			$('.tab-form').removeClass("tab-form-active");
			$("#" + tab_index).addClass("tab-form-active");
		}
	</script>

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
				<?php
					if(isset($_GET['id_ricovero']))
					{
						echo "<h1 class='page-header'>Cartella Clinica #$id_ricovero</h1>";
					}
					else
					{
						echo "<h1 class='page-header'>Ricerca Cartella</h1>";
					}
				?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
						<?php
							if(!isset($_GET['id_ricovero']))
							{
								echo "<form action='cartella_clinica.php' method='GET'>";
								echo "<div class='form-group'>";
								echo "<label>Inserisci ID ricovero</label>";
								echo "<input name='id_ricovero' type='text' class='form-control'>";
								echo "</div>";
								echo "<div class='form-group'>";
								echo "<a href='cartella_clinica.php' class='btn btn-warning'>Cancel</a>		";
								echo "<input name='btn' value='Ok' type='submit' class='btn btn-success'>";
								echo "</div>";
								echo "</form>";
							}
							else{ 
						?>
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
								<div align="right">
									<a title="Stampa" href="" class='btn btn-success stampa'><i class="fa fa-print fa-fw"></i></a>
									<a title="Esporta PDF" target="_blank" href="esporta_pdf.php" class='btn btn-success download'><i class="fa fa-file-pdf-o fa-fw"></i></a>
								</div>
							</div>
							<br>
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
													echo "<option value=''>--Seleziona--</option>";
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Data consegna</label>
										<input name="data_consegna" type="date" class="form-control">
										<label>Data rinvenimento</label>
										<input name="data_rinvenimento" type="date" class="form-control">
										<label>Età</label>
										<select name="eta" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='eta';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Causa ricovero</label>
										<input name="causa" type="text" class="form-control" maxLength="50">
										<label>Altra causa</label>
										<input name="altro" type="text" class="form-control" maxLength="50">
										<label>Triage</label>
										<select name="triage" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='triage';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
									</div>
								</form>
								<!-- FINE FORM RIEPILOGO -->
								<!-- INIZIO FORM DIAGNOSI -->
								<form id="2" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Diagnosi</label>
										<input name="diagnosi" type="text" class="form-control">
										<label>Veterinario</label>
										<input name="veterinario" type="text" class="form-control">
										<label>Lesione</label>
										<select name="lesione1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='lesione';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Distretto</label>
										<select name="distretto1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='distretto';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Tipo Frattura</label>
										<select name="frattura1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='frattura';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Localizzazione</label>
										<select name="localizzazione1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='localizz';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
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
										<label>Data esame</label>
										<input name="data_esame1" type="date" class="form-control">
										<label>Esame</label>
										<select name="esame1" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='esame';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Veterinario</label>
										<input name="veterinario" type="text" class="form-control">
										<label>Note</label>
										<input name="note1" type="text" class="form-control">
									</div>
								</form>
								<!-- FINE FORM ESAMI -->
								<!-- INIZIO FORM TERAPIE -->
								<form id="4" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Data terapia</label>
										<input name="data_terapia1" type="date" class="form-control">
										<label>Veterinario</label>
										<input name="veterinario" type="text" class="form-control">
										<label>Farmaci</label>
										<input name="farmaci1" type="text" class="form-control">
										<label>Altra terapia</label>
										<select name="altra_terapia1" type="text" class="form-control">
											<option value="">--Seleziona--</option>
											<option value="">Chirurgica</option>
											<option value="">Non cruenta</option>
										</select>
										<label>Note</label>
										<input name="note1" type="text" class="form-control">
									</div>
								</form>
								<!-- FINE FORM TERAPIE -->
								<!-- INIZIO FORM VARIE -->
								<form id="5" class="tab-form" action="cartella_clinica.php" method="GET">
									<div class="form-group">
										<label>Data prima visita</label>
										<input name="data_prima_visita" type="date" class="form-control">
										<label>Sensorio centrale</label>
										<select name="sensorio_centrale" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='sensorio_c';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Sensorio periferico</label>
										<select name="sensorio_periferico" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='sensorio_p';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Grasso</label>
										<select name="grasso" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='grasso';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Muscolatura</label>
										<select name="muscolatura" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='muscolatura';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Piumaggio/Pelliccia</label>
										<select name="piumaggio_pelliccia" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='pium_pelliccia';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
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
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='disidratazione';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Mucose</label>
										<select name="mucose" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='mucose';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
									</div>
								</form>
								<!-- FINE FORM VARIE -->
							</div>
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
					
					<?php
						}  
					?>
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
