<?php

namespace Drupal\current_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Current Location Form.
 *
 * @package Drupal\current_location\Form
 */
class CurrentLocationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'current_location.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'current_location_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $site_config = $this->config('current_location.settings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#default_value' => $site_config->get('country'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
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
      '#required' => TRUE,
      '#default_value' => $site_config->get('timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save config values.
    $this->config('current_location.settings')
      ->set('timezone', $form_state->getValue('timezone'))
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}