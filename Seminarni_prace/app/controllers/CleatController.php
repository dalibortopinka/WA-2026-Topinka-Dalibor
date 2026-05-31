<?php

class CleatController {

// 0. Výchozí metoda pro zobrazení úvodní stránky bazaru (seznam inzerátů s filtrováním)
    public function index() {
        // Načtení potřebných tříd
        require_once '../app/models/Database.php';
        require_once '../app/models/Cleat.php';

        // Vytvoření připojení k databázi
        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu
        $cleatModel = new Cleat($db);

        // TADY JE ZMĚNA: Vytáhneme filtry z URL adresy ($_GET)
        // Pokud filtr v URL není, dosadí se díky ?? prázdný řetězec
        $filters = [
            'brand' => $_GET['brand'] ?? '',
            'cleat_type' => $_GET['cleat_type'] ?? '',
            'size' => $_GET['size'] ?? '',
            'sort' => $_GET['sort'] ?? ''
        ];

        // Získání dat z modelu – předáme mu pole s našimi filtry
        $cleats = $cleatModel->getAll($filters); 
        
        // Načte se připravená šablona se seznamem
        require_once '../app/views/cleats/cleats_list.php';
    }

    // 1. Zobrazení formuláře pro přidání nového inzerátu kopaček
    public function create() {
        // Zabezpečení: Přidávat inzeráty mohou pouze přihlášení uživatelé
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání inzerátu se musíte nejdříve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // Načte se šablona s formulářem
        require_once '../app/views/cleats/cleat_create.php';
    }

    // 2. Zpracování dat odeslaných z formuláře pro nový inzerát
    public function store() {
        // Kontrola, zda byl formulář odeslán metodou POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Zabezpečení: Kontrola přihlášení
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro tuto akci musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            // 1. Získání a očištění textových dat (ochrana proti XSS)
            $title = htmlspecialchars($_POST['title'] ?? '');
            $brand = htmlspecialchars($_POST['brand'] ?? '');
            $size = htmlspecialchars($_POST['size'] ?? '');
            $cleatType = htmlspecialchars($_POST['cleat_type'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            
            // U číselných hodnot se provádí explicitní přetypování
            $price = (float)($_POST['price'] ?? 0);

            // Volání metody, která zpracuje soubory v $_FILES
            $uploadedImages = $this->processImageUploads(); 

            // Základní validace na straně serveru
            if (empty($title) || empty($brand) || empty($size) || empty($cleatType) || empty($uploadedImages)) {
                $this->addErrorMessage('Vyplňte prosím všechna povinná pole a nahrajte alepoň 1 fotografii.');
                header('Location: ' . BASE_URL . '/index.php?url=cleat/create');
                exit;
            }

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Cleat.php';

            $database = new Database();
            $db = $database->getConnection();

            $cleatModel = new Cleat($db);
            $isSaved = $cleatModel->create(
                $_SESSION['user_id'], $title, $brand, $size, 
                $cleatType, $price, $description, $uploadedImages
            );

            // 3. Vyhodnocení výsledku a přesměrování
            if ($isSaved) {
                $this->addSuccessMessage('Inzerát byl úspěšně vystaven.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Nepodařilo se uložit inzerát do databáze.');
                header('Location: ' . BASE_URL . '/index.php?url=cleat/create');
                exit;
            }
            
        } else {
            $this->addNoticeMessage('Pro přidání inzerátu je nutné odeslat formulář.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    // 3. Smazání existujícího inzerátu
    public function delete($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID inzerátu ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání inzerátu se musíte přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Cleat.php';

        $database = new Database();
        $db = $database->getConnection();

        $cleatModel = new Cleat($db);
        $cleat = $cleatModel->getById($id);

        if (!$cleat) {
            $this->addErrorMessage('Požadovaný inzerát nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // KONTROLA OPRAVNĚNÍ: Smazat může pouze autor inzerátu nebo admin
        if ($cleat['user_id'] !== $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
            $this->addErrorMessage('Nemáte oprávnění smazat cizí inzerát.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $isDeleted = $cleatModel->delete($id);

        if ($isDeleted) {
            $this->addSuccessMessage('Inzerát byl úspěšně stažen z bazaru.');
        } else {
            $this->addErrorMessage('Nastala chyba. Inzerát se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 4. Zobrazení formuláře pro úpravu inzerátu
    public function edit($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID inzerátu k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu inzerátu se musíte přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Cleat.php';

        $database = new Database();
        $db = $database->getConnection();

        $cleatModel = new Cleat($db);
        $cleat = $cleatModel->getById($id);

        if (!$cleat) {
            $this->addErrorMessage('Inzerát nebyl v databázi nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // KONTROLA OPRAVNĚNÍ: Upravovat může pouze autor nebo admin
        if ($cleat['user_id'] !== $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
            $this->addErrorMessage('Nemáte oprávnění upravovat cizí inzerát.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/cleats/cleat_edit.php';
    }

    // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID inzerátu k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu musíte být přihlášeni.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            require_once '../app/models/Database.php';
            require_once '../app/models/Cleat.php';

            $database = new Database();
            $db = $database->getConnection();

            $cleatModel = new Cleat($db);
            $cleat = $cleatModel->getById($id);

            if (!$cleat) {
                $this->addErrorMessage('Inzerát neexistuje.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // KONTROLA OPRAVNĚNÍ: Upravovat může pouze autor nebo admin
            if ($cleat['user_id'] !== $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
                $this->addErrorMessage('Nemáte oprávnění k úpravě tohoto inzerátu.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // Očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $brand = htmlspecialchars($_POST['brand'] ?? '');
            $size = htmlspecialchars($_POST['size'] ?? '');
            $cleatType = htmlspecialchars($_POST['cleat_type'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);

            // Zpracování nově nahraných obrázků
            $uploadedImages = $this->processImageUploads(); 
            
            // Pokud se žádné nové fotky nenahrály, zachováme v databázi ty původní
            if (empty($uploadedImages) && !empty($cleat['images'])) {
                $uploadedImages = json_decode($cleat['images'], true);
            }

            $isUpdated = $cleatModel->update(
                $id, $title, $brand, $size, $cleatType, $price, $description, $uploadedImages
            );

            if ($isUpdated) {
                $this->addSuccessMessage('Inzerát byl úspěšně upraven.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
                header('Location: ' . BASE_URL . '/index.php?url=cleat/edit/' . $id);
                exit;
            }
            
        } else {
            $this->addNoticeMessage('Pro úpravu inzerátu je nutné odeslat formulář.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    // 6. Zobrazení kompletního detailu inzerátu kopaček (včetně komentářů/dotazů)
    public function show($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID inzerátu.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Cleat.php';
        require_once '../app/models/Comment.php';

        $database = new Database();
        $db = $database->getConnection();

        $cleatModel = new Cleat($db);
        $cleat = $cleatModel->getById($id);

        if (!$cleat) {
            $this->addErrorMessage('Požadovaný inzerát nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení všech dotazů/komentářů patřících k tomuto inzerátu
        $commentModel = new Comment($db);
        $comments = $commentModel->getByCleatId($id);

        require_once '../app/views/cleats/cleat_show.php';
    }

    // --- Pomocná metoda pro zpracování nahrávání fotek kopaček ---
    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue; 
                    }

                    // Vygenerování unikátního jména s předponou cleat_
                    $newName = 'cleat_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }

    // --- Pomocné metody pro flash zprávy ---
    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}