<?php

class Reservation
{
    private ?int $id;
    private User $user;
    private ?Chambre $chambre;
    private $date_arrive;
    private $date_depart;
    private $typeres;
    private $prix;
    private $nbpers;
    private $nbnuits;
    private $desc;
    private $statut;
   
    public function __construct(?int $id, User $user, ?Chambre $chambre, $date_arrive, $date_depart, $typeres, $nbpers, $nbnuits,$prix,$desc,$statut)
    {
            $this->id = $id;
            $this->user = $user;
            $this->chambre = $chambre;
            $this->date_arrive = $date_arrive;
            $this->date_depart = $date_depart;
            $this->typeres = $typeres;
            $this->nbpers = $nbpers;
            $this->nbnuits = $nbnuits;
            $this->prix = $prix;
            $this->statut = $statut;
            $this->desc = $desc;
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

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }


    /////////////////////////// add reservation ////////////////////////
    public static function addReservation($res)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("INSERT INTO reservation (login, num_chambre, date_arrive, date_depart, type, nbpers, nbnuits, prix, statut, `desc`) 
            VALUES (:login, :num_chambre, :date_arrive, :date_depart, :type, :nbpers, :nbnuits, :prix, :statut, :desc)");
            
            $stmt->bindParam(':login', $res->user->login);
            $stmt->bindParam(':num_chambre', $res->chambre->num_chambre);
            $stmt->bindParam(':date_arrive', $res->date_arrive);
            $stmt->bindParam(':date_depart', $res->date_depart);
            $stmt->bindParam(':type', $res->typeres);
            $stmt->bindParam(':nbpers', $res->nbpers);
            $stmt->bindParam(':nbnuits', $res->nbnuits);
            $stmt->bindParam(':prix', $res->prix);
            $stmt->bindParam(':statut', $res->statut);
            $stmt->bindParam(':desc', $res->desc);
            
            if ($stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                error_log("Erreur SQL: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la réservation: " . $e->getMessage());
            return false;
        } finally {
            $conn = null;
        }
    }

