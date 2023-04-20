<?php

class Cities
{
    private $citiesTable = "city";
    public $conn;
    public $id;
    public $name;
    public $country_code;
    public $district;
    public $population;

    public function __construct($db)
    {
        $this->conn=$db;
    }

    function read()
    {
        if ($this->id) {
            $stmt = $this->conn->prepare("SELECT * FROM " . $this->citiesTable . " WHERE ID = ?");
            $stmt->bind_param("i", $this->id);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM " . $this->citiesTable);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function create() {
        $query = "INSERT INTO " . $this->citiesTable . "
                  SET Name=:name, country_code=:country_code, District=:district, Population=:population";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country_code = htmlspecialchars(strip_tags($this->country_code));
        $this->district = htmlspecialchars(strip_tags($this->district));
        $this->population = htmlspecialchars(strip_tags($this->population));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":country_code", $this->country_code);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":population", $this->population);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
