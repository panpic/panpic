<?php

/**
 * Model Backend
 * Last update 11 Jan 2017
 * 
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 11 Jan 2017
 */
class Posting_request_model extends MY_Model {

    private $_posting_request = 'posting_request';
    private $_package_agency = 'package_agency';
    private $_agency = 'agency';
    private $_package = 'package';
    private $_tour = 'tour';
    private $_tour_category_desc = 'tour_category_desc';
    public $post_status = array(1 => 'New', 2 => 'Pending', 3 => 'Done');

    function table_posting_request() {
        return $this->_posting_request;
    }

    function table_package_agency() {
        return $this->_package_agency;
    }

    function table_agency() {
        return $this->_agency;
    }

    function table_package() {
        return $this->_package;
    }

    function table_tour() {
        return $this->_tour;
    }

    function table_tour_category_desc() {
        return $this->_tour_category_desc;
    }

    public function items() {
        $sql = "SELECT a.id,b.agency_name,d.package_name,a.contact_phone ,a.date_request,a.avail
				FROM {$this->table_posting_request()} AS a
				JOIN {$this->table_agency()} AS b
					ON a.agency_id = b.agency_id AND a.avail = 1
			    JOIN {$this->table_package_agency()} AS c
					ON b.agency_id = c.agency_id 
				JOIN {$this->table_package()} AS d
					ON c.package_id = d.package_id
		";
        return $this->db->query($sql)->result_array();
    }

    public function countItem($cond = '') {
        $sql = "SELECT COUNT(a.id) AS total
                            FROM {$this->table_posting_request()} AS a
                            JOIN {$this->table_agency()} AS b
                                    ON a.agency_id = b.agency_id $cond
                        JOIN {$this->table_package_agency()} AS c
                                    ON b.agency_id = c.agency_id 
                            JOIN {$this->table_package()} AS d
                                    ON c.package_id = d.package_id";
        return $this->db->query($sql)->row()->total;
    }

    public function fetch_items($cond, $limit, $start = 0) {

        $sql = "SELECT a.id,a.contact_phone ,a.date_request,a.status,a.avail, 
                                b.agency_name, b.agency_id, b.slug a_slug, 
                                d.package_name, d.package_type
                          FROM " . $this->table_posting_request() . " AS a
                          JOIN " . $this->table_agency() . " AS b
                                  ON a.agency_id = b.agency_id   $cond 
                           JOIN (
                                  SELECT p.package_id, p.package_name, p.package_type, pa.agency_id 
                                  FROM " . $this->table_package() . " p
                                  JOIN " . $this->table_package_agency() . " pa 
                                          ON p.package_id = pa.package_id
                           ) AS d ON d.agency_id = a.agency_id 
                           ORDER BY a.id DESC LIMIT $start, $limit ";
        return $this->db->query($sql)->result_array();
    }

    public function updateItem($id, $params) {
        $this->db->where('id', $id);
        return $this->db->update($this->table_posting_request(), $params);
    }

    public function getItemById($id) {
        $sql = "SELECT a.*,b.agency_name, b.slug
			        FROM {$this->table_posting_request()} AS a
		            JOIN {$this->table_agency()} AS b
				       ON a.agency_id = b.agency_id AND a.id=$id
			";
        return $this->db->query($sql)->row_array();
    }

    public function deleteItem($where) {
        if (!$where)
            return;
        $this->db->where($where);
        return $this->db->delete($this->table_posting_request());
    }

}
