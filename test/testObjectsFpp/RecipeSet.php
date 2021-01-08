<?php
/** 
 * code generated by vog
 * https://github.com/MarvinWank/vog
 */
declare(strict_types=1);

namespace Test\TestObjectsFpp;

use UnexpectedValueException;
use InvalidArgumentException;

final class RecipeSet
{        
    private array $items = [];
        
    private function __construct(array $items)
    {
        $this->items = $items;
    }
    public static function fromArray(array $items) {
        foreach ($items as $key => $item) {
            $type = gettype($item);
            switch ($type) {
                case 'object':
                    if (!$item instanceof Recipe){
                        throw new UnexpectedValueException('array expects items of Recipe but has ' . $type . ' on index ' . $key); 
                    }    
                    break;
                default:
                    if ($type !== 'Recipe') {
                        throw new UnexpectedValueException('array expects items of Recipe but has ' . $type . ' on index ' . $key);
                    }
                    break;
            }
            
        }
        return new self($items);
    }
    public function equals(?self $other): bool
    {
        $ref = $this->toArray();
        $val = $other->toArray();
                
        return ($ref === $val);
    }

    public function toArray() {
        return $this->items;
    }
    
    public function count(): int
    {
        return count($this->items);
    }

    public function add(Recipe $item): self {
        $values = $this->toArray();
        array_push($values, $item);
        return new self($values);
    }
    
    public function remove(Recipe $item): self {
        $values = $this->toArray();
        if(($key = array_search($item, $values)) !== false) {
            unset($values[$key]);
        }
        
        return new self($values);
    }
    
    public function contains(Recipe $item): bool {
        if(($key = array_search($item, $this->items)) !== false) {
            return true;
        }
        
        return false;
    }
    
}