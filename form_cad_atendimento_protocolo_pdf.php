<?php
    session_start();
    require_once("fpdf/fpdf.php");
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';  
    require('fpdf/multicell.php');
    
    $cod_atendimento=$_GET['cod_atendimento'];
    $sql_pdf = ("SELECT gab_atendimento.cod_atendimento cod_atendimento, gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo cod_tipo, "
                            . "gab_tipo_atendimento.nom_tipo solicitacao, gab_atendimento.dat_atendimento data, gab_atendimento.txt_detalhes detalhes, "
                            . "gab_atendimento.GAB_PESSOA_cod_pessoa cod_pessoa,gab_status_atendimento.nom_status nom_status, gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status cod_status, "
                            . "gab_pessoa.nom_nome, gab_pessoa.ind_pessoa, gab_pessoa.nom_apelido, gab_pessoa.cod_cpf_cnpj, gab_pessoa.cod_rg, gab_pessoa.cod_ie "
                            . "FROM gab_atendimento "
                            . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
                            . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
                            . "LEFT JOIN gab_status_atendimento ON gab_status_atendimento.cod_status = gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status "
                            . "WHERE cod_atendimento='$cod_atendimento' ");
    $results = $mysqli->query($sql_pdf);
    $r=$results->fetch_object();
    
    $sql_pdf2 = ("SELECT nom_vereador, ind_sexo FROM gab_vereador");
    $results2 = $mysqli->query($sql_pdf2);
    $r2=$results2->fetch_object();
    if ($results2->num_rows){
		$ind_sexo=$r2->ind_sexo;
		$nom_vereador=$r2->nom_vereador;
    }
	else{
		$ind_sexo=NULL;
		$nom_vereador=NULL;
	}
    $pdf = new PDF("P","cm","A4");
    
	$pdf->setConnection($mysqli);
    $pdf->SetLeftMargin(1);
    $pdf->SetRightMargin(1);
    $pdf->AddPage();
    $pdf->SetFont("Arial","B",18);
    if ($nom_vereador!=NULL){
        $pdf->Cell(0,1,"Parlamentar ".$nom_vereador,0,1,'C');
    }
    $pdf->SetFont("Arial","B",14);
    $pdf->Cell(0,0.6,"Atendimento Parlamentar - Gestão de Gabinete",0,1,'C');
    $pdf->Ln(0.3);
    $pdf->Cell(0,0,"",1);
    $pdf->Ln(0.5);

    $pdf->SetFont("Arial","",10);        
    $pdf->Cell(0,0.3,"Data: ".converteDataBR($r->data),0,1,'l');
    if ($r->nom_apelido!=NULL) {
        $nome=$r->nom_nome." \"".$r->nom_apelido."\""; 
    }
    else{
        $nome=$r->nom_nome;
    }
    $pdf->Cell(0,0.4,"Nome: ".$nome,0,1,'l');
    
    if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ 
        $pdf->Cell(0,0.4,"CPF: ".$r->cod_cpf_cnpj,0,1,'l');
    }
    if($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ 
        $pdf->Cell(0,0.4,"RG: ".$r->cod_rg,0,1,'l');
    }
    if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ 
        $pdf->Cell(0,0.4,"CNPJ: ".$r->cod_cpf_cnpj,0,1,'l');
    }
    if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ 
        $pdf->Cell(0,0.4,"IE: ".$r->cod_ie,0,1,'l');
    }
   
    
    
    $detalhes = $r->detalhes; 
    $detalhes = preg_replace('/["]/','',$detalhes);

    $pdf->Cell(0,0.4,"Tipo de Atendimento: ".$r->solicitacao,0,1,'l');
    $pdf->Cell(0,0.4,"Situação do Atendimento: ".$r->nom_status,0,1,'l');
    $pdf->ln(0.5);
    $pdf->Cell(0,0.4,"Detalhes: ",0,1,'l');
    $pdf->MultiCell(19,0.4,$detalhes,0,'J');

    $pdf->Output("gestao_gabinete_protocolo_atendimento.pdf","I");
?>