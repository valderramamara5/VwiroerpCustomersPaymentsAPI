<?php

namespace App\Cache;

use App\Entity\Product;
use Symfony\Contracts\Cache\CacheInterface;

use Symfony\Contracts\Cache\ItemInterface;
use App\Repository\PromotionRepository;

class PromotionCache
{
    public function __construct(private CacheInterface $cache, private PromotionRepository $repository)
    {
    }

    public function findValidForProduct(Product $product, string $requestDate)
    {
        $key = sprintf("find-valid-for-product-%d", $product -> getId());

        return $this -> cache -> get($key, function(ItemInterface $item)
        use($product, $requestDate){

            // $item -> expiresAfter(50);
            var_dump('miss');

            return $this -> repository -> findValidForProduct(
                $product, date_create_immutable($requestDate) 
            ); 
        });

    }
}