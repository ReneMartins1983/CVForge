<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // não depende de assets compilados (Vite) ao renderizar views nos testes
        $this->withoutVite();
    }
}
