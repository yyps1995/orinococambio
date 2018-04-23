<?php
  session_start();
  require_once '../class.user.php';
  $user_home = new USER();

  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<script>
    $(document).ready(function(){

      $("#clav").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        $.ajax({
            type:"POST",
            url:"php/modificarclave.php",
            data:datos,
            beforeSend:function(){
                
            },
            success:function(r){
              if (r == 0) { 
                $("#msg").html("<div class='col l6 card green white-text'><strong>Lo sentimos !</strong>  Las contraseñas no coinciden!!</div>");
                
                $("input[name=cnueva]").focus();
                $("input[name=cnueva]").css({border:"solid 1px red"});
                $("input[name=cnueva2]").css({border: "solid 1px red"});
                $("#msg").css({border: "solid 2px red"});
                
              }
               if (r == 1) { 
                $(".contenedor").html("<div class='col l6 card green white-text'><strong>Modificación Exitosa</strong>  </div>");
                
              }
               if (r == 2) { 
                $("#msg").html("<div class='col l6 card green white-text'><strong>¡Contraseña incorrecta!</strong></div>");
                $("input[name=cactual]").css({border: "solid 1px red"});
                $("#msg").css({border: "solid 2px red"});
                
              }
               if (r == 3) { 
                $("#msg").html("<div class='col l6 card green white-text'><strong>Lo sentimos !</strong>  Usuario no encontrado</div>");
                $("#msg").css({border: "solid 2px red"});
                
              }  
                return r;
            },
            error:function(){
                alert("Error al Enviar");
            }
        });        
      }); 
     });
  </script>

    
    <div class="animated fadeInDownBig col-md-5 col-lg-8 col-center contenedor">
      <div id="msg"></div>
      <center><h4>Modificar Contraseña</h4></center>
      <br>
      <form  id="clav">
        <div class="form-group reduce">
          <label>Contraseña actual</label>
          <input type="password" name="cactual" class="form-control" id="formGroupExampleInput" required >
        </div>
        <div class="form-group forty">
          <label class="labe">Contraseña nueva</label>
          <input type="password" name="cnueva" class="form-control" id="formGroupExampleInput2" required >
        </div>
        <div class="form-group forty">
          <label>Repetir contraseña nueva </label>
          <input type="password" name="cnueva2" class="form-control" id="formGroupExampleInput2" required >
        </div>
        <input type="hidden" name="usua" value="<?php echo $_SESSION['userSession']; ?>">

          <br><br>

        <center>
            <button type="submit" class="btn btn-large botonuser">Modificar</button></a>
        </center>
     
      </form>
    </div>
    <a href="https://orinococambio.com" style="color: grey; margin-left:17%;">Regresar al Inicio</a>
    
  

  