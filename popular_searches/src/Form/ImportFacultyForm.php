<?php

namespace Drupal\popular_searches\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Database;
use Drupal\Core\File\FileSystem;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Core\File\FileSystemInterface;
use Drupal\media\Entity\File;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * This is simple contact Form.
 */
class ImportFacultyForm extends FormBase {


  /**
   * Define here unique form ID.
   */
  public function getFormId() {
    return "faculty_bulk_upload_form_id";
  }

 public function buildForm(array $form, FormStateInterface $form_state) {
  
     $form = array(
      '#attributes' => array('enctype' => 'multipart/form-data'),
    );
    
    $form['file_upload_details'] = array(
      '#markup' => t('<b>The File</b>'),
    );
  
    $validators = array(
      'file_validate_extensions' => array( 'css','pdf' ,'png' ,'jpg' ,'jpeg'),
    );
    $form['excel_file'] = array(
      '#type' => 'managed_file',
      '#name' => 'excel_file',
      '#title' => t('File *'),
      '#size' => 20,
      '#description' => t('Excel format only'),
      '#upload_validators' => $validators,
      '#upload_location' => 'public://',
    );
    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );

    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {    
    if ($form_state->getValue('excel_file') == NULL) {
      $form_state->setErrorByName('excel_file', $this->t('upload proper File'));
    }

  }
  public function submitForm(array &$form, FormStateInterface $form_state) { 
    $file=\Drupal::entityTypeManager()->getStorageFile('file')
    ->load($form_state->getValue('excel_file')[0]);
    $full_path=$file->get('url')->value;
    $file_name=basename($full_path);                   

    $inputFileName=\Drupal::service('file_system')->realpath('public://'.$file_name );
    $today_date=DrupalDateTime::createFirmTimestamp(time());
    
    $conn->insert('popular_searches')->fields(
      array(
        'node_nid' => 1,
        'data_type' => 'kkkk',
        'title' =>'kalyani',
        'link_uri' => $inputFileName,
        'created_date' => $today_date->format('Y-m-d\TH:i:s'),
        'entry_date' => $today_date->format('Y-m-d'),
      )
    )->execute();  
   
    $this->messenger()->addMessage($this->t($total.' Records Successfully Added'), 'status', TRUE);
  }


}
