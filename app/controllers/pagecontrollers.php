<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

require_once __DIR__ . '/../views/pages/header.php';

if ($page === 'oiseau') {
    require_once __DIR__ . '/../views/pages/oiseau.php';
} elseif ($page === 'nid') {
    require_once __DIR__ . '/../views/pages/nid.php';
} elseif ($page === 'galerie') {
    require_once __DIR__ . '/../views/pages/galerie.php';
} elseif ($page === 'inaturalist') {
    require_once __DIR__ . '/../views/pages/inaturalist.php';
} elseif ($page === 'mentions-legales') {
    require_once __DIR__ . '/../views/pages/mentions-legales.php';
} elseif ($page === 'politique-confidentialite') {
    require_once __DIR__ . '/../views/pages/politique-confidentialite.php';
} elseif ($page === 'cgu') {
    require_once __DIR__ . '/../views/pages/cgu.php';
} else {
    require_once __DIR__ . '/../views/pages/404.php';
}

require_once __DIR__ . '/../views/pages/footer.php';