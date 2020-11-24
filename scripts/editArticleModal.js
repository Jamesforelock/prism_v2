var articleDom // Данные о DOM-структуре модального окна с редактированием статьи
var editedArticleType // Тип редактируемой статьи
var editedArticleImagePath = null // Путь к картинке редактируемой статьи

// Обработка события открытия модального окна
$(document).on('show.bs.modal',"#editArticleModal", function () {
    let modal = $("#editArticleModal") // Модальное окно
    let article = modal.find(".article") // Прототип редактируемой статьи
    articleDom = { // Инициалзиация данных о DOM-структуре модального окна
        modal, // Модальное окно
        article, // Прототип редактируемой статьи
        articleTitle: article.find(".article__title"), // Название прототипа ред. статьи
        articleText: article.find(".article__text"), // Текст прототипа ред. статьи
        articleImage: article.find(".article__img"), // Изображение прототипа ред. статьи
        enteredTitle: $("#editedArticle_title"), // Введенное пользователем новое название ред. статьи
        enteredText: $("#editedArticle_text"), // Введенное пользователем новый текст ред. статьи
        uploadedArticleImage: $("#editedArticle_image") // Загруженная пользователем новая картинка ред. статьи
    }
    // Получение типа статьи из названия папки, в которой хранится её изображение
    editedArticleType = articleDom.articleImage.prop("src").split("/")[6]
})

// Меняем заголовок статьи при изменении соответствующего input'а
const setEditedArticleEnteredTitle = () => {
    articleDom.articleTitle.text(articleDom.enteredTitle.val())
}
// Меняем описание статьи при изменении соответствующего input'а
const setEditedArticleEnteredText = () => {
    articleDom.articleText.text(articleDom.enteredText.val())
}

const changeImage = () => { // При изменении изображения
    let image = articleDom.uploadedArticleImage[0].files[0] // Получение файла изображения
    if(!image) return // Если файл не получен, то ничего не делать
    let data = new FormData() // Экземпляр класса FormData для его отправки по ajax
    data.append("image", image) // Загружаем в data изображение
    data.append("image_uploaded", 1) // Загружаем в data идентификатор наличия изображения
    $.ajax({
        url: './components/universal/editArticlesModal/setImage.php',
        type: 'POST',
        data,
        dataType: 'json', // Устанавливаем тип получаемых данных (для автоматического парсинга json в js-объект)
        cache: false, // Выключаем кэширование (для IE 8 версии)
        processData: false, // Отключаем обработку передаваемых данных
        contentType: false, // Отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        success: (response) => {
            if(typeof response.error != 'undefined') { // Если замечена ошибка
                errorMessage(articleDom.modal.find("#modal-form"), response.error)
                articleDom.uploadedArticleImage.val(null) // Очистка input'а изображения
                return
            }
            editedArticleImagePath = response.imagePath // Путь, в котором хранится загруженное изображение
            articleDom.articleImage.prop("src", `./${editedArticleImagePath}`) // Установка изображения прототипу ред. статьи
        }
    })
}

const restoreImage = () => { // Восстановление исходной картинки прототипа ред. статьи
    if(editedArticleImagePath) { // Если путь к картинке установлен, значит картинка была изменена (есть смысл в восстановлении)
            let articleId = articleDom.article.prop("id") // Получаем id прототипа статьи
            $.ajax({
                url: './components/universal/editArticlesModal/restoreImage.php',
                type: 'POST',
                data: {
                    imagePath: editedArticleImagePath,
                    articleType: editedArticleType,
                    articleId
                },
                success: (response) => {
                    if(response != "noPhoto") { // Если в ответе нет факта изначального отсутствия фото
                        let defaultImagePath = response // Получение изначального пути к картинке ред. изображения
                        editedArticleImagePath = null // Сбрасываем значение пути к изображению
                        articleDom.uploadedArticleImage.val(null) // Сбрасываем значение input'а изображения
                        // Устанавливаем картинку по умолчанию
                        articleDom.articleImage.prop("src", `./${defaultImagePath}`)
                    }
                }
            })
        }
}

// Если хотим удалить изображение ред. статьи
const removeEditedArticleImage = () => {
    if(editedArticleImagePath) { // Если путь к картинке установлен, значит картинка была изменена (есть смысл в удалении)
        $.ajax({
            url: './components/universal/editArticlesModal/deleteImage.php',
            type: 'POST',
            data: {
                imagePath: editedArticleImagePath
            },
            success: () => {
                // В дальнейшем при проверке на равенство пути "cleared" будет решаться вопрос удаления картинки из файловой структуры и её ссылка из БД
                editedArticleImagePath = "cleared"
                articleDom.uploadedArticleImage.val(null) // Сбрасываем значение input'а изображения
                // Устанавливаем картинку, предназначенную для случаев отсутствия заданной картинки ред. статьи
                articleDom.articleImage.prop("src", "./assets/i/excursion/noPhoto_a.png")
            }
        })
    }
    else { // Если путь к картинке не установлен, то лишь устанавливаем факт удаления для дальнейших скриптов, а также спец. картинку
        editedArticleImagePath = "cleared"
        articleDom.articleImage.prop("src", "./assets/i/excursion/noPhoto_a.png")
    }
}

// При скрытии модального окна
$(document).on('hidden.bs.modal',"#editArticleModal", function () {
    editedArticleImagePath = null // Сбрасываем значение пути к изображению
    editedArticleType = null // Сбрасываем тип редактируемой статьи
    articleDom.modal.remove() // Удаляем модальное окно из DOM
    articleDom = null // Очищаем DOM-данные модального окна
})

// Возвращает данные формы
const getEditedArticleFormData = () => {
    // Валидация
    if(!articleDom.enteredTitle.val() || !articleDom.enteredText.val()) {
        errorMessage(articleDom.modal.find("#modal-form"), "Please fill in all fields!")
        return false
    }
    if(articleDom.enteredTitle.val().length >= 50 ) { // Если длина введенного заголовка будет больше 50
        errorMessage(articleDom.modal.find("#modal-form"), "Error: Title's length musnt be more than 50 symbols")
        return false
    }

    let articleId = articleDom.article.prop("id") // Получение id
    let formData = { // Загрузка данных формы в объект
        id: articleId,
        type: editedArticleType,
        title: articleDom.enteredTitle.val(),
        text: articleDom.enteredText.val(),
    }
    // Если также есть путь к картинке, то его загружаем в форму тоже
    if(editedArticleImagePath) formData = {...formData, imagePath: editedArticleImagePath}
    return formData
}

// Загрузка данных формы на сервер
const uploadEditedArticleData = () => {
    let data = getEditedArticleFormData()
    if(!data) return
    $.ajax({
        url: './components/universal/editArticlesModal/editArticle.php',
        type: 'POST',
        data,
        success: (response) => {
            response = JSON.parse(response)
            if(response.code == 1) {
                // Получение разметки отредактированной статьи
                let renderedArticle = response.renderedArticle
                // Меняем статью до редактирования на отредактированную статью
                $("#editArticlesModal").find(`.article_edit.${data.type}#${data.id}`).replaceWith(renderedArticle)
                articleDom.modal.modal('hide') // Скрываем модальное окно
            }
            else {
                errorMessage(modalForm, "Error: something went wrong")
                restoreImage()
            }
        }
    })
}