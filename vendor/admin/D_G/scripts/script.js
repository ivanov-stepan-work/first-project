$(document).ready(function () {
  $(".addButton").click(function (e) {
    // Получаем данные из полей формы
    var tr = $(this).parent().parent();
    var $selectedOptionAdd = $(tr).find(".selectGroupAdd option:selected");
    var selectGroupDel = $(tr).find(".selectGroupDel");
    var selectGroupAdd = $(tr).find(".selectGroupAdd").val();
    var idDepartment = $(tr).find("input[type='hidden']").val();
    $.ajax({
      url: "table_D_G_add_group.php",
      method: "post",
      data: {
        id_department: idDepartment,
        select_group_add: selectGroupAdd,
      } /* Данные передаваемые в массиве */,
      success: function (data) {
        console.log(selectGroupAdd);
        $(`option[value=${selectGroupAdd}]`).each(function () {
          // Удаляем элемент option
          $(this).remove();
        });
        selectGroupDel.prepend($selectedOptionAdd);
      },
    });
  });
  $(".delButton").click(function (e) {
    // Получаем данные из полей формы
    var tr = $(this).parent().parent();
    var $selectGroupAdd = $(tr).find(".selectGroupAdd ");
    var selectedOptionDel = $(tr).find(".selectGroupDel option:selected");
    var selectGroupDel = $(tr).find(".selectGroupDel").val();
    var idDepartment = $(tr).find("input[type='hidden']").val();
    $.ajax({
      url: "table_D_G_delete_group.php",
      method: "post",
      data: {
        select_group_delete: selectGroupDel,
      } /* Данные передаваемые в массиве */,
      success: function (data) {
        $(`option[value=${selectGroupDel}]`).each(function () {
          // Удаляем элемент option
          $(this).remove();
        }); /* функция которая будет выполнена после успешного запроса.  */
        $(".selectGroupAdd").prepend(selectedOptionDel);
      },
    });
  });
});
