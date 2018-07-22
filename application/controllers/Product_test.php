<?php
/**
 * This is the test cases for Product controller
 *
 * @category        Test
 * @subcategory     Controller
 * @author          Chandra Bhushan Sah
 * @email           chandrabhushan[dot]sah[at]live.in
 */

class Product_test extends TestCase
{    
	public function setUp()
	{
        $this->resetInstance();
	}

    /**
     * @test
     * 
     * @param int       $id
     * @param string    $expected
     * 
     * @testWith        [1, "status\":false"]
     *                  [4, "status\":true"]
     */
	public function testRestFetchRequest($id, $expected)
	{
        $this->request->setHeader('Authorization', 'Basic dGVzdHVzZXI6UGFzc0AyMTQ=');
		$output = $this->request('GET', "product/fetch", ["id" => $id]);
		$this->assertContains($expected, $output);
    }
    
    /**
     * @test
     */
	public function testAddProduct()
	{
        $this->request->setHeader('Authorization', 'Basic dGVzdHVzZXI6UGFzc0AyMTQ=');
		$output = $this->request('POST', 'product/add', [
            "name"          => "Flying Machine Men Striped Slim Fit Casual Shirt",
            "category_id"   => 3,
            "available_size"=> "L",
            "price"         => "1133.00",
            "descriptions"  => "Colour: Beige<br>100% Cotton<br>Half sleeve<br>Slim fit<br>Button down collar<br>Casual Wear",
            "image_url"     => "https://images-na.ssl-images-amazon.com/images/I/91z3Vp6epwL._UL1500_.jpg",
            "active_status" => "Y"
        ]);
		$this->assertContains("message\":\"Created Successfully\"", $output);
    }
    
    /**
     * @test
     * 
     * @param int       $id
     * @param string    $data
     * @param boolean   $expected
     * 
     * @testWith        [1, "price=1212.12&size=XL", false]
     *                  [5, "price=123.45", true]
     */
    public function testProductUpdate($id, $data, $expected)
    {
        $this->request->setHeader('Authorization', 'Basic dGVzdHVzZXI6UGFzc0AyMTQ=');
        try{
            $output = $this->request("PUT", "product/update/id/$id", $data);
        } catch (Exception $e) {
            $output = ob_get_clean();
        }
        $status = json_decode($output)->status;
        $this->assertEquals($expected, $status);
    }

    /**
     * @test
     * 
     * @param int       $id
     * @param boolean   $expected
     * 
     * @testWith        [1, false]
     *                  [31, true]
     */
    public function testProductDelete($id, $expected)
    {
        $this->request->setHeader('Authorization', 'Basic dGVzdHVzZXI6UGFzc0AyMTQ=');
        try{
            $output = $this->request("DELETE", "product/remove/id/$id");
        } catch (Exception $e) {
            $output = ob_get_clean();
        }
        $status = json_decode($output)->status;
        $this->assertEquals($expected, $status);
    }

    /**
     * @test
     * 
     * @param int       $page
     * @param string    $keyword
     * @param boolean   $expected
     * 
     * @testWith        [1, "", false]
     *                  [0, "white", true]
     *                  [2, "black", false]
     *                  [1, "whitenblack", false]
     */
    public function testProductSearch($page, $keyword, $expected)
    {
        $this->request->setHeader('Authorization', 'Basic dGVzdHVzZXI6UGFzc0AyMTQ=');
        try{
            $output = $this->request("get", "product/search/keyword/$keyword/page/$page");
        } catch (Exception $e) {
            $output = ob_get_clean();
        }
        $status = json_decode($output)->status;
        $this->assertEquals($expected, $status);
    }
}
