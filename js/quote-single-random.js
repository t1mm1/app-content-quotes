(function ($, Drupal, once) {
  Drupal.behaviors.appContentQuotesQuoteSingleRandom = {
    attach: function (context, settings) {
      const $container = $('#quote-single-container', context);
      if (!once('quotes-single-loader', $container).length) {
        return;
      }

      const escape = (text) => {
        return $('<div>').text(text).html();
      };

      $container.html(`
        <div class="quote-loading">
          <p>Loading quote<span class="loading-dots"></span></p>
        </div>
      `);

      setTimeout(() => {
        $.ajax({
          url: '/api/app-content-quotes/get/quote/single/random?_format=json',
          method: 'GET',
          dataType: 'json',
          success: function (data) {
            if (!Array.isArray(data)) {
              data = [data];
            }

            const quotesHtml = data
              .map((quote) => {
                const categories = Array.isArray(quote.categories)
                  ? quote.categories.join(', ')
                  : '';
                return `
                <div class="quote-content">
                  <blockquote>"${escape(quote.text)}</blockquote>
                  <p class="quote-author">— ${escape(
                    quote.author || 'Unknown'
                  )}</p>
                  ${
                    categories
                      ? `<p class="quote-categories"><small>${escape(
                          categories
                        )}</small></p>`
                      : ''
                  }
                </div>
              `;
              })
              .join('');

            $container.html(quotesHtml);
          },
          error: function () {
            $container.html(
              '<p class="quote-error">Failed to load quote. Please try again.</p>'
            );
          },
        });
      }, Math.random() * 1000);
    },
  };
})(jQuery, Drupal, once);
