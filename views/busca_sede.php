 <?php
 include ("../conexion.php");
session_start();
  if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "../../"
</script>';
}
$pais_d1=$_SESSION['usuario']['codigo_pais'];
$depto=mysqli_query($conexion, "SELECT * FROM depto WHERE Tipo='SEDE' and codigo_pais='$pais_d1'" );
 ?>