<?php require_once '../app/views/layout/header.php'; ?>
            <h2 class="text-2xl font-bold text-sky-700 mb-6">Dostupné knihy</h2>
            
            <?php if (empty($books)): ?>
                <div class="bg-sky-50 border border-sky-200 rounded-2xl p-8 shadow-sm text-center">
                    <p class="text-sky-600 text-lg">V databázi se zatím nenachází žádné knihy.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto bg-white border border-sky-200 rounded-2xl shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-sky-50 text-sky-700 text-sm uppercase tracking-wider border-b border-sky-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">ID</th>
                                <th class="px-6 py-4 font-bold">Název knihy</th>
                                <th class="px-6 py-4 font-bold">Autor</th>
                                <th class="px-6 py-4 font-bold">Rok vydání</th>
                                <th class="px-6 py-4 font-bold">Cena</th>
                                <th class="px-6 py-4 font-bold">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-100">
                            <?php foreach ($books as $book): ?>
                                <tr class="hover:bg-sky-50/50 transition-colors">
                                    <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($book['id']) ?></td>
                                    <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($book['title']) ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($book['author']) ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($book['year']) ?></td>
                                    <td class="px-6 py-4 text-slate-600">
                                        <span class="bg-sky-100 text-sky-700 py-1 px-3 rounded-full text-sm font-semibold">
                                            <?= htmlspecialchars($book['price']) ?> Kč
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-sky-500 hover:text-sky-700 font-semibold mr-3 transition-colors">Detail</a>
                                        <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-amber-500 hover:text-amber-700 font-semibold mr-3 transition-colors">Upravit</a> 
                                        <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Smazat</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
       
<?php require_once '../app/views/layout/footer.php'; ?>
    