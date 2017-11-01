function check() {
    if (document.getElementById('pass').value !== '' && document.getElementById('pass2').value !== '') {
        if (document.getElementById('pass').value == document.getElementById('pass2').value) {
            document.getElementById('passmsg').style.color = 'green';
            document.getElementById('passmsg').innerHTML = 'contraseñas coinciden';
        } else {
            document.getElementById('passmsg').style.color = 'red';
            document.getElementById('passmsg').innerHTML = 'contraseñas no coinciden';
        }
    } else {
        document.getElementById('passmsg').innerHTML = '';
    }
}

//para lo del password strength
function okPass(pass) {
    var pattern = /(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{8,})/g;
    return pattern.test(pass);
}
function goodPass(pass) {
    var pattern = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/g;
    return pattern.test(pass);
}
function greatPass(pass) {
    var pattern = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/g;
    return pattern.test(pass);
}

function strength() {

    var pass = $('#pass').val();
    var strength = "";
    var val = 0;
    if (pass.length < 8) {
        val = 0;
    }
    if (pass.length >= 8 && okPass(pass)) {
        strength = "weak-pass";
        val += 25;
    }
    if (okPass(pass)) {
        strength = "ok-pass";
        val += 25;
    }
    if (goodPass(pass)) {
        strength = "good-pass";
        val += 25;
    }
    val += pass.length;
    if (greatPass(pass)) {
        strength = "great-pass";
        val = 100;
    }

    $('#strength-meter').attr("class", "." + strength);
    $('#strength-meter').attr("value", val);
    $('#strength-meter').text(strength);
}