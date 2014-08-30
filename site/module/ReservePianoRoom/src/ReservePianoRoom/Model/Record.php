<?php

namespace ReservePianoRoom\Model;

class Record
{

	public $reserve_id = 0;
	public $room;
	public $date;
	public $class;
	public $uid;
	public $flag;
	public $comment;

	public function exchangeArray( $data ) {
		$this -> reserve_id = (!empty( $data[ 'reserve_id' ] )) ? $data[ 'reserve_id' ] : null;
		$this -> room= (!empty( $data[ 'room' ] )) ? $data[ 'room' ] : null;
		$this -> date = (!empty( $data[ 'date' ] )) ? $data[ 'date' ] : null;
		$this -> class = (!empty( $data[ 'class' ] )) ? $data[ 'class' ] : null;
		$this -> uid = (!empty( $data[ 'uid' ] )) ? $data[ 'uid' ] : null;
		$this -> flag = (!empty( $data[ 'flag' ] )) ? $data[ 'flag' ] : null;
		$this -> comment = (!empty( $data[ 'comment' ] )) ? $data[ 'comment' ] : null;
	}

}
