<?php

require DIR_APPLICATION . 'controller/catalog/importProductsCategories.php';

class  ControllerCatalogImport extends ControllerCatalogImportProductsCategories
{


    // IDs de las categorias PADRES
    private $id_usos    = 195;
    private $id_telas   = 170;
    private $id_blanco  = 196;
    private $id_moda    = 59;
    private $id_ofertas = 173;


    public function importProducts()
    {

        // $json = array();
        // $this->load->language('api/order');
        // $this->load->language('catalog/product');
        // $this->document->setTitle('Importando los productos');

        $products_csv = $this->getAllDataFromCsv('telas.csv');
        $products     = $this->separateProductBySeo($products_csv);

        foreach ($products as $k => $prod)
        {
            $data = $this->getProductToInsert($prod);
            $this->insertProduct($data);
        }


        echo 'Productos Insertados Correctamente . . .';
        exit(0);

        return true;

    }

    private function insertProduct($data): bool
    {
        $this->load->language('catalog/product');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $add_product = $this->model_catalog_product->addProduct($data);
        if ( isset($add_product) && is_numeric($add_product) && $add_product > 0) {
            return true;
        }

        throw new \Exception('ERROR FATAL. No puedo crear el producto ' . $prod[0]);

    }

    public function importCategories()
    {
        // Nombres Telas
        $categories_telas_csv = $this->getAllDataFromCsv('telas-categorias-nombres.csv');
        foreach ($categories_telas_csv AS $tela)
        {
            $data = $this->getCategoryToInsert($tela, $this->id_telas);
            // echo '<strong>$data in line ' . __LINE__ . ' in filename ' . __FILE__ . '</strong> <pre>' . var_export($data, true) . '</pre>';
            $this->insertCategory( $data );
        }
        echo 'Categorias Nombres de Telas insertadas con éxito . . .<br />';

        // Usos
        $categories_usos_csv = $this->getAllDataFromCsv('telas-categorias-usos.csv');
        foreach ($categories_usos_csv AS $uso)
        {
            $data = $this->getCategoryToInsert($uso, $this->id_usos);
            // echo '<strong>$data in line ' . __LINE__ . ' in filename ' . __FILE__ . '</strong> <pre>' . var_export($data, true) . '</pre>';
            $this->insertCategory( $data );
        }
        echo 'Categorias Usos de Telas insertadas con éxito . . .<br />';

        return true;
        exit(0);
    }

    private function insertCategory($data): bool
    {
        $this->load->language('catalog/category');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/category');
        $add_category = $this->model_catalog_category->addCategory($data);
        if ( isset($add_category) && is_numeric($add_category) && $add_category > 0) {
            return true;
        }

        throw new \Exception('ERROR FATAL. No puedo crear el producto ' . $prod[0]);

    }




}