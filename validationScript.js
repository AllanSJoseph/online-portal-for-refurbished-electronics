// "use strict"
console.log("Validation Script is loaded...")

//Adding All Fields
const nameField = document.getElementById('name');
const emailField = document.getElementById('email');
const mobField = document.getElementById('mob');
const addressField = document.getElementById('address');
const passField = document.getElementById('password');
const confPassField = document.getElementById('confpassword');
const submission = document.getElementById('submit_btn');

//Regular Expressions
var lowerCase = /[a-z]/g;
var upperCase = /[A-Z]/g;
var number = /[0-9]/g;
var specialChar = /[!@#$%^&*(),.?":{}|<>]/g;

//Validating whether all fields are present runs on form submission
function validate(){
    let name = nameField.value;
    let email = emailField.value;
    let mob = mobField.value;
    let address = addressField.value;
    let password = passField.value;
    let confpassword = confPassField.value;

    if (name === '' || email === '' || mob === '' || address === '' || password === '' || confpassword === '') {
        alert('Please fill in all fields.');
        return false;
    }

    if (password !== confpassword) {
        alert('Passwords do not match.');
        return false;
    }

    return true;
}

function validatePassword(password){
    if (password === ''){
        return 1;                  //Invalid Password
    }else if(password.length <= 8){
        return 1;                 //Invalid Password
    }else{
        let err = 0;
        let password = passField.value;
        if(!password.match(lowerCase) || !password.match(upperCase) || !password.match(number) || !password.match(specialChar)){
          return 1;       //Invalid Password
        }else{
            return 0;   //Valid Password
        }
    }
}

mobField.onkeyup = () => {
    let mobBlock = document.getElementById('mobHelpBlock');

    if (mobField.value != '' && mobField.value.length === 10){
        mobBlock.classList.add('valid');
        mobBlock.classList.remove('invalid');
        mobBlock.innerHTML = "<b>Your Mobile Number is Valid!</b>";
    }else{
        mobBlock.classList.add('invalid');
        mobBlock.classList.remove('valid');
        mobBlock.innerHTML = "<b>Invalid Mobile Number! (Must Contain 10 digits)</b>";
    }
}

passField.onkeyup = () => {
    let passBlock = document.getElementById('passwordHelpBlock');
    const errText = "Your password must be <b>atleast 8 characters</b> long, contain <b>Uppercase and LowerCase Letters, Numbers, and Special Characters</b>.";

    let err = validatePassword(passField.value);
    if (err){
        passBlock.innerHTML = errText;
        passBlock.classList.add('invalid');
        passBlock.classList.remove('valid');
    }else{
        passBlock.classList.add('valid');
        passBlock.classList.remove('invalid');
        passBlock.innerHTML = "<b>Your Password is Valid</b>";
    }
}

confPassField.onkeyup = () => {
    let confPassBlock = document.getElementById('confPassHelpBlock');
    
    let password = passField.value;
    let confpassword = confPassField.value;

    if (password !== confpassword) {
        confPassBlock.classList.add('invalid');
        confPassBlock.classList.remove('valid');
        confPassBlock.innerHTML = "<b>Passwords do not match!</b>";
    }else{
        confPassBlock.classList.add('valid');
        confPassBlock.classList.remove('invalid');
        confPassBlock.innerHTML = "<b>Passwords match!</b>";
    }

}