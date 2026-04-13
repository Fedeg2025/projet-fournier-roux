<!-- =========================
     LISTE DES UTILISATEURS
     Cette vue permet à l’administrateur
     de consulter les utilisateurs enregistrés sur le site
     ========================= -->

<section class="admin-users">
    <h2 class="admin-users__title">Utilisateurs</h2>

    <!-- =========================
         FORMULAIRE RECHERCHE
         ========================= -->
    <form method="GET" action="index.php" class="admin-users__search">
        <input type="hidden" name="page" value="admin">
        <input type="hidden" name="section" value="utilisateurs">

        <input
            type="text"
            name="search"
            placeholder="Rechercher un utilisateur..."
            value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
        >

        <button type="submit">Rechercher</button>
    </form>

    <!-- =========================
         FILTRE ALPHABÉTIQUE
         ========================= -->
    <div class="admin-users__alphabet">
        <?php foreach (range('A', 'Z') as $lettre): ?>
            <a href="index.php?page=admin&section=utilisateurs&letter=<?php echo $lettre; ?>">
                <?php echo $lettre; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php
    // =========================
    // FILTRAGE SIMPLE (AMATEUR)
    // =========================
    $filtered_users = $utilisateurs;

    // Recherche
    if (!empty($_GET['search'])) {
        $search = strtolower($_GET['search']);

        $filtered_users = array_filter($filtered_users, function ($u) use ($search) {
            return strpos(strtolower($u['nom']), $search) !== false ||
                   strpos(strtolower($u['prenom']), $search) !== false ||
                   strpos(strtolower($u['email']), $search) !== false;
        });
    }

    // Filtre lettre
    if (!empty($_GET['letter'])) {
        $letter = strtolower($_GET['letter']);

        $filtered_users = array_filter($filtered_users, function ($u) use ($letter) {
            return strtolower($u['nom'][0]) === $letter;
        });
    }

    // =========================
    // PAGINATION SIMPLE
    // =========================
    $par_page = 10;
    $page = isset($_GET['p']) ? (int) $_GET['p'] : 1;
    if ($page < 1) $page = 1;

    $total = count($filtered_users);
    $pages = ceil($total / $par_page);
    $offset = ($page - 1) * $par_page;

    $filtered_users = array_slice($filtered_users, $offset, $par_page);
    ?>

    <!-- =========================
         CAS AUCUN UTILISATEUR
         ========================= -->
    <?php if (empty($filtered_users)): ?>
        <p class="admin-users__empty">Aucun utilisateur.</p>

    <?php else: ?>

        <!-- =========================
             LISTE DES UTILISATEURS
             ========================= -->
        <div class="admin-users__list">
            <?php foreach ($filtered_users as $utilisateur): ?>
                <article class="admin-users__item">

                    <h3 class="admin-users__name">
                        <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>
                    </h3>

                    <p class="admin-users__info">
                        <span class="admin-users__label">Email :</span>
                        <span class="admin-users__value">
                            <?php echo htmlspecialchars($utilisateur['email']); ?>
                        </span>
                    </p>

                    <p class="admin-users__info">
                        <span class="admin-users__label">Rôle :</span>
                        <span class="admin-users__value">
                            <?php
                            echo $utilisateur['role'] === 'admin'
                                ? 'Administrateur'
                                : 'Utilisateur';
                            ?>
                        </span>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- =========================
             PAGINATION
             ========================= -->
        <div class="admin-users__pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="index.php?page=admin&section=utilisateurs&p=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>

    <?php endif; ?>
</section>