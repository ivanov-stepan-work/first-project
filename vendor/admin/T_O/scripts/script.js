$(document).ready(function() {
    $('.addButton').click(function (e) { 
        // Получаем данные из полей формы
        var tr = $(this).parent().parent()
      var $selectedOptionAdd = $(tr).find('.selectObjectAdd option:selected');
      var selectObjectDel = $(tr).find('.selectObjectDel')
      var selectObjectAdd = $(tr).find('.selectObjectAdd').val()
      var idTeacher = $(tr).find("input[type='hidden']").val()
      $.ajax({
        url: 'table_T_O_add_object.php',         
        method: 'post',            
        data: {
          id_teacher: idTeacher,
          select_object_add: selectObjectAdd
        },     /* Данные передаваемые в массиве */
        success: function(data){ 
            $(selectObjectAdd).find('option:first').remove();
              selectObjectDel.prepend($selectedOptionAdd);
        }
    });

    });
    $('.delButton').click(function (e) { 
        // Получаем данные из полей формы
        var tr = $(this).parent().parent()
        var $selectedOptionDel = $(tr).find('.selectObjectDel option:selected');
        var selectObjectAdd = $(tr).find('.selectObjectAdd')
        var selectObjectDel = $(tr).find('.selectObjectDel').val()
        var idTeacher = $(tr).find("input[type='hidden']").val()
      $.ajax({
        url: 'table_T_O_delete_object.php',         
        method: 'post',            
        data: {
          id_teacher: idTeacher,
          select_object_delete: selectObjectDel
        },     /* Данные передаваемые в массиве */
        success: function(data){ 
            $(selectObjectDel).find(`option[value=${selectObjectDel}]`).each(function() {
                // Удаляем элемент option
                $(this).remove();
              }); /* функция которая будет выполнена после успешного запроса.  */
            selectObjectAdd.prepend($selectedOptionDel);
        }
    });

    });
  });