$(document).ready(function() {
    $('.addButton').click(function (e) { 
        // Получаем данные из полей формы
        var tr = $(this).parent().parent()
      var $selectedOptionAdd = $(tr).find('.selectTeacherAdd option:selected');
      var selectTeacherDel = $(tr).find('.selectTeacherDel')
      var selectTeacherAdd = $(tr).find('.selectTeacherAdd').val()
      var idDepartment = $(tr).find("input[type='hidden']").val()
      $.ajax({
        url: 'table_D_T_add_teacher.php',         
        method: 'post',            
        data: {
            id_department: idDepartment,
            select_teacher_add: selectTeacherAdd
        },     /* Данные передаваемые в массиве */
        success: function(data){ 
            console.log(selectTeacherAdd);
            $(`option[value=${selectTeacherAdd}]`).each(function() {
                // Удаляем элемент option
                $(this).remove();
              });
            selectTeacherDel.prepend($selectedOptionAdd);
        }
    });

    });
    $('.delButton').click(function (e) { 
        // Получаем данные из полей формы
        var tr = $(this).parent().parent()
      var $selectTeacherAdd= $(tr).find('.selectTeacherAdd ');
      var selectedOptionDel = $(tr).find('.selectTeacherDel option:selected')
      var selectTeacherDel = $(tr).find('.selectTeacherDel').val();
      var idDepartment = $(tr).find("input[type='hidden']").val();
      $.ajax({
        url: 'table_D_T_delete_teacher.php',         
        method: 'post',            
        data: {
            id_department: idDepartment,
            select_teacher_delete: selectTeacherDel
        },     /* Данные передаваемые в массиве */
        success: function(data){ 
            $(`option[value=${selectTeacherDel}]`).each(function() {
                // Удаляем элемент option
                $(this).remove();
              }); /* функция которая будет выполнена после успешного запроса.  */
            $('.selectTeacherAdd').prepend(selectedOptionDel);
        }
    });

    });
  });