<?php
/**
* Model Backend General variable
* Last update 10 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 1o Jan 2017
*/

class General_model extends MY_Model
{
    
    private $_table = 'general';
    private $_general_desc = 'general_desc';
    private $fields = 'c.type, d.*';
    private $_lang = 'VN';
    
    public $cond;
    public $_type;
    public $offset;
    public $num;
    public $primary;
    
    
    function keyUpdate() { 
        return "id ='$this->primary'"; 
    }
    
    function keyArray() { 
        return array('id' => $this->primary); 
    }

    function updateByLangArray() {
        return array('id' => $this->primary, 'lang' => $this->_lang);
    }
    
    function updateByLang() {
            $where[] = "id ='$this->primary'";
            $where[] = "lang ='$this->_lang'";
            return $where;
    }

    function getKeyString() { return "c.id = '$this->primary'"; }
     
    
    function table_general(){ return $this->_table; }

    
    function table_general_desc(){ return $this->_general_desc; }
    
    
    
    /**
    * 
    * Get item by id
    * 
    * @param int $this->primary
    * @return array row
    */
   function getItemById(){

       if( $this->primary == '') return ;

       $sql = "SELECT $this->fields FROM ".$this->table_general()." AS c
           JOIN ".$this->table_general_desc()." AS d ON c.id = d.id AND d.lang = '$this->_lang' AND ".$this->getKeyString();

       return $this->db->query($sql)->row_array();
   }


   /**
    * 
    * Get item by condition
    * 
    * @param string $this->cond
    * @return array row
    */
   function getItemByCond(){

           if( $this->cond == '') return ;

           if($this->_type != '') {
               $cond = $this->cond." AND c.type = '$this->_type' ";
           }

           $sql = "SELECT $this->fields
                   FROM ".$this->table_general()." AS c
                   JOIN ".$this->table_general_desc()." AS d
                   ON c.id = d.id AND d.lang='$this->_lang' $cond";

           return $this->db->query($sql)->row_array();
   }


   /**
    * Total categories row
    *
    * @param string $cond
    * @return int
    */
   function counterItems(){ 

           $cond = $this->cond;

           if($this->_type != '') {
               $cond .= " AND c.type = '$this->_type' ";
           }

           $sql = "SELECT COUNT('c.id') AS total
                   FROM ".$this->table_general()." AS c
                   JOIN ".$this->table_general_desc()." AS d
                   ON c.id = d.id AND d.lang='$this->_lang' $cond";

           return $this->db->query($sql)->row()->total;
   }


   /**
    * Get items
    *
    * @param string $cond
    * @param int $num
    * @param int $offset
    * @return array mix
    */
   function getItems(){

           $limit = ($this->num > 0) ? " LIMIT $this->offset, $this->num" : '';

           $cond = $this->cond;

           if($this->_type != '') {
               $cond .= " AND c.type = '$this->_type' ";
           }

           $sql = "SELECT * FROM ".$this->table_general()." AS c
                   JOIN ".$this->table_general_desc()." AS d
                   ON c.id = d.id AND d.lang='$this->_lang' $cond ORDER BY c.date_add $limit";

           return $this->db->query($sql)->result('array');		
   }


   /**
    * Get combobox General Setting
    *
    * @param inherit $this->getItems();
    * 
    * @return array mix (general|items)
    */
   function parseCombobox(){

       $general_items = $this->getItems();
       $cbx = new Zend_Config_Ini(APPLICATION_PATH.'/configs/admin_joblist.ini', 'GENERAL');
       $general_array = $cbx->toArray();        
       $general_preset = $general_array['general'];

       $general_box = array();
       foreach ($general_items as $key=>$vl) {
           $type = $vl['type'];
           if(array_key_exists($type, $general_preset)) {         		
                   $general_box[$type][$vl['id']] = array('name'=>$general_preset[$type], 'record'=> $vl);        		
           }
       }

       return array('general'=>$general_preset, 'items'=>$general_box);
   }



   function getSomeFields(){

           $limit = ($this->num > 0) ? " LIMIT $this->offset, $this->num" : '';

           $cond = $this->cond;

           if($this->_type != '') {
                   $cond .= " AND c.type IN($this->_type) ";
           }
            
            if($this->_type == "'hotel'"){
                $sql = "SELECT c.type, d.id, d.name FROM ".$this->table_general()." AS c
                           JOIN ".$this->table_general_desc()." AS d ON c.id = d.id AND d.lang='$this->_lang' $cond ORDER BY c.id ASC $limit";
            } else {
                $sql = "SELECT c.type, d.id, d.name FROM ".$this->table_general()." AS c
                           JOIN ".$this->table_general_desc()." AS d ON c.id = d.id AND d.lang='$this->_lang' $cond ORDER BY c.date_add ASC $limit";
            }
            
           return $this->db->query($sql)->result('array');
   }


