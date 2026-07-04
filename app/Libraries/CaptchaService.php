<?php

namespace App\Libraries;

class CaptchaService
{
    private const SESSION_KEY = 'login_captcha_code';
    private const CHARS = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    private const LENGTH = 6;

    public function generateCode(): string
    {
        $code = '';
        $max = strlen(self::CHARS) - 1;

        for ($i = 0; $i < self::LENGTH; $i++) {
            $code .= self::CHARS[random_int(0, $max)];
        }

        session()->set(self::SESSION_KEY, $code);

        return $code;
    }

    public function validate(?string $answer): bool
    {
        $expected = (string) session()->get(self::SESSION_KEY);
        session()->remove(self::SESSION_KEY);

        $answer = strtoupper(trim((string) $answer));

        if ($expected === '' || $answer === '') {
            return false;
        }

        return hash_equals($expected, $answer);
    }

    public function generateSvg(): string
    {
        $code = $this->generateCode();
        $chars = str_split($code);
        $charSvg = '';

        foreach ($chars as $index => $char) {
            $x = 20 + ($index * 23);
            $y = random_int(38, 48);
            $rotation = random_int(-16, 16);
            $charSvg .= sprintf(
                '<text x="%d" y="%d" transform="rotate(%d %d %d)">%s</text>',
                $x,
                $y,
                $rotation,
                $x,
                $y,
                esc($char, 'attr')
            );
        }

        $noise = '';
        for ($i = 0; $i < 8; $i++) {
            $noise .= sprintf(
                '<line x1="%d" y1="%d" x2="%d" y2="%d" />',
                random_int(0, 160),
                random_int(0, 58),
                random_int(0, 160),
                random_int(0, 58)
            );
        }

        for ($i = 0; $i < 30; $i++) {
            $noise .= sprintf(
                '<circle cx="%d" cy="%d" r="%d" />',
                random_int(0, 160),
                random_int(0, 58),
                random_int(1, 2)
            );
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="160" height="58" viewBox="0 0 160 58" role="img" aria-label="CAPTCHA image">
    <rect width="160" height="58" rx="6" fill="#f4f7fb"/>
    <g stroke="#7a8aa0" stroke-width="1" opacity="0.42">$noise</g>
    <g fill="#1f2937" font-family="DejaVu Sans, Arial, sans-serif" font-size="27" font-weight="700" letter-spacing="2">$charSvg</g>
</svg>
SVG;
    }
}
