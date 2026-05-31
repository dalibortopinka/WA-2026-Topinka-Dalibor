<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>KOPAČKA - Fotbalový bazar</title>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="max-w-5xl mx-auto px-4 py-6">
        
        <header class="mb-8 border-b-2 border-emerald-100 pb-4 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <a href="<?= BASE_URL ?>/index.php" class="block transition-transform transform hover:scale-102">
                <img src="<?= BASE_URL ?>/images/logo.png" alt="Kopačka - fotbalový bazar" class="h-16 w-auto">
            </a>
            
            <nav class="mt-2 md:mt-0">
                <ul class="flex flex-col sm:flex-row items-center gap-3">
                    
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="block px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl transition-colors font-semibold text-center text-sm">
                            Nabídka bazaru
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=cleat/create" class="block px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md transition-colors font-semibold text-center text-sm">
                                + Přidat inzerát
                            </a>
                        </li>
                        
                        <li class="text-slate-600 text-sm sm:ml-4 sm:mr-2 py-2">
                            Ahoj, <span class="text-emerald-700 font-bold tracking-wide"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded-full font-bold ml-1">Admin</span>
                            <?php endif; ?>
                        </li>
                        
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="block px-4 py-2 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-xl transition-colors text-xs uppercase tracking-wider font-bold text-center">
                                Odhlásit
                            </a>
                        </li>

                    <?php else: ?>
                        <li class="sm:ml-4">
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="block px-5 py-2.5 text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 rounded-xl transition-colors font-semibold text-center text-sm">
                                Přihlásit se
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="block px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md transition-colors font-semibold text-center text-sm">
                                Registrace
                            </a>
                        </li>
                    <?php endif; ?>
                    
                </ul>
            </nav>
        </header>

        <main>
            
            <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
                <div class="mb-8 space-y-3">
                    
                    <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                        <?php 
                            // Určení barev podle typu systémové zprávy
                            $colorClasses = 'bg-slate-50 text-slate-700 border-slate-200';
                            if ($type === 'success') $colorClasses = 'bg-emerald-50 text-emerald-800 border-emerald-200';
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
                    // Po úspěšném vypsání zprávy vymažeme ze Session, aby při dalším F5 zmizely
                    unset($_SESSION['messages']); 
                ?>
            <?php endif; ?>