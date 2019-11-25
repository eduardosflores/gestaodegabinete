<?php
    session_start();
    require_once("fpdf/fpdf.php");
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    require('fpdf/multicell.php');
    ///////////////BUSCANDO DADOS NA TABELA /////////////////////
    $sql_pdf = $_SESSION['sql'];
    $records=array();
    $results = $mysqli->query($sql_pdf);
    $num=$results->num_rows;
    while($row = $results->fetch_object()){$records[]=$row;}
    $results->free_result();
    //$docTitulo =" ";
    //$docTitulo2 =" ";
    ///////////////DEFINIÇÃO DO DOCUMENTO PDF/////////////////////
    $pdf = new PDF("P","cm","A4");
	$pdf->setConnection($mysqli);
    $pdf->SetLeftMargin(1);
    $pdf->SetRightMargin(1);
    $pdf->AddPage();
    $pdf->Ln(0.5);
    $pdf->SetFont("Arial","B",15);
    $pdf->Cell(0,0.6,"Relatório de Pessoas - Gestão de Gabinete",0,1,'C');
    $pdf->Ln(0.3);
    $pdf->Cell(0,0,"",1);
    $pdf->Ln(0.5);
    ///////////////CABEÇALHO DA TABELA /////////////////////
    $pdf->SetFont("Arial","B",11);
    $pdf->Cell(9,0.8,"Nome",1,0,'C');
    $pdf->Cell(4.1,0.8,"Doc.Identificação",1,0,'C');
    $pdf->Cell(3,0.8,"Telefone",1,0,'C');
    $pdf->Cell(3,0.8,"Celular",1,1,'C');
    ////////////////DADOS DA TABELA ///////////////////////
    $pdf->SetFont("Arial","",8);
    $pdf->SetWidths(array(9,4.1,3,3));//CADA VALOR DESTE ARRAY SERÁ A LARGURA DE CADA COLUNA
    
    foreach($records as $r){
        if($r->nom_apelido!=NULL){$nome=$r->nom_nome." \"".$r->nom_apelido."\"";}else {$nome=$r->nom_nome;};
       
        $doc="";
        if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ $doc.=" CPF:".$r->cod_cpf_cnpj."\n"; }
		if($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ $doc.=" RG:".$r->cod_rg."\n"; }
        if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ $doc.=" CNPJ:".$r->cod_cpf_cnpj."\n"; }
        if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ $doc.=" IE:".$r->cod_ie."\n"; }


        //acrescenta () no ddd do telefone
        $num_ddd_tel = $r->num_ddd_tel;
        $num_ddd_tel = preg_replace ('/([0-9]{2})/',"($1)",$num_ddd_tel); 
        //acrescenta - no meio do numero do telefone
        $num_tel = $r->num_tel;
        if (strlen($num_tel) == 8){
        $num_tel= preg_replace('/([0-9]{4})([0-9]{4})/',"$1-$2",$num_tel);
        }
        //acrescenta () no ddd do celular
        $num_ddd_cel = $r->num_ddd_cel;
        $num_ddd_cel = preg_replace ('/([0-9]{2})/',"($1)",$num_ddd_cel); 
        //acrescenta - no meio do numero do telefone
        $num_cel = $r->num_cel;
        if (strlen($num_cel) == 9){
        $num_cel= preg_replace('/([0-9]{5})([0-9]{4})/',"$1-$2",$num_cel);       
        }
        //junta os numeros
        $tel=$num_ddd_tel." ".$num_tel;
        $cel=$num_ddd_cel." ".$num_cel;
        
        $pdf->Row(array($nome,$doc,$tel,$cel));
    }
    $pdf->Ln(1);
    $pdf->SetFont("Arial","",12);
    $pdf->Cell(0,0.8,"Total de registros: ".$num,0,1,'C');
    $pdf->Output("gestao_gabinete_pessoas.pdf","I");
?>