<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Hôtel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/projet/vue/cssprofile.css">
</head>
<body>
<div class="header-container">
  <header>
    <div class="login-form">
      <div class="logo-container">
        <img src="/projet/vue/photos/ChatGPT Image May 2, 2025, 07_17_51 PM.png" alt="Logo Mouradi Hotels" class="logo" style="width: 80px; height: 80px; border-radius: 50%;">
      </div>
      <ul class="nav-pills">
        <li class="nav-item">
          <a href="../controlleur/Controlpageclient.php" class="nav-link">Accueil</a>
        </li>
        <li class="nav-item">
          <a href="#contact-footer" class="nav-link">Contact</a>
        </li>
      </ul>
    </div>
    <form class="custom-form" method="post" action="../controlleur/Controlprofile.php">
      <select name="select" class="mon-compte-link" onchange="this.form.submit()">
        <option value="" disabled selected>MonProfile</option>
        <option value="compte">Mon compte</option>
        <option value="deconnexion">Déconnexion</option>
      </select>
    </form>
  </header>
</div>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h1>Bienvenue sur votre profil</h1>
            <p class="profile-subtitle">Gérez vos informations personnelles et vos réservations</p>
        </div>
        

        <div class="profile-content">
            <div class="profile-section">
                <div class="section-header">
                    <i class="fas fa-user-edit"></i>
                    <h2>Informations Personnelles</h2>
                </div>

                
                <form action="../controlleur/Controlprofile.php" method="POST" class="profile-form">
                     <?php if (!empty($_SESSION['erreur'])): ?>

                <div class="alert <?= ($_SESSION['erreur'] !== false) ? 'alert-success' : 'alert-error' ?>">
                    <?= htmlspecialchars($_SESSION['erreur']) ?>
                </div>
                <?php unset($_SESSION['erreur']); ?>
                <?php endif; ?> 
                    <input type="hidden" name="login" value="<?= htmlspecialchars($login) ?>">
                    <input type="hidden" name="type" value="<?= htmlspecialchars($login) ?>">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            Nom d'utilisateur
                        </label>
                        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($login) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-signature"></i>
                            Nom
                        </label>
                        <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($nom) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Adresse
                        </label>
                        <input type="text" class="form-control" name="adresse" value="<?= htmlspecialchars($adresse) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-phone"></i>
                            Téléphone
                        </label>
                        <input type="tel" class="form-control" name="tel" value="<?= htmlspecialchars($tel) ?>">
                    </div>

                    <button type="submit" name="Modifier" class="btn-update" onclick="return confirm('Êtes-vous sûr de vouloir modifier vos informations ?')">
                        <i class="fas fa-save"></i>
                        Mettre à jour
                    </button>
                </form>
            </div>
                        
<div class="profile-section">
<div class="section-header">
    <i class="fas fa-calendar-check"></i>
<h2>Mes Réservations</h2>
    </div>
                
<div class="reservations-list">
    <?php if (!empty($msg)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>
   <?php if (!empty($reservations)): ?>
        <?php foreach ($reservations as $res): ?>
         <div class="reservation-card">
            <div class="reservation-header">
                <i class="fas fa-hotel"></i>
                    <h3>Réservation #<?= htmlspecialchars($res['id']) ?></h3>
            </div>  
            
             <div class="reservation-status <?php 
                    if ($res['statut'] == 1) {
                     echo 'status-confirmed';
                    } elseif ($res['statut'] == 0) {
                    echo 'status-pending';
                    } else {
                    echo 'status-cancelled';
                    }
                ?>">
            <?php
        if ($res['statut'] == 1) {
            echo 'Confirmée';
        } elseif ($res['statut'] == 0) {
        echo 'En attente';
        } else {
         echo 'Annulée';
    }
?>
    </div>
<div>
    <?php if($res['statut'] == 0): ?>
    <form method="post" action="../controlleur/Controlprofile.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($res['id']) ?>">
        <input type="hidden" name="num_chambre" value="<?= htmlspecialchars($res['login']) ?>">
        <input type="hidden" name="num_chambre" value="<?= htmlspecialchars($res['num_chambre']) ?>">
        <div class="reservation-actions">
        <button type="submit" name="payer" class="btn-payer" onclick="return confirm('Êtes-vous sûr de vouloir payer cette réservation ?')">
           <i class="fas fa-credit-card"></i>
           Payer
        </button>
        <button type="submit" name="annuler" class="btn-cancel" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
            <i class="fas fa-times"></i>
            Annuler
        </button>
        </div>
    </form>
    </form>
    <?php endif; ?>
</div>



    <div class="reservation-details">
     <div class="detail-item">
    <i class="fas fa-calendar-alt"></i>
    <div class="date-range">
    <span>Du <?= date('d/m/Y', strtotime($res['date_arrive'])) ?></span>
        <i class="fas fa-arrow-right"></i>
        <span><?= date('d/m/Y', strtotime($res['date_depart'])) ?></span>
    </div>
</div>
<div class="detail-item">
    <i class="fas fa-door-open"></i>
        <?php
     $chambre = Chambre::getChambreById($res['num_chambre']);
    ?>

<?php   
if($chambre){
    if($chambre->type == 0){
    echo '<span>Chambre simple</span>';
    }elseif($chambre->type == 1){
         echo '<span>Chambre double</span>';
}elseif($chambre->type == 2){
        echo '<span>Chambre suite</span>';
    }
}else{
echo '<span>Chambre non disponible</span>';
    }?>
</div>
    <div class="detail-item">
    <i class="fas fa-users"></i>
    <span><?= htmlspecialchars($res['nbpers']) ?> personne(s)</span> </div>
    <div class="detail-item">
    <i class="fas fa-moon"></i>
 <span><?= htmlspecialchars($res['nbnuits']) ?> nuit(s)</span>
    </div>
    <div class="detail-item">
    <span>
    <?php 
        switch($res['type']) {
            case 3:
            echo '<i class="fas fa-crown"></i> All Inclusive';
            break;
            case 2:
            echo '<i class="fas fa-utensils"></i> Pension Complète';
             break;
            case 1:
            echo '<i class="fas fa-coffee"></i> Demi-Pension';
            break;
             case 0:
             echo '<i class="fas fa-bread-slice"></i> Petit-Déjeuner';
             break;
            default:
            echo htmlspecialchars($res['type']);
            }
        ?>
    </span>
    </div>
    </div>
<?php if (!empty($res['desc'])): ?>
    <div class="specifications">
        <i class="fas fa-comment"></i>
    <span><?= htmlspecialchars($res['desc']) ?></span>
    </div>
<?php endif; ?>
     <div class="price-tag">
    <?= number_format($res['prix'], 2) ?> DT
         </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-reservations">
    <i class="fas fa-calendar-times"></i>
    <p>Aucune réservation pour le moment</p>
    </div>
    <?php endif; ?>
    </div>
    </div>
    </div>
    </div>

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


