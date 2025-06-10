<?php
/**
* Model Backend Post category
* Last update 10 Nov 2018
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 10 Nov 2018
*/

class Postcat_model extends MY_Model
{

	private $_table = 'pp_post_category';
	private $_tableDesc = 'pp_post_category_desc';
    
    private $_fields = ' d.lang, d.cat_name, d.cat_slug, d.cat_icon, d.cat_note, d.seo_title, d.seo_description ';

	public $_lang = 'vi'; // current language of item
    public $_parent = 0;	
    public $_data;
    public $_id = 'post_cat_id';
    public $_orderArr;
    public $post_cat_id;
	public $page_lang;
	public $default_lang;

    
    function getKeyString() { return " post_cat_id = '$this->post_cat_id' AND lang = '$this->_lang' "; }
    
    
    function keyUpdateMain($post_cat_id) {
        return array("post_cat_id" => $post_cat_id);
    }


    function keyUpdate($post_cat_id) {
        return  array('post_cat_id' => $post_cat_id, 'lang' => $this->_lang);
    }

	
    function updateItem($params, $d, $post_cat_id){
        
        $this->db->trans_begin(); 
        
        if($params != '') {
            $this->db->update( $this->_table, $params, $this->keyUpdateMain($post_cat_id) );
        }

        if($d != '') {
            $this->db->update( $this->_tableDesc, $d, $this->keyUpdate($post_cat_id) );
        }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return TRUE;
        }
    }
    
    
    /**
    * Update info of node
    *
    * @param  array Data array store node info.
    * @param  int ID of node which you modify.
    * @param  int ID of parent node if you change parent node when you update current node
    *
    * @return A node modified and node info save to database.
    */	
    function updateNode($data, $id = null, $newParentId = 0){

        $update = false;

        if($id != null && $id != 0){

            $nodeInfo = $this->getNodeInfo($id);						

            //Update categories Description
            $d['cat_name'] = $data['cat_name'];
			$d['cat_slug'] = $data['cat_slug'];
            $d['cat_note'] = $data['cat_note'];
			$d['seo_title'] = $data['seo_title'];
			$d['seo_description'] = $data['seo_description'];
			if($data['cat_icon'] != '') {
			    $d['cat_icon'] = $data['cat_icon'];
            }

            $params['posts_no'] = $data['posts_no'];
            $params['home_status'] = $data['home_status'];

            $update = $this->updateItem($params, $d, $id);
        }

        if($newParentId != null && $newParentId > 0){
            if($nodeInfo['parents'] != $newParentId){ $this->moveNode($id, $newParentId); }
        }

        if($update)	{
            return true;
        } else {
            return false;		
        }
        
    }
    
    
    
    /**
	* Move node to new parent (move: left - right - before - after)
	*
	* @param  int ID of node which you want move to new parent.
	* @param  int ID of parent node which you want apply new node
	* @param  array Case when you apply new node (apply: left position - right position - before position - after position)
	*
	* @return Change tree structure.
	*/	
	function moveNode($id, $parent = 0, $options = null){
            $this->_id = $id;
            $this->_parent = $parent;

            if($options['position'] == 'right' || $options == null)	$this->moveRight();

            if($options['position'] == 'left')	$this->moveLeft();

            if($options['position'] == 'after')	$this->movetAfter($options['brother_id']);

            if($options['position'] == 'before') $this->moveBefore($options['brother_id']);
	}
	
	
	/**
	* Move node to left postion a unit on a level
	*
	* @param  int ID of node which you want move to new position.
	* 
	* @return Change tree structure.
	*/
	function moveUp($id){
		$nodeInfo = $this->getNodeInfo($id);		
		$parentInfo = $this->getNodeInfo($nodeInfo['parents']);
		
		$sql = 'SELECT * FROM '.$this->_table.' WHERE lft < '.$nodeInfo['lft'].' AND parents = '.$nodeInfo['parents'].' ORDER BY lft DESC LIMIT 1';
		
		$nodeBrother = $this->db->query($sql)->row_array();
                
		if(!empty($nodeBrother)){			
			$options = array('position'=>'before','brother_id'=>$nodeBrother['post_cat_id']);
			$this->moveNode($id, $parentInfo['post_cat_id'], $options);
		}
		
	}
	
	
	/**
	* Move node to right postion a unit on a level
	*
	* @param  int ID of node which you want move to new position.
	* 
	* @return Change tree structure.
	*/
	public function moveDown($id){
            $nodeInfo = $this->getNodeInfo($id);		
            $parentInfo = $this->getNodeInfo($nodeInfo['parents']);

            $sql = 'SELECT * FROM '.$this->_table.' WHERE lft > '.$nodeInfo['lft'].' AND parents = '.$nodeInfo['parents'].' ORDER BY lft ASC LIMIT 1';
            $nodeBrother = $this->db->query($sql)->row_array();

            if(!empty($nodeBrother)){			
                $options = array('position'=>'after','brother_id'=>$nodeBrother['post_cat_id']);
                $this->moveNode($id,$parentInfo['post_cat_id'],$options);
            }
	}
	
	
	/**
	* Get info of parent node
	*
	* @param  int ID of node which you want get info
	* 
	* @return Node info.
	*/
	function getParentNode($id){
		$infoNode = $this->getNodeInfo($id);
		$parentId = $infoNode['parents'];		
		return $this->getNodeInfo($parentId);
	}
	
	
	/**
	* Update ordering of all node in tree
	*
	* @param  array An array store info tree
	* @param  array An array store info of ordering
	* 
	* @return Change tree structure.
	*/
	function orderTree($data, $orderArr){
				
		$orderGroup = $this->orderGroup($data);				
		$newOrderGroup = array();
		foreach ($orderGroup as $key => $val){
			$tmpVal = array();
			foreach ($val as $key2 => $val2){
				$tmpVal[$key2] = $orderArr[$key2];
			}
			natsort($tmpVal);		
			$orderGroup[$key] = $tmpVal;
		}
		
		foreach ($orderGroup as $key => $val){
			$tmpVal = array();
			foreach ($val as $key2 => $val2){
				$info = $this->getNodeByLeft($key2);
				$tmpVal[$info['post_cat_id']] = $val2;
			}
			$orderGroup[$key] = $tmpVal;
		}
	
		foreach ($orderGroup as $key => $val){
			foreach ($val as $key2 => $val2){
				$nodeID = $key2;
				$parent = $key;				
				$this->moveNode($nodeID, $parent);
			}
		}
	}
	
	
	/**
	* Get info of node
	* 2012-10-25
	* 
	* @param  int Left value of node
	* 
	* @return array Node info.
	*/
	protected function getNodeByLeft($left){
		
		$sql = 'SELECT c.*, d.cat_name, d.seo_title, d.seo_keyword, d.seo_description FROM '.$this->_table.' AS c JOINE '.$this->_tableDesc.' AS d ON c.post_cat_id=d.post_cat_id AND c.lft = '.$left;
		
		return $this->db->query($sql)->row_array();
	}
	
	
	/**
	* Create node groups
	*
	* @param  array An array store info tree
	* 
	* @return array of node groups
	*/		
	function orderGroup($data = null){
		$orderArr2 = array();
		
		if($data != null){
			$orderArr = array();
		 	if(count($data)>0){
		 		foreach ($data as $key => $val){
		 			$orderArr[$val['post_cat_id']] = array();
		 			if(isset($orderArr[$val['parents']])){
		 				$orderArr[$val['parents']][] = $val['lft'];
		 			}
		 		}
		 		
		 		foreach ($orderArr as $key => $val){
		 			$tmp = array();
		 			$tmp = $orderArr[$key];
		 			if(count($tmp) >0){ $orderArr2[$key] = array_flip($val); }
		 		}
		 		
		 	}
		}
		
		$this->_orderArr = $orderArr2;
		return $this->_orderArr;
	}

	
	/**
	* Create ordering of node by left value
	*
	* @param int ID of parent of current node
	* @param int Letf value of current node
	* 
	* @return int An value of ordering 
	*/
	public function getNodeOrdering($parent, $left){
		$ordering = null;
		if(isset($this->_orderArr[$parent][$left]))
			$ordering = $this->_orderArr[$parent][$left] + 1;
			
		return $ordering;
	}
	
	/**
	* Processing move node to before position of other node
	*
	* @param int ID of node which you want move current node to before postion
	* 
	* @return Change tree structure
	*/
	protected function moveBefore($brother_id){
		
		$infoMoveNode = $this->getNodeInfo($this->_id);
		
		$lftMoveNode = $infoMoveNode['lft'];
		$rgtMoveNode = $infoMoveNode['rgt'];
		$widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);		
		
		$sqlReset = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$rgtMoveNode.'), lft = (lft - '.$lftMoveNode.')   
					 WHERE lft BETWEEN '.$lftMoveNode.' AND '.$rgtMoveNode;
		$this->db->query($sqlReset);
						
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$widthMoveNode.') WHERE rgt > '.$rgtMoveNode;
		$this->db->query($slqUpdateRight);
				
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft - '.$widthMoveNode.') WHERE lft > '.$rgtMoveNode;		
		$this->db->query($slqUpdateLeft);
								
		$infoBrotherNode = $this->getNodeInfo($brother_id);
		$lftBrotherNode = $infoBrotherNode['lft'];
				
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft + '.$widthMoveNode.') WHERE lft >= '.$lftBrotherNode.' AND rgt >0';
		$this->db->query($slqUpdateLeft);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$widthMoveNode.') WHERE rgt >= '.$lftBrotherNode;
		$this->db->query($slqUpdateRight);
						
		$infoParentNode 	= $this->getNodeInfo($this->_parent);
		$levelMoveNode 		= $infoMoveNode['level'];
		$levelParentNode	= $infoParentNode['level'];
		$newLevelMoveNode  	= $levelParentNode + 1;
		
		$slqUpdateLevel = 'UPDATE '.$this->_table.' SET level = (level  - '.$levelMoveNode.' + '.$newLevelMoveNode.') WHERE rgt <= 0';
		$this->db->query($slqUpdateLevel);
				
		$newParent 	= $infoParentNode['post_cat_id'];
		$newLeft 	= $infoBrotherNode['lft'];
		$newRight 	= $infoBrotherNode['lft'] + $widthMoveNode - 1;
		$slqUpdateParent = 'UPDATE ' .$this->_table.'  
						  SET parents = '.$newParent.', lft = '.$newLeft.', rgt = '.$newRight.' WHERE post_cat_id = '.$this->_id;
		$this->db->query($slqUpdateParent);
				
		$slqUpdateNode = 'UPDATE '.$this->_table.' SET rgt = (rgt +  '.$newRight.'), lft = (lft +  '.$newLeft.') WHERE rgt <0';
		$this->db->query($slqUpdateNode);		
	}
	
	
	/**
	* Processing move node to after position of other node
	* 	
	*
	* @param int ID of node which you want move current node to after postion
	* 
	* @return Change tree structure
	*/
	protected function movetAfter($brother_id){

		$infoMoveNode = $this->getNodeInfo($this->_id);
		
		$lftMoveNode = $infoMoveNode['lft'];
		$rgtMoveNode = $infoMoveNode['rgt'];
		$widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);
		
		
		$sqlReset = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$rgtMoveNode.'), lft = (lft - '.$lftMoveNode.')   
					 WHERE lft BETWEEN '.$lftMoveNode.' AND '.$rgtMoveNode;
		$this->db->query($sqlReset);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$widthMoveNode.') WHERE rgt > '.$rgtMoveNode;		
		$this->db->query($slqUpdateRight);
				
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft - '.$widthMoveNode.') WHERE lft > '.$rgtMoveNode;		
		$this->db->query($slqUpdateLeft);
				
		
		$infoBrotherNode = $this->getNodeInfo($brother_id);
		$rgtBrotherNode = $infoBrotherNode['rgt'];		
		
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft + '.$widthMoveNode.') WHERE lft > '.$rgtBrotherNode.' AND rgt >0';		
		$this->db->query($slqUpdateLeft);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$widthMoveNode.') WHERE rgt > '.$rgtBrotherNode;		
		$this->db->query($slqUpdateRight);
		
		$infoParentNode = $this->getNodeInfo($this->_parent);
		$levelMoveNode 		= $infoMoveNode['level'];
		$levelParentNode	= $infoParentNode['level'];
		$newLevelMoveNode  = $levelParentNode + 1;
		
		$slqUpdateLevel = 'UPDATE '.$this->_table.' SET level = (level - '.$levelMoveNode.' + '.$newLevelMoveNode.') WHERE rgt <= 0';
		$this->db->query($slqUpdateLevel);
				
		$newParent 	= $infoParentNode['post_cat_id'];
		$newLeft 	= $infoBrotherNode['rgt'] + 1;
		$newRight 	= $infoBrotherNode['rgt'] + $widthMoveNode;
		$slqUpdateParent = 'UPDATE '.$this->_table.'  SET parents = '.$newParent.', lft = '.$newLeft.', rgt = '.$newRight.' WHERE post_cat_id = '.$this->_id;	
		$this->db->query($slqUpdateParent);
				
		$slqUpdateNode = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$newRight.'), lft = (lft + '.$newLeft.') WHERE rgt <0';		
		$this->db->query($slqUpdateNode);
	}
	
	
	/**
	* Processing move node to left position of other node
	* 	
	*
	* @return Change tree structure
	* 
	*/
	protected function moveLeft(){
		
		$infoMoveNode = $this->getNodeInfo($this->_id);
		
		$lftMoveNode = $infoMoveNode['lft'];
		$rgtMoveNode = $infoMoveNode['rgt'];
		$widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);
		
		$sqlReset = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$rgtMoveNode.'), lft = (lft - '.$lftMoveNode.') WHERE lft BETWEEN '.$lftMoveNode.' AND '.$rgtMoveNode;
		$this->db->query($sqlReset);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$widthMoveNode.') WHERE rgt > '.$rgtMoveNode;
		$this->db->query($slqUpdateRight);
				
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft - '.$widthMoveNode.') WHERE lft > '.$rgtMoveNode;
		$this->db->query($slqUpdateLeft);
				
		$infoParentNode = $this->getNodeInfo($this->_parent);
		$lftParentNode = $infoParentNode['lft'];
		
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft + '.$widthMoveNode.') WHERE lft > '.$lftParentNode.' AND rgt > 0';
		$this->db->query($slqUpdateLeft);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$widthMoveNode.') WHERE rgt > '.$lftParentNode;
		$this->db->query($slqUpdateRight);
				
		$levelMoveNode 		= $infoMoveNode['level'];
		$levelParentNode	= $infoParentNode['level'];
		$newLevelMoveNode  = $levelParentNode + 1;
		
		$slqUpdateLevel = 'UPDATE '.$this->_table.' SET level = (level - '.$levelMoveNode.' + '.$newLevelMoveNode.') WHERE rgt <= 0';
		$this->db->query($slqUpdateLevel);
						
		$newParent 	= $infoParentNode['post_cat_id'];
		$newLeft 	= $infoParentNode['lft'] + 1;
		$newRight 	= $infoParentNode['lft'] + $widthMoveNode;
		$slqUpdateParent = 'UPDATE '.$this->_table.' SET parents = '.$newParent.', lft = '.$newLeft.', rgt = '.$newRight.'  WHERE post_cat_id = '.$this->_id;
		$this->db->query($slqUpdateParent);
		
		$slqUpdateNode = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$newRight.'), lft = (lft + '.$newLeft.') WHERE rgt <0';
		$this->db->query($slqUpdateNode);		
	}
	
	
	/**
	* Processing move node to right position of other node
	* 	
	*
	* @return Change tree structure
	*/
	protected function moveRight(){
		
		$infoMoveNode = $this->getNodeInfo($this->_id);
		
		$lftMoveNode = $infoMoveNode['lft'];
		$rgtMoveNode = $infoMoveNode['rgt'];
		$widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);
		
		$sqlReset = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$rgtMoveNode.'), lft = (lft - '.$lftMoveNode.') WHERE lft BETWEEN '.$lftMoveNode.' AND '.$rgtMoveNode;
		$this->db->query($sqlReset);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt - '.$widthMoveNode.') WHERE rgt > '.$rgtMoveNode;	
		$this->db->query($slqUpdateRight);
				
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft - '.$widthMoveNode.') WHERE lft > '.$rgtMoveNode;
		$this->db->query($slqUpdateLeft);
				
		$infoParentNode = $this->getNodeInfo($this->_parent);
		$rgtParentNode = $infoParentNode['rgt'];
		
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = (lft + '.$widthMoveNode.') WHERE lft >= '.$rgtParentNode.' AND rgt > 0';		
		$this->db->query($slqUpdateLeft);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$widthMoveNode.') WHERE rgt >= '.$rgtParentNode;		
		$this->db->query($slqUpdateRight);
				
		$levelMoveNode 	= $infoMoveNode['level'];
		$levelParentNode= $infoParentNode['level'];
		$newLevelMoveNode = $levelParentNode + 1;
		
		$slqUpdateLevel = 'UPDATE '.$this->_table.' SET level = (level - '.$levelMoveNode.' + '.$newLevelMoveNode.') WHERE rgt <= 0';
		$this->db->query($slqUpdateLevel);
				
		$newParent 	= $infoParentNode['post_cat_id'];
		$newLeft 	= $infoParentNode['rgt'];
		$newRight 	= $infoParentNode['rgt'] + $widthMoveNode - 1;
		$slqUpdateParent = 'UPDATE '.$this->_table.' SET parents = '.$newParent.', lft = '.$newLeft.', rgt = '.$newRight.'  WHERE post_cat_id = '.$this->_id;
		$this->db->query($slqUpdateParent);
				
		$slqUpdateNode = 'UPDATE '.$this->_table.' SET rgt = (rgt + '.$newRight.'), lft = (lft + '.$newLeft.') WHERE rgt <0';			
		$status = $this->db->query($slqUpdateNode);				
	}

	
	/**
	* Insert a new node to tree (move: left - right - before - after)
	* 	
	*
	* @param  array An array store info of new node
	* @param  int ID of parent node which you want insert new node
	* @param  array Case when you apply new node (apply: left position - right position - before position - after position)
	*
	* @return Change tree structure.
	*/
	function insertNode($data, $parent = 0, $options = null) {
		$this->_data 	= $data;
		$this->_parent 	= $parent;

		if($options['position'] == 'right' || $options == null)	return $this->insertRight();
		
		if($options['position'] == 'left') return $this->insertLeft();
		
		if($options['position'] == 'after') return $this->insertAfter($options['brother_id']);
		
		if($options['position'] == 'before') return $this->insertBefore($options['brother_id']);		
	}
	
	
	/**
	* Insert a new node to right position of other node
	* 	
	*
	* @return Change tree structure
	*/
	protected function insertRight(){
				
		$parentInfo =  $this->getNodeInfo($this->_parent);
		$parentRight = $parentInfo['rgt'];
				
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = lft + 2 WHERE lft > '.$parentRight;
		$this->db->query($slqUpdateLeft);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = rgt + 2 WHERE rgt >= '.$parentRight;
		$this->db->query($slqUpdateRight);
		
		$this->db->trans_begin();
		
			$c['parents']	= $this->_parent;
			$c['lft'] 		= $parentRight;
			$c['rgt'] 		= $parentRight + 1;
			$c['level'] 	= $parentInfo['level'] + 1;

			$this->db->insert($this->_table, $c);
			$last_id = $this->db->insert_id();

			foreach ($this->page_lang as $k=>$vl) {

				$d['post_cat_id'] = $last_id;
				$d['lang'] = $k;
				$d['cat_name'] = $this->_data['cat_name'];
                $d['seo_title'] = $this->_data['seo_title'];
                $d['seo_description'] = $this->_data['seo_description'];

                if( $this->_data['cat_icon'] != '') {
                    $d['cat_icon'] = $this->_data['cat_icon'];
                }

				// If english not input
				if ($k != $this->default_lang) {
					$d['cat_slug'] = $this->_data['cat_slug']."-$k";
				} else {
					$d['cat_slug'] = $this->_data['cat_slug'];
				}

				$this->db->insert($this->_tableDesc, $d);
			}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return $last_id;
		}
        
	}
	
	
	/**
	* Insert a new node to left position of other node
	* 	
	*
	* @return Change tree structure
	*/
	protected function insertLeft(){
				
            $parentInfo =  $this->getNodeInfo($this->_parent);
            $parentLeft = $parentInfo['lft'];

            $slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = lft + 2 WHERE lft > '.$parentLeft;
            $this->db->query($slqUpdateLeft);

            $slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = rgt + 2 WHERE rgt > '.($parentLeft + 1);		
            $this->db->query($slqUpdateRight);

            $this->db->trans_begin();

                $c['post_cat_id']   = $this->_data['post_cat_id'];		
                $c['parents']       = $this->_parent;
                $c['lft']           = $parentLeft + 1;
                $c['rgt']           = $parentLeft + 2;
                $c['level']         = $parentInfo['level'] + 1;

                $d['post_cat_id']= $this->_data['post_cat_id'];
                $d['cat_name']   = $this->_data['cat_name'];
				$d['cat_slug']	= $this->_data['cat_slug'];
                $d['seo_title']	= $this->_data['seo_title'];
                $d['seo_description']= $this->_data['seo_description'];

                $this->db->insert($this->_table,$c);		
                $last_id = $this->db->insert_id();

                $d['post_cat_id'] = $last_id;
                $d['lang'] 	= $this->_lang;
                $this->db->insert($this->_tableDesc, $d);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback(); 
                return FALSE; 
            } else {
                $this->db->trans_commit(); 
                return $last_id; 
            }       
             
	}
	
	
	/**
	* Insert a new node to after position of other node
	* 	
	* 
	* @param int ID of node which you want insert new node to after postion
	*
	* @return Change tree structure
	*/
	protected function insertAfter($brother_id){
				
            $parentInfo = $this->getNodeInfo($this->_parent);		
            $brotherInfo = $this->getNodeInfo($brother_id);		

            $slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = lft + 2 WHERE lft > '.$brotherInfo['rgt'];
            $this->db->query($slqUpdateLeft);

            $slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = rgt + 2 WHERE rgt > '.$brotherInfo['rgt'];
            $this->db->query($slqUpdateRight);

            $this->db->trans_begin();

                $c['post_cat_id']   = $this->_data['post_cat_id'];		
                $c['parents']       = $this->_parent;
                $c['lft']           = $brotherInfo['rgt'] + 1;
                $c['rgt']           = $brotherInfo['rgt'] + 2;
                $c['level']         = $parentInfo['level'] + 1;

                $d['post_cat_id']	= $this->_data['post_cat_id'];
                $d['cat_name']	= $this->_data['cat_name'];
				$d['cat_slug']	= $this->_data['cat_slug'];

                /*
                $d['cat_icon']	= $this->_data['cat_icon'];
                $d['seo_title']	= $this->_data['seo_title'];
                $d['seo_description']= $this->_data['seo_description'];
                */

                $this->db->insert($this->_table,$c);		
                $last_id = $this->db->insert_id();

                $d['post_cat_id']	= $last_id;
                $d['lang'] 	= $this->_lang;
                $this->db->insert($this->_tableDesc, $d);


            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback(); 
                return FALSE; 
            } else {
                $this->db->trans_commit(); 
                return $last_id; 
            }
            	
	}
	
	/**
	* Insert a new node to before position of other node
	* 	
	* 
	* @param int ID of node which you want insert new node to before postion
	*
	* @return Change tree structure
	*/
	protected function insertBefore($brother_id){
		
		$parentInfo =  $this->getNodeInfo($this->_parent);		
		$brotherInfo =  $this->getNodeInfo($brother_id);		
		
		$slqUpdateLeft = 'UPDATE '.$this->_table.' SET lft = lft + 2 WHERE lft >= '.$brotherInfo['lft'];
		$this->db->query($slqUpdateLeft);
				
		$slqUpdateRight = 'UPDATE '.$this->_table.' SET rgt = rgt + 2 WHERE rgt >= '.($brotherInfo['lft'] + 1);
		$this->db->query($slqUpdateRight);

		$this->db->trans_begin();
		
			$c['post_cat_id'] = $this->_data['post_cat_id'];		
			$c['parents']	= $this->_parent;
			$c['lft'] 		= $brotherInfo['rgt'];
			$c['rgt'] 		= $brotherInfo['lft'] + 1;
			$c['level'] 	= $parentInfo['level'] + 1;
			
			$d['post_cat_id'] = $this->_data['post_cat_id'];
			$d['cat_name']	= $this->_data['cat_name'];
			$d['cat_slug']	= $this->_data['cat_slug'];
                        
			$this->db->insert($this->_table,$c);
			$last_id = $this->db->insert_id();

			$d['post_cat_id']= $last_id;
			$d['lang'] 	= $this->_lang;
			$this->db->insert($this->_tableDesc, $d);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return $last_id;
		}
	}
	
	/**
	* Create a string from a data array 
	* 	
	* 
	* @param array a data array 
	*
	* @return string
	*/
	protected function createUpdateQuery($data){
		if (count($data) > 0) {
			$result = '';			
			$i = 1;
			foreach ( $data as $key => $val ) {
				if ($i == 1) {
					$result .= " " . $key . " = '" . $val . "' ";
				} else {
					$result .= " ," . $key . " = '" . $val . "' ";
				}
				$i ++;
			}
		}
		
		return $result;
	}
	
	/**
	* Create a string from a data array 
	* 	
	* 
	* @param array a data array 
	*
	* @return string
	*/
	public function createInsertQuery($data){
		if (count($data) > 0) {
			$cols = '';
			$values = '';
			$i = 1;
			foreach ( $data as $key => $val ) {
				if ($i == 1) {
					$cols .= "`" . $key . "`";
					$values .= "'" . $val . "'";
				} else {
					$cols .= ",`" . $key . "`";
					$values .= ",'" . $val . "'";
				}
				$i ++;
			}
		}
		
		$result['cols'] = $cols;
		$result['values'] = $values;
		return $result;
	}
	
	
	public function setTable($table) { $this->_table = $table; }

	/**
	* Calculate total nodes
	* 	
	* 
	* @param int ID of parent node
	* 
	* @return int Total nodes
	*/
	function totalNode($parents = 0){
		$sql = 'SELECT lft,rgt FROM '.$this->_table.' WHERE parents = '.$parents;
                $result = $this->db->query($sql)->row_array();
		$total 	= ($result['rgt'] - $result['lft'] +1)/2;
		return $total;
	}

	/**
	* Width of a branch of tree
	* 	
	* 
	* @param int Left value of node
	* @param int Right value of node
	* 
	* @return int width of node
	*/
	public function widthNode($lft, $rgt){
		$width = $rgt - $lft + 1;
		return $width;
	}
	
	/**
	* Remove a node of tree
	* 	
	* 
	* @param int ID of node which you want remove
	* @param string. If it is 'branch', delete a branch of tree
	* 				 If it is 'node', delete a node of tree and update all nodes of branch
	* 
	* @return Change tree structure
	*/
	public function removeNode($id, $options = 'branch'){
		$this->_id = $id;
		
		if($options == 'branch') return $this->removeBranch();
		if($options == 'node') return $this->removeOne();
	}
	
	/**
	* Remove a branch of tree
	* 2012-10-25
	* 
	* @return Change tree structure
	*/
	protected function removeBranch(){
		
		$infoNodeRemove 	= $this->getNodeInfo($this->_id);		
		$rgtNodeRemove 		= $infoNodeRemove['rgt'];
		$lftNodeRemove 		= $infoNodeRemove['lft'];
		$widthNodeRemove 	= $this->widthNode($lftNodeRemove, $rgtNodeRemove);
		
		$sql = "SELECT post_cat_id FROM $this->_table WHERE lft BETWEEN $lftNodeRemove AND $rgtNodeRemove";
		$arr = $this->db->query($sql)->result('array');
		
		$this->db->trans_begin();		
			
		$slqDelete = "DELETE FROM $this->_table WHERE lft BETWEEN $lftNodeRemove AND $rgtNodeRemove";
		$slqUpdateLeft = "UPDATE $this->_table SET lft = (lft - $widthNodeRemove) WHERE lft > $rgtNodeRemove";
		$slqUpdateRight = "UPDATE $this->_table SET rgt = (rgt - $widthNodeRemove) WHERE rgt > $rgtNodeRemove";
		
		$this->db->query($slqDelete);

		if(sizeof($arr) > 0) {
			foreach ($arr as $vl) {
				$this->db->delete($this->_tableDesc, array('post_cat_id' => $vl['post_cat_id']) );
			}
		}

		$this->db->query($slqUpdateLeft);
		$this->db->query($slqUpdateRight);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	
	
	/**
	* Remove an one of tree
	* 	
	* 
	* @return Change tree structure
	*/
	protected function removeOne(){
		
		$nodeInfo = $this->getNodeInfo($this->_id);
		$sql = 'SELECT post_cat_id FROM '.$this->_table.' WHERE parents = '.$nodeInfo['post_cat_id'].' ORDER BY lft ASC';		
		
		$childIds = $this->db->query($sql)->result('array');			
		rsort($childIds);		
		
		if(count($childIds) >0){
			foreach ($childIds as $key => $val){
				$id = $val;
				$parent = $nodeInfo['parents'];
				$options = array('position'=>'after','brother_id'=>$nodeInfo['post_cat_id']);
				$this->moveNode($id, $parent, $options);
			}
			$this->removeNode($nodeInfo['post_cat_id']);
		}
	}
	
	/**
	* Get info node of tree
	* 2012-10-25
	* 
	* @param int ID of node which you want get info
	*  
	* @return Change tree structure
	*/
	function getNodeInfo($id){
		if(empty($id)) return;
		
		$sql = "SELECT c.*, $this->_fields FROM $this->_table AS c 
				JOIN $this->_tableDesc AS d ON c.post_cat_id = d.post_cat_id AND c.post_cat_id = $id AND d.lang ='$this->_lang'";
		
		return $this->db->query($sql)->row_array();
	}
	
		
	/**
	* Get tree
	* 	
	* 
	* @param int ID of parent node
	* @param string A case of get node list
	* @param int ID of node which you don't want get info
	* @param int level of tree
	* @param int $num
	* @param int $offset
	*  
	* @return array Node list
	*/
	function listItem($parents = 0, $items = 'all', $exclude_id = null, $level = 0, $num='', $offset=''){
		
		$limit		= '';
		$lftExclude = '';
		$rgtExclude = '';
		$dataArr = array();
		$sqlParents = "SELECT @parentLeft := lft,@parentRight := rgt FROM $this->_table WHERE parents = $parents";
		$result = $this->db->query($sqlParents)->result('array');
				
		$limit = ($num > 0) ? " LIMIT $offset,$num " : '';
				
		$sqlItems = "SELECT node.*, $this->_fields FROM $this->_table AS node 
				JOIN $this->_tableDesc AS d ON node.post_cat_id = d.post_cat_id AND d.lang ='$this->_lang' ";
		
		if($items == 'all'){
			$sqlItemsLR = ' AND node.lft >= @parentLeft AND node.rgt <= @parentRight ';
		} else{
			$sqlItemsLR = ' AND node.lft > @parentLeft AND node.rgt < @parentRight ';
		}
							
		if($exclude_id != null && $exclude_id >0){
			$sqlExclude = "SELECT lft, rgt FROM $this->_table WHERE post_cat_id = $exclude_id ";
			$rowExclude = $this->db->query($sqlExclude)->row_array();
			$lftExclude = $rowExclude['lft'];
			$rgtExclude = $rowExclude['rgt'];
		}
		
		$sqlItems .= $sqlItemsLR;
		
		if($level != 0){ $sqlItems .= ' AND node.level <= '.$level; }
		
		$sqlItems .= ' ORDER BY node.lft '.$limit;				
		$result = $this->db->query($sqlItems)->result('array');
		
		if($result){			
			foreach($result as $row){
				if($row['lft'] < $lftExclude || $row['lft'] > $rgtExclude){
					$orderValue	= $this->getNodeOrdering($row['parents'],$row['lft']);
					$row['orderValue'] = $orderValue;
					$dataArr[] = $row;
				}
			}
		}
		
		return $dataArr;		
	}
	
		
	
	/**
	 * counter items
	 *
	 * @param int level of tree
	 * 
	 * @return total
	*/
	function countItem($level = 0){
		
		$sql = "SELECT COUNT(post_cat_id) AS total FROM $this->_table ";
		if($level != 0){ $sql .= ' WHERE level <= '.$level; }
				
		return $this->db->query($sql)->row()->total;
	}
	
	
	function countItemByCond($cond, $level=0) {
		 
		$sql = "SELECT COUNT(c.post_cat_id) AS total FROM $this->_table AS c 
				JOIN $this->_tableDesc AS d ON c.post_cat_id=d.post_cat_id AND d.lang ='$this->_lang' $cond";
		
		if($level != 0){ $sql .= ' AND c.level <= '.$level; }
		
		return $this->db->query($sql)->row()->total;
	}
	
	/**
	 * All items
	 * 2012-10-25
	 * 
	 * @param int $level
	 * @return array mix
	 */
	function items($level = 0, $num =0, $offset =0) {
		$dataArr = array();
		$limit = '';
		if($num > 0) $limit = ' LIMIT '.$offset.','.$num;
		
		$sql = 'SELECT c.*, '.$this->_fields.' FROM '.$this->_table.' AS c 
				JOIN '.$this->_tableDesc.' AS d ON c.post_cat_id=d.post_cat_id AND d.lang ="'.$this->_lang.'" ';
		
		if($level != 0){ $sql .= ' AND c.level <= '.$level; }
		
		$sql .= ' ORDER BY c.lft ASC '.$limit;
		$result = $arr = $this->db->query($sql)->result('array'); 

		if($result){			
			foreach($result as $row){
				$orderValue	= $this->getNodeOrdering($row['parents'], $row['lft']);
				$row['orderValue'] = $orderValue;
				$dataArr[] = $row;
			}
		}
		
		return $dataArr;
	}
	
	
	function itemsByCond($cond = 0, $num =0, $offset =0, $level=0) {
		$dataArr = array();
		$limit = '';
		if($num > 0) $limit = ' LIMIT '.$offset.','.$num;
		
		$sql = "SELECT c.*, $this->_fields FROM $this->_table AS c 
				JOIN $this->_tableDesc AS d 
				ON c.post_cat_id=d.post_cat_id AND d.lang ='$this->_lang' $cond ORDER BY c.lft ASC $limit";

		$result = $arr = $this->db->query($sql)->result('array'); 
		
		if($result){
			
			foreach($result as $row){
				$orderValue	= $this->getNodeOrdering($row['parents'], $row['lft']);
				$row['orderValue'] = $orderValue;
				$dataArr[] = $row;
			}
		}
		
		return $dataArr;
	}
	
	
	/**
	 * Only node parent (not get node root)
	 * 2012-10-25
	 * 
	 * @param string $cond
	 * @param int $num
	 * @param int $offset
	 * @return array mix
	 */
	function parentNode($cond, $num =0, $offset =0, $order=' ORDER BY d.cat_name ASC ') {
		$limit = '';
		if($num > 0) $limit = ' LIMIT '.$offset.','.$num;
		
		$sql = 'SELECT c.*, '.$this->_fields.' FROM '.$this->_table.' AS c JOIN '.$this->_tableDesc.' AS d ON c.post_cat_id=d.post_cat_id ';
		
		if($cond != ''){ $sql .= ' AND '.$cond;}		
		
		$sql .= $order.$limit;
		return $this->db->query($sql)->result('array');
	}


	/**
	 * Get nodes by Parent Id
	 *
	 * @param int $parent_id
	 * @param string $cond
	 * @param string $order
	 *
	 * @return array mix
	 */
	function getNodeByParentId($parent_id, $cond='', $order=' ORDER BY c.lft ASC ') {
		if($parent_id == '') return;

		$sql = "SELECT c.*, $this->_fields  
				FROM $this->_table AS c 
				JOIN $this->_tableDesc AS d ON c.post_cat_id = d.post_cat_id  
				JOIN (SELECT p.* FROM $this->_table AS p WHERE p.post_cat_id = $parent_id) AS parent 
				ON c.lft >= parent.lft AND c.rgt <= parent.rgt AND d.lang = '$this->_lang' $cond $order";

		return $this->db->query($sql)->result('array');
	}
	
	
	/**
	 * function update from parentNode() above
	 * Nov 29 2013
	 */
	function parentNodeHome($cond, $num =0, $offset =0, $order =' ORDER BY d.cat_name ASC ') {
		$limit = ($num > 0) ? " LIMIT $offset,$num" : '';
		
		$sql = 'SELECT '.$this->my_fields.' FROM '.$this->_table.' AS c 
			JOIN '.$this->_tableDesc.' AS d ON c.post_cat_id = d.post_cat_id '.$cond.$order.$limit;
		
		return $this->db->query($sql)->result('array'); //$this->db->fetchAll($sqls);
	}
	
	
	
	
	/**
	 * update number Estore per career
	 *
	 * @param string $field
	 * @return boolean
	 */
	public function updatePos($field){
		$result = $this->db->query('UPDATE '.$this->_table.' SET '.$field.' WHERE '.$this->getKeyString());
		if($result) return true;
		else return false;		
	}
	
	
		
	/**
	* Create breadcrumbs for nodes of tree 
	* 2012-10-25
	* 
	* @param int ID of current node
	* @param int level of parent where you want get info
	* 
	* @return array An array store info of breadcrumbs
	* 
	*/
	function breadcrumbs($id, $level_stop = null){

		$sql = "SELECT parent.*, $this->_fields FROM $this->_table AS node JOIN $this->_table AS parent
				ON (node.lft BETWEEN parent.lft AND parent.rgt) AND node.post_cat_id = $id AND parent.parents <> 0 ";
		
		if(isset($level_stop)){ $sql .= " AND parent.level > $level_stop "; }

		$sql .= " JOIN $this->_tableDesc AS d ON parent.post_cat_id=d.post_cat_id ";
		$sql .= ' ORDER BY parent.lft ASC';
		
		return $arr = $this->db->query($sql)->result('array');
	}
	
	
	function catStrIN($post_cat_id)
	{
		if( empty($post_cat_id) ) return ;

		$sql = " SELECT mc.post_cat_id, mcd.cat_name FROM $this->_table as mc RIGHT JOIN ( SELECT c.*, d.cat_name FROM $this->_table AS c JOIN $this->_tableDesc AS d ON c.post_cat_id = d.post_cat_id AND c.post_cat_id=$post_cat_id ) AS test ON (mc.lft >=test.lft AND mc.rgt <= test.rgt) JOIN $this->_tableDesc AS mcd ON mc.post_cat_id = mcd.post_cat_id ORDER BY mc.post_cat_id ASC ";

		$arr = $this->db->query($sql)->result('array');
		$catStrIN = $post_cat_id;

		if(sizeof($arr) > 0) {
			foreach ($arr as $vl) {	$catStrIN .= ','.$vl['post_cat_id']; }
		}

		return $catStrIN;
	}
	
	
	/**
	 * Get items 2 level from level parent
	 * Exp: aaa parent_level =1 (query get items have parent_level < level <= parent_level+2)
	 *
	 * @param int $post_cat_id
	 * @return array
	 */
	function itemsTwoLevel($post_cat_id) {
		if(empty($post_cat_id)) return ;
		
		$sql = "SELECT mc.post_cat_id, mc.parents, mc.level, mc.lft, mc.rgt, mcd.cat_name FROM ".$this->_table." as mc
			RIGHT JOIN
				( SELECT c.*, d.cat_name FROM ".$this->_table." AS c 
					JOIN ".$this->_tableDesc." AS d ON c.post_cat_id = d.post_cat_id AND c.post_cat_id =$post_cat_id 
				) AS test ON (mc.rgt < test.rgt) AND mc.lft > test.lft
			JOIN ".$this->_tableDesc." AS mcd ON mc.post_cat_id = mcd.post_cat_id 
			ORDER BY mcd.cat_name ASC";
		
		return $this->db->query($sql)->result('array');
	}
	
	
	
	
	function allItems($cond='AND node.post_cat_id != 1') {
		$sql = "SELECT node.post_cat_id, node.parents, node.level, node.lft, node.rgt, d.cat_name FROM es_hs_code_vn AS node JOIN es_hs_code_vn_desc AS d ON node.post_cat_id=d.post_cat_id AND node.mcAvail=1 $cond ORDER BY node.lft ASC";
		return $this->db->query($sql)->result('array');
	}
	
	
	/**
	 * Get two level Prev
	 * March 22 2013
	 * @param int $post_cat_id
	 * @return array
	 */
	function twoLevelPrev($post_cat_id) {
		if(empty($post_cat_id)) return ;
		
		$sql = "SELECT mc.post_cat_id, mc.parents, mc.level, mcd.cat_name FROM {$this->_table} as mc 
				RIGHT JOIN ( 
					SELECT c.*, d.cat_name FROM {$this->_table} AS c 
					JOIN {$this->_tableDesc} AS d ON c.post_cat_id = d.post_cat_id AND c.post_cat_id=$post_cat_id 
					) AS test ON (test.post_cat_id =  mc.post_cat_id OR test.parents=mc.post_cat_id)
					JOIN {$this->_tableDesc} AS mcd ON mc.post_cat_id = mcd.post_cat_id 
				ORDER BY mc.level ASC";
		
		return $this->db->query($sql)->result('array');
	}
	
	

	function parentNodeCustomField($num =0, $offset =0) {		
		$limit = ($num > 0) ? " LIMIT $offset,$num " : '';	
		$sql = "SELECT c.post_cat_id, d.cat_name FROM $this->_table AS c JOIN $this->_tableDesc AS d ON c.post_cat_id=d.post_cat_id AND (c.parents=1 OR c.level=1) AND c.mcAvail=1 ORDER BY d.cat_name ASC $limit";
		return $this->db->query($sql)->result('array'); 	
	}
    
    
    
}