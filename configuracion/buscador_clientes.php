
<script type="text/javascript">
$(document).ready(function(){
    $("#myModal").on('shown.bs.modal', function(){
        $(this).find('#q').focus();
    });
});
</script>



<?php

error_reporting(E_ERROR | E_PARSE); ////no listar Warnings


//SE LISTA PRODUCTOS PARA AGREGAR A LA FACTURA
/* Connect To Database*/
require_once ("../clientes/config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../clientes/config/conexion.php");//Contiene funcion que conecta a la base de datos


$perfil2    = mysqli_query($con, "select * from perfil limit 0,1");
$rw_perfil2 = mysqli_fetch_array($perfil2);



$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL)?$_REQUEST['action']:'';
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	$q        = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('id', 'username');//Columnas de busqueda
	$sTable   = "tbl_user";
	$sWhere   = "";
	if ($_GET['q'] != "") {
		$sWhere = "WHERE (";
		for ($i = 0; $i < count($aColumns); $i++) {
			$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}
	include 'pagination.php';//include pagination file
	//pagination variables
	$page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page  = 5;//how much records you want to show
	$adjacents = 4;//gap between pages after number of adjacents
	$offset    = ($page-1)*$per_page;
	//Count the total number of row in your table*/
	$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere ");
	$row         = mysqli_fetch_array($count_query);
	$numrows     = $row['numrows'];
	$total_pages = ceil($numrows/$per_page);
	$reload      = './index.php';
	//main query to fetch the data
	$sql   = "SELECT * FROM  $sTable $sWhere ORDER by id ASC LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql);
	//loop through fetched data
	if ($numrows > 0) {

		?>
		<div >
<table class="table">

<th>Usuario</th>
<th>Nivel de acceso</th>





<?
}

?>


</tr>
		<?php while ($row = mysqli_fetch_array($query)) {
			$id_producto       = $row['tbl_user_id'];
			$usuario            = $row['username'];
			$nivel            = $row['first_name'];
			$nombre          = $row['nombre'];

			$nitusuario          = $row['cc'];
            $passusuario          = $row['password'];

			?>
			
                
			<td><?php echo $usuario;?></td>
			<td><?php echo $nivel?></td>
  

           


			<td >
			
            <button type="button" class="btn btn-sample" class="btn pull-right" data-toggle="modal" data-target="#dataUpdateUsuario"  data-id="<?php echo $row['id']?>" data-usuario="<?php echo $usuario?>" data-nitusuario="<?php echo $nitusuario ?>" data-passusuario="<?php echo $passusuario?>" data-capital="<?php echo $row['telefono']?>" data-continente="<?php echo $row['email']?>" ><i class=''></i>Modificar</button>
       
           
			
			</tr>
			<?php
		}
		?>
		<tr>
			</tr>
		</table>
		</div>
		<?php
	}
}
?>