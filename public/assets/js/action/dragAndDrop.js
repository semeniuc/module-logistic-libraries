const excelFileInput = document.getElementById('excelFile');
const fileDropArea = document.getElementById('fileDropArea');
const submitBtn = document.getElementById('submitBtn');

// Включаем кнопку "Отправить" при выборе файла через input
excelFileInput.addEventListener('change', function () {
    if (excelFileInput.files.length > 0) {
        handleSingleFile();
    }
});

// Предотвращаем стандартное поведение для Drag & Drop
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileDropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Обработка события drop
fileDropArea.addEventListener('drop', function (e) {
    const dt = e.dataTransfer;
    const files = dt.files;

    if (files.length > 0) {
        excelFileInput.files = files;
        handleSingleFile(); // Обрабатываем только первый файл
    }
}, false);

// Общая функция для обработки только первого файла
function handleSingleFile() {
    const file = excelFileInput.files[0]; // Берем только первый файл

    // Проверка файла
    if (control(file)) {
        // Оставляем только первый файл
        const dataTransfer = new DataTransfer(); // Создаем новый объект DataTransfer
        dataTransfer.items.add(file); // Добавляем первый файл
        excelFileInput.files = dataTransfer.files; // Присваиваем обновленный список файлов

        enableSubmitAndUpdateUI(); // Обновляем UI
    }
}

// Общая функция для активации кнопки и обновления UI
function enableSubmitAndUpdateUI() {
    submitBtn.disabled = false; // Включаем кнопку отправки

    // Удаление класса 'ui-ctl-file-drop'
    fileDropArea.classList.remove('ui-ctl-file-drop');

    // Удаление внутреннего div с текстом
    const innerDiv = fileDropArea.querySelector('.ui-ctl-label-text');
    if (innerDiv) {
        innerDiv.remove();
    }

    // Удаление класса 'ui-ctl-element' у инпута
    excelFileInput.classList.remove('ui-ctl-element');
}

// Проверка типа файла
function control(file) {
    // Проверка типа файла (например, только .xlsx)
    if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        alert('Пожалуйста, выберите файл с расширением .xlsx');
        excelFileInput.value = ''; // Сброс инпута

        return false;
    }
    return true;
}
