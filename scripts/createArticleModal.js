let modalForm = $("#modal-form")
let new_article = $("#proto")
let title = new_article.find(".article__title")
let text = new_article.find(".article__text")
let articleImage = new_article.find(".article__img")
let enteredTitle = $("#newArticle_title")
let enteredText = $("#newArticle_text")
// Меняем заголовок статьи при изменении соответствующего input'а
const setTitle = () => title.text(enteredTitle.val())
// Меняем описание статьи при изменении соответствующего input'а
const setText = () => text.text(enteredText.val())

// Ассоциативный массив, в котором ключом является id названия типа создаваемой статьи,
// а значением - само название типа создаваемой статьи
let articlesType = {
    "excursionArticleType": "excursion",
    "standArticleType": "stand"
}
let articleTypeId = "excursionArticleType" // id html-названия типа создаваемой статьи
let articleType = articlesType[articleTypeId]; // Название типа создаваемой статьи
const setArticleType = selectedArticleTypeId => { // Изменение выбранного типа создаваемой статьи
    articleType = articlesType[selectedArticleTypeId]
    setArticleTypeStyles(selectedArticleTypeId)
}
const setArticleTypeStyles = (selectedArticleTypeId) => { // Корректировка стилей типов создаваемой статьи
    $(".articleType").each(function () {
       if($(this).prop("id") === selectedArticleTypeId) $(this).addClass("active")
       else $(this).removeClass("active")
    })
}

let imagePath = null // Путь к изображению в файловой структуре
// Файловый input для загрузки изображения
let inputImage = $("#newArticle_image")
// При изменении картинки
inputImage.on("change", () => {
    removeImage() // Удаляем картинку на случай, если она есть в файловой структуре
    let image = inputImage[0].files[0] // Получение картинки с input'а
    if(!image) return // Если картинка пуста, то ничего не делаем
    let data = new FormData() // Экземпляр класса FormData для его отправки по ajax
    data.append("image", image) // Загружаем в data изображение
    data.append("image_uploaded", 1) // Загружаем в data идентификатор наличия изображения
    $.ajax({
        url: './components/universal/createArticleModal/setImage.php',
        type: 'POST',
        data,
        dataType: 'json', // Устанавливаем тип получаемых данных (для автоматического парсинга json в js-объект)
        cache: false, // Выключаем кэширование (для IE 8 версии)
        processData: false, // Отключаем обработку передаваемых данных
        contentType: false, // Отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        success: (response) => {
            if(typeof response.error != 'undefined') { // Если замечена ошибка
                errorMessage(modalForm, response.error)
                inputImage.val(null) // Очистка input'а изображения
                return
            }
            imagePath = response.imagePath
            articleImage.prop("src", `./${imagePath}`)
        }
    })
})

const removeImage = () => { // Удаление картинки
    // Если путь к изображению в файловой структуре есть, то оно существует
    if(imagePath) {
        $.ajax({
            url: './components/universal/createArticleModal/deleteImage.php',
            type: 'POST',
            data: {
                imagePath
            },
            success: () => {
                imagePath = null // Сбрасываем значение пути к изображению
                inputImage.val(null) // Сбрасываем значение input'а изображения
                // Устанавливаем картинку по умолчанию
                articleImage.prop("src", "./assets/i/excursion/noPhoto_a.png")
            }
        })
    }
}

$(document).on('hidden.bs.modal',"#modal-form", function () {
    removeImage()
})

const getFormValues = () => { // Получение данных с формы
    if(!enteredTitle.val() || !enteredText.val()) { // Если поля не будут заполнены
        errorMessage(modalForm, "Please fill in all fields!")
        return false
    }
    if(enteredTitle.val().length >= 50 ) { // Если длина введенного заголовка будет больше 50
        errorMessage(modalForm, "Error: Title's length musnt be more than 50 symbols")
        return false
    }
    // Здесь должен быть показ ошибки при пустых полях
    let formData = {
        articleType,
        title: enteredTitle.val(),
        text: enteredText.val(),
    }
    // Если есть путь к картинке, то загружаем его в новый объект
    if(imagePath) formData = {...formData, imagePath}
    return formData
}

const createArticle = () => {
    let data = getFormValues() // Получение данных с формы
    if(!data) return // Если данные с формы получить не удалось, ничего не делаем
    $.ajax({
        url: './components/universal/createArticleModal/createArticle.php',
        type: 'POST',
        data,
        success: (response) => {
            if(response == 1) {
               // Чистка всех заполненных полей
               enteredTitle.val(null)
               enteredText.val(null)
               setTitle()
               setText()
               removeImage()
            }
            else {
                errorMessage(modalForm, "Error: something went wrong")
                removeImage()
            }
        }
    })
}

// Рисует над содержимым elem сообщение об ошибке, удаляет её через 5 секунд
const errorMessage = (elem, message) => {
    let newError = `
        <div class="alert alert-danger">
            ${message}
        </div>
    `
    elem.append(newError)
    setTimeout(() => {
        $(".alert-danger").remove()
    }, 5000)
}