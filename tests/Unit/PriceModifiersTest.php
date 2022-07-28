<?php
namespace App\Tests\Unit;

use App\DTO\LowestPriceEnquiry;
use App\Tests\ServiceTestCase;
use App\Entity\Promotion;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\EvenItemsMultiplier;
use App\Filter\Modifier\FixedPriceVoucher;

class PriceModifiersTest extends ServiceTestCase
{
    /** @test */
    public function DateRangeMultiplier_returns_a_correctly_modified_price() : void
        {
            $enquiry = new LowestPriceEnquiry;
            $enquiry -> setQuantity(5);
            //$enquiry -> setPrice(100);
            $enquiry -> setRequestDate('2022-11-27');

            $promotion = new Promotion();
            $promotion -> setName('Black friday half price sale');
            $promotion -> setAdjustment(0.5);
            $promotion -> setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
            $promotion -> setType('date_range_multiplier');

            $dateRangeModifier = new DateRangeMultiplier();
            
            $modifiedPrice = $dateRangeModifier -> modify(100, 5, $promotion, $enquiry);

            $this -> assertEquals(250, $modifiedPrice); 
        }
    
    /** @test */    
    public function FixedPriceVocuher_returns_a_correctly_modified_price(): void
        {
            $enquiry = new LowestPriceEnquiry;
            $enquiry -> setQuantity(5);
            // //$enquiry -> setPrice(100);
            // $enquiry -> setRequestDate('2022-11-3');
            $enquiry -> setVoucherCode('OU812');

            $promotion = new Promotion();
            $promotion -> setName('Voucher OU812');
            $promotion -> setAdjustment(100);
            $promotion -> setCriteria(["code" => "OU812"]);
            $promotion -> setType('fixed_price_voucher');

            $fixedPriceVoucher = new FixedPriceVoucher();
            $modifiedPrice = $fixedPriceVoucher -> modify(150, 5, $promotion, $enquiry);

            $this -> assertEquals(500, $modifiedPrice);

        }

    /** @test */  
    public function EvenItemsMultiplier_returns_a_correctly_modified_price(): void
        {
            $enquiry = new LowestPriceEnquiry;
            $enquiry -> setQuantity(5);
            $enquiry -> setPrice(100);
            
            $promotion = new Promotion();
            $promotion -> setName('Buy one get one free');
            $promotion -> setAdjustment(0.5);
            $promotion -> setCriteria(["minimum_quantity" => 2]);
            $promotion -> setType('even_items_multiplier');

            $evenItemsMultiplier = new EvenItemsMultiplier();
            $modifiedPrice = $evenItemsMultiplier -> modify(200, 5, $promotion, $enquiry);
            $this -> assertEquals(600, $modifiedPrice);

        }
        
        /** @test */  
    public function EvenItemsMultiplier_correctly_calculates_alternatives(): void
    {
        $enquiry = new LowestPriceEnquiry;
        $enquiry -> setQuantity(5);
        $enquiry -> setPrice(100);
        
        $promotion = new Promotion();
        $promotion -> setName('Buy one get one free');
        $promotion -> setAdjustment(0.75);
        $promotion -> setCriteria(["minimum_quantity" => 2]);
        $promotion -> setType('even_items_multiplier');

        $evenItemsMultiplier = new EvenItemsMultiplier();
        $modifiedPrice = $evenItemsMultiplier -> modify(200, 5, $promotion, $enquiry);
        $this -> assertEquals(800, $modifiedPrice);

    }
        

}