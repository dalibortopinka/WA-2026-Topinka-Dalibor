<?php require_once '../app/views/layout/header.php'; ?>

<body class="bg-white text-sky-600 font-sans antialiased">
    <div class="max-w-4xl mx-auto px-4 py-8">
        
        <header class="mb-8 border-b-2 border-sky-100 pb-6 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-sky-700">Upravit knihu</h2>
                <p class="text-sky-500 mt-2">Upravujete data pro knihu: <strong class="text-sky-700"><?= htmlspecialchars($book['title']) ?></strong></p>
            </div>
            <a href="<?= BASE_URL ?>/index.php" class="text-sm font-semibold text-sky-500 hover:text-sky-700 underline decoration-2 underline-offset-4 transition-colors">&larr; Zpět na seznam</a>
        </header>

        <main>
            <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="bg-sky-50/50 p-6 sm:p-10 rounded-3xl shadow-sm border border-sky-100">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <div class="col-span-1 md:col-span-2">
                        <label for="id_display" class="block text-sm font-bold text-slate-500 mb-1.5">ID v databázi</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly class="w-full md:w-1/3 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-500 bg-slate-100 cursor-not-allowed shadow-inner focus:outline-none">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-sky-700 mb-1.5">Název knihy <span class="text-red-400">*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent text-slate-700 bg-white shadow-sm transition-all">
                    </div>
                    
                    <div>
                        <label for="author" class="block text-sm font-bold text-sky-700 mb-1.5">Autor <span class="text-red-400">*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-bold text-sky-700 mb-1.5">ISBN <span class="text-red-400">*</span></label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="mb-4">
    <label for="category" class="block text-sm font-bold text-sky-800 mb-2">
        Kategorie <span class="text-red-500">*</span>
    </label>
    
    <select id="category" name="category" required 
            class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors">
        
        <option value="" class="text-slate-400">-- Vyberte kategorii --</option>
        
        <?php foreach ($categories as $cat): ?>
            <?php 
            // Zkontrolujeme, zda ID aktuálně vykreslované kategorie odpovídá ID kategorie, kterou má kniha uloženou
            $isSelected = ($book['category'] == $cat['id']) ? 'selected' : ''; 
            ?>
            
            <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $isSelected ?> class="text-slate-700">
                <?= htmlspecialchars($cat['name'] ?? '') ?>
            </option>
        <?php endforeach; ?>
        
    </select>
</div>

<div class="mb-4">
    <label for="subcategory" class="block text-sm font-bold text-sky-700 mb-1.5">Podkategorie</label>
    
    <select id="subcategory" name="subcategory" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
        
        <option value="" class="text-slate-400">-- Vyberte podkategorii --</option>
        
        <?php foreach ($subcategories as $subcat): ?>
            <?php 
            // Zkontrolujeme, zda ID aktuálně vykreslované podkategorie odpovídá ID, které má kniha uloženou
            $isSelected = ($book['subcategory'] == $subcat['id']) ? 'selected' : ''; 
            ?>
            
            <option value="<?= htmlspecialchars($subcat['id']) ?>" <?= $isSelected ?> class="text-slate-700">
                <?= htmlspecialchars($subcat['name'] ?? '') ?>
            </option>
        <?php endforeach; ?>
        
    </select>
</div>

                    <div>
                        <label for="year" class="block text-sm font-bold text-sky-700 mb-1.5">Rok vydání <span class="text-red-400">*</span></label>
                        <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-sky-700 mb-1.5">Cena knihy (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="link" class="block text-sm font-bold text-sky-700 mb-1.5">Odkaz</label>
                        <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>" class="w-full px-4 py-2.5 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-bold text-sky-700 mb-1.5">Popis knihy</label>
                        <textarea id="description" name="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400 text-slate-700 bg-white shadow-sm transition-all"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-2">
                        <label class="block text-sm font-bold text-sky-700 mb-2">Obrázky (zatím neřešíme, můžete ignorovat)</label>
                        <label class="flex flex-col items-center justify-center w-full p-8 border-2 border-dashed border-sky-300 rounded-2xl cursor-pointer hover:border-sky-500 hover:bg-sky-100 transition-colors bg-white">
                            <span class="text-sky-700 font-semibold text-lg">Klikni pro přidání nových souborů</span>
                            <span class="text-sm text-sky-500 mt-1">JPG / PNG / WebP</span>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>

                </div>

                <div class="flex justify-end pt-4 border-t border-sky-100">
                    <button type="submit" class="w-full md:w-auto px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-amber-200">
                        Uložit změny do DB
                    </button>
                </div>

            </form>
       
<?php require_once '../app/views/layout/footer.php'; ?>