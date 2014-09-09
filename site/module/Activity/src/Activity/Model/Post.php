<?php

namespace Activity\Model;

/**
 * Description of Post
 *
 * @author eddy
 */
class Post
{
	public $id;
	public $uid;
	public $category;
	public $title;
	public $content;
	public $time;
	public $sticky_posts;
	public $url;
	
	public $userData;

	public function exchangeArray( $data ) {
		$this -> id = (!empty( $data[ 'id' ] )) ? $data[ 'id' ] : null;
		$this -> uid= (!empty( $data[ 'uid' ] )) ? $data[ 'uid' ] : null;
		$this -> category= (!empty( $data[ 'category' ] )) ? $data[ 'category' ] : null;
		$this -> title = (!empty( $data[ 'title' ] )) ? $data[ 'title' ] : null;
		$this -> content = (!empty( $data[ 'content' ] )) ? $data[ 'content' ] : null;
		$this -> time = (!empty( $data[ 'time' ] )) ? $data[ 'time' ] : null;
		$this -> sticky_posts = (!empty( $data[ 'sticky_posts' ] )) ? $data[ 'sticky_posts' ] : null;
		$this -> url = (!empty( $data[ 'url' ] )) ? $data[ 'url' ] : null;
		//$this -> userData = new User();
		//$this -> userData -> exchangeArray($data);
	}
}
