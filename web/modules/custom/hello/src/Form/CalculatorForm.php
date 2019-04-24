<?php
namespace Drupal\hello\Form;


use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;



class CalculatorForm extends FormBase
{




  public function getFormId()
  {
    return 'hello_form_calculator';
  }


  public function buildForm(array $form, FormStateInterface $form_state)
  {
    if(isset($form_state->getRebuildInfo()['result'])){
      $form['result'] = [
        '#markup' => '<h2>'.$this->t('Result: ').$form_state->getRebuildInfo()['result'].'</h2>',
      ];
    }
    $form['first_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First value'),
      '#description' => $this->t('Enter first value.'),
      '#required' => TRUE,
      '#ajax'  => [
        'callback' => [$this, 'AjaxValidateNumeric'],
        'event' => 'change',
      ],
      '#prefix' => '<span id="error-message-first_value"></span>',
    ];

    $form['operation_value'] = [
      '#type' => 'radios',
      '#title' => $this->t('First value'),
      '#description' => $this->t('Choose operation for processing.'),
      '#options' => array(
        '+' => "+",
        '-' => "-",
        '*' => "*",
        '/' => "/",
      ),
      '#default_value' => '+',
      '#required' => TRUE,

    ];


    $form['second_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Second value'),
      '#required' => TRUE,
      '#description' => $this->t('Enter second value.'),
      '#ajax'  => [
        'callback' => [$this, 'AjaxValidateNumeric'],
        'event' => 'change',
      ],
      '#prefix' => '<span id="error-message-second_value"></span>',
    ];

    $form['calculate'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate'),
    ];
    return $form;

  }


  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @return \Drupal\Core\Ajax\AjaxResponse
   */
  public function AjaxValidateNumeric(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $field = $form_state->getTriggeringElement()['#name'];

    if (is_numeric($form_state->getValue($field))) {
      $css = ['border' => '2px solid green'];
      $message = $this->t('OK!');
    } else {
      $css = ['border' => '2px solid red'];
      $message = $this->t('%field must be numeric!', ['%field' => $form[$field]['#title']]);
    }

    $response->AddCommand(new CssCommand("[name=$field]", $css));
    $response->AddCommand(new HtmlCommand('#error-message-' . $field, $message));

    return $response;
  }
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $firstNumber = $form_state->getValue('first_value');
    $secondNumber = $form_state->getValue('second_value');
    $operateur = $form_state->getValue('operation_value');
    if($operateur == "+"){
        $result = $firstNumber + $secondNumber;

    }elseif ($operateur == "-"){
      $result = $firstNumber - $secondNumber;
    }elseif ($operateur == "*") {
      $result = $firstNumber * $secondNumber;
    }else if($operateur == "/"){
      $result = $firstNumber / $secondNumber;
    }


    $form_state->addRebuildInfo('result', $result);

    $form_state->setRebuild();
    //\Drupal::messenger()->addMessage(t('%resultat', ['%resultat' => $result]));

  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $firstNumber = $form_state->getValue('first_value');
    $secondNumber = $form_state->getValue('second_value');
    $operateur = $form_state->getValue('operation_value');
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
