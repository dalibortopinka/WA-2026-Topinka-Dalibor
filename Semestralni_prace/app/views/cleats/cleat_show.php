<?php
// Načtení společné hlavičky webu
require_once '../app/views/layout/header.php';

// Dekódování galerie obrázků z JSON
$images = json_decode($cleat['images'], true);
$images = is_array($images) ? $images : [];

// České popisky pro typy špuntů
$typeLabels = [
    'FG' => 'FG (lisovky - pevný přírodní trávník)',
    'SG' => 'SG (kolíky / mixy - mokrý povrch)',
    'AG' => 'AG (umělá tráva)',
    'TF' => 'TF (turfy - stabilní umělý povrch / koberce)'
];
$typeLabel = $typeLabels[$cleat['cleat_type']] ?? $cleat['cleat_type'];
?>

<div class="space-y-8">
    
    <div>
        <a href="<?= BASE_URL ?>/index.php" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 transition-colors">
            &larr; Zpět na nabídku bazaru
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
        
        <div class="space-y-4">
            <div class="bg-slate-100 rounded-xl aspect-video w-full flex items-center justify-center overflow-hidden border border-slate-200 shadow-2xs">
                <?php if (!empty($images)): ?>
                    <a href="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($images[0]) ?>" target="_blank" class="block w-full h-full cursor-zoom-in" title="Kliknutím zvětšíte obrázek">
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($images[0]) ?>" 
                             alt="<?= htmlspecialchars($cleat['title']) ?>" 
                             class="w-full h-full object-contain hover:opacity-95 transition-opacity">
                    </a>
                <?php endif; ?>
            </div>

            <?php if (count($images) > 1): ?>
                <div class="grid grid-cols-4 gap-2">
                    <?php foreach ($images as $img): ?>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg aspect-square overflow-hidden shadow-2xs">
                            <a href="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" target="_blank" class="block w-full h-full">
                                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover hover:opacity-80 transition-opacity">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div> <div class="flex flex-col justify-between space-y-6">
            <div>
                <span class="inline-block bg-slate-900 text-white text-xs font-bold px-2.5 py-1 rounded-md uppercase tracking-wide mb-2">
                    <?= htmlspecialchars($cleat['brand']) ?>
                </span>
                
                <h1 class="text-2xl font-black text-slate-900 leading-tight mb-2">
                    <?= htmlspecialchars($cleat['title']) ?>
                </h1>
                
                <div class="text-2xl font-black text-emerald-700 mb-6">
                    <?= number_format($cleat['price'], 0, ',', ' ') ?> Kč
                </div>

                <div class="border-t border-b border-slate-100 py-4 space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-400">Velikost:</span>
                        <span class="font-bold text-slate-900 bg-slate-100 px-2.5 py-0.5 rounded-md text-xs"><?= htmlspecialchars($cleat['size']) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-400">Typ podrážky:</span>
                        <span class="font-semibold text-slate-800"><?= htmlspecialchars($typeLabel) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-400">Prodejce:</span>
                        <span class="font-semibold text-slate-800 italic"><?= htmlspecialchars(!empty($cleat['nickname']) ? $cleat['nickname'] : $cleat['username']) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-400">Vystaveno:</span>
                        <span class="text-slate-500"><?= date('d. m. Y H:i', strtotime($cleat['created_at'])) ?></span>
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION['user_id']) && ($cleat['user_id'] === $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin')): ?>
                <div class="bg-slate-50 border border-slate-100 p-3 rounded-xl flex items-center gap-2">
                    <a href="<?= BASE_URL ?>/index.php?url=cleat/edit/<?= $cleat['id'] ?>" class="flex-1 text-center bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 py-2 rounded-xl text-xs font-bold transition-colors shadow-2xs">
                        Upravit inzerát ✏️
                    </a>
                    <a href="<?= BASE_URL ?>/index.php?url=cleat/delete/<?= $cleat['id'] ?>" class="flex-1 text-center bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 py-2 rounded-xl text-xs font-bold transition-colors"
                       onclick="return confirm('Opravdu chcete tento inzerát smazat?');">
                        Smazat z bazaru 🗑️
                    </a>
                </div>
            <?php endif; ?>
        </div> </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-900 mb-2">Popis stavu</h3>
        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
            <?= !empty($cleat['description']) ? htmlspecialchars($cleat['description']) : 'Prodejce k tomuto inzerátu nepřidal žádný podrobný popis.' ?>
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
        <div>
            <h3 class="text-base font-bold text-slate-900">Veřejné dotazy na prodejce (<?= count($comments) ?>)</h3>
            <p class="text-xs text-slate-400 mt-0.5">Zde se můžete prodejce zeptat na detaily, rozměry nebo domluvit předání.</p>
        </div>

        <?php if (empty($comments)): ?>
            <p class="text-sm text-slate-400 italic py-2">K tomuto inzerátu zatím nikdo nepoložil žádný dotaz.</p>
        <?php else: ?>
            <div class="divide-y divide-slate-100">
                <?php foreach ($comments as $comment): ?>
                    <div class="py-4 flex items-start justify-between gap-4 first:pt-0 last:pb-0">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md">
                                    <?= htmlspecialchars(!empty($comment['nickname']) ? $comment['nickname'] : $comment['username']) ?>
                                </span>
                                <span class="text-slate-400"><?= date('d. m. Y H:i', strtotime($comment['created_at'])) ?></span>
                                
                                <?php if (isset($_SESSION['user_id'])): ?>
                                <button type="button" 
                                onclick="setReply('<?= htmlspecialchars(!empty($comment['nickname']) ? $comment['nickname'] : $comment['username']) ?>')" 
                                class="text-emerald-600 hover:text-emerald-800 font-bold text-[11px] ml-2 transition-colors cursor-pointer">
                                ↩️ Odpovědět
                                </button>
                                <?php endif; ?>
                                <?php if ($comment['user_id'] === $cleat['user_id']): ?>
                                    <span class="bg-slate-900 text-white text-[9px] px-1.5 py-0.2 rounded font-semibold uppercase tracking-wider">Prodejce</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line pl-1">
                                <?= htmlspecialchars($comment['text']) ?>
                            </p>
                        </div>

                        <?php 
                        $canDeleteComment = false;
                        if (isset($_SESSION['user_id'])) {
                            if ($comment['user_id'] === $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin') {
                                $canDeleteComment = true;
                            }
                        }
                        ?>
                        
                        <?php if ($canDeleteComment): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $comment['id'] ?>" 
                               class="text-slate-300 hover:text-rose-600 text-sm p-1 transition-colors" 
                               title="Smazat dotaz" 
                               onclick="return confirm('Opravdu chcete tento dotaz smazat?');">
                                🗑️
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

<div class="border-t border-slate-100 pt-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php 
                // Kontrola, zda je přihlášený uživatel zároveň autorem tohoto inzerátu
                $isOwner = ($cleat['user_id'] === $_SESSION['user_id']);
                
                // Dynamická změna textů podle toho, zda se dívá prodejce, nebo kupující
                $labelText = $isOwner ? 'Napište svou odpověď kupujícím *' : 'Napište svůj dotaz prodejci *';
                $placeholderText = $isOwner ? 'Napište odpověď zájemcům o kopačky, upřesněte předání nebo detaily...' : 'Napište například: Sedí velikost přesně? Byly hrané na umělce?...';
                $buttonText = $isOwner ? 'Odeslat odpověď jako prodejce' : 'Odeslat dotaz prodejci';
                ?>
                
                <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="POST" class="space-y-3">
                    <input type="hidden" name="cleat_id" value="<?= $cleat['id'] ?>">
                    
                    <div id="reply-banner" class="hidden bg-emerald-50 text-emerald-800 text-xs px-3 py-2 rounded-xl flex items-center justify-between border border-emerald-100 animate-fade-in">
                        <span>Odpovídáte uživateli: <strong id="reply-username" class="font-bold"></strong></span>
                        <button type="button" onclick="cancelReply()" class="text-slate-400 hover:text-rose-600 font-bold px-1 text-sm">✕</button>
                    </div>

                    <div>
                        <label for="text" class="block text-xs font-semibold text-slate-500 mb-1"><?= $labelText ?></label>
                        <textarea name="text" id="text" rows="3" required placeholder="<?= $placeholderText ?>"
                                  class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-colors resize-none"></textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition-colors cursor-pointer">
                            <?= $buttonText ?>
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="bg-slate-50 border border-slate-150 p-4 rounded-xl text-center text-sm text-slate-500">
                    Pro vložení dotazu nebo komentáře se musíte nejdříve 
                    <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-emerald-700 font-bold hover:underline">přihlásit</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php
// Načtení společné patičky webu
require_once '../app/views/layout/footer.php';
?>

<script>
function setReply(username) {
    const textarea = document.getElementById('text');
    const banner = document.getElementById('reply-banner');
    const replyUserSpan = document.getElementById('reply-username');
    
    // 1. Zobrazíme info lištu s přezdívkou
    banner.classList.remove('hidden');
    replyUserSpan.textContent = username;
    
    // 2. Vyčistíme případný starý tag a vložíme nový na začátek textu
    let currentText = textarea.value.replace(/^@\w+\s/, '');
    textarea.value = '@' + username + ' ' + currentText;
    
    // 3. Aktivujeme textové pole
    textarea.focus();
    
    // 4. Plynule odskrolujeme dolů k formuláři
    textarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function cancelReply() {
    const textarea = document.getElementById('text');
    const banner = document.getElementById('reply-banner');
    
    // Skryjeme lištu a smažeme tag z textu
    banner.classList.add('hidden');
    textarea.value = textarea.value.replace(/^@\w+\s/, '');
}
</script>