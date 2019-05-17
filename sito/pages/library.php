<?php

require_once "settings.php";
require_once "../lib/PHPMailer/PHPMailerAutoload.php";


function getHeaderHTML($title,$subtitle,$dblipu){ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title." - ".$subtitle;?></title>

    <!-- THICKBOX -->
    <!--
    <script type="text/javascript" src="jquery-3.1.0.js"></script>
    <link rel="stylesheet" href="thickbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="thickbox-compressed.js"></script>
    -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Date range picker -->
    <link href="../bower_components/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">

    <style>
    th, td {
        padding: 4px;
        text-align: center;
    }
    #yardlayout{
        overflow: scroll;
    }
    #errLay{
        background-color: #fc6363;
    }
    #okLay{
        background-color: #dff0a0;
    }

    .okLayEmpty {
        background-color: #f1ed42;
    }

    .okLay22 {
        background-color: #85fe87;
    }
    .okLay42 {
        background-color: #98fef3;
    }
    .okLay45GP {
        background-color: #febf98;
    }
    .okLay45RE {
        background-color: #f3aaf2;
    }
    #blankLay{
        background-color: #dffdee;
    }
	
	.sidebar .nav-third-level li a{
		padding-left 37px;
	}

    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
	

		
        function limitText(limitField, limitNum) {
            limitField.value = limitField.value.toUpperCase();
            if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
            }
        }

        function initRows(){
            checkboxes = document.getElementsByName('elem[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                row = checkboxes[i].parentNode.parentNode;
                row.style.display = "table-row";
            }
        }

        function toggle(check) {
        var row;
        checkboxes = document.getElementsByName('elem[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            row = checkboxes[i].parentNode.parentNode;
                if(row.style.display=="table-row")
                    checkboxes[i].checked = check;
            }
        }

	
        function t_rich(){
			var rc=document.getElementById('ric').value;
			var cp=document.getElementById('cg_pa').value;
			var np=document.getElementById('nm_pa').value;
			var cm=document.getElementById('cg_ma').value;
			var nm=document.getElementById('nm_ma').value;		
			var dlg=document.getElementById('dlgt').value;

			if (rc=='Padre'){document.getElementById('ricn').value=cp + " " + np;}
			if (rc=='Madre'){document.getElementById('ricn').value=cm + " " + nm;}
			if (rc=='Delegato/a'){document.getElementById('ricn').value=dlg;} 
			if (rc=='Tutore'){if(cp) document.getElementById('ricn').value=cp + " " + np;
			                  else 
								  if(cm) document.getElementById('ricn').value=cm + " " + nm;
							 }
		}
 </script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               
                <a class="navbar-brand" href="index.php">LIPU Provincia di Livorno</a>
  
            </div>
            <!-- /.navbar-header -->

 
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['DB_username']; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
         

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">

                    
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a>
                        </li>
						
						<li>
                            <a href="#"><i class="fa fa-id-card-o fa-flip-horizontal"></i> Scheda Ammissione<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
								<li>
									<a href="nuova_scheda.php"><i class="fa fa-plus fa-fw"></i> Nuova Scheda</a>
                                </li>
								<li>
                                    <a href="apri_scheda.php"><i class="fa fa-folder-open fa-fw"></i> Apri Scheda</a>
                                </li>
							</ul>
                            <!-- /.nav-second-level -->
                        </li>
					
						<?php
							if($_SESSION['is_admin'] != -1):
						?>
						<li>
                            <a href="cartella_clinica.php"><i class="fa fa-heartbeat fa-fw"></i> Cartella Clinica</a>
                        </li>
						<?php
							endif;
						?>
						
                        <li>
                            <a href="#"><i class="fa fa-database fa-flip-horizontal"></i> Database<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
								<li>
                                    <a href="specie.php">Specie</a>
                                </li>
								<li>
                                    <a href="consegnanti.php">Consegnanti</a>
                                </li>
								<li>
                                    <a href="collaboratori.php">Collaboratori</a>
                                </li>
								<li>
                                    <a href="deleghe.php">Deleghe</a>
                                </li>
                                <li>
                                    <a href="permessiuscita.php">PDF Permessi Uscita</a>
                                </li>
                                <li>
                                    <a href="permessiuscita_storico.php">PDF Permessi Uscita (Storico)</a>
                                </li>
								<?php
									if($_SESSION['is_admin'] == 1):
								?>
								<li>
                                    <a href="user.php">Operatori</a>
                                </li>
								<?php
									endif;
								?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
					<!-- 
                        <li>
                            <a href="#"><i class="fa fa-bar-chart fa-fw"></i> Statistiche <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="statistics.php?stat=fm_M">Stat1</a>
                                </li>
								<li>
                                    <a href="statistics.php?stat=fm_F">Stat2</a>
                                </li>
								<li>
                                    <a href="statistics.php?stat=vgm">Stat3</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
						<!-- 
                        </li>
						<li>
                            <a href="#"><i class="fa fa-search fa-fw"></i>Ricerche<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
								<li>
                                    <a href="statistics.php?stat=history">Studente</a>
                                </li>
								<li>
                                    <a href="statsearch.php?srch=cntr">Data</a>
                                </li>
								<li>
                                    <a href="statsearch.php?srch=bk">Altro</a>
                                </li>

                            </ul>
						</li>
                            <!-- /.nav-second-level -->
                        
						
                        
                        <!--<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i>Tabelle<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="specie.php">Specie</a>
                                </li>
								<li>
                                    <a href="classi.php">Classi</a>
                                </li>
								<li>
                                    <a href="docenti.php">Docenti</a>
                                </li>
								<li>
                                    <a href="collaboratori.php">Collaboratori</a>
                                </li>
								<li>
                                    <a href="deleghe.php">Deleghe</a>
                                </li>
								
							
                                <li>
                                    <a href="user.php">Operatori</a>
                                </li>
								
                            </ul>
                             /.nav-second-level
                        </li>-->
                    </ul>
                    

                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
            <?php
}

