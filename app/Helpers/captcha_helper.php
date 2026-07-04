<?php

if (! function_exists('captcha_field')) {
    function captcha_field(string $inputName = 'captcha'): string
    {
        return view('components/captcha', [
            'inputName' => $inputName,
            'imageUrl'  => base_url('captcha/image'),
        ]);
    }
}
