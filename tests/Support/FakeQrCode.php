<?php

namespace Tests\Support;

class FakeQrCode
{
    public function size($size)
    {
        return $this;
    }

    public function format($format)
    {
        return $this;
    }

    public function generate($text, $filename = false)
    {
        return 'fake-qr';
    }
}
