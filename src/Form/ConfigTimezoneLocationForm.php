<?php

namespace Drupal\config_timezone_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Config Timezone Location Form.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    swati <swatiecekumari1994@gmail.com>
 * @copyright 2022 drupal
 * @license   http://localhost/drupal PHP License 7.0
 * @link      http://localhost/drupal/admin/config/config-timezone-location/settings
 */
class ConfigTimezoneLocationForm extends ConfigFormBase
{

    /**
     * Returns config names.
     *
     * @return string
     *   The config names.
     */
    protected function getEditableConfigNames()
    {
        return [
        'config_timezone_location.settings',
        ];
    }

    /**
     * Returns a unique string identifying the form.
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId()
    {
        return 'config_timezone_location_form';
    }

    /**
     * Defines configration form.
     *
     * @param array $form
     *   The Form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   Form State.
     * 
     * @return array
     *   Form definition array.
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $site_config = $this->config('config_timezone_location.settings');

        $form['country'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Country'),
        '#required' => true,
        '#default_value' => $site_config->get('country'),
        ];

        $form['city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#required' => true,
        '#default_value' => $site_config->get('city'),
        ];

        $options = [
        'America/Chicago' => 'Chicago',
        'America/New_York' => 'New York',
        'Asia/Tokyo' => 'Tokyo',
        'Asia/Dubai' => 'Dubai',
        'Asia/Kolkata' => 'Kolkata',
        'Europe/Amsterdam' => 'Amsterdam',
        'Europe/Oslo' => 'Oslo',
        'Europe/London' => 'London',
        ]; 

        $form['timezone'] = [
        '#type' => 'select',
        '#options' => $options,
        '#title' => $this->t('TimeZone'),
        '#required' => true,
        '#default_value' => $site_config->get('timezone'),
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * Form submission handler.
     *
     * @param array $form
     *   An associative array.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     * 
     * @return void
     *   Form definition array.
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Save config values.
        $this->config('config_timezone_location.settings')
            ->set('timezone', $form_state->getValue('timezone'))
            ->set('country', $form_state->getValue('country'))
            ->set('city', $form_state->getValue('city'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}
