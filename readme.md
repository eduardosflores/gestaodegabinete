# GESTÃO DE GABINETE

*Desenvolvido pelo **Serviço Tecnológico em Informática da Câmara Municipal de Bauru/SP em software livre e aberto**, sob Licença Pública Geral GNU*

*Para conhecer o software, acesse a **versão demonstrativa**: https://intranet.bauru.sp.leg.br/gabdemo/.* 

Siga o passo-a-passo abaixo para instalação e configuração do software "Gestão de Gabinete".


## INSTALAÇÃO E CONFIGURAÇÃO:

1. Baixe e instale XAMPP no computador/servidor em que o software será hospedado
(https://www.apachefriends.org/pt_br/index.html).

    *Obs.: O software **Gestão de Gabinete** está funcionando na versão 7.3.3 do Xampp para Windows 64 bits. Pode apresentar problemas de compatibilidade com versões muito antigas.*

2. Após instalação, realize as seguintes alterações nos arquivos de configuração:
    - No arquivo `\xampp\php\php.ini`, utilizar:
    
        ```
        file_uploads=On
        upload_max_filesize=52M
        post_max_size=55M
        ```
        
        Neste mesmo arquivo (`\xampp\php\php.ini`), definir o fuso horário da sua região, como no exemplo abaixo:
         ```
        date.timezone=America/Sao_Paulo
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

5. Modifique os campos `HOST`, `DATABASE`, `USER` e `PASSWORD` no seguinte arquivo do projeto: `\gabinete\includes\conexao.php`, conforme definido no item 4.i (`\scripts\1-script-bd.sql`).

6. Realize login no sistema utilizando usuário criado no item 4.iii (*user:admin / senha:admin*)  
**IMPORTANTE:** Após logon, altere senha do Administrador pelo sistema.


## OBSERVAÇÕES:

-Este software utiliza **webservice gratuito (https://viacep.com.br/)** no cadastro de Pessoas para consultar Códigos de Endereçamento Postal (CEP) do Brasil.

-A Agenda utilizada no software exibe eventos do **Google Agenda**. Para utilizá-la, é necessário cadastrar as Chaves do Google Agenda.

Para mais detalhes sobre as funcionalidades do software, consulte o **Manual do Usuário**.

Para  dúvidas  e/ou  esclarecimentos, entre  em **contato**  com  o Serviço  Tecnológico  em  Informática da Câmara  Municipal  de Bauru/SP. 

>**Email**: tecnologia@bauru.sp.leg.br  
>**Portal Legislativo**: https://www.bauru.sp.leg.br
