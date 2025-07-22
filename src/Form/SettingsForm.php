<?php

namespace Drupal\app_content_quotes\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for settings.
 */
class SettingsForm extends ConfigFormBase {

  use StringTranslationTrait;

  /**
   * Config settings.
   */
  const CONFIG_NAME = 'app_content_quotes.settings';

  /**
   * {@inheritdoc}
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    TypedConfigManagerInterface $typed_config_manager,
  ) {
    parent::__construct(
      $config_factory,
      $typed_config_manager,
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): ConfigFormBase|SettingsForm|static {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'app_content_quotes_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      static::CONFIG_NAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config(static::CONFIG_NAME);

    $form['api_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API URL'),
      '#default_value' => $config->get('api_url') ?: '',
      '#description' => $this->t('Example: http://192.168.1.103:3000'),
      '#required' => TRUE,
    ];
    $form['limit_random'] = [
      '#type' => 'number',
      '#title' => $this->t('Limit (random)'),
      '#default_value' => $config->get('limit_random') ?: 1,
      '#min' => 1,
      '#max' => 50,
      '#description' => $this->t('The limit of quotes.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config(static::CONFIG_NAME)
      ->set('api_url', $form_state->getValue('api_url'))
      ->set('limit_random', $form_state->getValue('limit_random'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
