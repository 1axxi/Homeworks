
function showAlert() {
    alert('Это демонстрационное сообщение Alert!\n\n' +
        'Фильтрация работает на PHP - при поиске страница перезагружается.\n' +
        'Поисковый запрос: "' + document.querySelector('input[name="search"]').value + '"');
}
function clearSearch() {
    document.querySelector('input[name="search"]').value = '';
    document.querySelector('form').submit();
}