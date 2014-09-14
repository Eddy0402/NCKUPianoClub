<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Activity\Form;

use Zend\InputFilter\InputFilter;

/**
 * Description of NewPostFormInputFilter
 *
 * @author eddy
 */
class NewPostFormInputFilter extends InputFilter
{
	public function __construct() {
		$this->add(	array(
			'name'     => 'title',
			'required' => true,
		));

		$this->add(	array(
			'name'     => 'content',
			'required' => true,
		));
		
		$this->add( array(
			'name'     => 'category',
			'required' => true,
			'validators' => array(
				array(
					'name'    => 'Zend\Validator\Between',
					'options' => array(
						'min'      => 1,
						'max'      => 3,
						'inclusive' => true,
					),
				),
			),
		));
		
	}
}
