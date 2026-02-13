<?php
class Product
{
    private $conn;
    private $table_name = "productos";

    public $id;
    public $sku;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $created_at;
    public $updated_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (sku, name, description, price, stock) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssdi", $this->sku, $this->name, $this->description, $this->price, $this->stock);
        
        return $stmt->execute();
    }

    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET sku = ?, name = ?, description = ?, price = ?, stock = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssdi", $this->sku, $this->name, $this->description, $this->price, $this->stock, $this->id);
        
        return $stmt->execute();
    }
    
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        
        return $stmt->execute();
    }
}
?>