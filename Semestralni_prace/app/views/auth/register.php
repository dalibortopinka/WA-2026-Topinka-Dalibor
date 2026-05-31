<?php
// Načtení společné hlavičky webu
require_once '../app/views/layout/header.php';
?>

<div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden my-8">
    
    <div class="bg-emerald-600 px-6 py-5 text-white text-center">
        <h1 class="text-xl font-bold tracking-tight">Vytvoření nového účtu</h1>
        <p class="text-xs text-emerald-100 mt-1">Zaregistrujte se do bazaru KOPAČKA a začněte prodávat nebo nakupovat.</p>
    </div>

    <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="POST" class="p-6 space-y-5">
        
        <div class="space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-1">Přihlašovací údaje</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 mb-1">Uživatelské jméno *</label>
                    <input type="text" name="username" id="username" required placeholder="Např. dalibor10"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">E-mailová adresa *</label>
                    <input type="email" name="email" id="email" required placeholder="jmeno@email.cz"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-1">Osobní údaje (Volitelné)</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-xs font-semibold text-slate-700 mb-1">Jméno</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Dalibor"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                </div>

                <div>
                    <label for="last_name" class="block text-xs font-semibold text-slate-700 mb-1">Příjmení</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Topinka"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                </div>
            </div>

            <div>
                <label for="nickname" class="block text-xs font-semibold text-slate-700 mb-1">Zobrazovaná přezdívka (Ideální pro bazar)</label>
                <input type="text" name="nickname" id="nickname" placeholder="Např. Topas"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                <p class="text-[10px] text-slate-400 mt-1">Pokud přezdívku nevyplníte, bude se u inzerátů zobrazovat vaše uživatelské jméno.</p>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-1">Zabezpečení účtu</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Heslo *</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                           minlength="8" pattern="(?=.*\d).{8,}"
                           title="Heslo musí mít alespoň 8 znaků a obsahovat minimálně jedno číslo."
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                    <p class="text-[10px] text-slate-400 mt-1">Minimálně 8 znaků a 1 číslo.</p>
                </div>

                <div>
                    <label for="password_confirm" class="block text-xs font-semibold text-slate-700 mb-1">Potvrzení hesla *</label>
                    <input type="password" name="password_confirm" id="password_confirm" required placeholder="••••••••"
                           minlength="8" pattern="(?=.*\d).{8,}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-[11px] text-slate-400">* Označené údaje jsou povinné pro vytvoření účtu.</span>
            
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors cursor-pointer">
                Dokončit registraci
            </button>
        </div>

        <div class="text-center text-xs text-slate-500 pt-2">
            Už u nás máte účet? 
            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-emerald-700 font-bold hover:underline ml-0.5">
                Přihlaste se zde
            </a>
        </div>

    </form>
</div>

<?php
// Načtení společné patičky webu
require_once '../app/views/layout/footer.php';
?>