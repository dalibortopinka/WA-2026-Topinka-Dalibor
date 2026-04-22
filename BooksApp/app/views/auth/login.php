<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-4 py-10 flex-grow flex items-center justify-center font-sans antialiased">
    <div class="w-full max-w-md">
        
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-sky-700">Přihlášení</h2>
            <p class="text-sky-500 mt-2">Vítejte zpět v naší Knihovně.</p>
        </div>
        
        <div class="bg-sky-50/50 border border-sky-100 rounded-3xl shadow-sm p-6 md:p-8">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post">
                
                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-bold text-sky-700 mb-1.5">E-mail</label>
                        <input type="email" id="email" name="email" required autofocus
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-sky-700 mb-1.5">Heslo</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full px-8 py-3.5 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-sky-200 text-lg">
                            Přihlásit se
                        </button>
                    </div>
                    
                    <p class="text-center text-slate-500 mt-6 pt-6 border-t border-sky-100">
                        Nemáte ještě účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-sky-500 hover:text-sky-700 font-semibold underline decoration-2 underline-offset-4 transition-colors">Zaregistrujte se</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>