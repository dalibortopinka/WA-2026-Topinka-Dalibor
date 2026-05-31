<?php
// Načtení společné hlavičky webu
require_once '../app/views/layout/header.php';
?>

<div class="max-w-2xl mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <!-- Záhlaví formuláře -->
    <div class="bg-emerald-600 px-6 py-4 text-white">
        <h1 class="text-xl font-bold">Nový inzerát kopaček</h1>
        <p class="text-xs text-emerald-100 mt-0.5">Vyplňte informace o kopačkách a nabídněte je ostatním hráčům.</p>
    </div>

    <!-- Samotný formulář (DŮLEŽITÉ: enctype pro nahrávání souborů) -->
    <form action="<?= BASE_URL ?>/index.php?url=cleat/store" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        
        <!-- Název inzerátu -->
        <div>
            <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Název inzerátu *</label>
            <input type="text" name="title" id="title" required placeholder="Např. Adidas F50 Elite FG - jako nové"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
        </div>

        <!-- Značka a Velikost (Dva sloupce vedle sebe) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="brand" class="block text-sm font-semibold text-slate-700 mb-1">Značka kopaček *</label>
                <select name="brand" id="brand" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                    <option value="">-- Vyberte značku --</option>
                    <option value="Adidas">Adidas</option>
                    <option value="Nike">Nike</option>
                    <option value="Puma">Puma</option>
                    <option value="Mizuno">Mizuno</option>
                    <option value="New Balance">New Balance</option>
                    <option value="Jiná">Jiná značka</option>
                </select>
            </div>

            <div>
                <label for="size" class="block text-sm font-semibold text-slate-700 mb-1">Velikost (EU / UK) *</label>
                <input type="text" name="size" id="size" required placeholder="Např. 43.5 (UK 9)"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
            </div>
        </div>

        <!-- Typ špuntů/podrážky a Cena (Dva sloupce vedle sebe) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="cleat_type" class="block text-sm font-semibold text-slate-700 mb-1">Typ podrážky *</label>
                <select name="cleat_type" id="cleat_type" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                    <option value="">-- Vyberte typ povrchu --</option>
                    <option value="FG">FG (lisovky - pevný přírodní trávník)</option>
                    <option value="SG">SG (kolíky / mixy - mokrý, měkký povrch)</option>
                    <option value="AG">AG (lisovky na umělou trávu)</option>
                    <option value="TF">TF (turfy - stabilní umělý povrch / koberce)</option>
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-slate-700 mb-1">Požadovaná cena (Kč) *</label>
                <input type="number" name="price" id="price" required min="0" placeholder="Např. 1500"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
            </div>
        </div>

        <!-- Detailní popis stavu kopaček -->
        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Podrobný popis stavu</label>
            <textarea name="description" id="description" rows="4" placeholder="Uveďte jak dlouho byly kopačky hrané, zda mají nějaké vady, důvod prodeje atd..."
                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors resize-none"></textarea>
        </div>

        <!-- Nahrávání fotek (Více souborů najednou přes multiple) -->
        <div>
            <label for="images" class="block text-sm font-semibold text-slate-700 mb-1">Fotografie kopaček *</label>
            <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 text-center hover:bg-slate-100/50 transition-colors">
                <input type="file" name="images[]" id="images" multiple accept="image/*" required
                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                <p class="text-[11px] text-slate-400 mt-2">Musíte vybrat alespoň 1 fotografii (formáty JPG, PNG, WEBP).</p>
            </div>
        </div>

        <!-- Spodní akční tlačítka -->
        <div class="border-t border-slate-100 pt-4 flex items-center justify-end gap-3">
            <a href="<?= BASE_URL ?>/index.php" class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
                Zrušit
            </a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors cursor-pointer">
                Zveřejnit inzerát
            </button>
        </div>

    </form>
</div>

<?php
// Načtení společné patičke webu
require_once '../app/views/layout/footer.php';
?>