<?php

/**
 * @file providing the service set config form.
 *
 */

namespace Drupal\config_timezone_location\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class Config Timezone Location Services
 * @package Drupal\config_timezone_location\Services
 */
class ConfigTimezoneLocationServices {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * Class constructor.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory.
   * @param \Drupal\Core\Datetime\DateFormatter $dateFormatter
   *   The date formatter service.
   */
  public function __construct(ConfigFactoryInterface $configFactory , DateFormatter $dateFormatter){
    $this->configFactory = $configFactory;
    $this->dateFormatter = $dateFormatter;
  }

    /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('date.formatter')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function getData() {
    $config = $this->configFactory->get('config_timezone_location.settings');
    $timezone = $config->get('timezone');
    $date = $this->dateFormatter->format(strtotime('now'), 'custom' , 'jS M Y - h:i A' , $timezone);
    return $date;
  }
}