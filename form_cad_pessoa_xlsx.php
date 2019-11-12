<?php
include_once 'includes/conexao.php';
include_once 'includes/functions.php';
include  'xlxs/Classes/PHPExcel.php';
session_start();
$sql=$_SESSION['sql'];
$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nome' )
            ->setCellValue('B1', "Doc. Identificação" )
            ->setCellValue('C1', "Doc. Identificação" )
            ->setCellValue("D1", "Email" )
            ->setCellValue("E1", "Telefone" )
            ->setCellValue("F1", "Celular" );       
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(false);
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$records=array();

if ($results = $mysqli->query($sql))
if ($results->num_rows){

                            while($row = $results->fetch_object()){
                                $records[]=$row;
                            }
                            $results->free_result();
                        }
$file="demo.xls";
$objPHPExcel->getActiveSheet()->setTitle('Relatório de Pessoas');
$x=2;
foreach($records as $r)
{
    if($r->nom_apelido!=NULL){$nome=$r->nom_nome." \"".$r->nom_apelido."\"";}else {$nome=$r->nom_nome;};
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, $nome);

    $doc="";
    $doc2="";
    if($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ $doc2.=" RG:".$r->cod_rg; }
    if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ $doc.=" CPF:".$r->cod_cpf_cnpj; }
    if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ $doc.=" CNPJ:".$r->cod_cpf_cnpj; }
    if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ $doc2.=" IE:".$r->cod_ie; }
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $x, $doc);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, $doc2);
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, $r->nom_email);
    
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

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, $num_ddd_cel." ".$num_cel);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $x, $num_ddd_tel." ".$num_tel);
    $x++;                           
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="gestao_gabinete_pessoas.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
?>
