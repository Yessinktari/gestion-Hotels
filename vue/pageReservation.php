<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réservation - Hôtel</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/projet/vue/csspageRes.css">
 
</head>
<body>


<div class="header-container">
  <header>
    <div class="login-form">
    <img src="/projet/vue/photos/ChatGPT Image May 2, 2025, 07_17_51 PM.png" alt="Logo" class="logo" style="width: 80px; height: 80px; border-radius: 50%;">
      <ul class="nav-pills">
        <li class="nav-item">
          <a href="../controlleur/Controlpageclient.php" class="nav-link">Accueil</a>
        </li>
        <li class="nav-item">
          <a href="#contact-footer" class="nav-link">Contact</a>
        </li>
      </ul>
    </div>
    <form class="custom-form" method="post" action="../controlleur/Controlpageclient.php">
      <select name="select" class="mon-compte-link" onchange="this.form.submit()">
        <option value="" disabled selected>MonProfile</option>
        <option value="compte">Mon compte</option>
        <option value="deconnexion">Déconnexion</option>
      </select>
    </form>
  </header>
</div>
<section class="reservation-section">
  <div class="reservation-container">
    <?php if (!empty($erreur)): ?>
      <div class="error-message"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <div class="reservation-form">
      <?php if (!empty($chambre)): ?>
        <div class="room-select">
          <img src="<?= htmlspecialchars($chambre->photo ?? 'default.jpg') ?>" alt="Chambre" class="chambre-photo">
          <h2>
            <?php
              switch ((int)$chambre->type) {
                case 0: echo "Chambre simple"; break;
                case 1: echo "Chambre double"; break;
                case 2: echo "Suite"; break;
                default: echo "Type inconnu";
              }
            ?>
          </h2>
          <p class="price-info">
            <strong>Prix par nuit :</strong> <?= htmlspecialchars($chambre->prix_nuit) ?> DT
          </p>
          <p class="description">
            <strong>Description :</strong> <?= htmlspecialchars($chambre->description) ?>
          </p>
        </div>
      <?php else: ?>
        <p class="error-message">Aucune chambre disponible à afficher.</p>
      <?php endif; ?>

      <div class="reservation-details">
        <h3>Types de Réservation & Tarifs</h3>
        <div class="price-info">
          <?php if (!empty($chambre)): ?>
            <?php $prixBase = floatval($chambre->prix_nuit); ?>
            <div class="price-details">
              <span>Petit-déjeuner inclus</span>
              <span><?= htmlspecialchars($prixBase + 50) ?> DT</span>
            </div>
            <div class="price-details">
              <span>Demi-pension</span>
              <span><?= htmlspecialchars($prixBase + 80) ?> DT</span>
            </div>
            <div class="price-details">
              <span>Pension complète</span>
              <span><?= htmlspecialchars($prixBase + 120) ?> DT</span>
            </div>
            <div class="price-details">
              <span>All inclusive</span>
              <span><?= htmlspecialchars($prixBase + 160) ?> DT</span>
            </div>
          <?php else: ?>
            <p>Aucune information tarifaire disponible.</p>
          <?php endif; ?>
        </div>
      </div>

      <form action="../controlleur/ControlReservation.php?num_chambre=<?= htmlspecialchars($num) ?>" method="POST" class="reservation-form">
        <input type="hidden" name="num_chambre" value="<?= htmlspecialchars($num) ?>">
        
        <div class="form-row">  
          <div class="form-group">
            <label class="form-label">Date Départ</label>
            <input type="date" class="form-control" name="dateDeb" min="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Date Fin</label>
            <input type="date" class="form-control" name="dateFin" min="<?= date('Y-m-d') ?>" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Type de Réservation</label>
            <select class="form-control" name="select" required>
              <option value="">Choisir...</option>
              <option value="dejeuner">Petit-déjeuner inclus</option>
              <option value="demi">Demi-pension</option>
              <option value="complet">Pension complète</option>
              <option value="all">All inclusive</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Nombre de Personnes</label>
            <input type="number" min="1" class="form-control" name="nbpersonnes" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Nombre de Nuits</label>
          <input type="number" min="1" class="form-control" name="nbnuits" required>
        </div>

        <div class="form-group">
          <label class="form-label">Des Spécifications ?</label>
          <textarea class="form-control" name="desc" rows="6" required></textarea>
        </div>

        <button type="submit" name="envoyer" class="reservation-btn">
          <i class="fas fa-check"></i> Réserver
        </button>
      </form>
    </div>
  </div>
</section>

<br><br>
<div class="footer-container" id="contact-footer">
    <br>
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <br>
    <hr>
    <p class="text-center text-body-secondary">© 2025 Company, Inc</p>
  </footer>
</div>


</body>
</html>