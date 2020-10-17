<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Dbfunction extends CI_Model {
	function __construct() {
		parent::__construct ();
                $this->load->database();
	}
	public function insertAll($table, $data) {
		// $this->db->last_query();;
		$this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();
			if ($insert_id > 0) {
				return $insert_id;
			} else {
				return false;
			}
	}
	public function getAllResult($table) {
		$allData = $this->db->get($table)->result();
		return $allData;
	}
	
	public function getAllResultArray($table, $where) {
		$allData = $this->db->get_where($table, $where)->result();
		return $allData;
	}
	
	public function getRowResultArray($table, $where) {
		$allData = $this->db->get_where($table, $where)->row();
		// echo $this->db->last_query();
                return $allData;
                
	}
	
	public function getAllResultWhereOrderBy($table, $where, $colum) { 
	
		if(empty($where)){
			$allData = $this->db->order_by($colum, "desc")->get($table)->result();
			return $allData;
		}else{
			$allData = $this->db->order_by($colum, "desc")->get_where($table, $where)->result();
			return $allData;
		}
	}

	public function getAllResultTwoDate($table, $toDate, $fromDate, $colum)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('sales_date <=', $fromDate);
		$this->db->where('sales_date >=', $toDate);
		$this->db->order_by($colum, "desc");

		 return $result = $this->db->get()->result();
		 $this->db->last_query();
	}
	
	public function getAllResultTwoDateWithWhere($table, $toDate, $fromDate, $colum, $where)
	{
		$this->db->where('sales_date <=', $fromDate);
		$this->db->where('sales_date >=', $toDate);
		$this->db->order_by($colum, "desc");

		 return $result = $this->db->get_where($table, $where)->result();
		 $this->db->last_query();
	}

	public function showCustomerPaymentsReport($table, $toDate, $fromDate, $colum, $where)
	{
		$this->db->where('created_at BETWEEN "'. date("Y-m-d 00:00:00", strtotime($toDate)). '" and "'. date("Y-m-d 23:59:00", strtotime($fromDate)).'"');
		$this->db->order_by($colum, "desc");

		 return $result = $this->db->get_where($table, $where)->result();
		  $this->db->last_query();
	}
	
	public function getAllResultWhereColumGroupBy($table, $where, $colum) {
		
		if(!empty($where)){
			$allData = $this->db->group_by($colum)->get_where($table, $where)->result();
			return $allData;
		}else{
			$allData = $this->db->group_by($colum)->get($table)->result();
			return $allData;
			
		}
	}
	
	public function getAllResultJoin($tableA, $tableAid, $tableB, $tableBid){
		$this->db->select('*');
		$this->db->from($tableA);
		$this->db->join($tableB, $tableAid = $tableBid);
		$allData = $this->db->get()->result();
		return $allData;
		
	}

	public function getAllResultRightJoin($tableA, $tableAid, $tableB, $tableBid){
		$this->db->select('*');
		$this->db->from($tableA);
		$this->db->join($tableB, $tableAid = $tableBid , 'outer');
		$allData = $this->db->get()->result();
		return $allData;
		
	}
	
	public function getAllResultJoinWithWhere($tableA, $tableAid, $tableB, $tableBid, $data){
		$this->db->select('*');
		$this->db->from($tableA);
		$this->db->join($tableB, $tableAid = $tableBid);
		$this->db->where($data);
		$allData = $this->db->get()->result();
		return $allData;
		
	}
	
	public function updateAllResultWhere($table, $where, $data) {
		$this->db->where($where)->update($table, $data);
		$afftectedRows = $this->db->affected_rows();
		return $afftectedRows;
	}
	
	public function getMaxNumber($table, $data){
		$allData = $this->db->select_max($data)->get($table)->row();
		return $allData;
		 
	}
	
	public function totalCount($table, $where){
		$allData = $this->db->where($where)->count_all_results($table);
		return $allData;  
	}
	
	public function totalSum($sum, $table, $where){
		
		$allData = $this->db->select_sum($sum)->get_where($table, $where)->row();
		return $allData;
	}

	public function deleteArray($table,$data){
		$allData = $this->db->where($data)->delete($table);
		return $allData;
		
	}

  public function create_slug($name)
{
    $count = 0;
    $name = url_title($name);
    $slug_name = $name;             // Create temp name
    while(true) 
    {
        $this->db->where('slug', $slug_name);   // Test temp name
        $query = $this->db->get('pages');
        if ($query->num_rows() == 0) break;
        $slug_name = $name . '-' . (++$count);  // Recreate new temp name
    }
    return $slug_name;// Return temp name
}

}
?>
