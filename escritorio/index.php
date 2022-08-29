<?php 
require_once('../header.php');
?>

  <body class="nav-md">

    <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0; text-align: center;">

              <?php 

			  echo $stitulo;

			  ?>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="<?php echo $foto; ?>" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Hola,</span>

                <h2><?php echo $husuario; ?></h2>

              </div>

            </div>

            <!-- /menu profile quick info -->

            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

              <div class="menu_section">

			                  <h3><?php echo $titulomenu; ?></h3>

<br>

                <?php 

				echo $menu;//**********************************************************menu

				?>

              </div>

              <?php

			  echo $configuracion;//***********************************************configuracion

			  ?>



            </div>

            <!-- /sidebar menu -->



            <!-- /menu footer buttons -->

            <?php echo $hmeninf; ?>

            <!-- /menu footer buttons -->

          </div>

        </div>

<?php

echo $navtop;

?>

        <div class="right_col" role="main">

          



          <!-- <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">

               <div class="dashboard_graph">



                <div class="row x_title">

                  <div class="col-md-12">

                    <div id="wowslider-container1">

                      <div class="ws_images"><ul>

                        <li><img src="data1/images/1.jpg" alt="1" title="1" id="wows1_0"/></li>

                        <li><img src="data1/images/2.jpg" alt="2" title="2" id="wows1_1"/></li>

                        <li><img src="data1/images/3.jpg" alt="3" title="3" id="wows1_2"/></li>

                        <li><img src="data1/images/4.jpg" alt="4" title="4" id="wows1_3"/></li>

                        <li><img src="data1/images/5.jpg" alt="5" title="5" id="wows1_4"/></li>

                        <li><img src="data1/images/6.jpg" alt="6" title="6" id="wows1_5"/></li>

                        <li><a href="http://wowslider.com"><img src="data1/images/7.jpg" alt="bootstrap slider" title="7" id="wows1_6"/></a></li>

                        <li><img src="data1/images/9.jpg" alt="9" title="9" id="wows1_7"/></li>

                      </ul></div>

                      <div class="ws_bullets"><div>

                        <a href="#" title="1"><span><img src="data1/tooltips/1.jpg" alt="1"/>1</span></a>

                        <a href="#" title="2"><span><img src="data1/tooltips/2.jpg" alt="2"/>2</span></a>

                        <a href="#" title="3"><span><img src="data1/tooltips/3.jpg" alt="3"/>3</span></a>

                        <a href="#" title="4"><span><img src="data1/tooltips/4.jpg" alt="4"/>4</span></a>

                        <a href="#" title="5"><span><img src="data1/tooltips/5.jpg" alt="5"/>5</span></a>

                        <a href="#" title="6"><span><img src="data1/tooltips/6.jpg" alt="6"/>6</span></a>

                        <a href="#" title="7"><span><img src="data1/tooltips/7.jpg" alt="7"/>7</span></a>

                        <a href="#" title="9"><span><img src="data1/tooltips/9.jpg" alt="9"/>8</span></a>

                      </div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.com">bootstrap slider</a> by WOWSlider.com v8.5</div>

                      <div class="ws_shadow"></div>

                    </div>                    

                  </div>

                  

                </div>

                <div class="clearfix"></div>

              </div> 

            </div>



          </div> -->

          <br />



          <div class="row">





            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel tile" style="overflow:hidden">
                <div class="x_title">
                  <h2>PLAN DE ACCION <span><a href="plan-accion-2025.pdf" target='new'>ver pdf</span></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="text-center">
                        <a href="plan-accion-2025.pdf" target='new' title="Ver Libro Completo"><img src="caratula.png" class='img-responsive'></a>
                    </div>
                </div>
              </div>

            </div>

              <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel tile">
                      <div class="x_title">
                          <h2>PLAN DE ACCION <span><a href="pa.pdf" target='new'>ver pdf</span></h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                          <div class="text-center">
                          <a href="pa.pdf" target='new' title="Ver Libro Completo"><img width="470"border="0" src="inicio/plan.jpg" class='img-responsive'></a>
                          </div>
                      </div>

                  </div>

              </div> -->



          </div>





          

        </div>

        <?php

		echo $footer;

		?>

      </div>

    </div>



    <!-- jQuery -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->

    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- FastClick -->

    

    <script src="../build/js/custom.min.js"></script>
<!-- 
<script type="text/javascript" src="engine1/wowslider.js"></script>

<script type="text/javascript" src="engine1/script.js"></script> -->

    <!-- Flot -->



  </body>

</html>