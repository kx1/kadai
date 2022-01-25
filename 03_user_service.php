<?php

class UserService extends AppService
{
  public function __construct($controller)
  {
    $this->controller = $controller;
    $this->invalidReasons = [];
  }

  public function register($userData)
  {
    if ($this->isValid($userData)) {
      $user = $this->controller->User->save($userData);
    } else {
      throw new Exception($this->invalidReasons);
    }
    return $user;
  }

  private function isValid($userData)
  {
    if ($this->isBlank($userData['name'])) {
      $this->invalidReasons[] = '名前が入力されていません。';
    }

    if ($this->isBlank($userData['name'])) {
      $this->invalidReasons[] = 'メールアドレスが入力されていません。';
    } elseif ($this->isInvalidEmail($userData['name'])) {
      $this->invalidReasons[] = 'メールアドレスの形式が正しくありません。';
    }

    if ($this->isBlank($userData['invitationCode'])) {
      // 処理なし
      // (招待コードは必須項目ではないため、未指定でもエラーとしない)
    } elseif ($this->isValidInvitationCode($userData['invitationCode'])) {
      $this->invalidReasons[] = '招待コードの形式が正しくありません。';
    }

    return count($this->invalidReasons) === 0;
  }
}
