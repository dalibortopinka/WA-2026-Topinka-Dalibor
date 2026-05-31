<?php
// Načtení společné hlavičky webu
require_once '../app/views/layout/header.php';
?>

<div class="max-w-md mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden my-8">
    
    <!-- Záhlaví karty přihlášení -->
    <div class="bg-emerald-600 px-6 py-5 text-white text-center">
        <h1 class="text-xl font-bold tracking-tight">Přihlášení do bazaru</h1>
        <p class="text-xs text-emerald-100 mt-1">Vstupte do svého účtu KOPAČKA a spravujte své inzeráty.</p>
    </div>

    <!-- Přihlašovací formulář -->
    <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="POST" class="p-6 space-y-4">
        
        <!-- E-mailová adresa -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">E-mailová adresa *</label>
            <input type="email" name="email" id="email" required placeholder="napriklad@email.cz"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
        </div>

        <!-- Heslo -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Heslo *</label>
            <input type="password" name="password" id="password" required placeholder="••••••••"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
        </div>

        <!-- Tlačítko pro odeslání -->
        <div class="pt-2">
            <button type="submit" class="w-full px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors cursor-pointer">
                Přihlásit se
            </button>
        </div>

        <!-- Odkaz na registraci pro nové uživatele -->
        <div class="border-t border-slate-100 pt-4 text-center text-xs text-slate-500">
            Ještě u nás nemáte účet? 
            <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-emerald-700 font-bold hover:underline ml-0.5">
                Zaregistrujte se zde
            </a>
        </div>

    </form>
</div>

<?php
// Načtení společné patičky webu
require_once '../app/views/layout/footer.php';
?>