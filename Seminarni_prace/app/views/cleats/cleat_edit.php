<?php
// Načtení společné hlavičky webu
require_once '../app/views/layout/header.php';

// Dekódování stávajících obrázků pro zobrazení náhledů
$currentImages = json_decode($cleat['images'], true);
$hasCurrentImages = (!empty($currentImages) && is_array($currentImages));
?>

<div class="max-w-2xl mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <!-- Záhlaví formuláře -->
    <div class="bg-emerald-600 px-6 py-4 text-white">
        <h1 class="text-xl font-bold">Upravit inzerát kopaček</h1>
        <p class="text-xs text-emerald-100 mt-0.5">Zde můžete změnit cenu, popisek nebo přidat nové fotografie.</p>
    </div>

    <!-- Formulář pro aktualizaci dat (enctype je nutný kvůli nahrávání fotek) -->
    <form action="<?= BASE_URL ?>/index.php?url=cleat/update/<?= $cleat['id'] ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        
        <!-- Název inzerátu -->
        <div>
            <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Název inzerátu *</label>
            <input type="text" name="title" id="title" required 
                   value="<?= htmlspecialchars($cleat['title']) ?>"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
        </div>

        <!-- Značka a Velikost -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="brand" class="block text-sm font-semibold text-slate-700 mb-1">Značka kopaček *</label>
                <select name="brand" id="brand" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                    <option value="Adidas" <?= $cleat['brand'] === 'Adidas' ? 'selected' : '' ?>>Adidas</option>
                    <option value="Nike" <?= $cleat['brand'] === 'Nike' ? 'selected' : '' ?>>Nike</option>
                    <option value="Puma" <?= $cleat['brand'] === 'Puma' ? 'selected' : '' ?>>Puma</option>
                    <option value="Mizuno" <?= $cleat['brand'] === 'Mizuno' ? 'selected' : '' ?>>Mizuno</option>
                    <option value="New Balance" <?= $cleat['brand'] === 'New Balance' ? 'selected' : '' ?>>New Balance</option>
                    <option value="Jiná" <?= $cleat['brand'] === 'Jiná' ? 'selected' : '' ?>>Jiná značka</option>
                </select>
            </div>

            <div>
                <label for="size" class="block text-sm font-semibold text-slate-700 mb-1">Velikost (EU / UK) *</label>
                <input type="text" name="size" id="size" required 
                       value="<?= htmlspecialchars($cleat['size']) ?>"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
            </div>
        </div>

        <!-- Typ špuntů a Cena -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="cleat_type" class="block text-sm font-semibold text-slate-700 mb-1">Typ podrážky *</label>
                <select name="cleat_type" id="cleat_type" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                    <option value="FG" <?= $cleat['cleat_type'] === 'FG' ? 'selected' : '' ?>>FG (lisovky - pevný trávník)</option>
                    <option value="SG" <?= $cleat['cleat_type'] === 'SG' ? 'selected' : '' ?>>SG (kolíky / mixy - mokro)</option>
                    <option value="AG" <?= $cleat['cleat_type'] === 'AG' ? 'selected' : '' ?>>AG (lisovky na umělku)</option>
                    <option value="TF" <?= $cleat['cleat_type'] === 'TF' ? 'selected' : '' ?>>TF (turfy - umělý koberec)</option>
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-slate-700 mb-1">Požadovaná cena (Kč) *</label>
                <input type="number" name="price" id="price" required min="0" 
                       value="<?= (int)$cleat['price'] ?>"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
            </div>
        </div>

        <!-- Popis stavu -->
        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Podrobný popis stavu</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors resize-none"><?= htmlspecialchars($cleat['description']) ?></textarea>
        </div>

        <!-- Aktuální fotografie (pokud existují) -->
        <?php if ($hasCurrentImages): ?>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Aktuální uložené fotografie:</label>
                <div class="grid grid-cols-4 gap-3 bg-slate-50 p-3 border border-slate-200 rounded-xl">
                    <?php foreach ($currentImages as $img): ?>
                        <div class="aspect-square bg-white border border-slate-200 rounded-lg overflow-hidden shadow-2xs">
                            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-[11px] text-amber-600 font-medium mt-1.5">⚠️ Nahráním nových fotografií níže kompletně nahradíte tyto stávající obrázky.</p>
            </div>
        <?php endif; ?>

        <!-- Nahrání nových fotek -->
        <div>
            <label for="images" class="block text-sm font-semibold text-slate-700 mb-1">Nahrát nové fotografie (volitelné)</label>
            <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 text-center hover:bg-slate-100/50 transition-colors">
                <input type="file" name="images[]" id="images" multiple accept="image/*"
                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                <p class="text-[11px] text-slate-400 mt-2">Pokud nechcete měnit fotky, nechte toto pole prázdné.</p>
            </div>
        </div>

        <!-- Akční tlačítka -->
        <div class="border-t border-slate-100 pt-4 flex items-center justify-end gap-3">
            <a href="<?= BASE_URL ?>/index.php?url=cleat/show/<?= $cleat['id'] ?>" class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
                Zpět na detail
            </a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors cursor-pointer">
                Uložit provedené změny
            </button>
        </div>

    </form>
</div>

<?php
// Načtení společné patičky webu
require_once '../app/views/layout/footer.php';
?>