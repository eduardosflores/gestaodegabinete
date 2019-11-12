<?php
// Incluindo arquivo de conexão
require_once('includes/conexao.php');

// Selecionando fotos
if ($resultado=$mysqli->query("SELECT img_foto, tip_foto, tam_foto FROM gab_vereador")){
    if ($resultado->num_rows){
        $foto=$resultado->fetch_object();
        
        // Se existir
        if ($foto != null)
        {
            // Definindo tipo do retorno
            header('Content-Type: '. $foto->tip_foto);

            // Retornando conteudo
            echo $foto->img_foto;
        }
    }
}