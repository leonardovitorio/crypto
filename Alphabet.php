<?php

namespace stools\Crypto;

//$characters = "abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789!@#$%¨&*,;?._ çàáãòóãõèéìíùúÁÀÉÈÍÌÓÒÚÙ";
$characters = "abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789 .";

class Alphabet{
    public array $collection;
    public array $dictionary;

    public static function generateRandom(string $characters):Alphabet{
        $characters = str_split($characters);
        for($j=0; $j < 8; $j++){
            for($i=0; $i < count($characters); $i++){            
                $jump = rand(0,count($characters)-1);
                $temp = $characters[$i];
                $characters[$i] = $characters[($jump+$i)%(count($characters)-1)];
                $characters[($jump+$i)%(count($characters)-1)] = $temp;
            }
        }
        $alphabet = implode('',$characters);
        return new Alphabet($alphabet);
    }

    public function __construct(string $alphabet){
        $this->collection = str_split($alphabet);
        $this->dictionary = [];
        $this->generateDictionary();
    }
    private function generateDictionary():void{
        $index = 1;
        foreach($this->collection as $char){
            $this->dictionary[$char] = $index++;
        }
    }
    public function size():int{
        return count($this->collection);
    }
    public function getCode(string $char):int{
        return $this->dictionary[$char];
    }
    public function getChar(int $code):string{
        if($code === 0){
            return $this->collection[$this->size()-1];
        }
        return $this->collection[$code -1];
    }
    public function toString(array $codes)
    {
        $result = [];
        foreach($codes as $code){
            $result[] = $this->getChar($code);
        }
        return implode('',$result);
    }
    public function toCodeArray(string $value):array{
        $chars = str_split($value);
        $result = [];
        foreach($chars as $char){
            $result[] = $this->getCode($char);
        }
        return $result;
    }
    public function toCharacters():string{
        return implode('',$this->collection);
    }
    public function __toString()
    {
        return implode('',$this->collection);
    }
}