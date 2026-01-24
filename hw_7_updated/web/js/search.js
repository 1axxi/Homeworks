
function showAlert() {
    alert('Поиск: ' + (document.getElementById('search')?.value || ''));
}

// Ждём загрузки страницы
window.onload = function() {
    const input = document.getElementById('search');
    if (input) {
        input.oninput = function() {
            const text = this.value.toLowerCase();
            document.querySelectorAll('table tr:not(:first-child)').forEach(row => {
                row.style.display = row.cells[1]?.textContent.toLowerCase().includes(text) ? '' : 'none';
            });
        };
    }
};