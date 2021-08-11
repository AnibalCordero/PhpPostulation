window.onload = () => {
    validateUserSession();
};

const validateUserSession = () => {
    let userSession = JSON.parse(sessionStorage.getItem('userData'));
    fetch('http://localhost/PhpPostulation/Controllers/userController.php', {
        method: 'POST',
        body:JSON.stringify({
            'type': 'validateUser',
            'userData': userSession,
        }),
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data =>{ 
        if(data == null || !data.success){
            window.location.replace('./login.php');
        }else{
            selectMenuView(data.userData);
            document.querySelector(".menuButon").click();
        }
    });
}

const logOut = () => {
    sessionStorage.removeItem('userData');
    validateUserSession();
}

const selectMenuView = (userData) => {
    let menuContainer = document.querySelector('#appMenu');
    menuContainer.innerHTML = userData.menuView;
    let menuName = document.querySelector('#menuUserName');
    menuName.innerHTML = `${userData.firstname} ${userData.pSurname}`;
}

const selectMenu = (menuType) => {
    fetch('http://localhost/PhpPostulation/Controllers/profileController.php', {
        method: 'POST',
        body:JSON.stringify({
            'type': 'menuRouter',
            'menuType': menuType,
        }),
        headers:{
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data =>{ 
       document.querySelector('#appOutlet').innerHTML = data;
       switch (menuType) {
           case 'adminUser':
               getAllUsersList();
               break;
       }
    });
}