<?php

class UsersController extends AppControlelr
{
  public $uses = ['User']; // User model

  public function register()
  {
    $userData = $this->params['data']['user'];
    $userData['invitationCode'] = $this->params['data']['invitationCode'];
    $mailMagazinOptedIn = $this->Session->read('mailMagazineOptedIn');
    if (isset($mailMagazinOptedIn)) {
      $userData['mailMagazineOptedIn'] = $mailMagazinOptedIn;
      $this->Session->delete('mailMagazineOptedIn');
    }

    $service = new UserService($this);

    try {
      $user = $service->register($userData);
    } catch (\Exception $e) {
      // TODO: 仕様未確定のため暫定
      throw $e;
    }

    $this->set('registeredUser', $user);
  }
}
