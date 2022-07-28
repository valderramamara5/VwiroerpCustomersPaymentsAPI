<?php

namespace App\Filter\Modifier;
use App\Entity\Promotion;
use App\DTO\PromotionEnquiryInterface;

class FixedPriceVoucher implements PriceModifierInterface
{
    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int 
    {
        $voucherCode = $enquiry -> getVoucherCode();
        $code = $promotion -> getCriteria()['code'];

        if(!($voucherCode == $code)){
            return $price * $quantity;
        }

        return ($promotion -> getAdjustment())*$quantity;
    }
}