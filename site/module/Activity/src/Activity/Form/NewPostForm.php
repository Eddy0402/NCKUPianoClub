<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Activity\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterInterface;

/**
 * Description of NewPostForm
 *
 * @author eddy
 */
class NewPostForm extends Form
{
	public function __construct( InputFilterInterface $inputFilter) {
		parent::__construct('new_post');

		$this-> setInputFilter($inputFilter);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'value' => '0'
            )
        ));
        
		$this->add(array(
            'name' => 'title',
            'options' => array(
                'label' => _('Title'),
            ),
            'type'  => 'Text',
        ));
		
		$this->add(array(
            'name' => 'content',
            'options' => array(
                'label' => _('Content'),
            ),
            'type'  => 'Textarea',
        ));
						
		$this->add(array(
            'name' => 'category',
            'options' => array(
                'label' => _('Category'),
				'empty_option' => 'Uncategorized',
                'value_options' => array(
                    '1' => _('Uncategorized'),
                    '2' => _('Activity'),
					'3' => _('Lecture'),
                ),
            ),
			'type' => 'Zend\Form\Element\Radio',
		));
		
		$this->add(array(
			'type' => 'CheckBox',
			'name' => 'sticky_posts',
			'options' => array(
                'label' => _('Is Sticky Post'),
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            )
		));
		
		$this->add(array(
			'type' => 'Zend\Form\Element\Csrf',
			'name' => 'csrf',
			'options' => array(
				'csrf_options' => array(
					'timeout' => 1800,
				)
			)
		));
		
        $this->add(array(
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => array(
                'value' => _('Submit'),
            ),
        ));	

	}
	
}

/* Translate warpper */
function _($str){
	return $str;
}