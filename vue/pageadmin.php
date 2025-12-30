<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Hôtel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/projet/vue/cssadmin.css">
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
              <img src="/projet/vue/photos/ChatGPT Image May 2, 2025, 07_17_51 PM.png" alt="Logo" class="logo" style="width: 50px; height: 50px; border-radius: 50%;">
                <h3>Administration</h3>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="">
                        <i class="fas fa-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="#chambres">
                        <i class="fas fa-bed"></i>
                        <span>Gestion des chambres</span>
                    </a>
                </li>
                <li>
                    <a href="#reservations">
                        <i class="fas fa-calendar-check"></i>
                        <span>Gestion des réservations</span>
                    </a>
                </li>
                <li>
                    <a href="#clients">
                        <i class="fas fa-users"></i>
                        <span>Gestion des clients</span>
                    </a>
                </li>
                <li>
                    <a href="../controlleur/Controlpageclient.php">
                        <i class="fas fa-globe"></i>
                        <span>Retour au site</span>
                    </a>
                </li>
                <li>
                    <a href="../controlleur/ControlAuth.php" class="logout-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- ------------------------ inforamtions personnelles------------------------------------ -->

    <main class="admin-main-content">
      <div class="admin-container">
      <!-- Section Informations Personnelles -->
      <section class="admin-section profile-section">
      <form action="../controlleur/ControlAdmin.php" method="post"> 
      <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['login'] ?? '') ?>">
      <div class="admin-section-header">
      <h2><i class="fas fa-user-circle"></i> Mon Profil</h2>
      <div class="action-buttons">
          <input type="submit" name="modifierInfo" value="Modifier mes infos" class="edit-input">
        </div>

    </div>
      <div class="profile-content">
      <div class="profile-info">


      <div class="profile-avatar"><i class="fas fa-user-circle"></i> </div>


      <div class="profile-details">

    
        <div class="info-group"><label>Nom d'utilisateur:</label>
        <input type="text" class="info-value" name="login" value="<?= htmlspecialchars($_SESSION['login'] ?? '') ?>" readonly></div>


            <div class="info-group"><label>Email:</label>

                  <input type="email" class="info-value" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>"></div>


                  <div class="info-group"><label>Nom:</label>

<input type="text" class="info-value" name="nom" value="<?= htmlspecialchars($_SESSION['nom'] ?? '') ?>"></div>


<div class="info-group"><label>Adresse:</label>

<input type="text" class="info-value" name="adresse" value="<?= htmlspecialchars($_SESSION['adresse'] ?? '') ?>"></div>


           <div class="info-group"><label>Téléphone:</label>
            <input type="text" class="info-value" name="tel" value="<?= htmlspecialchars($_SESSION['tel'] ?? '') ?>"></div>

            <div class="info-group">
              <label>Rôle:</label><input type="text" class="info-value" name="role" value="<?php
    switch($_SESSION['role']){
        case 1: echo 'Administrateur'; break;
        case 2: echo 'Client'; break;}?>" readonly></div>


            </div>

          </div>
        </div>
        <?php if (isset($_SESSION['erreur_profil'])): ?>
        <div class="success-message" style=" background-color: #e8f5e9; color: #4caf50; border: 1px solid #c8e6c9;">
          <center>  <i class="fas fa-check-circle"></i> <?= $_SESSION['erreur_profil'] ?></center>
        </div>
        <?php unset($_SESSION['erreur_profil']); ?>
      <?php endif; ?>
        </form> 
  </section>









  <!-- ------------------------ gestion des chambres------------------------------------ -->
               




    <div class="admin-content">
    <section class="admin-section" id="chambres">
    
    <div class="admin-section-header">
    <h2><i class="fas fa-door-open"></i> Gestion des Chambres</h2>
    <form action="../controlleur/ControlAdmin.php" method="post"> 
    <div class="action-buttons">
    <button type="submit" class="btn-add" name="ajouterChambre"><i class="fas fa-plus"></i> Ajouter une chambre</button>
    </div>
    </form>
    </div>
    <div class="table-responsive">
<table class="admin-table">
    <thead>
    <tr>
    <th>Photo</th>
    <th>Numéro</th>
    <th>Type</th>
    <th>Prix/Nuit</th>
    <th>Disponibilité</th>
    <th>Description</th>
    <th>Actions</th>
    </tr>
    </thead>
