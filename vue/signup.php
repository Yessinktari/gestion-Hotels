<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Mouradi Hotels</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #3498db;
            --accent-color: #ffd700; /* doré pour rappel du luxe */
            --text-color: #2c3e50;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --background-color: #f4f7fc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Nunito', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            padding: 20px;
        }

        .login-page {
            width: 100%;
            max-width: 500px;
            perspective: 1000px;
        }

        .login-form {
            background: linear-gradient(135deg, #fff 60%, #e3eafc 100%);
            padding: 44px 36px 36px 36px;
            border-radius: 32px;
            box-shadow: 0 8px 32px rgba(26, 35, 126, 0.10), 0 1.5px 8px rgba(52, 152, 219, 0.08);
            text-align: center;
            animation: formAppear 0.6s ease-out;
            border: 1.5px solid #e3eafc;
        }

        @keyframes formAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            margin-bottom: 18px;
            display: flex;
            justify-content: center;
        }

        .logo-container img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            background: white;
            box-shadow: 0 4px 24px rgba(26, 35, 126, 0.10);
            border: 4px solid var(--primary-color);
            transition: transform 0.3s;
        }

        .logo-container img:hover {
            transform: scale(1.07) rotate(-2deg);
        }

        .form-title {
            color: var(--primary-color);
            font-size: 27px;
            margin-bottom: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
            margin-bottom: 22px;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b8d1;
            font-size: 18px;
            transition: color 0.3s;
        }

        input[type="text"], 
        input[type="password"], 
        input[type="email"], 
        input[type="tel"] {
            width: 100%;
            padding: 15px 15px 15px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 16px;
            background-color: #f8fafc;
            transition: all 0.3s;
            box-shadow: 0 1px 4px rgba(26, 35, 126, 0.03);
        }

        input:focus {
            border-color: var(--secondary-color);
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.10);
        }

        input:focus + i {
            color: var(--primary-color);
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            margin-bottom: 15px;
            box-shadow: 0 2px 12px rgba(26, 35, 126, 0.10);
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        button:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 18px rgba(26, 35, 126, 0.18);
        }

        .login-link {
            margin-top: 18px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 15px;
            display: inline-block;
            font-weight: 500;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .error-message {
            background-color: #fef2f2;
            color: var(--error-color);
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #fee2e2;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 1px 6px rgba(231, 76, 60, 0.07);
        }

        @media (max-width: 480px) {
            .login-form {
                padding: 24px 8px;
            }
            .logo-container img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-form">
            <div class="logo-container">
                <img src="../vue/photos/ChatGPT Image May 2, 2025, 07_17_51 PM.png" alt="Logo Mouradi Hotels" />
            </div>
            <h2 class="form-title">Créer un compte</h2>
            <?php if (!empty($_SESSION['erreur'])): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($_SESSION['erreur']) ?>
                </div>
                <?php unset($_SESSION['erreur']); ?>
            <?php endif; ?>
            <form action="../controlleur/ControlSign.php" method="POST">
                <div class="input-group">
                    <input type="text" name="nom" placeholder="Nom complet" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Adresse email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input type="text" name="login" placeholder="Nom d'utilisateur" required>
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="input-group">
                    <input type="text" name="adresse" placeholder="Adresse" required>
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="input-group">
                    <input type="tel" name="telephone" placeholder="Numéro de téléphone" required>
                    <i class="fas fa-phone"></i>
                </div>
                <button type="submit">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </button>
            </form>
            <a href="../vue/authentification.php" class="login-link">
                <i class="fas fa-sign-in-alt"></i> Déjà un compte ? Se connecter
            </a>
        </div>
    </div>
</body>
</html>
