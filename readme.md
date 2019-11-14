# GESTÃO DE GABINETE

*Desenvolvido pelo Serviço Tecnológico em Informática da Câmara Municipal de Bauru/SP em software livre e aberto.
sob Licença Pública Geral GNU*

Siga o passo-a-passo para instalação e configuração do software "Gestão de Gabinete".

Para  maiores  dúvidas  e/ou  esclarecimentos  sobre  o  sistema,  
favor  entrar  em contato  com  o Serviço  Tecnológico  em  Informática da Câmara  Municipal  de Bauru/SP. 

>Email: tecnologia@bauru.sp.leg.br  
>Portal Legislativo: https://www.bauru.sp.leg.br

## INSTALAÇÃO E CONFIGURAÇÃO:

1. Baixe e instale XAMPP no computador/servidor em que o software será hospedado
(https://www.apachefriends.org/pt_br/index.html).

    *Obs.: O software **Gestão de Gabinete** está funcionando na versão 7.3.3 do Xampp para Windows 64 bits  
    (instalador compactado nesta pasta). Podendo apresentar problemas de compatibilidade com versões anteriores.*

2. Após instalação, realize as seguintes alterações nos arquivos de configuração:
    - No arquivo `\xampp\php\php.ini`, utilizar:
    
        ```
        file_uploads=On
        upload_max_filesize=52M
        post_max_size=55M
        ```
    - No arquivo `\xampp\mysql\bin\my.ini`, utilizar:
    
        ```
        max_allowed_packet = 3M
        innodb_log_file_size = 10M
        ```
3. Crie a pasta do sistema (utilizamos `\gabinete\`) dentro do diretório `\xampp\htdocs\` e transfira o código fonte para lá.

4. Acesse a ferramenta phpMyAdmin e execute os scripts conforme sequência abaixo:
    1. `\scripts\1-script-bd.sql`
    2. `\scripts\2-script-tables.sql`
    3. `\scripts\3-script-acesso-admin.sql`
  
    *Obs.: **Antes** de executar, **modificar** os scripts conforme comentário escrito em cada um dos arquivos.*

5. Defina os campos `HOST`, `DATABASE`, `USER` e `PASSWORD` conforme executado no  
item 4.i (`\scripts\1-script-bd.sql`) no seguinte arquivo do projeto: `\gabinete\includes\conexao.php`.

6. Realize login no sistema utilizando usuário criado no item 4.iii (user:admin/senha:admin)  
**IMPORTANTE:** Após logon, altere senha do Administrador pelo sistema.

*Obs.: este software utiliza webservice gratuito (https://viacep.com.br/) no cadastro de Pessoas
para consultar Códigos de Endereçamento Postal (CEP) do Brasil.*

*A Agenda utilizada no software exibe eventos do Google Agenda. Para utilizá-la, é necessário cadastrar as Chaves do Google Agenda.*

*Mais detalhes do software estão contidos no Manual do Usuário.*
