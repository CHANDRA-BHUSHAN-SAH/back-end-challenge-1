<?php
/**
 * This is the test cases for Product model
 *
 * @category        Test
 * @subcategory     Model
 * @author          Chandra Bhushan Sah
 * @email           chandrabhushan[dot]sah[at]live.in
 */
class Product_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('product/product_model');
        $this->model = $this->CI->product_model;
    }

    /**
     * @test
     * 
     * @param int       $id
     * @param string    $expected
     * 
     * @testWith        [1, "null"]
     *                  [4, "{\"id\":\"4\",\"name\":\"White T-shirt\",\"descriptions\":\"100 % cotton. Regural Fit\",\"available_size\":\"L\",\"price\":\"249.00\",\"image\":\"https://i.ebayimg.com/images/g/vTwAAOxydlFS-loL/s-l300.jpg\",\"category\":\"T-Shirts\"}"]
     */
    public function testGetProduct($id, $expected)
    {
        $output = $this->model->get_product($id);
        $this->assertEquals($expected, json_encode($output, JSON_UNESCAPED_SLASHES));
    }
    
    /**
     * @test
     * 
     * @param int       $offset
     * @param string    $expected
     * 
     * @testWith        [0, "[{\"id\":\"2\",\"name\":\"Black n White T-shirt\",\"available_size\":\"L\",\"price\":\"329.00\",\"image\":null,\"category\":\"T-Shirts\"},{\"id\":\"4\",\"name\":\"White T-shirt\",\"available_size\":\"L\",\"price\":\"249.00\",\"image\":\"https:\/\/i.ebayimg.com\/images\/g\/vTwAAOxydlFS-loL\/s-l300.jpg\",\"category\":\"T-Shirts\"},{\"id\":\"5\",\"name\":\"BlueTrouser\",\"available_size\":\"34\",\"price\":\"799.00\",\"image\":\"\",\"category\":\"Trousers\"},{\"id\":\"6\",\"name\":\"Formal Shirt\",\"available_size\":\"40\",\"price\":\"999.00\",\"image\":null,\"category\":\"Shirts\"},{\"id\":\"7\",\"name\":\"Casual Shirt\",\"available_size\":\"42\",\"price\":\"509.00\",\"image\":null,\"category\":\"Shirts\"},{\"id\":\"8\",\"name\":\"Flat-Front Slim Fit Chinos\",\"available_size\":\"34\",\"price\":\"999.00\",\"image\":\"https:\/\/www.reliancetrends.com\/medias\/sys_master\/root\/h53\/hf8\/8997003886622\/netplay-flat-front-slim-fit-chinos.jpg\",\"category\":\"Trousers\"},{\"id\":\"9\",\"name\":\"Mast & Harbour Men Blue Linen Blend Casual Trousers\",\"available_size\":\"28\",\"price\":\"1379.00\",\"image\":\"https:\/\/assets.myntassets.com\/h_640,q_90,w_480\/v1\/assets\/images\/1735987\/2017\/4\/13\/11492071605841-Mast--Harbour-Men-Blue-Trousers-9541492071605544-1.jpg\",\"category\":\"Trousers\"},{\"id\":\"10\",\"name\":\"Moda Rapido Men Grey & Black Colourblocked Round Neck T-shirt\",\"available_size\":\"S\",\"price\":\"479.00\",\"image\":\"https:\/\/assets.myntassets.com\/h_1440,q_100,w_1080\/v1\/assets\/images\/1829113\/2018\/2\/6\/11517896032192-Moda-Rapido-Men-Grey--Black-Colourblocked-Round-Neck-T-shirt-3821517896032055-1.jpg\",\"category\":\"T-Shirts\"}]"]
     *                  [10, "[]"]
     */
    public function testGetProducts($offset, $expected)
    {
        $output = $this->model->get_products($offset);
        $this->assertEquals($expected, json_encode($output, JSON_UNESCAPED_SLASHES));
        $this->assertLessThanOrEqual(REC_LIMIT, count($output));
    }

    /**
     * @test
     * 
     * @param string    $keyword
     * @param int       $offset
     * @param int       $limit
     * @param string    $expected
     * 
     * @testWith        ["black", 0, 10, "[{\"id\":\"2\",\"name\":\"Black n White T-shirt\",\"available_size\":\"L\",\"price\":\"329.00\",\"image\":null,\"category\":\"T-Shirts\"},{\"id\":\"10\",\"name\":\"Moda Rapido Men Grey & Black Colourblocked Round Neck T-shirt\",\"available_size\":\"S\",\"price\":\"479.00\",\"image\":\"https:\/\/assets.myntassets.com\/h_1440,q_100,w_1080\/v1\/assets\/images\/1829113\/2018\/2\/6\/11517896032192-Moda-Rapido-Men-Grey--Black-Colourblocked-Round-Neck-T-shirt-3821517896032055-1.jpg\",\"category\":\"T-Shirts\"}]"]
     *                  ["white", 0, 10, "[{\"id\":\"2\",\"name\":\"Black n White T-shirt\",\"available_size\":\"L\",\"price\":\"329.00\",\"image\":null,\"category\":\"T-Shirts\"},{\"id\":\"4\",\"name\":\"White T-shirt\",\"available_size\":\"L\",\"price\":\"249.00\",\"image\":\"https:\/\/i.ebayimg.com\/images\/g\/vTwAAOxydlFS-loL\/s-l300.jpg\",\"category\":\"T-Shirts\"},{\"id\":\"6\",\"name\":\"Formal Shirt\",\"available_size\":\"40\",\"price\":\"999.00\",\"image\":null,\"category\":\"Shirts\"}]"]
     *                  ["white", 1, 1, "[{\"id\":\"4\",\"name\":\"White T-shirt\",\"available_size\":\"L\",\"price\":\"249.00\",\"image\":\"https:\/\/i.ebayimg.com\/images\/g\/vTwAAOxydlFS-loL\/s-l300.jpg\",\"category\":\"T-Shirts\"}]"]
     *                  ["black&white", 0, 10, "[]"]
     */
    public function testSearchProducts($keyword, $offset, $limit, $expected)
    {
        $output = $this->model->search_products($keyword, $offset, $limit);
        $this->assertEquals($expected, json_encode($output, JSON_UNESCAPED_SLASHES));
        $this->assertLessThanOrEqual(REC_LIMIT, count($output));
    }

    /**
     * @test
     * 
     * @dataProvider dataProvider
     * 
     */
    public function testInsertProduct($data)
    {
        foreach($data as $d) {
            $id = $this->model->insert($d);
            $this->assertGreaterThan(0, $id);
        }
    }

    /**
     * @test
     * 
     * @param int       $id
     * @param string    $input
     * @param boolean   $expected
     * 
     * @testWith        [1, "{\"price\":650.00}", false]
     *                  [4, "{\"price\":639.00}", true]
     */
    public function testUpdateProduct($id, $input, $expected)
    {
        $status = $this->model->update(json_decode($input, TRUE), $id);
        $this->assertEquals($expected, $status);
    }

    /**
     * @test
     * 
     * @param int       $id
     * @param boolean   $expected
     * 
     * @testWith        [1, false]
     *                  [30, true]
     */
    public function testDeleteProduct($id, $expected)
    {
        $status = $this->model->delete($id);
        $this->assertEquals($expected, $status);
    }

    public function dataProvider()
    {
        return [
            "products" => [[
                [
                    "name"              => "Green T-Shirt for Men",
                    "available_size"    => 'XXL',
                    "price"             => "275",
                    "image_url"         => "https://5.imimg.com/data5/LV/HS/MY-18958081/mens-t-shirt-500x500.jpg",
                    "category_id"       => 1,
                    "active_status"     => "Y"
                ],
                [
                    "name"              => "Check Trousers In Slim Fit",
                    "available_size"    => 'XL',
                    "price"             => "1199.0",
                    "descriptions"      => "Material/Fabric :100% CottonSize & Fit : This brand runs true to size. To ensure the best fit, we suggest consulting the size chart.",
                    "image_url"         => "https://images.koovs.com/uploads//products/102783_55a3b9e855e481862396668de800f859_image1_zoom.jpg",
                    "category_id"       => 2,
                    "active_status"     => "Y"
                ],
            ]
        ]];
    }
}