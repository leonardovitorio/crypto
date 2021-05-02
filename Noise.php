<?php

namespace stools\Crypto;

class Noise implements Cypher{

    protected Alphabet $alphabet;
    protected string $key;
    protected string $endChar;

    public function __construct(Alphabet $alphabet, string $key, string $endChar)
    {
        $this->alphabet = $alphabet;
        $this->key = $key;
        $this->endChar = $endChar;
    }

    public function encode(string $value): string
    {
        $value = $value . $this->endChar;
        $characters = str_split($value);
        $result = '';
        for($i = 0; $i < count($characters); $i++){
            $index = ($this->alphabet->getCode($characters[$i]) + $this->alphabet->getCode($this->key[$i])) % ($this->alphabet->size());           
            $result .= $this->alphabet->getChar($index);
        }
        return $result . substr($this->key,strlen($result));
    }

    public function decode(string $value): string
    {
        $characters = str_split($value);
        $result = '';
        for($i = 0; $i < count($characters); $i++){
            //$a = ($b + $c) % size
            $a = $this->alphabet->getCode($characters[$i]);
            $b = $this->alphabet->getCode($this->key[$i]);
            $index = $a - $b;
            if($index >= 0){
                $result .= $this->alphabet->getChar($index);
                $opt = 2;
            }
            else{
                $result .= $this->alphabet->getChar($this->alphabet->size() + $index);
                $opt = 3;
            }
            //echo "$opt $a $b $result " . PHP_EOL; 
        }
        return substr($result,0,strpos($result,$this->endChar));
    }
}