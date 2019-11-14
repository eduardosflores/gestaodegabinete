INSTALAÇÃO E CONFIGURAÇÃO DO SOFTWARE "GESTÃO DE GABINETE"

*Desenvolvido pelo Serviço Tecnológico em Informática da Câmara Municipal de Bauru/SP em software livre e aberto.
*sob Licença Pública Geral GNU

Siga o passo-a-passo para instalação e configuração do software "Gestão de Gabinete".

Para  maiores  dúvidas  e/ou  esclarecimentos  sobre  o  sistema,  
favor  entrar  em contato  com  o Serviço  Tecnológico  em  Informática da Câmara  Municipal  de Bauru/SP. 

Email:tecnologia@bauru.sp.leg.br
Telefones:(14) 3235-0651 / (14) 3235-0652


- Baixar e instalar XAMPP no computador/servidor em que o software será hospedado
(https://www.apachefriends.org/pt_br/index.html).

Obs: O software "Gestão de Gabinete" está funcionando na versão atual do Xampp para Windows 64 bits 
(versão 7.3.3 - instalador compactado nesta pasta).
Pode ser que o software não seja totalmente compatível com versões do Xampp muito antigas.

- Após instalação, realizar as seguintes alterações nos arquivos de configuração:

*No arquivo \xampp\php\php.ini, utilizar:
file_uploads=On
upload_max_filesize=52M
post_max_size=55M

*No arquivo \xampp\mysql\bin\my.ini, utilizar:
max_allowed_packet = 3M
innodb_log_file_size = 10M


- Acessar a ferramenta phpMyAdmin e executar os scripts conforme sequência abaixo:
* \scripts\1-script-bd.sql
* \scripts\2-script-tables.sql
* \scripts\3-script-acesso-admin.sql
Obs: ANTES de executar, MODIFICAR os scripts conforme comentário escrito em cada um dos arquivos.


- Copiar a pasta gabinete e todo seu conteúdo descompactado dentro da pasta \xampp\htdocs 
(pasta htdocs do local onde o Xampp foi instalado).

-Será necessário definir os campos HOST, DATABASE, USER e PASSWORD (conforme executado no passo 2 (2-BD))
nos seguintes arquivos do projeto:
\gabinete\includes\conexao.php

OBS: este software utiliza webservice gratuito (https://viacep.com.br/) no cadastro de Pessoas
para consultar Códigos de Endereçamento Postal (CEP) do Brasil;