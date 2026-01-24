
<script src="/Homeworks/hw_7_updated/web/js/search.js"></script>
<div style="margin: 20px 0;">
    <input type="text"
           id="search"
           placeholder="Введите слово для поиска..."
           style="padding: 8px; width: 300px;">

    <button onclick="showAlert()"
            style="padding: 8px 15px; margin-left: 10px;">
        Показать Alert
    </button>
</div>
<?php
if (!isset($words) || !is_array($words)) {
$words = [];
}
?>
<table border="1">
    <tr><th>ID</th><th>Слово</th></tr>
    <?php foreach ($words as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['words']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
