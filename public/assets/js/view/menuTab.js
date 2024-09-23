function openPopup(url, title) {
    BX.SidePanel.Instance.open(url, {
        width: 1620, // Ширина попапа
        height: 600, // Высота попапа
        loader: 'Y',
        allowChangeHistory: false,
        title: title,
        label: {
            text: title,
        },
        events: {
            onLoad: function (event) {
                // Действия при загрузке попапа
            },
            onClose: function (event) {
                // Действия при закрытии попапа
            }
        }
    });
}

function addCustomLinkToLeftMenu() {
    // Создание элемента меню
    var menuItem = BX.create(
        'li',
        {
            attrs: {
                className: 'menu-item',
                id: 'custom_menu_item'
            },
            html: `
                <a href="#" class="menu-item-link">
                    <span class="menu-item-icon-box"></span>
                    <span class="menu-item-link-text">Импорт справочников</span>
                </a>
            `
        }
    );

    // Добавление обработчика клика для открытия попапа
    BX.bind(menuItem, 'click', function () {
        openPopup('/local/modules/logistic.libraries?sessid=' + BX.bitrix_sessid(), 'Импорт');
    });

    // Найти контейнер левого меню и добавить новый элемент
    var leftMenuContainer = document.querySelector('ul.menu-items');
    if (!leftMenuContainer) {
        console.error('Не удалось найти контейнер левого меню');
    } else {
        leftMenuContainer.appendChild(menuItem);
    }
}

// Вызов функции для добавления ссылки в левое меню
document.addEventListener('DOMContentLoaded', function () {
    addCustomLinkToLeftMenu();
});