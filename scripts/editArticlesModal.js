const searchBox = $("#searchBox") // Поисковая строка
const modalEditArticles = $("#modalEditArticles") // Модальное окно поиска статей
searchBox.on("keyup", () => { // При вводе символа в поисковую строку
    if(searchBox.val()) { // Если в поисковой строке введено какое-либо значение
        $.ajax({
            url: './components/universal/editArticlesModal/findArticles.php',
            method: "POST",
            data: {
                searchText: searchBox.val()
            },
            success: response => {
                response = JSON.parse(response)
                modalEditArticles.empty(); // Очистка модального окна
                if(response.excursions) { // Если найдены экскурсии
                    // Загрузка экскурсий в модальное окно
                    modalEditArticles.append('<h4 style="margin: 10px">Excursions</h4>')
                    modalEditArticles.append(response.excursions)
                }
                if(response.stands) { // Если найдены стенды
                    // Загрузка стендов в модальное окно
                    modalEditArticles.append('<h4 style="margin: 10px">Stands</h4>')
                    modalEditArticles.append(response.stands)
                }
            }
        })
    }
})

// Вызывает модальное окно (для непрерывного его вызова необходимо указать его будущий id в DOM-структуре)
const getEditModalWindow = (data, url, modalWindowId) => {
    $.ajax({
        url,
        method: 'POST',
        data,
        success: response => {
            $("body").append(response)
            $(`#${modalWindowId}`).modal("show")
        }
    })
}

// Вызывает модальное окно для редактирования статьи
const editArticle = (id, type) => {
    // Ajax => Разметка с модальным окном редактирования
    getEditModalWindow({articleId: id, articleType: type},
        './components/universal/editArticlesModal/editArticleModalConnector.php',
        "editArticleModal")
}

// Удаляет статью
const deleteArticle = (id, type) => {
    $.ajax({
        url: './components/universal/editArticlesModal/deleteArticle.php',
        method: "POST",
        data: {
            articleId: id,
            articleType: type
        },
        success: response => response == 1 && modalEditArticles.find(`#${id}.${type}`).remove()
    })
}

// Вызывает модальное окно для установки стендистов на стенд
const setAssistants = (standId) => {
    getEditModalWindow({standId},
        './components/universal/setAssistantsModal/setAssistantsModalConnector.php',
        `setAssistantsModal_${standId}`)
}