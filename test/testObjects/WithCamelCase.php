<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace Test\TestObjects;


use UnexpectedValueException;

final class WithCamelCase implements ValueObject
{
    private string $camelCased;

    public function __construct (
        string $camelCased
    ) {
        $this->camelCased = $camelCased;
    }
    
    public function getCamelCased(): string 
    {
        return $this->camelCased;
    }
    
    public function withCamelCased(string $camelCased): self 
    {
        return new self(
            $camelCased
        );
    }
    
    public function toArray(): array
    {
        return [
            'camelCased' => $this->camelCased,
        ];
    }
    
    public static function fromArray(array $array): self
    {
        if (!array_key_exists('camelCased', $array)) {
            throw new UnexpectedValueException('Array key camelCased does not exist');
        }
        
        return new self(
            $array['camelCased']
        );
    }
        
    private function valueToArray($value)
    {
        if (method_exists($value, 'toArray')) {
            return $value->toArray();
        }
        
        return (string) $value;
    }    
    public function equals($value): bool
    {
        $ref = $this->toArray();
        $val = $value->toArray();
        
        return ($ref === $val);
    }
}