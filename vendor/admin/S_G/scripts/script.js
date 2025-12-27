$(document).ready(function() {
    $('.addButton').click(function (e) { 
        // Получаем данные из полей формы
        var tr = $(this).parent().parent()
      var $selectedOptionAdd = $(tr).find('.selectStudentAdd option:selected');
      var selectStudentDelete = $(tr).find('.selectStudentDelete')
      var selectStudentAdd = $(tr).find('.selectStudentAdd').val()
      var idGroup = $(tr).find("input[type='hidden']").val()
      $.ajax({
        url: 'table_S_G_add_student.php',         
        method: 'post',            
        data: {
          id_group: idGroup,
          select_student_add: selectStudentAdd
        },     /* Данные передаваемые в массиве */
        success: function(data){ 
            $(`option[value=${selectStudentAdd}]`).each(function() {
                // Удаляем элемент option
                $(this).remove();
              });
              selectStudentDelete.prepend($selectedOptionAdd);
        }
    });

    });
    $('.delButton').click(function (e) { 
        // Получаем данные из полей формы
        var tr = $(this).parent().parent()
      var $selectStudentAdd= $(tr).find('.selectStudentAdd ');
      var selectedOptionDel = $(tr).find('.selectStudentDelete option:selected')
      var selectStudentDelete = $(tr).find('.selectStudentDelete').val();
      var idGroup = $(tr).find("input[type='hidden']").val();
      $.ajax({
        url: 'table_S_G_delete_student.php',         
        method: 'post',            
        data: {
          id_group: idGroup,
          select_student_delete: selectStudentDelete
        },     /* Данные передаваемые в массиве */
        success: function(data){ 
            $(`option[value=${selectStudentDelete}]`).each(function() {
                // Удаляем элемент option
                $(this).remove();
              }); /* функция которая будет выполнена после успешного запроса.  */
            $('.selectStudentAdd').prepend(selectedOptionDel);
        }
    });

    });
  });