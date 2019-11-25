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
    
    $pdf = new PDF("P","cm","A4");
	$pdf->setConnection($mysqli);
    $pdf->SetLeftMargin(1);
    $pdf->SetRightMargin(1);
    $pdf->AddPage();
    $pdf->Ln(0.5);
    $pdf->SetFont("Arial","BU",15);
    $pdf->Cell(0,0.6,"Gestão de Gabinete - Atendimento",0,1,'C');
    //$pdf->Ln(0.3);
    //$pdf->Cell(0,0,"",1);
    $pdf->Ln(0.5);

    $pdf->SetFont("Arial","B",10);
    $pdf->Cell(4.5,0.3,"Data: ",0, 0,'l');
    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(0, 0.3, converteDataBR($r->data), 0, 1, 'l');

    if ($r->nom_apelido!=NULL) {
        $nome=$r->nom_nome." \"".$r->nom_apelido."\""; 
    }
    else{
        $nome=$r->nom_nome;
    }
    $pdf->SetFont("Arial","B",10);
    $pdf->Cell(4.5, 0.4,"Nome: ", 0, 0, 'l');
    $pdf->SetFont("Arial","",10);
    $pdf->Cell(0, 0.4, $nome, 0, 1, 'l');
    
    if (!empty($r->cod_cpf_cnpj)){
        $pdf->SetFont("Arial","B",10);
        if($r->ind_pessoa == "PF"){
            $pdf->Cell(4.5,0.4,"CPF: ",0,0,'l');
        }else{
            $pdf->Cell(4.5,0.4,"CNPJ: ",0,0,'l');
        }
        $pdf->SetFont("Arial","",10);
        $pdf->Cell(0, 0.4, $r->cod_cpf_cnpj, 0, 1, 'l');
    }

    if(!empty($r->cod_rg)){
        $pdf->SetFont("Arial","B",10);
        $pdf->Cell(4.5, 0.4, "RG: ", 0, 0, 'l');
        $pdf->SetFont("Arial","",10);
        $pdf->Cell(0, 0.4, $r->cod_rg, 0, 1, 'l');
    }
    if(!empty($r->cod_ie)){
        $pdf->SetFont("Arial","B",10);
        $pdf->Cell(4.5, 0.4, "IE: ", 0, 0,'l');
        $pdf->SetFont("Arial","",10);
        $pdf->Cell(0, 0.4, $r->cod_ie, 0, 1, 'l');
    }

    $detalhes = $r->detalhes; 
    $detalhes = preg_replace('/["]/','',$detalhes);

    $pdf->SetFont("Arial","B",10);
    $pdf->Cell(4.5,0.4,"Tipo de Atendimento: ",0,0,'l');
    $pdf->SetFont("Arial","",10);
    $pdf->Cell(0,0.4,$r->solicitacao,0,1,'l');

    $pdf->SetFont("Arial","B",10);
    $pdf->Cell(4.5,0.4,"Situação do Atendimento: ",0,0,'l');
    $pdf->SetFont("Arial","",10);
    $pdf->Cell(0,0.4,$r->nom_status,0,1,'l');

    $pdf->ln(0.5);
    $pdf->SetFont("Arial","B",10);
    $pdf->Cell(0,0.4,"Detalhes: ",0,1,'l');
    $pdf->SetFont("Arial","",10);
    $pdf->MultiCell(19,0.4,$detalhes,0,'J');

    $pdf->Output("gestao_gabinete_protocolo_atendimento.pdf","I");
?>