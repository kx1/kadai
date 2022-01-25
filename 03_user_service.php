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
    // 名前
    if ($this->isBlank($userData['name'])) {
      $this->invalidReasons[] = '名前が入力されていません。';
    }

    // メールアドレス
    if ($this->isBlank($userData['mailaddress'])) {
      $this->invalidReasons[] = 'メールアドレスが入力されていません。';
    } elseif ($this->isInvalidEmail($userData['mailaddress'])) {
      $this->invalidReasons[] = 'メールアドレスの形式が正しくありません。';
    }

    // 招待コード
    if ($this->isBlank($userData['invitationCode'])) {
      // 処理なし
      // (招待コードは必須項目ではないため、未指定でもエラーとしない)
    } elseif ($this->isValidInvitationCode($userData['invitationCode'])) {
      $this->invalidReasons[] = '招待コードの形式が正しくありません。';
    }

    // メールマガジンオプトアウトフラグ
    if ($this->isBlank($userData['mailMagazineOptedIn'])) {
      // 処理なし
      // (メールマガジンオプトアウトフラグは必須項目ではないため、未指定でもエラーとしない)
    }

    return count($this->invalidReasons) === 0;
  }
}
