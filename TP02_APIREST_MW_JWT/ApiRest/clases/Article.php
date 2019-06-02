<?php

class Article
{
    public $articleId;
    public $section;
    public $description;
    public $price;
    public $stock;

    public static function readAll()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT 
			ArticleID, 
			Section, 
			Description,
            Price,
            Stock,
			FROM Articles
		");

		$consulta->execute();

		return $consulta->fetchAll(PDO::FETCH_CLASS, "Article");
	}

	public function create()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("

			INSERT INTO Articles 
			values (
				'$this->articleId',
				'$this->section',
				'$this->description',
                '$this->price',
                '$this->stock'
			);
		");

		$consulta->execute();

		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	public static function read($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT 
			ArticleID, 
			Section, 
			Description,
            Price,
            Stock
			FROM Articles
			WHERE ArticleID=$id;
		");

		$consulta->execute();

		$persona = $consulta->fetchObject('Article');

		return $persona;				
	}
	public function update()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			
			UPDATE Articles SET
			ArticleID='$this->articleId, 
			Section='$this->section, 
			Description='$this->description,
            Price='$this->price,
            Stock='$this->stock;
			WHERE OrderID='$this->orderId';
		");

		return $consulta->execute();
	}
	public function delete()
	{

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			DELETE 
			FROM Articles				
			WHERE ArticleID='$this->articleId';
		");

		$consulta->execute();

		return $consulta->rowCount();
	}
}

?>