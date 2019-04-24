<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 16/04/2019
 * Time: 10:45
 */

namespace Drupal\hello\Form;
use \Drupal\Core\Form\ConfigFormBase;
use \Drupal\Core\Form\FormStateInterface;

class UserStatUpdateForm extends ConfigFormBase
{
  public function getFormId()
  {
    return 'hello_form_userStatConfigUpdate';
  }

 protected function getEditableConfigNames()
 {
   return ['hello.settings'];
 }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $value = $this->config('hello.settings')->get('delay');
    $form['delay'] = [
      '#type' => 'select',
      '#title' => $this->t('How long to keep user activity statistics'),
      '#description' => $this->t('Choose delay.'),
      '#options' => array(
        '0' => "Never purge",
        '1' => "One day",
        '2' => " Tow days",
        '7' => "One week",
        '14' => "Two weeks",
        '30' => "One month",
      ),
      '#default_value' => $value,
      '#required' => TRUE,

    ];

    $form['save'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save configuration'),
    ];
    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $delay = $form_state->getValue('delay');
   $this->config('hello.settings')->set('delay', $delay)->save();

  }
}
