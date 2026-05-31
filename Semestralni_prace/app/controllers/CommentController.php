<?php

class CommentController {

    // 1. Zpracování a uložení nového komentáře/dotazu k inzerátu
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Zabezpečení: Komentovat mohou pouze přihlášení uživatelé
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro přidání dotazu se musíte nejdříve přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            $cleatId = (int)($_POST['cleat_id'] ?? 0);
            // Očištění textu proti XSS útokům
            $text = htmlspecialchars($_POST['text'] ?? '');

            if (empty($text) || $cleatId === 0) {
                $this->addErrorMessage('Text dotazu nesmí být prázdný.');
                header('Location: ' . BASE_URL . '/index.php?url=cleat/show/' . $cleatId);
                exit;
            }

            // Připojení k DB a Modelu
            require_once '../app/models/Database.php';
            require_once '../app/models/Comment.php';

            $database = new Database();
            $db = $database->getConnection();

            $commentModel = new Comment($db);
            $isSaved = $commentModel->create($cleatId, $_SESSION['user_id'], $text);

            if ($isSaved) {
                $this->addSuccessMessage('Váš dotaz byl úspěšně odeslán prodejci.');
            } else {
                $this->addErrorMessage('Nastala chyba při ukládání komentáře.');
            }

            // Přesměrování zpět na detail konkrétní kopačky
            header('Location: ' . BASE_URL . '/index.php?url=cleat/show/' . $cleatId);
            exit;
        }
    }

    // 2. Smazání komentáře s kontrolou přístupových práv
    public function delete($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID komentáře.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání komentáře musíte být přihlášeni.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';
        require_once '../app/models/Cleat.php';

        $database = new Database();
        $db = $database->getConnection();

        $commentModel = new Comment($db);
        $comment = $commentModel->getById($id);

        if (!$comment) {
            $this->addErrorMessage('Komentář nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pro ověření práv potřebujeme vědět, komu patří samotný inzerát
        $cleatModel = new Cleat($db);
        $cleat = $cleatModel->getById($comment['cleat_id']);

        // JASNÁ PŘÍSTUPOVÁ PRÁVA (Bod 3 ze zadání):
        // Smazat komentář smí:
        // - Autor komentáře ($comment['user_id'])
        // - Autor inzerátu ($cleat['user_id'])
        // - Administrátor ($_SESSION['user_role'] === 'admin')
        $isAuthorOfComment = ($comment['user_id'] === $_SESSION['user_id']);
        $isOwnerOfListing = ($cleat && $cleat['user_id'] === $_SESSION['user_id']);
        $isAdmin = ($_SESSION['user_role'] === 'admin');

        if ($isAuthorOfComment || $isOwnerOfListing || $isAdmin) {
            $isDeleted = $commentModel->delete($id);
            
            if ($isDeleted) {
                $this->addSuccessMessage('Komentář byl úspěšně smazán.');
            } else {
                $this->addErrorMessage('Komentář se nepodařilo smazat.');
            }
        } else {
            $this->addErrorMessage('Nemáte oprávnění smazat tento komentář.');
        }

        // Návrat zpět na detail inzerátu
        header('Location: ' . BASE_URL . '/index.php?url=cleat/show/' . $comment['cleat_id']);
        exit;
    }

    // --- Pomocné metody pro flash zprávy ---
    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}