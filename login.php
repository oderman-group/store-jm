<?php
include("no-sesion.php");
?>
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
    <link rel="shortcut icon" href="img/logos/favicon.png">
    <link rel="apple-touch-icon" href="img/logos/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/logos/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/logos/apple-touch-icon-114x114.png">

	<!-- title  -->
    <title>Login</title>

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

</head>

<body>

    <?php include("loading.php");?>

    <!-- start main-wrapper section -->
    <div class="main-wrapper">

        <?php include("menu.php");?>

       <p>&nbsp;</p>

        <!-- start contact section -->
        <section id="contacto">
            <div class="container">
                <div class="row">
                    <!-- start contact form -->
                    <div class="col-lg-6">
                        <div class="section-heading left">
                            <h4>Login</h4>
                        </div>
						
						<?php if(!empty($_GET["error"]) && $_GET["error"]==1){?>
							<p style="color: tomato;">El usuario no existe. Debes registrarte primero.</p>
						<?php }?>
						
						<?php if(!empty($_GET["error"]) && $_GET["error"]==2){?>
							<p style="color: tomato;">La contraseña NO es correcta.</p>
						<?php }?>
						
						<div class="contact-form-box margin-30px-top">
                            <div class="no-margin-lr" id="success-contact-form" style="display: none;"></div>
                            
							<form method="post" action="sql.php">
								<input type="hidden" name="idSQL" value="2">
								
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="email" class="medium-input" maxlength="50" placeholder="Email *" required="required" name="email" />
                                    </div>
									<div class="col-md-12">
                                        <input type="password" class="medium-input" maxlength="50" placeholder="Contraseña *" required name="clave" />
                                    </div>
                                    <div class="col-md-12 sm-margin-30px-bottom">
                                        <button type="submit" class="butn"><span>Ingresar</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
						
                    </div>
                    <!-- end contact form  -->

                    <!-- start contact detail -->
                    <div class="col-lg-6">	
						
                        <div class="section-heading left">
                            <h5>Registro</h5>
                        </div>
						
                        <div class="contact-form-box margin-30px-top">
                            <div class="no-margin-lr" id="success-contact-form" style="display: none;"></div>
                            
							<form method="post" action="sql.php">
								<input type="hidden" name="idSQL" value="3">
								
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="medium-input" maxlength="50" placeholder="Nombre *" required="required" name="nombre" />
                                    </div>
                                    <div class="col-md-12">
                                        <input type="email" class="medium-input" maxlength="70" placeholder="E-mail *" required="required" name="email" />
                                    </div>
									<div class="col-md-12">
                                        <input type="password" class="medium-input" maxlength="70" placeholder="Contraseña *" required="required" name="clave" />
                                    </div>
                                    <div class="col-md-12 sm-margin-30px-bottom">
                                        <button type="submit" class="butn"><span>Registrarme</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end contact detail -->
                </div>
            </div>
        </section>
        <!-- end contact section -->
 
        <?php include("footer.php");?>

    </div>
    <!-- end main-wrapper section -->

    <!-- start scroll to top -->
    <a href="javascript:void(0)" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
    <!-- end scroll to top -->

    <!-- all js include start -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- modernizr js -->
    <script src="js/modernizr.js"></script>

    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>

    <!-- navigation -->
    <script src="js/nav-menu.js"></script>

    <!-- tab -->
    <script src="js/easy.responsive.tabs.js"></script>

    <!-- owl carousel -->
    <script src="js/owl.carousel.js"></script>

    <!-- jquery.counterup.min -->
    <script src="js/jquery.counterup.min.js"></script>

    <!-- stellar js -->
    <script src="js/jquery.stellar.min.js"></script>

    <!-- waypoints js -->
    <script src="js/waypoints.min.js"></script>

    <!-- tab js -->
    <script src="js/tabs.min.js"></script>

    <!-- countdown js -->
    <script src="js/countdown.js"></script>

    <!-- jquery.magnific-popup js -->
    <script src="js/jquery.magnific-popup.min.js"></script>

    <!-- isotope.pkgd.min js -->
    <script src="js/isotope.pkgd.min.js"></script>

    <!-- map js -->
    <script src="js/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIy8l8gSJaMoUvCZJv8AyCAw3CU07nCKs&amp;callback=initMap" async defer></script>

    <!-- custom scripts -->
    <script src="js/main.js"></script>

    <!-- all js include end -->

</body>

</html>