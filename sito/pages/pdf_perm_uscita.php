<?php

require_once "../lib/fpdf/fpdf.php";
require "session.php";
require "settings.php";

if(isset($_SESSION['DB_lipu']))
	$dblipu = $_SESSION['DB_lipu'];
else
	header("location: login.php");


$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);
if($_GET){
	$c_not = 0;
	$matricola = mysqli_real_escape_string($connection, $_GET['matricola']);
	$data = mysqli_real_escape_string($connection, $_GET['data']);
	$ora = mysqli_real_escape_string($connection, $_GET['ora']);

	$void_it_path = "../img/permessi/permesso_uscita.jpg";
	

	$query = "SELECT * 
			    FROM alunni,permessi 
			   WHERE alunni.matricola=permessi.matricola 
				 AND alunni.matricola='$matricola' 
			     AND permessi.data='$data' 
				 AND permessi.ora='$ora';";
	
	$result = querySql($connection,$query);
    $up=0;
    $up=!$_GET['preview'];
	if($result!=NULL){
		$row = $result->fetch_array();

		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->Image($void_it_path,0,0,-100);
		
		//Numero permesso
		$pdf->SetFont('Arial','',16);
		$pdf -> SetY(45);
		$pdf->Cell(270,10,$row['numero'],0,0,'C');
		
		//Nominativo richiedente
		$pdf->SetFont('Arial','',11);
		$pdf -> SetY(70);
		$pdf->Cell(10);
		
		// ------------ Aggiunto da Pietro ...
		$qualificaRichiedente = $row['richiedente'];
		if ($row['richiedente'] == "Delegato/a")
			$qualificaRichiedente = $qualificaRichiedente . " al ritiro";
		$l=strlen($row['nominativo']."   ".$qualificaRichiedente);
		$pdf->Cell(100+$l,10,$row['nominativo']."   ".$qualificaRichiedente,0,0,'C');
		
		// ... al posto delle seguneit due righe
		
		// --- PF --- $l=strlen($row['nominativo']."   ".$row['richiedente']);
		// --- PF --- $pdf->Cell(100+$l,10,$row['nominativo']."   ".$row['richiedente'],0,0,'C');


		//Alunno
		$pdf->SetFont('Arial','',11);
		$pdf -> SetY(79);
		$l=strlen($row['cognome']."   ".$row['nome']);
		$pdf->Cell(110+$l,10,$row['cognome']." ".$row['nome'],0,0,'C');

		//Classe
		$pdf->SetFont('Arial','',12);
		$pdf -> SetY(87);
		$pdf->Cell(85,10,$row['classe'],0,0,'C');

		//Ora
		$pdf->SetFont('Arial','',12);
		$pdf -> SetY(113);
		$pdf->Cell(235,10,substr($row['ora'],0,5),0,0,'C');

		//Data
		$pdf->SetFont('Arial','',12);
		$pdf -> SetY(113);
		$pdf->Cell(325,10,$row['data'],0,0,'C');

		//Documento
		$pdf->SetFont('Arial','',11);
		$pdf -> SetY(172);
		$l=strlen($row['documento']);
		$pdf->Cell(230+$l,10,$row['documento'],0,0,'C');
		
		//Collaboratore
		$pdf->SetFont('Arial','',11);
		$pdf -> SetY(180);
		$pdf->Cell(85,10,$row['collaboratore'],0,0,'C');
		//Se non è stata richiesta una preview, aggiorna i campi nel database
		
		if($up)
		{
			$query = "UPDATE permessi 
					     SET stmp=1
					   WHERE matricola = '$matricola' 
					     AND data = '$data' 
					     AND ora='$ora';";
			insertSql($connection,$query);
			
		}
        $connection->autocommit(TRUE);
		$pdf->Output();


	}
}
//	Chiudo la connessione
$connection->close();
?>
