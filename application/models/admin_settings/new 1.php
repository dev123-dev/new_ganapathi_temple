function get_all_field_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select()->from($this->table_Seva);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->order_by('SEVA_NAME', 'asc'); 
			$this->db->join('DEITY_SEVA_PRICE', 'DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID');
			$this->db->join('DEITY', 'DEITY_SEVA.DEITY_ID = DEITY.DEITY_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}