<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

# main model shared between all controllers
class MainModel extends Database
{
    
    public function getUserByEmail($email)
    {
        return $this->select("SELECT * FROM users WHERE email = '" . $email . "'");
    }
    
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
    
    public function insertApplication($userId, $dogId) {
        return $this->insert("INSERT INTO `applications` (`user_id`, `dog_id`) VALUES ($userId, $dogId)");
    }
    
    // get applications and related dog details where user_id
    public function getAllApplications($user_id)
    {
        return $this->select("SELECT applications.application_id, dogs.name, dogs.breed, dogs.colour, dogs.sex FROM dogs INNER JOIN applications ON dogs.dog_id = applications.dog_id WHERE user_id = " . $user_id . " ORDER BY applications.application_id ASC");
    }
    
    public function updateDog($dogId, $breed, $colour) 
    {
        return $this->insert("UPDATE `dogs` SET `breed`='" . $breed . "', `colour`='" . $colour .  "' WHERE dog_id='" . $dogId . "'");
        
    }
    
    public function deleteDog($dogId)
    {
        return $this->delete("DELETE from dogs WHERE dog_id = " . $dogId);
    }
}
