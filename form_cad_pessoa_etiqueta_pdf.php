<?php
    
    session_start();
    require_once("fpdf/fpdf.php");
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';    

//var_dump($_POST);
//var_dump($_GET);

if ((!isset($_GET['cod_pessoa']) or empty($_GET['cod_pessoa'])) AND $_GET['origem']=="form_cad_pessoa")
        header ('Location: form_cad_pessoa.php?err=Selecione pelo menos uma pessoa para a geração de etiquetas!');
if (isset($_GET['origem']) and !empty($_GET['origem']))   
{

    $origem=$_GET['origem'];
    if ($origem=="form_cad_pessoa")
    {
        $codigos = 'null';        
                
        $cod_pessoa=$_GET['cod_pessoa'];

        foreach ($cod_pessoa as $cod) {
            $codigos = $codigos . "," . $cod;
        }
        
        $busca = "select gab_pessoa.nom_nome, gab_pessoa.nom_cidade, gab_pessoa.nom_estado, gab_pessoa.nom_endereco,gab_pessoa.nom_numero,".
                " gab_pessoa.nom_bairro, gab_pessoa.nom_complemento, gab_pessoa.num_cep,  gab_pessoa.nom_re ".
                " from gab_pessoa ".
                //" left join gab_bairro on gab_bairro.cod_bairro=gab_pessoa.GAB_BAIRRO_cod_bairro ".
                "where cod_pessoa in ($codigos) order by gab_pessoa.nom_nome";
        $query=$mysqli->query($busca);
        //$_SESSION['sql']=$busca;
        $num_total = $mysqli->query($_SESSION['sql'])->num_rows;
       // if (isset($_POST['op_re'])){ //se op com remetente selecionada
             $vereador="SELECT nom_vereador, ind_sexo, nom_endereco, nom_numero, nom_complemento, nom_cidade, nom_estado, num_cep, img_foto, tip_foto, tam_foto FROM gab_vereador";
             $query2=$mysqli->query($vereador);
        //}

    }
    else
    {
        $busca = $_SESSION['sql'];
        $query=$mysqli->query($busca);
        $num_total = $mysqli->query($_SESSION['sql'])->num_rows;        

       // if (isset($_POST['op_re'])){ //se op com remetente selecionada
            $vereador="SELECT nom_vereador, ind_sexo, nom_endereco, nom_numero, nom_complemento, nom_cidade, nom_estado, num_cep, img_foto, tip_foto, tam_foto FROM gab_vereador";
            $query2=$mysqli->query($vereador);
        //}
    }

}
$tip_ep=$_GET['tip_et'];//tipo do tamanho da etiqueta

    while($r=$query2->fetch_object())
    {       
        $nom_vereador="Parlamentar ".$r->nom_vereador;
        
        if($tip_ep=="T"){
            if (mb_strlen($nom_vereador,"UTF-8")>35){ //se for maior que 55 caracteres  
                $nom_vereador= mb_substr($nom_vereador, 0, 35,"UTF-8"); //restringe
                $nom_vereador=utf8_decode($nom_vereador);
            }
            else
                $nom_vereador=utf8_decode($nom_vereador);
        }else{
            if (mb_strlen($nom_vereador,"UTF-8")>55){ //se for maior que 55 caracteres 
                $nom_vereador= mb_substr($nom_vereador, 0, 55,"UTF-8"); //restringe
                $nom_vereador=utf8_decode($nom_vereador);
            }
            else
                $nom_vereador=utf8_decode($nom_vereador);
        }

        //endereço
        $endereco_vereador=$r->nom_endereco.",".$r->nom_numero;

        if($tip_ep=="T"){
            if (mb_strlen($endereco_vereador,"UTF-8")>35){ //se for maior que 55 caracteres 
                $endereco_vereador= mb_substr($endereco_vereador, 0, 35,"UTF-8"); //restringe
                $endereco_vereador=utf8_decode($endereco_vereador);
            }
            else
                $endereco_vereador=utf8_decode($endereco_vereador);
        }else{
            if (mb_strlen($endereco_vereador,"UTF-8")>55){ //se for maior que 55 caracteres 
                $endereco_vereador= mb_substr($endereco_vereador, 0, 55,"UTF-8"); //restringe
                $endereco_vereador=utf8_decode($endereco_vereador);
            }
            else
                $endereco_vereador=utf8_decode($endereco_vereador);
        }

        //bairro
        $bairro_vereador=$r->nom_complemento;

        if($tip_ep=="T"){
            if (mb_strlen($bairro_vereador,"UTF-8")>35){ //se for maior que 55 caracteres 
                $bairro_vereador= mb_substr($bairro_vereador, 0, 35,"UTF-8"); //restringe
                $bairro_vereador=utf8_decode($bairro_vereador);
            }
            else
                $bairro_vereador=utf8_decode($bairro_vereador);
        }else{
            if (mb_strlen($bairro_vereador,"UTF-8")>55){ //se for maior que 55 caracteres 
                $bairro_vereador= mb_substr($bairro_vereador, 0, 55,"UTF-8"); //restringe
                $bairro_vereador=utf8_decode($bairro_vereador);
            }
            else
                $bairro_vereador=utf8_decode($bairro_vereador);
        }

        //cidade
        if(!empty($r->num_cep)){
            $cep=" -CEP:"; 
        }else{
            $cep=" ";            
        }
        if(!empty($r->nom_estado)){
            $est="/"; 
        }else{
            $est=" ";            
        }

        $cidade_cep_vereador=$r->nom_cidade.$est.$r->nom_estado.$cep.$r->num_cep;

        if($tip_ep=="T"){
            if (mb_strlen($cidade_cep_vereador,"UTF-8")>35){ //se for maior que 55 caracteres 
                $cidade_cep_vereador= mb_substr($cidade_cep_vereador, 0, 35,"UTF-8"); //restringe
                $cidade_cep_vereador=utf8_decode($cidade_cep_vereador);
            }
            else
                $cidade_cep_vereador=utf8_decode($cidade_cep_vereador);
        }else{
            if (mb_strlen($cidade_cep_vereador,"UTF-8")>55){ //se for maior que 55 caracteres 
                $cidade_cep_vereador= mb_substr($cidade_cep_vereador, 0, 55,"UTF-8"); //restringe
                $cidade_cep_vereador=utf8_decode($cidade_cep_vereador);
            }
            else
                $cidade_cep_vereador=utf8_decode($cidade_cep_vereador);
        }
    }