    /////////////////////////// update reservation ////////////////////////
    public static function updateReservation($res)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("UPDATE reservation SET login = :login,num_chambre = :num_chambre,date_arrive = :date_arrive,date_depart = :date_depart,type = :type,nbpers = :nbpers,nbnuits = :nbnuits
            ,prix = :prix,`desc` = :desc,statut = :statut WHERE id = :id");
            $stmt->bindParam(':id', $res->id);
            $stmt->bindParam(':login', $res->user->login);
            $stmt->bindParam(':num_chambre', $res->chambre->num_chambre);
            $stmt->bindParam(':date_arrive', $res->date_arrive);
            $stmt->bindParam(':date_depart', $res->date_depart);
            $stmt->bindParam(':type', $res->typeres);
            $stmt->bindParam(':nbpers', $res->nbpers);
            $stmt->bindParam(':nbnuits', $res->nbnuits);
            $stmt->bindParam(':prix', $res->prix);
            $stmt->bindParam(':desc', $res->desc);
            $stmt->bindParam(':statut', $res->statut);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la réservation: " . $e->getMessage());
            return false;
        } finally {
            $conn = null;
        }
    }

    /////////////////////////// delete reservation ////////////////////////
    public static function deleteReservation($id)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("DELETE FROM reservation WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la réservation: " . $e->getMessage());
            return false;
        } finally {
            $conn = null;
        }
    }

    /////////////////////////// get all reservations ////////////////////////
    public static function getReservations()
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM reservation");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $reservations = [];
            foreach ($results as $result) {
                // Récupérer l'utilisateur associé à la réservation
                $user = User::getUserByLogin($result->login);
                if (!$user) {
                    error_log("Utilisateur non trouvé pour la réservation: " . $result->id);
                    continue;
                }

                // Récupérer la chambre associée à la réservation
                $chambre = Chambre::getChambreById($result->num_chambre);
                if (!$chambre) {
                    error_log("Chambre non trouvée pour la réservation: " . $result->id);
                    continue;
                }

                $reservations[] = new Reservation(
                    $result->id,
                    $user,
                    $chambre,
                    $result->date_arrive,
                    $result->date_depart,
                    $result->type,
                    $result->nbpers,
                    $result->nbnuits,
                    $result->prix,
                    $result->desc,
                    $result->statut
                );
            }
            return $reservations;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réservations: " . $e->getMessage());
            return [];
        } finally {
            $conn = null;
        }
    }


    /////////////////////////// get reservation by user ////////////////////////

    public static function getReservationsByUser($login)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT r.*, c.type as chambre_type, c.prix_nuit 
                                  FROM reservation r 
                                  JOIN chambre c ON r.num_chambre = c.num_chambre 
                                  WHERE r.login = :login 
                                  ORDER BY r.date_arrive DESC");
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($result)) {
                error_log("Aucune réservation trouvée pour l'utilisateur: " . $login);
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réservations de l'utilisateur: " . $e->getMessage());
            return [];
        } finally {
            $conn = null;
        }
    }
    /////////////////////////// get reservation by id ////////////////////////
    public static function getReservationById($id)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM reservation WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                // Récupérer l'utilisateur associé à la réservation
                $user = User::getUserByLogin($result->login);
                if (!$user) {
                    error_log("Utilisateur non trouvé pour la réservation: " . $result->id);
                    return null;
                }

                // Récupérer la chambre associée à la réservation
                $chambre = Chambre::getChambreById($result->num_chambre);
                if (!$chambre) {
                    error_log("Chambre non trouvée pour la réservation: " . $result->id);
                    return null;
                }

                return new Reservation(
                    $result->id,
                    $user,
                    $chambre,
                    $result->date_arrive,
                    $result->date_depart,
                    $result->type,
                    $result->nbpers,
                    $result->nbnuits,
                    $result->prix,
                    $result->desc,
                    $result->statut
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la réservation: " . $e->getMessage());
            return null;
        } finally {
            $conn = null;
        }
    }

    /////////////////////////// check availability ////////////////////////

    public static function checkAvailability($num_chambre, $date_arrive, $date_depart)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT COUNT(*) FROM reservation 
                                  WHERE num_chambre = :num_chambre 
                                  AND ((date_arrive <= :date_depart AND date_depart >= :date_arrive) 
                                  OR (date_arrive <= :date_arrive AND date_depart >= :date_depart))");
            
            $stmt->bindParam(':num_chambre', $num_chambre);
            $stmt->bindParam(':date_arrive', $date_arrive);
            $stmt->bindParam(':date_depart', $date_depart);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification de disponibilité: " . $e->getMessage());
            return true; // En cas d'erreur, on considère la chambre comme non disponible
        } finally {
            $conn = null;
        }
    }

    /////////////////////////// get reservation by date ////////////////////////
    public static function getReservationsByDate($date)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM reservation WHERE date_arrive <= :date AND date_depart >= :date");
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reservations;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        finally {
            $conn = null;
        }
    }

    /////////////////////////// get reservation by chambre ////////////////////////
    public static function getReservationsByChambre($num_chambre)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM reservation WHERE num_chambre = :num_chambre");
            $stmt->bindParam(':num_chambre', $num_chambre);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                // Récupérer l'utilisateur associé à la réservation
                $user = User::getUserByLogin($result->login);
                if (!$user) {
                    error_log("Utilisateur non trouvé pour la réservation: " . $result->id);
                    return null;
                }

                // Récupérer la chambre associée à la réservation
                $chambre = Chambre::getChambreById($result->num_chambre);
                if (!$chambre) {
                    error_log("Chambre non trouvée pour la réservation: " . $result->id);
                    return null;
                }

                return new Reservation(
                    $result->id,
                    $user,
                    $chambre,
                    $result->date_arrive,
                    $result->date_depart,
                    $result->type,
                    $result->nbpers,
                    $result->nbnuits,
                    $result->prix,
                    $result->desc,
                    $result->statut
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la réservation: " . $e->getMessage());
            return null;
        } finally {
            $conn = null;
        }
    }
    /////////////////////////// get reservation by statut ////////////////////////
    public static function getReservationsByStatut($statut)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM reservation WHERE statut = :statut");
            $stmt->bindParam(':statut', $statut);
            $stmt->execute();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reservations;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        finally {
            $conn = null;
        }
    }





    public static function getDateByChambre($num_chambre)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT date_arrive ,date_depart FROM reservation WHERE num_chambre = :num_chambre AND statut = 1");
            $stmt->bindParam(':num_chambre', $num_chambre);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if ($result) {
                return $result;
            }
            return null;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        finally {
            $conn = null;
        }
    }



    /////////////////////////// get reservationEnattendbylogin ////////////////////////

    public static function getReservationEnAttendByLogin($login)
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT * FROM reservation WHERE login = :login AND statut = 0");
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        finally {
            $conn = null;
        }
    }




    /////////////////////////// get last id reservation ////////////////////////
    public static function getLastId()
    {
        try {
            include("../database/connexion.php");
            $stmt = $conn->prepare("SELECT ifnull(MAX(id),0) as last_id FROM reservation");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['last_id'];
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        finally {
            $conn = null;
        }
    }
}

