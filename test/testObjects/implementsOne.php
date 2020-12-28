<?php

declare(strict_types=1);

namespace Test\TestObjects;

final class implementsOne implements Interface1
{
	private string $foo;
	private int $bar;

	public function __construct (
		string $foo,
		int $bar
	)
	{
		$this->foo = $foo;
		$this->bar = $bar;
	}

	public function foo(): string {
		return $this->foo;
	}

	public function bar(): int {
		return $this->bar;
	}


	public function with_foo (string $foo):self
	{
		return new self($foo,$this->bar,);
	}

	public function with_bar (int $bar):self
	{
		return new self($this->foo,$bar,);
	}
	public function toArray(): array
	{
		 return [
			 'foo' => $this->foo, 
			 'bar' => $this->bar, 
		];
	}

	public static function fromArray(array $array): self
	{
		if(!array_key_exists('foo', $array)){
			 throw new \UnexpectedValueException('Array key foo does not exist');
		}
		if(!array_key_exists('bar', $array)){
			 throw new \UnexpectedValueException('Array key bar does not exist');
		}

		return new self($array['foo'],$array['bar'],);
	}

	private function value_to_array($value)
	{
		if(method_exists($value, 'toArray')) {
			return $value->toArray();
		}
		return strval($value);
	}
}