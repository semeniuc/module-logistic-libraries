import {toggleElements} from "../view/steps.js";

export function importData() {
    const form = document.getElementById('importForm');

    const formData = new FormData(form);
    const directoryType = document.getElementById('directoryType').value;
    formData.append('directoryType', directoryType);

    document.getElementById('spinner').style.display = 'block';
    toggleElements(true);

    fetch('/local/modules/logistic.libraries/import', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);

            document.getElementById('spinner').style.display = 'none';
            toggleElements(false);

            // Очистить поле выбора файла
            document.getElementById('excelFile').value = '';

            // Обновить данные импорта на странице
            document.getElementById('successCount').textContent = data.success.total || 0;
            document.getElementById('errorCount').textContent = data.errors.total || 0;

            // Заполнить таблицу с ошибками
            const errorTable = document.getElementById('errorTable');
            const errorTableBody = errorTable.querySelector('tbody');
            errorTableBody.innerHTML = '';

            if (data.errors.records && data.errors.records.length > 0) {
                data.errors.records.forEach(error => {
                    error.description.forEach(description => {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td>${error.sheet}</td><td>${error.row}</td><td>${description}</td>`;
                        errorTableBody.appendChild(row);
                    });
                });
                errorTable.style.display = 'table';
            } else {
                errorTable.style.display = 'none';
            }

            step(3);
        })
        .catch(error => {
            console.error('Error:', error);

            document.getElementById('spinner').style.display = 'none';
            toggleElements(false);
        });
}