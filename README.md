# APP Content Quotes

**APP Content Quotes** is a custom Drupal module that displays random quotes via AJAX from an external REST API.  
_This is an example module as part of a client-server application. The client part is implemented as a Drupal module. The server is created with Node.js (not provided here)._

## Features

- Easily displays random quotes on a configurable admin page using AJAX.
- Fetches quotes from a configurable external API endpoint.
- Includes a settings form for specifying the API URL and the number of quotes to display.
- Supplies a configurable REST resource endpoint for programmatic quote access.

## Block Plugin

This module includes a block plugin called **"Random single quote"** in **"APP Content Quotes category"**.

- You can add this block to any region via the block layout UI.
- The block displays a random quote, loaded via AJAX from your configured API.
- Each page render fetches a new random quote (the block **is not cached** by Drupal).
- The block uses the module's settings (API URL and quote limit) for fetching quotes.
- Ideal for sidebars, articles, or landing pages where fresh inspirational or motivational quotes are wanted.

## Installation

1. Place the `app_content_quotes` folder in your Drupal installation under `/modules/custom/app_content_quotes`.
2. Enable the module via the Drupal **Extend** page or using Drush:
   ```bash
   drush en app_content_quotes
   ```

## Configuration

Before use, please, go to REST settings (/admin/config/services/rest) enable *Get quote single random resource* resource.	

1. Navigate to Configuration » Content » App Content Quotes settings (/admin/config/content/app-content-quotes-settings). You can change limit of quotes and API url for endpoints.
2. Enter the base API URL (e.g. http://example.com) and set the desired limit for random quotes.
3. Save the configuration.

## Usage
- Visit Configuration » Content » APP Content Quotes (/admin/config/content/app-content-quotes) to view the AJAX-powered quote display.
- Quotes will be fetched from your configured external API and displayed in real-time.

## REST Resource
The module provides a REST endpoint at: /api/app-content-quotes/get/quote/single/random?_format=json

## Requirements
- Drupal core (^11)
- hal (Drupal core)
- rest (Drupal core)
- serialization (Drupal core)
- [restui](https://www.drupal.org/project/restui)

---

## Credits

Developed by [pkasianov](https://www.drupal.org/u/pkasianov).

---

## License

This module is open-source and distributed under the [GPL-2.0-or-later](https://www.drupal.org/about/licensing).

---

## Feedback and Contributions

If you have suggestions, find bugs, or want to contribute improvements, feel free to [text me on Drupal.org](https://www.drupal.org/u/pkasianov) or submit a pull request.  
Your feedback and contributions are always welcome!
