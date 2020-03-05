<?php

class Model
{
    public $pdo;

    public function __construct()
    {

        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=anosodmitr', "anosodmitr", "Rester3506209");

        } catch (PDOException $e) {
            print "Database Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // метод выборки данных
	public function get_data()
	{

	}
}