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
	<div class="ui blue inverted segment sticky">
		<div class="ui container content">
			<div class="top">
				<?php
				echo ("Data ");
				$date = new DateTime();
				$date->setDate(2015, 12, 1);
				echo $date->format("y-m-d");
				?>
			</div>
		</div>
	</div>
	<?php require 'includes/header.php'; ?>


	<!-- Tresc aplikacji -->
	<div class="sk-content">
		<div class="ui container">
			<div class="ui two column stackable relaxed grid">

				<div class="eleven wide column">
					<!-- lista artykułów -->
					<h2>Najnowsze artykuły</h2>
					<?php include('db_connect.php');
					$result = $mysqli->query("SELECT * FROM articles ORDER BY id");
					while ($article = mysqli_fetch_array($result)) {
						echo '<article class="single-article">';
						echo '<h3>' . $article['title'] . '</h3>';
						echo '<img src="' . $article['image'] . '" alt="">';
						echo '<div class="article-content">';
						echo '<p>' . $article['content'] . '</p>';
						echo '</div>';
						echo '<a href="delete.php?id=' . $article['id'] . '">';/*przekierowanie do funkcj usun */
						echo '<div class="ui label"><i class="remove icon"></i>Usuń</div>';/*przycisk usun*/
						echo '</a>';
						echo '</article>';
					}
					/* dodawanie nowego artykulu */
					if (isset($_POST['add'])) {
						$title = strip_tags($_POST['title']);
						$content = strip_tags($_POST['content']);
						$image = strip_tags($_POST['image']);
						$statement = $mysqli->prepare("INSERT articles (title,image,content) VALUES (?,?,?)");
						$statement->bind_param("sss", $title, $image, $content);
						$statement->execute();
						$statement->close();
						header("Location: index.php");
					}
					?>

					<h2>Dodaj nowy artykuł</h2>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="ui form">
						<div class="required field">
							<label>Tytuł</label>
							<input type="text" name="title" id="title">
						</div>
						<div class="required field">
							<label>Treść artykułu</label>
							<textarea name="content" id="content" cols="30" rows="10"></textarea>
						</div>
						<div class="required field">
							<label>Obrazek</label>
							<input type="text" name="image" id="image">
						</div>
						<input type="submit" class="ui primary button" id="add" name="add" value="Dodaj artykuł"></input>
					</form>
				</div>

				<div class="five wide column">
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
					
				</div>
			</div>
		</div>
	</div>

	<!-- Stopka -->
	<?php require 'includes/footer.php'; ?>
</body>

</html>