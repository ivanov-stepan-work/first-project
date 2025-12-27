window.addEventListener("beforeunload", function(event) {
    $.ajax({
        method: "POST",
        url: "signout.php",
      })
      .done(function( response ) {
        $("p.broken").html(response);
      });
});



// Функция для генерации случайного пароля
function generateRandomLengthPassword(minLength, maxLength) {
  const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+[]{}|;:,.<>?";
  const passwordLength = Math.floor(Math.random() * (maxLength - minLength + 1)) + minLength;
  let password = "";
  for (let i = 0; i < passwordLength; i++) {
      const randomIndex = Math.floor(Math.random() * charset.length);
      password += charset.charAt(randomIndex);
  }
  return password;
}

// Обработчик события контекстного меню (правая кнопка мыши)
document.getElementsByName("password").forEach((input) =>{
  input.addEventListener("contextmenu", function(event) {
      event.preventDefault(); // Предотвращаем отображение стандартного контекстного меню
      const password = generateRandomLengthPassword(8, 16); // Генерируем пароль от 8 до 16 символов
      event.target.value = password; // Устанавливаем сгенерированный пароль в поле ввода
  });
}) 