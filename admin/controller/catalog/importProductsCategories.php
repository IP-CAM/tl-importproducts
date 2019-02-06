<?php

class ControllerCatalogImportProductsCategories extends Controller
{

    private $img_extension = '.png';


    protected function getAllDataFromCsv( String $filename ): array
    {
        // paso el .csv a un array
        $products = array();
        $item = 0;
        if (($handle = fopen('/var/www/html/telas/docs/' . $filename, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                $num = count($data);
                for ($c=0; $c < $num; $c++) {
                    $product[$c] = trim($data[$c]);
                }

                $all_data[$item] = $product;
                $item++;
            }
            fclose($handle);
        }

        return $all_data;
    }

    // por cada producto que nos pasan, debemos generar nuevos productos identicos, pero se diferencian por URL SEO.
    // por ejemplo. Si un producto tiene 3 URL SEO, vamos a devolver tres productos identicos, pero con URL SEO diferentes.
    protected function separateProductBySeo( Array $products): array
    {
        $all_products = [];
        foreach ($products AS $k => $product)
        {
            $url_seos           = $this->separateUrlsSeos($product);
            $separate_products  = $this->createNewProductsBySeo( $products[$k], $url_seos);
            $all_products       = $this->addProductsInArray($all_products, $separate_products);
        }

        return $all_products;
    }

    protected function separateUrlsSeos(Array $product)
    {
        $url_seos = explode(",", $product[23]);
        foreach ($url_seos AS $k=>$url)
        {
            if (strlen($url) < 4) {
                unset($url_seos[$k]);
            } else {
                $url_seos[$k] = trim(str_replace('/','', $url));
            }
        }

        return $url_seos;
    }



    protected function addProductsInArray( Array $allproducts, Array $separate_products): array
    {

        end($allproducts);
        $k = key($allproducts);

        foreach ($separate_products AS $product)
        {
            $k++;
            $allproducts[$k] = $product;
        }

        return $allproducts;
    }



    protected function createNewProductsBySeo( Array $product, Array $seos ): array
    {
        $all_products = [];
        $k_newproduct = 0;
        foreach ($seos AS $k_url => $seo)
        {
            $all_products[$k_newproduct] = $product;
            $all_products[$k_newproduct][23] = trim($seo);
            $k_newproduct++;
        }

        return $all_products;
    }


    protected function getProductToInsert( Array $prod): array
    {
        // idioma español
        $data["product_description"][2]["name"]         = $prod[1];
        $data["product_description"][2]["description"]  = $this->getProductDescription();
        $data["product_description"][2]["meta_title"]   = $prod[13];
        $data["product_description"][2]["meta_description"]= $prod[14];
        $data["product_description"][2]["meta_keyword"] = $prod[15];
        $data["product_description"][2]["tag"]          = "";

        // idioma ingles, lo agregamos para que no haya errores si editamos manualmente
        $data["product_description"][1]["name"]         = $prod[1];
        $data["product_description"][1]["description"]  = $this->getProductDescription();
        $data["product_description"][1]["meta_title"]   = $prod[13];
        $data["product_description"][1]["meta_description"]= $prod[14];
        $data["product_description"][1]["meta_keyword"] = $prod[15];
        $data["product_description"][1]["tag"]          = "";

        $data["model"]                       = $prod[1];
        $data["sku"]                         = "";
        $data["upc"]                         = "";
        $data["ean"]                         = "";
        $data["jan"]                         = "";
        $data["isbn"]                        = "";
        $data["mpn"]                         = "";
        $data["location"]                    = "";
        $data["price"]                       = str_replace(',','.',$prod[7]);
        $data["tax_class_id"]                = "0"; // va string en 0
        $data["quantity"]                    = "99999999";
        $data["minimum"]                     = "1";
        $data["subtract"]                    = "1";
        $data["stock_status_id"]             = "6";
        $data["shipping"]                    = "1";
        $data["date_available"]              = "2018-12-10";
        $data["length"]                      = "1"; // largo, entiendo que esto depende de la cantidad
        $data["width"]                       = self::set_width($prod[2]); //ancho
        $data["height"]                      = "1"; // alto. entiendo que es infimo por que son telas.
        $data["length_class_id"]             = "1"; // 1 es centimetros seteadas las dimensiones
        $data["weight"]                      = $prod[16]; // el peso por cada metro en gramos
        $data["weight_class_id"]             = "2"; // 2 es en gramos que es lo que vamos a usar para medir cada metro de tela.
        $data["status"]                      = "1";
        $data["sort_order"]                  = "0";
        $data["manufacturer"]                = "";
        $data["manufacturer_id"]             = "0";
        $data["category"]                    = [];

        // por el momento harckodeo categorias.
        // $data['product_category']             = self::set_categories($prod[18], $prod[1]);
        $data['product_category']            = [];

        $data['product_discount'][0]['customer_group_id'] = '1';
        $data['product_discount'][0]['quantity'] = '10';
        $data['product_discount'][0]['priority'] = '';
        $data['product_discount'][0]['price'] = str_replace(',','.',$prod[6]);
        $data['product_discount'][0]['date_start'] = '';
        $data['product_discount'][0]['date_end'] = '';

        $data['product_discount'][1]['customer_group_id'] = '1';
        $data['product_discount'][1]['quantity'] = '20';
        $data['product_discount'][1]['priority'] = '';
        $data['product_discount'][1]['price'] = str_replace(',','.',$prod[5]);;
        $data['product_discount'][1]['date_start'] = '';
        $data['product_discount'][1]['date_end'] = '';


        $data['product_discount'][2]['customer_group_id'] = '1';
        $data['product_discount'][2]['quantity'] = '100';
        $data['product_discount'][2]['priority'] = '';
        $data['product_discount'][2]['price'] = str_replace(',','.',$prod[4]);;
        $data['product_discount'][2]['date_start'] = '';
        $data['product_discount'][2]['date_end'] = '';


        $data["filter"]                      = "";
        $data["product_store"][0]            = "0";
        $data["download"]                    = "";
        $data["related"]                     = "";
        $data["option"]                      = "";
        // $data["image"]                       = "data/telas/" . $prod[18];
        $data["image"]                      = $this->getFirstImage($prod[23]);
        $data["points"]                      = "";
        $data["product_reward"][1]["points"] = "0";
        $data["product_seo_url"][0][2]       = $prod[23]; // para los dos idiomas  CASTELLANO
        $data["product_seo_url"][0][1]       = $prod[23] . '-en'; // para los dos idiomas INGLES
        $data["product_layout"][0]           = "";

        $data['product_image']              = $this->getImages($prod[23]);



        return $data;
    }

    private function getProductDescription()
    {
        return '<div class="product-info-container-am ">
                          <div class="product-label-am">
                            <div class="box-wrap-am">
                              <div class="price-box-am ">
                                <div class="price-title-am"> <span>Por menor<br>
                                  <span class="price-subtitle-am desktop-am">A partir de 1 kilo</span> <span class="price-subtitle-am mobile-am">Por 1 kg.</span> </span> </div>
                                <div class="price-container-regular-am "> <span class="regular-price-am"> <span class="price-am">$759,00</span> </span> </div>
                                <br clear="all">
                                <ul class="tiered-prices-list-am">
                                  <li>
                                    <div class="price-title-am"> <span>Por mayor<br>
                                      <span data-dialog="El precio por mayor se aplica a la compra de 5 kilos del mismo color o diseño" class="tooltip-info-am"><span></span></span> <span class="price-subtitle-am desktop-am">A partir de 5 kilos </span> <span class="price-subtitle-am mobile-am">Más de 5 kgs. </span> </span> </div>
                                    <div class="price-container-tiered-am"> <span class="price-am">$649,00</span> </div>
                                    <br clear="all">
                                  </li>
                                  <li>
                                    <div class="price-title-am"> <span>Por pieza<br>
                                      <span data-dialog="El precio por pieza se aplica a cantidades múltiplos de 20. - Ej.: 20, 40, 60, 80, etc." class="tooltip-info-am"><span></span></span> <span class="price-subtitle-am desktop-am">Piezas de 20 kilos </span> <span class="price-subtitle-am mobile-am">Pza. de 20 kgs. </span> </span> </div>
                                    <div class="price-container-tiered-am"> <span class="price-am">$529,00</span> </div>
                                    <br clear="all">
                                  </li>
                                </ul>
                              </div>

                              <span class="price-disclaimer-am">Precios por kilo. IVA incluido.</span> </div>
                          </div>

                          <div class="uses-container-am ">
                            <h4><strong>Usos</strong></h4>
                            <div class="blockquote-am">
                              <div class="inside-am">
                                <p>Vestidos, remeras, soleros</p>
                              </div>
                            </div>
                          </div>
                        </div>';
    }


    protected function getCategoryToInsert( Array $tela, int $parentid = 0 ): array
    {
        $data['category_description'][2]['name']            = $tela[0];
        $data['category_description'][2]['description']     = $tela[1];
        $data['category_description'][2]['meta_title']      = $tela[2];
        $data['category_description'][2]['meta_description']= $tela[3];
        $data['category_description'][2]['meta_keyword']    = $tela[4];
        $data['category_description'][1]['name']            = $tela[0];
        $data['category_description'][1]['description']     = $tela[1];
        $data['category_description'][1]['meta_title']      = $tela[2];
        $data['category_description'][1]['meta_description']= $tela[3];
        $data['category_description'][1]['meta_keyword']    = $tela[4];
        $data['path']       = '';
        $data['parent_id']  = $parentid;
        $data['filter']     =  '';
        $data['category_store'][0]  = '0';
        $data['image']      = 'data/telas/' . $tela[5] . $this->img_extension;
        $data['column']     = '';
        $data['sort_order'] = '0';
        $data['status']     = '1' ;
        $data['category_seo_url'][0][2] = $tela[6];
        $data['category_seo_url'][0][1] = $tela[6] . '-en';
        $data['category_layout'][0] = '';

        return $data;
    }

    protected function getImages( string $seo ): array
    {
        return [
                    [ "image" => 'data/telas/' . $seo . '-b' . $this->img_extension, "sort_order" => 1 ],
                    [ "image" => 'data/telas/' . $seo . '-c' . $this->img_extension, "sort_order" => 2 ],
                    [ "image" => 'data/telas/' . $seo . '-d' . $this->img_extension, "sort_order" => 3 ],
                    [ "image" => 'data/telas/' . $seo . '-e' . $this->img_extension, "sort_order" => 4 ]
            ];
    }



    protected function getFirstImage( string $seo): string
    {
        return trim('data/telas/' . $seo . '-a' . $this->img_extension);
    }


    // nos devuelve el ancho en centímetros. Es pasado como parámetro en metros con coma como separador.
    static function set_width( $width )
    {
        // width ejemplo 1,60
        // y lo tenemos que dejar en 160
        // por que está en centimetro
        $width = str_replace(',','.',$width);
        $width = (float)$width * 100;

        return (int)$width;
    }

    // nos devuelve el array con el id de las categorias.
    static function set_categories( $categories, $name_product )
    {
        // debajo como pasar el array de categoria

        $categories = trim($categories);

        $keys_cat['blanco']           = 172;
        $keys_cat['moda']             = 59;
        $keys_cat['ofertas']          = 173;
        $keys_cat['telas-por-nombre'] = 170;
        $keys_cat['telas-por-uso']    = 171;

        $categories_words = explode(",", $categories);

        foreach ($categories_words AS $name_cat)
        {
            $name_cat = trim(strtolower($name_cat));
            if ( $name_cat == 'blanco') {
                $add_category[] = $keys_cat['blanco'];
            } else if ( $name_cat == 'moda' ) {
                $add_category[] = $keys_cat['moda'];
            } else if ( $name_cat == 'ofertas') {
                $add_category[] = $keys_cat['ofertas'];
            } else if ( $name_cat == 'telas por nombre' ) {
                $add_category[] = $keys_cat['telas-por-nombre'];
            } else if ( $name_cat == 'telas por uso' ) {
                $add_category[] = $keys_cat['telas-por-uso'];
            } else {
                echo 'ERROR FATAL, no detecta la categoria ' . $name_cat .  ' en producto ' . $name_product;
                exit(1);
            }
        }

        return ($add_category);

    }



}



// así hay que pasarlo el producto





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










