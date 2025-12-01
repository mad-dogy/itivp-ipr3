<?php

use PHPUnit\Framework\TestCase;
use App\TextEncoder;

class TextEncoderTest extends TestCase
{
    private TextEncoder $encoder;

    // Запуск перед каждым тестом
    protected function setUp(): void
    {
        $this->encoder = new TextEncoder();
    }

    // Тесты для Base64

    public function testBase64EncodeBasic()
    {
        // Проверка обычной строки
        $result = $this->encoder->base64Encode('Hello World');
        $this->assertEquals('SGVsbG8gV29ybGQ=', $result);
    }

    public function testBase64EncodeCyrillic()
    {
        // Проверка кириллицы (Edge case с кодировкой)
        $result = $this->encoder->base64Encode('Привет');
        // base64 от "Привет" в UTF-8
        $this->assertEquals('0J/RgNC40LLQtdGC', $result);
    }

    public function testBase64EncodeEmptyString()
    {
        // Крайний случай: пустая строка
        $result = $this->encoder->base64Encode('');
        $this->assertEquals('', $result);
    }

    // Тесты для ROT13

    public function testRot13Basic()
    {
        // ROT13 от "abc" -> "nop"
        $result = $this->encoder->rot13('abc');
        $this->assertEquals('nop', $result);
    }

    public function testRot13Reversible()
    {
        // ROT13 обратим: дважды примененный метод должен вернуть исходный текст
        $original = 'PHP Unit Test';
        $encoded = $this->encoder->rot13($original);
        $decoded = $this->encoder->rot13($encoded);

        $this->assertEquals($original, $decoded);
    }

    public function testRot13EmptyString()
    {
        // Крайний случай: пустая строка
        $result = $this->encoder->rot13('');
        $this->assertEquals('', $result);
    }

    public function testRot13NumericString()
    {
        // ROT13 меняет только буквы, цифры остаются (Edge case)
        $result = $this->encoder->rot13('12345');
        $this->assertEquals('12345', $result);
    }

    // Тест на исключения

    public function testBase64ThrowsErrorOnArrayInput()
    {
        // Ожидаем ошибку типа TypeError, так как функция ждет string, а мы передадим array
        $this->expectException(\TypeError::class);
        
        // @phpstan-ignore-next-line (игнорируем подсветку IDE для теста)
        $this->encoder->base64Encode(['not', 'a', 'string']);
    }
}