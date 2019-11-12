<?php
include_once 'includes/conexao.php';
include_once 'includes/functions.php';
include  'xlxs/Classes/PHPExcel.php';
session_start();
$sql=$_SESSION['sql'];
$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Data' )
            ->setCellValue('B1', "Número/Ano" )
            ->setCellValue('C1', "Tipo" )
            ->setCellValue('D1', "Situação" )
            ->setCellValue('E1', "Unidade" )
            ->setCellValue("F1", "Atendimento" )      
            ->setCellValue("G1", "Resposta" );      
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(false);
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(130);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
$records=array();

if ($results = $mysqli->query($sql))
if ($results->num_rows){

while($row = $results->fetch_object()){
    $records[]=$row;
}
    $results->free_result();
}
$file="demo.xls";
$objPHPExcel->getActiveSheet()->setTitle('Relatório de Documentos');
$x=2;
foreach($records as $r)
{
    $cod_documento=$r->cod_documento; 
    $dat_documento=converteDataBR($r->dat_documento);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, $dat_documento);
    $nom_doc_data=$r->nom_documento."/".$r->dat_ano;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $x, $nom_doc_data);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, $r->nom_tip_doc);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, $r->nom_status);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, $r->nom_uni_doc);
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
                 if($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_rg)){ $doc.=" RG:".$linha_atend->cod_rg; }
                 if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.=" CPF:".$linha_atend->cod_cpf_cnpj; }
                 if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.=" CNPJ:".$linha_atend->cod_cpf_cnpj; }
                 if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_ie)){ $doc.=" IE:".$linha_atend->cod_ie; }
                 
                
                 
             }
         }
     }
     if( $cod_atendimento != null && $dados==1){
         $dat_atendimento=converteDataBR($linha_atend->dat_atendimento);
         $nom_nome=$linha_atend->nom_nome;
         $nom_tipo=$linha_atend->nom_tipo;
         $nom_status=$linha_atend->nom_status;
         
         $atendimento="Data: $dat_atendimento  \nPessoa: $nom_nome \nDoc. Identificação: $doc \nTipo: $nom_tipo \nSituação:$nom_status";
     }else{
         $dat_atendimento="";
         $nom_nome="";
         $nom_tipo="";
         $nom_status="";
         
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
        
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $x, $atendimento);
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $x, $dat_resposta);    
    
    $x++;                           
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="gestao_gabinete_documento.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
?>
