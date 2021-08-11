const getAllProfiles = () => {
    fetch('http://localhost/PhpPostulation/Controllers/profileController.php', {
        method: 'POST',
        body:JSON.stringify({
            'type':'getAllProfiles',
        }),
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data =>{ 
        let optionsTemplate = ``;
        Object.keys(data).forEach((key)=>{
            let profileData = data[key];
            optionsTemplate += `<option value="${profileData.id}">${profileData.name}</option>`;
        });
        let userProfileSelect = document.querySelector("#userProfileSelect");
        userProfileSelect.innerHTML = optionsTemplate;
    });
}

const getAllUsersList = () => {
    fetch('http://localhost/PhpPostulation/Controllers/userController.php', {
        method: 'POST',
        body:JSON.stringify({
            'type':'getAllUsersList',
        }),
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data =>{
        let userListHtml = ``;
        Object.keys(data).forEach((key)=>{
            let user = data[key];
            userListHtml+=`
                <div class="row userRow" id="userRow_${user.id}">
                    <div class="col">
                        ${user.firstname} ${user.secondname != null?user.secondname:''} ${user.pSurname} ${user.mSurname != null?user.mSurname:''}
                    </div>
                    <div class="col">
                        ${user.rut}
                    </div>
                    <div class="col">
                        <div class="btn btn-sm btn-primary ${user.id==1?'disabled':''}" onclick="openEditUser(${user.id})" title="editar usuario"><i class="fas fa-user-edit"></i></div>
                        <div class="btn btn-sm btn-danger ${user.id==1?'disabled':''}" onclick="deleteUser(${user.id})" title="eliminar usuario"><i class="fas fa-user-times"></i></div>
                    </div>
                </div>
            `;
        });
        document.querySelector("#usersListContainer").innerHTML = userListHtml;
    });
}

const openNewUserForm = (userId = null,edit = false) => {
    fetch('http://localhost/PhpPostulation/Controllers/userController.php', {
        method: 'POST',
        body:JSON.stringify({
            'type':'getNewUserForm',
            'userId': userId
        }),
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data =>{
        document.querySelector("#appOutlet").innerHTML = data.html;
        getAllProfiles();
        if(edit){ 
            document.querySelector("#createUserTitle").innerHTML = 'Editar usuario';
            document.querySelector('#userInputRut').value = `${data.userData.rutNumber}-${data.userData.rutDigit}`;
            document.querySelector('#userInputFirstname').value = data.userData.firstname;
            document.querySelector('#userInputSecondname').value = data.userData.secondname;
            document.querySelector('#userInputPSurname').value = data.userData.pSurname;
            document.querySelector('#userInputMSurname').value = data.userData.mSurname;
            document.querySelector('#userInputBirthdate').value = data.userData.birthdate;
            document.querySelector('#userInputEmail').value = data.userData.email;
            document.querySelector('#userProfileSelect').selectedIndex = data.userData.profileId;
            document.querySelector("#userFormBtn").innerHTML = 'Editar usuario';
            document.querySelector("#userFormBtn").setAttribute('onclick', `validateNewUser(${userId})`);
        }
    });
}

const validateNewUser = (userId = null) =>{
    let userInputRut = document.querySelector('#userInputRut');
    let userInputFirstName = document.querySelector('#userInputFirstname');
    let userInputSecondname = document.querySelector('#userInputSecondname');
    let userInputPSurname = document.querySelector('#userInputPSurname');
    let userInputMSurname = document.querySelector('#userInputMSurname');
    let userInputBirthdate = document.querySelector('#userInputBirthdate');
    let userInputEmail = document.querySelector('#userInputEmail');
    let userProfileSelect = document.querySelector('#userProfileSelect');
    let errMessage = document.querySelector("#userFormErrMsg");
    errMessage.innerHTML = '';
    userInputRut.value.trim() == ''?userInputRut.className='form-control inputError':userInputRut.className='form-control';
    userInputFirstName.value.trim() == ''?userInputFirstName.className='form-control inputError':userInputFirstName.className='form-control';
    userInputPSurname.value.trim() == ''?userInputPSurname.className='form-control inputError':userInputPSurname.className='form-control';
    userInputBirthdate.value.trim() == ''?userInputBirthdate.className='form-control inputError':userInputBirthdate.className='form-control';
    userInputEmail.value.trim() == ''?userInputEmail.className='form-control inputError':userInputEmail.className='form-control';
    userProfileSelect.value.trim() == ''?userProfileSelect.className='form-select inputError':userProfileSelect.className='form-select';
    if(userInputRut.value.trim() != '' && userInputFirstName.value.trim() != '' &&  userInputPSurname.value.trim() != '' && userInputBirthdate.value.trim() != '' && userInputEmail.value.trim() != '' && userProfileSelect.value.trim() != ''){
        if(rutValidation(userInputRut.value.trim()) && emailValidation(userInputEmail.value.trim())){
            userData = {
                id: userId,
                rut: userInputRut.value.trim(),
                firstname: userInputFirstName.value.trim(),
                secondname: userInputSecondname.value.trim(),
                pSurname: userInputPSurname.value.trim(),
                mSurname: userInputMSurname.value.trim(),
                birthdate: userInputBirthdate.value.trim(),
                email: userInputEmail.value.trim(),
                userProfileId: userProfileSelect.value.trim()
            };
            fetch('http://localhost/PhpPostulation/Controllers/userController.php', {
                method: 'POST',
                body:JSON.stringify({
                    'type':userId == null?'createNewUser':'editUser',
                    'userData': userData,
                }),
                headers:{
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data =>{
                if(data.success){
                    selectMenu('adminUser');
                }else{
                    errMessage.innerHTML = data.mesage;
                }
            });
        }else{  
            !rutValidation(userInputRut.value.trim())?userInputRut.className='form-control inputError':userInputRut.className='form-control';
            !emailValidation(userInputEmail.value.trim())?userInputEmail.className='form-control inputError':userInputEmail.className='form-control';
            let errMsg = '';
            if(!rutValidation(userInputRut.value.trim()) && !emailValidation(userInputEmail.value.trim())){
                errMsg = 'Rut y Email no válidos';
            }else if(!rutValidation(userInputRut.value.trim())){
                errMsg = 'Rut no válido';
            }else{
                errMsg = 'Email no válido';
            }
            errMessage.innerHTML = errMsg;
        }
    }
}

const openEditUser = (userId) => {
    openNewUserForm(userId, true);
}

const deleteUser = (userId) => {
    fetch('http://localhost/PhpPostulation/Controllers/userController.php', {
        method: 'POST',
        body:JSON.stringify({
            'type': 'deleteUser',
            'userId': userId,
        }),
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data =>{
        if(data.success){
            selectMenu('adminUser');
        }else{
            console.log(data.message);
        }
    });
}

const emailValidation = (email) => {
    if (/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(email)) {
        return true;
    }
    return false;
};

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