<?php
	function build_table_no_header($array){
		$html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"></p>';
		$html .= '<table id="myTable">';

		foreach($array as $key=>$value){
			$html .= '<tr>';
			foreach($value as $key2=>$value2){
				$html .= '<td>'.$value2.'</td>';
			}
			$html .= '</tr>';
		}

		$html .= '</table>';
		return $html;
	}
	function build_table_swap_no_header($array){
		$html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"></p>';
		$html .= '<table id="myTable">';
		
		$i = "0";
		foreach($array as $key=>$value){
			$count[$i] = count($value);
			$i++;
		}
		
		for($i="0";$i<$count[0];$i++){
			$html .= '<tr>';
			foreach($array as $key=>$value){
				$html .= '<td>'.$value[$i].'</td>';
			}
			$html .= '</tr>';
		}
		
		$html .= '</table>';
		return $html;
	}
    function build_table($array){
		$html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"></p>';
		$html .= '<table id="myTable">';
		$html .= '<thead><tr>';
		$i = "0";
		foreach($array[0] as $key=>$value){
			$html .= '<th onclick="sortTable('.$i.')">'.htmlspecialchars($key).'</th>';
			$i++;	
		}
		$html .= '</tr></thead>';

		foreach($array as $key=>$value){
			$html .= '<tr>';
			foreach($value as $key2=>$value2){
				$html .= '<td>'.$value2.'</td>';
			}
			$html .= '</tr>';
		}

		$html .= '</table>';
		return $html;
	}
    function build_table_swap($array){
		$html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"></p>';
		$html .= '<table id="myTable">';
		$html .= '<thead><tr>';
		$i = "0";
		foreach($array as $key=>$value){
			$html .= '<th onclick="sortTable('.$i.')">'.htmlspecialchars($key).'</th>';
			$count[$i] = count($value);
			$i++;
		}
		$html .= '</tr></thead>';
		
		for($i="0";$i<$count[0];$i++){
			$html .= '<tr>';
			foreach($array as $key=>$value){
				$html .= '<td>'.$value[$i].'</td>';
			}
			$html .= '</tr>';
		}
		
		$html .= '</table>';
		return $html;
	}
?>