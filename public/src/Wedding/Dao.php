<?php

namespace Wedding;

use Exception;
use PDO;

class Dao
{
	/**
	 * @var PDO
	 */
	private $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	public function getWishes()
	{
		return $this->fetchAll("SELECT id, description FROM wedding_list WHERE email IS NULL ORDER BY description");
	}

	public function reserveWish($id, $email, $code)
	{
		$sql = 'UPDATE wedding_list SET email=:email, verification_code=:code WHERE id=:id AND email IS NULL';
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam('email', $email, PDO::PARAM_STR);
		$stmt->bindParam('code', $code, PDO::PARAM_STR);
		$stmt->bindParam('id', $id, PDO::PARAM_INT);
		if (!$stmt->execute()) {
			throw new Exception(var_export($stmt->errorInfo(),true));
		}
		if ($stmt->rowCount()!=1) {
			throw new Exception('No record were updated.');
		}
		return $this->getItem($id);
	}

	public function cancelWish($id, $email, $code)
	{
		$sql = 'UPDATE wedding_list SET email=null, verification_code=null WHERE id=:id AND email=:email AND verification_code=:code';
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam('email', $email, PDO::PARAM_STR);
		$stmt->bindParam('code', $code, PDO::PARAM_STR);
		$stmt->bindParam('id', $id, PDO::PARAM_INT);
		if (!$stmt->execute()) {
			throw new Exception(var_export($stmt->errorInfo(),true));
		}
		if ($stmt->rowCount()!=1) {
			throw new Exception('No record were updated.');
		}
	}

	private function getItem($id)
	{
		$stmt = $this->db->prepare('SELECT * FROM wedding_list WHERE id=?');
		$stmt->execute([$id]);
		return $stmt->fetchObject();
	}

	private function fetchAll($query)
	{
		$stmt = $this->db->query($query);
		if (!$stmt) {
			throw new Exception("Failed to run query.");
		}
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

}
