function formhash(form, password) {
    
    if (form.nome.value != '' && form.senha.value != ''){
    
        // Crie um novo elemento de input, o qual será o campo para a senha com hash. 
        var p = document.createElement("input");

        // Adicione um novo elemento ao nosso formulário. 
        form.appendChild(p);
        p.name = "p";
        p.type = "hidden";
        p.value = hex_sha512(password.value);

        // Finalmente, envie o formulário. 
        form.submit();
    }
}
 
function regformhash(form, usuario, password, conf) {
     // Confira se cada campo tem um valor    
    if (usuario.value == '' || password.value == ''  || conf.value == '') {
 
        alert('Favor preencher nome de usuário e senhas.');
        return false;
    }
 
    // Verifique o nome de usuário
    re = /^\w+$/; 
    if(!re.test(usuario.value)) { 
        alert("Nome de usuário deve conter apenas letras, números e underlines."); 
        form.usuario.focus();
        return false; 
    }
 
    /*// Confira se a senha é comprida o suficiente (no mínimo, 6 caracteres)
    // A verificação é duplicada abaixo, mas o cuidado extra é para dar mais 
    // orientações específicas ao usuário
    if (password.value.length < 6) {
        alert('Senhas devem conter pelo menos 6 caracteres.');
        form.password.focus();
        return false;
    }
 
    // Pelo menos um número, uma letra minúscula e outra maiúscula 
    // Pelo menos 6 caracteres 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Senhas devem conter pelo menos 1 número, 1 letra minúscula e 1 letra maiúscula.');
        return false;
    }*/
 
    // Verificar se a senha e a confirmação são as mesmas
    if (password.value != conf.value) {
        alert('Senhas não coincidem. Tente de novo.');
        form.password.focus();
        return false;
    }
 
    // Crie um novo elemento de input, o qual será o campo para a senha com hash. 
    var p = document.createElement("input");
 
    // Adicione o novo elemento ao nosso formulário. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Cuidado para não deixar que a senha em texto simples não seja enviada. 
    password.value = "";
    conf.value = "";
 
    // Finalizando, envie o formulário.  
    form.submit();
    return true;
}