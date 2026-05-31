<?php
// Načtení společné hlavičky webu
require_once '../app/views/layout/header.php';
?>

<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Aktuální nabídka kopaček</h1>
        <p class="text-sm text-slate-500">Prohlédněte si nejnovější kousky od hráčů z celé republiky.</p>
    </div>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="<?= BASE_URL ?>/index.php?url=cleat/create" class="sm:hidden w-full text-center block px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm transition-colors">
            + Přidat inzerát
        </a>
    <?php endif; ?>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
    <form action="<?= BASE_URL ?>/index.php" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3 items-end">
        <input type="hidden" name="url" value="cleat/index">

        <div>
            <label Skinner for="brand" class="block text-xs font-semibold text-slate-500 mb-1">Značka</label>
            <select name="brand" id="brand" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                <option value="">Všechny značky</option>
                <option value="Adidas" <?= ($_GET['brand'] ?? '') === 'Adidas' ? 'selected' : '' ?>>Adidas</option>
                <option value="Nike" <?= ($_GET['brand'] ?? '') === 'Nike' ? 'selected' : '' ?>>Nike</option>
                <option value="Puma" <?= ($_GET['brand'] ?? '') === 'Puma' ? 'selected' : '' ?>>Puma</option>
                <option value="Mizuno" <?= ($_GET['brand'] ?? '') === 'Mizuno' ? 'selected' : '' ?>>Mizuno</option>
                <option value="New Balance" <?= ($_GET['brand'] ?? '') === 'New Balance' ? 'selected' : '' ?>>New Balance</option>
                <option value="Jiná" <?= ($_GET['brand'] ?? '') === 'Jiná' ? 'selected' : '' ?>>Jiná značka</option>
            </select>
        </div>

        <div>
            <label for="cleat_type" class="block text-xs font-semibold text-slate-500 mb-1">Typ podrážky</label>
            <select name="cleat_type" id="cleat_type" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                <option value="">Všechny povrchy</option>
                <option value="FG" <?= ($_GET['cleat_type'] ?? '') === 'FG' ? 'selected' : '' ?>>FG (lisovky)</option>
                <option value="SG" <?= ($_GET['cleat_type'] ?? '') === 'SG' ? 'selected' : '' ?>>SG (kolíky)</option>
                <option value="AG" <?= ($_GET['cleat_type'] ?? '') === 'AG' ? 'selected' : '' ?>>AG (umělka)</option>
                <option value="TF" <?= ($_GET['cleat_type'] ?? '') === 'TF' ? 'selected' : '' ?>>TF (turfy)</option>
            </select>
        </div>

        <div>
            <label for="size" class="block text-xs font-semibold text-slate-500 mb-1">Velikost (EU)</label>
            <input type="text" name="size" id="size" placeholder="Např. 45" 
                   value="<?= htmlspecialchars($_GET['size'] ?? '') ?>"
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
        </div>

        <div>
            <label for="sort" class="block text-xs font-semibold text-slate-500 mb-1">Seřadit podle</label>
            <select name="sort" id="sort" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors">
                <option value="">Nejnovějších inzerátů</option>
                <option value="price_asc" <?= ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Ceny: Od nejlevnějšího</option>
                <option value="price_desc" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Ceny: Od nejdražšího</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2 px-4 rounded-xl transition-colors cursor-pointer shadow-2xs">
                Filtrovat 🔍
            </button>
            
            <?php if (!empty($_GET['brand']) || !empty($_GET['cleat_type']) || !empty($_GET['size']) || !empty($_GET['sort'])): ?>
                <a href="<?= BASE_URL ?>/index.php" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs py-2 px-3 rounded-xl transition-colors flex items-center justify-center" title="Zrušit filtry">
                    ✕
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php if (empty($cleats)): ?>
    <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <div class="text-slate-300 text-5xl mb-3">👟</div>
        <h3 class="text-lg font-bold text-slate-700">Žádné kopačky neodpovídají výběru</h3>
        <p class="text-sm text-slate-400 mt-1 max-w-md mx-auto">Zkuste změnit kritéria filtrování nebo klikněte na křížek pro vymazání filtrů.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php foreach ($cleats as $cleat): ?>
            <?php
            $images = json_decode($cleat['images'], true);
            $mainImage = (!empty($images) && is_array($images)) ? $images[0] : '';
            
            $typeLabels = [
                'FG' => 'FG (lisovky - pevný trávník)',
                'SG' => 'SG (kolíky - mokrý povrch)',
                'AG' => 'AG (umělá tráva)',
                'TF' => 'TF (turfy / korálovky)'
            ];
            $typeLabel = $typeLabels[$cleat['cleat_type']] ?? $cleat['cleat_type'];
            ?>
            
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="relative bg-slate-100 h-48 w-full flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($mainImage) ?>" 
                             alt="<?= htmlspecialchars($cleat['title']) ?>" 
                             class="w-full h-full object-contain">
                        
                        <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-white text-xs font-bold px-2.5 py-1 rounded-lg uppercase tracking-wide">
                            <?= htmlspecialchars($cleat['brand']) ?>
                        </span>
                    </div>
                    
                    <div class="p-4">
                        <div class="text-xl font-black text-emerald-700 mb-1">
                            <?= number_format($cleat['price'], 0, ',', ' ') ?> Kč
                        </div>
                        
                        <h2 class="font-bold text-slate-800 text-base line-clamp-1 mb-2">
                            <a href="<?= BASE_URL ?>/index.php?url=cleat/show/<?= $cleat['id'] ?>" class="hover:text-emerald-600 transition-colors">
                                <?= htmlspecialchars($cleat['title']) ?>
                            </a>
                        </h2>
                        
                        <div class="space-y-1.5 text-xs text-slate-600 border-t border-slate-50 pt-3">
                            <div class="flex items-center gap-1.5">
                                <span class="font-semibold text-slate-400">Velikost:</span> 
                                <span class="bg-slate-100 text-slate-800 font-bold px-2 py-0.5 rounded-md text-[11px]"><?= htmlspecialchars($cleat['size']) ?></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-semibold text-slate-400">Typ:</span> 
                                <span class="text-slate-700 font-medium"><?= htmlspecialchars($typeLabel) ?></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-semibold text-slate-400">Prodejce:</span> 
                                <span class="text-slate-700 italic"><?= htmlspecialchars(!empty($cleat['nickname']) ? $cleat['nickname'] : $cleat['username']) ?></span>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="p-4 pt-0 bg-slate-50 border-t border-slate-100 flex items-center gap-2 mt-4">
                    <a href="<?= BASE_URL ?>/index.php?url=cleat/show/<?= $cleat['id'] ?>" class="flex-1 text-center bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-200 hover:border-emerald-300 py-2 rounded-xl text-xs font-bold transition-colors shadow-2xs">
                        Zobrazit detaily
                    </a>
                    
                    <?php if (isset($_SESSION['user_id']) && ($cleat['user_id'] === $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin')): ?>
                        <a href="<?= BASE_URL ?>/index.php?url=cleat/edit/<?= $cleat['id'] ?>" class="bg-slate-200 hover:bg-slate-300 text-slate-700 p-2 rounded-xl text-xs transition-colors" title="Upravit inzerát">
                            ✏️
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?url=cleat/delete/<?= $cleat['id'] ?>" class="bg-rose-100 hover:bg-rose-200 text-rose-700 p-2 rounded-xl text-xs transition-colors" title="Smazat inzerát" onclick="return confirm('Opravdu chcete tento inzerát trvale smazat?');">
                            🗑️
                        </a>
                    <?php endif; ?>
                </div>
            </div> 
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
// Načtení společné patičky webu
require_once '../app/views/layout/footer.php';
?>