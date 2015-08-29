<?php

session_start();
date_default_timezone_set('UTC');

$width   = !empty($_GET['width']) && $_GET['width'] <= 1000 && $_GET['width'] > 0 ? $_GET['width'] : 300;
$height  = !empty($_GET['height']) && $_GET['height'] <= 1000 && $_GET['height'] > 0 ? $_GET['height'] : 80;
$captcha = new SimpleCaptcha($width, $height);
$captcha->output();

class SimpleCaptcha
{

    private $image;
    private $width;
    private $height;
    private $chars_count = 5;
    private $chars_set = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ12345689';
    private $colors = array('880000', '008800', '000088', '888800', '880088', '008888', '000000');
    private $lines_count = 8;
    private $bg_color = 'ffffff';
    private $session_key = 'simple_captcha';

    public function __construct($width, $height)
    {
        $this->width  = intval($width);
        $this->height = intval($height);
    }

    public function output()
    {
        $this->initImage();
        $this->drawPoints();
        $this->drawLines();
        $text = $this->drawText();
        $this->setSession($text);
        $this->outputPNG();
    }

    private function initImage()
    {
        $this->image = imagecreatetruecolor($this->width, $this->height);
        imagefilledrectangle($this->image, 0, 0, $this->width - 1, $this->height - 1, hexdec($this->bg_color));
    }

    private function drawPoints()
    {
        $count = ($this->width * $this->height) / 30;
        for ($index = 0; $index < $count; $index += 1)
        {
            $color = hexdec($this->colors[rand(0, count($this->colors) - 1)]);
            $x     = rand(0, $this->width);
            $y     = rand(0, $this->height);
            imagesetpixel($this->image, $x, $y, $color);
        }
    }

    private function drawLines()
    {
        for ($index = 0; $index < $this->lines_count; $index += 1)
        {
            $color = hexdec($this->colors[rand(0, count($this->colors) - 1)]);
            imageline($this->image, rand(0, $this->width), rand(0, $this->height), rand(0, $this->width), rand(0, $this->height), $color);
        }
    }

    private function drawText()
    {
        $fonts     = glob(dirname(__FILE__) . '/fonts/*.ttf');
        $text      = '';
        $font_size = $this->width / $this->height < $this->chars_count ? $this->width / $this->chars_count - 15 : $this->height - 15;
        for ($index = 0; $index < $this->chars_count; $index += 1)
        {
            $char  = substr($this->chars_set, rand(0, strlen($this->chars_set) - 1), 1);
            $font  = $fonts[rand(0, count($fonts) - 1)];
            $color = hexdec($this->colors[rand(0, count($this->colors) - 1)]);
            $x     = intval(($this->width / $this->chars_count) * $index);
            $angle = rand(-20, 20);
            imagettftext($this->image, $font_size, $angle, $x, ($this->height / 2) + ($font_size / 2), $color, $font, $char);
            $text .= $char;
        }
        return $text;
    }

    private function setSession($text)
    {
        if (!isset($_SESSION[$this->session_key]))
        {
            $_SESSION[$this->session_key] = array();
        }
        $_SESSION[$this->session_key] = $text;
    }

    private function outputPNG()
    {
        header('Content-Type: image/png');
        imagepng($this->image);
        imagedestroy($this->image);
    }

}
