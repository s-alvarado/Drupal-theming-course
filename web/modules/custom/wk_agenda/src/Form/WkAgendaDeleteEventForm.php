<?php

namespace Drupal\wk_agenda\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines form to confirm deletion of an entry by its id.
 */
class WkAgendaDeleteEventForm extends ConfirmFormBase {

  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $eid;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $eid = NULL) {
    $this->eid = $eid;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Add deletion logic here
    // Create delete query using the incoming id

  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return 'wk_agenda_delete_event_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    // return new Url('wk_agenda.delete_event');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Do you want to delete %eid?', ['%eid' => $this->eid]);
  }

}