<tbody>
    <?php foreach ($chambres as $chambre): ?>
        <tr>
          <td><img src="<?= htmlspecialchars($chambre->photo) ?>" alt="Photo de la chambre" class="chambre-photo" style="width: 80px; height: 80px; border-radius: 50%;" /></td>
          <td><input type="text" class="info-value" name="num_chambre" readonly value="<?= htmlspecialchars($chambre->num_chambre) ?>" ></td>
          <td>
            <?php
            switch($chambre->type) {
              case 0: echo 'Simple'; break;
              case 1: echo 'Double'; break;
              case 2: echo 'Suite'; break;
            }
            ?>
          </td>
          <td>
            <form action="../controlleur/ControlAdmin.php" method="post" style="display:inline;">
              <input type="hidden" name="num_chambre" value="<?= htmlspecialchars($chambre->num_chambre) ?>">
              <input type="hidden" name="type" value="<?= htmlspecialchars($chambre->type) ?>">
              <input type="hidden" name="dispo" value="<?= htmlspecialchars($chambre->dispo) ?>">
              <input type="hidden" name="photo" value="<?= htmlspecialchars($chambre->photo) ?>">
              <input type="text" class="info-value" name="prix_nuit" value="<?= htmlspecialchars($chambre->prix_nuit) ?>">
          </td>
          <td>
            <center><span class="status-badge <?= $chambre->dispo == 1 ? 'unavailable' : 'available' ?>">
              <?php if($chambre->dispo == 1): ?>
                <?php if ($res = Reservation::getDateByChambre($chambre->num_chambre)): ?>
                <center> <span><i class="fas fa-times"></i> Indisponible du <?= date('d/m/Y', strtotime($res->date_arrive)) ?> au <?= date('d/m/Y', strtotime($res->date_depart)) ?></span></center>
                <?php else: ?>
                <?php endif; ?>
              <?php else: ?>
                <span><i class="fas fa-check"></i> Disponible</span>
              <?php endif; ?>
            </span>
            </center>
          </td>
          <td><input type="text" class="info-value" name="description" value="<?= htmlspecialchars($chambre->description) ?>"></td>
          <td>
              <button type="submit" class="btn-edit" name="modifierChambre" title="Modifier">
                <i class="fas fa-edit"></i>
              </button>
              <button type="submit" class="btn-delete" name="supprimerChambre" title="Supprimer"><i class="fas fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!empty($_SESSION['show_add_ch_row'])): ?>
                  <form action="../controlleur/ControlAdmin.php" method="post" enctype="multipart/form-data">
                    <tr>
                      <td><input type="file" name="photo" accept="image/*" required></td>
                      <td><input type="text" class="info-value" name="num_chambre" placeholder="num_chambre" required></td>
                      <td>
                        <select name="type" class="info-value">
                          <option value="0">Simple</option>
                          <option value="1">Double</option>
                          <option value="2">Suite</option>

                        </select>
                      </td>
                      <td><input type="text" class="info-value" name="prix" placeholder="prix nuit" required></td>
                      <td><input type="hidden" name="dispo" value="0"></td>

                      <td><input type="text" class="info-value" name="description" placeholder="Description" required></td>
                      <td>
                        <button type="submit" class="btn-save" name="validerAjoutCh" title="Valider">
                          <i class="fas fa-check"></i>
                        </button>
                        <button type="submit" class="btn-delete" name="annulerAjoutCh" title="Annuler">
                          <i class="fas fa-times"></i>
                        </button>
                      </td>
                    </tr>
                  </form>
                  <?php unset($_SESSION['show_add_user_row']); ?>
                <?php endif; ?>
</tbody>
</table>
<?php if (isset($_SESSION['erreur_chambre'])): ?>
  <?php
    $msg = $_SESSION['erreur_chambre'];
    $isSuccess = stripos($msg, 'succès') !== false || stripos($msg, 'modifiée') !== false || stripos($msg, 'ajoutée') !== false;
  ?>
  <div class="<?= $isSuccess ? 'success-message' : 'error-message' ?>" style="
    background-color: <?= $isSuccess ? '#e8f5e9' : '#f44336' ?>;
    color: <?= $isSuccess ? '#4caf50' : '#fff' ?>;
    border: 1px solid <?= $isSuccess ? '#c8e6c9' : '#f44336' ?>;
    margin-top: 15px;">
    <center>
      <i class="fas <?= $isSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i> <?= $msg ?>
    </center>
  </div>
  <?php unset($_SESSION['erreur_chambre']); ?>
