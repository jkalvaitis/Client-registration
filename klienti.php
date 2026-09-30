<?php
require 'db.php';

$error = '';
try {
    $clients = $db->query("SELECT id, name, surname, email, phone FROM clients ORDER BY id")
                  ->fetchAll();
}
catch (PDOException $e) {
    error_log($e->getMessage());
    $error = "Kļūme radās atlasot klientus.";
    $clients = [];
}

require 'header.php';
?>

<h1>Klienti</h1>
<?php if ($error): ?>
    <p style="color:red"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($clients): ?>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vārds</th>
                <th>Uzvārds</th>
                <th>E-pasts</th>
                <th>Tel.nr</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $c): ?>
            <tr>
                <td><?= e($c['id']) ?></td>
                <td><?= e($c['name']) ?></td>
                <td><?= e($c['surname']) ?></td>
                <td><?= e($c['email']) ?></td>
                <td><?= e($c['phone']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php elseif (!$error): ?>
    <p>Nav neviena klienta pievienota</p>
<?php endif; ?>

</body>
</html>
