<?php


use PHPUnit\Framework\TestCase;

class VogTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $vog = new Vog();
        $vog->run(__DIR__."/test_objects");
    }
}