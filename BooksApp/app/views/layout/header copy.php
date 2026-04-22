<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Knihovna - Seznam knih</title>
</head>
<body class="bg-white text-sky-600 font-sans antialiased">
    <div class="max-w-5xl mx-auto px-4 py-8">
        
        <header class="mb-8 border-b-2 border-sky-100 pb-6">
            <h1 class="text-4xl font-extrabold text-sky-700 mb-6">Aplikace Knihovna</h1>
            
            <nav>
                <ul class="flex flex-col sm:flex-row gap-3">
                    <li><a href="<?= BASE_URL ?>/index.php" class="block px-5 py-2.5 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-xl transition-colors font-semibold text-center">Seznam knih (Domů)</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="block px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl shadow-md transition-colors font-semibold text-center">Přidat novou knihu</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
                <div class="mb-8 space-y-3">
                    
                    <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                        <?php 
                            // Určení Tailwind barev podle typu zprávy
                            $colorClasses = 'bg-slate-50 text-slate-700 border-slate-200';
                            if ($type === 'success') $colorClasses = 'bg-green-50 text-green-700 border-green-200';
                            if ($type === 'error') $colorClasses = 'bg-red-50 text-red-700 border-red-200';
                            if ($type === 'notice') $colorClasses = 'bg-amber-50 text-amber-700 border-amber-200';
                        ?>
                        
                        <?php foreach ($messages as $message): ?>
                            <div class="border p-4 rounded-xl shadow-sm <?= $colorClasses ?>">
                                <strong class="font-semibold"><?= htmlspecialchars($message) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    
                </div>
                
                <?php 
                    // ZÁSADNÍ KROK: Po vypsání musíme zprávy ze session vymazat
                    unset($_SESSION['messages']); 
                ?>
            <?php endif; ?>