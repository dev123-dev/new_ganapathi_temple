<?php
	if(isset($dataNotFound)) {
		echo $dataNotFound;
	}else {
		foreach($Infotable as $objects) {
			echo $objects;
		}
	}
?>