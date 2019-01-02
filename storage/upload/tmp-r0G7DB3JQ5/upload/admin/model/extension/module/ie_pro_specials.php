<?php
    class ModelExtensionModuleIeProSpecials extends ModelExtensionModuleIePro {
        public function __construct($registry)
        {
            parent::__construct($registry);
        }

        public function set_model_tables_and_fields($special_tables = array(), $special_tables_description = array(), $delete_tables = array()) {
            $this->main_table = 'product_special';
            $this->main_field = 'product_special_id';

            parent::set_model_tables_and_fields($special_tables, $special_tables_description);
        }

        public function get_columns($configuration = array()) {
            $columns = parent::get_columns($configuration);
            return $columns;
        }

        function get_columns_formatted($multilanguage) {
            $columns = array(
                'Product special id' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'product_special_id')),
                'Product id' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'product_id'), 'product_id_identificator' => 'product_id'),
                'Customer group id' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'customer_group_id')),
                'Priority' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'priority')),
                'Price' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'price')),
                'Date start' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'date_start')),
                'Date end' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'date_end')),
                'Deleted' => array('hidden_fields' => array('table' => 'empty_columns', 'field' => 'delete', 'is_boolean' => true)),
            );
            $columns = parent::put_type_to_columns_formatted($columns);
            return $columns;
        }
    }
?>