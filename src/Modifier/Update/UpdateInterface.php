<?php

namespace App\Modifier\Update;



interface UpdateInterface
{
    public function update($object, $enquire, $wildcard);
    
    
}