<?php

namespace App\Controllers;

use App\Libraries\CaptchaService;

class CaptchaController extends BaseController
{
    public function image()
    {
        $captcha = new CaptchaService();

        return $this->response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setContentType('image/svg+xml')
            ->setBody($captcha->generateSvg());
    }
}
