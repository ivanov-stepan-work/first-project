$(document).ready(function () {
  $(".formUpdate").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    var inputNumber = form[0][1];
    console.log(inputNumber);

    var formData = $(this).serialize();
    var verifyInsertion;
    $.ajax({
      type: "POST",
      url: "verify_insertion.php",
      data: formData,
      success: function (response) {
        response = Number(response);
        if (response) {
          $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            success: function (response) {
              showNotificationSuccess();
            },
            error: function (xhr, status, error) {
              console.log("Произошла ошибка: " + status + " - " + error);
            },
          });
        } else {
          $("#errorModal").modal("show");
          $(inputNumber).css("color", "red");
        }
      },
      error: function (xhr, status, error) {
        console.log("Произошла ошибка: " + status + " - " + error);
      },
    });
  });
  function checkWindowSize() {
    if ($(window).width() <= 768) {
      // Пример порогового значения для мобильных устройств
      $(".mobile-content").show();
      $(".desktop-content").hide();
    } else {
      $(".mobile-content").hide();
      $(".desktop-content").show();
    }
  }

  // Проверка размера экрана при загрузке страницы
  checkWindowSize();

  $(window).resize(function () {
    checkWindowSize();
  });
});
