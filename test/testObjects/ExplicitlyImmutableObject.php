<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace Test\TestObjects;

use UnexpectedValueException;
use InvalidArgumentException;

final class ExplicitlyImmutableObject
{
    private string $foo;

    public function __construct (
        string $foo
    ) {
        $this->foo = $foo;
    }
    
    public function getFoo(): string 
    {
        return $this->foo;
    }
    
    public function withFoo(string $foo): self 
    {
        return new self(
            $foo
        );
    }
    
    public function toArray(): array
    {
        return [
            'foo' => $this->foo,
        ];
    }
    
    public static function fromArray(array $array): self
    {
        if (!array_key_exists('foo', $array)) {
            throw new UnexpectedValueException('Array key foo does not exist');
        }
        
        return new self(
            $array['foo']
        );
    }
        
    private function valueToArray($value)
    {
        if (method_exists($value, 'toArray')) {
            return $value->toArray();
        }
        
        return (string) $value;
    }    
    public function equals($value)
    {
        $ref = $this->toArray();
        $val = $value->toArray();
        
        return ($ref === $val);
    }
}