<?php endif; ?>
</form>

</div>
                 </section>

                    <!-- ------------------------ gestion des réservations------------------------------------ -->
                    <!-- Section Réservations -->
<section class="admin-section" id="reservations">
<div class="admin-section-header">
<h2><i class="fas fa-calendar-check"></i> Gestion des Réservations</h2>
<form action="../controlleur/ControlAdmin.php" method="post"> 
<div class="action-buttons">
<button type="submit" class="btn-add" name="ajouterReservation"><i class="fas fa-plus"></i> Ajouter une réservation</button>
</div>
</div>
</form>
<div class="table-responsive">
<table class="admin-table">
<thead>
<tr>
<th>ID</th>
<th>Client</th>
<th>Chambre</th>
<th>Dates</th>
<th>Type</th>
<th>Nombre de personnes</th>
<th>Nombre de nuits</th>
<th>Prix</th>
<th>Statut</th>
<th>Actions</th>
        </tr>
          </thead>
<tbody>
<?php foreach ($reservations as $res): ?>
<tr>
<td><?= htmlspecialchars($res->id) ?></td>
<td><?= htmlspecialchars($res->user->login) ?></td>
<td><?= htmlspecialchars($res->chambre->num_chambre) ?></td>
          <td><?= date('d/m/Y', strtotime($res->date_arrive)) ?> -> <?= date('d/m/Y', strtotime($res->date_depart)) ?></td>
       <td>
       <?php
       switch($res->typeres) {
      case 0: echo 'Petit-déjeuner'; break;
      case 1: echo 'Demi-pension'; break;
      case 2: echo 'Pension complète'; break;
      case 3: echo 'All inclusive'; break;
    }?>
      </td>
      <td><?= htmlspecialchars($res->nbpers) ?></td>
      <td><?= htmlspecialchars($res->nbnuits) ?></td>
        <td><?= htmlspecialchars($res->prix) ?> DT</td>
        <td>
          <span class="status-badge 
  <?php 
    switch($res->statut) {
        case 0: echo 'pending'; break;
        case 1: echo 'confirmed'; break;
        case 2: echo 'refused'; break;
        }
    ?>">
      <?php
        switch($res->statut) {
          case 0: echo 'En attente'; break;
          case 1: echo 'Confirmée'; break;
          case 2: echo 'Refusée'; break;
        }
    ?>
  </span>
</td>
            <td>
  <?php if ($res->statut == 0): ?>
    <form action="../controlleur/ControlAdmin.php" method="post">
      <input type="hidden" name="id" value="<?= htmlspecialchars($res->id) ?>">
      <input type="hidden" name="num_chambre" value="<?= htmlspecialchars($res->chambre->num_chambre) ?>">
      <div class="action-buttons">
        <button class="btn-edit" name="approuver" onclick="return confirm('Voulez-vous vraiment approuver cette réservation ?')">Approuver</button>
        <button class="btn-delete" name="refuser" onclick="return confirm('Voulez-vous vraiment refuser cette réservation ?')">Refuser</button>
      </div>
    </form>
  <?php else: ?>
    <span style="color: #aaa;">-</span>
  <?php endif; ?>
</td>
</tr>
    <?php endforeach; ?>
    </tbody>
   </table>
  </div>
