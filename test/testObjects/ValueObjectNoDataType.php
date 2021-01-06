<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace Test\TestObjects;

use UnexpectedValueException;
use InvalidArgumentException;

final class ValueObjectNoDataType
{
    private  $property;

    public function __construct (
         $property
    ) {
        $this->property = $property;
    }
    
    public function getProperty() 
    {
        return $this->property;
    }
    
    public function withProperty( $property): self 
    {
        return new self(
            $property
        );
    }
    
    public function toArray(): array
    {
        return [
            'property' =>  $this->valueToArray($this->property),
        ];
    }
    
    public static function fromArray(array $array): self
    {
        if (!array_key_exists('property', $array)) {
            throw new UnexpectedValueException('Array key property does not exist');
        }
        
        return new self(
            $array['property']
        );
    }
        
    private function valueToArray($value)
    {
        if (method_exists($value, 'toArray')) {
            return $value->toArray();
        }
        
        return (string) $value;
    }
}