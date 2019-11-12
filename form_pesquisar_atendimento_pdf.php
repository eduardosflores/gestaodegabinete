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
    ///////////////DEFINIÇÃO DO DOCUMENTO PDF/////////////////////
    $pdf = new PDF("P","cm","A4");
	$pdf->setConnection($mysqli);
    $pdf->SetLeftMargin(1);
    $pdf->SetRightMargin(1);
    $pdf->AddPage();
    $pdf->Ln(0.5);
    $pdf->SetFont("Arial","B",15);
    $pdf->Cell(0,0.6,"Relatório de Atendimentos - Gestão de Gabinete",0,1,'C');
    $pdf->Ln(0.3);
    $pdf->Cell(0,0,"",1);
    $pdf->Ln(0.5);
    ///////////////CABEÇALHO DA TABELA /////////////////////
    $pdf->SetFont("Arial","B",9);
    $pdf->Cell(1.7,1,"Data",1,0,'C');
    $pdf->Cell(5.8,1,"Pessoa",1,0,'C');
	$pdf->Cell(2.5,1,"Telefone(s)",1,0,'C');
    $pdf->Cell(4.5,1,"Localização",1,0,'C');
    $pdf->Cell(2.5,1,"Tipo",1,0,'C');
    $pdf->Cell(2.5,1,"Situação",1,1,'C');
    ////////////////DADOS DA TABELA ///////////////////////
    $pdf->SetFont("Arial","",8);
    
    foreach($records as $r){
        
		$pdf->SetWidths(array(1.7,5.8,2.5,4.5,2.5,2.5));//CADA VALOR DESTE ARRAY SERÁ A LARGURA DE CADA COLUNA
        $pdf->SetAligns(['r','L','L','L','L','L']);
		// $pdf->SetAligns(['R','R','R','R','R','R']);
		
        $codigo=$r->cod_atendimento;
        
        if($r->nom_apelido!=NULL){$nome=$r->nom_nome." \"".$r->nom_apelido."\"";}else {$nome=$r->nom_nome;};
        
        $doc="";
        $rgie="";
        if($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ $rgie.="\n RG:".$r->cod_rg; }
        if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ $doc.="\n CPF:".$r->cod_cpf_cnpj; }
        if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ $doc.="\n CNPJ:".$r->cod_cpf_cnpj; }
        if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ $rgie.="\n IE:".$r->cod_ie; }
        
		$pessoa= $nome.$doc.$rgie;
		
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
		
		$contato = escape($num_ddd_tel)." ".escape($num_tel)."\n".escape($num_ddd_cel)." ".escape($num_cel);
	
        $bairro=$r->nom_bairro; 
        $cidade=$r->nom_cidade; 
        $estado=$r->nom_estado; 
		
		$local= $bairro."\n".$cidade."/".$estado;
		
        $dataat=$r->data;
        if($dataat!=NULL){ 
            $auxdat = str_replace('/', '-', $dataat);
            $data = date('d/m/Y', strtotime($auxdat));
        }
        $tipo = $r->tipo;
        $status = $r->status;
        
        $pdf->Row(array($data,$pessoa,$contato,$local,$tipo,$status));
	
		$pdf->SetWidths([1.7,17.8]); //ALTERA LARGURA DAS COLUNAS PARA ESCREVER DETALHES DO ATENDIMENTO
		$pdf->SetAligns(['C','L']);
		$pdf->Row(["Detalhes:",$r->txt_detalhes]);
		$pdf->Ln(0.3);
    }
    $pdf->Ln(1);
    $pdf->SetFont("Arial","",10);
    $pdf->Cell(0,0.8,"Total de registros: ".$num,0,1,'C');
    $pdf->Output("gestao_gabinete_atendimento.pdf","I");
?>