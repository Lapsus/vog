<?php


namespace Vog;


use UnexpectedValueException;

class ValueObjectBuilder extends AbstractBuilder
{
    private const PRIMITIVE_TYPES = ["string", "int", "float", "bool", "array"];
    private string $string_value;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->type = "valueObject";
    }

    public function setStringValue(string $string_value)
    {
        if(!array_key_exists($string_value, $this->values)){
            throw new UnexpectedValueException("Designated string value $string_value does not exist in values");
        }

        $this->string_value = $string_value;
    }

    public function getPhpCode(): string
    {
        $phpcode = $this->generateGenericPhpHeader();

        foreach ($this->values as $name => $data_type) {
            $phpcode .= <<<EOT
            
                private $data_type $$name;
            EOT;
        }

        $phpcode = $this->generateConstructor($phpcode);
        $phpcode = $this->generateGetters($phpcode);
        if ($this->is_mutable){
            $phpcode = $this->generateSetters($phpcode);
        }
        $phpcode = $this->generateWithMethods($phpcode);
        $phpcode = $this->generateToArray($phpcode);
        $phpcode = $this->generateFromArray($phpcode);
        $phpcode = $this->generateValueToArray($phpcode);

        if(isset($this->string_value)){
            $phpcode = $this->generateToString($phpcode);
        }


        $phpcode = $this->closeClass($phpcode);
        return $phpcode;
    }

    private function generateConstructor(string $phpcode): string
    {
        $phpcode .= <<<EOT
        
        
            public function __construct (
        EOT;

        foreach ($this->values as $name => $data_type) {
            $phpcode .= <<<EOT
            
                    $data_type $$name,
            EOT;
        }

        $phpcode = rtrim($phpcode, ',');
        $phpcode .= <<<ETO
        
            ) {
        ETO;
        foreach ($this->values as $name => $data_type) {
            $phpcode .= <<<ETO
            
                    \$this->$name = $$name;
            ETO;
        }
        $phpcode .= <<<ETO
        
            }
            
        ETO;

        return $phpcode;
    }

    private function generateGetters(string $phpcode): string
    {
        foreach ($this->values as $name => $data_type) {
            $functionName = 'get'.ucfirst($name);

            if ($data_type) {
                $phpcode .= <<<ETO
                
                    public function $functionName(): $data_type 
                    {
                ETO;
            } else {
                $phpcode .= <<<ETO
                
                    public function $functionName() 
                    {
                ETO;
            }
            $phpcode .= <<<EOT
            
                    return \$this->$name;
                }
                
            EOT;
        }
        return $phpcode;
    }

    private function generateSetters(string $phpcode): string
    {
        foreach ($this->values as $name => $data_type) {
            $functionName = 'set'.ucfirst($name);
            if ($data_type) {
                $phpcode .= <<<EOT
                
                    public function $functionName($data_type $$name) 
                    {
                EOT;
            } else {
                $phpcode .= <<<EOT
                
                    public function $functionName($$name) 
                    {
                EOT;
            }
            $phpcode .= <<<EOT
            
                    \$this->$name = $$name;
                }
                
            EOT;
        }
        return $phpcode;
    }

    private function generateWithMethods(string $phpcode)
    {
        foreach ($this->values as $name => $data_type) {
            $functionName = 'with'.ucfirst($name);
            $phpcode .= <<<EOT
            
                public function $functionName($data_type $$name): self 
                {
                    return new self(
            EOT;

            foreach ($this->values as $name_assigner => $data_type_assginer) {
                if ($name_assigner === $name) {
                    $phpcode .= <<<EOT
                    
                                $$name_assigner,
                    EOT;

                    continue;
                }
                $phpcode .= <<<EOT
                
                            \$this->$name_assigner,
                EOT;
            }
            $phpcode = rtrim($phpcode, ',');
            $phpcode .= <<<EOT

                    );
                }
                
            EOT;
        }

        return $phpcode;
    }

    private function generateToArray(string $phpcode): string
    {
        $phpcode .= <<<EOT
        
            public function toArray(): array
            {
                return [
        EOT;

        foreach ($this->values as $name => $datatype) {
            if (!in_array($datatype, self::PRIMITIVE_TYPES)) {
                $phpcode .= <<<EOT
                
                            '$name' =>  \$this->valueToArray(\$this->$name),
                EOT;
            } else {
                $phpcode .= <<<EOT
                
                            '$name' => \$this->$name,
                EOT;
            }
        }
        $phpcode .= <<<EOT
        
                ];
            }
            
        EOT;
        return $phpcode;
    }

    private function generateFromArray(string $phpcode): string
    {
        $phpcode .= <<<'EOT'
        
            public static function fromArray(array $array): self
            {
        EOT;

        foreach ($this->values as $name => $datatype) {
            $phpcode .= <<<EOT
            
                    if (!array_key_exists('$name', \$array)) {
                        throw new UnexpectedValueException('Array key $name does not exist');
                    }
                    
            EOT;
        }

        $phpcode .= <<<EOT
        
                return new self(
        EOT;

        foreach ($this->values as $name => $datatype) {
            $phpcode .= <<<EOT
            
                        \$array['$name'],
            EOT;
        }

        $phpcode = rtrim($phpcode, ',');
        $phpcode .= <<<EOT
        
                );
            }
            
        EOT;

        return $phpcode;
    }

    private function generateToString(string $phpcode)
    {
        $phpcode .= <<<EOT
        
            public function __toString(): string
            {
                return \$this->toString();
            }
            
            public function toString(): string
            {
                return (string) \$this->$this->string_value;
            }
            
        EOT;

        return $phpcode;
    }

    private function generateValueToArray(string $phpcode)
    {
        $phpcode .= <<<EOT
            
            private function valueToArray(\$value)
            {
                if (method_exists(\$value, 'toArray')) {
                    return \$value->toArray();
                }
                
                return (string) \$value;
            }
        EOT;

        return $phpcode;
    }
}