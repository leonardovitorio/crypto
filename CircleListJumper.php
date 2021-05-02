<?php

namespace stools\Crypto;

class CircleListJumper implements Cypher{
    public string $key1;
    public string $key2;
    public string $key3;
    public Alphabet $alphabet;
    public function __construct(string $key1, string $key2, Alphabet $alphabet){
        $this->key1 = $key1;
        $this->key2 = $key2;
        $this->alphabet = $alphabet;
    }
    public function encode(string $value):string{

        $pieces = str_split($value);
        $moves = $this->alphabet->toCodeArray($this->key2);

        for($i=0; $i < count($pieces); $i++){
            $pieces = self::replace($pieces,$i,$moves[$i%count($moves)]);
        }
        
        return implode('',$pieces);
    }
    public function decode(string $value):string{
        $pieces = str_split($value);
        $moves = $this->alphabet->toCodeArray($this->key2);

        //echo implode('',$pieces) .PHP_EOL;
        for($i = count($pieces) -1; $i >= 0; $i--){
            $pieces = self::replace($pieces,$i,$moves[$i%count($moves)]);
        }

        $result = implode('',$pieces);
        return $result;
    }

    protected static function replace(array $content, int $index, int $space):array
    {
        $max = count($content);
        $next_index = ($index + $space) % $max; 
        $temp = $content[$index];
        $content[$index] = $content[$next_index]; 
        $content[$next_index] = $temp;
        return $content;
    }
}