// Variaveis de Tamanho

$pular=0;
if ($tip_ep=="T"){ //se folha com trinta etiqueta
    $mesq = "5"; // Margem Esquerda (mm)
    $mdir = "5"; // Margem Direita (mm)
    $msup = "16"; // Margem Superior (mm)
    $leti = 66.6; // Largura da Etiqueta (mm)
    $aeti = 25.9; // Altura da Etiqueta (mm)
    $ehet = "4"; // Espaço horizontal entre as Etiquetas (mm)
    $pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
    $pdf->AddPage(); // adiciona a primeira pagina
    $pdf->SetFont('Arial','B',8);
    $page=1;
    if(isset($_GET['pular']) && !empty($_GET['pular'])  ){
        $pular=$_GET['pular'];
    }else{
        $pular = 0;
    }
    $pdf->SetDisplayMode('fullpage');//Adicinei uma fullpage
    $linha_valor=10;
}
if ($tip_ep=="V"){ //se folha com vinte etiquetas
    $mesq = "4"; // Margem Esquerda (mm)
    $mdir = "3"; // Margem Direita (mm)
    $msup = "16.3"; // Margem Superior (mm)
    $leti = 101.6; // Largura da Etiqueta (mm)
    $aeti = 25.9; // Altura da Etiqueta (mm)
    $ehet = "9"; // Espaço horizontal entre as Etiquetas (mm)
    $pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
    $pdf->AddPage(); // adiciona a primeira pagina
    $pdf->SetFont('Arial','B',8);
    $page=1;
    if(isset($_GET['pular']) && !empty($_GET['pular'])  ){
        $pular=$_GET['pular'];
    }else{
        $pular = 0;
    }
    $pdf->SetDisplayMode('fullpage');//Adicinei uma fullpage
    $linha_valor=10;
}
if ($tip_ep=="Q"){ //se folha com quatorze
    $mesq = "4"; // Margem Esquerda (mm)
    $mdir = "3"; // Margem Direita (mm)
    $msup = "24.8"; // Margem Superior (mm)
    $leti = 101.6; // Largura da Etiqueta (mm)
    $aeti = 35.5; // Altura da Etiqueta (mm)
    $ehet = "9"; // Espaço horizontal entre as Etiquetas (mm)
    $pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
    $pdf->AddPage(); // adiciona a primeira pagina
    $pdf->SetFont('Arial','B',8);
    $page=1;
    if(isset($_GET['pular']) && !empty($_GET['pular'])  ){
        $pular=$_GET['pular'];
    }else{
        $pular = 0;
    }
    $pdf->SetDisplayMode('fullpage');//Adicinei uma fullpage
    $linha_valor=7;    
}


