<?php
require 'db.php';

$success = isset($_GET['ok']);

$error = '';
$pattern = '/[^a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ-]/u';
$name = $surname = $email = $phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = preg_replace('/[^\d+]/', '', trim($_POST['phone'] ?? ''));

    if ($name === '' || $surname === '' || $email === '' || $phone === '') {
        $error = "Visi lauki ir obligāti.";
    }
    else if (mb_strlen($name) > 100 || mb_strlen($surname) > 100 || mb_strlen($email) > 100) {
        $error = "Ievadītie dati pārsniedz 100 simbolu limitu.";
    }
    else if (preg_match($pattern, $name) || preg_match($pattern, $surname)) {
        $error = "Vārds un uzvārds nedrīkst saturēt skaitļus, atstarpes vai simbolus.";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-pasts neatbilst standarta formātam. Formāts: example@gmail.com.";
    }
    else if (!preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
        $error = "Telefona numurs neatbilst E.164 standartam (piem.: +37198765432).";
    }
    else {
        try {
            $statement = $db->prepare('SELECT id FROM clients WHERE email = ?');
            $statement->execute([$email]);

            if ($statement->fetch()) {
                $error = "Klients ar šo e-pastu jau ir pievienots.";
            }
            else {
                $statement = $db->prepare(
                    'INSERT INTO clients (name, surname, email, phone) VALUES (?, ?, ?, ?)'
                );
                $statement->execute([$name, $surname, $email, $phone]);

                header('Location: index.php?ok=1');
                exit;
            }
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            $error = "Neizdevās saglabāt datus. Mēģiniet vēlreiz.";
        }
    }
}

require 'header.php';
?>

<h1>Klientu reģistrācija</h1>

<?php if ($error): ?>
    <p style="color:red"> <?= e($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green">Klients veiksmīgi pievienots!</p>
<?php endif; ?>

<form method="post">
    Vārds: <input name="name" value="<?= e($name) ?>" maxlength="100" required><br>
    Uzvārds: <input name="surname" value="<?= e($surname) ?>" maxlength="100" required><br>
    Email: <input name="email" value="<?= e($email) ?>" maxlength="100" placeholder="example@gmail.com" required><br>
    Tel.nr: <input name="phone" value="<?= e($phone) ?>" placeholder="+37120000000" required><br>
    <button type="submit">Reģistrēt</button>
</form>

</body>
</html>
