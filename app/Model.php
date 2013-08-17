<?php

use RedBean_Facade as R;

class Model
{
  // Bean Constants
  const SESSION_BEAN = 'session';
  const BUYIN_BEAN = 'buyin';

  const MAX_COUNT = 100;

  public function __construct()
  {
    R::setup();
  }

  public function getLocations()
  {
    $q = 'SELECT location FROM ' . self::SESSION_BEAN;
    $rows = R::getAll($q);
    return $rows;
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

    //R::store($session);

    if( isset($value->buyins) ) {
      foreach($value->buyins as $buyin) {
        $buyinBean = saveBuyin($buyin);
        $session->ownBuyin[] = $buyinBean;
      }
    }

    $session->buyin_total = $this->calcSessionBuyinTotal($session);

    R::store($session);
    return $session;
  }

  protected function calcSessionBuyinTotal($session)
  {
    $total = 0;
    foreach($session->ownBuyin as $buyin) {
      $total += $buyin->amount;
    }
    return $total;
  }

  public function saveBuyin($value)
  {
    $session = R::load(self::SESSION_BEAN, $value->session_id);

    $buyin = R::dispense(self::BUYIN_BEAN);
    $buyin->amount = $value->amount;

    //R::store($buyin);

    return $buyin;
  }

  public function getBuyins($session_id) {
    $session = R::load(self::SESSION_BEAN, $value->session_id);
    return $session->ownBuyin;
  }
}