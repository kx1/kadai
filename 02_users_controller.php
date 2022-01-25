<?php

class UsersController extends AppControlelr
{
  public $uses = ['User']; // User model

  public function register()
  {
    $userData = $this->params['data']['user'];
    $service = new UserService($this);
    $user = $service->register($userData);

    // 20211225 メルマガオプトアウトフラグを追加
    $user['mailMagazineOptedIn'] = $this->Session->read('mailMagazineOptedIn');
    $this->User->save($user);
    $this->Session->delete('mailMagazineOptedIn');

    $this->set('registeredUser', $user);
  }
}