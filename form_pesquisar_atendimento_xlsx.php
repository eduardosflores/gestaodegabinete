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
            ->setCellValue('B1', 'Pessoa' )
            ->setCellValue('C1', "Doc. Identificação" )
            ->setCellValue('D1', "Doc. Identificação" )
			
            ->setCellValue("E1", "Telefone" )
            ->setCellValue("F1", "Celular" )      

            ->setCellValue('G1', "Bairro" )
            ->setCellValue('H1', "Cidade" )
            ->setCellValue('I1', "Estado" )
            ->setCellValue('J1', "Tipo" )
            ->setCellValue("K1", "Situação" )

			->setCellValue("L1", "Detalhes" );    
			
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(false);
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(55);

$records=array();

if ($results = $mysqli->query($sql))
if ($results->num_rows){

while($row = $results->fetch_object()){
    $records[]=$row;
}
    $results->free_result();
}
$file="demo.xls";
$objPHPExcel->getActiveSheet()->setTitle('Relatório de Atendimentos');
$x=2;
foreach($records as $r)
{
    $dataat = str_replace("/", "-", $r->data);
    $data = date('d/m/Y', strtotime($dataat));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, $data);
    
    if($r->nom_apelido!=NULL){$nome=$r->nom_nome." \"".$r->nom_apelido."\"";}else {$nome=$r->nom_nome;};
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $x, $nome);

    $doc="";
    $doc2="";
    if($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ $doc2.=" RG:".$r->cod_rg; }
    if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ $doc.=" CPF:".$r->cod_cpf_cnpj; }
    if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ $doc.=" CNPJ:".$r->cod_cpf_cnpj; }
    if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ $doc2.=" IE:".$r->cod_ie; }
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, $doc);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, $doc2);
	
	
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
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, escape($num_ddd_tel)." ".escape($num_tel));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $x, escape($num_ddd_cel)." ".escape($num_cel));
	
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $x, $r->nom_bairro);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $x, $r->nom_cidade);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $x, $r->nom_estado);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $x, $r->tipo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $x, $r->status);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $x, $r->txt_detalhes);
    $x++;                           
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="gestao_gabinete_atendimento.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
?>