import {setActiveStage} from "./stages.js";

export function step(step) {
    document.querySelectorAll('.step').forEach((el) => el.classList.remove('active'));
    document.querySelectorAll('.step')[step - 1].classList.add('active');
    setActiveStage(step);
}

export function toggleElements(isDisable) {
    const buttons = document.querySelectorAll('button');
    const selects = document.querySelectorAll('select');
    const inputs = document.querySelectorAll('input');

    document.getElementById('excelFile').disabled = true;

    buttons.forEach(button => {
        button.disabled = isDisable;
    });

    selects.forEach(select => {
        select.disabled = isDisable;
    });

    inputs.forEach(input => {
        input.disabled = isDisable;
    });
}

export function showLoading(isShow) {
    const spinner = document.getElementById('spinner');

    if (isShow === true) {
        spinner.style.display = 'block';
    } else {
        spinner.style.display = 'none';
    }
}