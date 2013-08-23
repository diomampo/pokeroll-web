<?php

use RedBean_Facade as R;

class Model
{
  // Bean Constants
  const USER_BEAN = 'user';
  const SESSION_BEAN = 'session';
  const BUYIN_BEAN = 'buyin';

  const MAX_COUNT = 100;

  public function __construct()
  {
    R::setup();
  }

  public function getAuthUser($u, $p)
  {
    $q = ' username = :u password = :p';
    $params = array(
      ':u' => $u,
      ':p' => $p
    );
    $result = R::findOne(self::USER_BEAN, $q, $params);
    return $result;
  }

  public function getLocations()
  {
    $q = 'SELECT location FROM ' . self::SESSION_BEAN;
    $result = R::getAll($q);
    $aLocations = array();
    foreach ($result as $row) {
      $aLocations[] = $row['location'];
    }
    return $aLocations;
  }

  public function getGames()
  {
    $q = 'SELECT DISTINCT game FROM ' . self::SESSION_BEAN;
    return R::exec($q);
  }

  public function getSessions($count=10)
  {
    if($count > self::MAX_COUNT) {
      $count = self::MAX_COUNT;
    }

    $result = R::findAll(
      self::SESSION_BEAN,
      'ORDER BY start_time LIMIT ' . $count);
    $a = array();
    foreach ($result as $session) {
      $obj = new stdClass();
      $obj->id = $session->id;
      $obj->location = $session->location;
      $obj->game = $session->game;
      $obj->start_time = $session->start_time;
      $obj->end_time = $session->end_time;
      $obj->buyin_total = $session->buyin_total;
      $obj->cashout = $session->cashout;
      $a[] = $obj;
    }
    return $a;
  }

  public function saveSession($value)
  {
    $session = R::dispense(self::SESSION_BEAN);
    $session->location = $value->location;
    $session->game = $value->game;
    $session->start_time = $value->start_time;
    $session->end_time = $value->end_time;
    $session->buyin_total = 0;
    $session->cashout = $value->cashout;

    $session_id = R::store($session);

    if( isset($value->buyins) ) {
      foreach($value->buyins as $buyin) {
        $buyinBean = $this->saveBuyin($session_id, $buyin);
      }
    }
    //we need an updated copy after the total has been added
    $session = R::load(self::SESSION_BEAN, $session_id);
    return $session;
  }

  protected function updateSessionBuyinTotal($session_id)
  {
    $session = R::load(self::SESSION_BEAN, $session_id);

    $buyins = $this->getBuyins($session->id);
    $newTotal = 0;
    foreach($buyins as $buyin) {
      $newTotal += $buyin->amount;
    }

    $session->buyin_total = $newTotal;
    R::store($session);
  }

  public function saveBuyin($session_id, $value)
  {
    //save this buyin associated with the session
    $buyin = R::dispense(self::BUYIN_BEAN);
    $buyin->session_id = $session_id;
    $buyin->amount = $value->amount;
    R::store($buyin);

    $this->updateSessionBuyinTotal($session_id);

    return $buyin;
  }

  public function getBuyins($session_id) {
    $result = R::findAll(
      self::BUYIN_BEAN,
      'WHERE session_id = ' . $session_id);
    $a = array();
    foreach ($result as $buyin) {
      $obj = new stdClass();
      $obj->id = $buyin->id;
      $obj->amount = $buyin->amount;
      $a[] = $obj;
    }
    return $a;
  }
}