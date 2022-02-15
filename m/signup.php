<?php include("sablon.php"); ?>
<?php a("Kaydol",1) ?>
        <label for="txt-first-name"><?php le("Adınız") ?></label>
        <input type="text" name="txt-first-name" id="txt-first-name" value="">
        <label for="txt-last-name"><?php le("Soyadınız") ?></label>
        <input type="text" name="txt-last-name" id="txt-last-name" value="">
        <label for="txt-departman"><?php le("Okuduğunuz Bölüm") ?></label>
        <input type="text" name="txt-departman" id="txt-departman" value="">
        <label for="txt-email"><?php le("E-Posta Adresiniz") ?></label>
        <input type="text" name="txt-email" id="txt-email" value="">
        <label for="txt-password"><?php le("Parolanız") ?></label>
        <input type="password" name="txt-password" id="txt-password" value="">
        <label for="txt-password-confirm"><?php le("Parolanız (Tekrar)") ?></label>
        <input type="password" name="txt-password-confirm" id="txt-password-confirm" value="">
       <button type="submit"><?php le("Kaydol") ?></button>
<?php b(""); ?>