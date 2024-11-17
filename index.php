<?php
session_start();
require './config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Élimine les espaces inutiles
    $password = $_POST['password'];

    // Vérifie que les champs ne sont pas vides
    if (empty($username) || empty($password)) {
        $error_message = "Veuillez remplir tous les champs.";
    } else {
        try {
            // Prépare la requête pour récupérer l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Authentification réussie
                $_SESSION['user_id'] = $user['id'];

                // Redirige vers le tableau de bord
                header('Location: dashboard.php');
                exit();
            } else {
                // Authentification échouée
                $error_message = "Identifiant ou mot de passe incorrect.";
            }
        } catch (Exception $e) {
            // Log l'erreur pour analyse (sans afficher au client)
            error_log($e->getMessage());
            $error_message = "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Conquête des Chats</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Orbitron', sans-serif;
            background: radial-gradient(circle, #1a1a1a, #000000);
            color: #ff004c;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            text-align: center;
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #ff004c;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px #ff004c;
            width: 400px;
        }

        h1 {
            color: #ff004c;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px #ff004c;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"], input[type="password"] {
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ff004c;
            border-radius: 5px;
            background: #1a1a1a;
            color: #ff004c;
            font-size: 1rem;
        }

        button {
            background: linear-gradient(to right, #ff004c, #8b0000);
            color: black;
            border: none;
            padding: 0.75rem;
            margin-top: 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-transform: uppercase;
            box-shadow: 0 0 10px #ff004c;
        }

        button:hover {
            background: linear-gradient(to right, #8b0000, #ff004c);
            box-shadow: 0 0 15px #ff004c;
        }

        .error-message {
            color: #ff004c;
            margin-top: 1rem;
            text-shadow: 0 0 10px #ff004c;
        }

        .back-link {
            margin-top: 1rem;
            display: inline-block;
            text-decoration: none;
            color: #ff004c;
            font-weight: bold;
            text-shadow: 0 0 10px #ff004c;
        }

        .back-link:hover {
            color: #8b0000;
        }

        @keyframes glow {
            0% { box-shadow: 0 0 10px #ff004c; }
            50% { box-shadow: 0 0 20px #8b0000; }
            100% { box-shadow: 0 0 10px #ff004c; }
        }

        button {
            animation: glow 1.5s infinite alternate;
        }
    </style>
</head>
<body>
    <div class="login-container">
            <h1>Connexion</h1>
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form method="post" action="index.php">
                <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
    </div>
</body>
</html>
