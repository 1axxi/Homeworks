<?php

$db = pg_connect("host=localhost dbname=study_database user=laxxi password=1246");
$result = pg_query($db, "SELECT * FROM bad_words");
?>

<table border="1">
    <tr><th>ID</th><th>Слово</th></tr>
    <?php while($row = pg_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['word'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<input type="text" placeholder="Поиск..." id="search">
<button onclick="alert('Простой Alert!')">Alert</button>

<script>
    // Простой поиск
    document.getElementById('search').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var rows = document.querySelectorAll('table tr');

        for (var i = 1; i < rows.length; i++) {
            var word = rows[i].cells[1].textContent.toLowerCase();
            rows[i].style.display = word.includes(filter) ? '' : 'none';
        }
    });
</script>