$coluna = 0;
$linha = 0;
$aux=1;
$ver_impar=0;
$linha_ad=0;
$contador=0;
//MONTA A ARRAY PARA ETIQUETAS

if (isset($_GET['op_re'])){ //se for com remetente imprime vereador

     if($tip_ep=="T"){ //se for com trinta ou seja tres colunas

        while($r=$query->fetch_object()) {

            
            $nome = $r->nom_nome;

            if (mb_strlen($nome,"UTF-8")>=35) //se for maior que 55 caracteres 
            { 
                $nome= mb_substr($nome, 0, 35,"UTF-8"); //restringe
                $nome = utf8_decode($nome);                
            }else
                $nome = utf8_decode($nome);                
                
            if (!empty($r->nom_re)){
                $nom_re = "A/C: ".$r->nom_re;
                if (mb_strlen($nom_re,"UTF-8")>=35) //se for maior que 55 caracteres 
                { 
                    $nom_re= mb_substr($nom_re, 0, 35,"UTF-8"); //restringe
                    $nom_re = utf8_decode($nom_re);                    
                }else
                    $nom_re = utf8_decode($nom_re);                    
                
            }else{
                $nom_re=null;
            }

            if (!empty($r->nom_endereco)){
                $ende = $r->nom_endereco.",". $r->nom_numero;
                if (mb_strlen($ende,"UTF-8")>=35) //se for maior que 55 caracteres 
                { 
                    $ende= mb_substr($ende, 0, 35,"UTF-8"); //restringe
                    $ende = utf8_decode($ende);                    
                }else
                    $ende = utf8_decode($ende);                    
                
            }else{
                $ende=null;
            }
            
            if (!empty($r->nom_complemento)){
                $bairro = $r->nom_bairro."-".$r->nom_complemento;
                if (mb_strlen($bairro,"UTF-8")>=35){
                    $bairro= mb_substr($bairro, 0, 35,"UTF-8"); //restringe
                    $bairro = utf8_decode($bairro);                                        
                }else
                    $bairro = utf8_decode($bairro);                                    
            }else 
            if (!empty($r->nom_bairro)){
                if (mb_strlen($r->nom_bairro,"UTF-8")>=35){
                    $bairro= mb_substr($r->nom_bairro, 0, 35,"UTF-8");
                    $bairro = utf8_decode($bairro);
                }else{
                    $bairro = utf8_decode($r->nom_bairro);
                }
            }else{
                $bairro=null;
            } 

            if(!empty($r->num_cep)){
                $cep="-CEP:"; 
            }else{
                $cep=" ";            
            }
            if(!empty($r->nom_estado)){
                $est="/"; 
            }else{
                $est=" ";            
            }

            $cidade_cep=$r->nom_cidade.$est.$r->nom_estado.$cep.$r->num_cep;
            if (mb_strlen($cidade_cep,"UTF-8")>=35) //se for maior que 55 caracteres 
            { 
                $cidade_cep= mb_substr($cidade_cep, 0, 35,"UTF-8"); //restringe
                $cidade_cep=utf8_decode($cidade_cep);
            }else
                $cidade_cep=utf8_decode($cidade_cep);

           

            //exibição 
            if($pular%2==0){ //verifica se é par

                if($coluna == "3") { // se for maior que tres
                    $coluna = 0; // $coluna volta para o valor inicial
                    $linha = $linha +2; // $linha é igual ela mesma +1
                }

                if($linha == $linha_valor) { // Se for a última linha da página
                $pdf->AddPage(); // Adiciona uma nova página
                $linha = 0; // $linha volta ao seu valor inicial
                $page++;
                }

                $posicaoV = $linha*$aeti;
                $posicaoH = $coluna*$leti; //alterar local de acordo com a coluna
                $ehetH = $coluna*$ehet;
                if($coluna == "0") { // Se a coluna for 0
                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
                } else{ // Senão
                $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
                }

                if($linha =="0") { // Se a linha for 0
                    if ($pular!=0 and $page==1)
                    {
                        $somaV = $msup+$aeti*$pular;
                        $linha=$pular;
                    }
                    else{    
                        $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
                    }
                } else { // Senão
                    $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
                }
                
                $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
                if (!empty($r->nom_re)){
                    $pdf->Text($somaH,$somaV+5,$nom_re); // Imprime o nome do representante se tiver de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+10,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+15, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+20,$cidade_cep);                    
                }else{
                    $pdf->Text($somaH,$somaV+5,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+10, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+15,$cidade_cep);
                } 
				
				if (!empty($nom_vereador)){
                $pdf->Text($somaH,$somaV+$aeti,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+$aeti+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+$aeti+10,$bairro_vereador ); // Imprime
                $pdf->Text($somaH,$somaV+$aeti+15,$cidade_cep_vereador);  
				}

                $coluna++;
                    
            }else{//se for impar

                if($coluna == "3") { // se for maior que tres
                $coluna = 0; // $coluna volta para o valor inicial
                $linha = $linha +2; // $linha é igual ela mesma +1
                $ver_impar=0;
                }

                //atribui ao valor linha o pular
                if($linha =="0") { // Se a linha for 0
                    if ($pular!=0 and $page==1)
                    {
                        $linha=$pular;
                    }
                } 
                if(($aux==$num_total)&&($linha==9)){
                    $ver_impar=1; //remetente 
                    $linha_ad=1; // para especificar que é preciso já exibir uma linha adicional para o vereador antes de sair do while  
                                  
                }else
                if($linha >= $linha_valor) { // Se for a última linha da página
                $pdf->AddPage(); // Adiciona uma nova página
                $linha = 1; // $linha volta ao seu valor inicial
                $page++;
                $ver_impar=1;
                }

                


                $posicaoV = $linha*$aeti;
                $posicaoH = $coluna*$leti; //alterar local de acordo com a coluna
                $ehetH = $coluna*$ehet;
                if($coluna == "0") { // Se a coluna for 0
                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
                } else{ // Senão
                $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
                }

                if($linha =="0") { // Se a linha for 0
                    if ($pular!=0 and $page==1)
                    {
                        $somaV = $msup+$aeti*$pular;
                    }
                    else{    
                        $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
                    }
                } else { // Senão
                    $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
                }

                if ($linha==9){
                    
                    $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
                    if (!empty($r->nom_re)){
                        $pdf->Text($somaH,$somaV+5,$nom_re); // Imprime o nome do representante se tiver de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+10,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+15, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+20,$cidade_cep);                    
                    }else{
                        $pdf->Text($somaH,$somaV+5,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+10, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+15,$cidade_cep);
                    }

                    if(($linha_ad==1)&&($ver_impar==1)){ //para imprimir vereador na primeira linha na página seguinte se for folha final
                        $pdf->AddPage(); // Adiciona uma nova página
                        $linha = 0; // $linha volta ao seu valor inicial
                        $page++;
                        $contador=$coluna;
                        $coluna = 0; // $coluna volta para o valor inicial  

                    for($c=0; $c <= $contador; $c++){
                        // atribui novos valores a variável de posição
                        $posicaoH = $coluna*$leti; //alterar local de acordo com a coluna
                        $ehetH = $coluna*$ehet;
                        if($coluna == "0") { // Se a coluna for 0
                        $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
                        } else{ // Senão
                        $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
                        }
                        //exibe
                        $pdf->Text($somaH,$msup,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                        $pdf->Text($somaH,$msup+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                        $pdf->Text($somaH,$msup+10,$bairro_vereador ); // Imprime
                        $pdf->Text($somaH,$msup+15,$cidade_cep_vereador); 
                        $coluna++;                
                        }
                    
                    }   
                        

                }else{
                    $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
                    if (!empty($r->nom_re)){
                        $pdf->Text($somaH,$somaV+5,$nom_re); // Imprime o nome do representante se tiver de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+10,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+15, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+20,$cidade_cep);                    
                    }else{
                        $pdf->Text($somaH,$somaV+5,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+10, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                        $pdf->Text($somaH,$somaV+15,$cidade_cep);
                    }

                    $pdf->Text($somaH,$somaV+$aeti,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+$aeti+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+$aeti+10,$bairro_vereador ); // Imprime
                    $pdf->Text($somaH,$somaV+$aeti+15,$cidade_cep_vereador);
                }

                
                if(($linha==1)&&($ver_impar==1)){ //acrescenta vereador a primeira linha da nova folha
                        
                    if($aux==$num_total){//se ele estiver ja na ultima volta do while, ou seja exibindo o ultimo objeto do banco na linha, preenche na linha de sima todos os tres 
                        if($coluna=="0"){ 
                            for($c=0; $c <= 2; $c++){
                                // atribui novos valores a variável de posição
                                $posicaoH = $coluna*$leti; //alterar local de acordo com a coluna
                                $ehetH = $coluna*$ehet;
                                if($coluna == "0") { // Se a coluna for 0
                                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
                                } else{ // Senão
                                $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
                                }
                                //exibe
                                $pdf->Text($somaH,$msup,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                                $pdf->Text($somaH,$msup+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                                $pdf->Text($somaH,$msup+10,$bairro_vereador ); // Imprime
                                $pdf->Text($somaH,$msup+15,$cidade_cep_vereador); 
                                $coluna++;                
                            }
                        } else
                        if($coluna=="1"){
                            for($c=0; $c <= 1; $c++){
                                // atribui novos valores a variável de posição
                                $posicaoH = $coluna*$leti; //alterar local de acordo com a coluna
                                $ehetH = $coluna*$ehet;
                                if($coluna == "0") { // Se a coluna for 0
                                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
                                } else{ // Senão
                                $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
                                }
                                //exibe
                                $pdf->Text($somaH,$msup,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                                $pdf->Text($somaH,$msup+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                                $pdf->Text($somaH,$msup+10,$bairro_vereador ); // Imprime
                                $pdf->Text($somaH,$msup+15,$cidade_cep_vereador); 
                                $coluna++;                
                            }
                        }else
                        if($coluna=="2"){
                            for($c=0; $c <= 0; $c++){
                                // atribui novos valores a variável de posição
                                $posicaoH = $coluna*$leti; //alterar local de acordo com a coluna
                                $ehetH = $coluna*$ehet;
                                if($coluna == "0") { // Se a coluna for 0
                                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
                                } else{ // Senão
                                $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
                                }
                                //exibe
                                $pdf->Text($somaH,$msup,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                                $pdf->Text($somaH,$msup+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                                $pdf->Text($somaH,$msup+10,$bairro_vereador ); // Imprime
                                $pdf->Text($somaH,$msup+15,$cidade_cep_vereador); 
                                $coluna++;                
                            }
                        }
                    }else{
                    $pdf->Text($somaH,$msup,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                    $pdf->Text($somaH,$msup+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                    $pdf->Text($somaH,$msup+10,$bairro_vereador ); // Imprime
                    $pdf->Text($somaH,$msup+15,$cidade_cep_vereador);
                    }
                }
                
               
                $coluna++;
                $aux++; 
                
            }
        }       
              
           
        
    } else{ //se for com duas colunas

        while($r=$query->fetch_object()) {
        

            $nome = $r->nom_nome;
            if (mb_strlen($nome,"UTF-8")>=55) //se for maior que 55 caracteres 
            { 
                $nome= mb_substr($nome, 0, 55,"UTF-8"); //restringe
                $nome = utf8_decode($nome);                                
            }else
                $nome = utf8_decode($nome);                            

            if (!empty($r->nom_re)){
                $nom_re = "A/C: ".$r->nom_re;
                if (mb_strlen($nom_re,"UTF-8")>=55) //se for maior que 55 caracteres 
                { 
                    $nom_re= mb_substr($nom_re, 0, 55,"UTF-8"); //restringe
                    $nom_re = utf8_decode($nom_re);                                        
                }else
                    $nom_re = utf8_decode($nom_re);                                    
            }else{
                $nom_re=null;
            }

            if (!empty($r->nom_endereco)){
                $ende = $r->nom_endereco.",". $r->nom_numero;
                if (mb_strlen($ende,"UTF-8")>=55) //se for maior que 55 caracteres 
                { 
                    $ende= mb_substr($ende, 0, 55,"UTF-8"); //restringe
                    $ende = utf8_decode($ende);                                        
                }else
                    $ende = utf8_decode($ende);                                    
            }else{
                $ende=null;
            }
            
            if (!empty($r->nom_complemento)){
                $bairro = $r->nom_bairro."-".$r->nom_complemento;
                if (mb_strlen($bairro,"UTF-8")>=55){
                    $bairro= mb_substr($bairro, 0, 55,"UTF-8"); //restringe
                    $bairro = utf8_decode($bairro);                                        
                }else
                    $bairro = utf8_decode($bairro);                                    
            }else 
            if (!empty($r->nom_bairro)){
                if (mb_strlen($r->nom_bairro,"UTF-8")>=55){
                    $bairro= mb_substr($r->nom_bairro, 0, 55,"UTF-8");
                    $bairro = utf8_decode($bairro);
                }else{
                    $bairro = utf8_decode($r->nom_bairro);
                }
            }else{
                $bairro=null;
            } 

            //cep
            if(!empty($r->num_cep)){
                $cep="-CEP:"; 
            }else{
                $cep=" ";            
            }
            if(!empty($r->nom_estado)){
                $est="/"; 
            }else{
                $est=" ";            
            }

            $cidade_cep=$r->nom_cidade.$est.$r->nom_estado.$cep.$r->num_cep;
        
            if (mb_strlen($cidade_cep,"UTF-8")>=55) //se for maior que 55 caracteres 
            { 
                $cidade_cep= mb_substr($cidade_cep, 0, 55,"UTF-8"); //restringe
                $cidade_cep=utf8_decode($cidade_cep);                
            }else
                $cidade_cep=utf8_decode($cidade_cep);            

            if($linha >= $linha_valor) { // Se for a última linha da página
            $pdf->AddPage(); // Adiciona uma nova página
            $linha = 0; // $linha volta ao seu valor inicial
            $page++;
            }

            $posicaoV = $linha*$aeti;
            $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial

            if($linha =="0") { // Se a linha for 0
                if ($pular!=0 and $page==1)
                {
                    $somaV = $msup+$aeti*$pular;
                    $linha=$pular;
                }
                else{    
                    $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
                }
            } else { // Senão
                $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
            }

            //exibição 
            
            $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
            if (!empty($r->nom_re)){
                $pdf->Text($somaH,$somaV+5,$nom_re); // Imprime o nome do representante se tiver de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+10,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+15, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+20,$cidade_cep);
            }else{
                $pdf->Text($somaH,$somaV+5,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+10, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                $pdf->Text($somaH,$somaV+15,$cidade_cep);
            }

                if (!empty($nom_vereador)){
				$pdf->Text($somaH+$leti+$ehet,$somaV,$nom_vereador); // Imprime o nome do Vereador de acordo com as coordenadas
                $pdf->Text($somaH+$leti+$ehet,$somaV+5,$endereco_vereador); // Imprime o endereço do Vereador de acordo com as coordenadas
                $pdf->Text($somaH+$leti+$ehet,$somaV+10,$bairro_vereador ); // Imprime
                $pdf->Text($somaH+$leti+$ehet,$somaV+15,$cidade_cep_vereador);
				}
        
            $linha++;
            $aux++;
        }
    }
}else{//se não for com remetente

    if($tip_ep=="T"){//se for trinta sem remetente
        while($r=$query->fetch_object()) {
            $nome = $r->nom_nome;
            if (mb_strlen($nome,"UTF-8")>=35){
                $nome= mb_substr($nome, 0, 35,"UTF-8"); //restringe
                $nome = utf8_decode($nome);                                
            } else
                $nome = utf8_decode($nome);                            

            if (!empty($r->nom_re)){
                $nom_re = "A/C: ".$r->nom_re;
                if (mb_strlen($nom_re,"UTF-8")>=35){
                        $nom_re= mb_substr($nom_re, 0, 35,"UTF-8"); //restringe
                        $nom_re = utf8_decode($nom_re);                                                                
                } else
                        $nom_re = utf8_decode($nom_re);                                        
                
            }else{
                $nom_re=null;
            }

            if (!empty($r->nom_endereco)){
                $ende =$r->nom_endereco.",". $r->nom_numero;
                if (mb_strlen($ende,"UTF-8")>=35){
                        $ende= mb_substr($ende, 0, 35,"UTF-8"); //restringe
                        $ende = utf8_decode($ende);                                                                
                }else
                        $ende = utf8_decode($ende);                                                     
            }else{
                $ende=null;
            } 

            if (!empty($r->nom_complemento)){
                $bairro = $r->nom_bairro."-".$r->nom_complemento;
                if (mb_strlen($bairro,"UTF-8")>=35){
                    $bairro= mb_substr($bairro, 0, 35,"UTF-8"); //restringe
                    $bairro = utf8_decode($bairro);                                        
                }else
                    $bairro = utf8_decode($bairro);                                    
            }else 
            if (!empty($r->nom_bairro)){
                if (mb_strlen($r->nom_bairro,"UTF-8")>=35){
                    $bairro= mb_substr($r->nom_bairro, 0, 35,"UTF-8");
                    $bairro = utf8_decode($bairro);
                }else{
                    $bairro = utf8_decode($r->nom_bairro);
                }
            }else{
                $bairro=null;
            } 

            if(!empty($r->num_cep)){
                $cep="-CEP:"; 
            }else{
                $cep=" ";            
            }
            if(!empty($r->nom_estado)){
                $est="/"; 
            }else{
                $est=" ";            
            }

            $cidade_cep=$r->nom_cidade.$est.$r->nom_estado.$cep.$r->num_cep; 
            if (mb_strlen($cidade_cep,"UTF-8")>=35){
                $cidade_cep= mb_substr($cidade_cep, 0, 35,"UTF-8"); //restringe
                $cidade_cep=utf8_decode($cidade_cep);                
            }else
                $cidade_cep=utf8_decode($cidade_cep);            

                if($coluna == "3") {
                $coluna = 0; // $coluna volta para o valor inicial
                $linha = $linha +1; // $linha é igual ela mesma +1
            }

            if($linha >= $linha_valor) { // Se for a última linha da página
            $pdf->AddPage(); // Adiciona uma nova página
            $linha = 0; // $linha volta ao seu valor inicial
            $page++;
            }

            $posicaoV = $linha*$aeti;
            $posicaoH = $coluna*$leti;
            $ehetH = $coluna*$ehet;
            
            if($coluna == "0") { // Se a coluna for 0
            $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
            } else { // Senão
            $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
            }

            if($linha =="0") { // Se a linha for 0
                if ($pular!=0 and $page==1)
                {
                    $somaV = $msup+$aeti*$pular;
                    $linha=$pular;
                }
                else{    
                    $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
                }
            } else { // Senão
                $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
            }

            //exibição 
            
                $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
                if (!empty($r->nom_re)){
                    $pdf->Text($somaH,$somaV+5,$nom_re); // Imprime o nome do representante se tiver de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+10,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+15, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+20,$cidade_cep);
                }else{
                    $pdf->Text($somaH,$somaV+5,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+10, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+15,$cidade_cep);
                }
                
            $aux++;
            $coluna++;
        }

    }else{  //se for 20 ou 14 sem remetente

        while($r=$query->fetch_object()) { 
            $nome = $r->nom_nome;   
            if (mb_strlen($nome,"UTF-8")>=55) //se for maior que 55 caracteres 
            {        
                $nome= mb_substr($nome, 0, 55,"UTF-8"); //restringe
                $nome = utf8_decode($nome);                                
            }else
                $nome = utf8_decode($nome);                            

            if (!empty($r->nom_re)){
                $nom_re = "A/C: ".$r->nom_re;
                if (mb_strlen($nom_re,"UTF-8")>=55) //se for maior que 55 caracteres 
                { 
                    $nom_re= mb_substr($nom_re, 0, 55,"UTF-8"); //restringe
                    $nom_re = utf8_decode($nom_re);                                                                                    
                }else
                    $nom_re = utf8_decode($nom_re);                                                                                
            }else{
                $nom_re=null;
            }

            if (!empty($r->nom_endereco)){
                $ende = $r->nom_endereco.",". $r->nom_numero;
                if (mb_strlen($ende,"UTF-8")>=55) //se for maior que 55 caracteres 
                { 
                        $ende= mb_substr($ende, 0, 55,"UTF-8"); //restringe
                        $ende = utf8_decode($ende);                                                                                        
                }else
                        $ende = utf8_decode($ende);                                                                                
            }else{
                $ende=null;
            }

            if (!empty($r->nom_complemento)){
                $bairro = $r->nom_bairro."-".$r->nom_complemento;
                if (mb_strlen($bairro,"UTF-8")>=55){
                    $bairro= mb_substr($bairro, 0, 55,"UTF-8"); //restringe
                    $bairro = utf8_decode($bairro);                                        
                }else
                    $bairro = utf8_decode($bairro);                                    
            }else 
            if (!empty($r->nom_bairro)){
                if (mb_strlen($r->nom_bairro,"UTF-8")>=55){
                    $bairro= mb_substr($r->nom_bairro, 0, 55,"UTF-8");
                    $bairro = utf8_decode($bairro);
                }else{
                    $bairro = utf8_decode($r->nom_bairro);
                }
            }else{
                $bairro=null;
            } 

            if(!empty($r->num_cep)){
                $cep="-CEP:"; 
            }else{
                $cep=" ";            
            }
            if(!empty($r->nom_estado)){
                $est="/"; 
            }else{
                $est=" ";            
            }

            $cidade_cep=$r->nom_cidade.$est.$r->nom_estado.$cep.$r->num_cep;
        
            if (mb_strlen($cidade_cep,"UTF-8")>=55) //se for maior que 55 caracteres 
            { 
                $cidade_cep= mb_substr($cidade_cep, 0, 55,"UTF-8"); //restringe
                $cidade_cep=utf8_decode($cidade_cep);                                
            }else
                $cidade_cep=utf8_decode($cidade_cep);                            


            if($coluna == "2") {
                $coluna = 0; // $coluna volta para o valor inicial
                $linha = $linha +1; // $linha é igual ela mesma +1
            }

            if($linha >= $linha_valor) { // Se for a última linha da página
            $pdf->AddPage(); // Adiciona uma nova página
            $linha = 0; // $linha volta ao seu valor inicial
            $page++;
            }

            $posicaoV = $linha*$aeti;
            $posicaoH = $coluna*$leti;
            $ehetH = $coluna*$ehet;
            
            if($coluna == "0") { // Se a coluna for 0
            $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
            } else { // Senão
            $somaH = $mesq+$posicaoH+$ehetH; // Soma Horizontal é a margem inicial mais a posiçãoH
            }

            if($linha =="0") { // Se a linha for 0
                if ($pular!=0 and $page==1)
                {
                    $somaV = $msup+$aeti*$pular;
                    $linha=$pular;
                }
                else{    
                    $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
                }
            } else { // Senão
                $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
            }

            //exibição 
            
                $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
                if (!empty($r->nom_re)){
                    $pdf->Text($somaH,$somaV+5,$nom_re); // Imprime o nome do representante se tiver de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+10,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+15, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+20,$cidade_cep);
                }else{
                    $pdf->Text($somaH,$somaV+5,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+10, $bairro); // Imprime o endereço da pessoa de acordo com as coordenadas
                    $pdf->Text($somaH,$somaV+15,$cidade_cep);
                }
            
            $aux++;
            $coluna++;
        }
    }
}

$pdf->Output("pessoa_etiqueta.pdf","I");
?>