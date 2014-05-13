<?php

class Test extends CI_Controller {
    
    public function index() {
        
        $this->load->library("zcms/zcms");
        $this->zcms->init();
        
        $this->zcms->load_headers();
        $this->zcms->load_js();

        $this->zcms->interface->load_interface('form');    
        $this->interface->form->init('mod_test_adv', (object)array("where" => array("t1.id" => 2)))
             ->add_field('param1',array(
                 'type' => 'text',
                 'disabled_on_update' => FALSE,
                 'label' => 'Module',
                 'validation' => 'required'
             ))
             ->add_submit(array(
                 'label' => 'Save',
                 'css_class' => 'btn btn-primary btn-large'
             ))
             ->modify()
             ->set_redirect()
             ->render();

        $this->zcms->load_footers();
    }
    
    
    public function test_list($p = NULL, $ord = NULL, $dir = NULL) {

        $this->load->library("zcms/zcms");
        $this->zcms->init();
        
        $this->zcms->load_headers();
        $this->zcms->load_js();

        $this->zcms->interface->load_interface('list');    
        $this->zcms->interface->list
             ->set('rows_per_page', 10)
             ->set('page', $p)
             ->set('order_column', $ord)
             ->set('order_direction', $dir)
             ->set('search', $this->input->get('search'))
             ->set('link_show_table', 0)
             ->set('link_mode', "uri")
             ->add_column(array(
                 "name" => "id",
                 "label" => "#"
             ))
             ->add_column(array(
                 "name" => "page_id",
                 "label" => "Id",
             ))
             ->add_column(array(
                 "name" => "title",
                 "label" => "Title"
             ))
             ->add_label(array(
                 'type' => 'alert',
                 'cond' => '{@id} < 3',
                 'text' => 'Test'
             ))
             ->add_search_column("title")
             ->add_search_column("keywords")
             ->add_search_column("description")
             ->add_search_column("html")
             ->add_search_column("page_id")
             ->add_action(array(
                 "link" => "pages/modify/{@id}",
                 "label" => "Edit"
             ))
             ->set_global_action("pages/modify")
             ->init('zcms_pages')
             ->render();
        
        //$this->zcms->interface->list->set_links(0,0);
        //$this->zcms->interface->list->render();
        
        $this->zcms->load_footers();
    }
}
