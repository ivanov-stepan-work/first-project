$(document).ready(function () {
    $('#form_signin').submit(function (e) { 
        e.preventDefault();
        
        var form = $(this);

        var formData = $(this).serialize()
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'), 
                    data: formData,
                    success: function(response) {
                        if(response == '100') showErrorNotification('Неправильный логин или пароль')
                        else{
                            location.reload()
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        
                        console.log("Произошла ошибка: " + status + " - " + error);
                    }
                });

        });
        $('#togglePassword').click(function() {
            var passwordInput = $('#passwordInput');
            var eyeIcon = $('#eye-icon');
        
            if (passwordInput.attr('type') === 'password') {
              passwordInput.attr('type', 'text');
              eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
              passwordInput.attr('type', 'password');
              eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
          });
          $('#passwordInput').focus(function (e) { 
            e.preventDefault();
            $('.input-group').addClass('active')
          });

          $('#passwordInput').blur(function (e) { 
            e.preventDefault();
            $('.input-group').removeClass('active')
          });
    });