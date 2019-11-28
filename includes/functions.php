<?php
/**
Descrição: Funções utilizadas no sistema
*/

function escape($string){
    return htmlentities(trim($string), ENT_QUOTES, 'UTF-8');
}
function converteDataBR($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}
function converte_data($strData) {
	// Recebemos a data no formato: dd/mm/aaaa
	// Convertemos a data para o formato: aaaa-mm-dd
	if ( preg_match("#/#",$strData) == 1 ) {
		
		$strDataFinal = implode('-', array_reverse(explode('/',$strData)));
		
	}
	return $strDataFinal;
}

function login($user, $password, $mysqli) {
    // Usando definições pré-estabelecidas significa que a injeção de SQL (um tipo de ataque) não é possível. 
    if ($stmt = $mysqli->prepare("SELECT nom_usuario, nom_senha, salt, ind_status
        FROM login WHERE (ind_status = 'A' OR ind_status = 'N') AND nom_usuario = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $user);  // Relaciona  "$user" ao parâmetro.
        $stmt->execute();    // Executa a tarefa estabelecida.
        $stmt->store_result();
        
        // obtém variáveis a partir dos resultados. 
        $stmt->bind_result($db_username, $db_password, $salt, $ind_status);
        $stmt->fetch();
 
        // faz o hash da senha com um salt excusivo.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // o usuário exista,  
                       
                // Verifica se a senha confere com o que consta no banco de dados
                // a senha do usuário é enviada.
                if ($db_password == $password) {
                    
                    // A senha está correta!
                    // Obtém o string usuário-agente do usuário. 
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // proteção XSS conforme imprimimos este valor
                    
                    // proteção XSS conforme imprimimos este valor 
                    $db_username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $db_username);
                    $_SESSION['username'] = $db_username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    $_SESSION['ind_status'] = $ind_status;
                    // Login concluído com sucesso.
                    return true;
                    
                } else {
                    // A senha não está correta                    
                    return false;
                }
            
        } else {
            // Tal usuário não existe.
            return false;
        }
    }
}

function login_check($mysqli) {
    
    // Verifica se todas as variáveis das sessões foram definidas 
   if (isset($_SESSION['username'])) {
 
            if ( $_SESSION['ind_status'] == 'N' ){
                //usuário Novo (primeiro acesso)
                //acesso não liberado enquanto usuário não alterar senha
                return false;
            }
            else{
                return true;
            }        
        
    } else {
        // Não foi logado 
        return false;
        //echo 'não existe as variaveis de sessão';
    }
}

/*function login_check($mysqli) {
    
    // Verifica se todas as variáveis das sessões foram definidas 
   if (isset($_SESSION['username'], $_SESSION['login_string'])) {
 
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        
        //echo 'username:'.$username;
 
        // Pega a string do usuário.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT nom_senha, ind_status  
                                      FROM login 
                                      WHERE nom_usuario = ? LIMIT 1")) {
            // Atribui "$user_id" ao parâmetro. 
            $stmt->bind_param('s', $username);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Caso o usuário exista, pega variáveis a partir do resultado.
                $stmt->bind_result($password,$ind_status);                
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logado!!
                    if ( $ind_status == 'N' ){
                        //usuário Novo (primeiro acesso)
                        //acesso não liberado enquanto usuário não alterar senha
                        return false;
                    }
                    else{
                        return true;
                    }
                } else {
                    // Não foi logado 
                    return false;
                }
            } else {
                // Não foi logado 
                return false;
            }
        } else {
            // Não foi logado 
            return false;
        }
    } else {
        // Não foi logado 
        return false;
        //echo 'não existe as variaveis de sessão';
    }
}*/

?>