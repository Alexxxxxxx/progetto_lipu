<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";
	
	if(!$_SESSION['is_admin']) {
		die("Permesso negato!");
	}

	//	Se il terminal non è stato settato l'utente non ha effettuato il login
	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	//	Apertura della connessione
	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);

    //Inizializza i campi
    if(isset($_GET['id']))
    {
        $id = mysqli_real_escape_string($connection, $_GET['id']);
    }
    else
    {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
    }

    $nome_comune = "";         		//0
	$nome_scientifico = "";			//1
	$spec = "";						//2
    
	$query = "SELECT * 
	            FROM specie
				WHERE id='$id';";

				$result = querySql($connection,$query);
				if($result!=NULL){
					$row = $result->fetch_array();
						$nome_comune = $row[1];
						$nome_scientifico = $row[2];
						$spec = $row[3];
					
					/**$query = "SELECT * 
								FROM classi
								WHERE classe='$classe';";
					

							$result = querySql($connection,$query);
							if($result!=NULL){
								$row = $result->fetch_array();
								$coordinatore = $row[3];
								$aula = $row[2];								
							}*/
				}
				
				//*----- Deleghe ------------------------------------------------------
				/**
				$deleganti="";
				$delegati="";
				
				$query = "SELECT * 
	            FROM deleghe
				WHERE id='$id';";

				$result = querySql($connection,$query);
				if($result!=NULL){
					$row = $result->fetch_array();
						$deleganti = $row['deleganti'];
						$delegati = $row['delegati'];
				}*/
				
				//*----- Coordinatore e aula ------------------------------------------------------
				/**
				$coordinatore="";
				$aula="";
					$query = "SELECT * 
								FROM classi
								WHERE classe='$classe';";
					

							$result = querySql($connection,$query);
							if($result!=NULL){
								$row = $result->fetch_array();
								$coordinatore = $row[3];
								$aula = $row[2];								
							}
				
				$data = date("Y-m-d");
				$ora = date("H:i:s");
				$nome_rich="";
				$documento="";
				$richiedente="";
				$collaboratore=""*/

    //if(isset($_GET['cognome']))
    //   $cognome = $_GET['cognome'];

 
?>

<?php
	if(!$_POST) :
?>

<!-- Mostra la form -->

<?php getHeaderHTML("ITIS G.Galilei", "Permessi Uscita Studente",$dblipu); ?>

<div id="page-wrapper">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">PERMESSI USCITA STUDENTE</h1>
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
								case 10:
									echo "Data Non Valida.";
									break;

								case 20:
									echo "Orario Non Valido.";
									break;

								case 30:
									echo "Tipo Richiedente Mancante.";
									break;
									
								case 35:
									echo "Nome Richiedente Mancante.";
									break;

								case 40:
			                        echo "Documento Richiedente Mancante.";
			                        break;
									
								case 50:
			                        echo "Impossibile registrare uscita.";
			                        break;

								default:
									echo "Errore non identificato!";
                    		}
                ?>
            </div>
        </div>
    </div>

    <?php endif; ?>
												

</div>

<?php getFooterHTML(); ?>

<?php else : ?>

<?php

    $url = "scheda_stud.php?";

    //	Recupero le informazioni da modificare
	$id = mysqli_real_escape_string($connection, $_POST['id']);
    $url .= "id=$id&";

    $data = mysqli_real_escape_string($connection, $_POST['data']);
    $url .= "data=$data&";

    $ora = mysqli_real_escape_string($connection, $_POST['ora']);
    $url .= "ora=$ora&";

	$richiedente = mysqli_real_escape_string($connection, $_POST['richiedente']);
    $url .= "richiedente=$richiedente&";
	
	$nome_rich = mysqli_real_escape_string($connection, $_POST['nome_rich']);
    $url .= "nome_rich=$nome_rich&";

	$documento = mysqli_real_escape_string($connection, $_POST['documento']);
    $url .= "documento=$documento&";
	
	$collaboratore = mysqli_real_escape_string($connection, $_POST['collaboratore']);
    $url .= "collaboratore=$collaboratore&";

    
			//***********************************************************************************
			$errDE=0;
			
			if(trim($data)=="" ||  !validateDate($data) ) $errDE=10; //Data
			if(trim($ora)==""  || !validateTime($ora)) $errDE=20;    //Ora
			if(trim($documento)=="") $errDE=40;                      //Documento
			if(trim($nome_rich)=="") $errDE=35;                      //Nome richiedente
			if(trim($richiedente)=="") $errDE=30;                    //Tipo richiedente
			
			
		
			if($errDE==0){
				//	Uso una transazione
				$connection->autocommit(FALSE);
				$query="INSERT 
				          INTO permessi (id, richiedente, nominativo, documento, collaboratore, data, ora, stmp)
						  VALUES ('$id','$richiedente','$nome_rich','$documento','$collaboratore','$data','$ora',0);";

				if(!insertSql($connection,$query)) {
					$url .= "err=50";
	            }
				else
				 $connection->autocommit(TRUE);
				 $url="selstud.php";
			}
			else $url .= "err=".$errDE;
			

    header("location: $url");

?>

<?php endif; ?>

<?php
	$connection->close();
?>
