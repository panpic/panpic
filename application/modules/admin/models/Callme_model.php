<?php 

/**
* Model Backend
* Last update 5 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 5 Jan 2017
*/

class Callme_model extends MY_Model {
	
	 
	private $_call_back_request = 'call_back_request';
	private $_tour = 'tour';
	private $_agency = 'agency';


	function table_call_back_request(){ return $this->_call_back_request;}
    function table_tour() { return $this->_tour;}
    function table_agency() { return $this->_agency;}

        public function items()
        {
			 $sql = "SELECT c.id,c.call_id, b.agency_name,b.phone as agency_number,c.date_add,c.phone,c.status
					FROM {$this->table_tour()} AS a
					JOIN {$this->table_agency()} AS b
						ON a.agency_id = b.agency_id
				    JOIN {$this->table_call_back_request()} AS c
						ON a.tour_id = c.tour_id AND c.avail = 1
		";
	     return $this->db->query($sql)->result_array(); 
        
	}	

	//pagination
        public function countItem($cond='')
        {
                $sql = "SELECT c.id 
                        FROM {$this->table_tour()} AS a
                        JOIN {$this->table_agency()} AS b
                                ON a.agency_id = b.agency_id
                        JOIN {$this->table_call_back_request()} AS c
                                ON a.tour_id = c.tour_id $cond";

                return $this->db->query($sql)->num_rows();

         }

        public function fetch_items($cond, $limit,$start=0)
        {

            $sql = "SELECT c.id,c.call_id, b.agency_name,b.phone as agency_number,c.date_add,c.phone ,c.status
                    FROM {$this->table_tour()} AS a
                    JOIN {$this->table_agency()} AS b
                            ON a.agency_id = b.agency_id
                    JOIN {$this->table_call_back_request()} AS c
                            ON a.tour_id = c.tour_id $cond
                    ORDER BY c.id DESC LIMIT $start,$limit";

            return $this->db->query( $sql )->result_array();		

        }

        public function getItemById($id)
        {
        	 $sql = "SELECT c.id, c.call_id, c.date_add, c.date_contacted, c.phone,c.message,c.status,
                                b.agency_name,b.phone as agency_number,b.hotline, b.slug a_slug, 
                                a.title, a.tour_sku, a.slug
					FROM {$this->table_tour()} AS a
					JOIN {$this->table_agency()} AS b
						ON a.agency_id = b.agency_id
				    JOIN {$this->table_call_back_request()} AS c
						ON a.tour_id = c.tour_id AND c.id = $id";

			 return $this->db->query($sql)->row_array();
		}

        function insertItem() {

        }


        public function updateItem($id,$params) 
        {
                $this->db->where('id', $id);
            return $this->db->update($this->table_call_back_request(), $params); 

        }

       public function deleteItem($where)
       {
        if(!$where) return;
        $this->db->delete($this->table_call_back_request(), $where);
        echo $this->db->last_query(); 
       }	
}