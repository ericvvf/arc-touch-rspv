<?php

namespace Drupal\rspv_events\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\rspv_events\RspvCore;
use Drupal\user\Entity\User;

/**
 * Returns responses for Rspv Events routes.
 */
class RspvEventsController extends ControllerBase {

  /**
   * The entity.manager service.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The Rspv.core service.
   *
   * @var \Drupal\rspv_events\RspvCore
   */
  protected $rspvCore;

  /**
   * The controller constructor.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity.manager service.
   */
  public function __construct(EntityManagerInterface $entity_manager, RspvCore $rspv_core) {
    $this->entityManager = $entity_manager;
    $this->rspvCore = $rspv_core;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('rspv_events.core')
    );
  }

  /**
   * Subscribes to an event.
   *
   * @param $event
   *   The event id.
   */
  public function subscribe($event) {

    $user = \Drupal::currentUser();

    $subscription = $this->rspvCore->subscribe($event, $user->id());

    return new JsonResponse($subscription);
  }


  /**
   * Cancel subscription on an event.
   *
   * @param $event
   *   The event id.
   */
  public function unsubscribe($event) {

    $user = \Drupal::currentUser();

    $subscription = $this->rspvCore->unsubscribe($event, $user->id());

    return new JsonResponse($subscription);
  }

}
