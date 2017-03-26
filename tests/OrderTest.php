<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase {

    public function testUpdateOrder() {
        $this->visit('/orders/edit/27')
                ->type('1', 'user')
                ->type('1', 'product')
                ->type('1', 'quantity')
                ->press('Edit')
                ->seePageIs('/orders');
    }
    
    public function testDeleteOrder() {
        $this->visit('/orders/delete/27')
                ->seePageIs('/orders');
    }

}
