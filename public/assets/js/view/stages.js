// Функция для установки активного этапа и изменения цвета предыдущих
export function setActiveStage(activeStage) {
    // Получаем все этапы
    const stages = document.querySelectorAll('.stage');

    // Проходим по каждому этапу
    stages.forEach((stage, index) => {
        // Получаем ID текущего этапа
        const stageId = index + 1;

        // Устанавливаем активный класс для текущего этапа и перекрашиваем предыдущие
        if (stageId <= activeStage) {
            stage.classList.add('active');

            // Меняем цвет в зависимости от активного этапа
            if (activeStage === 1) {
                document.documentElement.style.setProperty('--stage-1', '#2FC6F6');
            } else if (activeStage === 2) {
                document.documentElement.style.setProperty('--stage-1', 'var(--stage-2)');
            } else if (activeStage === 3) {
                document.documentElement.style.setProperty('--stage-1', 'var(--stage-3)');
                document.documentElement.style.setProperty('--stage-2', 'var(--stage-3)');
            }
        } else {
            stage.classList.remove('active');
        }
    });
}