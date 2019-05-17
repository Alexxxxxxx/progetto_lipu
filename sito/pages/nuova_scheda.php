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
		getHeaderHTML("LIPU","Scheda Ammissione",$dblipu);
	
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
					$query = "SELECT id_ricovero FROM ricovero;";
					$result = querySql($connection,$query);
					$id_ricovero = 0;
					if($result!=NULL)
					{
						while($row = $result->fetch_array())
						{
							$id_ricovero = $row[0];
						}
					}
					$id_ricovero = $id_ricovero + 1;
					echo "<h1 class='page-header'>Scheda Ammissione #$id_ricovero</h1>";
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
					<?php if(!$_GET){ ?>
                        <div id="tab-section">
							<div id="tab-header">
								<button class="tab active" id="1_a" onclick="changeTab(1)">
									<h3>Ritrovamento</h3>
								</button>
								<button class="tab" id="2_a" onclick="changeTab(2)">
									<h3>Ricovero</h3>
								</button>
								<button class="tab" id="3_a" onclick="changeTab(3)">
									<h3>Esito</h3>
								</button>
								<button class="tab" id="4_a" onclick="changeTab(4)">
									<h3>Consegnante</h3>
								</button>
								<div align="right">
									<a title="Stampa" href="" class='btn btn-success stampa'><i class="fa fa-print fa-fw"></i></a>
									<?php
										if($_SESSION['is_admin'] != -1):
									?>
									<a title="Apri Cartella Clinica" <?php echo "href='cartella_clinica.php?id_ricovero=$id_ricovero'"; ?> class='btn btn-success cartella'>
										<i class="fa fa-heartbeat fa-fw"></i>
									</a>
									<?php
										endif;
									?>
									<a title="Esporta PDF" target="_blank" href="esporta_pdf.php" class='btn btn-success download'><i class="fa fa-file-pdf-o fa-fw"></i></a>
								</div>
							</div>
							<br>
							<div id="tab-body">
								<!-- INIZIO FORM RITROVAMENTO -->
								<form id="1" class="tab-form tab-form-active" action="scheda_ammissione.php" method="GET">
									<div class="form-group">
										<label>Compilatore</label>
										<input name="data_consegna" type="text" class="form-control">
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
										<label>Data ritrovamento</label>
										<input name="data_ritrovamento" type="date" class="form-control">
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
										<label>Regione</label>
										<select name="regione" type="text" class="form-control">
											<?php
												$query = "SELECT regione FROM regioni;";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Provincia</label>
										<select name="provincia" type="text" class="form-control">
											<?php
												$query = "SELECT provincia FROM provincie;";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Comune</label>
										<select name="comune" type="text" class="form-control">
											<?php
												$query = "SELECT comune FROM comuni;";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Località</label>
										<input name="localita" type="text" class="form-control">
										<label>Note ritrovamento</label>
										<input name="note" type="text" class="form-control">
									</div>
								</form>
								<!-- FINE FORM RITROVAMENTO -->
								<!-- INIZIO FORM RICOVERO -->
								<form id="2" class="tab-form" action="scheda_ammissione.php" method="GET">
									<div class="form-group">
										<label>Causa ricovero</label>
										<select name="causa" type="text" class="form-control">
											<?php
												$query = "SELECT causa FROM cause;";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Altra causa</label>
										<select name="altro" type="text" class="form-control">
											<?php
												$query = "SELECT causa FROM cause;";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Triage</label>
										<select name="triage" type="text" class="form-control">
											<?php
												$query = "SELECT triage FROM diagnosi;";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Marcaggio</label>
										<select name="marcaggio" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='marcaggio';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Note Marcaggio</label>
										<input name="note_marcaggio" type="text" class="form-control">
										<label>Note Cliniche</label>
										<input name="note_cliniche" type="text" class="form-control">
										<label>Anamnesi</label>
										<input name="anamnesi" type="text" class="form-control">
										<label>Note Posizione</label>
										<input name="note_posizione" type="text" class="form-control">
									</div>
								</form>
								<!-- FINE FORM RICOVERO -->
								<!-- INIZIO FORM ESITO -->
								<form id="3" class="tab-form" action="scheda_ammissione.php" method="GET">
									<div class="form-group">
										<label>Data esito</label>
										<input name="data_esito" type="date" class="form-control">
										<label>Esito</label>
										<select name="esito" type="text" class="form-control">
											<?php
												$query = "SELECT descrizione FROM descrizioni WHERE categoria='esito';";
												$result = querySql($connection,$query);
												echo "<option value=''>--Seleziona--</option>";
												if($result!=NULL){
													while($row = $result->fetch_array()){
														echo "<option value='$row[0]'>$row[0]</option>";
													}
												}
											?>
										</select>
										<label>Note</label>
										<input name="note1" type="text" class="form-control">
									</div>
								</form>
								<!-- FINE FORM ESITO -->
								<!-- INIZIO FORM CONSEGNANTE -->
								<form id="4" class="tab-form" action="scheda_ammissione.php" method="GET">
									<label>Nome</label>
									<input name="nome" type="text" class="form-control">
									<label>Cognome</label>
									<input name="cognome" type="text" class="form-control">
									<label>Provincia</label>
									<select name="provincia" type="text" class="form-control">
										<?php
											$query = "SELECT provincia FROM provincie;";
											$result = querySql($connection,$query);
											echo "<option value=''>--Seleziona--</option>";
											if($result!=NULL){
												while($row = $result->fetch_array()){
													echo "<option value='$row[0]'>$row[0]</option>";
												}
											}
										?>
									</select>
									<label>Città</label>
									<select name="citta" type="text" class="form-control">
										<?php
											$query = "SELECT comune FROM comuni;";
											$result = querySql($connection,$query);
											echo "<option value=''>--Seleziona--</option>";
											if($result!=NULL){
												while($row = $result->fetch_array()){
													echo "<option value='$row[0]'>$row[0]</option>";
												}
											}
										?>
									</select>
									<label>Indirizzo</label>
									<input name="indirizzo" type="text" class="form-control">
									<label>Telefono</label>
									<input name="telefono" type="text" class="form-control">
									<label>E-mail</label>
									<input name="email" type="email" class="form-control">
									<label>Note</label>
									<input name="note1" type="text" class="form-control">
								</form>
								<!-- FINE FORM CONSEGNANTE -->
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
							echo "<a href='nuova_scheda.php' class='btn btn-warning'>Cancel</a>";
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
