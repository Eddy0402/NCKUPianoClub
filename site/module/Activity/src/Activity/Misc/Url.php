<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Activity\Misc;

/**
 * Description of newPHPClass
 *
 * @author eddy
 */
class Url
{
	static public function seoFriendlyUrl( $string ){
		$string = strtolower($string);
		$string = str_replace(    
		array('!', '"', '#', '$', '%', '&', '\'', '(', ')', '*',    
			'+', ', ', '-', '.', '/', ':', ';', '<', '=', '>',    
			'?', '@', '[', '\\', ']', '^', '_', '`', '{', '|',    
			'}', '~', '；', '﹔', '︰', '﹕', '：', '，', '﹐', '、',    
			'．', '﹒', '˙', '·', '。', '？', '！', '～', '‥', '‧',    
			'′', '〃', '〝', '〞', '‵', '‘', '’', '『', '』', '「',    
			'」', '“', '”', '…', '❞', '❝', '﹁', '﹂', '﹃', '﹄'),    
		'',    
		$string);
		$string = preg_replace("/[\s-]+/", " ", $string);
		$string = preg_replace("/[\s_]/", "-", $string);
		$string = trim($string, '-');		
		
		return $string;
	}
}
