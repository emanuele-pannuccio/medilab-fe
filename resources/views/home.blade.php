<!DOCTYPE html>
<html lang="it" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medilab - Login</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
  @vite(["resources/js/app.js", "resources/css/app.css"])
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center transition-colors duration-300">

    <!-- Pulsante per il Toggle del Tema -->
    <button
        id="theme-toggle"
        class="fixed top-6 right-6 p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all z-10"
        aria-label="Toggle theme"
    >
        <!-- Icona Sole (mostrata in dark mode, per passare a light) -->
        <i data-feather="sun" class="w-5 h-5 hidden dark:block"></i>
        <!-- Icona Luna (mostrata in light mode, per passare a dark) -->
        <i data-feather="moon" class="w-5 h-5 block dark:hidden"></i>
    </button>

    <div class="w-full max-w-md p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700">
            <div class="text-center mb-8 pointer-events-none select-none">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Medilab</h1>
                <p class="text-primary dark:text-white text-lg font-medium">Portale di Analisi Clinica Avanzata</p>
            </div>

            <!-- Message -->
            <!-- Aggiorniamo le classi per light/dark mode -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <p class="text-gray-700 dark:text-gray-300 text-sm text-center pointer-events-none select-none">
                    Accesso riservato allo staff medico autorizzato.
                </p>
            </div>

            <!-- Login Form -->
            <form class="space-y-6">
                <!-- User ID -->
                <div>
                    <!-- Aggiorniamo le classi per light/dark mode -->
                    <label for="user-id" class=" pointer-events-none select-none block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        ID Utente
                    </label>
                    <input
                        type="text"
                        id="user-id"
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 select-none rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        placeholder="Inserisci il tuo ID utente"
                    >
                </div>

                <!-- Password -->
                <div>
                    <!-- Aggiorniamo le classi per light/dark mode -->
                    <label for="password" class="block pointer-events-none select-none text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        placeholder="Inserisci la tua password"
                    >
                </div>

                <!-- Login Button (il colore 'primary' funziona bene in entrambi i temi) -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-400 cursor-pointer text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50"
                >
                    Accedi
                </button>
            </form>

            <!-- Footer -->
            <!-- Aggiorniamo le classi per light/dark mode -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 pointer-events-none select-none">
                <p class="text-gray-500 dark:text-gray-400 text-xs text-center">
                    © Medilab - Riservato e Confidenziale
                </p>
            </div>
        </div>
    </div>

    <!-- Rimuoviamo il link a 'script.js' che non abbiamo -->
    <!-- <script src="script.js"></script> -->
    <script>
        // Inizializza le icone Feather
        feather.replace();

        // Handle login form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            // In a real app, this would authenticate with a backend
            // Per ora, simuliamo il reindirizzamento
            console.log("Login tentato. Reindirizzamento a dashboard.html...");
            // window.location.href = 'dashboard.html';
        });

        // --- Logica per il Toggle del Tema ---

        const themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // Controlla se il tema dark è attualmente attivo
            const isDark = document.documentElement.classList.contains('dark');

            if (isDark) {
                // Passa a light
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                // Passa a dark
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }

            // NON è necessario richiamare feather.replace() qui,
            // perché le icone sono già nel DOM e vengono mostrate/nascoste
            // puramente con le classi 'dark:block' e 'dark:hidden' di Tailwind.
        });
    </script>
</body>
</html>
