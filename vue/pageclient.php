<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Client</title>
    <link rel="stylesheet" href="/projet/vue/csspageclient.css">
    
</head>
<body>

<div class="header-container">
  <header>
    <div class="login-form">
      <div class="logo-container">
        <img src="../vue/photos/ChatGPT Image May 2, 2025, 07_17_51 PM.png"  alt="Logo Mouradi Hotels" />
      </div>
      <ul class="nav-pills">
        <li class="nav-item">
          <a href="../controlleur/Controlpageclient.php" class="nav-link">Accueil</a>
        </li>
        
        <li class="nav-item">
          <a href="#services" class="nav-link">Nos Services</a>
        </li>
        <li class="nav-item">
          <a href="#chambres" class="nav-link">Nos Chambres</a>
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
<br><br>
<h1 class="styled-heading">bienvenu à notre hôtel </h1>
<div class="about-container">
  <h1>À propos de nous</h1>
  <p>
    Bienvenue dans notre établissement, où l'élégance rencontre le confort.<br>
    Situé au cœur de SFAX, notre hôtel est conçu pour offrir à chaque visiteur une expérience inoubliable.<br><br>
    Que vous voyagiez pour affaires, en famille ou pour le plaisir, nous vous proposons des chambres modernes, des suites élégantes et un service attentionné.  
    Chaque détail a été pensé pour garantir votre bien-être : literie haut de gamme, espaces lumineux, restauration savoureuse et équipements de qualité.<br><br>
    Notre équipe dévouée est à votre service 24h/24 pour répondre à vos besoins et faire de votre séjour un moment unique.<br><br>
    Chez Y.Ktari, votre satisfaction est notre priorité.<br><br>
    <strong>Votre confort, notre passion.</strong>
  </p>
</div>

<div class="reservation-page" id="services">
<h1>nos Services</h1>
<p>Découvrez nos services exclusifs pour un séjour inoubliable.</p>
<div class="service">
    <img src="../vue/photos/service3.avif" alt="Piscine">
    <h3>Réception 24h/24</h3>
    <p>Accueil des clients, assistance et information.</p>
  </div>
  <div class="service">
    <img src="../vue/photos/images.jpg" alt="Piscine">
    <h3>Piscine</h3>
    <p>Profitez de notre piscine chauffée avec vue magnifique.</p>
  </div>
  <div class="service">
    <img src="../vue/photos/service2.avif" alt="Piscine">
    <h3>Spa & bien-être</h3>
    <p>Massages, soins du corps, sauna, hammam, bains de vapeur.</p>
  </div>
  <div class="service">
    <img src="../vue/photos/images (1).jpg" alt="Mer">
    <h3>Mer</h3>
    <p>Accès direct à la plage pour des moments de détente au bord de mer.</p>
  </div>
  <div class="service">
    <img src="../vue/photos/images (2).jpg" alt="Chambre">
    <h3>Chambres bien équipées</h3>
    <p> Lit confortable, salle de bain privée, télévision, climatisation/chauffage, Wi-Fi gratuit.</p>
  </div>
</div>




<br><br><br>

