
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - Hôtel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #3949ab;
            --accent-color: #5c6bc0;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #e0e0e0;
            --success-color: #4caf50;
            --error-color: #f44336;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--light-gray);
            color: var(--text-color);
        }

        .payment-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .payment-header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .payment-form-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section h2 {
            color: var(--primary-color);
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }

        .form-group label i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .card-input-wrapper {
            position: relative;
        }

        .card-icons {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 0.5rem;
        }

        .card-icons i {
            font-size: 1.5rem;
            color: #666;
        }

        .payment-form input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .payment-form input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 35, 126, 0.1);
            outline: none;
        }

        .payment-summary {
            background: var(--light-gray);
            padding: 1.5rem;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .payment-summary h3 {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .summary-item .amount {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-payer {
            background: linear-gradient(to right, #045a06, #05d728);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(3, 95, 64, 0.2);
        }

        .btn-cancel {
            background: linear-gradient(to right, #dc3545, #c82333);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
        }

        .btn-payer:hover, .btn-cancel:hover {
            transform: translateY(-2px);
        }

        .btn-payer:hover {
            background: linear-gradient(to right, #44c823, #84ac0a);
            box-shadow: 0 4px 10px rgba(4, 129, 27, 0.3);
        }

        .btn-cancel:hover {
            background: linear-gradient(to right, #c82333, #bd2130);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        @media (max-width: 768px) {
            .payment-form-container {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .card-icons {
                display: none;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-payer, .btn-cancel {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <h1><i class="fas fa-credit-card"></i> Paiement de la réservation</h1>
            <p>Veuillez remplir les informations de paiement ci-dessous</p>
        </div>

        <div class="payment-form-container">
            <form action="../controlleur/ControlPayement.php" method="POST" class="payment-form">
                <div class="form-section">
                    <h2>Informations de la carte</h2>
                    
                    <div class="form-group">
                        <label for="card-number">
                            <i class="fas fa-credit-card"></i>
                            Numéro de carte
                        </label>
                        <div class="card-input-wrapper">
                            <input type="text" id="card-number" name="card_number" 
                                   pattern="[0-9]{16}" maxlength="16" required
                                   placeholder="1234 5678 9012 3456">
                            <div class="card-icons">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-amex"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry-date">
                                <i class="fas fa-calendar-alt"></i>
                                Date d'expiration
                            </label>
                            <input type="text" id="expiry-date" name="expiry_date" 
                                   pattern="(0[1-9]|1[0-2])\/([0-9]{2})" 
                                   placeholder="MM/AA" maxlength="5" required>
                        </div>

                        <div class="form-group">
                            <label for="cvv">
                                <i class="fas fa-lock"></i>
                                Code de sécurité
                            </label>
                            <input type="text" id="cvv" name="cvv" 
                                   pattern="[0-9]{3,4}" maxlength="4" required
                                   placeholder="123">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Informations personnelles</h2>
                    
                    <div class="form-group">
                        <label for="card-name">
                            <i class="fas fa-user"></i>
                            Nom sur la carte
                        </label>
                        <input type="text" id="card-name" name="card_name" required
                               placeholder="JEAN DUPONT">
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input type="email" id="email" name="email" required
                               placeholder="jean.dupont@email.com">
                    </div>
                </div>

                <div class="payment-summary">
                    <h3>Récapitulatif du paiement</h3>
                    <div class="summary-item">
                        <span>Montant total</span>
                        <?php if (!empty($reservation)): ?>
                            <?php $prix = $reservation->prix; ?>
                        <span class="amount"><?php htmlspecialchars($prix) ?> DT</span>
                        <?php else: ?>
                            <span class="amount">0 DT</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="history.back()">
                        <i class="fas fa-times"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn-payer">
                        <i class="fas fa-lock"></i>
                        Payer maintenant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Formatage automatique du numéro de carte
        document.getElementById('card-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.substr(0, 16);
            e.target.value = value;
        });

        // Formatage automatique de la date d'expiration
        document.getElementById('expiry-date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substr(0,2) + '/' + value.substr(2);
            }
            e.target.value = value;
        });

        // Validation du CVV
        document.getElementById('cvv').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</body>
</html>