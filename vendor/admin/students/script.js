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
        const loginCell = row.querySelector('.login input[type=text]');
        const loginForm = row.querySelector('input[name="login"]')

        if (lastname !== '' && firstnameInput.value.length > 0 && e.target.value.length > 0) {
            const login = `${lastname}${firstnameLetter}${middlenameLetter}`;
            loginCell.textContent = login;
            loginForm.value = login;
        }
    });
    $(window).click(function (e) { 
        showErrorNotification('Вы нажали')
        
    });
}); 
