const excelFileInput = document.getElementById('excelFile');
const submitBtn = document.getElementById('submitBtn');
const fileMessage = document.getElementById('file-message');

// Включаем кнопку "Отправить" при выборе файла через input
excelFileInput.addEventListener('change', function () {
    if (excelFileInput.files.length > 0) {
        const file = excelFileInput.files[0];
        handleSingleFile(file);
    } else {
        fileMessage.textContent = 'Файл не выбран'; // Показываем сообщение об ошибке
    }
});

// Общая функция для обработки только первого файла
function handleSingleFile(file) {
    // Проверка файла
    if (control(file)) {
        // Оставляем только первый файл
        const dataTransfer = new DataTransfer(); // Создаем новый объект DataTransfer
        dataTransfer.items.add(file); // Добавляем первый файл
        excelFileInput.files = dataTransfer.files; // Присваиваем обновленный список файлов

        enableSubmitAndUpdateUI(file); // Обновляем UI
    }
}

// Общая функция для активации кнопки и обновления UI
function enableSubmitAndUpdateUI(file) {
    submitBtn.disabled = false; // Включаем кнопку отправки
    fileMessage.textContent = `Выбран файл: ${file.name}`; // Показываем имя файла
}

// Проверка типа файла
function control(file) {
    // Проверка типа файла (например, только .xlsx)
    if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        alert('Пожалуйста, выберите файл с расширением .xlsx');
        excelFileInput.value = ''; // Сброс инпута
        submitBtn.disabled = true; // Отключаем кнопку
        fileMessage.style.color = 'red'; // Меняем цвет сообщения на красный
        fileMessage.textContent = 'Пожалуйста, выберите файл с расширением .xlsx'; // Показываем сообщение об ошибке
        return false;
    }
    return true;
}
