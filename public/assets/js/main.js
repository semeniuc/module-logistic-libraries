import {step} from './view/steps.js';
import {exportData} from './action/exportFile.js';
import {importData} from './action/importFile.js';
import {setActiveStage} from "./view/stages.js";
import './action/inputFile.js';
import './action/selectType.js';

window.step = step;
window.exportData = exportData;
window.importData = importData;

// Очистить input file при загрузке страницы
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('excelFile').value = '';
    setActiveStage(1);
});

// Отключаем стандартное поведение (отправку формы)
document.getElementById('submitBtn').addEventListener('click', function (event) {
    event.preventDefault();
});