import {currentPage, errorsData, recordsPerPage, setCurrentPage} from "../action/importFile.js";
import {displayRecords} from "./table.js";

export function updatePagination() {
    const pagination = document.getElementById('pagination');
    const totalPages = Math.ceil(errorsData.length / recordsPerPage);

    // "Назад"
    const prevBtn = document.getElementById('prevBtn');
    prevBtn.disabled = currentPage === 1;
    prevBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            setCurrentPage(currentPage - 1);
            displayRecords(currentPage);
        }
    });
    pagination.appendChild(prevBtn);

    // "Вперед"
    const nextBtn = document.getElementById('nextBtn');
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.addEventListener('click', function () {
        if (currentPage < totalPages) {
            setCurrentPage(currentPage + 1);
            displayRecords(currentPage);
        }
    });
    pagination.appendChild(nextBtn);
}
