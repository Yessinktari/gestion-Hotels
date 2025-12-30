<?php 

class Chambre
{
    private $num_chambre;
    private $type;
    private $prix_nuit;
    private $dispo;
    private $description;
    private $photo;
   
    public function __construct($numch, $type, $prix_nuit, $dispo, $description, $photo)
    {
        $this->num_chambre = $numch;
        $this->type = $type;
        $this->prix_nuit = $prix_nuit;
        $this->dispo = $dispo;
        $this->description = $description;
        $this->photo = $photo;
    }

    public function __get($attr)
    {
        return isset($this->$attr) ? $this->$attr : "erreur";
    }

    public function __set($attr, $val)
    {
        $this->$attr = $val;
    }

    public function __isset($attr)
    {
        return isset($this->$attr);
    }


    public function __unset($attr)
    {
        unset($this->$attr);
    }


    public function setDispo($dispo)
    {
        $this->dispo = $dispo;
    }   





    public function __toString()
    {
        $s = "<div class='hotel-card'>";
        
        if ($this->photo) {
            $s .= "<img src='" . htmlspecialchars($this->photo) . "' class='chambre-photo' alt='Photo de la chambre' />";
        }
        
        switch ($this->type) {
            case 0:
                $s .= "<h3>Chambre simple</h3>";
                break;
            case 1:
                $s .= "<h3>Chambre double</h3>";
                break;
            case 2:
                $s .= "<h3>Suite</h3>";
                break;
            default:
                $s .= "<h3>Type inconnu</h3>";
        }
        
        $s .= "<p>" . htmlspecialchars($this->description) . "</p>";
        $s .= "<p>" . htmlspecialchars($this->prix_nuit) . " DT</p>";
        
        if ($this->dispo == 0) {
            $s .= "<p class='text-success'>Chambre disponible</p>";
        } else {
            $s .= "<p class='text-danger'>Chambre non disponible</p>";
        }
        
        $s .= "</div>";
        
        return $s;
    }



    //////////// ajouter une chambre ////////////

    public static function addChambre($chambre)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("INSERT INTO chambre (photo,num_chambre, type, prix_nuit, dispo, description) VALUES (:photo,:num_chambre, :type, :prix, :dispo, :description)");
            $stmt->bindParam(":photo", $chambre->photo);
            $stmt->bindParam(":num_chambre", $chambre->num_chambre);
            $stmt->bindParam(":type", $chambre->type);
            $stmt->bindParam(":prix", $chambre->prix_nuit);
            $stmt->bindParam(":dispo", $chambre->dispo);
            $stmt->bindParam(":description", $chambre->description);
            $stmt->bindParam(":photo", $chambre->photo);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la chambre: " . $e->getMessage());
            return false;
        } finally {
            $conn = null;
        }
    }

    //////////// modifier une chambre ////////////

    public static function updateChambre($chambre)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("UPDATE chambre SET type = :type,prix_nuit = :prix_nuit,dispo = :dispo,description = :description WHERE num_chambre = :num_chambre");
            $stmt->bindParam(':num_chambre', $chambre->num_chambre);
            $stmt->bindParam(':type', $chambre->type);
            $stmt->bindParam(':prix_nuit', $chambre->prix_nuit);
            $stmt->bindParam(':dispo', $chambre->dispo);
            $stmt->bindParam(':description', $chambre->description);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la chambre: " . $e->getMessage());
            return false;
        } finally {
            $conn = null;
        }
    }


    //////////// supprimer une chambre ////////////
    public static function deleteChambre($num_chambre)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("DELETE FROM chambre WHERE num_chambre = :num_chambre");
            $stmt->bindParam(":num_chambre", $num_chambre);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la chambre: " . $e->getMessage());
            return false;
        } finally {
            $conn = null;
        }
    }


    //////////// recuperer une chambre par son id ////////////
    public static function getChambreById($num_chambre)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM chambre WHERE num_chambre = :num_chambre");
            $stmt->bindParam(':num_chambre', $num_chambre);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                return new Chambre(
                    $result->num_chambre,
                    $result->type,
                    $result->prix_nuit,
                    $result->dispo,
                    $result->description,
                    $result->photo
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la chambre: " . $e->getMessage());
            return null;
        } finally {
            $conn = null;
        }
    }



    //////////// recuperer une chambre par son type ////////////
