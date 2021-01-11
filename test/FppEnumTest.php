<?php


use PHPUnit\Framework\TestCase;
use Test\TestObjectsFpp\DietStyle;

class FppEnumTest extends FppTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function es_testet_from_value()
    {
        $diet_style = DietStyle::fromName('OMNIVORE');

        $this->assertEquals("Omnivore", $diet_style->value());
        $this->assertEquals(DietStyle::OMNIVORE, $diet_style->value());
        $this->assertEquals("OMNIVORE", $diet_style->name());
    }

    /**
     * @test
     */
    public function es_testet_from_name()
    {
        $diet_style = DietStyle::fromName("VEGAN");

        $this->assertEquals("Vegan", $diet_style->value());
        $this->assertEquals("VEGAN", $diet_style->name());
    }

    /**
     * @test
     */
    public function es_testet_from_function()
    {
        $diet_style = DietStyle::VEGETARIAN();

        $this->assertEquals("Vegetarian", $diet_style->value());
        $this->assertEquals("VEGETARIAN", $diet_style->name());
    }

    /**
     * @test
     */
    public function it_tests_equals()
    {
        $diet_style = DietStyle::OMNIVORE();
        $diet_style2 = DietStyle::OMNIVORE();

        $this->assertTrue($diet_style->equals($diet_style2));
        $this->assertTrue($diet_style2->equals($diet_style));
    }
}