<?php

namespace Drupal\config_timezone_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\config_timezone_location\Services\ConfigTimezoneLocationServices;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Provides a 'Config Timezone Location' Block.
 *
 * @Block(
 *   id = "config_timezone_location_block",
 *   admin_label = @Translation("config timezone location block"),
 *   category = @Translation("Config Timezone Location Block"),
 * )
 */
class ConfigTimezoneLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity display repository.
   *
   * @var \Drupal\config_timezone_location\Services\ConfigTimezoneLocationServices
   */
  protected $timezoneConfigService;

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
   * Constructs a new EntityView.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\config_timezone_location\Services\ConfigTimezoneLocationServices
   *   The current time service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory.
   * @param \Drupal\Core\Datetime\DateFormatter $dateFormatter
   *   The date formatter service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigTimezoneLocationServices $timezoneConfigService, ConfigFactoryInterface $configFactory, DateFormatter $dateFormatter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->timezoneConfigService = $timezoneConfigService;
    $this->configFactory = $configFactory;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config_timezone_location.timezone_service'),
      $container->get('config.factory'),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'country' => '',
      'city' => '',
      'timezone' => ''
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $date_data = [];
    $config = $this->configFactory->get('config_timezone_location.settings');
    $this->configuration['country'] = $config->get('country');
    $this->configuration['city'] = $config->get('city');
    $this->configuration['timezone'] = $config->get('timezone');
    $date_data['country'] = $this->configuration['country'];
    $date_data['city'] = $this->configuration['city'];
    $date_data['day'] = $this->dateFormatter->format((new DrupalDateTime('now'))->getTimestamp(), 'custom' , 'l' , $this->configuration['timezone']);
    $date =  $this->timezoneConfigService->getData();
    $date = explode("-", $date);    
    $date_data['current_date'] = $this->dateFormatter->format((new DrupalDateTime($date[0]))->getTimestamp(), 'custom' , 'j F Y');
    $date_data['time'] = $this->dateFormatter->format((new DrupalDateTime($date[1]))->getTimestamp(), 'custom' , 'h:i a');
    return [
      '#theme' => 'custom_timezone_block',
      '#data' => $date_data,
      '#cache' => ['max-age' => 0],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
}

}
