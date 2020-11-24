const formWrapper = $('.formWrapper').first() // Выбор блока
let i = 2 // Переменная-счетчик
setInterval(() => { // Установка интервала (первый аргумент - функция, второй - миллисекунды)
    formWrapper.css('backgroundImage', `url(../assets/i/auth/0${i}.jpg)`)  // Смена фона
    i++ // Увеличение счетчика
    if (i == 4) i = 1 // Если счетчик == 4, начать сначала
}, 7000)