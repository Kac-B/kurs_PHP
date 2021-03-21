<?php
$email = '';
$password = '';
$terms = '';
$errorEmail = '';
$errorPassword = '';
$errorTerms = '';
$emailSent = '';
if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $terms = $_POST['terms'];
    if (!$email) {
        $errorEmail = 'Uzupełnij pole email';
    } elseif ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = 'Upewnij się, że adres email ma prawidłowy format';
    }
    if (!$password) {
        $errorPassword = 'Uzupełnij pole hasło';
    } elseif ($password && strlen($password) < 6) {
        $errorPassword = 'Hasło musi zawierać minimum 6 znaków';
    }
    if ($terms  != 'on') {
        $errorTerms = 'Musisz zaakceptować regulamin';
    }
    /* wysylamy email */
    if (!$errorEmail && !$errorPassword && !$errorTerms) {
        $to = 'test@strefakursow.pl ';
        $subject = 'Rejestracja w serwisie';
        $message = 'To jest przykładowa treść';
        $emailSent = mail($to, $subject, $message);
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Walidacja formularzy</title>
    <link rel="stylesheet" href="resources/semantic.min.css">
    <link rel="stylesheet" href="resources/custom.css">
    <!-- Dodatkowe skrypty -->
    <script src="resources/jquery.min.js"></script>
    <script src="resources/semantic.min.js"></script>

</head>

<body>

    <!-- Top -->

    <?php require 'includes/header.php'; ?>


    <!-- Tresc aplikacji -->
    <div class="sk-content">
        <div class="ui container">
            <div class="ui two column stackable relaxed grid">

                <div class="eleven wide column">
                    <!-- lista artykułów -->
                    <h2>Strona użytkownicy</h2>

                    <!-- Rejestracja -->
                    <h3>Rejestracja</h3>

                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="ui form">
                        <?php if ($emailSent == 1) { ?>
                            <div class="ui message">
                                <div class="header">Wiadomość wysłana</div>
                                <p>Na podany przez ciebie adres email została wysłana wiadomość z instrukcjami, które pozwolą ci dokonczyć rejestracje.</p>
                            </div>
                        <?php } ?>
                        <div class="required field">
                            <label>Email (login)</label>
                            <?php if ($errorEmail != null) { ?>
                                <span class="ui red label">
                                    <?php echo $errorEmail; ?>
                                </span>
                            <?php } ?>
                            <input type="text" name="email" id="email" value="<?php echo $email; ?>">
                        </div>

                        <div class="required field">
                            <label>Hasło</label>
                            <?php if ($errorPassword != null) { ?>
                                <span class="ui red label">
                                    <?php echo $errorPassword; ?>
                                </span>
                            <?php } ?>
                            <input type="text" name="password" id="password" value="<?php echo $password; ?>">
                        </div>

                        <div class="required field">
                            <div class="ui checkbox">
                                <?php if ($errorTerms != null) { ?>
                                    <span class="ui red label">
                                        <?php echo $errorTerms; ?>
                                    </span>
                                <?php } ?>
                                <input class="hidden" tabindex="0" type="checkbox" name="terms" id="terms" <?php echo (isset($_POST['terms']) ? 'checked="checked"' : '') ?>>
                                <label>Zapoznałem się z regulaminem</label>
                            </div>
                        </div>
                        <input type="submit" class="ui primary button" id="send" name="send" value="Wyślij"></input>
                    </form>
                    <!-- Tresc pod formularzem -->
                    <div class="sk-popular-users">
                        <h3 class="sk-column-header">Najpopularniejsi użytkownicy</h3>
                        <div class="ui two column grid">
                            <div class="ui eight column">
                                <div class="ui card">
                                    <div class="image">
                                        <img src="resources/images/avatar.png" alt="">
                                    </div>
                                    <div class="content">
                                        <a class="header">Janusz</a>
                                    </div>
                                    <div class="extra content">
                                        <a href=""><i class="user icon"></i>6 obserwuje</a>
                                    </div>
                                </div>
                            </div>
                            <div class="ui eight column">
                                <div class="ui card">
                                    <div class="image">
                                        <img src="resources/images/avatar.png" alt="">
                                    </div>
                                    <div class="content">
                                        <a class="header">Krzysiek</a>
                                    </div>
                                    <div class="extra content">
                                        <a href=""><i class="user icon"></i>2 obserwuje</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stopka -->
    <?php require 'includes/footer.php'; ?>
</body>

</html>