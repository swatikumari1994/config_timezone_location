<?php

/**
 * Config Timezon.
 * php version 7.3.28
 * 
 * @file      providing the service set config form.
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    swati <swatiecekumari1994@gmail.com>
 * @copyright 2022 drupal
 * @license   http://localhost/drupal PHP License 7.0
 * @link      http://localhost/drupal/admin/config/config-timezone-location/settings
 */

namespace Drupal\config_timezone_location\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Config Timezone Location Services
 * php version 7.3.28
 * 
 * @category  PHP
 * @package   Drupalconfig_Timezone_LocationServices
 * @author    swati <swatiecekumari1994@gmail.com>
 * @copyright 2022 drupal
 * @license   http://localhost/drupal PHP License 7.0
 * @link      http://localhost/drupal/admin/config/config-timezone-location/settings
 */
class ConfigTimezoneLocationServices
{

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
     *
     * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory comment of variable.
     *                                                                  The configuration factory.
     * @param \Drupal\Core\Datetime\DateFormatter        $dateFormatter comment of variable.
     *                                                                  The date formatter service.
     */
    public function __construct(ConfigFactoryInterface $configFactory , 
        DateFormatter $dateFormatter
    ) {
        $this->configFactory = $configFactory;
        $this->dateFormatter = $dateFormatter;
    }

    /**
     *  Class Container.
     * 
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container comment.
     *                                                                            Container.
     * 
     * @return object
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('config.factory'),
            $container->get('date.formatter')
        );
    }
  
    /**
     * Returns date.
     *
     * @return string $date
     *   The date.
     */
    public function getData()
    {
        $config = $this->configFactory->get('config_timezone_location.settings');
        $timezone = $config->get('timezone');
        $date = $this->dateFormatter->format(
            strtotime('now'), 
            'custom', 'jS M Y - h:i A', $timezone
        );
        return $date;
    }
}
