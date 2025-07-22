<?php

namespace Drupal\app_content_quotes\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the random quote AJAX display page.
 */
class Page extends ControllerBase {

  /**
   * {@inheritdoc}
   *
   * Generates a render array for the page with a container for the quote.
   * The JS library app_content_quotes/loader will asynchronously insert the quote via AJAX.
   */
  public function content() {
    return [
      [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#attributes' => [
          'id' => 'quote-single-container',
        ],
        '#value' => 'Wait for loading quote...',
      ],
      '#attached' => [
        'library' => ['app_content_quotes/loader'],
      ],
    ];
  }

}