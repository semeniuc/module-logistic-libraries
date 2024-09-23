import {errorsData, recordsPerPage} from "../action/importFile.js";

export function displayRecords(page) {
    const errorTable = document.getElementById('errorTable');
    const errorTableBody = errorTable.querySelector('tbody');
    errorTableBody.innerHTML = ''; // Очистить предыдущие записи


    // Рассчитать диапазон записей для текущей страницы
    const start = (page - 1) * recordsPerPage;
    const end = start + recordsPerPage;

    // Отобразить записи для текущей страницы
    const recordsToDisplay = errorsData.slice(start, end);
    recordsToDisplay.forEach(error => {
        error.description.forEach(description => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${error.sheet}</td><td>${error.row}</td><td>${description}</td>`;
            errorTableBody.appendChild(row);

            // Добавляем класс для анимации
            setTimeout(() => {
                row.classList.add('show');
            }, 100);
        });
    });
}
