    <?php

    class User {
        private $login;
        private $password;
        private $nom;
        private $role;
        private $email;
        private $adresse;
        private $tel;

        public function __construct($log, $ps, $n = null, $r = null, $em = null, $adr = null, $t = null)
        {
            $this->login = $log;
            $this->password = $ps;
            $this->nom = $n;
            $this->role = $r;
            $this->email = $em;
            $this->adresse = $adr;
            $this->tel = $t;
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

        public function __toString()
        {
            return "Utilisateur connecté: " . $this->login;
        }


    ////////// connexion //////////
        public static function connect($login, $password)
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE login = ? AND password = ?");
                $stmt->execute([$login, $password]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    return new User(
                        $result['login'],
                        $result['password'],
                        $result['nom'],
                        $result['role'],
                        $result['email'],
                        $result['adresse'],
                        $result['tel']
                    );
                }
                return false;
            } catch (PDOException $e) {
                error_log("Erreur de connexion: " . $e->getMessage());
                return false;
            } finally {
                $conn = null;
            }
        }

        ///// ajouter un utilisateur ////
        public function register()
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("INSERT INTO utilisateur (login, password, nom, role, email, adresse, tel) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                
                return $stmt->execute([
                    $this->login,
                    $this->password,
                    $this->nom,
                    $this->role,
                    $this->email,
                    $this->adresse,
                    $this->tel
                ]);
            } catch (PDOException $e) {
                error_log("Erreur lors de l'inscription: " . $e->getMessage());
                return false;
            } finally {
                $conn = null;
            }
        }


        /// methode pour modifier un utilisateur ///
        public static function updateUser($user)
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("UPDATE utilisateur 
                                    SET nom = :nom, 
                                        password = :password, 
                                        adresse = :adresse, 
                                        tel = :tel 
                                    WHERE login = :login");
                
                $stmt->bindParam(":login", $user->login);
                $stmt->bindParam(":nom", $user->nom);
                $stmt->bindParam(":password", $user->password);
                $stmt->bindParam(":adresse", $user->adresse);
                $stmt->bindParam(":tel", $user->tel);
                
                return $stmt->execute();
            } catch (PDOException $e) {
                error_log("Erreur lors de la mise à jour de l'utilisateur: " . $e->getMessage());
                return false;
            } finally {
                $conn = null;
            }
        }

        ///// methode pour supprimer un utilisateur ////
        public static function deleteUser($login)
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("DELETE FROM utilisateur WHERE login = ?");
                return $stmt->execute([$login]);
            } catch (PDOException $e) {
                error_log("Erreur lors de la suppression de l'utilisateur: " . $e->getMessage());
                return false;
            } finally {
                $conn = null;
            }
        }

        ///// recuperation de tous les utilisateurs ////
        public static function getAllUsers()
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("SELECT * FROM utilisateur");
                $stmt->execute();
                $users = [];
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $users[] = new User(
                        $row->login,
                        $row->password,
                        $row->nom,
                        $row->role,
                        $row->email,
                        $row->adresse,
                        $row->tel);
                }
                return $users;
            } finally {
                $conn = null;
            }
        }

        ///// verification si user existe ////
        public static function userExists($login, $email, $tel)
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateur WHERE login = ? OR email = ? OR tel = ?");
                $stmt->execute([$login, $email, $tel]);
                return $stmt->fetchColumn() > 0;
            } catch (PDOException $e) {
                error_log("Erreur lors de la vérification de l'existence de l'utilisateur: " . $e->getMessage());
                return false;
            } finally {
                $conn = null;
            }
        }

        ///// recuperation d'un utilisateur par son login ////
        public static function getUserByLogin($login)
        {
            try {
                include("../database/connexion.php");
                $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE login = ?");
                $stmt->execute([$login]);
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                
                if ($result) {
                    return new User(
                        $result->login,
                        $result->password,
                        $result->nom,
                        $result->role,
                        $result->email,
                        $result->adresse,
                        $result->tel
                    );
                }
                return null;
            } catch (PDOException $e) {
                error_log("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
                return null;
            } finally {
                $conn = null;
            }
        }


    }