public static function getChambre1ByType($type)
{
    try {
        include("../database/connexion.php");
        $stmt = $conn->prepare("SELECT * FROM chambre WHERE type = :type AND dispo = 0 limit 1");
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ); // Fetch as an object

        if ($result) {
            return new Chambre($result->num_chambre,$result->type,$result->prix_nuit,$result->dispo,$result->description,$result->photo);
        }
        return null;
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de la chambre par type: " . $e->getMessage());
        return null;
    } finally {
        $conn = null;
    }
}

//////////// recuperer toutes les chambres par son type ////////////

public static function getChambresByType($type)
{
    try {
        include("../database/connexion.php");

        // Préparer la requête SQL
        $stmt = $conn->prepare("SELECT * FROM chambre WHERE type = :type AND dispo = 0");
        $stmt->bindParam(":type", $type, PDO::PARAM_INT);
        $stmt->execute();

        // Récupérer toutes les chambres correspondantes
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Vérifier si des résultats ont été trouvés
        if ($results) {
            $chambres = [];
            foreach ($results as $result) {
                $chambres[] = new Chambre($result->num_chambre,$result->type,$result->prix_nuit,$result->dispo,$result->description,$result->photo);
            }
            return $chambres; // Retourner un tableau d'objets Chambre
        }

        return []; // Retourner un tableau vide si aucune chambre n'est trouvée
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des chambres par type: " . $e->getMessage());
        return [];
    } finally {
        $conn = null;
    }
}




    //////////// recuperer toutes les chambres ////////////


    public static function getChambres()
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM chambre");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $chambres = [];
            foreach ($results as $result) {
                $chambres[] = new Chambre(
                    $result->num_chambre,
                    $result->type,
                    $result->prix_nuit,
                    $result->dispo,
                    $result->description,
                    $result->photo
                );
            }
            return $chambres;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des chambres: " . $e->getMessage());
            return [];
        } finally {
            $conn = null;
        }
    }

    
    //////////// recuperer toutes les chambres disponibles ////////////
    public static function getChambresDispo()
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM chambre WHERE dispo = 0 OR dispo IS NULL");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if (empty($results)) {
                error_log("Aucune chambre disponible trouvée dans la base de données");
            }
            
            $chambres = [];
            foreach ($results as $result) {
                $chambres[] = new Chambre(
                    $result->num_chambre,
                    $result->type,
                    $result->prix_nuit,
                    $result->dispo,
                    $result->description,
                    $result->photo
                );
            }
            return $chambres;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des chambres disponibles: " . $e->getMessage());
            return [];
        } finally {
            $conn = null;
        }
    }

    

    //////////////////  filtrer ////////////////////////////////////

    public static function filterChambre($type, $prix_min, $prix_max)
    {
        include("../DataBase/connexion.php");
        $sql = "SELECT * FROM chambre WHERE dispo = 0";
        $params = array();

        // Gestion du type de chambre
        if ($type !== null) {
            $sql .= " AND type = :type";
            $params[':type'] = $type;
        }

        // Gestion du prix minimum
        if (isset($prix_min) && $prix_min !== '') {
            $sql .= " AND prix_nuit >= :prix_min";
            $params[':prix_min'] = $prix_min;
        }

        // Gestion du prix maximum
        if (isset($prix_max) && $prix_max !== '') {
            $sql .= " AND prix_nuit <= :prix_max";
            $params[':prix_max'] = $prix_max;
        }

        $stmt = $conn->prepare($sql);

        // Binding des paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $listChambres = [];
        
        foreach ($results as $result) {
            $listChambres[] = new Chambre(
                $result->num_chambre,
                $result->type,
                $result->prix_nuit,
                $result->dispo,
                $result->description,
                $result->photo
            );
        }
        return $listChambres;
    }




}