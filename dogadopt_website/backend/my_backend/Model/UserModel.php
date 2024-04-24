<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getAllUsers($limit)
    {
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }
    
    public function getUserById($id)
    {
        return $this->select("SELECT * FROM users WHERE user_id = $id");
    }
    
    public function getAllDogs()
    {
        return $this->select("SELECT * FROM dogs ORDER BY dog_id");
    }
    
    public function getDogById($id)
    {
        return $this->select("SELECT * FROM dogs WHERE dog_id = $id");
    }
    
    public function getDogsBySex($sex)
    {
        return $this->select("SELECT * FROM dogs WHERE sex = $sex");
    }
    
    public function getDogsByBreed($breed)
    {
        return $this->select("SELECT * FROM dogs WHERE breed = '" . $breed . "'");
    }
    
    public function getAllDogBreeds()
    {
        return $this->select("SELECT breed FROM dogs ORDER BY breed ASC");
    }
    
    public function getDogsByColour($colour)
    {
        return $this->select("SELECT * FROM dogs WHERE colour = '" . $colour . "'");
    }
    
    public function getAllDogColours()
    {
        return $this->select("SELECT colour FROM dogs ORDER BY colour ASC");
    }
    
    public function getDogsByBreedAndSex($breed, $sex)
    {
        return $this->select("SELECT * FROM dogs WHERE breed = $breed AND sex = $sex");
    }
}
