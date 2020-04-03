userNavToggle()
function userNavToggle() {
    let userNavImg = document.getElementById('user-nav-btn');
    userNavImg.addEventListener('click', function() {
        let elem = document.getElementById('user-nav-menu');
        let isActive = elem.classList.contains('active');
        if (isActive) {
            elem.classList.remove('active');
        } else {
            elem.classList.add('active');
        }
    });
}


problemSuccessBar();
function problemSuccessBar() {
    let elems = document.getElementsByClassName('problem-success-bar');
    for (let i = 0; i < elems.length; i++) {
        let elem = elems[i].firstChild;
        let percentage = elem.getAttribute('data-percentage');
        elem.style.width = percentage + '%';
    }
}


hideToast();
function hideToast() {
    let elem = document.querySelector('.toast span');
    elem.addEventListener('click', function() {
        document.querySelector('.toast').style.display = 'none';
    });
}


function adminTab(elemID) {
    let tabNavElems = document.getElementsByClassName('tab-nav');
    let tabContentElems = document.getElementsByClassName('tab-content');

    for(let i = 0; i < tabNavElems.length; i++) {
        tabNavElems[i].classList.remove('active');
    }

    for(let i = 0; i < tabContentElems.length; i++) {
        tabContentElems[i].classList.remove('active');
    }

    let tabNav = document.getElementById(elemID);
    let tabContent = document.getElementById(tabNav.getAttribute('data-tab'));
    tabNav.classList.add('active');
    tabContent.classList.add('active');

}


function addProblemValidation() {
    let problemTitle = document.forms['add-problem-form']['ap-prob-title'].value;
    let problemStatement = document.forms['add-problem-form']['ap-prob-statement'].value;
    let inputFormat = document.forms['add-problem-form']['ap-input-format'].value;
    let outputFormat = document.forms['add-problem-form']['ap-output-format'].value;
    let sampleInput = document.forms['add-problem-form']['ap-sample-input'].value;
    let sampleOutput = document.forms['add-problem-form']['ap-sample-output'].value;
    let problemInput = document.forms['add-problem-form']['ap-prob-input'].value;
    let problemOutput = document.forms['add-problem-form']['ap-prob-output'].value;

    let ptFlag = false, psFlag = false, ifFlag = false, ofFlag = false, siFlag = false, soFlag = false, piFlag = false, poFlag = false;

    if (problemTitle == '') {
        let elem = document.getElementById('ap-prob-title-error');
        elem.classList.add('active');
        elem.innerHTML = 'Problem Title cannot be empty';
    } else {
        let elem = document.getElementById('ap-prob-title-error');
        elem.classList.remove('active');
        ptFlag = true;
    }

    if (problemStatement == '') {
        let elem = document.getElementById('ap-prob-statement-error');
        elem.classList.add('active');
        elem.innerHTML = 'Problem Statement cannot be empty';
    } else {
        let elem = document.getElementById('ap-prob-statement-error');
        elem.classList.remove('active');
        psFlag = true;
    }

    if (inputFormat == '') {
        let elem = document.getElementById('ap-input-format-error');
        elem.classList.add('active');
        elem.innerHTML = 'Input Format cannot be empty';
    } else {
        let elem = document.getElementById('ap-input-format-error');
        elem.classList.remove('active');
        ifFlag = true;
    }

    if (outputFormat == '') {
        let elem = document.getElementById('ap-output-format-error');
        elem.classList.add('active');
        elem.innerHTML = 'Output Format cannot be empty';
    } else {
        let elem = document.getElementById('ap-output-format-error');
        elem.classList.remove('active');
        ofFlag = true;
    }

    if (sampleInput == '') {
        let elem = document.getElementById('ap-sample-input-error');
        elem.classList.add('active');
        elem.innerHTML = 'Sample Input cannot be empty';
    } else {
        let elem = document.getElementById('ap-sample-input-error');
        elem.classList.remove('active');
        siFlag = true;
    }

    if (sampleOutput == '') {
        let elem = document.getElementById('ap-sample-output-error');
        elem.classList.add('active');
        elem.innerHTML = 'Sample Output cannot be empty';
    } else {
        let elem = document.getElementById('ap-sample-output-error');
        elem.classList.remove('active');
        soFlag = true;
    }

    if (problemInput == '') {
        let elem = document.getElementById('ap-prob-input-error');
        elem.classList.add('active');
        elem.innerHTML = 'Problem Input cannot be empty';
    } else {
        let elem = document.getElementById('ap-prob-input-error');
        elem.classList.remove('active');
        piFlag = true;
    }

    if (problemOutput == '') {
        let elem = document.getElementById('ap-prob-output-error');
        elem.classList.add('active');
        elem.innerHTML = 'Problem Input cannot be empty';
    } else {
        let elem = document.getElementById('ap-prob-output-error');
        elem.classList.remove('active');
        poFlag = true;
    }

    if (ptFlag && psFlag && ifFlag && ofFlag && siFlag && soFlag && piFlag && poFlag)
        return true;
    else
        return false;
}


