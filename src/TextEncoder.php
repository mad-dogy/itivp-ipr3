<?php

namespace App;

class TextEncoder
{
    /**
     * Кодирует текст в формат Base64.
     *
     * @param string $text
     * @return string
     */
    public function base64Encode(string $text): string
    {
        return base64_encode($text);
    }

    /**
     * Применяет кодирование ROT13 к тексту.
     *
     * @param string $text
     * @return string
     */
    public function rot13(string $text): string
    {
        return str_rot13($text);
    }
}