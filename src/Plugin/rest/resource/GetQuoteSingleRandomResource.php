<?php

namespace Drupal\app_content_quotes\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @RestResource(
 *   id = "get_quote_single_random_resource",
 *   label = @Translation("Get quote single random resource"),
 *   uri_paths = {
 *     "canonical" = "/api/app-content-quotes/get/quote/single/random"
 *   }
 * )
 */
class GetQuoteSingleRandomResource extends ResourceBase {

  /**
   * Logger channel name.
   */
  const LOGGER_CHANNEL = 'app_content_quotes';

  /**
   * Config settings.
   */
  const CONFIG_NAME = 'app_content_quotes.settings';

  /**
   * Endpoint url.
   */
  const ENDPOINT_URL = 'quotes/random';

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The ClientInterface.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;
  
  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    ConfigFactoryInterface $config_factory,
    ClientInterface $http_client,
  ) {
    parent::__construct(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $serializer_formats,
      $logger,
    );

    $this->configFactory = $config_factory;
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition,
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get(static::LOGGER_CHANNEL),
      $container->get('config.factory'),
      $container->get('http_client'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function get() {
    $output = [];

    try {
      $config = $this->configFactory->get(static::CONFIG_NAME);
      $base_url = rtrim($config->get('api_url'), '/');
      $query = [
        'limit' => (int) $config->get('limit_random'),
      ];
      $url = $base_url . '/' . static::ENDPOINT_URL . '?' . http_build_query($query);

      $response = $this->httpClient->get($url, [
        'timeout' => 10,
        'headers' => ['Accept' => 'application/json'],
      ]);

      $data = json_decode($response->getBody(), TRUE);
      if (!empty($data)) {
        foreach ($data as $item) {
          $output[] = [
            'text' => $item['text'] ?? 'No text available.',
            'author' => $item['author'] ?? 'Unknown',
            'categories' => is_array($item['categories']) ? $item['categories'] : [],
          ];
        }
      } 
      else {
        $output[] = [
          'text' => 'No quote available.',
          'author' => 'Unknown',
          'categories' => [],
        ];
      }
    } 
    catch (\Exception $e) {
      $this->logger->error('API request failed: @message', ['@message' => $e->getMessage()]);
    }

    $response = new ResourceResponse($output);
    $response->addCacheableDependency(['max-age' => 0]);
    return $response;
  }

}