function registerUserValidation() {
    let rName = document.getElementById('r-name');
    let rEmail = document.getElementById('r-email');
    let rPassword = document.getElementById('r-password');
    let rCPassword = document.getElementById('r-cpassword');

    let nameFlag = false, emailFlag = false, passwordFlag = false, cPasswordFlag = false;

    if (rName.value == '') {
        let elem = document.getElementById('r-name-error');
        elem.classList.add('active');
        elem.innerHTML = 'Name cannot be empty';
    } else if (rFullname.value.length < 3) {
        let elem = document.getElementById('r-name-error');
        elem.classList.add('active');
        elem.innerHTML = 'Name is too small';
    } else if ((/[!@#$%^&*(),.?":{}|<>0-9]/g).test(rFullname.value)) {
        let elem = document.getElementById('r-name-error');
        elem.classList.add('active');
        elem.innerHTML = 'Name cannot contain invalid characters';
    } else {
        let elem = document.getElementById('r-name-error');
        elem.classList.remove('active');
        nameFlag = true;
    }

    if (rEmail.value == '') {
        let elem = document.getElementById('r-email-error');
        elem.classList.add('active');
        elem.innerHTML = 'Email address cannot be empty';
    } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/).test(rEmail.value)) {
        let elem = document.getElementById('r-email-error');
        elem.classList.add('active');
        elem.innerHTML = 'Please, enter a valid email address';
    } else {
        let elem = document.getElementById('r-email-error');
        elem.classList.remove('active');
        emailFlag = true;
    }

    if (rPassword.value == '') {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password cannot be empty';
    } else if (rPassword.value.length < 8) {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password must be at lest 8 character long';
    } else if (!(/[a-z]/g).test(rPassword.value)) {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password must contain at leset one lowercase letters';
    } else if (!(/[A-Z]/g).test(rPassword.value)) {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password must contain at leset one uppercase letters';
    } else if (!(/[0-9]/g).test(rPassword.value)) {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password must contain at leset one number';
    } else if (!(/[!@#$%^&*(),.?":{}|<>\/]/g).test(rPassword.value)) {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password must contain at leset one special character';
    } else if ((/[\s]/g).test(rPassword.value)) {
        let elem = document.getElementById('r-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password cannot contain spaces';
    } else {
        let elem = document.getElementById('r-password-error');
        elem.classList.remove('active');
        passwordFlag = true;
    }

    if (rCPassword.value != rPassword.value) {
        let elem = document.getElementById('r-cpassword-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password did not match';
    } else {
        let elem = document.getElementById('r-cpassword-error');
        elem.classList.remove('active');
        cPasswordFlag = true;
    }

    if (nameFlag && emailFlag && passwordFlag && cPasswordFlag) {
        document.querySelector('.status-message').classList.add('active');
        document.querySelector('.status-message').innerHTML('Please wait');
        return true;
    }
    else {
        return false;
    }

}


function loginUserValidation() {
    let lEmail = document.forms['login-user-form']['l-email'].value;
    let lPassword = document.forms['login-user-form']['l-password'].value;

    let emailFlag = false, passwordFlag = false;

    if (lEmail == '') {
        let elem = document.getElementById('l-email-error');
        elem.classList.add('active');
        elem.innerHTML = 'Email address cannot be empty';
    } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/).test(rEmail.value)) {
        let elem = document.getElementById('l-email-error');
        elem.classList.add('active');
        elem.innerHTML = 'Please, enter a valid email address';
    } else {
        let elem = document.getElementById('l-email-error');
        elem.classList.remove('active');
        emailFlag = true;
    }

    if (lPassword == '') {
        let elem = document.getElementById('l-password-error');
        elem.classList.add('active');
        elem.innerHTML = 'Password cannot be empty';
    } else {
        let elem = document.getElementById('l-password-error');
        elem.classList.remove('active');
        passwordFlag = true;
    }

    if (emailFlag && passwordFlag)
        return true;
    else
        return false;

}


function psMessageValidation() {
    let psMessage = document.forms['ps-request-form']['ps-message'].value;

    let msgFlag = false;

    if (psMessage == '') {
        let elem = document.getElementById('ps-message-error');
        elem.classList.add('active');
        elem.innerHTML = 'Message cannot be empty';
    } else if (psMessage.length < 100) {
        let elem = document.getElementById('ps-message-error');
        elem.classList.add('active');
        elem.innerHTML = 'Message must be at least 100 character long';
    } else {
        let elem = document.getElementById('l-password-error');
        elem.classList.remove('active');
        msgFlag = true;
    }

    if (msgFlag)
        return true;
    else
        return false;

}
