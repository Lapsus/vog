<?php

declare(strict_types=1);

namespace Test\TestObjects;

final class Cuisine
{

	public const OPTIONS = [ "DEUTSCH" => "deutsch", "MEDITERAN" => "mediteran", "ASIATISCH" => "asiatisch", "AMERIKANISCH" => "amerikanisch", "INDISCH" => "indisch",];

	public const DEUTSCH = 'deutsch';
	public const MEDITERAN = 'mediteran';
	public const ASIATISCH = 'asiatisch';
	public const AMERIKANISCH = 'amerikanisch';
	public const INDISCH = 'indisch';
        
    private ?string $name;
    private ?string $value;
        
    private function __construct(?string $name)
    {
        if(is_null($name)){
            $this->name = null;
            $this->value = null;
        }
        
        else{
            $this->name = $name;
            $this->value = self::OPTIONS[$name];
        }
    }


	public static function DEUTSCH(): self
	{
		return new self('DEUTSCH');
	}

	public static function MEDITERAN(): self
	{
		return new self('MEDITERAN');
	}

	public static function ASIATISCH(): self
	{
		return new self('ASIATISCH');
	}

	public static function AMERIKANISCH(): self
	{
		return new self('AMERIKANISCH');
	}

	public static function INDISCH(): self
	{
		return new self('INDISCH');
	}


    public static function fromValue(?string $input_value): self
    {
        if(is_null($input_value)){
            return new self(null);
        }
    
        foreach (self::OPTIONS as $key => $value) {
            if ($input_value === $value) {
                return new self($key);
            }
        }

        throw new \InvalidArgumentException("Unknown enum value '$input_value' given");
    }
    
    public static function fromName(?string $name): self
    {
        if(is_null($name)){
            return new self(null);
        }
    
        if(!array_key_exists($name, self::OPTIONS)){
             throw new \InvalidArgumentException("Unknown enum name $name given");
        }
        
        return new self($name);
    }

    public function equals(?self $other): bool
    {
        if($this->value === null && $other === null){
            return true;
        }
        return ($other !== null) && ($this->name() === $other->name());
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function __toString(): ?string
    {
        return $this->name;
    }

    public function toString(): ?string
    {
        return $this->name;
    }

}