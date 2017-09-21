<?php
namespace App;

class Connection extends \PDO
{
    private $db = 'symblog'; // base de données
    private $host = 'localhost'; // adresse de la base
    private $user = 'root'; // nom
    private $pwd = ''; // mot de passe
    private $con; //
    private $email='b.rejeb.ali@gmail.com'; // email de l'admin du site

    public function __construct ()
    {
        try
        {
            $this->con = parent::__construct($this->getDns(), $this->user, $this->pwd);
            // pour mysql on active le cache de requête
            if($this->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'mysql')
                $this->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            return $this->con;
        }
        catch(\PDOException $e) {
            die(date('D/m/y').' à '.date("H:i:s").' : '.$e->getMessage());
            //On indique par email qu'on n'a plus de connection disponible
            error_log(date('D/m/y').' à '.date("H:i:s").' : '.$e->getMessage(), 1, $this->email);
            //$message= new Message();
            //$message->outPut('Erreur 500', 'Serveur de BDD indisponible, nous nous excusons de la gêne occasionnée');
        }
    }

    public function fetchAll($table)
    {
        try{
            $stmt = parent::query("Select * from $table");
            return $stmt->fetchAll();
        }catch(\PDOException  $e ){
            echo "Error: ".$e;
        }
    }

    public function select($reqSelect)
    {
        try
        {
            $this->con = parent::beginTransaction();
            //$result= parent::query($reqSelect);
            $result = parent::prepare($reqSelect);
            $result->execute();
            $this->con = parent::commit();
            return $result;
        } catch (\Exception $e) {
            die(date('D/m/y').' à '.date("H:i:s").' : '.$e->getMessage());
            //On indique par email que la requête n'a pas fonctionné.
            error_log(date('D/m/y').' à '.date("H:i:s").' : '.$e->getMessage(), 1, $this->email);
            $this->con =parent::rollBack();
            //$message= new Message();
            //$message->outPut('Erreur dans la requêtte', 'Votre requête a été abandonné');
        }
    }


    public function selectTableau($reqSelect)
    {
        $result = parent::prepare($reqSelect);
        $result->execute();
        /* Récupération de toutes les lignes d'un jeu de résultats "équivalent à mysql_num_row() " */
        $resultat = $result->fetchAll();
        return $resultat;
    }

    public function getDns()
    {
        return 'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8';
    }
}