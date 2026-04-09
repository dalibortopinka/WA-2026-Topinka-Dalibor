<?php require_once '../app/views/layout/header.php'; ?>

        <main>
            <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data" class="bg-sky-50/50 p-6 sm:p-10 rounded-3xl shadow-sm border border-sky-100">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <div class="col-span-1 md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-sky-700 mb-1.5">Název knihy <span class="text-red-400">*</span></label>
                        <input type="text" id="title" name="title" required class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>
                    
                    <div>
                        <label for="author" class="block text-sm font-bold text-sky-700 mb-1.5">Autor <span class="text-red-400">*</span></label>
                        <input type="text" id="author" name="author" placeholder="Příjmení Jméno" required class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-bold text-sky-700 mb-1.5">ISBN <span class="text-red-400">*</span></label>
                        <input type="text" id="isbn" name="isbn" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-sky-700 mb-1.5">Kategorie</label>
                        <input type="text" id="category" name="category" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="subcategory" class="block text-sm font-bold text-sky-700 mb-1.5">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-bold text-sky-700 mb-1.5">Rok vydání <span class="text-red-400">*</span></label>
                        <input type="number" id="year" name="year" required class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-sky-700 mb-1.5">Cena knihy (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="link" class="block text-sm font-bold text-sky-700 mb-1.5">Odkaz</label>
                        <input type="text" id="link" name="link" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-bold text-sky-700 mb-1.5">Popis knihy</label>
                        <textarea id="description" name="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">Popis knihy: </textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-2">
                        <label class="block text-sm font-bold text-sky-700 mb-2">Obrázky (můžete nahrát více)</label>
                        <label class="flex flex-col items-center justify-center w-full p-8 border-2 border-dashed border-sky-300 rounded-2xl cursor-pointer hover:border-sky-500 hover:bg-sky-100 transition-colors bg-white">
                            <span class="text-sky-700 font-semibold text-lg">Klikni pro výběr souborů</span>
                            <span class="text-sm text-sky-500 mt-1">JPG / PNG / WebP – více souborů najednou</span>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>

                </div>

                <div class="flex justify-end pt-4 border-t border-sky-100">
                    <button type="submit" class="w-full md:w-auto px-8 py-3.5 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-sky-200">
                        Uložit knihu do DB
                    </button>
                </div>

            </form>

        <?php require_once '../app/views/layout/footer.php'; ?>
