import {showLoading, step, toggleElements} from "../view/steps.js";
import {displayRecords} from '../view/table.js';

export let currentPage = 1;        // Текущая страница
export let errorsData = [];        // Массив для хранения записей с ошибками
export const recordsPerPage = 50;  // Количество записей на одной странице

export function importData() {
    const form = document.getElementById('importForm');
    const formData = new FormData(form);
    const directoryType = document.getElementById('directoryType').value;

    formData.append('directoryType', directoryType);

    showLoading(true);
    toggleElements(true);

    fetch('/local/modules/logistic.libraries/import', {
        method: 'POST',
        body: formData,
        headers: {
            'Cache-Control': 'no-cache'
        }
    })
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            toggleElements(false);

            // Очистить поле выбора файла
            document.getElementById('excelFile').value = '';

            // Обновить счётчики успехов и ошибок
            document.getElementById('successCount').textContent = data.success.total || 0;
            document.getElementById('errorCount').textContent = data.errors.total || 0;

            // Сохранить записи ошибок для пагинации
            errorsData = data.errors.records || [];

            // console.log('errorsData:', errorsData);
            step(3);

            // Отобразить записи для первой страницы
            displayRecords(currentPage);
        })
        .catch(error => {
            console.error('Error:', error);
            showLoading(false);
            toggleElements(false);
        });
}

export function setCurrentPage(page) {
    currentPage = page;
}
