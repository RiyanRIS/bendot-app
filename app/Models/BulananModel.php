<?php

namespace App\Models;

use CodeIgniter\Model;

class BulananModel extends Model
{
	protected $table = 'bulanan';
	protected $primaryKey = 'id';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['id', 'id_anggota', 'month', 'year', 'waktu'];
	protected $useTimestamps = false;

	public function simpan($data){
			$this->db->table($this->table)->insert($data);
			$id = $this->db->insertId($this->table);
			return $id ?? false;
	}

	public function findYearMonth($year, $month)
	{
		return $this->db->table($this->table)
										->select()
										->where('year', $year)
										->where('month', $month)
										->get()
										->getResultArray();
	}

}
