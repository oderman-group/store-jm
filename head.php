<!DOCTYPE html>
<html lang="zxx">

<head>

    <!-- metas -->
    <meta charset="utf-8">
    <meta name="author" content="Jhon Oderman" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="JM EQUIPOS" />
    <meta name="description" content="JMEQUIPOS" />


    <!-- favicon -->
    <link rel="shortcut icon" href="https://jmequipos.com/imagenes/logo/2020/logoAzulJm.png">
    <link rel="apple-touch-icon" href="img/logos/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/logos/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/logos/apple-touch-icon-114x114.png">

	<!-- title  -->
    <title>EQUIPOS TOPOGRÁFICOS EN MEDELLIN - JMENDOZA S.A.S</title>

    <!-- bootstrap css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- font awesome css -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">

    <!-- et-line icon css -->
    <link href="css/et-line.css" rel="stylesheet">

    <!-- revolution slider css -->
    <link rel="stylesheet" href="css/rev_slider/settings.css">
    <link rel="stylesheet" href="css/rev_slider/layers.css">
    <link rel="stylesheet" href="css/rev_slider/navigation.css">

    <!-- magnific popup css -->
    <link href="css/magnific-popup.css" rel="stylesheet">

    <!-- owl carousel css -->
    <link href="css/owl.carousel.css" rel="stylesheet">

    <!-- template default css -->
    <link href="css/default.css" rel="stylesheet">

    <!-- navigation css -->
    <link href="css/nav-menu.css" rel="stylesheet">

    <!-- custom css -->
    <link href="css/styles-3.css" rel="stylesheet" id="colors">

	<style type="text/css">
		.imagenProducto{
			width: 300px !important;
			height: 300px !important;
		}
	</style>
	
	<!-- jQuery -->
    <script src="js/jquery.min.js"></script>
	
	
<script type="text/javascript">
  function carrito(id){
  var producto = id;
	  
	  if(producto>0){
			var opcion = 1;  
	  }
  	  
	  $('#respCarrito').empty().hide().html("...").show(1);
		datos = "producto="+(producto)+
				"&opcion="+(opcion);
			   $.ajax({
				   type: "POST",
				   url: "ajax-carrito.php",
				   data: datos,
				   success: function(data){
				   $('#respCarrito').empty().hide().html(data).show(1);
				   }
			   });

	}
	
	setInterval(carrito(0), 1000);
</script>