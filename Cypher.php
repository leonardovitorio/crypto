<?php

namespace stools\Crypto;

interface Cypher{
    public function encode(string $value):string;
    public function decode(string $value):string;
}