import {toggleElements} from "../view/steps.js";

export function exportData() {
    const directoryType = document.getElementById('directoryType').value;
    const directoryTypeName = document.querySelector('#directoryType option:checked').textContent;

    const dataToSend = {
        categoryName: directoryType
    };

    document.getElementById('spinner').style.display = 'block';
    toggleElements(true);

    fetch('/local/modules/logistic.libraries/export', {
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