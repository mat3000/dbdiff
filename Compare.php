<?php

class Compare{

	private $db1;
	private $db2;
	private $db_name_1;
	private $db_name_2;

	private $structure_left = [];
	private $structure_right = [];

	public function __construct($db_1, $db_2){

		$this->structure_left = (object) ['db_name'=> $db_1['name']];
		$this->structure_right = (object) ['db_name'=> $db_2['name']];

		$this->db1 = new DataBase($db_1['host'], $db_1['name'], $db_1['user'], $db_1['pass']);
		$this->db2 = new DataBase($db_2['host'], $db_2['name'], $db_2['user'], $db_2['pass']);

	}

	public function structure(){

		$this->getStructure();
		$this->compare_table();
		$this->compare_structure();
		$this->organize_structure();

		return $this->generate_table();

	}

	public function table($table){

		$this->getStructure();
		$this->compare_table();
		$this->compare_structure();
		$this->organize_structure();

		if( empty($this->structure_left->tables[$table]->name) || empty($this->structure_right->tables[$table]->name) ) 
			return 'Compare fail: tables must exist on each database.';

		$this->getContent($table);
		$this->compare_content($table);

	}

	private function getContent($table){

		$content_1 = $this->db1->getContent($this->structure_left->tables[$table]->name);
		$content_2 = $this->db2->getContent($this->structure_right->tables[$table]->name);

		if($this->structure_left->tables[$table]->key_pri){
			$new_content_1 = [];
			foreach ($content_1 as $v) {
				$key_pri = $this->structure_left->tables[$table]->key_pri;
				$new_content_1[$v->$key_pri] = $v;
			}
			$new_content_2 = [];
			foreach ($content_2 as $v) {
				$key_pri = $this->structure_right->tables[$table]->key_pri;
				$new_content_2[$v->$key_pri] = $v;
			}
		}else{
			$new_content_1 = $content_1;
			$new_content_2 = $content_2;
		}

		$this->structure_left->tables[$table]->content = $new_content_1;
		$this->structure_right->tables[$table]->content = $new_content_2;

		// print_r( $this->structure_left->tables[$table]->content );
		// print_r( $this->structure_right->tables[$table]->content );

	}

	private function getStructure(){

		$tables_1 = $this->db1->getTables();
		$tables_2 = $this->db2->getTables();

		foreach ($tables_1 as $value) {
			$this->structure_left->tables[$value] = (object) ['name'=>$value];
		}

		foreach ($tables_2 as $value) {
			$this->structure_right->tables[$value] = (object) ['name'=>$value];
		}

		foreach ($this->structure_left->tables as $key=>$value) {
			$this->structure_left->tables[$key]->structure = $this->db1->getStructure($key);
		}

		foreach ($this->structure_right->tables as $key=>$value) {
			$this->structure_right->tables[$key]->structure = $this->db2->getStructure($key);
		}

	}

	private function compare_content($table){

		print_r( $this->structure_left->tables[$table]->content );
		print_r( $this->structure_right->tables[$table]->content );


		/*$c1 = $this->structure_left->tables[$table]->content;
		$c2 = $this->structure_right->tables[$table]->content;

		$cc1 = $this->structure_left->tables[$table]->content;
		$cc2 = $this->structure_right->tables[$table]->content;

		foreach ($cc1 as $k => $v) {
			if( !array_key_exists($k, $s1->tables) ) $cc1[$k] = (object) ['name'=>'', 'structure'=>[]];
		}

		foreach ($sm2 as $k => $v) {
			if( !array_key_exists($k, $s2->tables) ) $sm2[$k] = (object) ['name'=>'', 'structure'=>[]];
		}
*/


	}

	private function compare_table(){

		$s1 = $this->structure_left;
		$s2 = $this->structure_right;

		$sm1 = $s1->tables;
		$sm2 = $s2->tables;

		foreach ($s2->tables as $k=>$v) {
			if(!array_key_exists($k, $s1->tables)) {
				$sm1[$k] = $v;
			}
		}
		ksort($sm1);

		foreach ($s1->tables as $k=>$v) {
			if(!array_key_exists($k, $s2->tables)) {
				$sm2[$k] = $v;
			}
		}
		ksort($sm2);

		foreach ($sm1 as $k => $v) {
			if( !array_key_exists($k, $s1->tables) ) $sm1[$k] = (object) ['name'=>'', 'structure'=>[]];
		}

		foreach ($sm2 as $k => $v) {
			if( !array_key_exists($k, $s2->tables) ) $sm2[$k] = (object) ['name'=>'', 'structure'=>[]];
		}

		$this->structure_left->tables = $sm1;
		$this->structure_right->tables = $sm2;

	}

