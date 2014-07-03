<?php

class Zcms_Frontend_Menus extends Interface_form {
    
    public function setup($form)
    {
        return $form->add_field('label',array(
                    'type' => 'text',
                    'disabled_on_update' => FALSE,
                    'label' => $this->translate->t('Label'),
                    'validation' => 'required'
                ))
                ->add_field('parent_id',array(
                    'type' => 'select',
                    'disabled_on_update' => FALSE,
                    'label' => 'Parent Id',
                    'opt_val_pairs' => array(
                        0 => $this->translate->t('New menu'),
                    ),
                    'link_table' => 'zcms_frontend_menus',
                    'link_opt_column' => 'id',
                    'link_val_column' => 'label',
                    'parent_column' => 'parent_id',
                    'validation' => ''
                ))
                ->add_field('page_id',array(
                    'type' => 'select',
                    'disabled_on_update' => FALSE,
                    'label' => 'Page',
                    'opt_val_pairs' => array(
                        0 => $this->translate->t('None'),
                    ),
                    'link_table' => 'zcms_pages',
                    'link_opt_column' => 'id',
                    'link_val_column' => 'title',
                    'validation' => ''
                ))
                ->add_submit(array(
                    'label' => $this->translate->t('Save'),
                    'css_class' => 'btn btn-primary btn-large'
                ));
    }
}

