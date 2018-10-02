<?php

namespace AdsTest\Interfaces;

interface IDictionary
{

  /**
   * @return boolean
   */
  public function isLoaded();

  /**
   * @return void
   */
  public function load();

  /**
   * Возвращает из справочника запись с указанным id
   * @param mixed $id
   * @return \stdClass
   * @throws \Exception
   */
  public function getRecordById($id);

  /**
   * Проверяет существование записи с указанным id
   * @param mixed $id
   * @return boolean
   */
  public function isRecordExists($id);

}

