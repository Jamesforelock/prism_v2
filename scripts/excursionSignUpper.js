// Устанавливает значение стиля экскурсии
const setExcursionStyle = (excursionId, isAdded) => {
    let excursion = $(`#${excursionId}`) // Получение экскурсии по id
    let button = excursion.find(".article__btn") // Получение кнопки экскурсии
    if(isAdded) { // Если экскурсия стала добавленной
        // Установка соответствующих стилей
        excursion.addClass("article_added")
        button.removeClass("article__btn_add fa-plus")
        button.addClass("article__btn_delete fa-minus-circle")
        // Изменение поведения при нажатии кнопки на удаление экскурсии
        button.off("click")
        button.on("click", () => removeExcursion(excursionId))
    }
    else { // Если экскурсия стала удаленной
        // Установка соответсвующих стилей
        excursion.removeClass("article_added")
        button.removeClass("article__btn_delete fa-minus-circle")
        button.addClass("article__btn_add fa-plus")
        // Изменение поведения при нажатии кнопки на добавление экскурсии
        button.off("click")
        button.on("click", () => addExcursion(excursionId))
    }
}

// Производит ajax-запрос на добавление экскурсии посетителю
const addExcursion = (excursionId) => {
    $.ajax({ // Функция выполнения ajax-запроса (принимает объект со свойствами запроса в качестве параметра)
        type: 'POST', // Тип запроса
        url: './components/content/articles/excursionSignUpper.php?action=add', // Путь к php-скрипту
        data: { // Отсылаемые данные серверу
            excursionId // id экскурсии
        },
        success: response => response == 1 && setExcursionStyle(excursionId, true)
    })
}
// Производит ajax-запрос на удаление экскурсии посетителя
const removeExcursion = (excursionId) => {
    $.ajax({
        type: 'POST',
        url: './components/content/articles/excursionSignUpper.php?action=delete',
        data: {
            excursionId
        },
        success: response => response == 1 && setExcursionStyle(excursionId, false)
    })
}