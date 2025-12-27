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
$(".reportCurator").click(function () {
  // window.location.href = "output_curator.php";
  window.open('output_curator.php');
});

// Проверка размера экрана при загрузке страницы
checkWindowSize();

$(window).resize(function () {
  checkWindowSize();
});
