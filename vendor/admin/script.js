$(document).ready(function () {
document.querySelectorAll('input[name="middlename"]').forEach(input => {
    // функция слушатель события input
    input.addEventListener('change', (e) => {
        // находим ближайший родительский tr
        const row = e.target.closest('tr');

        // ищем необходимые нам поля по их именам
        const lastnameInput = row.querySelector('input[name="lastname"]');
        const firstnameInput = row.querySelector('input[name="firstname"]');

        // получаем значения из полей и берем нужные по задаче части
        const lastname = lastnameInput.value;
        const firstnameLetter = firstnameInput.value.slice(0,1);
        const middlenameLetter = e.target.value.slice(0,1);

        // ищем ячейку, в которую нужно вывести результат
        const loginForm = row.querySelector('input[name="login"]')

        if (lastname !== '' && firstnameInput.value.length > 0 && e.target.value.length > 0) {
            const login = `${lastname}${firstnameLetter}${middlenameLetter}`;
            loginForm.value = login;
        }
    });
}); 
$( "#printTeachers" ).click(function() {
    $.ajax({
        method: "POST",
        url: "check_add_teachers.php",
        success: function(data){ 
            if(data == 0){
        result = confirm('Не все преподаватели отнесены к кафедре. Они не будут отображены в документе.');
        if(result) window.open('output_teachers.php', '_blank');;
}
    else
    window.open('output_teachers.php', '_blank');
   }
      })
      .fail(function() {
        alert( "error" );
      });
  });
  $( "#printStudents" ).click(function() {
    $.ajax({
        method: "POST",
        url: "check_add_students.php",
        success: function(data){ 
            if(data == 0){
        result = confirm('Не все студенты отнесены к группе. Они не будут отображены в документе.');
        if(result) window.open('output_students.php', '_blank');
}
    else
    window.open('output_students.php', '_blank');
   }
      })
      .fail(function() {
        alert( "error" );
      });
  });
  $('.formUpdate').submit(function (e) { 
    e.preventDefault();
    
    var form = $(this);

    var formData = $(this).serialize()
    $.ajax({
        type: 'POST',
        url: form.attr('action'), 
        data: formData,
        success: function(response) {
            showSuccessNotification('Изменения успешно внесены')

        },
        error: function(xhr, status, error) {
            
            console.log("Произошла ошибка: " + status + " - " + error);
        }
    });
});
  $('.formAdd').submit(function (e) { 
    e.preventDefault();
    
    var form = $(this);

    var formData = $(this).serialize()
    $.ajax({
        type: 'POST',
        url: form.attr('action'), 
        data: formData,
        success: function(response) {
            if(response == '101') showErrorNotification('Студент с таким логином уже существует')
            else location.reload();
        },
        error: function(xhr, status, error) {
            console.log("Произошла ошибка: " + status + " - " + error);
        }
    });
});
});