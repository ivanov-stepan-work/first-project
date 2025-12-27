$(document).ready(function () {
  $(".selectsStudents").change(function () {
    $(this)
      .parent()
      .parent()
      .parent()
      .find("h2")
      .find(".headAccordion")
      .text($(this).find("option:selected").text());
  });

  $(".desktop-content").hide();
  $(".mobile-content").hide();
  var screenWidth = $(window).width();
  if (screenWidth < 1024) {
    $("body").addClass("mobile-content");
    $(".desktop-content").hide();
    $(".mobile-content").show();
  } else {
    $(".desktop-content").show();
    $(".mobile-content").hide();
  }
  $(".spinnerBtn").css("display", "none");
  $("#addTxtArea").blur(function () {
    $(this).removeClass("red-border");
  });
  $("#addSelect").change(function () {
    $(this).removeClass("red-border");
  });
  $(".formAdd").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    var inputNumber = form[0][1];
    if (form[0][2].value === "") {
      showErrorNotification("Заполните тему перед добавлением!");
      $("#addTxtArea").addClass("red-border");
    } else {
      var formData = $(this).serialize();
      var verifyInsertion;
      $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: formData,
        success: function (response) {
          if (response == "101") {
            $("#addSelect").addClass("red-border");
            showErrorNotification("У выбранного студента уже назначен проект");
          } else location.reload();
        },
        error: function (xhr, status, error) {
          console.log("Произошла ошибка: " + status + " - " + error);
        },
      });
    }
  });
  $(".formUpdate").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    if ($("body").hasClass("mobile-content")) {
      var selectStudent = $(form[0][3]);
      var btn = $(form[0][7]);
    } else {
      var selectStudent = $(form[0][2]);
      var btn = $(form[0][6]);
    }
    var formData = $(this).serialize();
    $(document).css("cursor", "progress");
    btn.find(".spinnerBtn").css("display", "inline-block");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: formData,
      success: function (response) {
        btn.find(".spinnerBtn").css("display", "none");
        $(this).css("cursor", "auto");
        if (response == "102") {
          showErrorNotification(
            "Изменения не сохранены. Тема должна быть заполнена."
          );
        }
        showSuccessNotification("Изменения успешно внесены");
      },
      error: function (xhr, status, error) {
        $(this).css("cursor", "auto");
        console.log("Произошла ошибка: " + status + " - " + error);
      },
    });
  });
  $(".formDel").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = $(this).serialize();
    if (!confirm("Вы уверены что хотите удалить проект?")) return;
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: formData,
      success: function (response) {
        location.reload();
      },
      error: function (xhr, status, error) {
        $(this).css("cursor", "auto");
        console.log("Произошла ошибка: " + status + " - " + error);
      },
    });
  });
});
