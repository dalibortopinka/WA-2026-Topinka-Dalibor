<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-4 py-10 flex-grow flex items-center justify-center font-sans antialiased">
    <div class="w-full max-w-2xl">
        
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-sky-700">Nová registrace</h2>
            <p class="text-sky-500 mt-2">Vytvořte si účet pro správu vašeho knižního katalogu.</p>
        </div>
        
        <div class="bg-sky-50/50 border border-sky-100 rounded-3xl shadow-sm p-6 md:p-10">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="md:col-span-2">
                        <h3 class="text-sky-700 text-lg font-bold border-b-2 border-sky-200 pb-2 mb-2">Přihlašovací údaje</h3>
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-bold text-sky-700 mb-1.5">Uživatelské jméno <span class="text-red-400">*</span></label>
                        <input type="text" id="username" name="username" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-sky-700 mb-1.5">E-mail <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-sky-700 mb-1.5">Heslo <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-bold text-sky-700 mb-1.5">Potvrzení hesla <span class="text-red-400">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <h3 class="text-sky-700 text-lg font-bold border-b-2 border-sky-200 pb-2 mb-2">Osobní údaje <span class="text-sm font-normal text-sky-500">(Volitelné)</span></h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-sm font-bold text-sky-700 mb-1.5">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-bold text-sky-700 mb-1.5">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="nickname" class="block text-sm font-bold text-sky-700 mb-1.5">Zobrazovaná přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Jak vám máme v aplikaci říkat?"
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all placeholder:text-slate-400">
                    </div>

                    <div class="md:col-span-2 mt-6">
                        <button type="submit" 
                                class="w-full px-8 py-3.5 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-sky-200 text-lg">
                            Vytvořit účet
                        </button>
                        
                        <p class="text-center text-slate-500 mt-6">
                            Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-sky-500 hover:text-sky-700 font-semibold underline decoration-2 underline-offset-4 transition-colors">Přihlaste se zde</a>.
                        </p>
                    </div>
                    
                </div>
            </form>
        </div>
        
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>