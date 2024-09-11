import {step} from './view/steps.js';
import {exportData} from './action/exportFile.js';
import {importData} from './action/importFile.js';

window.step = step;
window.exportData = exportData;
window.importData = importData;

// Очистить input file при загрузке страницы
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('excelFile').value = '';
});

// Изменение отображение инпута для файла
document.getElementById('excelFile').addEventListener('change', function (event) {
    const fileInput = event.target;
    const label = fileInput.closest('label');
    const innerDiv = label.querySelector('.ui-ctl-label-text');
    const submitButton = document.querySelector('.ui-btn-success');

    // Проверка, выбран ли файл
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];

        // Проверка типа файла (например, только .xlsx)
        if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            alert('Пожалуйста, выберите файл с расширением .xlsx');
            fileInput.value = ''; // Сброс инпута
            return;
        }

        // Удаление класса 'ui-ctl-file-drop'
        label.classList.remove('ui-ctl-file-drop');

        // Удаление внутреннего div с текстом
        if (innerDiv) {
            innerDiv.remove();
        }

        // Удаление класса 'ui-ctl-element' у инпута
        fileInput.classList.remove('ui-ctl-element');

        // Разблокировать кнопку
        submitButton.disabled = false;
    } else {
        // Если файл не выбран, блокируем кнопку
        submitButton.disabled = true;
    }
});
