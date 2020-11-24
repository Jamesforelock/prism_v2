var setAssistantsModalData // Объект для храния DOM-объекта модального окна, а также для id стенда

$(document).on('show.bs.modal','div[id^="setAssistantsModal"]', function () {
    let modal = $('div[id^="setAssistantsModal"]') // Модальное окно установки ассистентов
    setAssistantsModalData = { // Загрузка данных в объект
        modal, // Модальное окно
        standId: modal.prop('id').split('_')[1] // Полчение ID стенда из ID модального окна
    }
    // Получение списка ассистентов
    $.ajax({
        url: './components/universal/setAssistantsModal/assistantList.php',
        data: {
            standId: setAssistantsModalData.standId
        },
        type: 'POST',
        success: (response) => {
            let renderedAssistants = response // Разметка ассистентов
            // Вставка полученной разметки в модальное окно
            setAssistantsModalData.modal.find(".modal-body").append(renderedAssistants)
        }
    })
})


// Устанавливает стендиста на стенд (или снимает его со стенда)
const toggleAssistantAjax = (assistantId, toggleType) => {
    $.ajax({
        url: `./components/universal/setAssistantsModal/assistantToggler.php`,
        type: 'POST',
        data: {
            assistantId,
            standId: setAssistantsModalData.standId,
            toggleType
        },
        success: response => response != 1 && alert("Sorry, but this assistant hasn't been (un)set")
    })
}

// По нажатию на checkbox вызывает установку (или снятие) стендиста на стенд
const toggleAssistant = (checkbox, assistantId) => {
    $(checkbox).is(':checked') ?
        toggleAssistantAjax(assistantId, "SET")
        :
        toggleAssistantAjax(assistantId, "UNSET")
}

// При закрытии модального окна
$(document).on('hidden.bs.modal','div[id^="setAssistantsModal"]', function () {
    setAssistantsModalData.modal.remove() // Удаляем модальное окно из DOM
    setAssistantsModalData = null // Очистка данных
})