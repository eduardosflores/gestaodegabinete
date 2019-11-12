function validaData(campo)
{
    /******** VALIDA DATA NO FORMATO DD/MM/AAAA *******/

    var regExpCaracter = /[^\d]/;     //Expressão regular para procurar caracter não-numérico.
    var regExpEspaco = /^\s+|\s+$/g;  //Expressão regular para retirar espaços em branco.
    if (campo.value!="")
    {

        if(campo.value.length != 10)
        {
            if(campo.value.length != 8){
                alert('Data fora do padrão DD/MM/AAAA');
                campo.value = "";
                campo.focus();
                return false;
            }
            else{//está sem as barras
                //acréscimo das barras (dd/mm/aaaa) no campo 
                campo.value=campo.value.substring(0, 2)+"/"+campo.value.substring(2, 4)+"/"+campo.value.substring(4, 8);
            }
        }

        splitData = campo.value.split('/');

        if(splitData.length != 3)
        {
            alert('Data fora do padrão DD/MM/AAAA');
            campo.value = "";
            campo.focus();
            return false;
        }

        /* Retira os espaços em branco do início e fim de cada string. */
        splitData[0] = splitData[0].replace(regExpEspaco, '');
        splitData[1] = splitData[1].replace(regExpEspaco, '');
        splitData[2] = splitData[2].replace(regExpEspaco, '');

        if ((splitData[0].length != 2) || (splitData[1].length != 2) || (splitData[2].length != 4))
        {
            alert('Data fora do padrão DD/MM/AAAA');
             campo.value = "";
             campo.focus();
            return false;
        }

        /* Procura por caracter não-numérico. EX.: o "x" em "28/09/2x11" */
        if (regExpCaracter.test(splitData[0]) || regExpCaracter.test(splitData[1]) || regExpCaracter.test(splitData[2]))
        {
            alert('Caracter inválido encontrado!');
            campo.value = "";
            campo.focus();
            return false;
        }

        dia = parseInt(splitData[0],10);
        mes = parseInt(splitData[1],10)-1; //O JavaScript representa o mês de 0 a 11 (0->janeiro, 1->fevereiro... 11->dezembro)
        ano = parseInt(splitData[2],10);

        var novaData = new Date(ano, mes, dia);

        /* O JavaScript aceita criar datas com, por exemplo, mês=14, porém a cada 12 meses mais um ano é acrescentado à data
             final e o restante representa o mês. O mesmo ocorre para os dias, sendo maior que o número de dias do mês em
             questão o JavaScript o converterá para meses/anos.
             Por exemplo, a data 28/14/2011 (que seria o comando "new Date(2011,13,28)", pois o mês é representado de 0 a 11)
             o JavaScript converterá para 28/02/2012.
             Dessa forma, se o dia, mês ou ano da data resultante do comando "new Date()" for diferente do dia, mês e ano da
             data que está sendo testada esta data é inválida. */
        if ((novaData.getDate() != dia) || (novaData.getMonth() != mes) || (novaData.getFullYear() != ano))
        {
            alert('Data Inválida!');
            campo.value = "";
             campo.focus();
            return false;
        }
        else
        {
            return true;
        }
    }
}

$( function() {
    $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
     });
} );



function validarCPF(cpf){

   var filtro = /\d{3}.\d{3}.\d{3}-\d{2}/;
   if(!filtro.test(cpf.value))
   {
           //window.alert("CPF inválido. Tente novamente.");
           document.form.cpf.value="";
           return false;
   } else document.getElementById('message').innerHTML = '';

   cpf2 = remove(cpf.value, ".");
   cpf2 = remove(cpf2, "-");


   if(cpf2.length != 11 || cpf2 == "00000000000" || cpf2 == "11111111111" ||
           cpf2 == "22222222222" || cpf2 == "33333333333" || cpf2 == "44444444444" ||
           cpf2 == "55555555555" || cpf2 == "66666666666" || cpf2 == "77777777777" ||
           cpf2 == "88888888888" || cpf2 == "99999999999")
   {
        document.getElementById('message').innerHTML = 'CPF inválido.';
           //window.alert("CPF inválido. Tente novamente.");
           document.form.cpf.value="";
           return false;
   } else document.getElementById('message').innerHTML = '';

   soma = 0;
   for(i = 0; i < 9; i++)
   {
           soma += parseInt(cpf.charAt(i)) * (10 - i);
   }

   resto = 11 - (soma % 11);
   if(resto == 10 || resto == 11)
   {
           resto = 0;
   }
   if(resto != parseInt(cpf.charAt(9))){
        document.getElementById('message').innerHTML = 'CPF inválido.';
           //window.alert("CPF inválido. Tente novamente.");
           document.form.cpf.value="";
           return false;
   } else document.getElementById('message').innerHTML = '';

   soma = 0;
   for(i = 0; i < 10; i ++)
   {
           soma += parseInt(cpf.charAt(i)) * (11 - i);
   }
   resto = 11 - (soma % 11);
   if(resto == 10 || resto == 11)
   {
           resto = 0;
   }

   if(resto != parseInt(cpf.charAt(10))){
        document.getElementById('message').innerHTML = 'CPF inválido.';
           //window.alert("CPF inválido. Tente novamente.");
           document.form.cpf.value="";
           return false;
   } else document.getElementById('message').innerHTML = '';
   return true;
}

function remove(str, sub) {
        i = str.indexOf(sub);
        r = "";
        if (i == -1) return str;
        {
                r += str.substring(0,i) + remove(str.substring(i + sub.length), sub);
        }

        return r;
}

/**
   * MASCARA ( mascara(o,f) e execmascara() ) CRIADAS POR ELCIO LUIZ
   * elcio.com.br
   */
function mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
}

function execmascara(){
        v_obj.value=v_fun(v_obj.value)
}

function cpf_mask(v){
        v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
        v=v.replace(/(\d{3})(\d)/,"$1.$2")    //Coloca ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")    //Coloca ponto entre o setimo e o oitava dígitos
        v=v.replace(/(\d{3})(\d)/,"$1-$2")   //Coloca ponto entre o decimoprimeiro e o decimosegundo dígitos
        return v
}

function ValidaCep(cep){
   exp = /\d{5}\-\d{3}/
   if(!exp.test(cep.value))
    {
        alert('Numero de Cep Invalido!');
        document.form.cep.value="";
    }
}

function mascara_cep(t, mask){
    var i = t.value.length;
    var saida = mask.substring(1,0);
    var texto = mask.substring(i)
    if (texto.substring(0,1) != saida){
        t.value += texto.substring(0,1);
    }
}

$(document).ready(function(){
   $('#num_cep').mask('99999-999');
});

$(document).ready(function(){
   $('#cnpj').mask('99.999.999/9999-99');
});
