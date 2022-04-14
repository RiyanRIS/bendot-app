<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
	protected $table = 'anggota';
	protected $primaryKey = 'id';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['id', 'nama', 'role', 'id_tele', 'username', 'password'];
	protected $useTimestamps = false;

	public function simpan($data){
			$this->db->table($this->table)->insert($data);
			$id = $this->db->insertId($this->table);
			return $id ?? false;
	}

	public function findByChatid(string $chat_id):array
	{
		return $this->db->table($this->table)
												->where('id_tele', $chat_id)
												->get()
												->getResultArray();
	}

	public function findByUsername(string $username):array
	{
		return $this->db->table($this->table)
												->where('username', $username)
												->get()
												->getResultArray();
	}

	public function validLogin(string $username, string $password):bool
	{
		$result = $this->db->table($this->table)
												->select()
												->where('username', $username)
												->get()
												->getResultArray();
		if((count($result) >= 1) && password_verify($password, $result[0]['password'])){
			return true;
		}
		return false;
	}

	public function validUsername(string $username, int $id = null):bool
	{
		if($id == null){
			$result = $this->db->table($this->table)
												->where('username', $username)
												->get()
												->getResultArray();
		} else {
			$result = $this->db->table($this->table)
												->where('username', $username)
												->where('id != ', $id)
												->get()
												->getResultArray();
		}
		
		if(count($result) >= 1){
			return false;
		}
		return true;
	}

}
