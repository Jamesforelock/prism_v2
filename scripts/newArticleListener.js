// Контейнер со статьями
let articlesContainer = $(".articles")
// Последняя по актуальности статья (самая верхняя на странице)
let lastArticle = $(".article").first()
// Получение id последней статьи
let lastArticleId = lastArticle.prop("id")
const listenNewArticle = (articlesType) => {
    $.ajax({ // long-polling запрос на проверку новых статей в БД
        url: "./components/content/articles/newArticlePusher.php",
        type: "POST",
        cache: false,
        data: {
            lastArticleId: lastArticleId,
            articlesType
        },
        timeout: 10000, // если новых данных не будет, запрос прервется через 10 секунд и запуститься заного
        async: true, // запрос должен быть асинхронным, чтобы не было проблем с заморозкой страницы
        success: (response) => {
            response = JSON.parse(response) // Преобразование json-ответа в js-объект
            // Исчезновение контейнера
            articlesContainer.fadeOut(500)
            // Добавление новой статьи в начало контейнера
            articlesContainer.prepend(response.html)
            // Появление контейнера
            articlesContainer.fadeIn(500)
            // Теперь последняя статья = новой статье
            lastArticle = $(".article").first()
            // Получение id новой статьи
            lastArticleId = lastArticle.prop("id")
            // Повторный вызов прослушки новой статьи
            listenNewArticle(articlesType)
        },
        error: () => { // На случай, если запрос прервется (по истечению времени или по другим причинам)
            // Повторный вызов прослушки новой статьи
            listenNewArticle(articlesType)
        }
    })
}