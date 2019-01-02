<?php
    class ModelExtensionModuleIeProCustomerGroups extends ModelExtensionModuleIePro {
        public function __construct($registry) {
            parent::__construct($registry);
        }

        public function set_model_tables_and_fields($special_tables = array(), $special_tables_description = array(), $delete_tables = array()) {
            $this->main_table = 'customer_group';
            $this->main_field = 'customer_group_id';

            $special_tables_description = array('customer_group_description');
            $delete_tables = array('customer_group_description');
            parent::set_model_tables_and_fields($special_tables, $special_tables_description, $delete_tables);
        }

        public function get_columns($configuration = array()) {
            $columns = parent::get_columns($configuration);
            return $columns;
        }

        function get_columns_formatted($multilanguage) {
            $columns = array(
                'Customer Group id' => array('hidden_fields' => array('table' => 'customer_group', 'field' => 'customer_group_id')),
                'Name' => array('hidden_fields' => array('table' => 'customer_group_description', 'field' => 'name'), 'multilanguage' => $multilanguage),
                'Description' => array('hidden_fields' => array('table' => 'customer_group_description', 'field' => 'description'), 'multilanguage' => $multilanguage),
                'Approve' => array('hidden_fields' => array('table' => 'customer_group', 'field' => 'approval')),
                'Sort order' => array('hidden_fields' => array('table' => 'customer_group', 'field' => 'sort_order')),
                'Deleted' => array('hidden_fields' => array('table' => 'empty_columns', 'field' => 'delete', 'is_boolean' => true)),
            );
            $columns = parent::put_type_to_columns_formatted($columns);
            return $columns;
        }
    }
?>