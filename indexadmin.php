<?php
  include('core/award.class.php');
  include ('headeradmin.php');
  $instancia->validarRol(array("Administrador"));
?>
<h1>Bienvenido al sistema</h1>
<p>Un gran poder conlleva una gran responsabilidad.</p>
<?php include('footer.php');?>