<?php

namespace Drupal\app_content_quotes\Plugin\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Provides a block that loads a quote via AJAX.
 *
 * @Block(
 *   id = "app_content_quotes_quote_single_random_block",
 *   admin_label = @Translation("Quote single random Block")
 * )
 */
class QuoteSingleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
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
