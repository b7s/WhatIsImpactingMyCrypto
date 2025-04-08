# Bitcoin News Aggregator

A modern cryptocurrency news aggregator that fetches, analyzes, and displays the latest Bitcoin and cryptocurrency news with sentiment analysis.

## Features

- **Real-time Cryptocurrency News**: Aggregates news from various sources with automatic updates
- **Sentiment Analysis**: Categorizes news articles as positive, negative, or neutral
- **Bitcoin Price Chart**: Interactive price chart showing BTC price movement over the last 24 hours
- **Click Tracking**: Tracks user engagement with news articles
- **Responsive Design**: Optimized for both desktop and mobile devices
- **Dark/Light Mode**: User-selectable theme preference
- **Political News Filter**: Special section for regulatory and political news affecting crypto markets
- **News by Hour**: View news published during specific time periods by clicking on the price chart
- **SEO Optimized**: Properly formatted meta tags for better search engine indexing

## Technologies Used

### Backend
- **Laravel 10**: PHP framework for the application core
- **MySQL**: Database for storing news articles and Bitcoin price data
- **PHP 8.3**: For server-side processing
- **Sentiment Analysis**: Natural language processing for news sentiment classification
- **RSS Feed Processing**: For gathering news from various sources

### Frontend
- **Alpine.js**: Lightweight JavaScript framework for interactive elements
- **Tailwind CSS**: Utility-first CSS framework for styling
- **Chart.js**: For rendering the Bitcoin price chart
- **Responsive Design**: Mobile-first approach with responsive components

### Features
- **Encoded URLs**: Security through YouTube-style URL encoding for click tracking
- **Real-time Notifications**: Updates when new articles are available
- **HTML Sanitization**: Removing HTML tags from descriptions for consistent display
- **Caching**: Performance optimization through intelligent caching
- **Dark Mode Detection**: Automatic theme selection based on system preferences

## Architecture

- **MVC Pattern**: Clear separation of concerns with Models, Views, and Controllers
- **Service Layer**: Dedicated services for fetching news and processing data
- **Repository Pattern**: Clean data access layer
- **Event-Driven Communication**: Custom events for communication between components
- **RESTful API**: Endpoints for retrieving time-specific news

## Getting Started

### Prerequisites
- PHP 8.3+
- Composer
- MySQL 8.0+
- Node.js and NPM (for frontend assets)

### Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/bitcoin-news-aggregator.git
cd bitcoin-news-aggregator
```

2. Install dependencies
```bash
composer install
```

3. Set up environment file
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in the .env file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bitcoin_news
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations
```bash
php artisan migrate
```

6. Fetch initial news data
```bash
php artisan news:fetch
```

7. Start the server
```bash
php artisan serve
```

8. Visit http://localhost:8000 in your browser

### Commands

- `php artisan news:fetch` - Fetches latest news from sources
- `php artisan news:list` - Lists all news articles with details
- `php artisan serve` - Starts the development server

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
