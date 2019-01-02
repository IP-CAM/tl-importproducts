
<?php

class ControllerApiProduct extends Controller
{


    public function getall()
    {

        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);


        // echo 'entramos a la API de los productos!!!';


        $json = array();


        $this->load->language('api/order');

        $json = array();

        // if (!isset($this->session->data['api_id'])) {
        // TODO::JUAMPA resolver esto, debe tener seguridad para poder utilizar la API
        if (false) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            $this->load->model('catalog/product');
            $data = array();

            $results = $this->model_catalog_product->getProducts($data);

            foreach ($results as $result)
            {
                    $data['products'][] = array(
                        'product_id'  => $result['product_id'],
                        'name'        => $result['name'],
                        'rating'      => $result['rating'],

                    );
            }

            $json['products'] = $data['products'];
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));




    }


    public function addproduct()
    {


        $json = array();
        $this->load->language('api/order');
        $this->load->language('catalog/product');
        $this->document->setTitle($this->language->get('heading_title'));





        // array(38) {
        //     ["product_description"]=> array(2) {
        //                             [2]=> array(6) {
        //                                  ["name"]=> string(24) "nombre del prod espaniol"
        //                                  ["description"]=> string(51) "<p>toda la descripcion del producto</p>"
        //                                  ["meta_title"]=> string(4) "pepe"
        //                                  ["meta_description"]=> string(0) ""
        //                                  ["meta_keyword"]=> string(0) ""
        //                                  ["tag"]=> string(0) "" }
        //                             [1]=> array(6) {
        //                                     ["name"]=> string(24) "nombre del prod espaniol"
        //                                     ["description"]=> string(61) "<p>toda la descripcion del producto<br></p>"
        //                                     ["meta_title"]=> string(24) "meta tag titulloooo engl"
        //                                     ["meta_description"]=> string(0) ""
        //                                     ["meta_keyword"]=> string(0) ""
        //                                     ["tag"]=> string(0) "" }
        //                                 }
        //     ["model"]=> string(16) "model de la tela"
        //     ["sku"]=> string(0) ""
        //     ["upc"]=> string(0) ""
        //     ["ean"]=> string(0) ""
        //     ["jan"]=> string(0) ""
        //     ["isbn"]=> string(0) ""
        //     ["mpn"]=> string(0) ""
        //     ["location"]=> string(0) ""
        //     ["price"]=> string(0) ""
        //     ["tax_class_id"]=> string(1) "0"
        //     ["quantity"]=> string(1) "1"
        //     ["minimum"]=> string(1) "1"
        //     ["subtract"]=> string(1) "1"
        //     ["stock_status_id"]=> string(1) "6"
        //     ["shipping"]=> string(1) "1"
        //     ["date_available"]=> string(10) "2018-12-10"
        //     ["length"]=> string(0) ""
        //     ["width"]=> string(0) ""
        //     ["height"]=> string(0) ""
        //     ["length_class_id"]=> string(1) "1"
        //     ["weight"]=> string(0) ""
        //     ["weight_class_id"]=> string(1) "1"
        //     ["status"]=> string(1) "1"
        //     ["sort_order"]=> string(1) "1"
        //     ["manufacturer"]=> string(0) ""
        //     ["manufacturer_id"]=> string(1) "0"
        //     ["category"]=> string(0) ""
        //     ["filter"]=> string(0) ""
        //     ["product_store"]=> array(1) {
        //                         [0]=> string(1) "0" }
        //     ["download"]=> string(0) ""
        //     ["related"]=> string(0) ""
        //     ["option"]=> string(0) ""
        //     ["image"]=> string(0) ""
        //     ["points"]=> string(0) ""
        //     ["product_reward"]=> array(1) {
        //                         [1]=> array(1) {
        //                             ["points"]=> string(0) "" } }
        //     ["product_seo_url"]=> array(1) {
        //                         [0]=> array(2) {
        //                             [2]=> string(0) ""
        //                             [1]=> string(0) "" } }
        //     ["product_layout"]=> array(1) {
        //                         [0]=> string(0) "" } }


        $data["product_description"][2]["name"]         = "nombre del prod espaniol";
        $data["product_description"][2]["description"]  = "<p>toda la descripcion del producto</p>";
        $data["product_description"][2]["meta_title"]   = "pepe";
        $data["product_description"][2]["meta_description"]= "nombre del prod espaniol";
        $data["product_description"][2]["meta_keyword"] = "nombre del prod espaniol";
        $data["product_description"][2]["tag"]          = "nombre del prod espaniol";

        $data["product_description"][1]["name"]         = "nombre del prod englishhh";
        $data["product_description"][1]["description"]  = "<p>toda la descripcion english ucto</p>";
        $data["product_description"][1]["meta_title"]   = "pepe";
        $data["product_description"][1]["meta_description"]= "nombre del prod espaniol";
        $data["product_description"][1]["meta_keyword"] = "nombre del prod espaniol";
        $data["product_description"][1]["tag"]          = "nombre del prod espaniol";

        $data["model"] = "model_telas";
        $data["sku"] = "model_telas";
        $data["upc"] = "model_telas";
        $data["ean"] = "model_telas";
        $data["jan"] = "model_telas";
        $data["isbn"] = "model_telas";
        $data["mpn"] = "model_telas";
        $data["location"] = "model_telas";
        $data["price"] = "model_telas";
        $data["tax_class_id"] = "model_telas";
        $data["quantity"] = "1";
        $data["minimum"] = "1";
        $data["subtract"] = "1";
        $data["stock_status_id"] = "6";
        $data["shipping"] = "1";
        $data["date_available"] = "2018-12-10";
        $data["length"] = "model_telas";
        $data["width"] = "model_telas";
        $data["height"] = "model_telas";
        $data["length_class_id"] = "1";
        $data["weight"] = "model_telas";
        $data["weight_class_id"] = "model_telas";
        $data["status"] = "1";
        $data["sort_order"] = "model_telas";
        $data["manufacturer"] = "model_telas";
        $data["manufacturer_id"] = "model_telas";
        $data["category"] = "model_telas";
        $data["filter"] = "model_telas";
        $data["product_store"][0] = "0";
        $data["download"] = "model_telas";
        $data["related"] = "model_telas";
        $data["option"] = "model_telas";
        $data["image"] = "model_telas";
        $data["points"] = "model_telas";
        $data["product_reward"][1]["points"] = "0";
        $data["product_seo_url"][0][2] = ""; // para los dos idiomas
        $data["product_seo_url"][0][1] = ""; // para los dos idiomas
        $data["product_layout"][0] = "";

        // echo 'vamos a insertar el producto . .. ';
        // die();


        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product');


        $this->model_catalog_product->addProduct($data);


        $json = 'entramos a agregar el producto . . .';
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

        echo $json;
        die();


        // $json['status'] = 'true';
        // $json['message'] = 'Se insertó el producto correctamente.';

        // $this->response->addHeader('Content-Type: application/json');
        // $this->response->setOutput(json_encode($json));



    }

}





















