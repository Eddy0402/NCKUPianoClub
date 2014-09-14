<?php

namespace Activity\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

class PostTable
{

    protected $tableGateway;
    protected $alterUrlTableGateway;

    public function __construct( TableGateway $tableGateway, $alterUrlTableGateway ) {
        $this -> tableGateway = $tableGateway;
        $this -> alterUrlTableGateway = $alterUrlTableGateway;
    }

    public function fetchAll() {
        $resultSet = $this -> tableGateway -> select();
        return $resultSet -> buffer();
    }

    public function getPageCount( $pagesize ) {
        $sql = new Sql( $this -> tableGateway -> getAdapter() );
        $select = $sql -> select();
        $select -> columns( array( 'num' => new Expression( 'COUNT(*)' ) ) );
        $select -> from( 'activity' );
        $num = $sql -> prepareStatementForSqlObject( $select ) -> execute() -> current()[ 'num' ];
        return floor( ($num + $pagesize - 1) / $pagesize );
    }

    public function fetchAllInPage( $page, $pagesize ) {
        $resultSet = $this -> tableGateway -> select( function(Select $select)use($page, $pagesize) {
            $select -> order( array( 'sticky_posts desc', 'time desc' ) );
            $select -> offset( ($page - 1) * $pagesize );
            $select -> limit( $pagesize );
            $select -> join( 'user', 'user_id = activity.uid' );
        } );
        return $resultSet -> buffer();
    }

    public function getCategoryPageCount( $category, $pagesize ) {
        $sql = new Sql( $this -> tableGateway -> getAdapter() );
        $select = $sql -> select();
        $select -> columns( array( 'num' => new Expression( 'COUNT(*)' ) ) );
        $select -> where( array( 'category' => $category ) );
        $select -> from( 'activity' );
        $num = $sql -> prepareStatementForSqlObject( $select ) -> execute() -> current()[ 'num' ];
        return floor( ($num + $pagesize - 1) / $pagesize );
    }

    public function fetchByCategoryInPage( $category, $page, $pagesize ) {
        $resultSet = $this -> tableGateway -> select( function(Select $select)use($category, $page, $pagesize) {
            $select -> where( array( 'category' => $category ) );
            $select -> order( array( 'sticky_posts desc', 'time desc' ) );
            $select -> offset( ($page - 1) * $pagesize );
            $select -> limit( $pagesize );
            $select -> join( 'user', 'user_id = activity.uid' );
        } );
        return $resultSet -> buffer();
    }

    public function getPostByUrl( $url ) {
        $resultSet = $this -> tableGateway -> select( function(Select $select)use($url) {
            $select -> where( array( 'url' => $url ) );
            $select -> where( array( 'value' => $url ), \Zend\Db\Sql\Predicate\PredicateSet::OP_OR );
            $select -> group( 'id' );
            $select -> join( 'user', 'user_id = activity.uid' );
            $select -> join( 'activity_alterurl', 'postid = activity.id', '*', Select::JOIN_LEFT );
        } );
        if ( $resultSet -> count() > 1 ) {
            $resultSet -> current() -> id;
            while ( $resultSet -> current() ) {
                $resultSet -> current() -> id;
                $resultSet -> next();
            }
            throw new \Exception( 'Duplicate Entry' );
        }
        return $resultSet -> current();
    }

    public function isUrlOccupiedByOther( $url, $selfid ) {
        $sql = new Sql( $this -> tableGateway -> getAdapter() );
        $select = $sql -> select();
        $select -> columns( array( 'num' => new Expression( 'COUNT(*)' ) ) );
        $select -> from( 'activity' );
        $select -> join( 'activity_alterurl', 'postid = activity.id', '*', Select::JOIN_LEFT );
        $select -> where( new \Zend\Db\Sql\Predicate\NotLike( 'id', $selfid ) );
        $select -> where( array( 'url' => $url ) );
        $select -> where( array( 'value' => $url ), \Zend\Db\Sql\Predicate\PredicateSet::OP_OR );

        if ( $sql -> prepareStatementForSqlObject( $select ) -> execute() -> current()[ 'num' ] > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostById( $id ) {
        $resultSet = $this -> tableGateway -> select( function(Select $select)use($id) {
            $select -> where( array(
                'id' => $id,
            ) );
        } );
        return $resultSet -> current();
    }

    public function savePost( Post $post ) {
        $data = array(
            'uid' => ( int ) $post -> uid,
            'category' => $post -> category,
            'title' => $post -> title,
            'summary' => $post->summary,
            'content' => $post -> content,
            'sticky_posts' => ( int ) $post -> sticky_posts,
            'url' => $post -> url,
        );
        $target = $this -> getPostById( $post -> id );
        if ( $target ) {
            while ( $this -> isUrlOccupiedByOther( $post -> url, $post -> id ) ) {
                $post -> url = $post -> url . rand( 0, 9 );
                $data[ 'url' ] = $post -> url;
            }
            $this -> tableGateway -> update( $data, array( 'id' => ( int ) $target -> id ) );
            if ( $target -> url != $post -> url ) {
                $this -> alterUrlTableGateway -> insert( array(
                    'postid' => $target -> id,
                    'value' => $target -> url,
                ) );
            }
        } else {
            while ( $this -> isUrlOccupiedByOther( $post -> url, $post -> id ) ) {
                $post -> url = $post -> url . rand( 0, 9 );
                $data[ 'url' ] = $post -> url;
            }
            $this -> tableGateway -> insert( $data );
        }
    }

    public function deleteRecord( Post $post ) {
        $this -> tableGateway -> delete( array( 'id' => $post -> id ) );
    }

}
