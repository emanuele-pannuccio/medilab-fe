<!DOCTYPE html>
<html lang="it" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettaglio Caso - Medilab</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#0ea5e9',
                        secondary: '#64748b'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
    <script src="components/navbar.js"></script>
    <custom-navbar></custom-navbar>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <a href="dashboard.html" class="text-primary hover:text-blue-400 transition-colors">
                        <i data-feather="arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-white">Analisi Dettagliata Caso ID-4567</h1>
                </div>
                <p class="text-gray-400">Dettaglio completo del caso clinico con analisi AI</p>
            </div>

            <!-- Sezione 1: Dati Anagrafici e Clinici -->
            <div class="glass rounded-2xl p-6 mb-6">
                <h2 class="text-xl font-bold text-white mb-4">Dati Anagrafici e Clinici</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Info -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Paziente</h3>
                            <p class="text-white">PT-1234</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Età</h3>
                            <p class="text-white">67 anni</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Sesso</h3>
                            <p class="text-white">Maschio</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Reparto</h3>
                            <p class="text-white">Cardiologia</p>
                        </div>
                    </div>

                    <!-- Medical Info -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Medico Titolare</h3>
                            <p class="text-white">Dr. Bianchi</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Data Registrazione</h3>
                            <p class="text-white">15/01/2024</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-300 mb-2">Diagnosi di Ingresso</h3>
                            <p class="text-white">Cardiomiopatia ipertrofica</p>
                        </div>
                    </div>
                </div>

                <!-- Anamnesi -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-300 mb-2">Anamnesi rilevante</h3>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <p class="text-gray-300 text-sm">
                            Paziente con storia di ipertensione arteriosa da 15 anni, dislipidemia, familiarità per cardiopatia.
                            Presenta dispnea da sforzo progressiva negli ultimi 6 mesi. Ecocardiogramma mostra ipertrofia ventricolare sinistra asimmetrica.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sezione 2: Analisi Completa dell'IA -->
            <div class="glass rounded-2xl p-6 mb-6">
                <h2 class="text-xl font-bold text-white mb-4">Analisi Completa dell'IA</h2>

                <!-- Riepilogo AI -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-3">Riepilogo AI</h3>
                    <div class="bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-300">
                        Il caso presenta caratteristiche tipiche di cardiomiopatia ipertrofica in paziente anziano con comorbidità cardiovascolari.
                        L'analisi predittiva indica un rischio moderato-alto di complicazioni aritmiche.
                    </p>
                </div>

                <!-- Analisi Comparativa -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-3">Analisi Comparativa</h3>
                    <div class="bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-300">
                        Questo caso presenta una somiglianza del 92% con il Cluster 4B (Pazienti con comorbidità ipertensione, dislipidemia, età >65).
                    </p>
                </div>

                <!-- Riferimenti (Casi Simili) -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-3">Riferimenti (Casi Simili)</h3>
                    <div class="space-y-2">
                        <a href="#" class="block text-primary hover:text-blue-400 transition-colors p-3 rounded bg-gray-700 hover:bg-gray-600">
                            <span class="font-medium">ID-1234</span> - Cardiomiopatia ipertrofica con scompenso (89% similarità)
                        </a>
                        <a href="#" class="block text-primary hover:text-blue-400 transition-colors p-3 rounded bg-gray-700 hover:bg-gray-600">
                            <span class="font-medium">ID-2345</span> - Ipertrofia ventricolare in paziente iperteso (87% similarità)
                        </a>
                        <a href="#" class="block text-primary hover:text-blue-400 transition-colors p-3 rounded bg-gray-700 hover:bg-gray-600">
                            <span class="font-medium">ID-3456</span> - Cardiomiopatia con aritmie (85% similarità)
                        </a>
                    </div>
                </div>

                <!-- Analisi Predittiva -->
                <div>
                    <h3 class="text-lg font-semibold text-primary mb-3">Analisi Predittiva</h3>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <p class="text-gray-300">
                            Rischio stimato di complicazioni: 25% (Medio-Alto)<br>
                            Probabilità di risposta positiva al trattamento: 78%<br>
                            Tempo stimato di recupero: 6-8 settimane
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sezione 3: Cronologia ed Eventi -->
            <div class="glass rounded-2xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Cronologia ed Eventi</h2>

                <div class="space-y-4">
                    <!-- Event 1 -->
                    <div class="bg-gray-700 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-green-500 rounded-full p-1 mt-1">
                            <i data-feather="check-circle" class="text-white w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">Inizio Trattamento A</p>
                            <p class="text-gray-400 text-sm">15/01/2024 - Terapia farmacologica con beta-bloccanti</p>
                        </div>
                    </div>
                </div>

                <!-- Event 2 -->
                <div class="bg-gray-700 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-500 rounded-full p-1 mt-1">
                                <i data-feather="activity" class="text-white w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Risposta a Terapia</p>
                                <p class="text-gray-400 text-sm">22/01/2024 - Miglioramento della dispnea e stabilità emodinamica</p>
                            </div>
                        </div>
                    </div>

                    <!-- Event 3 -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-yellow-500 rounded-full p-1 mt-1">
                                <i data-feather="clock" class="text-white w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Dimissioni</p>
                                <p class="text-gray-400 text-sm">05/02/2024 - Programmata per controllo ambulatoriale</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <script src="components/footer.js"></script>
    <custom-footer></custom-footer>

    <script src="script.js"></script>
    <script>
        feather.replace();

        // Check authentication
        if (!auth.checkAuth()) {
            window.location.href = 'index.html';
        }
    </script>
</body>
</html>
