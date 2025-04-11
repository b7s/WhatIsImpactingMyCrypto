<!DOCTYPE html>
<html lang="en" 
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
    x-init="$watch('darkMode', val => {
        document.documentElement.classList.toggle('dark', val);
        localStorage.setItem('darkMode', val);
        });
        if (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        darkMode = true;
    }" 
    :class="{ 'dark': darkMode }"
    class="dark"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Is Impacting My Crypto? - Latest Cryptocurrency News Analysis</title>
    <meta name="description" content="Get the latest Bitcoin and cryptocurrency price movement news with sentiment analysis. Stay updated with market trends and forecasts.">
    <meta name="keywords" content="bitcoin, cryptocurrency, crypto news, bitcoin price, crypto market, blockchain news, impact">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="What Is Impacting My Crypto? - Latest Cryptocurrency News Analysis">
    <meta property="og:description" content="Get the latest Bitcoin and cryptocurrency price movement news with sentiment analysis.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="What Is Impacting My Crypto? - Latest Cryptocurrency News Analysis">
    <meta name="twitter:description" content="Get the latest Bitcoin and cryptocurrency price movement news with sentiment analysis.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <meta name="robots" content="index, follow">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {},
            }
        }
    </script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4979108873270184"
crossorigin="anonymous"></script>
                                            <script src="https://widgets.coingecko.com/gecko-coin-heatmap-widget.js"></script>


    <style>
        [x-cloak] { display: none !important; }
        
        /* Bitcoin chart tooltip styles */
        .bitcoin-chart-tooltip {
            padding: 8px 12px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 6px;
            color: white;
            font-size: 14px;
            pointer-events: none;
            position: absolute;
            transform: translate(-50%, 0);
            z-index: 100;
            transition: all 0.1s ease;
            opacity: 0;
        }
        
        .bitcoin-chart-tooltip::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -6px;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid rgba(0, 0, 0, 0.8);
        }
        
        .bitcoin-chart-tooltip p {
            margin: 4px 0;
        }
        
        .bitcoin-chart-tooltip .price {
            font-weight: bold;
            font-size: 16px;
        }
        
        .bitcoin-chart-tooltip .price {
            font-weight: bold;
            font-size: 16px;
        }
        
        .bitcoin-chart-hover-point {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #f0f9ff;
            border: 2px solid #0ea5e9;
            transform: translate(-50%, -50%);
            pointer-events: none;
            opacity: 0;
            z-index: 10;
            transition: opacity 0.1s ease;
        }
        
        .dark .bitcoin-chart-hover-point {
            background-color: #0c4a6e;
            border: 2px solid #38bdf8;
        }
        
        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-900 {
                background-color: rgb(17 24 39);
            }
            .dark\:text-gray-100 {
                color: rgb(243 244 246);
            }
            .dark\:bg-gray-800 {
                background-color: rgb(31 41 55);
            }
            .dark\:text-gray-400 {
                color: rgb(156 163 175);
            }
            .dark\:text-blue-400 {
                color: rgb(96 165 250);
            }
            .dark\:bg-green-900 {
                background-color: rgb(20 83 45);
            }
            .dark\:text-green-200 {
                color: rgb(187 247 208);
            }
            .dark\:bg-rose-900 {
                background-color: rgb(127 29 29);
            }
            .dark\:text-rose-200 {
                color: rgb(254 202 202);
            }
            .dark\:bg-gray-700 {
                background-color: rgb(55 65 81);
            }
            .dark\:text-gray-200 {
                color: rgb(229 231 235);
            }
            .dark\:hover\:bg-gray-600:hover {
                background-color: rgb(75 85 99);
            }
            .dark\:hover\:bg-green-800:hover {
                background-color: rgb(22 101 52);
            }
            .dark\:hover\:bg-rose-800:hover {
                background-color: rgb(153 27 27);
            }
            .dark\:hover\:text-blue-400:hover {
                color: rgb(96 165 250);
            }
        }

        .bg-gray-100 {
            background-color: rgb(243 244 246);
        }
        .text-gray-900 {
            color: rgb(17 24 39);
        }
        .bg-white {
            background-color: rgb(255 255 255);
        }
        .text-gray-600 {
            color: rgb(75 85 99);
        }
        .text-gray-400 {
            color: rgb(156 163 175);
        }
        .text-blue-600 {
            color: rgb(37 99 235);
        }
        .bg-green-100 {
            background-color: rgb(220 252 231);
        }
        .text-green-800 {
            color: rgb(22 101 52);
        }
        .bg-rose-100 {
            background-color: rgb(254 226 226);
        }
        .text-rose-800 {
            color: rgb(153 27 27);
        }
        .bg-gray-200 {
            background-color: rgb(229 231 235);
        }
        .text-gray-800 {
            color: rgb(31 41 55);
        }
        .bg-blue-600 {
            background-color: rgb(37 99 235);
        }
        .text-white {
            color: rgb(255 255 255);
        }
        .hover\:bg-gray-300:hover {
            background-color: rgb(209 213 219);
        }
        .hover\:bg-green-200:hover {
            background-color: rgb(187 247 208);
        }
        .hover\:bg-rose-200:hover {
            background-color: rgb(254 202 202);
        }
        .hover\:bg-blue-700:hover {
            background-color: rgb(29 78 216);
        }
        .hover\:text-blue-600:hover {
            color: rgb(37 99 235);
        }
        .shadow-md {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen" 
      x-data="{ 
        showNewsPopup: false, 
        showHeatmap: false,
        popupTimestamp: null,
        popupHour: '',
        popupDate: '',
        popupNews: [],
        loadingNews: false,
        
        // Helper function to format dates in local timezone
        formatLocalTime(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp * 1000);
            return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
        },
        
        formatLocalDate(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp * 1000);
            return date.toLocaleDateString(undefined, {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        },
        
        formatPublishedAt(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleString(undefined, {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        }
      }"
      x-init="
        window.addEventListener('open-news-popup', (event) => {
            popupTimestamp = event.detail.timestamp;
            popupHour = event.detail.hour;
            popupDate = event.detail.date;
            popupNews = [];
            loadingNews = true;
            showNewsPopup = true;
        });

        window.addEventListener('news-loaded', (event) => {
            popupNews = event.detail.news;
            loadingNews = false;
        });

        // Update TradingView theme based on dark mode
        $watch('darkMode', value => {
            if (document.querySelector('.tradingview-widget-container__widget iframe')) {
                const iframe = document.querySelector('.tradingview-widget-container__widget iframe');
                const theme = value ? 'dark' : 'light';
                if (iframe && iframe.contentWindow) {
                    iframe.contentWindow.postMessage({ name: 'set-theme', value: theme }, '*');
                }
            }
        });
      ">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <gecko-coin-price-marquee-widget locale="en" dark-mode="true" transparent-background="true" coin-ids="bitcoin,ethereum,solana,pi-network,jupiter-exchange-solana,sonic-3,ripple,chainlink,cardano,binancecoin,the-open-network,dogecoin,tron,polkadot,polygon-ecosystem-token,pancakeswap-token" initial-currency="usd"></gecko-coin-price-marquee-widget>
            <script src="https://widgets.coingecko.com/gecko-coin-price-marquee-widget.js"></script>
        </div>

        <header class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Crypto Impact Logo" class="w-12 h-12 mr-3">
                    <h1 class="text-3xl md:text-4xl font-bold">What Is Impacting My Crypto?</h1>
                </div>
                <div class="flex items-center gap-2">
                    @if($sentiment !== 'all' || !empty($selectedTimestamp))
                    <a href="{{ route('news.index') }}" class="p-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center" aria-label="Return to home page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Home
                    </a>
                    @endif
                    
                <button 
                    @click="showHeatmap = true" 
                    class="p-2 rounded-lg bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center"
                    aria-label="Open cryptocurrency heatmap"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Heatmap
                </button>

                <!-- Heatmap Modal -->
                <div x-show="showHeatmap" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 overflow-y-auto"
                     aria-labelledby="heatmap-modal-title"
                     role="dialog"
                     aria-modal="true"
                >
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showHeatmap" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                             aria-hidden="true"
                             @click="showHeatmap = false"
                        ></div>

                        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4" id="heatmap-modal-title">
                                            Cryptocurrency Heatmap
                                        </h3>
                                        <div class="mt-2">
                                            <gecko-coin-heatmap-widget locale="en" dark-mode="true" transparent-background="true" outlined="true" top="100"></gecko-coin-heatmap-widget>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" 
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="showHeatmap = false"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">Latest news about Bitcoin and cryptocurrency price movements</p>
            
            <!-- Sentiment Filters & Today's Sentiment -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 gap-4">
                <!-- Sentiment Filters -->
                <nav aria-label="Sentiment filters" class="grid grid-cols-2 sm:flex sm:flex-wrap gap-2 mb-4 lg:mb-0">
                    <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-full text-sm font-medium text-center {{ $sentiment === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600' }} transition-colors" aria-current="{{ $sentiment === 'all' ? 'page' : 'false' }}">
                        All
                    </a>
                    <a href="{{ route('news.index', ['sentiment' => 'positive']) }}" class="px-4 py-2 rounded-full text-sm font-medium text-center {{ $sentiment === 'positive' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100 hover:bg-green-200 dark:hover:bg-green-800' }} transition-colors" aria-current="{{ $sentiment === 'positive' ? 'page' : 'false' }}">
                        Positive
                    </a>
                    <a href="{{ route('news.index', ['sentiment' => 'negative']) }}" class="px-4 py-2 rounded-full text-sm font-medium text-center {{ $sentiment === 'negative' ? 'bg-rose-600 text-white' : 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-100 hover:bg-rose-200 dark:hover:bg-rose-800' }} transition-colors" aria-current="{{ $sentiment === 'negative' ? 'page' : 'false' }}">
                        Negative
                    </a>
                    <a href="{{ route('news.index', ['sentiment' => 'neutral']) }}" class="px-4 py-2 rounded-full text-sm font-medium text-center {{ $sentiment === 'neutral' ? 'bg-sky-600 text-white' : 'bg-sky-100 text-gray-800 dark:bg-sky-700 dark:text-gray-100 hover:bg-sky-300 dark:hover:bg-sky-600' }} transition-colors" aria-current="{{ $sentiment === 'neutral' ? 'page' : 'false' }}">
                        Neutral
                    </a>
                </nav>

                <!-- Today's Sentiment Indicator -->
                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm" aria-labelledby="sentiment-heading">
                    <div class="flex items-center justify-between text-sm font-medium mb-2">
                        <div class="flex items-center">
                            <div x-data="{ showInfo: false }" class="relative">
                                <button 
                                    @mouseenter="showInfo = true" 
                                    @mouseleave="showInfo = false" 
                                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none"
                                    aria-label="Sentiment calculation information"
                                    type="button"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                <div x-show="showInfo" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 translate-y-1" 
                                     x-transition:enter-end="opacity-100 translate-y-0" 
                                     x-transition:leave="transition ease-in duration-150" 
                                     x-transition:leave-start="opacity-100 translate-y-0" 
                                     x-transition:leave-end="opacity-0 translate-y-1" 
                                     class="absolute left-0 mt-2 w-72 px-4 py-3 bg-white dark:bg-gray-700 rounded-lg shadow-lg z-50 text-xs text-left"
                                     style="transform: translateX(-50%);"
                                     role="tooltip"
                                >
                                    <p class="font-medium mb-1 text-gray-900 dark:text-white">Weighted Sentiment Calculation</p>
                                    <p class="text-gray-600 dark:text-gray-300 mb-1">This indicator shows the dominant market sentiment based on news from the last 24 hours.</p>
                                    <p class="text-gray-600 dark:text-gray-300">Political news (containing terms like "regulation", "policy", "government", etc.) have twice the impact on positive and negative sentiment calculations.</p>
                                </div>
                            </div>
                            <span id="sentiment-heading" class="ml-1 mr-2">Last 24h Market Sentiment:</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full font-bold {{ 
                            $todaySentiment['dominant'] === 'positive' ? 'bg-green-500 text-white' : 
                            ($todaySentiment['dominant'] === 'negative' ? 'bg-rose-500 text-white' : 'bg-sky-500 text-white') 
                        }}">
                            {{ ucfirst($todaySentiment['dominant']) }}
                        </span>
                    </div>
                    <div class="w-full h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden" role="presentation">
                        <div class="flex h-full">
                            <div class="bg-green-500 h-full" style="width: {{ $todaySentiment['percentages']['positive'] }}%" aria-hidden="true"></div>
                            <div class="bg-sky-500 h-full" style="width: {{ $todaySentiment['percentages']['neutral'] }}%" aria-hidden="true"></div>
                            <div class="bg-rose-500 h-full" style="width: {{ $todaySentiment['percentages']['negative'] }}%" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div class="flex justify-between w-full text-xs mt-1">
                        <span class="text-green-500 font-medium">{{ $todaySentiment['percentages']['positive'] }}% Positive</span>
                        <span class="text-sky-500 font-medium">{{ $todaySentiment['percentages']['neutral'] }}% Neutral</span>
                        <span class="text-rose-500 font-medium">{{ $todaySentiment['percentages']['negative'] }}% Negative</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Political section -->
        @if($politicalNews->isNotEmpty())
        <section class="mb-8" aria-labelledby="political-news-heading">
            <div class="bg-purple-50 dark:bg-purple-900/30 p-4 sm:p-6 rounded-xl border border-purple-200 dark:border-purple-800">
                <h2 id="political-news-heading" class="text-xl sm:text-2xl font-bold mb-2 sm:mb-4 text-purple-800 dark:text-purple-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    Impacting Crypto
                </h2>
                <p class="text-sm sm:text-base text-purple-700 dark:text-purple-200 mb-4 sm:mb-6">Recent political events and regulatory news that may affect cryptocurrency markets</p>
                
                <div class="grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($politicalNews as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border-l-4 
                            @if($item->sentiment === 'positive') border-green-500
                            @elseif($item->sentiment === 'negative') border-rose-500
                            @else border-sky-500 @endif">
                            <div class="p-3 sm:p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $item->published_at->diffForHumans() }}</span>
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold
                                        @if($item->sentiment === 'positive') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($item->sentiment === 'negative') bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200
                                        @else bg-sky-100 text-gray-800 dark:bg-sky-900 dark:text-gray-200 @endif">
                                        {{ ucfirst($item->sentiment) }}
                                    </span>
                                </div>
                                
                                <h3 class="text-base font-semibold mb-2 line-clamp-2">
                                    <a href="{{ $item->getRedirectRoute() }}" target="_blank" rel="noopener" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                
                                <div class="flex justify-between items-center mt-3 text-xs">
                                    <span class="font-medium text-gray-500 dark:text-gray-400">
                                        {{ str_replace(['.com', '.org', '.net'], '', $item->source) }}
                                    </span>
                                    <a href="{{ $item->getRedirectRoute() }}" target="_blank" rel="noopener" class="flex items-center text-purple-600 dark:text-purple-400 hover:underline" aria-label="Read more about {{ $item->title }}">
                                        <span>Read more</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Bitcoin Price Chart Section -->
        @if(isset($bitcoinPrices) && count($bitcoinPrices) > 0)
        <section class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden" aria-labelledby="bitcoin-price-heading">
            <div class="p-3 sm:p-4">
                <div class="flex flex-wrap justify-between items-center mb-2">
                    <div>
                        <div class="flex items-center">
                            <img src="{{ asset('images/bitcoin.svg') }}" alt="Bitcoin logo" class="w-5 h-5 mr-2">
                            <h2 id="bitcoin-price-heading" class="text-lg sm:text-xl font-bold">Bitcoin Price</h2>
                            @if($latestBitcoinPrice)
                            <span class="ml-2 text-lg sm:text-xl font-bold {{ $latestBitcoinPrice->price_change_24h > 0 ? 'text-green-600 dark:text-green-400' : ($latestBitcoinPrice->price_change_24h < 0 ? 'text-rose-600 dark:text-rose-400' : 'text-gray-700 dark:text-gray-300') }}">
                                ${{ number_format($latestBitcoinPrice->price, 2) }}
                            </span>
                                @if($latestBitcoinPrice->price_change_24h)
                                <span class="ml-1 text-xs sm:text-sm font-medium {{ $latestBitcoinPrice->price_change_24h > 0 ? 'text-green-600 dark:text-green-400' : 'text-rose-600 dark:text-rose-400' }}" aria-label="Price change in the last 24 hours: {{ $latestBitcoinPrice->price_change_24h > 0 ? 'up' : 'down' }} {{ number_format(abs($latestBitcoinPrice->price_change_24h), 2) }}%">
                                    {{ $latestBitcoinPrice->price_change_24h > 0 ? '+' : '' }}{{ number_format($latestBitcoinPrice->price_change_24h, 2) }}%
                                </span>
                                @endif
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 sm:mt-0">
                            <span class="font-medium">* Click chart</span> to see news at that time
                        </div>
                    </div>
                    <div class="mt-1 sm:mt-0">
                        <button 
                                @click="$dispatch('open-tradingview')" 
                                class="ml-2 text-xs px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors flex items-center"
                                aria-label="Open TradingView chart"
                                type="button"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3m0 0l3 3m-3-3v12m6-9l3 3m0 0l3-3m-3 3V6" />
                            </svg>
                            TradingView
                        </button>
                    </div>
                </div>
                
                <div class="relative" style="height: 180px; sm:height: 200px; cursor: pointer;" title="Click to see news at this time" 
                    aria-label="Bitcoin price chart for the last 24 hours. Interactive chart that shows price changes. Click on bars to see news from that time period.">
                    <canvas id="bitcoinChart"></canvas>
                    <div id="chartTooltip" class="bitcoin-chart-tooltip" aria-hidden="true"></div>
                    <div id="chartHoverPoint" class="bitcoin-chart-hover-point" aria-hidden="true"></div>
                </div>
            </div>
        </section>
        @endif
        
        <!-- Popup for news at specific hour -->
        <div x-show="showNewsPopup" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-cloak
             role="dialog"
             aria-labelledby="news-popup-title"
             aria-modal="true"
             >
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showNewsPopup = false">
                    <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                </div>
                
                <div @click.away="showNewsPopup = false" 
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 id="news-popup-title" class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                News from <span x-text="popupHour"></span> on <span x-text="popupDate"></span>
                            </h3>
                            <button 
                                @click="showNewsPopup = false" 
                                class="text-gray-400 hover:text-gray-500 focus:outline-none" 
                                aria-label="Close dialog"
                                type="button">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-2" x-show="loadingNews" aria-live="polite">
                            <div class="flex justify-center">
                                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="sr-only">Loading news...</span>
                            </div>
                        </div>
                        
                        <div class="mt-2" x-show="!loadingNews" aria-live="polite">
                            <div x-show="popupNews.length === 0" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                No news published in this hour
                            </div>
                            
                            <ul x-show="popupNews.length > 0" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-for="item in popupNews" :key="item.url">
                                    <li class="py-3">
                                        <a :href="item.url" target="_blank" rel="noopener noreferrer" class="block hover:bg-gray-50 dark:hover:bg-gray-700 px-4 py-2 rounded">
                                            <div>
                                                <span class="mt-2 px-2 py-0.5 text-xs rounded-full"
                                                    :class="{
                                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': item.sentiment === 'positive',
                                                        'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200': item.sentiment === 'negative',
                                                        'bg-sky-100 text-gray-800 dark:bg-sky-700 dark:text-gray-200': item.sentiment === 'neutral'
                                                    }"
                                                    x-text="item.sentiment.charAt(0).toUpperCase() + item.sentiment.slice(1)"></span>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2" x-text="item.title"></p>
                                            </div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-text="item.published_at"></div>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                            
                            <div x-show="popupNews.length > 0" class="mt-4 flex justify-center">
                                <a :href="`{{ url()->current() }}?timestamp=${popupTimestamp}`" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    View all news from this hour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- TradingView Modal -->
        <div
            x-data="{ showTradingView: false }"
            x-show="showTradingView"
            x-on:open-tradingview.window="showTradingView = true"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            x-cloak
            role="dialog"
            aria-labelledby="tradingview-title"
            aria-modal="true"
        >
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showTradingView = false">
                    <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                </div>
                
                <div @click.away="showTradingView = false"
                    class="inline-block w-full max-w-5xl h-[80vh] align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle"
                >
                    <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                        <button 
                            @click="showTradingView = false" 
                            class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none bg-white dark:bg-gray-800 rounded-full p-1"
                            aria-label="Close TradingView chart"
                            type="button"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="h-full w-full p-1">
                        <h2 id="tradingview-title" class="sr-only">TradingView Bitcoin Chart</h2>
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container" style="height:100%;width:100%">
                          <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
                          <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                          <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                          {
                          "autosize": true,
                          "symbol": "COINBASE:BTCUSD",
                          "interval": "60",
                          "timezone": "Etc/UTC",
                          "theme": "dark",
                          "style": "1",
                          "locale": "en",
                          "allow_symbol_change": true,
                          "studies": [
                            "STD;RSI"
                          ],
                          "support_host": "https://www.tradingview.com"
                        }
                          </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Heatmap Modal -->
        <div
            x-data="{ showHeatmap: false }"
            x-show="showHeatmap"
            x-on:open-heatmap.window="showHeatmap = true"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            x-cloak
            role="dialog"
            aria-labelledby="heatmap-title"
            aria-modal="true"
        >
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showHeatmap = false">
                    <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                </div>
                
                <div @click.away="showHeatmap = false"
                    class="inline-block w-full max-w-5xl h-[80vh] align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle"
                >
                    <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                        <button 
                            @click="showHeatmap = false" 
                            class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none bg-white dark:bg-gray-800 rounded-full p-1"
                            aria-label="Close heatmap"
                            type="button"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="h-full w-full p-1">
                        <h2 id="heatmap-title" class="sr-only">Cryptocurrency Heatmap</h2>
                        <script src="https://widgets.coingecko.com/gecko-coin-heatmap-widget.js"></script>
                        <gecko-coin-heatmap-widget locale="en" dark-mode="true" transparent-background="true" outlined="true" top="100"></gecko-coin-heatmap-widget>
                    </div>
                </div>
            </div>
        </div>

        @if($news->isEmpty())
            <div class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md text-center" role="status">
                <p class="text-xl">No news found with the selected filter.</p>
                <a href="{{ route('news.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">View all news</a>
            </div>
        @else
            <section aria-label="Latest cryptocurrency news">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($news as $article)
                    @php
                        $articleSource = preg_replace('/\.(com|org|net|xyz|io|ai)$/i', '', $article->source);
                        // Clean description: strip HTML tags and remove source name
                        $cleanDesc = str_replace($article->source, '', strip_tags($article->description)); 
                    @endphp
                        <article class="p-4 border dark:border-gray-700 rounded-lg bg-white hover:bg-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 transition-all">
                            <div class="flex flex-col h-full">
                                <div class="flex justify-between items-start mb-3">
                                    <time datetime="{{ $article->published_at->toIso8601String() }}" class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $article->published_at->diffForHumans() }}
                                    </time>
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold
                                        @if($article->sentiment === 'positive') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($article->sentiment === 'negative') bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200
                                        @else bg-sky-100 text-gray-800 dark:bg-sky-900 dark:text-gray-200 @endif">
                                        {{ ucfirst($article->sentiment) }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-bold mb-2 line-clamp-2 text-gray-900 dark:text-white">
                                    {{ $article->title }}
                                </h3>
                                
                                <p class="text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">{!! $cleanDesc !!}</p>
                                
                                <div class="mt-auto flex justify-between items-center">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $articleSource }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex gap-2 w-full">
                                    <button
                                        @click="
                                            navigator.clipboard.writeText('{{ $article->getRedirectRoute() }}');
                                            const originalText = $event.target.closest('button').innerText;
                                            $event.target.closest('button').innerHTML = '<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-4 w-4 mr-1\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\' /></svg>Copied!';
                                            setTimeout(() => {
                                                $event.target.closest('button').innerHTML = '<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-4 w-4 mr-1\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3\' /></svg>Copy Link';
                                            }, 1500);
                                        "
                                        class="flex-1 text-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors text-sm font-medium flex items-center justify-center"
                                        type="button"
                                        aria-label="Copy link to {{ $article->title }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                        Copy Link
                                    </button>
                                    
                                    <a href="{{ $article->getRedirectRoute() }}" target="_blank" rel="noopener" class="flex-1 text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors text-sm font-medium flex items-center justify-center" aria-label="Read article: {{ $article->title }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                        Read Article
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <nav aria-label="Pagination" class="mt-8">
                    {{ $news->appends(request()->query())->links() }}
                </nav>
            </section>
        @endif

        <footer class="mt-16" role="contentinfo">
            <h2 class="text-2xl font-bold mb-4">What Is Impacting My Crypto?</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Cryptocurrency markets are highly reactive to news events. Regulatory announcements, institutional adoption, macroeconomic trends, and technological developments can all trigger significant price movements within minutes. Our sentiment analysis helps you identify the market's emotional response and potential impact direction.
            </p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bitcoinChartElement = document.getElementById('bitcoinChart');
            if (!bitcoinChartElement) return;
            
            // Chart data
            const bitcoinData = @json($bitcoinPrices ?? []);
            if (!bitcoinData.length) return;
            
            // Filter null values
            const filteredData = bitcoinData.filter(item => item.price !== null);
            
            // Prepare data for the chart - convert UTC timestamps to local timezone
            const convertedData = filteredData.map(item => {
                // Convert timestamp to local timezone
                const localDate = new Date(item.timestamp * 1000);
                const localHour = localDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
                
                return {
                    ...item,
                    hour: localHour, // Replace UTC hour with local hour
                    localDate: localDate
                };
            });
            
            // Sort data by timestamp to ensure chronological order
            convertedData.sort((a, b) => a.timestamp - b.timestamp);
            
            // Prepare data for the chart
            const labels = convertedData.map(item => item.hour);
            const prices = convertedData.map(item => item.price);
            const timestamps = convertedData.map(item => item.timestamp);
            
            // Calculate colors based on price trend
            const gradientColors = calculateGradientColors(prices);
            
            // Tooltip elements
            const tooltip = document.getElementById('chartTooltip');
            const hoverPoint = document.getElementById('chartHoverPoint');
            
            // Chart configuration
            const ctx = bitcoinChartElement.getContext('2d');
            
            // Create chart
            const bitcoinChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Bitcoin Price (USD)',
                        data: prices,
                        backgroundColor: function(context) {
                            const index = context.dataIndex;
                            const bar = context.chart.getDatasetMeta(0).data[index];
                            
                            // Create gradient for each bar
                            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                            
                            if (index === 0) {
                                // First bar - blue gradient
                                gradient.addColorStop(0, 'rgba(14, 165, 233, 0.8)');
                                gradient.addColorStop(1, 'rgba(14, 165, 233, 0.2)');
                            } else {
                                const currentPrice = prices[index];
                                const previousPrice = prices[index - 1];
                                
                                if (currentPrice >= previousPrice) {
                                    // Positive change - green gradient
                                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
                                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.2)');
                                } else {
                                    // Negative change - red gradient
                                    gradient.addColorStop(0, 'rgba(239, 68, 68, 0.8)');
                                    gradient.addColorStop(1, 'rgba(239, 68, 68, 0.2)');
                                }
                            }
                            
                            return gradient;
                        },
                        borderColor: function(context) {
                            const index = context.dataIndex;
                            if (index === 0) return 'rgba(14, 165, 233, 1)';
                            const currentPrice = prices[index];
                            const previousPrice = prices[index - 1];
                            return currentPrice >= previousPrice 
                                ? 'rgba(16, 185, 129, 1)'
                                : 'rgba(239, 68, 68, 1)';
                        },
                        borderWidth: 1,
                        borderRadius: 2,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxRotation: 0,
                                color: function(context) {
                                    return document.documentElement.classList.contains('dark') ? '#646970' : '#6b7280';
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: function(context) {
                                    return document.documentElement.classList.contains('dark') ? 'rgba(107, 114, 128, 0.1)' : 'rgba(229, 231, 235, 0.8)';
                                }
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                },
                                color: function(context) {
                                    return document.documentElement.classList.contains('dark') ? '#646970' : '#6b7280';
                                },
                                min: function() {
                                    const minPrice = Math.min(...prices);
                                    return minPrice - 10000;
                                },
                                max: function() {
                                    const maxPrice = Math.max(...prices);
                                    // Calculate 10% above the maximum price, but ensure it's at least 10,000 above
                                    const buffer = Math.max(maxPrice * 0.2, 20000);
                                    return maxPrice + buffer;
                                },
                                stepSize: 20000
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    onClick: handleChartClick
                }
            });
            
            // Custom tooltip
            bitcoinChartElement.addEventListener('mousemove', function(event) {
                const points = bitcoinChart.getElementsAtEventForMode(event, 'index', { intersect: false }, true);
                
                if (points.length) {
                    const point = points[0];
                    const index = point.index;
                    const price = prices[index];
                    const hour = labels[index];
                    
                    // Calculate percentage change
                    let percentageChange = '';
                    if (index > 0) {
                        const previousPrice = prices[index - 1];
                        const change = ((price - previousPrice) / previousPrice) * 100;
                        percentageChange = change >= 0 
                            ? `<span class="text-green-500">+${change.toFixed(2)}%</span>`
                            : `<span class="text-red-500">${change.toFixed(2)}%</span>`;
                    }
                    
                    // Tooltip position
                    const rect = bitcoinChartElement.getBoundingClientRect();
                    const xPos = points[0].element.x;
                    const yPos = points[0].element.y;
                    
                    // Get timezone info
                    const timezone = getTimezoneAbbr();
                    
                    tooltip.style.opacity = 1;
                    tooltip.style.left = xPos + 'px';
                    tooltip.style.top = (yPos - 80) + 'px';
                    tooltip.innerHTML = `
                        <p>${hour} <span class="text-xs">${timezone}</span></p>
                        <p class="price">$${price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                        ${percentageChange ? `<p class="text-xs">Change: ${percentageChange}</p>` : ''}
                        <p class="text-xs">Click to see news</p>
                    `;
                    
                    // Hover point
                    hoverPoint.style.opacity = 1;
                    hoverPoint.style.left = xPos + 'px';
                    hoverPoint.style.top = yPos + 'px';
                } else {
                    hideTooltip();
                }
            });
            
            bitcoinChartElement.addEventListener('mouseleave', hideTooltip);
            
            function hideTooltip() {
                tooltip.style.opacity = 0;
                hoverPoint.style.opacity = 0;
            }
            
            // Handler for chart click
            function handleChartClick(event) {
                const points = bitcoinChart.getElementsAtEventForMode(event, 'index', { intersect: false }, true);
                
                if (points.length) {
                    const index = points[0].index;
                    const timestamp = timestamps[index];
                    const hour = labels[index];
                    // Format date in local timezone
                    const date = new Date(timestamp * 1000).toLocaleDateString(undefined, {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    // Add timezone info to the hour
                    const formattedHour = `${hour} ${getTimezoneAbbr()}`;
                    
                    // Safer way to update Alpine.js data
                    window.dispatchEvent(new CustomEvent('open-news-popup', { 
                        detail: {
                            timestamp: timestamp,
                            hour: formattedHour,
                            date: date
                        }
                    }));
                    
                    // Fetch news for this time
                    fetchNewsForHour(timestamp);
                }
            }
            
            // Get timezone abbreviation
            function getTimezoneAbbr() {
                return new Date().toLocaleTimeString('en-us', {timeZoneName: 'short'}).split(' ')[2];
            }
            
            // Fetch news for a specific hour
            function fetchNewsForHour(timestamp) {
                fetch(`/api/news/hour?timestamp=${timestamp}`)
                    .then(response => response.json())
                    .then(data => {
                        // Dispatch a custom event to update Alpine data
                        window.dispatchEvent(new CustomEvent('news-loaded', { 
                            detail: {
                                news: data.news,
                                success: true
                            }
                        }));
                    })
                    .catch(error => {
                        console.error('Error fetching news:', error);
                        window.dispatchEvent(new CustomEvent('news-loaded', { 
                            detail: {
                                news: [],
                                success: false
                            }
                        }));
                    });
            }
            
            // Calculate chart colors based on price trend
            function calculateGradientColors(prices) {
                // Check if price went up or down overall
                /*const start = prices[0];
                const end = prices[prices.length - 1];
                const change = end - start;
                
                let lineColor;
                if (change > 0) {
                    lineColor = 'rgba(16, 185, 129, 1)'; // Green for uptrend
                } else if (change < 0) {
                    lineColor = 'rgba(239, 68, 68, 1)'; // Red for downtrend
                } else {
                    lineColor = 'rgba(14, 165, 233, 1)'; // Blue for stable
                }*/
                
                return {
                    lineColor: 'rgba(14, 165, 233, 1)'
                };
            }
        });
    </script>
</body>
</html>