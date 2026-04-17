<?php

// =====================================================
// ===================== MESSAGES =======================
// =====================================================

/**
 * Supprime un message.
 * Cette action vérifie que la requête utilise
 * bien la méthode POST avant de traiter la suppression.
 */
if (isset($_POST['delete'])) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=admin&section=messages');
        exit;
    }

    $messageId = (int) $_POST['delete'];
    deleteMessage($pdo, $messageId);

    header('Location: index.php?page=admin&section=messages');
    exit;
}

$messages = getAllMessages($pdo);

$messageDate = trim($_GET['message_date'] ?? '');

if ($messageDate !== '') {
    $messages = array_filter($messages, function ($message) use ($messageDate) {
        return strpos($message['date_envoi'], $messageDate) === 0;
    });
}

$messages = array_values($messages);

$messagesPerPage = 5;
$currentMessagePage = isset($_GET['message_page']) ? (int) $_GET['message_page'] : 1;

if ($currentMessagePage < 1) {
    $currentMessagePage = 1;
}

$totalMessages = count($messages);
$totalMessagePages = $totalMessages > 0 ? (int) ceil($totalMessages / $messagesPerPage) : 1;

if ($currentMessagePage > $totalMessagePages) {
    $currentMessagePage = $totalMessagePages;
}

$messageOffset = ($currentMessagePage - 1) * $messagesPerPage;
$messages = array_slice($messages, $messageOffset, $messagesPerPage);

$messagePagination = [
    'currentPage' => $currentMessagePage,
    'totalPages' => $totalMessagePages
];