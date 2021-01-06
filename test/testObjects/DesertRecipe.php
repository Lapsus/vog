<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace Test\TestObjects;

use UnexpectedValueException;
use InvalidArgumentException;

final class DesertRecipe extends BaseClass
{
    private bool $lactosefree;
    private bool $light;

    public function __construct (
        bool $lactosefree,
        bool $light
    ) {
        $this->lactosefree = $lactosefree;
        $this->light = $light;
    }
    
    public function getLactosefree(): bool 
    {
        return $this->lactosefree;
    }
    
    public function getLight(): bool 
    {
        return $this->light;
    }
    
    public function withLactosefree(bool $lactosefree): self 
    {
        return new self(
            $lactosefree,
            $this->light
        );
    }
    
    public function withLight(bool $light): self 
    {
        return new self(
            $this->lactosefree,
            $light
        );
    }
    
    public function toArray(): array
    {
        return [
            'lactosefree' => $this->lactosefree,
            'light' => $this->light,
        ];
    }
    
    public static function fromArray(array $array): self
    {
        if (!array_key_exists('lactosefree', $array)) {
            throw new UnexpectedValueException('Array key lactosefree does not exist');
        }
        
        if (!array_key_exists('light', $array)) {
            throw new UnexpectedValueException('Array key light does not exist');
        }
        
        return new self(
            $array['lactosefree'],
            $array['light']
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