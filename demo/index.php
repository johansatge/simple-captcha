<?php
session_start();
if (!empty($_POST))
{
    $is_valid = !empty($_SESSION['simple_captcha']) && !empty($_POST['captcha']) && $_SESSION['simple_captcha'] == $_POST['captcha'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8>
        <title>Captcha demo</title>
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/styles.css">
    </head>
    <body>
        <div class="centered">
            <?php if (isset($is_valid)) : ?>
                <div class="message">
                    Captcha is <strong><?php if ($is_valid) : ?>valid<?php else : ?>invalid<?php endif; ?></strong>.
                </div>
            <?php endif; ?>
            <form action="?" method="post">
                <label>
                    Sample field<br>
                    <input type="text" name="sample">
                </label>
                <label>
                    <a class="js-reload" href="#">Reload</a>
                    Fill captcha
                    <img class="js-captcha" src="../captcha.php?rand=<?php echo md5(microtime(true)); ?>">
                    <input type="text" name="captcha">
                </label>
                <input type="submit" value="Send">
            </form>
        </div>
    </body>
    <script>
        var reload = document.querySelector('.js-reload');
        var captcha = document.querySelector('.js-captcha');
        reload.addEventListener('click', function(evt)
        {
            evt.preventDefault();
            captcha.setAttribute('src', '../captcha.php?rand=' + new Date().getTime());
        });
    </script>
</html>