<div class="hotel-container" id="chambres">
  <h1>Nos Types Des Chambres</h1>
  <?php if (!empty($erreur)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
  <?php endif; ?>
<div class="hotel-cards-header">
   
<div class="chambre-filtres">
  <form method="POST" action="../controlleur/Controlpageclient.php">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Prix Min</label>
        <input type="number" class="form-control" name="prix-min" min="0" placeholder="Prix minimum">
      </div>
      <div class="col-md-6">
        <label class="form-label">Prix Max</label>
        <input type="number" class="form-control" name="prix-max" min="0" placeholder="Prix maximum">
      </div>
      <div class="col-md-6">
        <label class="form-label">Type du Chambre</label>
        <select class="form-select" name="select">
          <option value="">Choisir...</option>
          <option value="simple">simple</option>
          <option value="double">Double</option>
          <option value="suite">Suite</option>
        </select>
      </div>
    </div>
    <div class="buttons-container">
      <button type="submit" class="reserve-btn" name="filtrer">Filtrer</button>
      <button type="submit" class="reserve-btn" name="afficher">Afficher toutes les chambres</button>
    </div>
  </form>
</div>



  <div class="hotel-cards-wrapper">
    <?php if (!empty($chambres)): ?>
      <?php foreach ($chambres as $chambre): ?>
        <div class="hotel-card">
          <?php if (!empty($chambre->photo)): ?>
            <img src="<?= htmlspecialchars($chambre->photo) ?>" alt="Photo de la chambre" class="chambre-photo" />
          <?php endif; ?>
          <h3><?= htmlspecialchars($chambre->type == 0 ? 'Chambre simple' : ($chambre->type == 1 ? 'Chambre double' : 'Suite')) ?></h3>
          <p><strong>Prix :</strong> <?= htmlspecialchars($chambre->prix_nuit) ?> DT</p>
          <p><?= htmlspecialchars($chambre->description) ?></p>
          <form method="POST" action="../controlleur/Controlpageclient.php">
            <input type="hidden" name="num" value="<?= htmlspecialchars($chambre->num_chambre) ?>" />
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
            <button class="reserve-btn" name="reserver">Réserver</button>
            <?php endif; ?>
          </form>
        </div>

      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune chambre disponible à afficher.</p>
    <?php endif; ?>
  </div>
  <br>
  <br>
  <br

</div>
</div>


<br><br><br>


<!--  -----------   reviews      --------------------------------           -->
<div class="carousel-wrapper">
<h1>Our Costumer's reviews</h1>
  <div class="carousel-track">
    
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Yessin Ktari</h5>
            <small class="text-muted">Séjour en Mars 2025</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
    </div>
    <p class="mb-0">
        "Très belle chambre, propre et confortable. Le service était excellent ! Je recommande vivement."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Zayneb Kammoun</h5>
            <small class="text-muted">Séjour en avril 2025</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Un cadre romantique parfait. La vue depuis notre balcon était magnifique et le service en chambre irréprochable. Mention spéciale pour le petit-déjeuner buffet très varié !"
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Aziz Affes</h5>
            <small class="text-muted">Séjour en Mars 2024</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star text-warning"></i> <!-- étoile vide -->
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Très bon hôtel pour un séjour d'affaires. Wi-Fi rapide, salle de réunion bien équipée et chambre calme pour travailler. Service rapide et efficace."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-neutral"></i>
        <div>
            <h5 class="mb-1">Youssef Jardak</h5>
            <small class="text-muted">Séjour en janvier 2025</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star text-warning"></i> <!-- étoile vide -->
                <i class="bi bi-star text-warning"></i> <!-- étoile vide -->
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Accueil chaleureux dès mon arrivée. Le personnel a toujours été disponible pour me conseiller sur les visites à faire autour. Hôtel calme, propre et très bien situé."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">kays saaid</h5>
            <small class="text-muted">Séjour en février 2025</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star text-warning"></i> <!-- étoile vide -->
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Hôtel idéalement situé à deux pas de la plage ! Piscine propre, transats confortables et bar extérieur très agréable. Un séjour de rêve."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Lionel Messi</h5>
            <small class="text-muted">Séjour en décembre 2024</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star text-warning"></i> <!-- étoile vide -->
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Un excellent rapport qualité-prix ! Le personnel parle anglais et français, ce qui a rendu notre séjour très facile. Chambres modernes et restaurant délicieux."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Semer Mallouli</h5>
            <small class="text-muted">Séjour en mai 2024</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
               
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Séjour magique pour notre lune de miel ! Merci pour la surprise en chambre (pétales de rose et champagne). Tout était parfait."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">yessin Aloulou</h5>
            <small class="text-muted">Séjour en avril 2025</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Nous avons passé un week-end merveilleux dans cet hôtel. La chambre était parfaite, avec une vue imprenable sur la ville. Le personnel a même préparé un petit geste pour notre anniversaire de mariage. Une expérience inoubliable !"
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Ali Ben taher</h5>
            <small class="text-muted">Séjour en janvier 2025</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
    </div>
    <p class="mb-0">
    "L'endroit idéal pour mes voyages d'affaires réguliers. La connexion Wi-Fi est stable et rapide, ce qui m'a permis de travailler efficacement. Le service de blanchisserie est rapide, et le personnel est toujours prêt à aider. Recommandé pour les séjours prolongés."
    </p>
</div>
</div>
<div class="reviews">
<div class="review p-4 my-4 rounded shadow">
    <div class="d-flex align-items-center mb-3">
       <i class="bi bi-emoji-smile"></i>
        <div>
            <h5 class="mb-1">Mohamed Trabelsi</h5>
            <small class="text-muted">Séjour en avril 2024</small>
            <div class="stars mt-1">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
    </div>
    <p class="mb-0">
    "Séjour merveilleux en famille ! Les chambres étaient spacieuses, impeccablement propres, et très confortables. Le personnel était aux petits soins pour nous, surtout avec les enfants. Nous reviendrons sans hésiter."
    </p>
</div>
</div>

</div>
</div>


<br><br><br><br><br>

<!---------------- map ------------------------------>
<div class="contact section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 offset-lg-4">
          <div class="section-heading text-center">
            <h6>| Contact Us</h6>
            <h2>Get In Touch With Our Agents</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div id="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d26218.885447501736!2d10.7436091!3d34.7716943!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13002cda1486c695%3A0x22dfe0a62c50ce6f!2sSfax!5e0!3m2!1sen!2stn!4v1745779311926!5m2!1sen!2stn" width="120%" height="500px" frameborder="0" style="border:0; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);" allowfullscreen=""></iframe>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="item phone">
                <h6>+216 25817966<br><span>Téléphone</span></h6>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="item email"> 
                <h6>info@hotelsKtari.com<br><span>Business Email</span></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <form id="contact-form" action="" method="post">
            <div class="row">
              <div class="col-lg-12">
                <fieldset>
                  <label for="name">Full Name</label>
                  <input type="name" name="name" id="name" placeholder="Your Name..." autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="email">Email Address</label>
                  <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="subject">Subject</label>
                  <input type="subject" name="subject" id="subject" placeholder="Subject..." autocomplete="on" >
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="message">Message</label>
                  <textarea name="message" id="message" placeholder="Your Message"></textarea>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <button type="submit" id="form-submit" class="orange-button">Send Message</button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!------------------------------ footer-------------------------- -->

<br><br><br>
<br><br>
<div class="footer-container" id="contact-footer">
    <br>
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="../controlleur/Controlpageclient.php" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="#services" class="nav-link px-2 text-body-secondary">Services</a></li>
      <li class="nav-item"><a href="#chambres" class="nav-link px-2 text-body-secondary">Chambres</a></li>
      <li class="nav-item"><a href="#contact-footer" class="nav-link px-2 text-body-secondary">Contact</a></li>
    </ul>
    </div>
    <hr>
    <div class="text-center">
   
   <center> <p class="text-center text-body-secondary">© 2025 Company, Inc</p></center>
    </div>
    <br>
    <br>
  </footer>


    
</body>
</html>