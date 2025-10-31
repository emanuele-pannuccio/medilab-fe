<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MediClinic - Report</title>

  <!-- Feather icons -->
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   @vite(["resources/css/app.css", "resources/js/app.js"])
  <style>
    /* Nasconde l'input file di default */
    #fileElem {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        cursor: pointer;
    }
    /* Helper per il tema scuro (se necessario) */
    .dark .dark\:invert {
        filter: invert(1);
    }

    /* Animazione per i puntini di caricamento */
    .loading-dot {
      animation: bounce 1.4s infinite both;
    }
    .loading-dot:nth-child(1) { animation-delay: -0.32s; }
    .loading-dot:nth-child(2) { animation-delay: -0.16s; }
    @keyframes bounce {
      0%, 80%, 100% { transform: scale(0); }
      40% { transform: scale(1.0); }
    }
    /* Aggiungi stili per il font Inter */
    body {
        font-family: 'Inter', sans-serif;
    }
    #form-modifica-casistica::-webkit-scrollbar {
        display: none; /* Per Chrome, Safari e Opera */
    }
    #form-modifica-casistica {
        -ms-overflow-style: none;  /* Per IE e Edge */
        scrollbar-width: none;  /* Per Firefox */
    }
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap');

  </style>
  <script>
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }

    // Funzione globale per il toggle
    function toggleTheme() {
      if (localStorage.theme === 'dark') {
        localStorage.theme = 'light';
        document.documentElement.classList.remove('dark');
      } else {
        localStorage.theme = 'dark';
        document.documentElement.classList.add('dark');
      }
      // Aggiorna icone dopo il cambio tema se necessario
      feather.replace();
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-200 antialiased">

    <!-- Header (Semplificato per questa vista) -->
    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-30">
        <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo e Navigazione -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="/dashboard" class="flex items-center space-x-2">
                    <span class="p-2 bg-blue-600 rounded-lg">
                        <i data-feather="plus" class="w-4 h-4 font-bold text-white"></i>
                    </span>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">MediClinic</span>
                </a>
            </div>

            <!-- Controlli Utente -->
            <div class="flex items-center space-x-4">
                <!-- Pulsante Tema -->
                <button id="theme-toggle-btn" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 hover:cursor-pointer">
                    <i data-feather="moon" class="w-5 h-5 hidden dark:block"></i>
                    <i data-feather="sun" class="w-5 h-5 block dark:hidden"></i>
                </button>

                <!-- Menu Utente -->
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2">
                        <img src="https://placehold.co/40x40/E2E8F0/4A5568?text=DR" alt="Avatar utente" class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600" onerror="this.src='https://placehold.co/40x40/E2E8F0/4A5568?text=DR'">
                        <span class="hidden sm:inline text-sm font-medium text-gray-700 dark:text-gray-200">{{ request()->user()->name }}</span>
                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-500"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="user-menu-dropdown"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 border border-gray-200 dark:border-gray-700
                                hidden opacity-0 scale-95 transform transition-all duration-100 ease-out
                                origin-top-right z-40">
                        <a href="/auth/logout" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/50">
                            Logout
                        </a>
                    </div>
                </div>
                 <button class="md:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <i data-feather="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Contenuto Principale della Pagina -->
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Intestazione della pagina: Titolo e Stato -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold dark:text-white text-black">Dettaglio Caso: #CASE-15</h1>
                <p class="text-lg dark:text-gray-400 text-gray-700 text-bold">Registrato il 2022-07-09 18:31:48</p>
            </div>
            <div class="flex-shrink-0">
                <span class="text-base font-semibold px-4 py-2 rounded-full dark:text-gray-200 text-gray-700">
                    Stato: {{ $report["status"] }}
                </span>
            </div>
        </div>

        <!-- Layout a griglia per Info Paziente e Dettagli Caso -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Colonna Sinistra: Riassunto Paziente -->
            <div class="lg:col-span-1 flex flex-col gap-6">

                <!-- Card Info Paziente -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Paziente</h3>
                    <div class="space-y-3">
                        <div class="w-full overflow-hidden">
                            <dt class="text-sm font-medium text-gray-800 dark:text-white">Nome</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-white font-medium text-wrap w-full">{{ $report["patient"]["name"] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-800 dark:text-gray-400">ID Paziente</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-300 font-mono">{{ $report["patient"]["id"] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-800 dark:text-gray-400">Data di Nascita</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-300">{{ Carbon\Carbon::parse($report["patient"]["birthday"])->format("d/m/Y") }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-800 dark:text-gray-400">Medico Assegnato</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-300">{{ $report["doctor"]["name"] }} ({{ $report["doctor"]["email"] }}) </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonna Destra: Dettagli Caso Studio -->
            <div class="lg:col-span-2 flex flex-col gap-6">

                <!-- Card Dettagli Caso -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Dettagli Caso Studio</h3>
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Reparto</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-300">{{ $report["doctor"]["department"]["name"] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-800 dark:text-white">Diagnosi d'Ingresso</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-white italic border-l-4 border-blue-400 pl-4 py-2 bg-gray-200 dark:bg-slate-700/50 rounded-r-lg">
                                {{ $report["present_illness_history"] }}
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Card Cronologia e Note Mediche (Timeline) -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-6">Cronologia e Note Mediche</h3>

                    <!-- Timeline -->
                    <ol class="relative border-l border-slate-700">
                        <!-- Elemento 1: Ammissione -->
                        <li class="mb-10 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-500 rounded-full -left-3 ring-8 ring-white dark:ring-slate-800">
                                <svg class="w-2.5 h-2.5 dark:text-blue-100 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4z"/>
                                </svg>
                            </span>
                            <h4 class="flex items-center mb-1 text-lg font-semibold text-gray-500 dark:text-white">Ammissione</h4>
                            <time class="block text-sm font-normal leading-none text-gray-400">{{ Carbon\Carbon::parse($report["hospitalization_date"])->format("d/m/Y H:i")  }}</time>
                            <p class="mt-2 text-sm text-gray-400 dark:text-gray-300">{{ $report["present_illness_history"] }}</p>
                        </li>

                        <!-- Elemento 2: Esami Richiesti -->
                        @if ($report["clinical_evolution"] )
                        <li class="mb-10 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-yellow-500 rounded-full -left-3 ring-8 ring-white dark:ring-slate-800">
                                <!-- Icona fiala -->
                                <svg class="w-3 h-3 dark:text-yellow-100 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/>
                                </svg>
                            </span>
                            <h4 class="mb-1 text-lg font-semibold text-gray-500 dark:text-white">Clinical Evolution</h4>
                            <p class="text-sm text-gray-400 dark:text-gray-300">{{ $report["clinical_evolution"] }}</span>.</p>
                        </li>
                        @endif


                        @if ($report["discharge_date"] )
                        <li class="mb-10 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-slate-600 rounded-full -left-3 ring-8 ring-slate-800">
                                <!-- Icona orologio -->
                                <svg class="w-3 h-3 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0zm0 18a8 8 0 1 1 8-8 8.009 8.009 0 0 1-8 8z"/><path d="M10.707 5.293a1 1 0 0 0-1.414 0L8 6.586V13a1 1 0 0 0 2 0V7.414l1.293-1.293a1 1 0 0 0 0-1.414z"/>
                                </svg>
                            </span>
                            <h4 class="mb-1 text-lg font-semibold text-gray-500 dark:text-white">Dimissione</h4>
                            <time class="block text-sm font-normal leading-none text-gray-400">{{ Carbon\Carbon::parse($report["discharge_date"])->format("d/m/Y H:i")  }}</time>
                            @if ($report["discharge_date"] )
                            <p class="mt-2 text-sm text-gray-400 dark:text-gray-300">{{ $report["discharge_description"] }}</span>.</p>
                            @endif
                        </li>
                        @endif
                    </ol>

                </div>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            feather.replace();
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');

            if (userMenuButton && userMenuDropdown) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation(); // Previene che il click si propaghi al window
                    // Toggle visibility
                    if (userMenuDropdown.classList.contains('hidden')) {
                        userMenuDropdown.classList.remove('hidden');
                        // Forza un reflow per l'animazione
                        void userMenuDropdown.offsetWidth;
                        userMenuDropdown.classList.remove('opacity-0', 'scale-95');
                        userMenuDropdown.classList.add('opacity-100', 'scale-100');
                    } else {
                        userMenuDropdown.classList.remove('opacity-100', 'scale-100');
                        userMenuDropdown.classList.add('opacity-0', 'scale-95');
                        // Aspetta la fine della transizione (100ms) per nascondere
                        setTimeout(() => {
                            userMenuDropdown.classList.add('hidden');
                        }, 100);
                    }
                });

                // Chiudi se si clicca fuori
                window.addEventListener('click', (e) => {
                    // Controlla se il dropdown è visibile E se il click NON è sul bottone E NON è dentro il dropdown
                    if (!userMenuDropdown.classList.contains('hidden') &&
                        !userMenuButton.contains(e.target) &&
                        !userMenuDropdown.contains(e.target)) {

                        userMenuDropdown.classList.remove('opacity-100', 'scale-100');
                        userMenuDropdown.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            userMenuDropdown.classList.add('hidden');
                        }, 100);
                    }
                });

                const themeBtn = document.getElementById('theme-toggle-btn');
                if (themeBtn) {
                    themeBtn.addEventListener('click', toggleTheme);
                }

            }
        })
    </script>
</body>
</html>
