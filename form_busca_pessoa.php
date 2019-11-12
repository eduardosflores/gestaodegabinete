<?php
    require_once 'includes/conexao.php';
   
    if($_GET['type'] == 'pesquisa'){
            $result = mysqli_query($mysqli, "SELECT cod_pessoa, nom_nome FROM gab_pessoa WHERE nom_nome LIKE '".strtoupper($_GET['name_startsWith'])."%' AND ind_status='A'");	
            $data = array();
            while ($row = mysqli_fetch_array($result)) {
                    array_push($data, $row['nom_nome']);	
            }	
            echo json_encode($data);
    }
    
    if($_GET['type'] == 'country_table'){
	$row_num = $_GET['row_num'];   
	$result = mysqli_query($mysqli, "SELECT nom_nome, cod_pessoa, cod_cpf_cnpj, ind_pessoa, cod_rg, cod_ie FROM gab_pessoa WHERE nom_nome LIKE '".strtoupper($_GET['name_startsWith'])."%' AND ind_status='A'");
	$data = array();
	while ($row = mysqli_fetch_array($result)) {
		$name = $row['nom_nome'].'|'.$row['cod_cpf_cnpj'].'|'.$row['cod_pessoa'].'|'.$row['ind_pessoa'].'|'.$row['cod_rg'].'|'.$row['cod_ie'].'|'.$row_num;
		array_push($data, $name);	
	}	
	echo json_encode($data);
}
?>