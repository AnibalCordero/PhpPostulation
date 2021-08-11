const validLoginUser = () => {
    let submitBtn = document.querySelector("#loginSubmitBtn");
    submitBtn.className = 'btn btn-primary disabled';
    let rutInput = document.querySelector("#loginRut");
    let passInput = document.querySelector("#loginPass");
    let errMessage = document.querySelector("#loginErrMsg");
    rutInput.className = rutInput.value.trim() == ''?'form-control inputError':'form-control';
    passInput.className = passInput.value.trim() == ''? 'form-control inputError':'form-control';
    if(rutInput.value.trim() !=  '' && passInput.value.trim() != ''){
        if(rutValidation(rutInput.value.trim())){
            fetch('http://localhost/PhpPostulation/Controllers/userController.php', {
                method: 'POST',
                body:JSON.stringify({
                    'type': 'loginUser',
                    userData:{
                        'rut': rutInput.value.trim(),
                        'password': passInput.value.trim()
                    }
                }),
                headers:{
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }).then(response => response.json())
            .then(data =>{ 
                errMessage.innerHTML = '';
                if(data.success){
                    sessionStorage.setItem('userData', JSON.stringify(data.userData));
                    window.location.replace('./index.php');
                }else{
                    errMessage.innerHTML = data.message;
                    submitBtn.className = 'btn btn-primary';
                }
            });
        }else{
            errMessage.innerHTML = 'Ingresar un rut válido';
            submitBtn.className = 'btn btn-primary';
        }
    }else{
        errMessage.innerHTML = '';
        submitBtn.className = 'btn btn-primary';
    }

}

const rutValidation = (rut) => {
    let valueFormat = rut.split('.').join('');
    valueFormat = valueFormat.split('-').join('');
    const rBody = valueFormat.slice(0, -1);
    const dv = valueFormat.slice(-1).toLowerCase();
    const newFormat = `${rBody}-${dv}`;
    if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(newFormat)) {
        return false;
    }
    const value = valueFormat.replace('-', '');
    const rutBody = valueFormat.slice(0, -1);
    const vDigit = value.slice(-1).toLowerCase();
    if (rutBody.length < 7) {
        return false;
    }
    let T = rutBody;
    let M = 0;
    let S = 1;
    for (;T; T = Math.floor(T / 10)) {
        // eslint-disable-next-line
        S = (S + T % 10 * (9 - M++ % 6)) % 11; 
    }
    const newDigit = S ? S - 1 : 'k';
    // eslint-disable-next-line
    if (newDigit == vDigit) {
        return `${rutBody}-${vDigit}`;
    }
    return false;
};