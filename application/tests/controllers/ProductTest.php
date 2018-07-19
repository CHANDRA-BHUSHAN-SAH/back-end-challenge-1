<?php

class ProductTest extends TestCase {

    public function test_get_product_by_invalid_id()
    {
        $output = $this->request('GET', 'product/fetch/id/1');
        $expected = '{"status":false,"message":"No products were found!","product":{}}';
        $this->assertContains($expected, $output);
    }
}