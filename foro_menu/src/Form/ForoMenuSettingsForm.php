<?php

namespace Drupal\foro_menu\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class ForoMenuSettingsForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'foro_menu.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'foro_menu_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $values = foro_menu_get_available_sections();

    $defaultValue = '';
    foreach ($values as $key => $value) {
      $defaultValue .= "$key | $value\n";
    }
  
    $form['foro_menu_entries'] = array(
      '#type' => 'textarea',
      '#title' => t('Menu entries for "ediciones" block'),
      '#default_value' => $defaultValue,
      '#description' => t('List of available menu entries, one per line. Separate path and title with | '),
      // '#size' => 100,
      // '#maxlength' => 300,
      '#rows' => 20,
      '#required' => TRUE,
    );
    $form['exam_document'] = array(
      '#type' => 'managed_file',
      '#title' => t('Exam Document'),
      '#required' => FALSE,
      '#upload_location' => 'private://',
      '#multiple' => TRUE,
      '#default_value' => explode(',' , $config->get('exam_document')),
      '#upload_validators' => array(
        'file_validate_extensions' => array('doc docx txt pdf'),
      )
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('foro_menu_entries', $form_state->getValue('foro_menu_entries'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}