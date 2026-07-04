<?php
$inputName = $inputName ?? 'captcha';
$imageUrl = $imageUrl ?? base_url('captcha/image');
$imageId = 'captcha-image-' . bin2hex(random_bytes(4));
?>

<div class="form-group">
    <label for="<?= esc($inputName, 'attr') ?>" class="sr-only">Enter CAPTCHA</label>
    <div class="d-flex align-items-center mb-2" style="gap: 10px;">
        <img
            src="<?= esc($imageUrl, 'attr') ?>?t=<?= time() ?>"
            id="<?= esc($imageId, 'attr') ?>"
            alt="CAPTCHA image"
            width="160"
            height="58"
            style="border: 1px solid #d8dde6; border-radius: 6px;"
        >
        <button
            type="button"
            class="btn btn-outline-secondary btn-sm"
            onclick="document.getElementById('<?= esc($imageId, 'attr') ?>').src='<?= esc($imageUrl, 'attr') ?>?t=' + Date.now();"
        >
            Refresh CAPTCHA
        </button>
    </div>
    <input
        type="text"
        name="<?= esc($inputName, 'attr') ?>"
        id="<?= esc($inputName, 'attr') ?>"
        class="form-control form-control-lg"
        placeholder="Enter CAPTCHA"
        autocomplete="off"
        required
    >
</div>
