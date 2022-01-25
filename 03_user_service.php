<?php

class UserService extends AppService
{
  public function __construct($controller)
  {
    $this->controller = $controller;
  }

  /**
   * ユーザーデータをDBに新規登録する
   * バリデーションエラー時は例外をスローする
   *
   * @param array $userData ユーザーデータ
   * @return array 登録したユーザーデータ
   * @throws \Exception
   */
  public function register($userData)
  {
    $errors = $this->validateUser($userData);

    if ($errors) {
      throw new \Exception($errors);
    }

    $user = $this->controller->User->save($userData);
    return $user;
  }

  /**
   * ユーザーデータのバリデーションを行う
   *
   * @param array $userData ユーザー情報
   * @return array バリデーションエラー一覧 (バリデーションOK時は空リスト)
   */
  private function validateUser($userData)
  {
    $invalidReasons = [];

    // 名前
    if ($this->isBlank($userData['name'])) {
      $invalidReasons[] = '名前が入力されていません。';
    }

    // メールアドレス
    if ($this->isBlank($userData['mailaddress'])) {
      $this->invalidReasons[] = 'メールアドレスが入力されていません。';
    } elseif ($this->isInvalidEmail($userData['mailaddress'])) {
      $invalidReasons[] = 'メールアドレスの形式が正しくありません。';
    }

    // 招待コード
    if ($this->isBlank($userData['invitationCode'])) {
      // 処理なし
      // (招待コードは必須項目ではないため、未指定でもエラーとしない)
    } elseif ($this->isValidInvitationCode($userData['invitationCode'])) {
      $invalidReasons[] = '招待コードの形式が正しくありません。';
    }

    // メールマガジンオプトアウトフラグ
    if ($this->isBlank($userData['mailMagazineOptedIn'])) {
      // 処理なし
      // (メールマガジンオプトアウトフラグは必須項目ではないため、未指定でもエラーとしない)
    }

    return $invalidReasons;
  }
}
