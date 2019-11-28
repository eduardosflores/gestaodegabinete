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
    $pdf->SetFont("Arial","BU",15);
    $pdf->Cell(0,0.6,"Gestão de Gabinete - Relatório de Documentos",0,1,'C');
    //$pdf->Ln(0.3);
    //$pdf->Cell(0,0,"",1);
    $pdf->Ln(0.5);
    ///////////////CABEÇALHO DA TABELA /////////////////////
    $pdf->SetFont("Arial","B",9);
    $pdf->Cell(1.8,0.8,"Data",1,0,'C');
    $pdf->Cell(2,0.8,"Número/Ano",1,0,'C');
    $pdf->Cell(2,0.8,"Tipo",1,0,'C');
    $pdf->Cell(2,0.8,"Situação",1,0,'C');
    $pdf->Cell(2,0.8,"Unidade",1,0,'C');
    $pdf->Cell(5.2,0.8,"Atendimento",1,0,'C');
    $pdf->Cell(4,0.8,"Resposta",1,1,'C');
    ////////////////DADOS DA TABELA ///////////////////////
    $pdf->SetFont("Arial","",8);
    $pdf->SetWidths(array(1.8,2,2,2,2,5.2,4));//CADA VALOR DESTE ARRAY SERÁ A LARGURA DE CADA COLUNA
    
    foreach($records as $r){
        $cod_documento=$r->cod_documento; 
        $nom_doc_data=$r->nom_documento."/".$r->dat_ano;
       /* if($dataat!=NULL){ 
            $auxdat = str_replace('/', '-', $dataat);
            $data = date('d/m/Y', strtotime($auxdat));
        }*/
        $dat_documento=converteDataBR($r->dat_documento);
        $nom_tip_doc = $r->nom_tip_doc;
        $nom_status = $r->nom_status;
        $nom_uni_doc = $r->nom_uni_doc;

        //atendimento
        $cod_atendimento=$r->cod_atendimento;
        if( $cod_atendimento != null){ 
            $dados=0;
            if ($resultado=$mysqli->query("SELECT gab_atendimento.cod_atendimento, gab_atendimento.dat_atendimento, gab_atendimento.txt_detalhes detalhes,"
            . "gab_pessoa.nom_nome, gab_pessoa.ind_pessoa, gab_pessoa.cod_cpf_cnpj, gab_pessoa.cod_ie, gab_pessoa.cod_rg,"
            . "gab_tipo_atendimento.nom_tipo, "
            . "gab_status_atendimento.nom_status nom_status "
            . "FROM gab_atendimento "
            . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
            . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
            . "LEFT JOIN gab_status_atendimento ON gab_status_atendimento.cod_status = gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status "
            . "WHERE cod_atendimento=$cod_atendimento")){

                if ($resultado->num_rows){
                    $dados=1;
                    $linha_atend=$resultado->fetch_object();
                    
                    $doc="";
                    
                    if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_cpf_cnpj) && !empty($linha_atend->cod_rg)){ 
                        $doc="CPF:".$linha_atend->cod_cpf_cnpj; 
                        $doc.="\nRG:".$linha_atend->cod_rg;
                    }
                    else if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_cpf_cnpj)){
                        $doc="CPF:".$linha_atend->cod_cpf_cnpj; 
                    }
                    else if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_rg)){
                        $doc.="RG:".$linha_atend->cod_rg;
                    }

                    if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_cpf_cnpj) && !empty($linha_atend->cod_ie)){ 
                        $doc.="CNPJ:".$linha_atend->cod_cpf_cnpj; 
                        $doc.="\nIE:".$linha_atend->cod_ie;
                    }           
                    else if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_cpf_cnpj)){ 
                        $doc.="CNPJ:".$linha_atend->cod_cpf_cnpj; 
                    }
                    else if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_ie)){ 
                        $doc.="IE:".$linha_atend->cod_ie; 
                    }
                    
                }
            }
        }
        if( $cod_atendimento != null && $dados==1){
            $dat_atendimento=converteDataBR($linha_atend->dat_atendimento);
            $nom_nome=$linha_atend->nom_nome;
            $nom_tipo=$linha_atend->nom_tipo;
            $nom_status2=$linha_atend->nom_status;
            
            $atendimento="$dat_atendimento \n$nom_nome \n$doc \nTipo: $nom_tipo \nSituação:$nom_status2";
            
        }else{
            $dat_atendimento="";
            $nom_nome="";
            $nom_tipo="";
            $nom_status2="";
            
            $atendimento=NULL;
        }

        //resposta
        if ($r->dat_resposta!=NULL){
            $data = str_replace("/", "-", $r->dat_resposta);
            $dat_resposta = date('d/m/Y', strtotime($data));
            if(!empty($r->lnk_documento)){
                $lnk_documento=$r->lnk_documento;
            }else{
                $lnk_documento="";
            }
           $dat_resposta="Data: $dat_resposta";
        }
        else{
           $dat_resposta=NULL;
        }

        $pdf->Row(array($dat_documento,$nom_doc_data,$nom_tip_doc,$nom_status,$nom_uni_doc,$atendimento,$dat_resposta));
    }
    $pdf->Ln(1);
    $pdf->SetFont("Arial","",10);
    $pdf->Cell(0,0.8,"Total de registros: ".$num,0,1,'C');
    $pdf->Output("gestao_gabinete_documento.pdf","I");
?>