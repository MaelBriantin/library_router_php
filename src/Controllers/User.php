<?php
namespace Controllers;

use PDO;
use Core\Connection;
use Traits\ReturnJson;


class User
{
    use ReturnJson;
    protected $connection;
    protected $table = 'users';
    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function index()
    {
        $sql = $this->connection->prepare("SELECT * FROM $this->table");
        $sql->execute();
        echo return_json($sql->fetchAll());
    }

    public function show($id, $return = false)
    {
        $sql = $this->connection->prepare("SELECT * FROM $this->table WHERE id = :id");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        if ($return) {
            return $sql->fetch();
        } else {
            echo return_json($sql->fetch());
        }
    }

    public function update($object, $id)
    {
        $username = $object['username'];
        $mail = $object['mail'];
        $sql = $this->connection->prepare("UPDATE $this->table SET username = :username, mail = :mail  WHERE id = :id");
        $sql->bindValue(':username', $username);
        $sql->bindValue(':mail', $mail);
        $sql->bindValue(':id', $id);
        $sql->execute();
        //echo "User modified. Username: $username. Mail: $mail.";
    }


    public function create($object)
    {
        $username = $object['username'];
        $mail = $object['mail'];
        //$sql = $this->connection->prepare("INSERT INTO $this->table (username, mail) VALUES (:username, :mail)");
        $sql = $this->connection->prepare("INSERT INTO $this->table (username, mail) VALUES (:username, :mail)");
        $sql->bindValue(':username', $username);
        $sql->bindValue(':mail', $mail);
        $sql->execute();
        //echo "User added. Username: $username. Mail: $mail.";
    }

    public function destroy($id)
    {
        $sql = $this->connection->prepare("DELETE FROM $this->table WHERE id = :id;");
        $sql->bindValue(':id', $id);
        $sql->execute();
        //echo "User removed.";
    }

    public function library($id)
    {
        $user = new \stdClass();
        $user->name = $this->show($id, true)['username'];
        $library = new Library();
        $user->library = $library->show($id, true);
        echo return_json($user);
    }
}