        // array para insertar categorias
        //array (
        //   'category_description' =>
        //   array (
        //     2 =>
        //     array (
        //       'name' => 'nombre espaniolll',
        //       'description' => '<p>descripcion espaniolll</p>',
        //       'meta_title' => 'el metata titulo',
        //       'meta_description' => 'meta descripcion',
        //       'meta_keyword' => 'meta palabras',
        //     ),
        //     1 =>
        //     array (
        //       'name' => 'nombre en ingles',
        //       'description' => '<p>descrpcion en ingles&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>',
        //       'meta_title' => 'meta titulo',
        //       'meta_description' => 'meta descripcion',
        //       'meta_keyword' => 'meta palabras',
        //     ),
        //   ),
        //   'path' => 'Telas por nombre',
        //   'parent_id' => '170',
        //   'filter' => '',
        //   'category_store' =>
        //   array (
        //     0 => '0',
        //   ),
        //   'image' => '',
        //   'column' => '1',
        //   'sort_order' => '0',
        //   'status' => '1',
        //   'category_seo_url' =>
        //   array (
        //     0 =>
        //     array (
        //       2 => 'jean',
        //       1 => 'jean-en',
        //     ),
        //   ),
        //   'category_layout' =>
        //   array (
        //     0 => '',
        //   ),
        // )

        //fin array de las categorias.




