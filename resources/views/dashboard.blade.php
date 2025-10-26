<!DOCTYPE html>
<html lang="it" class="light md:h-screen">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MediClinic - Dashboard</title>

  <!-- Feather icons -->
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
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
    }
  </script>
  <!-- Questo sembra essere un placeholder per Laravel Vite, lo lascio com'è -->
  @vite(["resources/js/app.js", "resources/css/app.css"])
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200 font-sans h-full">

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

                <!-- Link Navigazione -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/dashboard" class="text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 pb-1">Dashboard</a>
                    <a href="#" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Pazienti</a>
                    <a href="#" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Report</a>
                </div>
            </div>

            <!-- Controlli Utente -->
            <div class="flex items-center space-x-4">
                <button class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <i data-feather="bell" class="w-5 h-5"></i>
                </button>

                <!-- Pulsante Tema -->
                <button id="theme-toggle-btn" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 hover:cursor-pointer">
                    <i data-feather="moon" class="w-5 h-5 hidden dark:block"></i>
                    <i data-feather="sun" class="w-5 h-5 block dark:hidden"></i>
                </button>

                <!-- Menu Utente -->
                <div class="relative">
                    <button class="flex items-center space-x-2">
                        <img src="https://placehold.co/40x40/E2E8F0/4A5568?text=DR" alt="Avatar utente" class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600" onerror="this.src='https://placehold.co/40x40/E2E8F0/4A5568?text=DR'">
                        <span class="hidden sm:inline text-sm font-medium text-gray-700 dark:text-gray-200">Dr. Rossi</span>
                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-500"></i>
                    </button>
                    <!-- Dropdown (nascosto per ora) -->
                </div>
                 <button class="md:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <i data-feather="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </nav>
    </header>


    <main class="container mx-auto md:px-4 py-6 h-full">
        <!-- Page Title -->
        <div class="flex flex-wrap sm:flex-nowrap justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Analisi Casistiche</h1>
            <div class="flex items-center space-x-2 sm:space-x-4 w-full sm:w-auto justify-end">

                <!-- Pulsante Nuova Casistica -->
                <button id="btn-nuova-casistica" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 sm:px-4 rounded-md transition shadow-sm text-sm font-medium cursor-pointer">
                    <i data-feather="plus" class="w-4 h-4 mr-1 sm:mr-2"></i>
                    Nuova Casistica
                </button>

                <!-- Controlli secondari -->
                <div class="flex items-center space-x-1 sm:space-x-2 border-l pl-2 sm:pl-4 border-gray-200 dark:border-gray-700">
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 pointer-events-none select-none hidden md:inline">Ultimo agg: oggi, 14:32</span>
                    <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                        <i data-feather="refresh-cw" class="w-5 h-5 text-gray-600 dark:text-gray-300 hover:cursor-pointer"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- FINE MODIFICA -->


        <!-- Quick Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach (["reparto", "stato", "data inizio"] as $filter)
                    <div>
                        <label for="filter-{{ $filter }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 select-none pointer-events-none">{{ Str::ucfirst($filter) }}</label>
                        <div class="relative">
                            <select id="filter-reparto" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white appearance-none py-2 pl-3 pr-8 outline-hidden">
                                <option>Default</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-400">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="flex items-end">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition">
                        Applica Filtri
                    </button>
                </div>
            </div>
        </div>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Card 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Casistiche Totali</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">1,248</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                        <i data-feather="file-text" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">In Analisi</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">328</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                        <i data-feather="alert-circle" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Chiusi</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">876</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <i data-feather="check-circle" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">In Revisione</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">44</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                        <i data-feather="edit" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cases Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Caso</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:block">Data Registrazione</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Paziente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:block">Diagnosi Ingresso</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sintesi AI</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stato</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:block">Medico</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Esempio riga 1 -->
                        @for ($i=0;$i<10;$i++)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">#MC-2023-0456</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden lg:block">12/05/2023</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">PZ-AB789X</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden lg:block">Sospetta miocardite</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Bassa priorità
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Chiuso
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden lg:block">Dr. Bianchi</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-500 mr-3 cursor-pointer">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500 cursor-pointer">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                        <!-- More rows... -->
                    </tbody>
                </table>
            </div>
            <!-- Paginazione -->
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-600 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">Indietro</a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">Avanti</a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Mostrando <span class="font-medium">1</span> a <span class="font-medium">10</span> di <span class="font-medium">1248</span> risultati
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-4 w-4"></i>
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                                1
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                                2
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                                3
                            </a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                                <span class="sr-only">Next</span>
                                <i data-feather="chevron-right" class="h-4 w-4"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ========================================================== -->
    <!-- MODAL "NUOVA CASISTICA" (CON STILE E ANIMAZIONI) -->
    <!-- ========================================================== -->
    <!-- Overlay:
         - `invisible opacity-0` (stato nascosto)
         - `visible opacity-100` (stato visibile)
         - `transition-opacity duration-300 ease-in-out` (animazione)
    -->
    <div id="modal-nuova-casistica" class="fixed inset-0 z-50 bg-gray-900/60 flex items-center justify-center p-4 invisible opacity-0 transition-opacity duration-300 ease-in-out">

        <!-- Pannello del Modal:
             - `opacity-0 scale-95` (stato nascosto)
             - `opacity-100 scale-100` (stato visibile)
             - `transition-all duration-300 ease-in-out` (animazione)
        -->
        <div id="modal-panel" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl overflow-hidden transform transition-all opacity-0 scale-95">

            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Inserisci Nuova Casistica</h3>
                <button id="modal-close-btn" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Modal Body (Form con icone) -->
            <form id="form-nuova-casistica" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- ID Caso (con icona) -->
                    <div>
                        <label for="id_caso" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID Caso</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-feather="hash" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="text" name="id_caso" id="id_caso" placeholder="#MC-2024-XXXX" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10">
                        </div>
                    </div>

                    <!-- Paziente (con icona) -->
                    <div>
                        <label for="paziente" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Paziente</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-feather="user" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="text" name="paziente" id="paziente" placeholder="PZ-XXXXXX" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10">
                        </div>
                    </div>

                    <!-- Data Registrazione (con icona) -->
                    <div>
                        <label for="data_registrazione" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Registrazione</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-feather="calendar" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="date" name="data_registrazione" id="data_registrazione" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10">
                        </div>
                    </div>

                    <!-- Medico (con icona) -->
                    <div>
                        <label for="medico" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medico</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-feather="user-check" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="text" name="medico" id="medico" placeholder="Dr. Rossi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10">
                        </div>
                    </div>

                    <!-- Stato (con icona e chevron) -->
                    <div>
                        <label for="stato" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stato</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-feather="activity" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <select id="stato" name="stato" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10 pr-10 appearance-none">
                                <option>Nuovo</option>
                                <option>In Analisi</option>
                                <option>In Revisione</option>
                                <option>Chiuso</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sintesi AI (con icona e chevron) -->
                    <div>
                        <label for="sintesi_ai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sintesi AI (Priorità)</label>
                        <div class="relative mt-1">
                             <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-feather="zap" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <select id="sintesi_ai" name="sintesi_ai" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10 pr-10 appearance-none">
                                <option>Non definita</option>
                                <option>Bassa priorità</option>
                                <option>Media priorità</option>
                                <option>Alta priorità</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnosi Ingresso (con icona) -->
                    <div class="md:col-span-2">
                        <label for="diagnosi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diagnosi Ingresso</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute top-3 left-0 flex items-center pl-3">
                                <i data-feather="file-text" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <textarea id="diagnosi" name="diagnosi" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-10" placeholder="Descrivere la diagnosi iniziale..."></textarea>
                        </div>
                    </div>

                    <!-- ============================================= -->
                    <!-- MODIFICA: Aggiunta Sezione Upload Documento -->
                    <!-- ============================================= -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Documento Associato (Opzionale)</label>
                        <div id="file-drop-zone" class="relative mt-1 flex flex-col items-center justify-center w-full p-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                            <i data-feather="upload-cloud" class="w-10 h-10 text-gray-400"></i>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300"><span class="font-semibold text-blue-600 dark:text-blue-400">Clicca per caricare</span> o trascina un file</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG, PNG, DOCX (max 10MB)</p>
                            <!-- Input file nascosto -->
                            <input type="file" id="file_associato" name="file_associato" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                        <!-- Nome del file selezionato -->
                        <span id="file-name-display" class="mt-1 text-sm text-gray-600 dark:text-gray-400"></span>
                    </div>

                </div>
            </form>

            <!-- Modal Footer (con animazioni hover) -->
            <div class="flex justify-end items-center p-4 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600 space-x-3">
                <button id="modal-cancel-btn" class="bg-white dark:bg-gray-600 hover:bg-gray-100 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 py-2 px-4 rounded-md transition-all duration-150 ease-in-out border border-gray-300 dark:border-gray-500 shadow-sm text-sm font-medium transform hover:scale-[1.03] hover:shadow-md">
                    Annulla
                </button>
                <button type="submit" form="form-nuova-casistica" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-all duration-150 ease-in-out shadow-sm text-sm font-medium transform hover:scale-[1.03] hover:shadow-md">
                    Salva Casistica
                </button>
            </div>
        </div>
    </div>
    <!-- FINE MODAL -->


    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-12">
        <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; 2025 MediClinic. Tutti i diritti riservati.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Privacy Policy</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Termini di Servizio</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Contatti</a>
            </div>
        </div>
    </footer>


 <!-- Chatbot Overlay -->
 <div class="fixed inset-0 z-50 invisible opacity-50 transition-opacity duration-300 ease-in-out" id="chatbot-overlay">
    <div class="absolute inset-0 bg-black opacity-50" id="chatbot-backdrop"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-gray-800 shadow-xl transform transition-transform duration-300 ease-in-out translate-x-full" id="chatbot-panel">
      <div class="h-full flex flex-col">
        <div class="flex items-center justify-between bg-blue-600 dark:bg-blue-800 text-white px-4 py-3">
          <h3 class="font-medium text-lg">MediConsult AI</h3>
          <button id="chatbot-close" class="text-white hover:text-blue-200">
            <i data-feather="x" class="w-5 h-5"></i>
          </button>
        </div>

        <!-- Messaggi -->
        <div class="flex-1 p-4 overflow-y-auto space-y-4" id="chat-messages">
          <div class="flex justify-start">
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs">
              <p class="text-sm text-gray-800 dark:text-gray-200" id="welcome-msg">
                Ciao! Sono MediConsult AI. Posso analizzare referti (PDF, immagini) o rispondere a domande mediche. Come posso aiutarti?
              </p>
            </div>
          </div>
        </div>

        <!-- Composer + Input -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
          <!-- Lista allegati in attesa (chip) -->
          <div id="attachment-list" class="mb-3 hidden">
            <div class="flex items-start justify-between mb-2">
              <p class="text-xs text-gray-600 dark:text-gray-300">
                I file qui sotto verranno inviati con il messaggio.
              </p>
              <button id="clear-all" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white">
                Svuota
              </button>
            </div>
            <div id="attachment-chips" class="flex flex-wrap gap-2"></div>
          </div>

          <!-- Drop area -->
          <div id="drop-area" class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 mb-3 hidden">
            <div class="text-center">
              <i data-feather="upload" class="w-8 h-8 mx-auto text-gray-400"></i>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Trascina qui i file o clicca per selezionare</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">Supportiamo PDF, DOC, JPG, PNG</p>
            </div>
            <!-- Accetta tipi di file generici dato che la logica è simulata -->
            <input type="file" id="fileElem" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
          </div>

          <!-- Chat input -->
          <div class="flex">
            <input type="text" id="chat-input" placeholder="Scrivi un messaggio..." class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 outline-none focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white px-3 py-2">
            <button id="send-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-md">
              <i data-feather="send" class="w-5 h-5"></i>
            </button>
          </div>
          <div class="mt-2 flex justify-between items-center">
            <button id="attach-btn" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm flex items-center">
              <i data-feather="paperclip" class="w-4 h-4 mr-1"></i> Allega file
            </button>
            <span class="text-xs text-gray-500 dark:text-gray-400">Oppure trascina qui i file</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toggle -->
  <div class="fixed bottom-6 right-6 z-40">
    <button id="chatbot-toggle" class="p-4 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition flex items-center justify-center">
      <i data-feather="message-square" class="w-6 h-6"></i>
    </button>
  </div>


  <!-- Script principale -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {

      // Inizializza TUTTE le icone (incluse sole/luna) una sola volta
      // Questo troverà anche le icone nel modal nascosto
      feather.replace();

      // ----- VARIABILI CHATBOT -----
      const chatbotToggle = document.getElementById('chatbot-toggle');
      const chatbotOverlay = document.getElementById('chatbot-overlay');
      const chatbotBackdrop = document.getElementById('chatbot-backdrop');
      const chatbotClose = document.getElementById('chatbot-close');
      const chatbotPanel = document.getElementById('chatbot-panel');

      const dropArea = document.getElementById('drop-area');
      const fileElem = document.getElementById('fileElem');
      const attachBtn = document.getElementById('attach-btn');

      const chatInput = document.getElementById('chat-input');
      const sendBtn = document.getElementById('send-btn');
      const chatMessages = document.getElementById('chat-messages');

      const attachmentList = document.getElementById('attachment-list');
      const chipsWrap = document.getElementById('attachment-chips');
      const clearAllBtn = document.getElementById('clear-all');

      // ----- STATO CHATBOT -----
      let pendingFiles = [];
      let dragCounter = 0;
      let isAwaitingResponse = false; // Previene invii multipli


      // ===================================================================
      // LOGICA PER IL MODAL "NUOVA CASISTICA" (con animazioni e upload)
      // ===================================================================

      // ----- VARIABILI MODAL NUOVA CASISTICA -----
      const btnNuovaCasistica = document.getElementById('btn-nuova-casistica');
      const modalNuovaCasistica = document.getElementById('modal-nuova-casistica');
      const modalPanel = document.getElementById('modal-panel'); // Pannello interno
      const modalCloseBtn = document.getElementById('modal-close-btn');
      const modalCancelBtn = document.getElementById('modal-cancel-btn');
      const formNuovaCasistica = document.getElementById('form-nuova-casistica');

      // ----- VARIABILI UPLOAD FILE -----
      const fileDropZone = document.getElementById('file-drop-zone');
      const fileInput = document.getElementById('file_associato');
      const fileNameDisplay = document.getElementById('file-name-display');

      // Funzione per aprire il modal
      function openModal() {
          if (modalNuovaCasistica && modalPanel) {
              modalNuovaCasistica.classList.remove('invisible');
              modalNuovaCasistica.classList.add('visible');

              // Rimuovi le classi "hidden" per avviare l'animazione "pop-in"
              modalNuovaCasistica.classList.remove('opacity-0');
              modalPanel.classList.remove('opacity-0', 'scale-95');

              document.body.style.overflow = 'hidden'; // Blocca lo scroll

              // Resetta il campo file
              if (fileNameDisplay) fileNameDisplay.textContent = '';
              if (fileInput) fileInput.value = null; // Pulisce i file selezionati
              if (fileDropZone) fileDropZone.classList.remove('border-green-500', 'border-blue-500', 'bg-blue-50');

              // Assicura che le icone nel modal siano renderizzate
              feather.replace();
          }
      }

      // Funzione per chiudere il modal
      function closeModal() {
          if (modalNuovaCasistica && modalPanel) {
              // Aggiungi le classi "hidden" per avviare l'animazione "pop-out"
              modalNuovaCasistica.classList.add('opacity-0');
              modalPanel.classList.add('opacity-0', 'scale-95');

              // Aspetta la fine dell'animazione (300ms) prima di nascondere
              setTimeout(() => {
                  modalNuovaCasistica.classList.add('invisible');
                  modalNuovaCasistica.classList.remove('visible');
                  document.body.style.overflow = 'auto'; // Riabilita lo scroll
              }, 300);
          }
      }

      // ----- LISTENER MODAL -----
      if (btnNuovaCasistica) {
          btnNuovaCasistica.addEventListener('click', openModal);
      }
      if (modalCloseBtn) {
          modalCloseBtn.addEventListener('click', closeModal);
      }
      if (modalCancelBtn) {
          modalCancelBtn.addEventListener('click', closeModal);
      }

      // Chiudi il modal se si clicca sullo sfondo (l'overlay stesso)
      if (modalNuovaCasistica) {
          modalNuovaCasistica.addEventListener('click', function(e) {
              if (e.target === modalNuovaCasistica) {
                  closeModal();
              }
          });
      }

      // ----- LOGICA UPLOAD FILE -----
      if (fileDropZone && fileInput && fileNameDisplay) {

          // Feedback al cambio file (sia da click che da drop)
          fileInput.addEventListener('change', () => {
              if (fileInput.files.length > 0) {
                  fileNameDisplay.textContent = `File selezionato: ${fileInput.files[0].name}`;
                  fileDropZone.classList.add('border-green-500'); // Feedback positivo
                  fileDropZone.classList.remove('border-blue-500', 'bg-blue-50');
              } else {
                  fileNameDisplay.textContent = '';
                  fileDropZone.classList.remove('border-green-500');
              }
          });

          // Gestione Drag & Drop
          fileDropZone.addEventListener('dragover', (e) => {
              e.preventDefault();
              e.stopPropagation();
              fileDropZone.classList.add('border-blue-500', 'bg-blue-50');
          });

          fileDropZone.addEventListener('dragleave', (e) => {
              e.preventDefault();
              e.stopPropagation();
              fileDropZone.classList.remove('border-blue-500', 'bg-blue-50');
          });

          fileDropZone.addEventListener('drop', (e) => {
              e.preventDefault();
              e.stopPropagation();
              fileDropZone.classList.remove('border-blue-500', 'bg-blue-50');

              const files = e.dataTransfer.files;
              if (files.length > 0) {
                  fileInput.files = files; // Assegna i file droppati all'input
                  // Scatena manualmente l'evento 'change' per aggiornare l'UI
                  fileInput.dispatchEvent(new Event('change'));
              }
          });
      }

      // Gestione submit form (con feedback visivo, senza alert)
      if(formNuovaCasistica) {
          formNuovaCasistica.addEventListener('submit', function(e) {
              e.preventDefault(); // Impedisce il submit reale

              const formData = new FormData(formNuovaCasistica);
              // Il file è già in formData grazie a name="file_associato"
              const data = Object.fromEntries(formData.entries());
              console.log("Dati del form pronti per essere inviati:", data);

              const submitBtn = formNuovaCasistica.querySelector('button[type="submit"]');
              if (!submitBtn) return;

              // 1. Mostra stato di caricamento
              submitBtn.disabled = true;
              submitBtn.classList.add('inline-flex', 'items-center');
              submitBtn.innerHTML = `
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Salvataggio...
              `;

              // 2. Simula salvataggio (1.5 secondi)
              setTimeout(() => {
                  // 3. Mostra stato "Salvato"
                  submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                  submitBtn.classList.add('bg-green-600');
                  submitBtn.innerHTML = '<i data-feather="check" class="w-5 h-5 mr-2"></i> Salvato!';
                  feather.replace(); // Aggiorna l'icona

                  // 4. Attendi 1 secondo e chiudi/resetta
                  setTimeout(() => {
                      closeModal();
                      formNuovaCasistica.reset();

                      // Resetta il display del file
                      if (fileNameDisplay) fileNameDisplay.textContent = '';
                      if (fileDropZone) fileDropZone.classList.remove('border-green-500');

                      // Resetta il pulsante
                      submitBtn.disabled = false;
                      submitBtn.classList.remove('bg-green-600', 'inline-flex', 'items-center');
                      submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                      submitBtn.innerHTML = 'Salva Casistica';
                  }, 1000); // Tempo di visualizzazione "Salvato"

              }, 1500); // Tempo di salvataggio simulato
          });
      }
      // ----- FINE LOGICA MODAL -----
      // ===================================================================


      /**
       * Abilita o disabilita l'interfaccia utente della chat durante l'attesa.
       * @param {boolean} isEnabled - True per abilitare, false per disabilitare.
       */
      function setChatUIEnabled(isEnabled) {
        chatInput.disabled = !isEnabled;
        sendBtn.disabled = !isEnabled;
        attachBtn.disabled = !isEnabled;

        if (isEnabled) {
          chatInput.placeholder = "Scrivi un messaggio...";
        } else {
          chatInput.placeholder = "AI sta elaborando...";
        }
      }

      // ----- GESTIONE DRAG & DROP -----

      function preventAllWhenChatOpen(e) {
        // Modificato per non controllare 'hidden'
        if (!chatbotOverlay.classList.contains('invisible')) {
          e.preventDefault();
          e.stopPropagation();
        }
      }
      window.addEventListener('dragover', preventAllWhenChatOpen, false);
      window.addEventListener('drop', preventAllWhenChatOpen, false);

      function eventHasFiles(e) {
        const types = e?.dataTransfer?.types;
        if (!types) return false;
        try { return Array.from(types).includes('Files'); }
        catch { return types.contains && types.contains('Files'); }
      }

      function showDropArea(){ if (!isAwaitingResponse) dropArea.classList.remove('hidden'); }
      function hideDropArea(){ dropArea.classList.add('hidden'); dragCounter = 0; }

      chatbotOverlay.addEventListener('dragenter', (e) => {
        if (!eventHasFiles(e)) return;
        dragCounter++;
        showDropArea();
      }, false);

      chatbotOverlay.addEventListener('dragover', (e) => {
        if (!eventHasFiles(e)) return;
        e.preventDefault(); e.stopPropagation();
      }, false);

      chatbotOverlay.addEventListener('dragleave', (e) => {
        if (!eventHasFiles(e)) return;
        dragCounter = Math.max(0, dragCounter - 1);
        if (dragCounter === 0) hideDropArea();
      }, false);

      chatbotOverlay.addEventListener('drop', (e) => {
        if (!eventHasFiles(e) || isAwaitingResponse) return;
        e.preventDefault(); e.stopPropagation();
        hideDropArea();
        handleFiles({ target: { files: e.dataTransfer.files } });
      }, false);

      ['dragenter','dragover'].forEach(ev => {
        dropArea.addEventListener(ev, () => {
          dropArea.classList.add('border-blue-500','bg-blue-50','dark:bg-blue-900');
        }, false);
      });
      ['dragleave','drop'].forEach(ev => {
        dropArea.addEventListener(ev, () => {
          dropArea.classList.remove('border-blue-500','bg-blue-50','dark:bg-blue-900');
        }, false);
      });

      // ----- GESTIONE SELEZIONE FILE -----

      fileElem.addEventListener('change', handleFiles, false);

      attachBtn.addEventListener('click', () => {
        if (!isAwaitingResponse) {
          dropArea.classList.toggle('hidden');
        }
      });

      clearAllBtn.addEventListener('click', () => { pendingFiles = []; renderChips(); });

      /**
       * Gestisce i file selezionati (da drop o click).
       */
      function handleFiles(e) {
        const files = e.target.files;
        if (!files || !files.length) return;

        for (const f of files) {
            pendingFiles.push(f);
        }
        renderChips();
        hideDropArea();
      }

      /**
       * Mostra i file in attesa come "chip" nell'interfaccia.
       */
      function renderChips() {
        chipsWrap.innerHTML = '';
        if (pendingFiles.length === 0) {
          attachmentList.classList.add('hidden');
          return;
        }
        attachmentList.classList.remove('hidden');

        pendingFiles.forEach((file, idx) => {
          const chip = document.createElement('div');
          chip.className = 'inline-flex items-center gap-2 px-2 py-1 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow-sm';

          const icon = document.createElement('i');
          icon.setAttribute('data-feather', getFileIcon(file.type));
          icon.className = 'w-3.5 h-3.5 text-blue-600 dark:text-blue-300';

          const name = document.createElement('span');
          name.className = 'text-xs text-gray-800 dark:text-gray-200 max-w-[9rem] truncate';
          name.textContent = file.name;

          const size = document.createElement('span');
          size.className = 'text-[10px] text-gray-500 dark:text-gray-400';
          size.textContent = humanFileSize(file.size);

          const remove = document.createElement('button');
          remove.className = 'p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700';
          remove.innerHTML = '<i data-feather="x" class="w-3 h-3 text-gray-500"></i>';
          remove.addEventListener('click', () => {
            pendingFiles.splice(idx, 1);
            renderChips();
          });

          chip.append(icon, name, size, remove);
          chipsWrap.appendChild(chip);
        });

        feather.replace(); // Aggiorna le icone nei chip
      }

      // ===== INVIO MESSAGGI E RISPOSTA FINTA =====
      sendBtn.addEventListener('click', onSend);
      chatInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') onSend(); });

      /**
       * Gestisce l'evento di invio del messaggio (testo e/o file)
       */
      async function onSend() {
        if (isAwaitingResponse) return;

        const text = chatInput.value.trim();
        const filesToSend = [...pendingFiles]; // Copia i file

        if (text === '' && filesToSend.length === 0) {
          return; // Non inviare messaggi vuoti
        }

        isAwaitingResponse = true;
        setChatUIEnabled(false);

        // Pulisci l'input e i file in attesa dall'UI
        chatInput.value = '';
        pendingFiles = [];
        renderChips();

        // 1. Mostra il messaggio dell'utente nell'UI
        if (filesToSend.length > 0) {
            addUserFilesMessage(filesToSend, text); // Mostra card file nell'UI
        } else {
            addUserTextMessage(text); // Mostra bolla testo nell'UI
        }

        // 2. Mostra il loading dell'AI
        const loadingMsgId = `msg-${Date.now()}`;
        addAIResponse(null, loadingMsgId); // Passa null per mostrare il loading

        // 3. Simula ritardo della risposta
        setTimeout(() => {
          let aiTextResponse;
          if (filesToSend.length > 0) {
              aiTextResponse = `Ho ricevuto ${filesToSend.length} file. Analisi simulata completata. Il testo associato era: "${text || 'Nessuno'}".`;
          } else {
              aiTextResponse = getAIResponse(text);
          }

          // 4. Aggiorna la bolla di loading con la risposta effettiva
          addAIResponse(aiTextResponse, loadingMsgId);

          // 5. Riabilita l'interfaccia utente
          isAwaitingResponse = false;
          setChatUIEnabled(true);
          chatInput.focus();
        }, 1200); // Ritardo di 1.2 secondi
      }

      /**
       * Genera una risposta finta basata su regex.
       * @param {string} message - Il testo dell'utente.
       */
      function getAIResponse(message) {
        const lower = message.toLowerCase();
        if (lower.match(/ciao|salve|buongiorno/)) {
            return 'Ciao! Come posso aiutarti con la tua casistica medica oggi?';
        }
        if (lower.match(/analisi|analizza|risultati|referto/)) {
            return 'Posso aiutarti ad analizzare i risultati medici. Per favore carica il documento o descrivi i valori.';
        }
        if (lower.match(/grazie|grazie mille/)) {
            return 'Prego! Sono qui per aiutarti. Hai altre domande?';
        }
        if (lower.match(/come stai/)) {
            return 'Sono un sistema virtuale, ma funziono correttamente. Grazie per aver chiesto!';
        }
        return 'Ho ricevuto la tua richiesta. Sto elaborando una risposta simulata...';
      }


      // ===== RENDERING IN CHAT =====

      /**
       * Mostra la bolla di testo dell'utente.
       */
      function addUserTextMessage(text) {
        const userDiv = document.createElement('div');
        userDiv.className = 'flex justify-end';
        const bubble = document.createElement('div');
        bubble.className = 'bg-blue-600 text-white rounded-lg p-3 max-w-xs';
        const p = document.createElement('p');
        p.className = 'text-sm whitespace-pre-wrap'; // Aggiunto whitespace-pre-wrap
        p.textContent = text;
        bubble.appendChild(p);
        userDiv.appendChild(bubble);
        chatMessages.appendChild(userDiv);
        scrollBottom();
      }

      /**
       * Mostra la card dei file inviati dall'utente (con testo opzionale).
       */
      function addUserFilesMessage(files, text) {
        const wrap = document.createElement('div');
        wrap.className = 'flex justify-end';

        const card = document.createElement('div');
        card.className = 'bg-blue-100 dark:bg-blue-900 rounded-lg p-3 max-w-xs';

        // Lista file
        files.forEach(file => {
          const row = document.createElement('div');
          row.className = 'flex items-center';
          if (card.childElementCount > 0) row.classList.add('mt-2'); // Spazio tra i file

          const icon = document.createElement('i');
          icon.setAttribute('data-feather', getFileIcon(file.type));
          icon.className = 'w-4 h-4 mr-2 text-blue-600 dark:text-blue-300 flex-shrink-0';

          const name = document.createElement('span');
          name.className = 'text-sm text-blue-800 dark:text-blue-200 truncate';
          name.textContent = `${file.name} (${humanFileSize(file.size)})`;

          row.append(icon, name);
          card.appendChild(row);
        });

        // Aggiungi il testo se presente
        if (text) {
          const hr = document.createElement('div');
          hr.className = 'my-2 h-px bg-blue-200/60 dark:bg-blue-800/60';
          card.appendChild(hr);

          const noteEl = document.createElement('p');
          noteEl.className = 'text-sm text-blue-900 dark:text-blue-100 whitespace-pre-wrap';
          noteEl.textContent = text;
          card.appendChild(noteEl);
        }

        wrap.appendChild(card);
        chatMessages.appendChild(wrap);
        scrollBottom();
        feather.replace(); // Aggiorna icone
      }

      /**
       * Aggiunge una risposta AI o un indicatore di loading.
       */
      function addAIResponse(text, msgId) {
        let msgElement = document.getElementById(msgId);
        let bubble;

        if (!msgElement) {
          // 1. Crea un nuovo contenitore per il messaggio
          const aiDiv = document.createElement('div');
          aiDiv.className = 'flex justify-start';
          aiDiv.id = msgId;

          bubble = document.createElement('div');
          bubble.className = 'bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-w-xs';

          aiDiv.appendChild(bubble);
          chatMessages.appendChild(aiDiv);

        } else {
          // 2. Trova il messaggio esistente
          bubble = msgElement.querySelector('div');
          bubble.innerHTML = ''; // Pulisci il contenuto (i puntini)
        }

        // 3. Imposta il contenuto (loading o testo)
        if (text === null) {
          bubble.innerHTML = `
            <div class="flex space-x-1.5 p-1">
              <div class="w-2 h-2 bg-gray-400 rounded-full loading-dot"></div>
              <div class="w-2 h-2 bg-gray-400 rounded-full loading-dot"></div>
              <div class="w-2 h-2 bg-gray-400 rounded-full loading-dot"></div>
            </div>`;
        } else {
          const p = document.createElement('p');
          p.className = 'text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap';
          p.textContent = text;
          bubble.appendChild(p);
        }

        scrollBottom();
      }

      function scrollBottom(){ chatMessages.scrollTop = chatMessages.scrollHeight; }

      // ===== HELPERS =====

      /**
       * Restituisce l'icona Feather appropriata per il tipo di file.
       */
      function getFileIcon(fileType) {
        if (!fileType) return 'file';
        if (fileType.includes('pdf')) return 'file-text';
        if (fileType.includes('image')) return 'image';
        if (fileType.includes('word') || fileType.includes('document')) return 'file-text';
        return 'file';
      }

      /**
       * Formatta i byte in una stringa leggibile (KB, MB).
       */
      function humanFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024, sizes = ['B','KB','MB','GB','TB'];
        const i = Math.floor(Math.log(bytes)/Math.log(k));
        return parseFloat((bytes/Math.pow(k,i)).toFixed(1)) + ' ' + sizes[i];
      }

      // ===== TOGGLE CHATBOT (MODIFICATO PER SLIDE) =====

      chatbotToggle.addEventListener('click', () => {
        // Rendi visibile l'overlay e fai fade-in
        chatbotOverlay.classList.remove('invisible');
        chatbotOverlay.classList.add('opacity-100');
        // Fai scorrere il pannello
        chatbotPanel.classList.remove('translate-x-full');

        document.body.style.overflow = 'hidden';
        chatInput.focus();
      });

      function closeOverlay(){
        // Fai fade-out l'overlay e scorri fuori il pannello
        chatbotOverlay.classList.remove('opacity-100');
        chatbotPanel.classList.add('translate-x-full');

        document.body.style.overflow = 'auto';
        // Pulisci lo stato dei file in attesa
        hideDropArea();
        pendingFiles = [];
        renderChips();

        // Nascondi l'overlay dopo la fine della transizione (300ms)
        setTimeout(() => {
            chatbotOverlay.classList.add('invisible');
        }, 300);
      }

      chatbotClose.addEventListener('click', closeOverlay);
      chatbotBackdrop.addEventListener('click', closeOverlay);

      const themeBtn = document.getElementById('theme-toggle-btn');
      if (themeBtn) {
          themeBtn.addEventListener('click', toggleTheme);
      }

    });
  </script>
</body>
</html>

