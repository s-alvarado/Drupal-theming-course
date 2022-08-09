<?php

namespace Drupal\wk_agenda\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Datetime\DateFormatterInterface;

class WkAgendaEventForm extends FormBase {
  /** 
   * The database connection
   * @var \Drupal\Core\Database\Connection;
   */
  protected $connection;

  /** 
   * The dateTime service
   * @var \Drupal\Core\Datetime\DateFormatterInterface;
   */
  protected $dateFormatter;

  /**
   * @param \Drupal\Core\Database\Connection $connection
   */
  public function __construct(Connection $connection, DateFormatterInterface $date_formatter ) {
    $this->connection = $connection;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * We inject the database
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      // Load the service required to construct this class.
      $container->get('database'),
      $container->get('date.formatter')
    );
  }

  /**
   * Getter method for Form ID.
   *
   * @return string
   *   The unique ID of the form defined by this class.
   */
  public function getFormId() {
      return 'wk_agenda_event_form';
  }

  /**
   * Build the simple form.
   *
   * @param array $form
   *   Default form array structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object containing current form state.
   *
   * @return array
   *   The render array defining the elements of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['info'] = [
      '#type' => 'item',
      '#markup' => $this->t('Create a new event and we will keep you informed!'),
    ];

    $form['event_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event Title'),
      '#description' => $this->t('Title must be at least 5 characters in length.'),
      '#required' => TRUE,
    ];

    $form['event_description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Event Description'),
      '#description' => $this->t('A brief description of the registered event.'),
      '#required' => TRUE,
    ];

    $form['event_date'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Event Date'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Implements form validation.
   *
   * @param array $form
   *   The render array of the currently built form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $event_title = $form_state->getValue('event_title');
    $event_date = $form_state->getValue('event_date');

    if (strlen($event_title) < 5) {
      // Set an error for the form element with a key of "event_title".
      $form_state->setErrorByName('event_title', $this->t('The title must be at least 5 characters long.'));
    };
  }

  /**
   * Implements a form submit handler.
   *
   * @param array $form
   *   The render array of the currently built form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $event_title = $form_state->getValue('event_title');
    $event_description = $form_state->getValue('event_description');
    
    // We process the date and convert it into a unix timestamp
    $event_date = $form_state->getValue('event_date');
    $date_time = new DrupalDateTime($event_date, new \DateTimeZone('UTC'));
    $timestamp = $date_time->getTimestamp();

    // We reference the connection and store the values
    $database = $this->connection;
    $fields = array(
      'event_title' => $event_title,
      'event_description' => $event_description,
      'event_date' => $timestamp,
    );
    $database
      ->insert('event')
      ->fields($fields)
      ->execute();
    
    $this->messenger()->addStatus($this->t('New event created with title: %event_title.', ['%event_title' => $event_title]));
  }
}