</section>

                    <!-- ------------------------ gestion des utilisateurs------------------------------------ -->
                    <!-- Section Utilisateurs -->
  <section class="admin-section" id="clients">
    <div class="admin-section-header">
        <h2><i class="fas fa-users"></i> Gestion des Utilisateurs</h2>
        <form action="../controlleur/ControlAdmin.php" method="post"> 
          <div class="action-buttons">
            <button type="submit" class="btn-add" name="ajouterUser"><i class="fas fa-plus"></i> Ajouter un utilisateur</button>
            </div>
        </form>
          </div>
            <div class="table-responsive">
             <table class="admin-table">
               <thead>
                   <tr>
                    <th>Login</th>
                    <th>Password</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                  <form action="../controlleur/ControlAdmin.php" method="post">
                    <td><input type="text" class="info-value" name="login" value="<?= htmlspecialchars($user->login) ?>" readonly></td>
                    <td><input type="text" class="info-value" name="password" value="<?= htmlspecialchars($user->password) ?>" readonly></td>
                    <td><input type="text" class="info-value" name="nom" value="<?= htmlspecialchars($user->nom) ?>"></td>
                    <td><input type="text" class="info-value" name="email" value="<?= htmlspecialchars($user->email) ?>"></td>
                    <td><input type="text" class="info-value" name="adresse" value="<?= htmlspecialchars($user->adresse) ?>"></td>
                    <td><input type="text" class="info-value" name="tel" value="<?= htmlspecialchars($user->tel) ?>"></td>
                    <td>
                      <span class="status-badge <?= $user->role == 1 ? 'admin' : 'user' ?>">
                        <?= $user->role == 1 ? 'Admin' : 'Client' ?>
                      </span>
                      <input type="hidden" name="role" value="<?= htmlspecialchars($user->role) ?>">
                    </td>
                    <td>
                      <?php if ($user->login != $_SESSION['login']): ?>
                      <button type="submit" class="btn-edit" name="modifierUser" title="Modifier">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button type="submit" class="btn-delete" name="supprimerUser" title="Supprimer">
                        <i class="fas fa-trash"></i>
                      </button>
                      <?php endif; ?>
                    </td>
                  </form>
                </tr>
                <?php endforeach; ?>
                <?php if (!empty($_SESSION['show_add_user_row'])): ?>
                  <form action="../controlleur/ControlAdmin.php" method="post">
                    <tr>
                      <td><input type="text" class="info-value" name="login" placeholder="Login" required></td>
                      <td><input type="text" class="info-value" name="password" placeholder="Password" required></td>
                      <td><input type="text" class="info-value" name="nom" placeholder="Nom" required></td>
                      <td><input type="text" class="info-value" name="email" placeholder="Email" required></td>
                      <td><input type="text" class="info-value" name="adresse" placeholder="Adresse" required></td>
                      <td><input type="text" class="info-value" name="tel" placeholder="Téléphone" required></td>
                      <td>
                        <select name="role" class="info-value">
                          <option value="1">Admin</option>
                          <option value="0">Client</option>
                        </select>
                      </td>
                      <td>
                        <button type="submit" class="btn-save" name="validerAjoutUser" title="Valider">
                          <i class="fas fa-check"></i>
                        </button>
                        <button type="submit" class="btn-delete" name="annulerAjoutUser" title="Annuler">
                          <i class="fas fa-times"></i>
                        </button>
                      </td>
                    </tr>
                  </form>
                  <?php unset($_SESSION['show_add_user_row']); ?>
                <?php endif; ?>
              </tbody>
              <?php if (isset($_SESSION['erreur_user'])): ?>
                <?php
                  $msg = $_SESSION['erreur_user'];
                  $isSuccess = stripos($msg, 'succès') !== false || stripos($msg, 'modifiée') !== false || stripos($msg, 'ajoutée') !== false;
                ?>
                <div class="<?= $isSuccess ? 'success-message' : 'error-message' ?>" style="
                  background-color: <?= $isSuccess ? '#e8f5e9' : '#f44336' ?>;
                  color: <?= $isSuccess ? '#4caf50' : '#fff' ?>;
                  border: 1px solid <?= $isSuccess ? '#c8e6c9' : '#f44336' ?>;
                  margin-top: 15px;">
                  <center>
                    <i class="fas <?= $isSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i> <?= $msg ?>
                  </center>
                </div>
                <?php unset($_SESSION['erreur_user']); ?>
              <?php endif; ?>
            </table>
          </div>
        </section>
                </div>
            </div>

            <div class="footer-container">
                <footer class="py-3 my-4">
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
                    </ul>
                    <p class="text-center text-body-secondary">© 2025 Company, Inc</p>
                </footer>
            </div>
        </main>
    </div>

</body>
</html>


