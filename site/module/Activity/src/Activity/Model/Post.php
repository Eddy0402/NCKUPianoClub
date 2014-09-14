<?php

namespace Activity\Model;

use User\Model\User;

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
    public $summary;
    public $content;
    public $time;
    public $sticky_posts;
    public $url;
    public $userData;

    public function exchangeArray( $data ) {
        $this -> id = (!empty( $data[ 'id' ] )) ? $data[ 'id' ] : null;
        $this -> uid = (!empty( $data[ 'uid' ] )) ? $data[ 'uid' ] : null;
        $this -> category = (!empty( $data[ 'category' ] )) ? $data[ 'category' ] : null;
        $this -> title = (!empty( $data[ 'title' ] )) ? $data[ 'title' ] : null;
        $this -> summary = (!empty( $data[ 'summary' ] )) ? $data[ 'summary' ] : null;
        $this -> content = (!empty( $data[ 'content' ] )) ? $data[ 'content' ] : null;
        $this -> time = (!empty( $data[ 'time' ] )) ? $data[ 'time' ] : null;
        $this -> sticky_posts = (!empty( $data[ 'sticky_posts' ] )) ? $data[ 'sticky_posts' ] : null;
        $this -> url = (!empty( $data[ 'url' ] )) ? $data[ 'url' ] : null;
        
        $this -> userData = new User();
        $this -> userData -> exchangeArray($data);
    }

    public function getArrayCopy() {
        return array(
            'id'            => $this -> id,
            'uid'           => $this -> uid,
            'category'      => $this -> category,
            'title'         => $this -> title,
            'summary'       => $this -> summary,
            'content'       => $this -> content,
            'time'          => $this -> time,
            'sticky_posts'  => $this -> sticky_posts,
            'url'           => $this -> url,
        );
    }

}
