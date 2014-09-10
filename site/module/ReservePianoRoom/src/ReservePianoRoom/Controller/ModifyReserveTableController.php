<?php

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ReservePianoRoom\Model\Record;

class ModifyReserveTableController extends AbstractActionController
{

    public function modifyAction() {
        $method = $this -> params() -> fromRoute( 'method' );
        switch ( $method ) {
            case 'reserve' : return $this -> reserve();
            case 'cancel' : return $this -> cancel();
        }
    }

    private function reserve() {
        if ( !$this -> zfcUserAuthentication() -> hasIdentity() ) {
            return $this -> redirect() -> toRoute( 'zfcuser/login' );
        }

        $uid = $this -> zfcUserAuthentication() -> getIdentity() -> getId();

        $date = $this -> params() -> fromRoute( 'date' );
        $class = ( int ) $this -> params() -> fromRoute( 'class', 0 );
        $room = ( int ) $this -> params() -> fromRoute( 'room', 0 );

        $first = new \DateTime( 'this week +7 days' );
        $last = new \DateTime( 'this week +13 days' );
        $personalReserveDay = $this -> getReserveTableQuery() -> getPersonReservedCount(
            $uid, $first -> format( 'y-m-d' ), $last -> format( 'y-m-d' )
        );
        if ( $personalReserveDay >= 7 && !$this->isAdmin() ) {
            $response = $this -> getResponse();
            $response -> setContent( 'Exceed' );
            return $response;
        }

        if ( $this -> getReserveTableQuery() -> isPersonReservedInTime( $uid, $date, $class ) && !$this->isAdmin() ) {
            $response = $this -> getResponse();
            $response -> setContent( 'Only one room in a time.' );
            return $response;
        }

        $Table = $this -> getReserveTable();
        if ( $Table -> isRoomReserved( $date, $class, $room ) == false ) {
            $this -> addRecord(
                $Table, $date, $class, $room, $this -> zfcUserAuthentication() -> getIdentity() -> getId()
            );
        }
        $response = $this -> getResponse();
        $response -> setContent( 'Success' );
        return $response;
    }

    private function cancel() {
        if ( !$this -> zfcUserAuthentication() -> hasIdentity() ) {
            return $this -> redirect() -> toRoute( 'zfcuser/login' );
        }

        $uid = $this -> zfcUserAuthentication() -> getIdentity() -> getId();

        $date = $this -> params() -> fromRoute( 'date' );
        $class = ( int ) $this -> params() -> fromRoute( 'class', 0 );
        $room = ( int ) $this -> params() -> fromRoute( 'room', 0 );

        if ( $this -> getReserveTableQuery() -> isPersonReservedRoom( $uid, $date, $class, $room ) || !$this->isAdmin() ) {
            $this -> deleteRecord(
                $this -> getReserveTable(), $date, $class, $room
            );
            $response = $this -> getResponse();
            $response -> setContent( 'Success' );
            return $response;
        }
        $response = $this -> getResponse();
        $response -> setContent( 'Something error!' );
        return $response;
    }

    private function isAdmin() {
        if ( $this -> zfcUserAuthentication() -> hasIdentity() &&
            $this -> zfcUserAuthentication() -> getIdentity() -> getRole() == 1 ) {
            return true;
        } else {
            return false;
        }
    }

    private function addRecord( $Table, $date, $class, $room, $uid ) {
        $record = new Record();
        $record -> exchangeArray( array(
            'date' => $date,
            'class' => $class,
            'room' => $room,
            'uid' => $uid,
        ) );
        $Table -> saveRecord( $record );
    }

    private function deleteRecord( $Table, $date, $class, $room ) {
        $record = new Record();
        $record -> exchangeArray( array(
            'date' => $date,
            'class' => $class,
            'room' => $room,
        ) );
        $Table -> deleteRecord( $record );
    }

    public function getReserveTable() {
        if ( !$this -> ReserveTable ) {
            $sm = $this -> getServiceLocator();
            $this -> ReserveTable = $sm -> get( 'ReservePianoRoom\Model\ReserveTable' );
        }
        return $this -> ReserveTable;
    }

    public function getReserveTableQuery() {
        if ( !$this -> ReserveTableQuery ) {
            $sm = $this -> getServiceLocator();
            $this -> ReserveTableQuery = $sm -> get( 'ReservePianoRoom\Model\ReserveTableQuery' );
        }
        return $this -> ReserveTableQuery;
    }

    protected $ReserveTable;
    protected $ReserveTableQuery;

}
