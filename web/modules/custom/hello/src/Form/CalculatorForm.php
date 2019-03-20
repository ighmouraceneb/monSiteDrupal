<?php
namespace Drupal\hello\Form;


use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;



class CalculatorForm extends FormBase
{
  public function getFormId()
  {
    return 'hello_form_calculator';
  }


  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['first_value'] = [
      '#type' => 'number',
      '#title' => $this->t('First value'),
      '#description' => $this->t('Enter first value.'),
      '#required' => TRUE,
    ];

    $form['operation_value'] = [
      '#type' => 'radios',
      '#title' => $this->t('First value'),
      '#description' => $this->t('Choose operation for processing.'),
      '#options' => array(
        '+' => "Addition",
        '-' => "Soustract",
        '*' => "Multiply",
        '/' => "Divide",
      ),
      '#default_value' => '+',
      '#required' => TRUE,

    ];


    $form['second_value'] = [
      '#type' => 'number',
      '#title' => $this->t('Second value'),
      '#required' => TRUE,
      '#description' => $this->t('Enter second value.'),
    ];

    $form['calculate'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate'),
    ];
    return $form;

  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $firstNumber = $form_state->getValue('first_value');
    $secondNumber = $form_state->getValue('second_value');
    $operateur = $form_state->getValue('operation_value');
    if($operateur == "+"){

    }

  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $firstNumber = $form_state->getValue('first_value');
    $secondNumber = $form_state->getValue('second_value');
    if(!is_numeric($firstNumber)){
      $form_state->setErrorByName('first_value', $this->t('first_value must be numeric'));
    }

    if(!is_numeric($secondNumber)){
      $form_state->setErrorByName('second_value', $this->t('second_value must be numeric'));
    }

    if ($operateur == '/' && $secondNumber == 0){
      $form_state->setErrorByName('$secondNumber', $this->t('division over zero is not possible'));
    }
  }


}
