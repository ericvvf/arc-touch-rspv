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

  /**
   * Checks whether the user is already registered on the event.
   *
   * @param \Drupal\Core\TypedData\Plugin\DataType\ItemList $participants
   *   Array of participants
   *  @param Int $user_id
   *   The user id.
   */
  protected function user_is_registered($participants, $user_id) {
    return array_search(
      $user_id, array_column($participants, 'target_id')
    );
  }

  /**
   * Handles the subscription/unsubscription workflow.
   *
   *  @param Int $event_id
   *   The event id.
   *  @param Int $user_id
   *   The user id.
   */
  public function subscription($event_id, $user_id) {
    $return = [];
    $event = $this->entityManager->getStorage('node')->load($event_id);
    $participants = $event->get('field_event_participant')->getValue();
    $user = User::load($user_id);
    $user_register_key = $this->user_is_registered($participants, $user->id());

    if ($user_register_key === FALSE) {
      $event->field_event_participant[] = ['target_id' => $user->id()];
      if ($event->save()) {
        $return['user_id'] = $user->id();
        $return['user_name'] = $user->get('name')->value;
        $return['action'] = 'register';
      }
      else {
        $return['error'] = TRUE;
      }
    }

    else {
      $event->get('field_event_participant')->removeItem($user_register_key);
      if($event->save()) {
        $return['user_id'] = $user->id();
        $return['action'] = 'remove';
      }
      else {
        $return['error'] = TRUE;
      }
    }

    return $return;
  }
}
