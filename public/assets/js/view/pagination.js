const recordsPerPage = 10;  // Количество записей на одной странице
let currentPage = 1;        // Текущая страница

function displayRecords(data, page) {
    const errorTableBody = document.querySelector('#errorTable tbody');
    errorTableBody.innerHTML = ''; // Очистить предыдущие записи

    // Рассчитать начало и конец текущей страницы
    const start = (page - 1) * recordsPerPage;
    const end = start + recordsPerPage;

    // Отобразить только нужные записи для текущей страницы
    const recordsToDisplay = data.slice(start, end);
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

    updatePagination(data.length);  // Обновляем кнопки пагинации
}

function updatePagination(totalRecords) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = ''; // Очистить пагинацию

    const totalPages = Math.ceil(totalRecords / recordsPerPage);

    // Создать кнопки для каждой страницы
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.textContent = i;
        pageBtn.classList.add('page-btn');
        if (i === currentPage) {
            pageBtn.classList.add('active');
        }

        pageBtn.addEventListener('click', function () {
            currentPage = i;
            displayRecords(data, currentPage);
        });

        pagination.appendChild(pageBtn);
    }
}

// Вызов функции при получении данных
fetch('/local/modules/logistic.libraries/import', {
    method: 'POST',
    body: formData,
    headers: {
        'Cache-Control': 'no-cache'
    }
})
    .then(response => response.json())
    .then(data => {
        // Отобразить данные для первой страницы
        displayRecords(data.errors.records, currentPage);
    })
    .catch(error => {
        console.error('Error:', error);
    });
