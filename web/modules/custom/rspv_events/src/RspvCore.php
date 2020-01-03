<?php

namespace Drupal\rspv_events;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\user\Entity\User;

/**
 * RspvCore service.
 */
class RspvCore {

  /**
   * The entity.manager service.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a RspvCore object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity.manager service.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  public function subscribe($event_id, $user_id) {
    $return = [];
    $event = $this->entityManager->getStorage('node')->load($event_id);
    $user = User::load($user_id);
    // $event->field_event_participant->entity = $user;
    $event->field_event_participant[] = ['target_id' => $user->save()];

    if ($event->save()) {
      $return['user_id'] = $user->id();
      $return['user_name'] = $user->get('name')->value;
    }
    else {
      $return['error'] = TRUE;
    }

    return $return;
  }

  public function unsubscribe($event_id, $user_id) {

    // $event = $this->entityManager->getStorage('node')->load($event_id);
    // $user = User::load($user_id);
    // $event->field_event_participant->entity = $user;
    // $save = $event->save();

    // return ['save' => $save];
  }

}