   function selectItems($type){

           $this->_type = $type;
           $general_items = $this->getSomeFields();

           $this->load->library('general_library');
           $general_preset = $this->general_library->general();

           $general_box = array();
           foreach ($general_items as $key=>$vl) {
                   $type = $vl['type'];
                   if(array_key_exists($type, $general_preset)) {
                           $general_box[$type][$vl['id']] = array('name'=>$general_preset[$type], 'record'=> $vl);
                   }
           }

           return array('general'=>$general_preset, 'items'=>$general_box);
   }


   function getSomeFieldsTime(){

           $limit = ($this->num > 0) ? " LIMIT $this->offset, $this->num" : '';

           $cond = $this->cond;

           if($this->_type != '') {
                   $cond .= " AND c.type IN($this->_type) ";
           }

           $sql = "SELECT c.type, d.id, d.name FROM ".$this->table_general()." AS c
                           JOIN ".$this->table_general_desc()." AS d ON c.id = d.id AND d.lang='$this->_lang' $cond ORDER BY d.id ASC $limit";

           return $this->db->query($sql)->result('array');
   }


   function selectItemsTime($type){

           $this->_type = $type;
           $general_items = $this->getSomeFieldsTime();

           $this->load->library('general_library');
           $general_preset = $this->general_library->general();
           
           $general_box = array();
           foreach ($general_items as $key=>$vl) {
                   $type = $vl['type'];
                   if(array_key_exists($type, $general_preset)) {
                           $general_box[$type][$vl['id']] = array('name'=>$general_preset[$type], 'record'=> $vl);
                   }
           }

           return array('general'=>$general_preset, 'items'=>$general_box);
   }


   /**
    * Insert item
    *
    * @param array $params	 
    * @return bool
    */
   function insertItem($params, $desc){

           $this->db->trans_begin();

               $this->db->insert($this->table_general(), $params);
               $last_id = $this->db->insert_id(); 

               $desc['id']     = $last_id;
               $desc['lang']   = $this->_lang;
               $this->db->insert($this->table_general_desc(), $desc);

           if($this->db->trans_status() === FALSE){
               $this->db->trans_rollback(); 
               return FALSE; 
           } else {
               $this->db->trans_commit(); 
               return $last_id; 
           }   

   }


   /**
    * Update item
    *
    * @param array $params
    * @param string $this->_model->primary
    * @return bool
    */
   function updateItem($params, $desc){

           $this->db->trans_begin();

               $this->db->update($this->table_general(), $params, $this->keyArray());
               $this->db->update($this->table_general_desc(), $desc, $this->updateByLangArray());


           if($this->db->trans_status() === FALSE){
               $this->db->trans_rollback(); 
               return FALSE; 
           } else {
               $this->db->trans_commit(); 
               return TRUE; 
           }
   }


   /**
    * Insert multi records
    *
    * @param array $params
    * @param array $multi
    */
   function insertMulti($params, $multi=''){
           $this->db->trans_begin();

               $this->db->insert($this->table_general(), $params);			
               $last_id = $this->db->lastInsertId($this->table());

               if(!empty($multi)) {

                       $total = sizeof($multi['parent']);

                       for ($i = 0; $i < $total; $i++){
                               $record = array(
                                       'name' 	=> $multi['name'][$i],
                                       'type' 	=> $params['type'],
                                       'date_add' => $params['last_update'],
                                       'last_update'=> $params['last_update']);					
                               $this->db->insert($this->table(), $record);
                       }					
               }

           if($this->db->trans_status() === FALSE){
               $this->db->trans_rollback(); 
               return FALSE; 
           } else {
               $this->db->trans_commit(); 
               return TRUE; 
           }
   }


   function updateMulti($params, $multi=''){		
           $this->db->trans_begin();

               $this->db->update($this->table(), $params, $this->keyArray());

               if(!empty($multi)) {

                    $total = sizeof($multi['name']);

                    for ($i = 0; $i < $total; $i++){

                        $record = array(
                            'name' 	=> $multi['name'][$i],
                            'type' 	=> $params['type'],
                            'last_update'=> $params['last_update']);

                        $new_id = $multi['id'][$i];

                        if(empty($new_id) && !empty($record['name']) ) { //add
                            $record['date_add'] = $params['last_update'];
                            $this->db->insert($this->table(), $record);
                        } else { //update
                            $this->db->update($this->table(), $record , array('id' => $new_id) );
                        }
                    }					
               }

           if($this->db->trans_status() === FALSE){
               $this->db->trans_rollback(); 
               return FALSE; 
           } else {
               $this->db->trans_commit(); 
               return TRUE; 
           }
   }


   /*
    * Remove out database
    * 
    * @param string $this->_model->primary
    * @return bool
    */
   function deleteItem(){
        $del = $this->db->delete($this->table(), $this->keyArray());

        if($del) return true;
        else return false;
   }


   /**
    * update somes fields
    *
    * @param string $fields
    * @return bool
    */
   function updatePos($fields){
           $result = $this->db->query("UPDATE {$this->table()} SET $fields WHERE ".$this->keyUpdate());
           if($result) return true;
           else return false;		
   }
        
        
        
    
}