<html>
    <body>
               <input type="hidden" id="cod_pessoa" name="cod_pessoa"<?php if (isset($_GET['cod_pessoa'])){echo "value=\"".$_GET['cod_pessoa']."\"";} ?>>

               <input type="hidden" id="id_foto" name="id_foto"<?php if (isset($_GET['id_foto'])){echo "value=\"".$_GET['id_foto']."\"";} ?>>

               <input type="radio" id="web" name="radiobtn" value="web" checked/> <label for="web">WebCam</label>
               <input type="radio" id="upload" name="radiobtn" value="upload"/> <label for="upload">Imagem</label>
                
                <div class="container" >
                    <div height= "240">
                        <div id="divweb" style="display:block; ">
                            <video id="video" width="320" height="240" autoplay></video>
                            <button id="snap">Tirar foto</button>
                        </div>

                        <div id="divupload" style="display:none; " class="custom-file">
                            <img id="imagem" width="320" height="240"/>
                            <input type="file" onChange="preview(this);" class="custom-file-input">
                        </div>
                    </div>
                    <div style="display:none;">
                      <canvas id="canvas" width="320" height="240"></canvas>
                    </div>


                    <br> <span id=uploading style="display:none; " > Fazendo upload . . .  </span>
                    <span id=uploaded  style="display:none;"> Foto foi salva com sucesso!
                    <a href="javascript:window.close();"> Fechar </a> </span>

                </div>

    </body>

    <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script src="js/jquery-1.10.2.min.js"></script>

    <script type="text/javascript">

        $('document').ready(
            function(){
                $('input:radio').click(
                    function(){
                      if (document.getElementById("web").checked == true){
                        $("#uploaded").hide();
                        document.getElementById("divweb").style.display ="block";
                        document.getElementById("divupload").style.display ="none";
                      } else {
                          $("#uploaded").hide();
                        document.getElementById("divupload").style.display ="block";
                        document.getElementById("divweb").style.display ="none";
                      }
                    }
                );
            }
        );

      // Older browsers might not implement mediaDevices at all, so we set an empty object first
      if (navigator.mediaDevices === undefined) {
      navigator.mediaDevices = {};
      }

      // Some browsers partially implement mediaDevices. We can't just assign an object
      // with getUserMedia as it would overwrite existing properties.
      // Here, we will just add the getUserMedia property if it's missing.
      if (navigator.mediaDevices.getUserMedia === undefined) {
      navigator.mediaDevices.getUserMedia = function(constraints) {

      // First get ahold of the legacy getUserMedia, if present
      var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

      // Some browsers just don't implement it - return a rejected promise with an error
      // to keep a consistent interface
      if (!getUserMedia) {
      return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
      }

      // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
      return new Promise(function(resolve, reject) {
      getUserMedia.call(navigator, constraints, resolve, reject);
      });
      }
      }

      navigator.mediaDevices.getUserMedia({ audio: false, video: true })
      .then(function(stream) {
      var video = document.querySelector('video');
      // Older browsers may not have srcObject
      if ("srcObject" in video) {
      video.srcObject = stream;
      } else {
      // Avoid using this in new browsers, as it is going away.
      video.src = window.URL.createObjectURL(stream);
      }
      video.onloadedmetadata = function(e) {
      video.play();
      };
      })
      .catch(function(err) {
      console.log(err.name + ": " + err.message);
      });


     // Elements for taking the snapshot
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var video = document.getElementById('video');

        // Trigger photo take
        document.getElementById("snap").addEventListener("click", function() {


                context.drawImage(video, 0, 0, 320, 240);

                var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
                $("#uploading").show();
                $.ajax({
                  type: "POST",
                  url: "action_cad_foto_pessoa.php",
                  data: {
                     imgBase64: dataUrl,
                     user: "Joe",
                     <?php if (isset($_GET['cod_pessoa'])){?>
                     userid: document.getElementById('cod_pessoa').value,
                     insere: "N"
                     <?php } else {?>
                     userid: document.getElementById('id_foto').value,
                     insere: "S"
                     <?php } ?>
                  }

                }).done(function(msg) {
                  console.log("saved");
                  $("#uploading").hide();
                  $("#uploaded").show();

                    window.opener.document.getElementById("div_foto").width="160";
                    window.opener.document.getElementById("div_foto").height="120";

                    window.opener.document.getElementById("div_foto").src =
                    <?php if (isset($_GET['cod_pessoa'])){?>"fotos/"+document.getElementById('cod_pessoa').value<?php }
                          else {?>"temp/"+document.getElementById('id_foto').value<?php } ?>
                    + ".jpg?"+ new Date().getTime();

                });
        });

        var outImage ="imagem";
        function preview(obj)
        {
            if (FileReader)
            {
                var reader = new FileReader();
                reader.readAsDataURL(obj.files[0]);
                reader.onload = function (e) {
                    var image=new Image();
                    image.src=e.target.result;
                    image.onload = function () {
                        document.getElementById(outImage).src=image.src;


                    context.drawImage(image, 0, 0, 320, 240);

                    var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
                    $("#uploading").show();
                    $.ajax({
                        type: "POST",
                        url: "action_cad_foto_pessoa.php",
                        data: {
                            imgBase64: dataUrl,
                            user: "Joe",
                            <?php if (isset($_GET['cod_pessoa'])){?>
                            userid: document.getElementById('cod_pessoa').value,
                            insere: "N"
                            <?php } else {?>
                            userid: document.getElementById('id_foto').value,
                            insere: "S"
                            <?php } ?>
                        }

                    }).done(function(msg) {
                        console.log("saved");
                        $("#uploading").hide();
                        $("#uploaded").show();

                        window.opener.document.getElementById("div_foto").width="160";
                        window.opener.document.getElementById("div_foto").height="120";

                        window.opener.document.getElementById("div_foto").src =
                        <?php if (isset($_GET['cod_pessoa'])){?>"fotos/"+document.getElementById('cod_pessoa').value<?php }
                                else {?>"temp/"+document.getElementById('id_foto').value<?php } ?>
                        + ".jpg?"+ new Date().getTime();

                    });


                    };
                }
            }
            else
            {
                    //
            }
        }

    </script>

</html>
