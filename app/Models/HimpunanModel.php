<?php

namespace App\Models;

use CodeIgniter\Model;

class HimpunanModel extends Model
{
	protected $table = 'himpunan';
	protected $primaryKey = 'id';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['id', 'tipe', 'nama', 'waktu', 'jumlah', 'total'];
	protected $useTimestamps = false;

	public function simpan($data){
			$this->db->table($this->table)->insert($data);
			$id = $this->db->insertId($this->table);
			return $id ?? false;
	}

}
