import {step} from './view/steps.js';
import {exportData} from './action/exportFile.js';
import {importData} from './action/importFile.js';
import './action/dragAndDrop.js';

window.step = step;
window.exportData = exportData;
window.importData = importData;

// Очистить input file при загрузке страницы
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('excelFile').value = '';
});

// Отключаем стандартное поведение (отправку формы)
document.getElementById('submitBtn').addEventListener('click', function (event) {
    event.preventDefault();
});


// Подключение подсказок
BX.UI.Hint.init(BX('container'));