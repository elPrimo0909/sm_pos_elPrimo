<?php
/*-----------------------
elPrimo
---------------------*/
# conectare la base de datos
ob_start();
session_start();
error_reporting(E_ERROR | E_PARSE); ////no listar Warnings
///print_r($_SESSION);

/*
$rtt = $_SESSION['username'];
//echo $rtt;
$regimen = $_SESSION['regimen'];
$creando = $_SESSION['crea_empresa'];
////echo $regimen;


$xx = $_SESSION['username'];

*/
//$nom= "facturoe_"; 

///echo $xx;
//$raiz = /*"facturoe_admin";*/$nom . $xx;

//$array = array("$nom","$xx");       /* Coloca en un arreglo las 3 cadenas //////*/ 


/////$raiz="facturoe_admin";

//$tyu = implode($array); 
define("DB_HOST", "localhost");//DB_HOST:  generalmente suele ser "127.0.0.1"
define("DB_NAME","datos_pos");//Nombre de la base de datos
define("DB_USER", "root");//Usuario de tu base de datos
define("DB_PASS", "");//
	# conectare la base de datos
  $con = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
	die("imposibsssle conectarse: ".mysqli_error($con));
}
if (@mysqli_connect_errno()) {
	die("Connect failed: ".mysqli_connect_errno()." : ".mysqli_connect_error());
}
/*Inicia validacion del lado del servidor*/
if (empty($_POST['codigo'])) {
	$errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
	$errors[] = "Nombre vacío";
} else if (empty($_POST['moneda'])) {
	$errors[] = "Moneda vacío";
} else if (empty($_POST['capital'])) {
	$errors[] = "Capital vacío";
} else if (empty($_POST['continente'])) {
	$errors[] = "Continente vacío";
} else if (
	!empty($_POST['codigo']) &&
	!empty($_POST['nombre']) &&
	!empty($_POST['moneda']) &&
	!empty($_POST['capital']) &&
	!empty($_POST['continente'])

) {

	// escaping, additionally removing everything that could be (html/javascript-) code
	$codigo     = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
	$nombre     = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
	$moneda     = mysqli_real_escape_string($con, (strip_tags($_POST["moneda"], ENT_QUOTES)));
	$capital    = mysqli_real_escape_string($con, (strip_tags($_POST["capital"], ENT_QUOTES)));
	$continente = mysqli_real_escape_string($con, (strip_tags($_POST["continente"], ENT_QUOTES)));
	$impuesto = mysqli_real_escape_string($con, (strip_tags($_POST["impuesto"], ENT_QUOTES)));


/*
$insert = mysqli_query($con, "INSERT INTO facturas (id,numero,retension,tipo_retension,descuento,forma_pago,vencimiento,iva) VALUES ('$id','$numero_factura','$retension','$tipo_retension','$descuento','$forma_pago','$fecha','$iva')");
*/



	$sql          = "INSERT INTO lista7 (id, descripcion, codigo, precio_compra, precio_venta, cantidad, impuesto) VALUES ('$id','".$nombre."','".$moneda."','".$continente."','".$codigo."','".$capital."','".$impuesto."')";
	$query_update = mysqli_query($con, $sql);



	
	if ($query_update) {
		$messages[] = "El ítem se ingreso satisfactoriamente.";
	} else {
		$errors[] = "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
	}
} else {
	$errors[] = "Error desconocido.";
}

if (isset($errors)) {

	?>
	<div class="alert alert-danger" role="alert">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>Error!</strong>
	<?php
	foreach ($errors as $error) {
		echo $error;
	}
	?>
	</div>
	<?php
}
if (isset($messages)) {

	?>
	<div class="alert alert-success" role="alert">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>¡Bien hecho!</strong>
	<?php
	foreach ($messages as $message) {
		echo $message;
	}
	?>
	</div>
	<?php
}

?>