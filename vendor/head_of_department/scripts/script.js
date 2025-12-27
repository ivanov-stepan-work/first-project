$(document).ready(function () {
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
  $(".formUpdate").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    var inputNumber = form[0][2];
    if (isNaN($(inputNumber).val())) {
      showErrorNotification("Вы ввели некоректное значение");
      $(inputNumber).css("color", "red");
      return;
    }
    var btn = $(form[0][4]);
    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "verify_insertion.php",
      data: formData,
      success: function (response) {
        response = Number(response);
        if (response) {
          btn.find(".spinnerBtn").css("display", "inline-block");
          $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            success: function (response) {
              btn.find(".spinnerBtn").css("display", "none");
              showSuccessNotification("Данные успешно обновлены");
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
  $(".numbers").on("change", function () {
    $(".numbers").css("color", "black");
  });
  $(".plus").click(function () {
    var inputGroup = $(this).closest(".input-group");
    var quantityInput = inputGroup.find(".quantity");
    var value = parseInt(quantityInput.val());
    if (quantityInput.val() == "") quantityInput.val(1);
    if (value < 100) {
      quantityInput.val(value + 1);
    }
  });

  $(".minus").click(function () {
    var inputGroup = $(this).closest(".input-group");
    var quantityInput = inputGroup.find(".quantity");
    var value = parseInt(quantityInput.val());
    if (quantityInput.val() == "") quantityInput.val(0);
    if (value > 0) {
      quantityInput.val(value - 1);
    }
  });
});
