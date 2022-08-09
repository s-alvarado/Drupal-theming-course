<?php

namespace Drupal\wk_agenda\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use \Drupal\Core\Url;
use \Drupal\Core\Link;

/**
 * Shows the events saved in your agenda.
 */
class WkAgendaEventController extends ControllerBase {

  /** 
   * The database connection service
   * 
   * @var \Drupal\Core\Database\Connection;
   */
  protected $connection;

  /**
   * Class constructor.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Displays all the existing events in your agenda.
   */
  public function getEvents() {
    $config = $this->config('wk_agenda.settings');

    // We instantiate the conection and create a query
    $connection = $this->connection;
    $result = $connection->query("SELECT eid, event_title, event_description, event_date FROM {event}");
    $records = $result->fetchAll();

    // Create a new array to pass as parameter to the table array
    $event_rows = [];
    foreach ($records as $record) {
      // We acces the object and establish variables for its content
      $eid = $record->eid;
      $title = $record->event_title;
      $description = $record->event_description;
      $date = $record->event_date;

      // We generate the url for the delete link
      // $url = Url::fromRoute('wk_agenda.delete_event', ['eid' => $eid]);

      // Optional method?
      $url = Url::fromUri('route:wk_agenda.delete_event');
      $url->setRouteParameter('eid', $record->eid);

      // Get the URL string:
      $url_string = $url->toString();
      // Build a link:
      $link = Link::fromTextAndUrl(t('Delete entry'), $url);
      // Get the link string:
      $link_string = $link->toString();
      // Get a renderable array
      $link_renderable = $link->toRenderable();

      $event_rows[] = array(
          'event_title' => $title,
          'event_description' =>  $description,
          'event_date' =>  $date,
          'delete' => [
            'data' => [
              '#type' => 'link',
              '#title' => $this->t('Delete'),
              '#url' => $url,
            ],
          ],
          // 'delete' => "delete" //Agregar logica para generar el link, pasando un render element (contiene propiedad data)
      );
    };

    return [
      '#type' => 'table',
      '#caption' => $this->t('Your existing events.'),
      '#header' => [$this->t('Event'), $this->t('Description'), $this->t('Date'), $this->t('Delete')],
      '#rows' => $event_rows,
      '#description' => $this->t('Example of outputing database elements as a table.'),
      '#cache' => [
          'max-age' => 0,
        ],
    ];
        
  }

}
