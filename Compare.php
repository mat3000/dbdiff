<?php

class Compare{

	private $db1;
	private $db2;
	private $db_name_1;
	private $db_name_2;

	private $structure_left = [];
	private $structure_right = [];

	public function __construct($db_1, $db_2){

		// $this->structure_left['db_name'] = $db_1['name'];
		// $this->structure_right['db_name'] = $db_2['name'];
		$this->structure_left = (object) ['db_name'=> $db_1['name']];
		$this->structure_right = (object) ['db_name'=> $db_2['name']];

		$this->db1 = new DataBase($db_1['host'], $db_1['name'], $db_1['user'], $db_1['pass']);
		$this->db2 = new DataBase($db_2['host'], $db_2['name'], $db_2['user'], $db_2['pass']);

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

	public function structure(){

		$this->getStructure();

		// print_r( $this->structure_left );
		// echo "<br><br><br>";
		// print_r( $this->structure_right );
		// echo "<br><br><br>";
		// die();

		$this->compare_table();

		// print_r( $this->structure_left );
		// echo "<br><br><br>";
		// print_r( $this->structure_right );
		// echo "<br><br><br>";
		// die();

		$this->compare_structure();

		// print_r( $this->structure_left );
		// echo "<br><br><br>";
		// print_r( $this->structure_right );
		// echo "<br><br><br>";
		// die();

		return $this->generate_table();

		// die();

		// return ['left'=>$this->structure_left, 'right'=>$this->structure_right];



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
			// if( !array_key_exists($k, $s1->tables) ) $sm1[$k] = (object) ['name'=>0, 'structure'=>0];
		}

		foreach ($sm2 as $k => $v) {
			if( !array_key_exists($k, $s2->tables) ) $sm2[$k] = (object) ['name'=>'', 'structure'=>[]];
			// if( !array_key_exists($k, $s2->tables) ) $sm2[$k] = (object) ['name'=>0, 'structure'=>0];
		}

		$this->structure_left->tables = $sm1;
		$this->structure_right->tables = $sm2;

	}

	private function compare_structure(){

		foreach ($this->structure_left->tables as $k => $table_1) {

			/*if( !$this->structure_left->tables[$k]->name || !$this->structure_right->tables[$k]->name ){
				continue;
			}*/

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
				// if( !array_key_exists($kII, $s1) ) $sm1[$kII] = 0;
			}

			foreach ($sm2 as $kII => $v) {
				if( !array_key_exists($kII, $s2) ) $sm2[$kII] = (object) ['Field'=>'', 'Type'=>'', 'Null'=>'', 'Key'=>'', 'Default'=>'', 'Extra'=>''];
				// if( !array_key_exists($kII, $s2) ) $sm2[$kII] = 0;
			}

			$this->structure_left->tables[$k]->structure = $sm1;
			$this->structure_right->tables[$k]->structure = $sm2;
			
		}

	}

	private function generate_table(){

		// print_r( $this->structure_left );
		// print_r( $this->structure_right );

		// die();


		$html = '<div class="db_compare">';

			foreach ($this->structure_left->tables as $k=>$left) {

				$right = $this->structure_right->tables[$k];

				$html .= "<div class=\"block\">";

					$html .= "<div class=\"db db-left\">";

						/*$html .= "<table class=\"db__table\">";
							$html .=   "<thead>
											<tr>
						                        <th>$left->name</th>
						                        <th></th>
						                        <th>$right->name</th>
						                    </tr>
						                </thead>";
						$html .= "<tbody>";*/
						
						// $html .= "<div class=\"name name_left\">$left->name</div>";
						// $html .= "<div class=\"name name_right\">$right->name</div>";
						
						// $html .= "<div class=\"clear\"></div>";

						$html .= "<table class=\"db__structure\">";
							$html .=   "<thead>
						                    <tr>
												<th colspan=\"6\">$left->name</th>
										        <th></th>
										        <th colspan=\"6\">$right->name</th>
										    </tr>
						                    <tr>
						                        <th>Field</th>
						                        <th>Type</th> 
						                        <th>Null</th>
						                        <th>Key</th>
						                        <th>Default</th> 
						                        <th>Extra</th>
						                        <th></th>
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
									$html .= "<th></th>";
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
					
					$html .= "<div class=\"clear\"></div>";

				$html .= "</div>";

			}

		$html .= '</div>';

		return $html;

	}

}