function getFooterHTML($additionalScript = NULL){
    ?>

        </div>
    <!-- /#wrapper -->
    <script>
    initRows();
    </script>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/daterangepicker/moment.min.js"></script>
    <script src="../bower_components/daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../bower_components/alasql/dist/alasql.min.js"></script>
    <script src="../bower_components/js-xlsx/dist/xlsx.core.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<!-- aLengthMenu inserito il 28/7/2016 Flow -->
	<!--"iDisplayLength":100,Flow -->
    <script>
    $(document).ready(function() {
        $('input[name=daterange]').daterangepicker({
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "alwaysShowCalendars": true,
            "startDate": "11/06/2016",
            "endDate": "11/12/2016",
            "buttonClasses": "btn"
        }, function(start, end, label) {
            $('input[name=date-start]').val(start.format('YYYY-MM-DD'));
            $('input[name=date-end]').val(end.format('YYYY-MM-DD'));
        });

        $('#dataTables-example').DataTable({

				"aLengthMenu":[[250, 100, 50, 25,-1], ["250", "100", "50", "25","All"]],

				responsive: true
        });

        //Assegna una funzione di controllo a tutti gli elementi con classe incheck-alphanum.
        //Controlla siano inseriti unicamente caratteri alfanumerici
        $('.incheck-alphanum').bind('keypress', function (event) {
            var regex = new RegExp("^[a-zA-Z0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });

        //Assegna una funzione di controllo a tutti gli elementi con classe incheck-num.
        //Controlla siano inseriti unicamente caratteri numerici
        $('.incheck-num').bind('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });

        //Assegna una funzione di controllo a tutti gli elementi con classe incheck-date.
        //Controlla siano inseriti unicamente caratteri elementi e il carattere '-'
        $('.incheck-date').bind('keypress', function (event) {
            var regex = new RegExp("^[0-9-]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });

        //Assegna una funzione di controllo a tutti gli elementi con classe incheck-time.
        //Controlla siano inseriti unicamente caratteri elementi e il carattere ':'
        $('.incheck-time').bind('keypress', function (event) {
            var regex = new RegExp("^[0-9:]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });

        //Assegna una funzione di controllo a tutti gli elementi con classe incheck-uppercase.
        //Converti tutto quel che viene scritto a maiuscolo
        $('.incheck-uppercase').on('input', function(){
            var start = this.selectionStart,
                end = this.selectionEnd;

            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });

    });

    function checkOnlyNumbers(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }

    function exportExcel(tableid, filename) {
       alasql('SELECT * INTO XLSX("' + filename + '.xlsx",{headers:true}) \
                 FROM HTML("#' + tableid + '",{headers:true})');
    }

	function del(){
		return checkChecked() && confirm("Confirm delete?");
	}

	function checkChecked(){
		checkboxes = document.getElementsByName('elem[]');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			if(checkboxes[i].checked == true){
				return true;
			}
		}

		return false;
	}

	var commands = {
		'delete': function(e){
			return checkChecked() && confirm("Confirm delete?");
		},
        'delete-cntr': function(e){
            return checkChecked() && confirm("Delete container?");
        },
		'lock': function(e){
			return checkChecked() && confirm("Confirm close?");
		},
		'unlock': function(e){
			return checkChecked() && confirm("Confirm open?");
		},
		'auth': function(e){
			return checkChecked() && confirm("Add authorization?");
		},
		'deauth': function(e){
			return checkChecked() && confirm("Remove authorization?");
		},
		'mcdr': function(e){
			return checkChecked() && confirm("Make codeco report?");
		},
		'mcdrs': function(e){
			return checkChecked() && confirm("Make codeco report and send by e-mail?");
		},
		'mcrr': function(e){
			return checkChecked() && confirm("Make coarri report?");
		},
		'mcrrs': function(e){
			return checkChecked() && confirm("Make coarri report and send by e-mail?");
		}
	};

	$('*[cmd]').off().click(
		function(e){
			e.preventDefault();
			var cmd = $(this).attr('cmd');
			if(commands[cmd].call(this, e)){
				var form = $(this).closest('form');
				form.find('*[name=cmd]').val(cmd);
				form.submit();
			}
		}
	);
	</script>

    <?php if($additionalScript !== null) { ?>
    <script><?php echo $additionalScript ?></script>
    <?php } ?>

</body>

</html>


<?php }


function getHeaderInfo($file){
    $header = NULL;
    while ( ($line = fgets($file)) !== false) {
            if (strpos($line, 'PARTNER: ') !== false) {
                $arr = explode(" ,", $line, 2);
                $first = $arr[0];
                $header[0] = substr($first, 9);
                $header[0] = trim(preg_replace('/\s+/', ' ', $header[0]));

            }
            else if (strpos($line, 'VESSEL CODE: ') !== false) {
                $arr = explode(" ,", $line, 3);
                $second = $arr[1];
                $header[1] = substr($second, 13);
                $header[1] = trim(preg_replace('/\s+/', ' ', $header[1]));
            }
            else if (strpos($line, 'VOYAGE: ') !== false) {
                $arr = explode(" ,", $line, 2);
                $first = $arr[0];
                $header[2] = substr($first, 8);
                $header[2] = trim(preg_replace('/\s+/', ' ', $header[2]));

            }
            else if (strpos($line, 'PORT: ') !== false) {
                $arr = explode(" ,", $line, 2);
                $first = $arr[0];
                $header[3] = substr($first, 6);
                $header[3] = trim(preg_replace('/\s+/', ' ', $header[3]));
            }
            else if (strpos($line, 'OPERATION TERMINAL: ') !== false) {
                $arr = explode(" ,", $line, 2);
                $first = $arr[0];
                $header[4] = substr($first, 20);
                $header[4] = trim(preg_replace('/\s+/', ' ', $header[4]));
            }
            else if (strpos($line, 'DATE(GMT): ') !== false) {
                $arr = explode(" ,", $line, 2);
                $first = $arr[0];
                $header[5] = substr($first, 11);
                $header[5] = trim(preg_replace('/\s+/', ' ', $header[5]));
                $header[5] = dateToDb($header[5]).":00";

            }
    }
    return $header;
}

function querySql($connection,$query){
    $result = $connection->query($query);
    if ($result->num_rows == 0) {
		$result->free();
		return NULL;
    }
    else{
        return $result;
    }
}

function insertSql($connection,$query){
    if($connection->query($query) === TRUE){
        return 1;
    }
    else{
        return 0;
    }
}

function updateSql($connection,$query){
    if($connection->query($query) === TRUE){
        return 1;
    }
    else{
        return 0;
    }
}

function lstFieldPoolVoy($status,$voyage,$vessel,$line,$IU,$connection){
	if($IU=='U')
		$listP='voym=NULL,vesm=NULL,linem=NULL';
	else
		$listP='NULL,NULL,NULL';
	$query = "SELECT *
				FROM status 
			   WHERE status = '$status';";
			   
	$ress = querySql($connection,$query);
	if($ress!=NULL){
		$recs = $ress->fetch_array();
		if (($recs[6]==1)||($recs[7]==1)){
			
			$query = "SELECT *
						FROM voyage 
					   WHERE voyage = '$voyage' 
						 AND vessel = '$vessel' 
						 AND   line = '$line';";
	
			$resv = querySql($connection,$query);
			if($resv!=NULL) {
				$recv = $resv->fetch_array();
				if ($recv[5]==1){
					if($IU=='U')
						$listP="voym='".$recv[6]."',vesm='".$recv[7]."',linem='".$recv[8]."'";
					else
						$listP="'".$recv[6]."','".$recv[7]."','".$recv[8]."'";
				}
				else{
					if($IU=='U')
						$listP="voym='".$voyage."',vesm='".$vessel."',linem='".$line."'";
					else
						$listP="'".$voyage."','".$vessel."','".$line."'";
				}
			}
		}
	}
	return $listP;
}

function upMov($cntr,$connection,$ld){
    $campi=explode(",","line,cntr,sz,fm,tare,status,ie,date,time,partner,seal1,seal2,seal3,seal4,wt,bk,bl,ord,ves,voy,pol,pod,cell,term,yard,pos,driver,plate,remarks,auth,pa,interchange,codeco,coarri,history,datec,timec,vgm,user,voym,vesm,linem");
	$tpv = explode(",","   0,   0, 0, 0,   1,     0, 0,   0,   0,      0,    0,    0,    0,    0, 1, 0, 0,  0,  0,  0,  0,  0,   0,   0,   0,  0,     0,    0,      0,   1, 1,          1,     1,     1,      1,    0,    0,  1,   0,   0,   0,    0");
	for ($i=0;$i<35;$i++)
		$tpv[$i]=trim($tpv[$i]);
    $list = "SET ";
    for($i=0;$i<39;$i++){
		if ((($i<>1) && ($i<>7) && ($i<>8) && ($ld<>"Y"))||(($i<>1) && ($ld=="Y"))){ //si escludono icampi in chiave a meno che non si tratti di un discharging YardPosition
				$list=$list.$campi[$i]."=";

         if(!isset($cntr[$i]))
		  $list = $list."NULL,";
		 else
			if($tpv[$i]=="0")
              $list = $list."'".trim($cntr[$i])."',";
            else
              $list = $list.$cntr[$i].",";
		}
    }
    
	$list.=lstFieldPoolVoy($cntr[5],$cntr[19],$cntr[18],$cntr[0],'U',$connection);  //$list = substr($list, 0, -1);
	
	//  Inizio la transazione
	    $connection->autocommit(FALSE);
		$query = "UPDATE movement ".$list." 
				   WHERE cntr='".$cntr[1]."' 
				     AND ves='".$cntr[18]."' 
				     AND voy='".$cntr[19]."' 
					 AND history=0";
		if (($ld=="Y") || ($ld=="R"))
			$query = $query." AND auth=1";
		else
			$query = $query." AND auth=0";
		
		if ($ld=="L")
			$query = $query." AND status IN (SELECT status FROM status WHERE loading=1)";
		$query=$query.";";

        if(insertSql($connection,$query)){
            $connection->commit();
            //  Chiudo la transazione
            $connection->autocommit(TRUE);
            return 1;
        }
		return 0;
    }

function addMov($cntr,$connection){
    //  Inizio la transazione
    $connection->autocommit(FALSE);
    $list = "";
    for($i=0;$i<39;$i++){
        if(isset($cntr[$i]))
            $list = $list."'".$cntr[$i]."',";
        else
            $list = $list."NULL,";
    }
    $list.=lstFieldPoolVoy($cntr[5],$cntr[19],$cntr[18],$cntr[0],'I',$connection);//$list = substr($list, 0, -1);
	
    $query = "DELETE 
	            FROM movement 
			   WHERE cntr = '$cntr[1]' 
				 AND date = '$cntr[7]' 
				 AND time='$cntr[8]';";
	
	if(insertSql($connection,$query)){
		
        $query = "INSERT 
		            INTO movement 
				  VALUES (".$list.");";
        if(insertSql($connection,$query)){
            $connection->commit();
            $connection->autocommit(TRUE);
            return 1;
		}
    }
	$connection->rollback();
    $connection->autocommit(TRUE);
    return 0;
}


function checkPartner($partner,$line,$connection){
    $query = "SELECT * 
	            FROM partner 
			   WHERE partner='$partner' 
			     AND line='$line';";
    $result = querySql($connection,$query);

    if($result!=NULL)
        return 1;
    else
        return 0;
}


function validateDate($date){
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function validateTime($time){
	$t=explode (":",$time);
    if (!isset($t[0])||!isset($t[1])||!isset($t[2])) return false;
	if (!is_numeric($t[0])||!is_numeric($t[1])||!is_numeric($t[2])) return false;
	if (intval($t[0])<0 || intval($t[0])>23) return false;
	if (intval($t[1])<0 || intval($t[1])>59||intval($t[2])<0 || intval($t[2])>59) return false;
    $d = DateTime::createFromFormat('H:i:s', $time);
    return $d && $d->format('H:i:s') === $time;
}

function getSettingsEmailRecipient($connection) {
    $query = "SELECT email_recipient 
	            FROM settings";
    $result = querySql($connection,$query);
    if($result != NULL) {
        $array = $result->fetch_array();
        return $array[0];
    }

    return "";
}
function getEDIMails($connection,$line){
    $query = "SELECT email 
	            FROM edimail 
			   WHERE line='".$line."'";
    $result = querySql($connection,$query);
	if($result){
		$to=array();
		while($res = $result->fetch_array())
			$to[] =$res[0];
		return $to;
	}
	return null;
}

function sendEmail($to, $subject, $body, $attachment, $attachment_filename){
    $mail             = new PHPMailer();

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "smtp.office365.com"; // SMTP server
    //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                               // 1 = errors and messages
                                               // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 587;
    $mail->Username   = "itis@sisam.it"; // SMTP account username
    $mail->Password   = "Nicola2016$$";        // SMTP account password

    $mail->SetFrom("itis@sisam.it", 'itis');

    $mail->Subject    = $subject;
	if($body=="")
		$body="Attached file: ".$attachment_filename; 
    $mail->MsgHTML($body);
	
	if (!isset($to))
		return false;
	if(is_array($to)){
		foreach($to as $address)
			$mail->AddAddress($address);
	}
	else{
		$mail->AddAddress($to);
	}
 
    if(isset($attachment)){
        if(isset($attachment_filename))
            $mail->AddAttachment($attachment, $attachment_filename);
        else
            $mail->AddAttachment($attachment);
    }
    if($mail->Send())
        return true;
    return false;
}

function dateToDb($date){
    $date = str_replace("/","-",$date);
    return $date;
}

function day_after($gg,$mm,$aaaa){
  return date('Y-m-d', mktime(0,0,0,$mm,$gg+1,$aaaa));
}

function day_before($gg,$mm,$aaaa){
  return date('Y-m-d', mktime(0,0,0,$mm,$gg-1,$aaaa));
}

function day_shift($gg,$mm,$aaaa,$shift){
  return date('Y-m-d', mktime(0,0,0,$mm,$gg+$shift,$aaaa));
}
?>
