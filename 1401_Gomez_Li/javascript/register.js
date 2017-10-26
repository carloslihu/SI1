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