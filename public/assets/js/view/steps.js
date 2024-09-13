export function step(step) {
    document.querySelectorAll('.step').forEach((el) => el.classList.remove('active'));
    document.querySelectorAll('.step')[step - 1].classList.add('active');

    updateProgressBar(step);
}

export function toggleElements(isDisable) {
    const buttons = document.querySelectorAll('button[type="button"]');
    const selects = document.querySelectorAll('select');
    const inputs = document.querySelectorAll('input');

    buttons.forEach(button => {
        button.disabled = isDisable;
        if (isDisable) {
            button.classList.add('disabled-button');
        } else {
            button.classList.remove('disabled-button');
        }
    });

    selects.forEach(select => {
        select.disabled = isDisable;
        if (isDisable) {
            select.classList.add('disabled-select');
        } else {
            select.classList.remove('disabled-select');
        }
    });

    inputs.forEach(input => {
        input.disabled = isDisable;
        if (isDisable) {
            input.classList.add('disabled-input');
        } else {
            input.classList.remove('disabled-input');
        }
    });
}

export function updateProgressBar(step) {
    const progressBar = document.getElementById('progressBar');
    const stepPercentage = (step / 3) * 100; // Обновлено на 3 шага
    progressBar.style.width = stepPercentage + '%';
}

export function showLoading(isShow) {
    const spinner = document.getElementById('spinner');

    if (isShow === true) {
        spinner.style.display = 'block';
    } else {
        spinner.style.display = 'none';
    }
}