	private function compare_structure(){

		foreach ($this->structure_left->tables as $k => $table_1) {

			$s1 = $this->structure_left->tables[$k]->structure;
			$s2 = $this->structure_right->tables[$k]->structure;
			$sm1 = $s1;
			$sm2 = $s2;

			foreach ($s2 as $kII=>$v) {
				if(!array_key_exists($kII, $s1)) $sm1[$kII] = $v;
			}
			ksort($sm1);

			foreach ($s1 as $kII=>$v) {
				if(!array_key_exists($kII, $s2)) $sm2[$kII] = $v;
			}
			ksort($sm2);

			foreach ($sm1 as $kII => $v) {
				if( !array_key_exists($kII, $s1) ) $sm1[$kII] = (object) ['Field'=>'', 'Type'=>'', 'Null'=>'', 'Key'=>'', 'Default'=>'', 'Extra'=>''];
			}

			foreach ($sm2 as $kII => $v) {
				if( !array_key_exists($kII, $s2) ) $sm2[$kII] = (object) ['Field'=>'', 'Type'=>'', 'Null'=>'', 'Key'=>'', 'Default'=>'', 'Extra'=>''];
			}

			$this->structure_left->tables[$k]->structure = $sm1;
			$this->structure_right->tables[$k]->structure = $sm2;
			
		}

	}

	private function array_move($key, $new_index, $array){

	    if($new_index < 0) return;
	    if($new_index >= count($array)) return;
	    if(!array_key_exists($key, $array)) return;

	    $ret = array();
	    $ind = 0;
	    foreach($array as $k => $v)
	    {
	      if($new_index == $ind)
	      {
	        $ret[$key] = $array[$key];
	        $ind++;
	      }
	      if($k != $key)
	      {
	        $ret[$k] = $v;
	        $ind++;
	      }
	    }
	    // one last check for end indexes
	    if($new_index == $ind)
	        $ret[$key] = $array[$key];


	    return $ret;
	}

	private function organize_structure(){

		foreach ($this->structure_left->tables as $k => $table_1) {

			$s1 = $this->structure_left->tables[$k]->structure;
			$s2 = $this->structure_right->tables[$k]->structure;

			foreach ($s1 as $key => $value) {
				if($value->Key==='PRI'){
					$this->structure_left->tables[$k]->key_pri = $value->Field;
					$this->structure_right->tables[$k]->key_pri = $value->Field;
					$s1 = $this->array_move($key, 0, $s1);
					$s2 = $this->array_move($key, 0, $s2);
				}
			}

			foreach ($s2 as $key => $value) {
				if($value->Key==='PRI'){
					$this->structure_left->tables[$k]->key_pri = $value->Field;
					$this->structure_right->tables[$k]->key_pri = $value->Field;
					$s1 = $this->array_move($key, 0, $s1);
					$s2 = $this->array_move($key, 0, $s2);
				}
			}

			$this->structure_left->tables[$k]->structure = $s1;
			$this->structure_right->tables[$k]->structure = $s2;
			
		}

	}

	private function generate_table(){

		$html = '<div class="db_compare">';

			foreach ($this->structure_left->tables as $k=>$left) {

				$right = $this->structure_right->tables[$k];

				$html .= "<div class=\"block\">";

					$html .= "<div class=\"db db-left\">";
					$html .= "<div class=\"db__table-name\">$left->name</div>";
						$html .= "<table class=\"db__structure\">";
							$html .=   "<thead>
						                    <tr>
						                        <th>Field</th>
						                        <th>Type</th> 
						                        <th>Null</th>
						                        <th>Key</th>
						                        <th>Default</th> 
						                        <th>Extra</th>
						                    </tr>
						                </thead>";
							$html .= "<tbody>";
							foreach ($left->structure as $key => $value){
								$value2 = $right->structure[$key];
								$html .= "<tr>";
									$html .= "<th>$value->Field</th>";
									$html .= "<th>$value->Type</th>";
									$html .= "<th>$value->Null</th>";
									$html .= "<th>$value->Key</th>";
									$html .= "<th>$value->Default</th>";
									$html .= "<th>$value->Extra</th>";
								$html .= "</tr>";
							}
							$html .= "</tbody>";
						$html .= "</table>";
					$html .= "</div>";

					$html .= "<div class=\"db db-right\">";
					$html .= "<div class=\"db__table-name\">$right->name</div>";
						$html .= "<table class=\"db__structure\">";
							$html .=   "<thead>
						                    <tr>
						                        <th>Field</th>
						                        <th>Type</th> 
						                        <th>Null</th>
						                        <th>Key</th>
						                        <th>Default</th> 
						                        <th>Extra</th>
						                    </tr>
						                </thead>";
							$html .= "<tbody>";
							foreach ($left->structure as $key => $value){
								$value2 = $right->structure[$key];
								$html .= "<tr>";
									$html .= "<th>$value2->Field</th>";
									$html .= "<th>$value2->Type</th>";
									$html .= "<th>$value2->Null</th>";
									$html .= "<th>$value2->Key</th>";
									$html .= "<th>$value2->Default</th>";
									$html .= "<th>$value2->Extra</th>";
								$html .= "</tr>";
							}
							$html .= "</tbody>";
						$html .= "</table>";
					$html .= "</div>";

				$html .= "</div>";

			}

		$html .= '</div>';

		return $html;

	}

}