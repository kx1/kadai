<?php

class UsersController extends AppControlelr
{
  public $uses = ['User']; // User model

  public function register()
  {
    $userData = $this->params['data']['user'];
    $userData['invitationCode'] = $this->params['data']['invitationCode'];

    $service = new UserService($this);

    try {
      $user = $service->register($userData);
    } catch (\Exception $e) {
      // TODO: 仕様未確定のため暫定
      throw $e;
    }

    // 20211225 メルマガオプトアウトフラグを追加
    $user['mailMagazineOptedIn'] = $this->Session->read('mailMagazineOptedIn');
    $this->User->save($user);
    $this->Session->delete('mailMagazineOptedIn');

    $this->set('registeredUser', $user);
  }
}
