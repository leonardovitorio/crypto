<?php

namespace stools\Crypto;

class Crypto{

    protected string $value; // value 
    protected string $key1; // noise
    protected string $key2; // aleatory jumper
    protected Alphabet $alphabet;

    public static function convertToCrypto(string $value, string $alphabet):Crypto
    {
        //generate random alphabet based on characters.
        $alphabet = Alphabet::generateRandom($alphabet);

        $c = new Crypto();
        $c->key1 = self::generateKey1(128, $alphabet);
        $c->key2 = self::generateKey2(128, $alphabet);
        $c->alphabet = $alphabet;

        $noise = new Noise($c->alphabet, $c->key1, '.');
        $value = $noise->encode($value);
        
        $jumper = new CircleListJumper($c->key1, $c->key2, $c->alphabet);
        $c->value = $jumper->encode($value);

        return $c;
    }

    public static function generateKey1(int $size, Alphabet $alphabet):string{
        $contra_chave = [];
        for($i =0; $i < $size; $i++){
            $contra_chave[] = $alphabet->getChar(rand(1,$alphabet->size()));
        }
        return implode('',$contra_chave);
    }

    public static function generateKey2(int $size, Alphabet $alphabet):string{
        $contra_chave = [];
        for($i =0; $i < $size; $i++){
            $contra_chave[] = $alphabet->getChar(rand(1,$alphabet->size()));
        }
        return implode('',$contra_chave);
    }

    public function getKey1():string
    {
        return $this->key1;
    }

    public function getKey2():string
    {
        return $this->key2;
    }

    public function getValue():string
    {
        return $this->value;
    }

    public function getAlphabet():string
    {
        return $this->alphabet->toCharacters();
    }

    public function getDecoded():string
    {
        $noise = new Noise($this->alphabet, $this->key1, '.');
        $jumper = new CircleListJumper($this->key1, $this->key2, $this->alphabet);
        
        $value = $jumper->decode($this->value);
        $value = $noise->decode($value);
        
        return $value;
    }
}



