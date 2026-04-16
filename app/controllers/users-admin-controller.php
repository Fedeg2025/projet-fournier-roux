<?php

// =====================================================
// ===================== UTILISATEURS ===================
// =====================================================

$users = getAllUsers($pdo);

$userSearch = trim($_GET['user_search'] ?? '');

if ($userSearch !== '') {
    $users = array_filter($users, function ($user) use ($userSearch) {
        $searchValue = mb_strtolower($userSearch);

        return mb_strpos(mb_strtolower($user['nom']), $searchValue) !== false
            || mb_strpos(mb_strtolower($user['prenom']), $searchValue) !== false
            || mb_strpos(mb_strtolower($user['email']), $searchValue) !== false;
    });
}

$users = array_values($users);

$usersPerPage = 5;
$currentUserPage = isset($_GET['user_page']) ? (int) $_GET['user_page'] : 1;

if ($currentUserPage < 1) {
    $currentUserPage = 1;
}

$totalUsers = count($users);
$totalUserPages = $totalUsers > 0 ? (int) ceil($totalUsers / $usersPerPage) : 1;

if ($currentUserPage > $totalUserPages) {
    $currentUserPage = $totalUserPages;
}

$userOffset = ($currentUserPage - 1) * $usersPerPage;
$users = array_slice($users, $userOffset, $usersPerPage);

$userPagination = [
    'currentPage' => $currentUserPage,
    'totalPages' => $totalUserPages
];