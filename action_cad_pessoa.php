<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
       //var_dump($_POST);
       //var_dump($_GET);
        $username=$_SESSION['username'];

        if(!empty($_POST)){

            if(isset($_POST['alt'])){          
                //Alteração
                
                $cod_pessoa = $_POST['cod_pessoa'];
                $ind_pessoa = $_POST['ind_pessoa'];
                $nom_nome = trim($_POST['nom_nome']);
                if (isset($_POST['nom_apelido']) && !empty($_POST['nom_apelido'])){
                    $nom_apelido = trim($_POST['nom_apelido']);
                }
                else {
                    $nom_apelido = NULL;
                } 
                //campo representante
                if (isset($_POST['nom_re']) && !empty($_POST['nom_re'])){
                    $nom_re = trim($_POST['nom_re']);
                }
                else {
                    $nom_re = NULL;
                }
                //fim representante
                if (isset($_POST['dat_nascimento']) && !empty($_POST['dat_nascimento'])){
                $dat_nascimento = converte_data($_POST['dat_nascimento']);
                }
                else{
                    $dat_nascimento = NULL;
                }
                if (isset($_POST['ind_sexo']) && !empty($_POST['ind_sexo'])){
                    $ind_sexo = trim($_POST['ind_sexo']);
                }
                else{
                    $ind_sexo = NULL;
                }
                if (isset($_POST['cod_ie']) && !empty($_POST['cod_ie'])){
                    $cod_ie = trim($_POST['cod_ie']);
                }
                else{
                    $cod_ie = NULL;
                }
                if (isset($_POST['cod_cpf_cnpj']) && !empty($_POST['cod_cpf_cnpj'])){
                     $cod_cpf_cnpj = trim($_POST['cod_cpf_cnpj']);
                }
                else {
                    $cod_cpf_cnpj = NULL;
                }
                if (isset($_POST['cod_rg']) && !empty($_POST['cod_rg'])){
                     $cod_rg = trim($_POST['cod_rg']);
                }
                else {
                    $cod_rg = NULL;
                }
                if (isset($_POST['nom_estado']) && !empty($_POST['nom_estado'])){
                     $nom_estado = trim($_POST['nom_estado']);
                }
                else {
                    $nom_estado = NULL;
                }
                if (isset($_POST['num_cep']) && !empty($_POST['num_cep'])){
                     $num_cep = trim($_POST['num_cep']);
                }
                else {
                    $num_cep = NULL;
                }
                if (isset($_POST['nom_cidade']) && !empty($_POST['nom_cidade'])){
                     $nom_cidade = trim($_POST['nom_cidade']);
                }
                else {
                    $nom_cidade = NULL;
                }
                if (isset($_POST['nom_endereco']) && !empty($_POST['nom_endereco'])){
                     $nom_endereco = trim($_POST['nom_endereco']);
                }
                else {
                    $nom_endereco = NULL;
                }
                if (isset($_POST['nom_numero']) && !empty($_POST['nom_numero'])){
                     $nom_numero = trim($_POST['nom_numero']);
                }
                else {
                    $nom_numero = NULL;
                }
                
                if (isset($_POST['nom_bairro']) && !empty($_POST['nom_bairro'])){
                    $nom_bairro = $_POST['nom_bairro'];
                }
                else {
                    $nom_bairro = NULL;
                }
                
                if (isset($_POST['nom_complemento']) && !empty($_POST['nom_complemento'])){
                     $nom_complemento = trim($_POST['nom_complemento']);
                }
                else {
                    $nom_complemento = NULL;
                } 
                if (isset($_POST['num_ddd_tel']) && !empty($_POST['num_ddd_tel'])){
                     $num_ddd_tel = trim($_POST['num_ddd_tel']);
                }
                else{
                    $num_ddd_tel = NULL;
                }     
                if (isset($_POST['num_ddd_cel']) && !empty($_POST['num_ddd_cel'])){
                     $num_ddd_cel = trim($_POST['num_ddd_cel']);
                }
                else{
                    $num_ddd_cel = NULL;
                }
                if (isset($_POST['num_telefone']) && !empty($_POST['num_telefone'])){
                     $num_telefonesinal = trim($_POST['num_telefone']);
                    //tira - do numero do telefone
                     $num_telefone = preg_replace('/[-]/','',$num_telefonesinal); 
                }
                else{
                    $num_telefone = NULL;
                }
                if (isset($_POST['num_celular']) && !empty($_POST['num_celular'])){
                     $num_celularsinal = trim($_POST['num_celular']);
                     //tira - do numero do celular
                     $num_celular = preg_replace('/[-]/','',$num_celularsinal);
                }
                else{
                    $num_celular = NULL;
                }
                if (isset($_POST['nom_email']) && !empty($_POST['nom_email'])){
                    $nom_email = trim($_POST['nom_email']);
                }
                else{
                    $nom_email = NULL;
                }
                if (isset($_POST['txt_obs']) && !empty($_POST['txt_obs'])){
                    $txt_obs = trim($_POST['txt_obs']);
                }
				else{
                    $txt_obs = NULL;
                }
                if (isset($_POST['nom_rede_social']) && !empty($_POST['nom_rede_social'])){
                    $nom_rede_social = trim($_POST['nom_rede_social']);
                }
				else{
                    $nom_rede_social = NULL;
                }
                if (isset($_POST['nom_ocupacao']) && !empty($_POST['nom_ocupacao'])){
                    $nom_ocupacao = trim($_POST['nom_ocupacao']);
                }
                else{
                    $nom_ocupacao = NULL;
                }


                if (!empty($nom_nome)){
                    
                    if($ind_pessoa == "PF")
                    {
                        //Se estiver preenchido, verifica se o CPF já existe no BD
                        if ($cod_cpf_cnpj != NULL){

                            $resultado=$mysqli->query("SELECT cod_pessoa FROM gab_pessoa where cod_cpf_cnpj = '$cod_cpf_cnpj' and cod_pessoa <> $cod_pessoa");
                            if($resultado->num_rows>0)
                            {
                                header('Location: form_cad_pessoa.php?err=O CPF já está vinculado a outra Pessoa!');
                                die();
                            } 
                        }
                    }
                    else
                    {
                        //Se estiver preenchido, verifica se o CNPJ já existe no BD
                        if ($cod_cpf_cnpj != NULL){

                            $resultado=$mysqli->query("SELECT cod_pessoa FROM gab_pessoa where cod_cpf_cnpj = '$cod_cpf_cnpj' and cod_pessoa <> $cod_pessoa");
                            if($resultado->num_rows>0)
                            {
                                header('Location: form_cad_pessoa.php?err=O CNPJ já está vinculado a outra Pessoa!');
                                die();
                            }
                        }
                    }
                    
                    $insert = $mysqli->prepare("UPDATE gab_pessoa SET ind_pessoa=?, nom_nome=?, nom_apelido=?, dat_nascimento=?, cod_cpf_cnpj=?,cod_ie=?, cod_rg=?, ind_sexo=?, num_cep=?, nom_endereco=?, nom_numero=?, nom_bairro=?, nom_complemento=?, nom_cidade=?, nom_estado=?, num_ddd_tel=?, num_tel=?, num_ddd_cel=?, num_cel=?, nom_email=?,txt_obs=?,nom_rede_social=?, nom_ocupacao=?, dat_log=NOW(), nom_usuario_log='$username', nom_operacao_log='UPDATE', nom_re=? WHERE cod_pessoa=?");
                    $insert->bind_param('sssssssssssssssiiiisssssi', $ind_pessoa, $nom_nome, $nom_apelido, $dat_nascimento, $cod_cpf_cnpj, $cod_ie, $cod_rg, $ind_sexo, $num_cep, $nom_endereco, $nom_numero, $nom_bairro, $nom_complemento, $nom_cidade, $nom_estado, $num_ddd_tel,$num_telefone, $num_ddd_cel, $num_celular, $nom_email, $txt_obs ,$nom_rede_social, $nom_ocupacao,$nom_re,$cod_pessoa);

                    if ($insert->execute()) {
                        header('Location: form_cad_pessoa.php?msg=Pessoa alterada com sucesso!');
                        die();
                    }
                    else{
                         header('Location: includes/error.php?err=Registration failure: UPDATE');
                         die();
                    }
                }
            }
            else if(isset($_POST['nom_nome']) ) {   
                //Inserção

                $ind_pessoa = $_POST['ind_pessoa'];
                $nom_nome = trim($_POST['nom_nome']);
                if (isset($_POST['nom_apelido']) && !empty($_POST['nom_apelido'])){
                     $nom_apelido = trim($_POST['nom_apelido']);
                }
                else {
                    $nom_apelido = NULL;
                }
                 //campo representante
                if (isset($_POST['nom_re']) && !empty($_POST['nom_re'])){
                    $nom_re = trim($_POST['nom_re']);
                }
                else {
                    $nom_re = NULL;
                }
                //fim representante
                if (isset($_POST['dat_nascimento']) && !empty($_POST['dat_nascimento'])){
                $dat_nascimento = converte_data($_POST['dat_nascimento']);
                }
                else{
                    $dat_nascimento = NULL;
                }
                if (isset($_POST['ind_sexo']) && !empty($_POST['ind_sexo'])){
                    $ind_sexo = trim($_POST['ind_sexo']);
                }
                else{
                    $ind_sexo = NULL;
                }
                if (isset($_POST['cod_ie']) && !empty($_POST['cod_ie'])){
                    $cod_ie = trim($_POST['cod_ie']);
                }
                else{
                    $cod_ie = NULL;
                }
                if (isset($_POST['cod_cpf_cnpj']) && !empty($_POST['cod_cpf_cnpj'])){
                     $cod_cpf_cnpj = trim($_POST['cod_cpf_cnpj']);
                }
                else {
                    $cod_cpf_cnpj = NULL;
                }
                if (isset($_POST['cod_rg']) && !empty($_POST['cod_rg'])){
                     $cod_rg = trim($_POST['cod_rg']);
                }
                else {
                    $cod_rg = NULL;
                }
                if (isset($_POST['nom_estado']) && !empty($_POST['nom_estado'])){
                     $nom_estado = trim($_POST['nom_estado']);
                }
                else {
                    $nom_estado = NULL;
                }
                if (isset($_POST['num_cep']) && !empty($_POST['num_cep'])){
                     $num_cep = trim($_POST['num_cep']);
                }
                else {
                    $num_cep = NULL;
                }
                if (isset($_POST['nom_cidade']) && !empty($_POST['nom_cidade'])){
                     $nom_cidade = trim($_POST['nom_cidade']);
                }
                else {
                    $nom_cidade = NULL;
                }
                if (isset($_POST['nom_endereco']) && !empty($_POST['nom_endereco'])){
                     $nom_endereco = trim($_POST['nom_endereco']);
                }
                else {
                    $nom_endereco = NULL;
                }
                if (isset($_POST['nom_numero']) && !empty($_POST['nom_numero'])){
                     $nom_numero = trim($_POST['nom_numero']);
                }
                else {
                    $nom_numero = NULL;
                }
                
                if (isset($_POST['nom_bairro']) && !empty($_POST['nom_bairro'])){
                    $nom_bairro = $_POST['nom_bairro'];
                }
                else {
                    $nom_bairro = NULL;
                }
                
                if (isset($_POST['nom_complemento']) && !empty($_POST['nom_complemento'])){
                     $nom_complemento = trim($_POST['nom_complemento']);
                }
                else {
                    $nom_complemento = NULL;
                }      
                if (isset($_POST['num_ddd_cel']) && !empty($_POST['num_ddd_cel'])){
                     $num_ddd_cel = trim($_POST['num_ddd_cel']);
                }
                else{
                    $num_ddd_cel = NULL;
                }
                if (isset($_POST['num_ddd_tel']) && !empty($_POST['num_ddd_tel'])){
                     $num_ddd_tel = trim($_POST['num_ddd_tel']);
                }
                else{
                    $num_ddd_tel = NULL;
                }
                if (isset($_POST['num_telefone']) && !empty($_POST['num_telefone'])){
                     $num_telefonesinal = trim($_POST['num_telefone']);
                    //tira - do numero do telefone
                     $num_telefone = preg_replace('/[-]/','',$num_telefonesinal); 
                }
                else{
                    $num_telefone = NULL;
                }
                if (isset($_POST['num_celular']) && !empty($_POST['num_celular'])){
                     $num_celularsinal = trim($_POST['num_celular']);
                    //tira - do numero do celular
                     $num_celular = preg_replace('/[-]/','',$num_celularsinal);
                }
                else{
                    $num_celular = NULL;
                }
                if (isset($_POST['nom_email']) && !empty($_POST['nom_email'])){
                    $nom_email = trim($_POST['nom_email']);
                }
                else{
                    $nom_email = NULL;
                }
                if (isset($_POST['txt_obs']) && !empty($_POST['txt_obs'])){
                    $txt_obs = trim($_POST['txt_obs']);
                }
                else{
                    $txt_obs = NULL;
                }
                if (isset($_POST['nom_rede_social']) && !empty($_POST['nom_rede_social'])){
                    $nom_rede_social = trim($_POST['nom_rede_social']);
                }
                else{
                    $nom_rede_social = NULL;
                }
                if (isset($_POST['nom_ocupacao']) && !empty($_POST['nom_ocupacao'])){
                    $nom_ocupacao = trim($_POST['nom_ocupacao']);
                }
                else{
                    $nom_ocupacao = NULL;
                }
                $ind_status = "A";
                
                if (isset($_GET['mod']))
                {   
                     $mod=$_GET['mod'];
                }
                else {
                      $mod=0;
                }
            
            if (!empty($nom_nome)){
                //echo "3";
                if($ind_pessoa == "PF")
                {
                    //Se estiver preenchido, verifica se o CPF já existe no BD
                    if ($cod_cpf_cnpj != NULL){
                        
                        $resultado=$mysqli->query("SELECT cod_pessoa FROM gab_pessoa where cod_cpf_cnpj = '$cod_cpf_cnpj'");
                        if($resultado->num_rows>0)
                        {
                        
                            header('Location: form_cad_pessoa.php?err=O CPF já está vinculado a outra Pessoa!');
                            die();
                        }
                    }
                    $insert = $mysqli->prepare("INSERT INTO gab_pessoa (ind_pessoa, nom_nome, nom_apelido, dat_nascimento, cod_cpf_cnpj, cod_rg, ind_sexo, num_cep, nom_endereco, nom_numero, nom_bairro, nom_complemento, nom_cidade, nom_estado, num_ddd_tel, num_tel, num_ddd_cel, num_cel, nom_email, ind_status,txt_obs,nom_rede_social, nom_ocupacao, dat_log, nom_usuario_log, nom_operacao_log, nom_re) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), '$username', 'INSERT', ?)");
                    $insert->bind_param('ssssssssssssssiiiissssss', $ind_pessoa, $nom_nome, $nom_apelido, $dat_nascimento, $cod_cpf_cnpj, $cod_rg, $ind_sexo, $num_cep, $nom_endereco, $nom_numero, $nom_bairro, $nom_complemento, $nom_cidade, $nom_estado, $num_ddd_tel,$num_telefone, $num_ddd_cel, $num_celular, $nom_email, $ind_status, $txt_obs,$nom_rede_social, $nom_ocupacao, $nom_re);
                }
                else
                {
                    //Se estiver preenchido, verifica se o CNPJ já existe no BD
                    if ($cod_cpf_cnpj != NULL){
                        
                        $resultado=$mysqli->query("SELECT cod_pessoa FROM gab_pessoa where cod_cpf_cnpj = '$cod_cpf_cnpj'");
                        if($resultado->num_rows>0)
                        {
                            header('Location: form_cad_pessoa.php?err=O CNPJ já está vinculado a outra Pessoa!');
                            die();
                        }
                    }
                    $insert = $mysqli->prepare("INSERT INTO gab_pessoa (ind_pessoa,nom_nome, nom_apelido, dat_nascimento, cod_cpf_cnpj, cod_ie, num_cep, nom_endereco, nom_numero, nom_bairro, nom_complemento, nom_cidade, nom_estado, num_ddd_tel, num_tel, num_ddd_cel, num_cel, nom_email, ind_status, txt_obs, nom_rede_social, nom_ocupacao, dat_log, nom_usuario_log, nom_operacao_log, nom_re) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), '$username', 'INSERT', ?)");
                    $insert->bind_param('sssssssssssssiiiissssss', $ind_pessoa, $nom_nome, $nom_apelido, $dat_nascimento, $cod_cpf_cnpj, $cod_ie, $num_cep, $nom_endereco, $nom_numero, $nom_bairro, $nom_complemento, $nom_cidade, $nom_estado, $num_ddd_tel,$num_telefone, $num_ddd_cel, $num_celular, $nom_email, $ind_status, $txt_obs, $nom_rede_social, $nom_ocupacao, $nom_re);
                }
                if ($insert->execute()) {
                    

                    $img="temp/".$_POST['id_foto'].".jpg"; 

                    if (file_exists($img)) {
                       //renomear foto
                       rename($img, "temp/".$mysqli->insert_id.".jpg");
                       //copiar foto para pasta "fotos"
                       copy("temp/".$mysqli->insert_id.".jpg", "fotos/".$mysqli->insert_id.".jpg");
                       //apagar foto da pasta "temp"
                       unlink("temp/".$mysqli->insert_id.".jpg");
                    } else {
                       //copia imagem padrão
                        copy("fotos/sem-foto.jpg", "fotos/".$mysqli->insert_id.".jpg");
                    }

                    if (($mod==1))
                    {
                        $cod_pessoa_modal=$mysqli->insert_id;


                         //header('Location: form_cad_municipe.php?msg=Munícipe incluído com sucesso!&mod=1&cod_municipe_modal='.$cod_municipe_modal.'&nom_municipe_modal='.$nom_municipe);
                        ?>
                         <script type="text/javascript">

                            window.opener.document.getElementById('cod_pessoa').value="<?php echo $cod_pessoa_modal;?>";
                            window.opener.document.getElementById('busca').value="<?php echo $nom_municipe;?>";

                            window.opener.document.getElementById("div_foto").width="160";
                            window.opener.document.getElementById("div_foto").height="120";
                            window.opener.document.getElementById("div_foto").src ="fotos/<?php echo $cod_pessoa_modal;?>.jpg?"+ new Date().getTime();

                            window.close();

                        </script>

                        <?php 
                        die();
                    }
                    else{
                        //echo "1";
                        header('Location: form_cad_pessoa.php?msg=Pessoa cadastrada com sucesso!');
                        die();
                    }

                }
                else{
                   // echo "2";
                    header('Location: form_cad_pessoa.php?err=Registration failure: INSERT');
                    die();

                }
            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_pessoa'])){
        //Exclusão
        $cod_pessoa= trim($_GET['cod_pessoa']);
        $resultado_del=$mysqli->query("SELECT cod_atendimento FROM gab_atendimento where ind_status='A' and GAB_PESSOA_cod_pessoa =$cod_pessoa");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_pessoa.php?err=Pessoa vinculada a um Atendimento!');
            die();
        }
        
        $results  = $mysqli->prepare("UPDATE gab_pessoa SET ind_status='I', dat_log=NOW(), nom_usuario_log='$username', nom_operacao_log='UPDATE (EXCLUSÃO)' WHERE cod_pessoa=?");
        $results->bind_param('i', $cod_pessoa);
        if ($results->execute()) {
           header('Location: form_cad_pessoa.php?msg=Pessoa excluída com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_pessoa.php?err=Registration failure: DELETE');
            die();
        }
    }




    if(isset($_POST['cod_cpf_cnpj'])){
        
        $cod_cpf_cnpj = $_POST['cod_cpf_cnpj'];
    
        $resultado=$mysqli->query("SELECT cod_pessoa FROM gab_pessoa where cod_cpf_cnpj = '$cod_cpf_cnpj'");
    
        
        if(mysqli_num_rows($resultado)>0) {
            echo 1;
        }
        else {
            echo 2;
        }
            
    }

?>

