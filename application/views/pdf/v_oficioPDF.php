<?
$fecha = $this->m_ticket->fecha_text_f($oficio->fecha_realizado);
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans" rel="stylesheet"> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans" rel="stylesheet"> 

<style type="text/css">
	body {
		font-family: sans-serif;
		
	}
	p {
		font-size: 16px;
	}
	
	h2 {
		color: #999;
	}
	.texto
	{
		font-size: 14px;
	}
	hr {
		page-break-after: always;
		border: 0;
		margin: 0;
		padding: 0;
}
	.portada {
		padding-top: 70px;
		padding-left: 40px;		
	}
	.page {
		padding-top: 20px;
		background: #eee;
	}


#footer {
  position: fixed;
  	font-size: 10px;
  	left: 0;
	right: 0;
	bottom: 10px;
	color: #525252;
	
}

#header {
  position: absolute;
  top: 20px;
  left: 10px;
}

#logoFisca {
	top: 43px;
  	left: -45px;
}

/*#footer {
  padding-bottom: :105px; 
  font-size: 12px;
  color: #000; 
}*/


#oficioAsunto {
  top: 110px;
  position: absolute;
  padding-left: 450px;
  padding-right: 20px;
 
}

 #cuerpo {
 	padding-top: 150px;
 	padding-left: 70;
 	padding-right: 20px;
 }
 #fecha {
 	padding-top: 20px;
 	text-align: right;
 }

 #mensaje {
 	text-align: justify !important;

 }

 #despedida {
 	padding-top: -20px;

 }

 table {
 	border-collapse: collapse;
 	text-align: center !important;
 	font-size: 11px;
 	width: 100%;
 	border: black 1px solid;
 }
 th {
 	
 	background-color: #b7b7b7;
 	border: black 1px solid;
 }
 td{
 	border: black 1px solid;
 	width: 100% !important;
 	font-size: 11px !important;
 }


.page-number {
  text-align: right;
  font-size: 12px;
  color: #000;
  position: fixed;
  bottom: 10;

}

.page-number:after {
	
  content:  counter(page) ;
}
</style>
</head>
<body>
	<div id="header">
		<img src="src/img/logooficio.png" width="400px">
	</div>
	<div id="oficioAsunto">
		<p align="right">
			<b><?=$oficio->oficio?></b><br>
		</p>		
	</div>

	<div id="cuerpo">
		<p><b><?=$oficio->destinatario?></b><br>	
		<?=$oficio->cargo?> <br>
		<?=$oficio->dependencia?> <br>
		Presente

		<div id="fecha">
		</div>
		<div id="mensaje">
			<?=$oficio->redaccion?>
		</div>
		<div id="despedida">
			<p align="center">Atentamente<br>
				<b>"Piensa y Trabaja"</b><br>
				Guadalajara, Jalisco, <?=$fecha?>
				<br>
				<br>
				<br>
				<br>
				<b>Lic. Juan Carlos Guerrero Fausto</b><br>
				<span>Abogado General</span> </p>
		</div>		
	</div>


	
	

	<div id="footer" align="center">
  		Av. Juárez 976, Edificio de la Rectoría General, Piso 3, Colonia Centro C.P. 44100.<br>
  			Guadalajara, Jalisco. México. Tels. [52] (33) 3134 4661 al 4663 <br>
  			<b>www.abogadogeneral.udg.mx</b>
	</div>
	
</body>
</html>