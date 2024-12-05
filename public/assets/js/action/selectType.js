document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('directoryType');
    const buttons = document.querySelectorAll('button');

    // Функция для управления состоянием кнопок
    const toggleButtons = () => {
        const isDisabled = !selectElement.value; // Проверяем, есть ли выбранное значение
        buttons.forEach(button => {
            button.disabled = isDisabled;
        });
    };

    // Проверка состояния при загрузке страницы
    toggleButtons();

    // Проверка состояния при изменении селекта
    selectElement.addEventListener('change', toggleButtons);
});
