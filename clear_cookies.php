<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cookies = explode('; ', $_SERVER['HTTP_COOKIE']);
    foreach ($cookies as $cookie) {
        $parts = explode("=", $cookie, 2);
        $name = $parts[0];
        if (preg_match("/^wordpress_/", $name)) {
            setcookie($name, "", time()-1000);
            setcookie($name, "", time()-1000, "/");
        }
    }
    if (isset($_POST['redirect_to']) && preg_match("/^\//", $_POST["redirect_to"])) {
        header("Location: $_POST[redirect_to]");
    } else {
        header("Location: /wp-login.php");
    }
}
else {
    ?>

    <p>
        Some users have experienced issues with the log in process. If you're
        one of them, click this button, and then try to log in again.
    </p>

    <form action="" method="post">
        <button type="submit">Clear cookies</button>
    </form>
    <?php
}
