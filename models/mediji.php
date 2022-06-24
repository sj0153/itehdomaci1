<?php
class Mediji
{
    public $id;
    public $naziv;
    public $zemlja;
    public $karakter_medija;
    public $god_osnivanja;

    public function __construct($id, $naziv, $zemlja, $karakter_medija, $god_osnivanja)
    {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->zemlja = $zemlja;
        $this->karakter_medija = $karakter_medija;
        $this->god_osnivanja = $god_osnivanja;
    }

    public static function getAll(mysqli $conn)
    {
        $q = "SELECT * FROM mediji";
        return $conn->query($q);
    }

    public static function getById($id, mysqli $conn)
    {
        $q = "SELECT * FROM mediji WHERE id=$id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function deleteById($id, mysqli $conn)
    {
        $q = "DELETE FROM mediji WHERE id=$id";
        return $conn->query($q);
    }

    public static function add($naziv, $zemlja, $karakter_medija, $god_osnivanja, mysqli $conn)
    {
        $q = "INSERT INTO mediji(naziv,zemlja,karakter_medija,god_osnivanja) values('$naziv','$zemlja', '$karakter_medija', '$god_osnivanja')";
        return $conn->query($q);
    }

    public static function update($id, $naziv, $zemlja, $karakter_medija, $god_osnivanja, mysqli $conn)
    {
        $q = "UPDATE mediji set naziv='$naziv', zemlja='$zemlja', karakter_medija='$karakter_medija', god_osnivanja='$god_osnivanja' where id=$id";
        return $conn->query($q);
    }
}