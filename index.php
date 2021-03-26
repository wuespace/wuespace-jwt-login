<?php
/*
 * Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
 */

use function wuespace\jwt\auth\signIn;

require_once 'system/setup.php';

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="WüSpace e. V.">
    <meta name="robots" content="noindex,nofollow">
    <title>WüSpace Login</title>
    <link href="css/tailwind.css" rel="stylesheet">
</head>
<body class="flex justify-center min-h-screen bg-primary bg-gray-100 p-4">
<div class="max-w-md m-auto p-4 shadow bg-white rounded-2xl font-body">
    <img src="img/logo.png" alt="WüSpace" class="w-32 mx-auto">
    <h1 class="text-center text-2xl font-headline text-primary">WüSpace Login</h1>
	<?php if (isset($_GET['source']) && isDomainRegistered($_GET['source'])): ?>
	<?php if (!isset($_POST['username'], $_POST['password']) || !signIn($_POST['username'], $_POST['password'])): ?>
        <p class="mt-4">
            Logge dich mit deinen WüSpace-Zugangsdaten ein, um
            dich für <code class="select-all"><?= htmlspecialchars($_GET['source']) ?></code>
            zu authentifizieren.
        </p>
        <p class="mt-4">
            Nach Eingabe gelangst du auf eine Seite, auf der du die
            Übermittlung der Daten bestätigen musst.
        </p>
        <form method="post">
            <?php if (isset($_POST['username'])): ?>
                <p class="mt-4 border-l-2 border-red-500 bg-red-50 p-4">
                    Diese Anmeldedaten scheinen leider nicht ganz richtig zu sein. Bitte versuche es erneut.
                </p>
            <?php endif; ?>
            <p class="mt-4">
                <label>
                    Mitgliedsnummer:<br>
                    <input value="<?=empty($_POST['username']) ? '' : htmlspecialchars($_POST['username'])?>"
                           type="text" name="username" required class="border-b block w-full" autofocus>
                </label>
            </p>
            <p class="mt-4">
                <label>
                    Passwort:<br>
                    <input type="password" name="password" required class="border-b block w-full">
                </label>
            </p>
            <p class="mt-4">
                <button type="submit"
                        class="bg-primary rounded-full px-4 py-2 float-right text-white"
                >
                    Einloggen
                </button>
            </p>
        </form>
	<?php else: ?>
	<?php $token = signIn($_POST['username'], $_POST['password']); ?>
    <form method="post" action="<?=urldecode($_GET['source'])?>">
        <p class="mt-4">
            Folgende Daten werden, wenn Du auf <strong>Daten übermitteln</strong> klickst,
            an <code class="select-all"><?= htmlspecialchars($_GET['source']) ?></code>
            übermittelt:
        </p>
        <p class="mt-4">
            <label>
                Token:<br>
                <input type="text" name="token" required readonly class="border-b block w-full select-all"
                       value="<?= htmlspecialchars(signIn($_POST['username'], $_POST['password'])) ?>">
            </label>
        </p>
        <p class="mt-4 clear-both">
            Um den Vorgang abzubrechen, kannst du die Seite einfach schließen.
        </p>
        <p class="mt-4">
            <button type="submit"
                    class="bg-primary rounded-full px-4 py-2 float-right text-white" autofocus
            >
                Daten übermitteln
            </button>
        </p>
		<?php endif; ?>
		<?php else: ?>
            <p class="text-red-600 mt-4">
                <strong>Fehler: Es konnte keine Weiterleitungs-URL festgestellt werden.</strong>
                <br>
                Bitte kehre zur Ursprungsseite zurück und versuche es erneut. Bleibt das Problem bestehen, wende dich
                bitte
                an die WüSpace-IT-Fachleute.
            </p>
		<?php endif; ?>
</div>
</body>
</html>
