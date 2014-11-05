<?php
//User class with methods for user table - select or modify operations
class User {
    public function fetch_user($user_id){
        global $pdo;

        $query = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $query->bindValue(1, $user_id);
        $query->execute();

        return $query->fetch();
    }
}
?>