<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Softline' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-bg { 
            background: var(--primary-gradient); 
            min-height: 100vh; 
            padding: 20px;
        }
        .card { 
            border-radius: 15px; 
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background: var(--primary-gradient) !important;
            padding: 1.5rem;
        }
        .btn { border-radius: 8px; }
        .table-responsive { border-radius: 10px; }
        @media (max-width: 768px) {
            .table { font-size: 0.875rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
        }
    </style>
</head>
<body>
    <?= $content ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $scripts ?? '' ?>
</body>
</html>
