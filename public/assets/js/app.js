document.addEventListener('DOMContentLoaded', function () {
    // Очистить input file при загрузке страницы
    document.getElementById('excelFile').value = '';
});

function step(step) {
    document.querySelectorAll('.step').forEach((el) => el.classList.remove('active'));
    document.querySelectorAll('.step')[step - 1].classList.add('active');
    updateProgressBar(step);
}

function updateProgressBar(step) {
    const progressBar = document.getElementById('progressBar');
    const stepPercentage = (step / 3) * 100; // Обновлено на 3 шага
    progressBar.style.width = stepPercentage + '%';
    progressBar.setAttribute('aria-valuenow', stepPercentage);
    progressBar.textContent = 'Этап ' + step;
}

function showExport() {
    step(2);
    document.getElementById('exportStep').style.display = 'block';
    document.getElementById('importStep').style.display = 'none';
}

function showImport() {
    step(2);
    document.getElementById('exportStep').style.display = 'none';
    document.getElementById('importStep').style.display = 'block';
}

function exportData() {
    const directoryType = document.getElementById('directoryType').value;
    const directoryTypeName = document.querySelector('#directoryType option:checked').textContent;

    const dataToSend = {
        categoryName: directoryType
    };

    document.getElementById('spinner').style.display = 'block';
    toggleElements(true);

    fetch('/library/export', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSend)
    })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = directoryTypeName + '_' + new Date().getTime() + '.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);

            document.getElementById('spinner').style.display = 'none';
            toggleElements(false);
            
        })
        .catch(error => {
            console.error('Download error:', error);

            document.getElementById('spinner').style.display = 'none';
            toggleElements(false);
        });
}

function importData() {
    const form = document.getElementById('importForm');
    const formData = new FormData(form);

    const directoryType = document.getElementById('directoryType').value;
    formData.append('directoryType', directoryType);

    document.getElementById('spinner').style.display = 'block';
    toggleElements(true);

    fetch('/library/import', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);

            document.getElementById('spinner').style.display = 'none';
            toggleElements(false);

            document.getElementById('excelFile').value = '';

            importResult();
            step(3);
        })
        .catch(error => {
            console.error('Error:', error);

            document.getElementById('spinner').style.display = 'none';
            toggleElements(false);
        });
}

function toggleElements(disable) {
    const buttons = document.querySelectorAll('button[type="button"]');
    const selects = document.querySelectorAll('select');
    const inputs = document.querySelectorAll('input');

    buttons.forEach(button => {
        button.disabled = disable;
        if (disable) {
            button.classList.add('disabled-button');
        } else {
            button.classList.remove('disabled-button');
        }
    });

    selects.forEach(select => {
        select.disabled = disable;
        if (disable) {
            select.classList.add('disabled-select');
        } else {
            select.classList.remove('disabled-select');
        }
    });

    inputs.forEach(input => {
        input.disabled = disable;
        if (disable) {
            input.classList.add('disabled-input');
        } else {
            input.classList.remove('disabled-input');
        }
    });
}

function importResult() {
    const errors = [
        {row: 5, message: 'Invalid data format'},
        {row: 12, message: 'Missing required field'}
    ];

    document.getElementById('successCount').textContent = 10;
    document.getElementById('errorCount').textContent = errors.length;
    const errorTable = document.getElementById('errorTable');
    const errorTableBody = errorTable.querySelector('tbody');
    errorTableBody.innerHTML = '';
    errors.forEach(error => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${error.row}</td><td>${error.message}</td>`;
        errorTableBody.appendChild(row);
    });
    errorTable.style.display = 'table';
}
