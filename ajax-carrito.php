<?php
include("sesion.php");

if($_POST["opcion"]==1){
	$carrito = mysqli_query($conexion,"SELECT * FROM store_carrito
	INNER JOIN productos ON prod_id=car_producto
	WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_POST["producto"]."'");

	$cart = mysqli_fetch_array($carrito);
	$num = mysqli_num_rows($carrito);
	
	if($num==0){
		mysqli_query($conexion,"INSERT INTO store_carrito(car_cliente, car_producto, car_cantidad, car_momento)VALUES('".$_SESSION["idC"]."','".$_POST["producto"]."',1,now())");
	}else{
		mysqli_query($conexion,"UPDATE store_carrito SET car_cantidad=car_cantidad+1, car_momento_actualizado=now() WHERE car_cliente='".$_SESSION["idC"]."' AND car_producto='".$_POST["producto"]."'");
	}
?>
	<script type="text/javascript">
		alert("El producto fue añadido al carrito");
	</script>
<?php
}


$carrito = mysqli_query($conexion,"SELECT * FROM store_carrito
									INNER JOIN productos ON prod_id=car_producto
									WHERE car_cliente='".$_SESSION["idC"]."'");
									$numCar = mysqli_num_rows($carrito);
									?>
                                    <!-- Start Atribute Navigation -->
                                    
                                        
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <span class="badge bg-theme"><?=$numCar;?></span>
                                                </a>
                                                <ul class="dropdown-menu cart-list">
                                                    <?php
													while($car = mysqli_fetch_array($carrito)){
														$fotoCarrito = $car['prod_foto'];
														if($car['prod_foto']==""){
															$fotoCarrito = 'sinfoto.png';
														}
														
														$precioConIvaCarrito = $car['prod_precio'] + ($car['prod_precio']*0.19);
								
														$utilidadWebCarrito = $car['prod_descuento_web']/100;
														$precioWebCarrito = $car['prod_costo'] + ($car['prod_costo']*$utilidadWebCarrito);
														$precioWebConIvaCarrito = $precioWebCarrito + ($precioWebCarrito*0.19);
														
														$totalXproductoCarrito = $precioWebConIvaCarrito*$car['car_cantidad'];
														$sumaCarrito += $totalXproductoCarrito;
													?>
													<li>
                                                        <a href="detalle.php?id=<?=$car['prod_id'];?>" class="photo"><img src="https://softjm.com/usuarios/files/productos/<?=$fotoCarrito;?>" class="cart-thumb" alt="" /></a>
                                                        <h6><a href="detalle.php?id=<?=$car['prod_id'];?>"><?=$car['prod_nombre'];?> </a></h6>
                                                        <p><?=$car['car_cantidad'];?> - <span class="price">$<?=number_format($precioWebConIvaCarrito,0,".",",");?></span></p>
                                                    </li>
													<?php }?>

                                                    <li class="total bg-theme">
                                                        <span class="pull-left"><strong>Total</strong>: $<?php echo number_format($sumaCarrito,0,",",".");?></span>
                                                        <a href="carrito-resumen.php" class="butn small btn-cart white"><span>Ir al carrito</span></a>
                                                    </li>
                                                </ul>

	
                                            
                                    