<?php
include('../../conexion.php');
session_start();
$usuario=$_SESSION['usuario']['USUARIO'];
//busca los permisos asignados a usuario
$b_permiso=mysqli_query($conexion,"SELECT id_permiso from permiso_usuario where usuario='$usuario'");
$rawdata =  array();
$i=0;
while ($row = mysqli_fetch_array($b_permiso)) {
	$rawdata[$i] = $row; 
	$i++;

}
//se almacena resultado a json
$json = json_encode($rawdata);
// almacena jscon en variable
$array=json_decode($json) ;
/////////////////////////////////////////////////////////////////
//menu comercialización*************////////////////////////////


  for ($i=0; $i < count($array); $i++){
  $id_permiso=$array[$i]->id_permiso;

  if ($id_permiso==4) {
    echo "
    <li id='tarea_m'><a href='#' onclick='tarea();'><i class='fa fa-table'></i><span>Tareas</span></a></li>
    ";
  }

  if ($id_permiso==5) {
    echo "
    <li id='equipo_m'><a href='#' onclick='equipo();' ><i class='fa fa-desktop'></i><span>Equipo</span></a></li>
    ";
  }
  if ($id_permiso==6) {
    echo "
    <li id='asignaciones_m'><a href='#' onclick='asignaciones();'><i class='fa fa-edit'></i><span>Asignaciones</span></a></li>
    ";
  }
  if ($id_permiso==7) {
    echo "
    <li id='mantenimientos_m'><a href='#' onclick='mantenimientos();'><i class='fa fa-wrench'></i><span>Mantenimientos</span></a></li>
    ";
  }
  if ($id_permiso==8) {
    echo "
    <li id='problemas_m'><a href='#' onclick='problemas();'><i class='fa  fa-file-text'></i><span>Documentar problemas</span></a></li>
    ";
  }
}

echo "
        <li id='configuracion' class='treeview'>
          <a href='#'>
            <i class='fa fa-gears'></i>
            <span>Configuración</span>
             <i class='fa fa-angle-left pull-right'></i>
            <span class='pull-right-container'>           
            </span>
          </a>
          <ul class='treeview-menu'>
";

  for ($i=0; $i < count($array); $i++){
  $id_permiso=$array[$i]->id_permiso;

  if ($id_permiso==9) {
    echo "
    <li id='usuarios_m'><a href='#' onclick='usuarios();' ><i class='fa  fa-user-plus'></i>Usuarios</a></li>
    ";
  }
  if ($id_permiso==10) {
    echo "
    <li id='usuariosP_m'><a href='#' onclick='usuarios_permisos();' ><i class='fa  fa-unlock-alt'></i>Usuarios Permisos</a></li>
    ";
  }
    if ($id_permiso==11) {
    echo "
    <li id='usuarios_pais'><a href='#' onclick='usuarios_paises();' ><i class='fa  fa-users'></i>Usuarios Paises</a></li>
    ";
  }

}

echo "
             
          </ul>
        </li>
";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


mysqli_close($conexion);
?>