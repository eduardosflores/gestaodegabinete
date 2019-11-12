<html> 
    <body>       
                 <div class="col-md-4">
                    <?php
                    if (!empty ($_GET) && isset($_GET['cod_pessoa'])){
                        $img="fotos/".$_GET['cod_pessoa'].".jpg"; 

                        echo "<div>";
                        if (file_exists($img)) {
                           echo "<img id='div_foto' src=". $img . ">";
                        } else {
                           echo "<img id='div_foto' src='fotos/sem-foto.jpg'>";
                        }
                        echo "</div>";
                    }
                    ?>
                    <br><a href="javascript:window.close();"> Fechar </a> </span>
                </div>
    </body>
    
</html>