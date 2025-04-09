# What Is Impacting My Crypto?

A modern web application that tracks, analyzes, and displays cryptocurrency news with sentiment analysis and price correlations.

## Project Overview

This application fetches the latest cryptocurrency news, analyzes sentiment, and correlates with Bitcoin price movements. The platform helps users understand what factors may be impacting cryptocurrency markets.

### Key Features

- **News Aggregation**: Automated collection of cryptocurrency news from multiple sources
- **Sentiment Analysis**: Classification of news as positive, negative, or neutral
- **Political Impact Identification**: Special highlighting of news related to policy, regulation, and government actions
- **Bitcoin Price Tracking**: 24-hour price chart with interactive exploration
- **Time Correlation**: View news published at specific times to correlate with price movements
- **Dark/Light Mode**: UI theme persistence using localStorage
- **Click Tracking**: Analytics on which news articles users find most relevant
- **Mobile-Responsive Design**: Optimized user experience across all devices

## Technical Stack

- **Backend**: Laravel 12 (PHP 8.3)
- **Frontend**: Alpine.js, Tailwind CSS, Chart.js
- **Database**: SQLite
- **Caching**: Laravel's built-in caching system for performance
- **Deployment**: Compatible with any PHP hosting with Laravel support

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer
- Node.js & NPM
- Database (MySQL or PostgreSQL)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/b7s/WhatIsImpactingMyCrypto.git
   cd WhatIsImpactingMyCrypto
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database connection in the `.env` file

5. Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. Fetch initial data:
   ```bash
   php artisan news:fetch
   php artisan bitcoin:fetch
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

### Scheduled Tasks

Set up the following cron jobs for automatic updates:

```bash
# Fetch new cryptocurrency news every hour
* * * * * cd /path-to-your-project && php artisan news:fetch

# Update Bitcoin price data every 15 minutes
*/15 * * * * cd /path-to-your-project && php artisan bitcoin:fetch
```

### Manual Updates

You can manually trigger updates with:

```bash
php artisan news:fetch
php artisan bitcoin:fetch
```

### Viewing News

- Visit `/` to access the main news dashboard
- Use sentiment filters to focus on positive, negative, or neutral news
- Click on the Bitcoin price chart to see news from specific time periods
- Toggle dark/light mode with the theme button in the top-right corner

## Customization

- Add or modify political keywords in `app/Http/Controllers/NewsController.php`
- Adjust sentiment analysis parameters in `app/Services/NewsService.php`
- Modify the UI components in `resources/views/news/index.blade.php`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgements

- [Laravel](https://laravel.com/) - The PHP framework used
- [Alpine.js](https://alpinejs.dev/) - JavaScript framework for interactivity
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [Chart.js](https://www.chartjs.org/) - JavaScript charting library
