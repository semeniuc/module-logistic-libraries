const excelFileInput = document.getElementById('excelFile');
const submitBtn = document.getElementById('submitBtn');

// Включаем кнопку "Отправить" при выборе файла через input
excelFileInput.addEventListener('change', function () {
    if (excelFileInput.files.length > 0) {
        handleSingleFile();
    }
});

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

    // Удаление класса 'ui-ctl-element' у инпута
    excelFileInput.classList.remove('ui-ctl-element');
}

// Проверка типа файла
function control(file) {
    // Проверка типа файла (например, только .xlsx)
    if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        alert('Пожалуйста, выберите файл с расширением .xlsx');
        excelFileInput.value = ''; // Сброс инпута
        submitBtn.disabled = true; // Отключаем кнопку

        return false;
    }
    return true;
}
