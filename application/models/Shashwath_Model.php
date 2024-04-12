<?php
	class Shashwath_Model extends CI_Model{
		//TABLE NAME
		var $table_Period = 'SHASHWATH_PERIOD_SETTING';
		var $table_Calendar = 'CALENDAR';
		var $table_Cal_Year_Breakup = 'CALENDAR_YEAR_BREAKUP';
		var $table_Festival = 'shashwath_festival_setting';

		public function __Construct()
		{
			parent::__construct();
			$this->load->database();
		}


		function getShashwathDetailsForGeneratingShaswathSevaReport($date, $name_phone,$excludeIncludeCondition) {
			$filter = "AND 1";
			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
				  $filter = "AND SM_NAME LIKE '$name_phone%'";
				} else {
				  $filter = "AND SM_PHONE LIKE '$name_phone%'";	
				}
			}

			$sql ="SELECT 
					shashwath_seva.SS_ID,
			        Deity.DEITY_ID,
			        Deity.DEITY_NAME, 
			        deity_seva.SEVA_NAME, 
			        shashwath_members.SM_NAME, 
			        shashwath_members.SM_PHONE,
				    shashwath_members.SM_NAKSHATRA,
			        shashwath_seva.THITHI_CODE
					FROM deity_seva_offered dso 
					INNER JOIN shashwath_seva ON dso.SS_ID = shashwath_seva.SS_ID
					INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
					INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
					INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
					WHERE dso.SO_DATE ='$date' ".$filter." ".$excludeIncludeCondition."  GROUP BY shashwath_seva.SS_ID 
					ORDER BY Deity.DEITY_ID, deity_seva.SEVA_ID ASC";

			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return array();
			} 		
		}
		
		function count_result($date) {
			$query = $this->db->query("SELECT * FROM deity_seva_offered where RECEIPT_CATEGORY_ID = 7 AND SO_DATE = '".$date."'");
			if($query->num_rows() > 0){
				return true;
			} else {
				return false;
			} 
		}	

		function getSevaGeneratedPreviouslyStatus($date) {
			$query = $this->db->query("SELECT * FROM deity_shashwath_seva_generation where DSSG_DATE = '".$date."'");
			if($query->num_rows() > 0){
				return true;
			} else {
				return false;
			}
		}	
		
		function count_seva_for_date($date) {
			$this->db->where('SO_DATE',$date);
			$this->db->where('RECEIPT_CATEGORY_ID',7);
			$query = $this->db->get('deity_seva_offered');
			if ($query->num_rows() > 0){
				return $query->num_rows();
			} else {
				return false;
			}
		}
		
		function getThithiCode($date){
			$sql = "SELECT THITHI_SHORT_CODE,CAL_ROI,CAL_YEAR_ID FROM calendar INNER JOIN calendar_year_breakup ON calendar_year_breakup.CAL_ID = calendar.CAL_ID WHERE calendar.CAL_ID = (SELECT CAL_ID FROM calendar WHERE (STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) ORDER BY CAL_ID DESC LIMIT 1) AND ENG_DATE = '$date' and DEACTIVE_STATUS = 0";
			
			$query = $this->db->query($sql);

		  // return $sql;
			 if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}  
		}

		function getThithiCodeROI($date){
			$sql = "SELECT THITHI_SHORT_CODE,CAL_ROI,CAL_YEAR_ID FROM calendar INNER JOIN calendar_year_breakup ON calendar_year_breakup.CAL_ID = calendar.CAL_ID WHERE calendar.CAL_ID = (SELECT CAL_ID FROM calendar WHERE (STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) ORDER BY CAL_ID DESC LIMIT 1) AND ENG_DATE = '$date'";
			$query = $this->db->query($sql);
			 if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}  
		}

		 // function getExistingSevas($date,$num,$start,$name_phone){
			
		// 	$filter = "AND 1";
		// 	if($name_phone != '' || $name_phone == 0) {
		// 		if(!is_numeric($name_phone)){
		// 		  $filter = "AND SM_NAME LIKE '$name_phone%'";
		// 		} else {
		// 		  $filter = "AND SM_PHONE LIKE '$name_phone%'";	
		// 		}
		// 	}
			
		// 	$sql ="SELECT 
		// 		shashwath_members.SM_NAME,
		// 		dso.SO_ID,shashwath_seva.SS_ID,SUM(dso.SEVA_CORPUS) AS SEVA_CORPUS,deity_seva.SEVA_NAME,dso.SO_PRICE AS SEVA_AMT,
		// 		IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
		// 		deity.DEITY_NAME,
		// 		dso.SO_DATE,
		// 		CONCAT(deity_seva.SEVA_NAME,' (Rs. ',dso.SO_PRICE,'/-)') AS SEVA_PRICE,
		// 		dso.SO_QUANTITY AS SEVA_QTY,
		// 		dso.SO_PRICE AS SEVA_COST,
		// 		dso.SO_PRICE*dso.SO_QUANTITY AS TOTAL_SEVA_COST,
		// 		CONCAT('Rs. ',SUM(dso.SEVA_CORPUS),'/- ',' (Rs. ',(dso.SEVA_INTEREST),'/-)') AS PRINCIPAL_INTEREST,
		// 		CONCAT('Rs. ',dso.LOSS_BALANCE,'/-') AS SEVA_LOSS,

		// 		CONCAT('Rs. ',((SELECT COALESCE(SUM(dso1.LOSS_BALANCE),0) FROM deity_seva_offered dso1 WHERE dso1.SS_ID = shashwath_seva.SS_ID AND (STR_TO_DATE(dso1.SO_DATE,'%d-%m-%Y') <= STR_TO_DATE(DATE_FORMAT(CURDATE(),'%d-%m-%Y'),'%d-%m-%Y')))),'/-') AS ACCUMULATED_LOSS,

		// 		CONCAT('Rs. ',((SELECT COALESCE(SUM(dso3.LOSS_BALANCE),0) FROM deity_seva_offered dso3 WHERE dso3.SS_ID = shashwath_seva.SS_ID)),'/-')  AS TOTAL_LOSS, 
		// 		deity_seva.SEVA_TYPE,
		// 		IF(STR_TO_DATE('$date','%d-%m-%Y') >= CURDATE(),1,0) AS EDIT_CHECK
		// 		FROM deity_seva_offered dso 
		// 		INNER JOIN shashwath_seva ON dso.SS_ID = shashwath_seva.SS_ID
		// 		INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
		// 		INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
		// 		INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		// 		WHERE dso.SO_DATE ='$date' ".$filter."  GROUP BY shashwath_seva.SS_ID  LIMIT $start, $num  ";

		// 		  $query = $this->db->query($sql);
		// 		 // return $sql;
		// 		 // $this->db->limit($num, $start);
		// 			  if ($query->num_rows() > 0) {
		// 				return $query->result();
		// 			} else {
		// 				return array();
		// 			} 					
		// }
		

		function getExistingSevas($date,$num,$start,$name_phone,$combo='',$sevaCombo=''){
			
			$filter = " ";
			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
				  $filter = "AND SM_NAME LIKE '$name_phone%'";
				} else {
				  $filter = "AND SM_PHONE LIKE '$name_phone%'";	
				}
			}
			if($combo!=''){
				$filter .= " AND shashwath_seva.DEITY_ID=$combo";
			}
			if($sevaCombo!=''){
				$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
			}
			
			
			$sql ="SELECT 
				shashwath_members.SM_NAME,
				dso.SO_ID,shashwath_seva.SS_ID,
				SUM(dso.SEVA_CORPUS) 
				AS SEVA_CORPUS,IS_MANDALI,deity_seva.SEVA_NAME,dso.SO_PRICE 
				AS SEVA_AMT,THITHI_CODE,shashwath_seva.EVERY_WEEK_MONTH,SEVA_NOTES, 	
				IF((shashwath_members.SM_PHONE != ''),
				CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) 
				AS NAME_PHONE,shashwath_members.SM_ID,shashwath_members.SM_REF, shashwath_members.SM_NAME, shashwath_members.SM_PHONE,
				shashwath_members.SM_PHONE2,shashwath_members.SM_ADDR1, shashwath_members.SM_ADDR2, shashwath_members.SM_CITY,shashwath_members.SM_STATE, shashwath_members.SM_COUNTRY, shashwath_members.SM_PIN,shashwath_members.SM_ID,
				deity.DEITY_NAME,dso.SO_DATE,
				CONCAT(deity_seva.SEVA_NAME,' (Rs. ',dso.SO_PRICE,'/-)') AS SEVA_PRICE,
				dso.SO_QUANTITY AS SEVA_QTY,
				dso.SO_PRICE AS SEVA_COST,
				dso.SO_PRICE*dso.SO_QUANTITY AS TOTAL_SEVA_COST,
				CONCAT('Rs. ',SUM(dso.SEVA_CORPUS),'/- ',' (Rs. ',(dso.SEVA_INTEREST),'/-)') AS PRINCIPAL_INTEREST,
				CONCAT('Rs. ',dso.LOSS_BALANCE,'/-') AS SEVA_LOSS,
				CONCAT('Rs. ',((SELECT COALESCE(SUM(dso1.LOSS_BALANCE),0) FROM deity_seva_offered dso1 WHERE dso1.SS_ID = shashwath_seva.SS_ID AND (STR_TO_DATE(dso1.SO_DATE,'%d-%m-%Y') <= STR_TO_DATE(DATE_FORMAT(CURDATE(),'%d-%m-%Y'),'%d-%m-%Y')))),'/-') AS ACCUMULATED_LOSS,
				CONCAT('Rs. ',((SELECT COALESCE(SUM(dso3.LOSS_BALANCE),0) FROM deity_seva_offered dso3 WHERE dso3.SS_ID = shashwath_seva.SS_ID)),'/-')  AS TOTAL_LOSS, 
				deity_seva.SEVA_TYPE,
				IF(STR_TO_DATE('$date','%d-%m-%Y') >= CURDATE(),1,0) AS EDIT_CHECK
				FROM deity_seva_offered dso 
				INNER JOIN shashwath_seva ON dso.SS_ID = shashwath_seva.SS_ID
				INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
				INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
				INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
				WHERE dso.SO_DATE ='$date' ".$filter."  GROUP BY shashwath_seva.SS_ID  LIMIT $start, $num  ";

				  $query = $this->db->query($sql);
				 // return $sql;
				 // $this->db->limit($num, $start);
					  if ($query->num_rows() > 0) {
						return $query->result();
					} else {
						return array();
					} 					
		}

		function getShashwathSevas($date,$thithi_where_condition,$ROI,$num,$start,$name_phone,$combo='',$sevaCombo='',$oneYrLessSelDate){
			$filter = "AND 1";
			if($name_phone != '' || $name_phone == 0) {
				if($name_phone != '' && $name_phone == 0) {
					if(!is_numeric($name_phone)){
						$filter = "AND SM_NAME LIKE '$name_phone%'";
					} else {
						$filter = "AND SM_PHONE LIKE '$name_phone%'";	
					}
				}
			}

			if($combo!=''){
				$filter .= " AND shashwath_seva.DEITY_ID=$combo";
			}
			if($sevaCombo!=''){
				$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
			}
			
			$sql = "SELECT shashwath_seva.SS_ID, SUM(deity_receipt.RECEIPT_PRICE) AS SEVA_CORPUS,IS_MANDALI,deity_seva.SEVA_NAME,IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)) AS SEVA_AMT,THITHI_CODE,shashwath_seva.EVERY_WEEK_MONTH, 	
				IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,SEVA_NOTES,
				deity.DEITY_NAME,shashwath_members.SM_REF, shashwath_members.SM_NAME, shashwath_members.SM_PHONE, shashwath_members.SM_PHONE2,shashwath_members.SM_ADDR1, shashwath_members.SM_ADDR2, shashwath_members.SM_CITY, shashwath_members.SM_STATE, shashwath_members.SM_COUNTRY, shashwath_members.SM_PIN,shashwath_members.SM_ID,RECEIPT_NO,
				CONCAT(deity_seva.SEVA_NAME,' (Rs. ',IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)),'/-)') AS SEVA_PRICE,
				SEVA_QTY,
				IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2),IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2),ROUND(OLD_PRICE*$ROI/100,2))) AS SEVA_COST,
				IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,ROUND(OLD_PRICE*$ROI/100,2)*SEVA_QTY)) AS TOTAL_SEVA_COST,
				CONCAT('Rs. ',SUM(deity_receipt.RECEIPT_PRICE),'/- ',' (Rs. ',ROUND((SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * ('$ROI')/100)),'/-)') AS PRINCIPAL_INTEREST, 
				IF(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,CONCAT('Rs. ',(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1,' /-'),CONCAT('Rs. 0/-')) AS SEVA_LOSS , 

				CONCAT('Rs. ',(SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0)
				FROM deity_seva_offered
				WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID),'/-') AS ACCUMULATED_LOSS,

				CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID) + (IF(ROUND(SUM(DEITY_RECEIPT.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,(ROUND(SUM(DEITY_RECEIPT.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1,0))),'/-') AS TOTAL_LOSS, 
				deity_seva.SEVA_TYPE,NO_OF_SEVAS,SHASH_PRICE
				FROM shashwath_seva INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
				INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
				INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
				INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID
				INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID
				WHERE (".$thithi_where_condition.") AND SEVA_PRICE_ACTIVE = 1  AND shashwath_seva.SS_STATUS = 1 AND RECEIPT_CATEGORY_ID = 7 ".$filter." AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) GROUP BY shashwath_seva.SS_ID LIMIT $start,$num";
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}  
		}

		// function getShashwathSevas($date,$thithi_where_condition,$ROI,$num,$start,$name_phone,$combo='',$sevaCombo='',$oneYrLessSelDate){
		// 	$filter = "AND 1 ";
		// 	if($name_phone != '' || $name_phone == 0) {
		// 		if($name_phone != '' && $name_phone == 0) {
		// 			if(!is_numeric($name_phone)){
		// 				$filter = "AND SM_NAME LIKE '$name_phone%'";
		// 			} else {
		// 				$filter = "AND SM_PHONE LIKE '$name_phone%'";	
		// 			}
		// 		}
		// 	}

		// 	if($combo!=''){
		// 		$filter .= " AND shashwath_seva.DEITY_ID=$combo";
		// 	}
		// 	if($sevaCombo!=''){
		// 		$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
		// 	}

		// 	$sql = "ELECT shashwath_seva.SS_ID, SUM(deity_receipt.RECEIPT_PRICE) AS SEVA_CORPUS,IS_MANDALI,deity_seva.SEVA_NAME,IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)) AS SEVA_AMT,THITHI_CODE,
		// 		IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,shashwath_members.SM_ID,
		// 		deity.DEITY_NAME,
		// 		CONCAT(deity_seva.SEVA_NAME,' (Rs. ',IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)),'/-)') AS SEVA_PRICE,
		// 		SEVA_QTY,
		// 		IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)) AS SEVA_COST,
		// 		IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)) AS TOTAL_SEVA_COST,  
		// 		CONCAT('Rs. ',SUM(deity_receipt.RECEIPT_PRICE),'/- ',' (Rs. ',ROUND((SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * ('$ROI')/100)),'/-)') AS PRINCIPAL_INTEREST, 
		// 		IF(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,
		// 		CONCAT('Rs. ',(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1,' /-'),
		// 		CONCAT('Rs. 0/-')) AS SEVA_LOSS , 

		// 		CONCAT('Rs. ',(SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0)
		// 		FROM deity_seva_offered
		// 		WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID),'/-') AS ACCUMULATED_LOSS,

		// 		CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID) + (IF(ROUND(SUM(DEITY_RECEIPT.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,(ROUND(SUM(DEITY_RECEIPT.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1,0))),'/-') AS TOTAL_LOSS, 
		// 		deity_seva.SEVA_TYPE,NO_OF_SEVAS,SHASH_PRICE

		// 		FROM shashwath_seva INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		// 		INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
		// 		INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
		// 		INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID
		// 		INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID
		// 		WHERE (".$thithi_where_condition.") AND SEVA_PRICE_ACTIVE = 1  AND shashwath_seva.SS_STATUS = 1 AND PAYMENT_STATUS!='Cancelled' AND RECEIPT_CATEGORY_ID = 7 ".$filter." AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) GROUP BY shashwath_seva.SS_ID LIMIT $start,$num";
			
		// 	$query = $this->db->query($sql);
		// 	//echo $this->db->last_query();
			
		// 	if ($query->num_rows() > 0) {
		// 		return $query->result();
		// 	} else {
		// 		return array();
		// 	}  
		// }
		
		
		function priceAdd($data){
			$sql = "SELECT shashwath_members.SM_NAME,deity_seva_offered.SO_SEVA_NAME,SO_ID FROM `deity_seva_offered`
                    INNER JOIN shashwath_seva ON deity_seva_offered.SS_ID =shashwath_seva.SS_ID INNER JOIN shashwath_members ON shashwath_seva.SM_ID =shashwath_members.SM_ID WHERE deity_seva_offered.SO_ID = '$data'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    }   
		}
		function priceSubmit($price,$soId){
			$sql ="UPDATE `deity_seva_offered` SET SO_PRICE = '$price' ,LOSS_BALANCE = IF(('$price' - deity_seva_offered.SEVA_INTEREST) > 0,('$price'- deity_seva_offered.SEVA_INTEREST),0)WHERE SO_ID = '$soId'"; 
			$this->db->query($sql);
		}
		
		function generateSeva($date,$thithi_where_condition,$ROI,$dateTime,$todayDate,$userId,$oneYrLessSelDate){
			
		$sql = "INSERT INTO deity_seva_offered(deity_seva_offered.SS_ID,deity_seva_offered.SO_DEITY_ID,deity_seva_offered.SO_DEITY_NAME,deity_seva_offered.SO_SEVA_ID,deity_seva_offered.SO_SEVA_NAME,deity_seva_offered.SO_PRICE,deity_seva_offered.LOSS_BALANCE,deity_seva_offered.SEVA_INTEREST,deity_seva_offered.SO_DATE,deity_seva_offered.SO_QUANTITY,deity_seva_offered.RECEIPT_CATEGORY_ID,deity_seva_offered.SO_IS_SEVA,deity_seva_offered.RECEIPT_ID,deity_seva_offered.SEVA_CORPUS,deity_seva_offered.GENERATED_DATE,deity_seva_offered.GENERATED_DATE_TIME,deity_seva_offered.GENERATED_BY)
			
			SELECT shashwath_seva.SS_ID,
			shashwath_seva.DEITY_ID, 
			deity.DEITY_NAME,
			shashwath_seva.SEVA_ID,
			deity_seva.SEVA_NAME,
			
			IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)) AS SEVA_PRICE,
			 
			IF(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,((ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),ROUND(SHASH_PRICE*$ROI/100,2)*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1),(0)) AS SEVA_LOSS, 
            
			ROUND((SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * ('$ROI')/100)) AS INTEREST,
			'$date',
			shashwath_seva.SEVA_QTY,
			7,
			1,
			deity_receipt.RECEIPT_ID,
			SUM(deity_receipt.RECEIPT_PRICE) AS CORPUS,
			'$todayDate',
			'$dateTime',
			$userId
			FROM shashwath_seva INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
			INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
			INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
		    INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID
			INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID

			WHERE (".$thithi_where_condition.") AND SEVA_PRICE_ACTIVE = 1  AND shashwath_seva.SS_STATUS = 1 AND RECEIPT_CATEGORY_ID = 7 AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) GROUP BY shashwath_seva.SS_ID";
			//abhicode start 
			$this->db->query($sql);

			$sqlSevaGen ="UPDATE `shashwath_seva` SET SEVA_GEN_COUNTER = SEVA_GEN_COUNTER-1 where (".$thithi_where_condition.") AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) "; 
			$this->db->query($sqlSevaGen);
			

			$sql1 ="UPDATE `shashwath_seva` SET SP_COUNTER = SP_COUNTER+1 where (".$thithi_where_condition.") AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) AND SEVA_GEN_COUNTER =0 "; 
		    
		    ///abhicode end

			$sql2 ="UPDATE
		    shashwath_seva
		    INNER JOIN shashwath_period_setting
	        ON shashwath_seva.SP_ID =shashwath_period_setting.SP_ID
	        SET shashwath_seva.SS_STATUS=0
	        WHERE shashwath_seva.SP_COUNTER=shashwath_period_setting.PERIOD";
	        $this->db->query($sql1);  
		    $this->db->query($sql2);

			$this->db->query("INSERT INTO deity_shashwath_seva_generation(DSSG_DATE,DSSG_STATUS,DSSG_DATE_TIME,DSSG_STATUS_BY_ID) VALUES('".$date."',1,'".date('d-m-Y H:i:s A')."',".$_SESSION['userId'].")");	
		}

		// function getExistingSevasCount($date,$name_phone){
		// 	$filter = "AND 1";
			
		// 	if($name_phone != '' || $name_phone == 0) {
		// 		if(!is_numeric($name_phone)){
		// 		$filter = "AND SM_NAME LIKE '$name_phone%'";
		// 		} else {
		// 		$filter = "AND SM_PHONE LIKE '$name_phone%'";	
		// 		}
		// 	}
			
		// 	$sql ="SELECT 
		// 		deity_seva_offered.SO_ID,shashwath_seva.SS_ID,
		// 		IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
		// 		deity.DEITY_NAME,
		// 		SO_DATE,
		// 		CONCAT(deity_seva.SEVA_NAME,' (Rs. ',deity_seva_offered.SO_PRICE,'/-)') AS SEVA_PRICE,
		// 		CONCAT('Rs. ',SUM(deity_seva_offered.SEVA_CORPUS),'/- ',' (Rs. ',(deity_seva_offered.SEVA_INTEREST),'/-)') AS PRINCIPAL_INTEREST,
		// 		CONCAT('Rs. ',deity_seva_offered.LOSS_BALANCE,'/-') AS SEVA_LOSS,

		// 		CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE SS_ID = deity_seva_offered.SS_ID AND (STR_TO_DATE(SO_DATE,'%d-%m-%Y') <= STR_TO_DATE(DATE_FORMAT(CURDATE(),'%d-%m-%Y'),'%d-%m-%Y'))) - 
		// 		(SELECT COALESCE(SUM(shashwath_loss_paid.AMOUNT),0) 
		// 		FROM deity_seva_offered
		// 		INNER JOIN shashwath_loss_paid ON shashwath_loss_paid.SO_ID = deity_seva_offered.SO_ID
		// 		WHERE deity_seva_offered.SS_ID = deity_seva_offered.SS_ID)),'/-') AS ACCUMULATED_LOSS,

		// 		CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE SS_ID = deity_seva_offered.SS_ID) - 
		// 		(SELECT COALESCE(SUM(shashwath_loss_paid.AMOUNT),0) 
		// 		FROM deity_seva_offered
		// 		INNER JOIN shashwath_loss_paid ON shashwath_loss_paid.SO_ID = deity_seva_offered.SO_ID
		// 		WHERE deity_seva_offered.SS_ID = deity_seva_offered.SS_ID)),'/-')  AS TOTAL_LOSS

		// 		FROM deity_seva_offered 
		// 		INNER JOIN shashwath_seva ON deity_seva_offered.SS_ID = shashwath_seva.SS_ID
		// 		INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
		// 		INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
		// 		INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		// 		WHERE deity_seva_offered.SO_DATE ='$date' ".$filter." GROUP BY shashwath_seva.SS_ID  ";
		// 		  $query = $this->db->query($sql);
				 
		// 	if ($query->num_rows() > 0) {
		// 		return $query->num_rows();
		// 	} else {
		// 		return array();
		// 	}   
		// }

		function getExistingSevasCount($date,$name_phone,$combo='',$sevaCombo=''){
			$filter = "AND 1";
			
			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
				$filter = "AND SM_NAME LIKE '$name_phone%'";
				} else {
				$filter = "AND SM_PHONE LIKE '$name_phone%'";	
				}
			}

			if($combo!=''){
				$filter .= " AND shashwath_seva.DEITY_ID=$combo";
			}
			if($sevaCombo!=''){
				$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
			}
			
			$sql ="SELECT 
				deity_seva_offered.SO_ID,shashwath_seva.SS_ID,
				IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				deity.DEITY_NAME,
				SO_DATE,
				CONCAT(deity_seva.SEVA_NAME,' (Rs. ',deity_seva_offered.SO_PRICE,'/-)') AS SEVA_PRICE,
				CONCAT('Rs. ',SUM(deity_seva_offered.SEVA_CORPUS),'/- ',' (Rs. ',(deity_seva_offered.SEVA_INTEREST),'/-)') AS PRINCIPAL_INTEREST,
				CONCAT('Rs. ',deity_seva_offered.LOSS_BALANCE,'/-') AS SEVA_LOSS,

				CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE SS_ID = deity_seva_offered.SS_ID AND (STR_TO_DATE(SO_DATE,'%d-%m-%Y') <= STR_TO_DATE(DATE_FORMAT(CURDATE(),'%d-%m-%Y'),'%d-%m-%Y'))) - 
				(SELECT COALESCE(SUM(shashwath_loss_paid.AMOUNT),0) 
				FROM deity_seva_offered
				INNER JOIN shashwath_loss_paid ON shashwath_loss_paid.SO_ID = deity_seva_offered.SO_ID
				WHERE deity_seva_offered.SS_ID = deity_seva_offered.SS_ID)),'/-') AS ACCUMULATED_LOSS,

				CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE SS_ID = deity_seva_offered.SS_ID) - 
				(SELECT COALESCE(SUM(shashwath_loss_paid.AMOUNT),0) 
				FROM deity_seva_offered
				INNER JOIN shashwath_loss_paid ON shashwath_loss_paid.SO_ID = deity_seva_offered.SO_ID
				WHERE deity_seva_offered.SS_ID = deity_seva_offered.SS_ID)),'/-')  AS TOTAL_LOSS

				FROM deity_seva_offered 
				INNER JOIN shashwath_seva ON deity_seva_offered.SS_ID = shashwath_seva.SS_ID
				INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
				INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
				INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
				WHERE deity_seva_offered.SO_DATE ='$date' ".$filter." GROUP BY shashwath_seva.SS_ID  ";
				  $query = $this->db->query($sql);
				 
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return array();
			}   
		}

		// function getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,$combo='',$sevaCombo=''){
		// 	/* $ROI = "SELECT CAL_ROI FROM calendar INNER JOIN calendar_year_breakup ON calendar_year_breakup.CAL_ID = calendar.CAL_ID WHERE calendar.CAL_ID = (SELECT CAL_ID FROM calendar WHERE        (STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) ORDER BY CAL_ID DESC LIMIT 1) AND ENG_DATE = '$date' LIMIT 1"; */
			
		// 	$filter = "AND 1";
			
		// 	if($name_phone != '' || $name_phone == 0) {
		// 		if(!is_numeric($name_phone)){
		// 		$filter = "AND SM_NAME LIKE '$name_phone%'";
		// 		} else {
		// 		$filter = "AND SM_PHONE LIKE '$name_phone%'";	
		// 		}
		// 	}

		// 	if($combo!=''){
		// 		$filter .= " AND shashwath_seva.DEITY_ID=$combo";
		// 	}
		// 	if($sevaCombo!=''){
		// 		$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
		// 	}
			
		// 	$sql = "SELECT shashwath_seva.SS_ID, IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
		// 			deity.DEITY_NAME,
		// 			CONCAT(deity_seva.SEVA_NAME,' (Rs. ',IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)),'/-)') AS SEVA_PRICE,
		// 			CONCAT('Rs. ',SUM(deity_receipt.RECEIPT_PRICE),'/- ',' (Rs. ',ROUND((SUM(deity_receipt.RECEIPT_PRICE) * ('$ROI')/100)),'/-)') AS PRINCIPAL_INTEREST, 
		// 			IF((SUM(deity_receipt.RECEIPT_PRICE) * (('$ROI')/100)- IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)))>0,CONCAT('Rs. ',ROUND(0),'/-'),CONCAT('Rs. ',ROUND((SUM(deity_receipt.RECEIPT_PRICE) * (('$ROI')/100)- IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE))))*-1,'/-')) AS SEVA_LOSS, 
	
		// 			CONCAT('Rs. ',(SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) 
		// 			FROM deity_seva_offered
		// 			WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID) - 
		// 			(SELECT COALESCE(SUM(shashwath_loss_paid.AMOUNT),0) 
		// 			FROM deity_seva_offered
		// 			INNER JOIN shashwath_loss_paid ON shashwath_loss_paid.SO_ID = deity_seva_offered.SO_ID
		// 			WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID),'/-') AS ACCUMULATED_LOSS,

		// 			CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) 
		// 			FROM deity_seva_offered
		// 			WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID) +
		// 			(IF((SUM(deity_receipt.RECEIPT_PRICE) * (('$ROI')/100)- IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)))>0,ROUND(0),ROUND((SUM(deity_receipt.RECEIPT_PRICE) * (('$ROI')/100)- IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE))))*-1)))
		// 			 -
		// 			(SELECT COALESCE(SUM(shashwath_loss_paid.AMOUNT),0) 
		// 			FROM deity_seva_offered
		// 			INNER JOIN shashwath_loss_paid ON shashwath_loss_paid.SO_ID = deity_seva_offered.SO_ID
		// 			WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID),'/-') AS TOTAL_LOSS

		// 			FROM shashwath_seva INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		// 			INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
		// 			INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
		// 			INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID
		// 			INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID
		// 			WHERE (".$thithi_where_condition.") AND SEVA_PRICE_ACTIVE = 1  AND shashwath_seva.SS_STATUS = 1 ".$filter." GROUP BY shashwath_seva.SS_ID";
		// 	        $query = $this->db->query($sql);
		// 		//$this->db->limit($num, $start);
				
		// 	if ($query->num_rows() > 0) {
		// 		return $query->num_rows();
		// 	} else {
		// 		return 0;
		// 	}    
		
		// }
		
		function getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,$combo='',$sevaCombo='',$oneYrLessSelDate){
			/* $ROI = "SELECT CAL_ROI FROM calendar INNER JOIN calendar_year_breakup ON calendar_year_breakup.CAL_ID = calendar.CAL_ID WHERE calendar.CAL_ID = (SELECT CAL_ID FROM calendar WHERE        (STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) ORDER BY CAL_ID DESC LIMIT 1) AND ENG_DATE = '$date' LIMIT 1"; */
			
			$filter = "AND 1";
			
			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
				$filter = "AND SM_NAME LIKE '$name_phone%'";
				} else {
				$filter = "AND SM_PHONE LIKE '$name_phone%'";	
				}
			}

			if($combo!=''){
				$filter .= " AND shashwath_seva.DEITY_ID=$combo";
			}
			if($sevaCombo!=''){
				$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
			}
			
			$sql = "SELECT shashwath_seva.SS_ID
					FROM shashwath_seva 
					INNER JOIN deity_seva 
					ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
					INNER JOIN shashwath_members 
					ON shashwath_members.SM_ID = shashwath_seva.SM_ID
					INNER JOIN deity 
					ON deity.DEITY_ID = shashwath_seva.DEITY_ID
					INNER JOIN deity_receipt 
					ON deity_receipt.SS_ID = shashwath_seva.SS_ID
					INNER JOIN deity_seva_price 
					ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID
					WHERE (".$thithi_where_condition.") AND SEVA_PRICE_ACTIVE = 1  AND shashwath_seva.SS_STATUS = 1 
					".$filter." AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) 
					GROUP BY shashwath_seva.SS_ID";
			        $query = $this->db->query($sql);
				//$this->db->limit($num, $start);
				
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}    
		
		}
		
		function getMainLossdetails($num,$start,$name_phone = ''){

				   $this->db->select("shashwath_seva.SS_ID,
			       deity_seva_offered.SO_ID,
			       SO_DATE,
				   shashwath_members.SM_ID,
				   IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				   deity.DEITY_ID,
				   DEITY_NAME,
				   deity_seva.SEVA_ID,
				   SEVA_NAME,CAL_TYPE,
				   CONCAT('Rs. ',sum(LOSS_BALANCE),'/-') AS ACCUMULATED_LOSS ");
 
					if($name_phone != '' || $name_phone == 0) {
						if(!is_numeric($name_phone)){
							$this->db->like('SM_NAME',$name_phone,'after');	
						} else {
							$this->db->like('SM_PHONE',$name_phone,'after');
						}
					}

					
					$this->db->from('SHASHWATH_MEMBERS');
					$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
					$this->db->join('DEITY','DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID');
					$this->db->join('DEITY_SEVA','DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID');
					$this->db->join('DEITY_SEVA_OFFERED','DEITY_SEVA_OFFERED.SS_ID = SHASHWATH_SEVA.SS_ID');
				//	$this->db->where("date_format(STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y'),'%Y-%m-%d') < date_format(STR_TO_DATE('$date','%d-%m-%Y'),'%Y-%m-%d')");
					$this->db->where('deity_seva_offered.SEVA_LOSS_CONFIRMED','0');
					$this->db->where('LOSS_BALANCE > ','0');
					$this->db->group_by('SHASHWATH_SEVA.SS_ID'); 
					$this->db->limit($num, $start);
					$query = $this->db->get(); 
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    }   	   		    
		}
	
		function getMainLoss($date,$num,$start,$name_phone = ''){
		/* 	$sql = "SELECT shashwath_seva.SS_ID,
			       deity_seva_offered.SO_ID,
			       SO_DATE,
				   shashwath_members.SM_ID,
				   CONCAT(SM_NAME,' (',SM_PHONE,')')  AS NAME_PHONE, 
				   deity.DEITY_ID,
				   DEITY_NAME,
				   deity_seva.SEVA_ID,
				   SEVA_NAME,
				   CONCAT('Rs. ',sum(LOSS_BALANCE),'/-') AS ACCUMULATED_LOSS  
				   FROM shashwath_members 
				   INNER JOIN shashwath_seva ON shashwath_members.SM_ID = shashwath_seva.SM_ID 
				   INNER JOIN deity_seva_offered ON shashwath_seva.SS_ID = deity_seva_offered.SS_ID 
				   INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
				   INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
				   WHERE  STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$date','%d-%m-%Y') AND deity_seva_offered.SEVA_LOSS_CONFIRMED = 0 AND LOSS_BALANCE > 0 GROUP BY shashwath_seva.SS_ID LIMIT $start ,$num"; */
				   $this->db->select("shashwath_seva.SS_ID,
			       deity_seva_offered.SO_ID,
			       SO_DATE,
				   shashwath_members.SM_ID,
				   IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				   deity.DEITY_ID,
				   DEITY_NAME,
				   deity_seva.SEVA_ID,
				   SEVA_NAME,CAL_TYPE,
				   CONCAT('Rs. ',sum(LOSS_BALANCE),'/-') AS ACCUMULATED_LOSS ");
 
					if($name_phone != '' || $name_phone == 0) {
						if(!is_numeric($name_phone)){
							$this->db->like('SM_NAME',$name_phone,'both');	
						} else {
							$this->db->like('SM_PHONE',$name_phone,'after');
						}
					}
					if($date != '' ) {
							$this->db->where('SO_DATE',$date,'after');	
					}

					$this->db->from('SHASHWATH_MEMBERS');
					$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
					$this->db->join('DEITY','DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID');
					$this->db->join('DEITY_SEVA','DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID');
					$this->db->join('DEITY_SEVA_OFFERED','DEITY_SEVA_OFFERED.SS_ID = SHASHWATH_SEVA.SS_ID');
				//	$this->db->where("date_format(STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y'),'%Y-%m-%d') < date_format(STR_TO_DATE('$date','%d-%m-%Y'),'%Y-%m-%d')");
					//$this->db->where("deity_seva_offered.SO_DATE < '$date'");
					$this->db->where('deity_seva_offered.SEVA_LOSS_CONFIRMED','0');
					$this->db->where('LOSS_BALANCE > ','0');
					$this->db->group_by('SHASHWATH_SEVA.SS_ID'); 
					$this->db->limit($num, $start);
					$query = $this->db->get(); 
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    }   	   		    
		}
		
		function getTotalAccumulatedLoss($date='',$name_phone = ''){
		   $this->db->select("shashwath_seva.SS_ID,
		   deity_seva_offered.SO_ID,
		   SO_DATE,
		   shashwath_members.SM_ID,
		   IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
		   deity.DEITY_ID,
		   DEITY_NAME,
		   deity_seva.SEVA_ID,
		   SEVA_NAME,
		   CONCAT('Rs. ',sum(LOSS_BALANCE),'/-') AS ACCUMULATED_LOSS ");

			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
					$this->db->like('SM_NAME',$name_phone,'both');	
				} else {
					$this->db->like('SM_PHONE',$name_phone,'after');
				}
			}
			if($date != '' ) {
					$this->db->where('SO_DATE',$date,'after');	
			}
			$this->db->from('SHASHWATH_MEMBERS');
			$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
			$this->db->join('DEITY','DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID');
			$this->db->join('DEITY_SEVA','DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID');
			$this->db->join('DEITY_SEVA_OFFERED','DEITY_SEVA_OFFERED.SS_ID = SHASHWATH_SEVA.SS_ID');
			//$this->db->where("date_format(STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y'),'%Y-%m-%d') < date_format(STR_TO_DATE('$date','%d-%m-%Y'),'%Y-%m-%d')");
			$this->db->where('deity_seva_offered.SEVA_LOSS_CONFIRMED','0');
			$this->db->where('LOSS_BALANCE > ','0');
			$this->db->group_by('SHASHWATH_SEVA.SS_ID'); 
			$query = $this->db->get(); 
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    }   	   		   
		}
		
		
		function count_LossReport_Rows($date='',$name_phone = '') {
			$filter = "AND 1";
			
			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
				$filter = "AND SM_NAME LIKE '$name_phone%'";
				} else {
				$filter = "AND SM_PHONE LIKE '$name_phone%'";	
				}
			}
			if($date != '' ) {
				$date = "AND SO_DATE='$date'";
					
			}
			
			$sql = "SELECT shashwath_seva.SS_ID,
			       SO_DATE,
				   shashwath_members.SM_ID,
				   IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				   deity.DEITY_ID,
				   DEITY_NAME,
				   deity_seva.SEVA_ID,
				   SEVA_NAME,
				   CONCAT('Rs. ',sum(LOSS_BALANCE),'/-') AS ACCUMULATED_LOSS  
				   FROM shashwath_members 
				   INNER JOIN shashwath_seva ON shashwath_members.SM_ID = shashwath_seva.SM_ID 
				   INNER JOIN deity_seva_offered ON shashwath_seva.SS_ID = deity_seva_offered.SS_ID 
				   INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
				   INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
				   WHERE deity_seva_offered.SEVA_LOSS_CONFIRMED = 0 AND LOSS_BALANCE > 0 ".$filter." $date GROUP BY shashwath_seva.SS_ID";

			$query = $this->db->query($sql);
				//echo $this->db->last_query();
			if ($query->num_rows() > 0){
				return $query->num_rows();
			} else {
				return false;
			}
		}

		function getShashwathSevas_print($date,$thithi_where_condition,$ROI,$combo='',$sevaCombo='',$oneYrLessSelDate){
			$filter = "AND 1 ";
			if($name_phone != '' || $name_phone == 0) {
				if($name_phone != '' && $name_phone == 0) {
					if(!is_numeric($name_phone)){
						$filter = "AND SM_NAME LIKE '$name_phone%'";
					} else {
						$filter = "AND SM_PHONE LIKE '$name_phone%'";	
					}
				}
			}

			if($combo!=''){
				$filter .= " AND shashwath_seva.DEITY_ID=$combo";
			}
			if($sevaCombo!=''){
				$filter .= " AND shashwath_seva.SEVA_ID=$sevaCombo";
			}

			$sql = "SELECT shashwath_seva.SS_ID, SUM(deity_receipt.RECEIPT_PRICE) AS SEVA_CORPUS,RECEIPT_NAKSHATRA,RECEIPT_PHONE,RECEIPT_DATE,RECEIPT_NO,deity_seva.SEVA_NAME,IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)) AS SEVA_AMT,THITHI_CODE,
				IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				deity.DEITY_NAME,
				CONCAT(deity_seva.SEVA_NAME,' (Rs. ',IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)),'/-)') AS SEVA_PRICE,
				SEVA_QTY,
				IF(REVISION_STATUS = 0,SEVA_PRICE,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE,OLD_PRICE)) AS SEVA_COST,
				IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)) AS TOTAL_SEVA_COST,  
				CONCAT('Rs. ',SUM(deity_receipt.RECEIPT_PRICE),'/- ',' (Rs. ',ROUND((SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * ('$ROI')/100)),'/-)') AS PRINCIPAL_INTEREST, 
				IF(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,
				CONCAT('Rs. ',(ROUND(SUM(deity_receipt.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1,' /-'),
				CONCAT('Rs. 0/-')) AS SEVA_LOSS , 

				CONCAT('Rs. ',(SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0)
				FROM deity_seva_offered
				WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID),'/-') AS ACCUMULATED_LOSS,

				CONCAT('Rs. ',((SELECT COALESCE(SUM(deity_seva_offered.LOSS_BALANCE),0) FROM deity_seva_offered WHERE deity_seva_offered.SS_ID = shashwath_seva.SS_ID) + (IF(ROUND(SUM(DEITY_RECEIPT.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)) < 0,(ROUND(SUM(DEITY_RECEIPT.RECEIPT_PRICE)/NO_OF_SEVAS * (('$ROI')/100)) - IF(REVISION_STATUS = 0,SEVA_PRICE*SEVA_QTY,IF(STR_TO_DATE('$date','%d-%m-%Y') >= STR_TO_DATE(REVISION_DATE,'%d-%m-%Y'),SEVA_PRICE*SEVA_QTY,OLD_PRICE*SEVA_QTY)))*-1,0))),'/-') AS TOTAL_LOSS, 
				deity_seva.SEVA_TYPE,NO_OF_SEVAS

				FROM shashwath_seva INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
				INNER JOIN shashwath_members ON shashwath_members.SM_ID = shashwath_seva.SM_ID
				INNER JOIN deity ON deity.DEITY_ID = shashwath_seva.DEITY_ID
				INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID
				INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID
				WHERE (".$thithi_where_condition.") AND SEVA_PRICE_ACTIVE = 1  AND shashwath_seva.SS_STATUS = 1 AND PAYMENT_STATUS!='Cancelled' AND RECEIPT_CATEGORY_ID = 7 ".$filter." AND (STR_TO_DATE(SS_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('$oneYrLessSelDate','%d-%m-%Y')) GROUP BY shashwath_seva.SS_ID ORDER BY deity.DEITY_ID ";		
			
			$query = $this->db->query($sql);
			return $query->result('array');
		}

		function getDetailedLoss($date,$ssId,$num,$start,$soId,$todayDate){
			$sql="SELECT shashwath_seva.SS_ID,
				  shashwath_members.SM_ID,
				  shashwath_seva.SS_RECEIPT_NO,shashwath_members.SM_REF, shashwath_members.SM_NAME, shashwath_members.SM_PHONE, shashwath_members.SM_PHONE2,shashwath_members.SM_ADDR1, shashwath_members.SM_ADDR2, shashwath_members.SM_CITY, shashwath_members.SM_STATE, shashwath_members.SM_COUNTRY,shashwath_members.SM_PIN,

				  GROUP_CONCAT(deity_seva_offered.SO_ID) AS SO_ID,
				  deity_seva_offered.SO_DATE, 
			      (CASE WHEN MONTH(STR_TO_DATE(SO_DATE,'%d-%m-%Y')) >= 4 AND MONTH(STR_TO_DATE(SO_DATE,'%d-%m-%Y')) <= 12 THEN
			       concat(YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y')), '-',YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y'))+1)
			   		ELSE concat(YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y'))-1,'-', YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y'))) END) AS FINANCIAL_YEAR,
			        GROUP_CONCAT(LOSS_BALANCE) AS SEVA_LOSS,SUM(LOSS_BALANCE) AS SUM_SEVA_LOSS,CAL_TYPE, 

				  IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				  deity.DEITY_ID,
				  (SELECT DISTINCT CAL_ROI FROM calendar INNER JOIN calendar_year_breakup ON calendar_year_breakup.CAL_ID = calendar.CAL_ID WHERE calendar.CAL_ID = (SELECT CAL_ID FROM calendar WHERE (STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) ORDER BY CAL_ID DESC LIMIT 1) AND ENG_DATE = '$date') AS ROI,
				  DEITY_NAME,
				  deity_seva.SEVA_ID,
				  SEVA_NAME,
				  SEVA_CORPUS AS SEVA_CORPUS,
				  SUM(SEVA_INTEREST) AS SEVA_INTEREST, 
				  SO_PRICE,COUNT(SO_PRICE) AS NUMSEVAS,
				  SO_QUANTITY AS SEVA_QTY,
				  (SO_PRICE*SO_QUANTITY) AS SEVA_COST,
				  ((SO_PRICE*SO_QUANTITY)*COUNT(SO_PRICE)) AS TOTAL_SEVA_COST,
				  (SELECT CONCAT('Rs. ',SUM(LOSS_BALANCE),'/-') from deity_seva_offered INNER JOIN SHASHWATH_SEVA ON deity_seva_offered.SS_ID = shashwath_seva.SS_ID WHERE SHASHWATH_SEVA.SS_ID = '$ssId') AS TOTAL_LOSS,
				  (SELECT SUM(RECEIPT_PRICE) from deity_receipt WHERE deity_receipt.SS_ID = '$ssId') AS TOTAL_CORP,NO_OF_SEVAS,SHASH_PRICE,
				  SO_DEITY_NAME,SO_SEVA_NAME,deity_seva_price.SEVA_PRICE as SHASH_SEVA_COST
				  FROM shashwath_members 
				  INNER JOIN shashwath_seva ON shashwath_members.SM_ID = shashwath_seva.SM_ID 
				  INNER JOIN deity_seva_offered ON shashwath_seva.SS_ID = deity_seva_offered.SS_ID 
				  INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
				  INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
				  INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID
				  WHERE shashwath_seva.SS_ID ='$ssId' AND SEVA_PRICE_ACTIVE=1 GROUP BY FINANCIAL_YEAR ORDER BY STR_TO_DATE(SO_DATE,'%d-%m-%Y') ASC LIMIT $start, $num ";
				  //  WHERE  STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$todayDate','%d-%m-%Y') AND shashwath_seva.SS_ID ='$ssId' AND SEVA_PRICE_ACTIVE=1 GROUP BY FINANCIAL_YEAR ORDER BY STR_TO_DATE(SO_DATE,'%d-%m-%Y') ASC LIMIT $start, $num ";
				  $query = $this->db->query($sql);
				 //return $sql;
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    } 
				  
		}

		function getLossPaid($ssId){
			$sql ="SELECT IF(SUM(AMOUNT) IS NULL,0,SUM(AMOUNT)) as Total FROM `shashwath_loss_paid` where SLP_SS_ID='$ssId'";
			$query = $this->db->query($sql);
			return $query->row()->Total;				
		}

		function loss_pay_details($ssId){
			$this->db->select('RECEIPT_NO,RECEIPT_DATE,shashwath_loss_paid.AMOUNT As AMOUNT')->from('deity_receipt');
			//$this->db->join('SHASHWATH_SEVA','deity_receipt.SS_ID = SHASHWATH_SEVA.SS_ID');
			$this->db->join('shashwath_loss_paid',' deity_receipt.RECEIPT_ID = shashwath_loss_paid.RECEIPT_ID');
			$this->db->where('shashwath_loss_paid.SLP_SS_ID',$ssId);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
			function getMainLossExcelPDFReport($date,$name_phone = '') {
			$this->db->select("shashwath_seva.SS_ID,shashwath_seva.SS_RECEIPT_NO,
			deity_seva_offered.SO_ID, SO_DATE, shashwath_members.SM_ID, CONCAT(SM_NAME,' (',SM_PHONE,')')  AS NAME_PHONE,
			deity.DEITY_ID, DEITY_NAME, deity_seva.SEVA_ID, SEVA_NAME, CONCAT('Rs. ',sum(LOSS_BALANCE),'/-') AS ACCUMULATED_LOSS ");

			if($name_phone != '' || $name_phone == 0) {
				if(!is_numeric($name_phone)){
					$this->db->like('SM_NAME',$name_phone,'after');	
				} else {
					$this->db->like('SM_PHONE',$name_phone,'after');
				}
			}
			if($date != '' ) {
					$this->db->where('SO_DATE',$date,'after');	
			}
			$this->db->from('SHASHWATH_MEMBERS');
			$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
			$this->db->join('DEITY','DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID');
			$this->db->join('DEITY_SEVA','DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID');
			$this->db->join('DEITY_SEVA_OFFERED','DEITY_SEVA_OFFERED.SS_ID = SHASHWATH_SEVA.SS_ID');
			//$this->db->where("date_format(STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y'),'%Y-%m-%d') < date_format(STR_TO_DATE('$date','%d-%m-%Y'),'%Y-%m-%d')");
			$this->db->where('deity_seva_offered.SEVA_LOSS_CONFIRMED','0');
			$this->db->where('LOSS_BALANCE > ','0');
			$this->db->group_by('SHASHWATH_SEVA.SS_ID'); 
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    }   	   		   
		}
		
		function getDetailedLoss_Rows($date,$ssId){
			$sql="SELECT shashwath_seva.SS_ID,
				  shashwath_members.SM_ID,
				  shashwath_seva.SS_RECEIPT_NO,

				  GROUP_CONCAT(deity_seva_offered.SO_ID) AS SO_ID,
				  deity_seva_offered.SO_DATE, 
			      (CASE WHEN MONTH(STR_TO_DATE(SO_DATE,'%d-%m-%Y')) >= 4 AND MONTH(STR_TO_DATE(SO_DATE,'%d-%m-%Y')) <= 12 THEN
			       concat(YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y')), '-',YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y'))+1)
			   		ELSE concat(YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y'))-1,'-', YEAR(STR_TO_DATE(SO_DATE,'%d-%m-%Y'))) END) AS FINANCIAL_YEAR,
			        GROUP_CONCAT(LOSS_BALANCE) AS SEVA_LOSS,SUM(LOSS_BALANCE) AS SUM_SEVA_LOSS,CAL_TYPE, 

				  IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
				  deity.DEITY_ID,
				  (SELECT DISTINCT CAL_ROI FROM calendar INNER JOIN calendar_year_breakup ON calendar_year_breakup.CAL_ID = calendar.CAL_ID WHERE calendar.CAL_ID = (SELECT CAL_ID FROM calendar WHERE (STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) ORDER BY CAL_ID DESC LIMIT 1) AND ENG_DATE = '$date') AS ROI,
				  DEITY_NAME,
				  deity_seva.SEVA_ID,
				  SEVA_NAME,
				  SEVA_CORPUS AS SEVA_CORPUS,
				  SUM(SEVA_INTEREST) AS SEVA_INTEREST, 
				  SO_PRICE,COUNT(SO_PRICE) AS NUMSEVAS,
				  SO_QUANTITY AS SEVA_QTY,
				  (SO_PRICE*SO_QUANTITY) AS SEVA_COST,
				  ((SO_PRICE*SO_QUANTITY)*COUNT(SO_PRICE)) AS TOTAL_SEVA_COST,
				  (SELECT CONCAT('Rs. ',SUM(LOSS_BALANCE),'/-') from deity_seva_offered INNER JOIN SHASHWATH_SEVA ON deity_seva_offered.SS_ID = shashwath_seva.SS_ID WHERE SHASHWATH_SEVA.SS_ID = '$ssId') AS TOTAL_LOSS,
				  (SELECT SUM(RECEIPT_PRICE) from deity_receipt WHERE deity_receipt.SS_ID = '$ssId') AS TOTAL_CORP,NO_OF_SEVAS
				  FROM shashwath_members 
				  INNER JOIN shashwath_seva ON shashwath_members.SM_ID = shashwath_seva.SM_ID 
				  INNER JOIN deity_seva_offered ON shashwath_seva.SS_ID = deity_seva_offered.SS_ID 
				  INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
				  INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
				  WHERE  STR_TO_DATE(deity_seva_offered.SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$date','%d-%m-%Y') AND shashwath_seva.SS_ID ='$ssId' GROUP BY FINANCIAL_YEAR";
			$query = $this->db->query($sql);
			//return $sql;
			if ($query->num_rows() > 0){
				return $query->num_rows();
			} else {
				return false;
			} 
		}

		function addPeriodDetails($data = array()){
			$this->db->insert($this->table_Period,$data);
			return $this->db->insert_id();
		}
		
		function get_period_details(){
			$this->db->select()->from($this->table_Period);
			$rows = $this->db->get();
			return $rows->result();
		}

		function updatePeriodDetails($data = array(),$id){
		
			$this->db->where('SP_ID',$id);
			$this->db->update($this->table_Period,$data);
		}

		//festival code start
		function addFestivalDetails($data = array()){
			$this->db->insert($this->table_Festival,$data);
			return $this->db->insert_id();
		}

		function updateFestivalDetails($data = array(),$id){
			
			$this->db->where('SFS_ID',$id);
			$this->db->update($this->table_Festival,$data);
		}
		//festival code end
		
		function getSevaForDate(){
			$query1 = $this->db->query($query);
			
			if ($query1->num_rows() > 0) {
				return $query1->result();
			} else {
				return array();
			}
		}
		
				//Get Deity
		function getDeties() {
			$where = array(
				'DEITY.DEITY_ACTIVE'=>"1"
			);
			$this->db->select()->from('DEITY')->where($where);
			$query = $this->db->get();
			return $query->result('array');
		}
		
		//Get Deity Sevas
		function getDetiesSevas() {
			$where = array(
				'DEITY_SEVA.SEVA_ACTIVE'=>"1" /*, 'DEITY_SEVA.BOOKING !=' => "1" */
				); 
			
			$where2 = array(
				'DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE'=>"1"
			);

			$strq1 = $this->db->select()->from('DEITY_SEVA')
			->join('DEITY_SEVA_PRICE', 'DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID')
			->where($where)
			->where($where2)
			->where("(SEVA_BELONGSTO = 'Shashwath' OR SEVA_BELONGSTO = 'Deity/Shashwath')")
			->order_by("SEVA_NAME", "asc");
			$query = $this->db->get();			
			return $query->result('array');
		}
		
		//to get thithi
		function getThithi($bomid) {
			$this->db->distinct();
			$this->db->select(" THITHI_NAME,THITHI_CODE")->from('THITHI');
			$this->db->join("BASED_ON_MOON","THITHI.BOM_ID = BASED_ON_MOON.BOM_ID");
			$where = array('BASED_ON_MOON.BOM_ID'=>$bomid);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}
		
		  function getThithi1($bomid) {
			//$this->db->distinct();
			$this->db->select(" THITHI_NAME,THITHI_CODE")->from('THITHI');
			$this->db->join("BASED_ON_MOON","THITHI.BOM_ID = BASED_ON_MOON.BOM_ID");
			$where = array('BASED_ON_MOON.BOM_ID' => $bomid);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}  
		
		//to get masa
		function getMasa() {
			$this->db->select("MASA_NAME,MASA_CODE")->from('MASA');
			$query = $this->db->get();
			return $query->result();
		}
		
		//to get shuddha/bahula
		function getBasedOnMoon() {
			$this->db->select("BOM_NAME,BOM_CODE,BOM_ID")->from('BASED_ON_MOON');
			$query = $this->db->get();
			return $query->result();
		}
		
		function getPeriod() {
			$where = array(
				'P_STATUS'=>"1"
			);
			$this->db->select()->from('SHASHWATH_PERIOD_SETTING')->where($where);
			$query = $this->db->get();
			return $query->result('array');
		}

		//to get Festival
		function getFestival() {
			$this->db->select("SFS_NAME,SFS_ID,SFS_THITHI_CODE")->from('shashwath_festival_setting');
			$query = $this->db->get();
			return $query->result();
		}
		//ends
	
		function get_calendar_details($num,$start){
			$this->db->select("CAL_ID,CAL_ROI,CAL_END_DATE,CAL_START_DATE");
			$this->db->select("IF (STR_TO_DATE(DATE_FORMAT(CURDATE(),'%d-%m-%Y'),'%d-%m-%Y') < STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y'),1,0) AS EDIT_STATUS");
			$this->db->from('CALENDAR');
			$this->db->order_by('CAL_ID','DESC');
			$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//Inbuilt Insert Calendar Records
		function InsertFreshCalendarRecords($data = array()) {
			$this->db->insert($this->table_Cal_Year_Breakup,$data);
			return $this->db->insert_id();
		}

		function updateCalendarDetails($data = array(),$calId){
			$this->db->where('CAL_ID',$calId);
			$this->db->update($this->table_Calendar,$data);
			//echo $this->db->last_query();
		}
		
		//to get number of rows of calendar table
		function count_rows_calendar() {
		$this->db->select()->from($this->table_Calendar);
		$query = $this->db->get();
		return $query->num_rows();
		}
		
			//to  get cal records
		function get_calendar_records($cal_id,$num,$start){
			$this->db->select();
			$this->db->from('calendar_year_breakup');
			$this->db->where('CAL_ID',$cal_id);
			$this->db->order_by('STR_TO_DATE(ENG_DATE,"%d-%m-%Y"), CAL_YEAR_ID');

			//$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return array();
			}
		}
		
		//to get number of rows of calendar year breakup table
		function count_rows_calendar_breakup($cal_id = ''){
			$this->db->where('CAL_ID',$cal_id);
			$this->db->select()->from('calendar_year_breakup');
			$query = $this->db->get();
			return $query->num_rows();
		}
		//existing shashwasth members import
		function get_existing_shashwath_records($num,$start,$reciept_no = ''){
			$this->db->select()->from('shashwath_member_import');
			if($reciept_no != '') 
				$this->db->like('sm_reciept_no',$reciept_no,'after');			
			$this->db->where('sm_status',0);
			$this->db->limit($num,$start);
			$query = $this->db->get();
			if ($query->num_rows() > 0){
				return $query->result("array");
			} else {
				return array();
			}
		}	


		function count_rows_existing_shashwath_member($reciept_no = ''){
			$this->db->select()->from('shashwath_member_import');
			if($reciept_no != '') 
				$this->db->like('sm_reciept_no',$reciept_no,'after');	
			$this->db->where('sm_status',0);
			$query = $this->db->get();
			return $query->num_rows();
		}

		//existing shashwasth members import reciept_name
		function get_existing_shashwath_records_name($num,$start,$reciept_name = ''){
			$this->db->select()->from('shashwath_member_import');
			if($reciept_name != '') 
				$this->db->like('sm_member_name',$reciept_name,'after');			
			$this->db->where('sm_status',0);
			$this->db->limit($num,$start);
			$query = $this->db->get();
			if ($query->num_rows() > 0){
				return $query->result("array");
			} else {
				return array();
			}
		}	
		

		//existing shashwasth members import count reciept_name
		function count_rows_existing_shashwath_member_name($reciept_name = ''){
			$this->db->select()->from('shashwath_member_import');
			if($reciept_name != '') 
				$this->db->like('sm_member_name',$reciept_name,'after');	
			$this->db->where('sm_status',0);
			$query = $this->db->get();
			return $query->num_rows();
		}	

		function membermerge_details(){
			$this->db->select("shashwath_members.SM_ID, SM_REF,SM_NAME");
			$this->db->from('SHASHWATH_MEMBERS');
			$this->db->group_by('shashwath_members.SM_NAME '); 
			$this->db->order_by('SM_APPEAR_STATUS','ASC'); 
			$this->db->order_by('SM_NAME','ASC'); 
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result("array");
			} else {
				return array();
			}
		}

		function get_member_details($num,$start,$name_phone = ''){
			if(is_numeric($name_phone) && strlen($name_phone)<=5){
				$this->db->select('SHASHWATH_SEVA.SM_ID');
				$this->db->from('SHASHWATH_SEVA');
				$this->db->join('DEITY_RECEIPT','SHASHWATH_SEVA.SS_ID = DEITY_RECEIPT.SS_ID');
				$this->db->where('SS_RECEIPT_NO_REF',$name_phone);
				$queryRno = $this->db->get();
				$queryRes = $queryRno->result();

				if ($queryRno->num_rows() > 0) {
					$querySM = "(SHASHWATH_SEVA.SM_ID=".$queryRes[0]->SM_ID;
					for($i=1;$i<$queryRno->num_rows();$i++){
						$querySM .= " OR SHASHWATH_SEVA.SM_ID=".$queryRes[$i]->SM_ID;
					}
					$querySM .= ")";
				} else {
					$querySM = "SHASHWATH_SEVA.SM_ID=0";
				}
				

				$this->db->select("shashwath_members.SM_ID, SM_REF, SS_RECEIPT_NO, SM_NAME,SUM(RECEIPT_PRICE) as corpus,COUNT(DISTINCT(shashwath_seva.SS_ID)) as sevaCount, SM_PHONE, SM_CITY, SM_COUNTRY, SM_RASHI, SM_NAKSHATRA,IF(MIN(SHASHWATH_SEVA.SS_VERIFICATION) = 0,'No','Yes') AS SS_VERIFICATION,GROUP_CONCAT(SS_RECEIPT_NO_REF) AS SS_REC_REF");
				if($name_phone != '' || $name_phone == 0) {
					if(is_numeric($name_phone) && strlen($name_phone)<=5){
						// $this->db->where('DEITY_RECEIPT.SS_RECEIPT_NO_REF',$name_phone);		
						$this->db->where($querySM);
					}
				}
				$this->db->from('SHASHWATH_MEMBERS');
				$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
				$this->db->join('DEITY_RECEIPT','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
				$this->db->where(array('DEITY_RECEIPT.RECEIPT_CATEGORY_ID'=>7));
				$this->db->where('DEITY_RECEIPT.RECEIPT_ACTIVE =','1');
				$this->db->group_by('shashwath_members.SM_ID'); 
				$this->db->order_by('MIN(SHASHWATH_SEVA.SS_VERIFICATION)','ASC');
				$this->db->order_by('SHASHWATH_SEVA.SS_RECEIPT_NO','ASC'); 
				$this->db->limit($num, $start);
				$query = $this->db->get();
			} else {
				$this->db->select("shashwath_members.SM_ID, SM_REF, SS_RECEIPT_NO, SM_NAME,SUM(RECEIPT_PRICE) as corpus,COUNT(DISTINCT(shashwath_seva.SS_ID)) as sevaCount, SM_PHONE, SM_CITY, SM_COUNTRY, SM_RASHI, SM_NAKSHATRA,IF(MIN(SHASHWATH_SEVA.SS_VERIFICATION) = 0,'No','Yes') AS SS_VERIFICATION,GROUP_CONCAT(SS_RECEIPT_NO_REF) AS SS_REC_REF");
				if($name_phone != '' || $name_phone == 0) {
					if(!is_numeric($name_phone)){
						$this->db->like('SM_NAME',$name_phone,'both');	
					}//This code temporarily given for searching old reciept, if number is more than 5 digit then it won't work 
					else if(is_numeric($name_phone) && strlen($name_phone)>=5){
						$this->db->like('SM_PHONE',$name_phone,'both');
					}
				}
				$this->db->from('SHASHWATH_MEMBERS');
				$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
				$this->db->join('DEITY_RECEIPT','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
				$this->db->where(array('DEITY_RECEIPT.RECEIPT_CATEGORY_ID'=>7));
				$this->db->where('DEITY_RECEIPT.RECEIPT_ACTIVE =','1');
				$this->db->group_by('shashwath_members.SM_ID'); 
				$this->db->order_by('MIN(SHASHWATH_SEVA.SS_VERIFICATION)','ASC');
				$this->db->order_by('SHASHWATH_SEVA.SS_RECEIPT_NO','ASC'); 
				 // $this->db->order_by('shashwath_members.SM_ID','ASC'); 
				$this->db->limit($num, $start);
				$query = $this->db->get();
			}
			if ($query->num_rows() > 0) {
				return $query->result("array");
			} else {
				return array();
			}
		}

		
		function count_rows_member($name_phone = '') {
			if(is_numeric($name_phone) && strlen($name_phone)<=5){
				$this->db->select('SHASHWATH_SEVA.SM_ID');
				$this->db->from('SHASHWATH_SEVA');
				$this->db->join('DEITY_RECEIPT','SHASHWATH_SEVA.SS_ID = DEITY_RECEIPT.SS_ID');
				$this->db->where('SS_RECEIPT_NO_REF',$name_phone);
				$queryRno = $this->db->get();
				$queryRes = $queryRno->result();

				if ($queryRno->num_rows() > 0) {
					$querySM = "(SHASHWATH_SEVA.SM_ID=".$queryRes[0]->SM_ID;
					for($i=1;$i<$queryRno->num_rows();$i++){
						$querySM .= " OR SHASHWATH_SEVA.SM_ID=".$queryRes[$i]->SM_ID;
					}
					$querySM .= ")";
				} else {
					$querySM = "SHASHWATH_SEVA.SM_ID=0";
				}
				

				$this->db->select("shashwath_members.SM_ID, SM_REF, SS_RECEIPT_NO, SM_NAME,SUM(RECEIPT_PRICE) as corpus,COUNT(DISTINCT(shashwath_seva.SS_ID)) as sevaCount, SM_PHONE, SM_CITY, SM_COUNTRY, SM_RASHI, SM_NAKSHATRA,IF(MIN(SHASHWATH_SEVA.SS_VERIFICATION) = 0,'No','Yes') AS SS_VERIFICATION,GROUP_CONCAT(SS_RECEIPT_NO_REF) AS SS_REC_REF");
				if($name_phone != '' || $name_phone == 0) {
					if(is_numeric($name_phone) && strlen($name_phone)<=5){
						// $this->db->where('DEITY_RECEIPT.SS_RECEIPT_NO_REF',$name_phone);		
						$this->db->where($querySM);
					}
				}
				$this->db->from('SHASHWATH_MEMBERS');
				$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
				$this->db->join('DEITY_RECEIPT','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
				$this->db->where(array('DEITY_RECEIPT.RECEIPT_CATEGORY_ID'=>7));
				$this->db->where('DEITY_RECEIPT.RECEIPT_ACTIVE =','1');
				$this->db->group_by('shashwath_members.SM_ID'); 
				$this->db->order_by('MIN(SHASHWATH_SEVA.SS_VERIFICATION)','ASC');
				$this->db->order_by('SHASHWATH_SEVA.SS_RECEIPT_NO','ASC'); 
				$query = $this->db->get();
			} else {
				$this->db->select("shashwath_members.SM_ID, SM_REF, SS_RECEIPT_NO, SM_NAME,SUM(RECEIPT_PRICE) as corpus,COUNT(DISTINCT(shashwath_seva.SS_ID)) as sevaCount, SM_PHONE, SM_CITY, SM_COUNTRY, SM_RASHI, SM_NAKSHATRA,IF(MIN(SHASHWATH_SEVA.SS_VERIFICATION) = 0,'No','Yes') AS SS_VERIFICATION,GROUP_CONCAT(SS_RECEIPT_NO_REF) AS SS_REC_REF");
				if($name_phone != '' || $name_phone == 0) {
					if(!is_numeric($name_phone)){
						$this->db->like('SM_NAME',$name_phone,'both');	
					}//This code temporarily given for searching old reciept, if number is more than 5 digit then it won't work 
					else if(is_numeric($name_phone) && strlen($name_phone)>=5){
						$this->db->like('SM_PHONE',$name_phone,'both');
					}
				}
				$this->db->from('SHASHWATH_MEMBERS');
				$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
				$this->db->join('DEITY_RECEIPT','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
				$this->db->where(array('DEITY_RECEIPT.RECEIPT_CATEGORY_ID'=>7));
				$this->db->where('DEITY_RECEIPT.RECEIPT_ACTIVE =','1');
				$this->db->group_by('shashwath_members.SM_ID'); 
				$this->db->order_by('MIN(SHASHWATH_SEVA.SS_VERIFICATION)','ASC');
				$this->db->order_by('SHASHWATH_SEVA.SS_RECEIPT_NO','ASC'); 
				 // $this->db->order_by('shashwath_members.SM_ID','ASC'); 
				$query = $this->db->get();
			}
			return $query->num_rows();
		}
		
		function count_unverifed_rows() {
			$this->db->select();
			$this->db->from('SHASHWATH_SEVA');
			$this->db->where(array('SHASHWATH_SEVA.SS_VERIFICATION' => 0));
			$query = $this->db->get();
			return $query->num_rows();
		}

		function count_unverifed_member_rows() {
			$query = $this->db->query('SELECT shashwath_members.SM_ID,SM_NAME,SM_REF, SM_PHONE, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, SM_RASHI, SM_NAKSHATRA, SM_GOTRA, REMARKS FROM SHASHWATH_MEMBERS JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY_RECEIPT ON DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID WHERE DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 AND DEITY_RECEIPT.RECEIPT_ACTIVE =1 AND SHASHWATH_SEVA.SS_VERIFICATION= 0 GROUP BY shashwath_members.SM_ID ORDER BY SHASHWATH_SEVA.SS_RECEIPT_NO ASC');
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			} 
		}
		
		function member_details($data1='') {
			$this->db->select('shashwath_members.SM_ID, SM_REF, SM_NAME, SM_PHONE, SM_PHONE2, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, SM_RASHI, SM_NAKSHATRA, SM_GOTRA, REMARKS, SHASHWATH_SEVA.SS_ID, SS_REF, SHASHWATH_SEVA.SM_ID, SS_RECEIPT_NO,SS_RECEIPT_NO_REF, SS_RECEIPT_DATE, SHASHWATH_SEVA.DEITY_ID, SHASHWATH_SEVA.SEVA_ID, SEVA_QTY, SHASHWATH_SEVA.SEVA_TYPE, CAL_TYPE, THITHI_CODE, ENG_DATE,SHASHWATH_SEVA.EVERY_WEEK_MONTH, SHASHWATH_SEVA.SP_ID, SHASHWATH_SEVA.SP_COUNTER, SS_STATUS, MASA, BASED_ON_MOON, THITHI_NAME, SHASHWATH_SEVA.SEVA_NOTES, ACCUMULATED_LOSS,SHASHWATH_SEVA.SS_VERIFICATION,DEITY.DEITY_ID, DEITY_CODE, DEITY_NAME, DEITY.DATE_TIME, DEITY.DATE, DEITY.USER_ID, DEITY_ACTIVE,DEITY_SEVA.SEVA_ID, SEVA_CODE, SEVA_NAME, DEITY_SEVA.DEITY_ID, SEVA_DESC, DEITY_SEVA.DATE_TIME, DEITY_SEVA.DATE, DEITY_SEVA.USER_ID, SEVA_ACTIVE, QUANTITY_CHECKER, IS_SEVA, BOOKING, IS_TOKEN, DEITY_SEVA.SEVA_TYPE, SEVA_BELONGSTO,DEITY_RECEIPT.RECEIPT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_NAME, RECEIPT_PHONE, RECEIPT_EMAIL, RECEIPT_ADDRESS, RECEIPT_RASHI, RECEIPT_NAKSHATRA, RECEIPT_DEITY_NAME, RECEIPT_DEITY_ID, SUM(RECEIPT_PRICE) as RECEIPT_PRICE,RECEIPT_PRICE as FIRST_RECEIPT_PRICE, RECEIPT_PAYMENT_METHOD, CHEQUE_NO, CHEQUE_DATE, BANK_NAME, BRANCH_NAME, TRANSACTION_ID, RECEIPT_PAYMENT_METHOD_NOTES, RECEIPT_ISSUED_BY, RECEIPT_ISSUED_BY_ID, DEITY_RECEIPT.DATE_TIME, RECEIPT_ACTIVE, CANCELLED_BY, CANCELLED_BY_ID, CANCELLED_DATE, CANCELLED_DATE_TIME, CANCEL_NOTES, RECEIPT_CATEGORY_ID, PAYMENT_STATUS, PAYMENT_CONFIRMED_BY_NAME, PAYMENT_CONFIRMED_BY, PAYMENT_DATE_TIME, PAYMENT_DATE, AUTHORISED_STATUS, AUTHORISED_BY, AUTHORISED_BY_NAME, AUTHORISED_DATE_TIME, AUTHORISED_DATE, CHEQUE_CREDITED_DATE, DATE_TYPE, IS_BOOKING, RECEIPT_SB_ID, IS_TRUST, RECEIPT_HB_ID, EOD_CONFIRMED_BY_ID, EOD_CONFIRMED_BY_NAME, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, POSTAGE_CHECK, POSTAGE_PRICE, POSTAGE_GROUP_ID, ADDRESS_LINE1, ADDRESS_LINE2, CITY,STATE,COUNTRY, PINCODE, IF(POSTAGE_CHECK = 1,CONCAT(ADDRESS_LINE1,",",IF(ADDRESS_LINE2 = "","",CONCAT(ADDRESS_LINE2,",")),CITY," ",STATE," ",COUNTRY," - ",PINCODE),"") AS POSTAL_ADDR, DEITY_RECEIPT.SS_ID, PRINT_STATUS, IS_JEERNODHARA,SHASHWATH_PERIOD_SETTING.SP_ID, PERIOD_NAME, PERIOD, P_STATUS,COUNT(*) as CORPUS_CNT,SHASH_PRICE,IS_MANDALI,SEVA_PRICE AS SHASH_SEVA_COST,NO_OF_SEVAS')->from('shashwath_members');
			$this->db->join('SHASHWATH_SEVA','SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID');
			$this->db->join('DEITY','DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID');
			$this->db->join('DEITY_SEVA','DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID');
			$this->db->join('DEITY_RECEIPT','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
			$this->db->join('SHASHWATH_PERIOD_SETTING','SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID');
			$this->db->join('deity_seva_price','deity_seva.SEVA_ID = deity_seva_price.SEVA_ID');
			$this->db->where('shashwath_members.SM_ID',$data1);
			$this->db->where('DEITY_RECEIPT.RECEIPT_CATEGORY_ID =','7');
			$this->db->where('DEITY_RECEIPT.RECEIPT_ACTIVE =','1');
			$this->db->where('DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE =','1');
			$this->db->group_by('DEITY_RECEIPT.SS_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}


		function mandali_member_details($SMID='') {
			$this->db->select()->from('shashwath_mandali_member_details');
			if ($SMID!='') {
				$this->db->where('SM_ID',$SMID);
			}			
			$this->db->where('MM_ACTIVE_STATUS',1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}


		function existing_member_details($data1) {
			$this->db->select()->from('shashwath_member_import');
			$this->db->where('shashwath_member_import.SM_ID',$data1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
	
		}
		function corpus_raise_details($SS_ID) {
			$this->db->select('SEVA_QTY, DEITY_NAME, SEVA_NAME, RECEIPT_NO,SS_RECEIPT_NO_REF,RECEIPT_DATE, RECEIPT_PRICE,MM_NAME,IS_MANDALI')->from('deity_receipt');
			$this->db->join('SHASHWATH_SEVA','deity_receipt.SS_ID = SHASHWATH_SEVA.SS_ID');
			$this->db->join('DEITY','DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID');
			$this->db->join('DEITY_SEVA','DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID');
			$this->db->join('shashwath_members','shashwath_members.SM_ID = SHASHWATH_SEVA.SM_ID');
			$this->db->join('shashwath_mandali_member_details','DEITY_RECEIPT.ADDL_MM_PAID_BY = shashwath_mandali_member_details.MM_ID','left');
			$this->db->where('DEITY_RECEIPT.RECEIPT_ACTIVE =','1');
			$this->db->where('deity_receipt.SS_ID ',$SS_ID);
			$this->db->where('deity_receipt.RECEIPT_CATEGORY_ID ',7);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		
		function seva_Offered_No_Price_Count($fromDate){
			$query = $this->db->query("SELECT SO_PRICE,SO_DEITY_NAME,SO_DATE,SO_SEVA_NAME,shashwath_seva.SS_ID,SO_ID,SM_NAME,SM_PHONE FROM deity_seva_offered INNER JOIN shashwath_seva ON  deity_seva_offered.SS_ID = shashwath_seva.SS_ID INNER JOIN shashwath_members ON shashwath_members.SM_ID =shashwath_seva.SM_ID WHERE STR_TO_DATE(SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$fromDate','%d-%m-%Y') AND SO_PRICE = 0 AND RECEIPT_CATEGORY_ID = 7");
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}  
		}
		
		
		function addSevaPrice($date,$num,$start){
			$query = $this->db->query("SELECT SO_PRICE,SO_DEITY_NAME,SO_DATE,SO_SEVA_NAME,shashwath_seva.SS_ID,SO_ID,SM_NAME,SM_PHONE FROM deity_seva_offered INNER JOIN shashwath_seva ON  deity_seva_offered.SS_ID = shashwath_seva.SS_ID INNER JOIN shashwath_members ON shashwath_members.SM_ID =shashwath_seva.SM_ID WHERE STR_TO_DATE(SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$date','%d-%m-%Y') AND SO_PRICE = 0 AND RECEIPT_CATEGORY_ID = 7 LIMIT $start, $num");
			
			 if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}  
		}
		/* function update_member_details($data1) {
			
			$data = array(
			'SM_NAME' => $_POST['name'],
			'SM_PHONE' => $_POST['phone'],
			'SM_RASHI' => $_POST['rashi'],
			'SM_NAKSHATRA' => $_POST['nakshatra'],
			'SM_ADDR1' => $_POST['addrline1'],
			'SM_ADDR1' => $_POST['addrline2'],
			'SM_CITY' => $_POST['smcity'],
			'SM_STATE' => $_POST['smstate'],
			'SM_COUNTRY' => $_POST['smcountry'],
			'SM_PIN' => $_POST['smpin'],
			'REMARKS' => $_POST['smremarks']
		);
		$this->db->update('shashwath_members',$data);
		$this->db->where('SM_ID',$data1);
		$query = $this->db->get();
		return $query->result();
		
		} */

		function get_all_payment_method_details(){
	  		$sql ="SELECT * FROM `deity_receipt` where STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (RECEIPT_PAYMENT_METHOD='Direct Credit' OR RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND FGLH_ID = 0 ORDER BY `deity_receipt`.`RECEIPT_DATE` ASC";
	  		$query= $this->db->query($sql);
			return $query->result();
	  	}
	  	
	  	function get_banks() {
			//bank 															//laz
			$this->db->from('finacial_group_ledger_heads');
			$this->db->where('FGLH_PARENT_ID',9);
			$query = $this->db->get();									   //laz..
			return $query->result();
		}

		function update_all_payment_method_bank_details($RECEIPT_ID,$tobank){
			$sql ="UPDATE `deity_receipt` SET FGLH_ID = '$tobank'  WHERE RECEIPT_ID = $RECEIPT_ID" ; 
	  		$this->db->query($sql);
		}

		function count_rows_bank_details() {
			$sql="SELECT * FROM `deity_receipt` where STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (RECEIPT_PAYMENT_METHOD='Direct Credit' OR RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND FGLH_ID = 0 ORDER BY `deity_receipt`.`RECEIPT_DATE` ASC";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

	function getfinyear() { 													//prathiksha code
		$this->db->select("MONTH_IN_YEAR")->from('financial_year');
		return $this->db->get()->row()->MONTH_IN_YEAR;
	}
	
	function getfinmonth() { 													//prathiksha code
		$this->db->select("MONTH_IN_NUMBER")->from('financial_year');
		return $this->db->get()->row()->MONTH_IN_NUMBER;
	}

	function getDuplicateRecords($engDate){
		$sql="SELECT CAL_YEAR_ID,CAL_ID,THITHI_SHORT_CODE,DUPLICATE,ENG_DATE FROM `calendar_year_breakup` WHERE ENG_DATE='$engDate'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getExcistingDuplicateRecords($calyid){
		$sql="SELECT CAL_YEAR_ID,CAL_ID,THITHI_SHORT_CODE,DUPLICATE,ENG_DATE FROM `calendar_year_breakup` WHERE CAL_YEAR_ID=$calyid";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function  get_masa_month($num,$start,$filter,$masa,$nameCondition='') {
		$sql = "SELECT shashwath_seva.SS_ID,SS_RECEIPT_NO,
			    shashwath_members.SM_NAME, shashwath_members.SM_ID,
			    CONCAT(SM_ADDR1,' ',SM_ADDR2,' ',SM_CITY,' ',SM_PIN) AS Address,
			    SM_CITY As PLACE,LEFT(THITHI_CODE,5) as leftRno,
			    THITHI_CODE,shashwath_seva.ENG_DATE,EVERY_WEEK_MONTH,SEVA_NOTES,shashwath_seva.DEITY_ID,shashwath_seva.SEVA_ID,";
		$sql .=	"deity.DEITY_NAME, 
			    DEITY_SEVA.SEVA_NAME,
			    SEVA_QTY,
			    SUM(RECEIPT_PRICE) AS CORPUS
			    FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID 
                       JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID 
                       JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID               
                       INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID ";
		$sql .= " WHERE ".$filter." $nameCondition GROUP BY shashwath_seva.SS_ID
		 			ORDER BY shashwath_seva.ENG_DATE,leftRno DESC,THITHI_CODE ASC,MERGE_STATUS,shashwath_seva.SS_ID ";
		$sql .= "LIMIT $start, $num"; 	
		$query = $this->db->query($sql);
		return $query->result("array");
	}

	// function get_masa_month($num,$start,$filter,$masa,$nameCondition='') {
	// 	$sql = "SELECT shashwath_seva.SS_ID,
	// 		    shashwath_members.SM_NAME, shashwath_members.SM_ID,
	// 		    CONCAT(SM_ADDR1,' ',SM_ADDR2,' ',SM_CITY,' ',SM_PIN) AS Address,
	// 		    SM_CITY As PLACE,shashwath_seva.ENG_DATE
	// 		    THITHI_CODE, ";
	// 	$sql .=	"deity.DEITY_NAME, 
	// 		    DEITY_SEVA.SEVA_NAME,
	// 		    SEVA_QTY,
	// 		    SUM(RECEIPT_PRICE) AS CORPUS
	// 		    FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID 
 //                       JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID 
 //                       JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID 
 //                       JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID 
 //                       INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID ";
                   
	// 	$sql .= " WHERE ".$filter." $nameCondition GROUP BY shashwath_seva.SS_ID
	// 			ORDER BY shashwath_seva.ENG_DATE,THITHI_CODE ";
	// 	$sql .= "LIMIT $start, $num"; 	
	// 	$query = $this->db->query($sql);
	// 	return $query->result("array");
	// }

	function get_masa_month_search($filter,$masa,$condsrch = ""){
		$sql = "SELECT shashwath_members.SM_NAME,shashwath_members.SM_ID FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID  WHERE $filter $condsrch GROUP BY shashwath_members.SM_NAME ORDER BY SM_NAME ASC"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return "";
		}
	}

	function get_masa_month_count($filter,$masa,$nameCondition=''){
		$sql = "SELECT shashwath_members.SM_ID FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID 
               INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID ";       
		$sql .= " WHERE ".$filter." $nameCondition GROUP BY shashwath_seva.SS_ID";			
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function member_details_for_corpus_issue($mergeCondition) {
		$sql ="SELECT shashwath_members.SM_ID,IS_MANDALI,SM_REF,SM_NAME,ADDL_MM_PAID_BY,MM_NAME,MM_ID,SM_PHONE, SM_PHONE2, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, SM_RASHI, SM_NAKSHATRA, SM_GOTRA, REMARKS, SHASHWATH_SEVA.SS_ID, SS_REF, SHASHWATH_SEVA.SM_ID, SS_RECEIPT_NO, SS_RECEIPT_DATE, SHASHWATH_SEVA.DEITY_ID, SHASHWATH_SEVA.SEVA_ID, SEVA_QTY, SHASHWATH_SEVA.SEVA_TYPE, CAL_TYPE, THITHI_CODE, ENG_DATE, SHASHWATH_SEVA.EVERY_WEEK_MONTH, SHASHWATH_SEVA.SP_ID, SHASHWATH_SEVA.SP_COUNTER, SS_STATUS, MASA, BASED_ON_MOON, THITHI_NAME, SHASHWATH_SEVA.SEVA_NOTES, ACCUMULATED_LOSS, SHASHWATH_SEVA.SS_VERIFICATION, DEITY.DEITY_ID, DEITY_CODE, DEITY_NAME, DEITY.DATE_TIME, DEITY.DATE, DEITY.USER_ID, DEITY_ACTIVE, DEITY_SEVA.SEVA_ID, SEVA_CODE, SEVA_NAME, DEITY_SEVA.DEITY_ID, SEVA_DESC, DEITY_SEVA.DATE_TIME, DEITY_SEVA.DATE, DEITY_SEVA.USER_ID, SEVA_ACTIVE, QUANTITY_CHECKER, IS_SEVA, BOOKING, IS_TOKEN, DEITY_SEVA.SEVA_TYPE, SEVA_BELONGSTO, DEITY_RECEIPT.RECEIPT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_NAME, RECEIPT_PHONE, RECEIPT_EMAIL, RECEIPT_ADDRESS, RECEIPT_RASHI, RECEIPT_NAKSHATRA, RECEIPT_DEITY_NAME, RECEIPT_DEITY_ID, SUM(RECEIPT_PRICE) as RECEIPT_PRICE, RECEIPT_PAYMENT_METHOD, CHEQUE_NO, CHEQUE_DATE, BANK_NAME, BRANCH_NAME, TRANSACTION_ID, RECEIPT_PAYMENT_METHOD_NOTES, RECEIPT_ISSUED_BY, RECEIPT_ISSUED_BY_ID, DEITY_RECEIPT.DATE_TIME, RECEIPT_ACTIVE, CANCELLED_BY, CANCELLED_BY_ID, CANCELLED_DATE, CANCELLED_DATE_TIME, CANCEL_NOTES, RECEIPT_CATEGORY_ID, PAYMENT_STATUS, PAYMENT_CONFIRMED_BY_NAME, PAYMENT_CONFIRMED_BY, PAYMENT_DATE_TIME, PAYMENT_DATE, AUTHORISED_STATUS, AUTHORISED_BY, AUTHORISED_BY_NAME, AUTHORISED_DATE_TIME, AUTHORISED_DATE, CHEQUE_CREDITED_DATE, DATE_TYPE, IS_BOOKING, RECEIPT_SB_ID, IS_TRUST, RECEIPT_HB_ID, EOD_CONFIRMED_BY_ID, EOD_CONFIRMED_BY_NAME, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, POSTAGE_CHECK, POSTAGE_PRICE, POSTAGE_GROUP_ID, ADDRESS_LINE1, ADDRESS_LINE2, CITY, STATE, COUNTRY, PINCODE, IF(POSTAGE_CHECK = 1, CONCAT(ADDRESS_LINE1, ', ', IF(ADDRESS_LINE2 = '', '', CONCAT(ADDRESS_LINE2, ', ')), CITY, ' ', STATE, ' ', COUNTRY, ' - ', PINCODE), '') AS POSTAL_ADDR, DEITY_RECEIPT.SS_ID, PRINT_STATUS, IS_JEERNODHARA, SHASHWATH_PERIOD_SETTING.SP_ID, PERIOD_NAME, PERIOD, P_STATUS, COUNT(*) as CORPUS_CNT, SHASH_PRICE FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID JOIN DEITY_RECEIPT ON DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID left JOIN shashwath_mandali_member_details on DEITY_RECEIPT.ADDL_MM_PAID_BY=shashwath_mandali_member_details.MM_ID JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID WHERE DEITY_RECEIPT.RECEIPT_CATEGORY_ID = '7' AND DEITY_RECEIPT.RECEIPT_ACTIVE = '1' AND DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE = '1' $mergeCondition GROUP BY DEITY_RECEIPT.SS_ID  ORDER BY  STR_TO_DATE( shashwath_seva.SS_RECEIPT_DATE,'%d-%m-%Y')";
		
		$query = $this->db->query($sql);	
		return $query->result();
	}


	function member_details_for_totalCorpus($mergeCondition){
		$sql ="SELECT SUM(RECEIPT_PRICE) as Total_Price FROM `deity_receipt` JOIN shashwath_seva on DEITY_RECEIPT.SS_ID =shashwath_seva.SS_ID join shashwath_members on shashwath_seva.SM_ID =shashwath_members.SM_ID where DEITY_RECEIPT.RECEIPT_CATEGORY_ID = '7' $mergeCondition";
		$query= $this->db->query($sql);
		return $query->row()->Total_Price;
	}

	function deletingShashwathSeva($deleteSSID,$deleteReceiptId,$deleteSeavaReason,$dateTime,$userId) {
		$dateTime = date('d-m-Y H:i:s A');
		$sql1="SELECT * FROM deity_receipt where SS_ID= $deleteSSID";
		$query1 = $this->db->query($sql1);
		$deity_receipt_result =  $query1->result();
		$sql2="SELECT * FROM shashwath_seva where SS_ID= $deleteSSID";
		$query2 = $this->db->query($sql2);
		$shashwath_seva_result =  $query2->result();

		$SM_ID = $shashwath_seva_result[0]->SM_ID;
		$SS_REF = $shashwath_seva_result[0]->SS_REF;
		$SS_RECEIPT_NO = $shashwath_seva_result[0]->SS_RECEIPT_NO;
		$SEVA_ID = $shashwath_seva_result[0]->SEVA_ID;
		$DEITY_ID = $shashwath_seva_result[0]->DEITY_ID;
		$QTY = $shashwath_seva_result[0]->SEVA_QTY;
		$SEVA_TYPE = $shashwath_seva_result[0]->SEVA_TYPE;
		$CAL_TYPE = $shashwath_seva_result[0]->CAL_TYPE;
		if ($CAL_TYPE == "Gregorian") {
			$THITHI_CODE_ENG_DATE = $shashwath_seva_result[0]->ENG_DATE;
		} else {
			$THITHI_CODE_ENG_DATE = $shashwath_seva_result[0]->THITHI_CODE;
		}
		
		foreach($deity_receipt_result as $res) {
			$RECEIPT_ID = $res->RECEIPT_ID;
			$RECEIPT_NO = $res->RECEIPT_NO;
			$RECEIPT_DATE = $res->RECEIPT_DATE;
			$RECEIPT_PRICE = $res->RECEIPT_PRICE;
			$sql3="INSERT INTO shashwath_seva_delete_history(`SS_ID`, `SM_ID`, `SS_REF`, `SS_RECEIPT_NO`, `SEVA_ID`, `DEITY_ID`, `QTY`, `SEVA_TYPE`, `CAL_TYPE`, `THITHI_CODE_ENG_DATE`, `RECEIPT_ID`, `RECEIPT_NO`, `RECEIPT_DATE`, `RECEIPT_PRICE`, `DELETE_REASON`, `DELETED_DATE_TIME`, `DELETED_BY`)
			 VALUES
			 ($deleteSSID,$SM_ID,$SS_REF,'$SS_RECEIPT_NO',$SEVA_ID,$DEITY_ID,$QTY,'$SEVA_TYPE','$CAL_TYPE','$THITHI_CODE_ENG_DATE',$RECEIPT_ID,'$RECEIPT_NO','$RECEIPT_DATE',$RECEIPT_PRICE,'$deleteSeavaReason','$dateTime',$userId)";
			 $query3 = $this->db->query($sql3);
		}

		$this ->db->select('shashwath_members.SM_ID,SM_NAME, SM_PHONE, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, REMARKS')->from('shashwath_members')
		->where('shashwath_members.SM_ID', $SM_ID);
		$queryMember = $this->db->get();
		$memberData = $queryMember->result();
		$adres = ($memberData[0]->SM_ADDR1.",").($memberData[0]->SM_ADDR2.",").($memberData[0]->SM_CITY.",").($memberData[0]->SM_STATE.",").($memberData[0]->SM_COUNTRY.",").($memberData[0]->SM_PIN);
		$dataSmDelete = array (	
			'SM_ID' => $memberData[0]->SM_ID,
			'SM_NAME' => $memberData[0]->SM_NAME,
			'SM_PHONE' =>  $memberData[0]->SM_PHONE,
			'SM_ADDR' => $adres,
			'SM_REMARK' => $memberData[0]->REMARKS,
			'DELETED_BY'=> $_SESSION['userId'],
			'DELETED_DATE_TIME' => $dateTime
		);

		$sql4="DELETE From deity_receipt where SS_ID= $deleteSSID";	
		$query4 = $this->db->query($sql4);

		$sql5="DELETE From shashwath_seva where SS_ID= $deleteSSID";	
		$query5 = $this->db->query($sql5);

		$sql6 ="SELECT SS_ID FROM shashwath_seva  where SM_ID = $SM_ID";
		$query6 = $this->db->query($sql6);
		if($query6->num_rows() < 1) {
			$sql7 = "DELETE FROM shashwath_members where SM_ID = $SM_ID";
			$query7 = $this->db->query($sql7);
			$this->db->insert('shashwath_member_delete_history',$dataSmDelete);
			redirect('Shashwath/shashwath_member');
		}
	}	

	function getSmReferenceIssue(){
  		$sql ="Select * from(SELECT SM_ID,SM_REF,SM_NAME FROM shashwath_members) as tbl1 join
		(SELECT shashwath_members.SM_ID,shashwath_seva.SS_ID,SM_REF,SS_REF,@myLeft  := SUBSTRING_INDEX(RECEIPT_NO,'M',-1)as rno,SUBSTRING_INDEX(@myLeft ,'/S',1) as smRefID,shashwath_seva.SS_RECEIPT_NO,SS_ENTERED_BY_ID,SS_ENTERED_DATE_TIME,RECEIPT_NO FROM `shashwath_seva` JOIN shashwath_members on shashwath_members.SM_ID = shashwath_seva.SM_ID JOIN deity_receipt on deity_receipt.SS_ID = shashwath_seva.SS_ID )as tbl2
		on tbl1.SM_ID = tbl2.SM_ID where tbl1.SM_REF != tbl2.smRefID  
		ORDER BY STR_TO_DATE(`tbl2`.`SS_ENTERED_DATE_TIME`, '%d-%m-%Y') ASC";

  		$query= $this->db->query($sql);
		return $query->result();
  	}

  		function get_filter_member($num, $start = 0,$nameCondition=''){ 
	  	$sql = "SELECT shashwath_members.SM_NAME,shashwath_members.SM_ID,SM_REF,SS_RECEIPT_NO, SM_PHONE, SM_CITY, SM_COUNTRY,shashwath_seva.SS_ID,SUM(RECEIPT_PRICE) as corpus,COUNT(DISTINCT(shashwath_seva.SS_ID)) as sevaCount,CONCAT(SM_ADDR1,',',SM_ADDR2,',',SM_CITY,',',SM_STATE,',',SM_COUNTRY,',',SM_PIN,'')  AS ADDRESS FROM shashwath_members join `shashwath_seva` on shashwath_members.SM_ID = shashwath_seva.SM_ID join deity_receipt on deity_receipt.SS_ID =shashwath_seva.SS_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID  WHERE $nameCondition GROUP BY shashwath_members.SM_ID ORDER BY  STR_TO_DATE( shashwath_seva.SS_RECEIPT_DATE,'%d-%m-%Y') LIMIT $start, $num"; 
		$query = $this->db->query($sql);
		return $query->result("array");
	}

	function get_filter_member_count($nameCondition=''){
		$sql = "SELECT shashwath_members.SM_NAME,shashwath_members.SM_ID,SM_REF,SS_RECEIPT_NO, SM_PHONE, SM_CITY, SM_COUNTRY,shashwath_seva.SS_ID,SUM(RECEIPT_PRICE) as corpus,COUNT(DISTINCT(shashwath_seva.SS_ID)) as sevaCount,CONCAT(SM_ADDR1,',',SM_ADDR2,',',SM_CITY,',',SM_STATE,',',SM_COUNTRY,',',SM_PIN,'')  AS ADDRESS FROM shashwath_members join `shashwath_seva` on shashwath_members.SM_ID = shashwath_seva.SM_ID join deity_receipt on deity_receipt.SS_ID =shashwath_seva.SS_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID  WHERE $nameCondition GROUP BY shashwath_members.SM_ID ORDER BY  STR_TO_DATE( shashwath_seva.SS_RECEIPT_DATE,'%d-%m-%Y') ";           		
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function member_details_for_member_merge($mergeCondition) {
		$sql ="SELECT shashwath_members.SM_ID, SM_REF, SM_NAME, SM_PHONE, SM_PHONE2, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, SM_RASHI, SM_NAKSHATRA, SM_GOTRA, REMARKS, SHASHWATH_SEVA.SS_ID, SS_REF, SHASHWATH_SEVA.SM_ID, SS_RECEIPT_NO, SS_RECEIPT_DATE, SHASHWATH_SEVA.DEITY_ID, SHASHWATH_SEVA.SEVA_ID, SEVA_QTY, SHASHWATH_SEVA.SEVA_TYPE, CAL_TYPE, THITHI_CODE, ENG_DATE, SHASHWATH_SEVA.EVERY_WEEK_MONTH, SHASHWATH_SEVA.SP_ID, SHASHWATH_SEVA.SP_COUNTER, SS_STATUS, MASA, BASED_ON_MOON, THITHI_NAME, SHASHWATH_SEVA.SEVA_NOTES, ACCUMULATED_LOSS, SHASHWATH_SEVA.SS_VERIFICATION, DEITY.DEITY_ID, DEITY_CODE, DEITY_NAME, DEITY.DATE_TIME, DEITY.DATE, DEITY.USER_ID, DEITY_ACTIVE, DEITY_SEVA.SEVA_ID, SEVA_CODE, SEVA_NAME, DEITY_SEVA.DEITY_ID, SEVA_DESC, DEITY_SEVA.DATE_TIME, DEITY_SEVA.DATE, DEITY_SEVA.USER_ID, SEVA_ACTIVE, QUANTITY_CHECKER, IS_SEVA, BOOKING, IS_TOKEN, DEITY_SEVA.SEVA_TYPE, SEVA_BELONGSTO, DEITY_RECEIPT.RECEIPT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_NAME, RECEIPT_PHONE, RECEIPT_EMAIL, RECEIPT_ADDRESS, RECEIPT_RASHI, RECEIPT_NAKSHATRA, RECEIPT_DEITY_NAME, RECEIPT_DEITY_ID, SUM(RECEIPT_PRICE) as RECEIPT_PRICE, RECEIPT_PAYMENT_METHOD, CHEQUE_NO, CHEQUE_DATE, BANK_NAME, BRANCH_NAME, TRANSACTION_ID, RECEIPT_PAYMENT_METHOD_NOTES, RECEIPT_ISSUED_BY, RECEIPT_ISSUED_BY_ID, DEITY_RECEIPT.DATE_TIME, RECEIPT_ACTIVE, CANCELLED_BY, CANCELLED_BY_ID, CANCELLED_DATE, CANCELLED_DATE_TIME, CANCEL_NOTES, RECEIPT_CATEGORY_ID, PAYMENT_STATUS, PAYMENT_CONFIRMED_BY_NAME, PAYMENT_CONFIRMED_BY, PAYMENT_DATE_TIME, PAYMENT_DATE, AUTHORISED_STATUS, AUTHORISED_BY, AUTHORISED_BY_NAME, AUTHORISED_DATE_TIME, AUTHORISED_DATE, CHEQUE_CREDITED_DATE, DATE_TYPE, IS_BOOKING, RECEIPT_SB_ID, IS_TRUST, RECEIPT_HB_ID, EOD_CONFIRMED_BY_ID, EOD_CONFIRMED_BY_NAME, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, POSTAGE_CHECK, POSTAGE_PRICE, POSTAGE_GROUP_ID, ADDRESS_LINE1, ADDRESS_LINE2, CITY, STATE, COUNTRY, PINCODE, IF(POSTAGE_CHECK = 1, CONCAT(ADDRESS_LINE1, ', ', IF(ADDRESS_LINE2 = '', '', CONCAT(ADDRESS_LINE2, ', ')), CITY, ' ', STATE, ' ', COUNTRY, ' - ', PINCODE), '') AS POSTAL_ADDR, DEITY_RECEIPT.SS_ID, PRINT_STATUS, IS_JEERNODHARA, SHASHWATH_PERIOD_SETTING.SP_ID, PERIOD_NAME, PERIOD, P_STATUS, COUNT(*) as CORPUS_CNT, SHASH_PRICE FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID JOIN DEITY_RECEIPT ON DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID WHERE DEITY_RECEIPT.RECEIPT_CATEGORY_ID = '7' AND DEITY_RECEIPT.RECEIPT_ACTIVE = '1' AND DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE = '1' $mergeCondition GROUP BY shashwath_members.SM_ID ";
		
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function member_details_for_member_seva($mergeCondition) {
		$sql ="SELECT shashwath_members.SM_ID, SM_REF, SM_NAME, SM_PHONE, SM_PHONE2, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, SM_RASHI, SM_NAKSHATRA, SM_GOTRA, REMARKS, SHASHWATH_SEVA.SS_ID, SS_REF, SHASHWATH_SEVA.SM_ID, SS_RECEIPT_NO, SS_RECEIPT_DATE, SHASHWATH_SEVA.DEITY_ID, SHASHWATH_SEVA.SEVA_ID, SEVA_QTY, SHASHWATH_SEVA.SEVA_TYPE, CAL_TYPE, THITHI_CODE, ENG_DATE, SHASHWATH_SEVA.EVERY_WEEK_MONTH, SHASHWATH_SEVA.SP_ID, SHASHWATH_SEVA.SP_COUNTER, SS_STATUS, MASA, BASED_ON_MOON, THITHI_NAME, SHASHWATH_SEVA.SEVA_NOTES, ACCUMULATED_LOSS, SHASHWATH_SEVA.SS_VERIFICATION, DEITY.DEITY_ID, DEITY_CODE, DEITY_NAME, DEITY.DATE_TIME, DEITY.DATE, DEITY.USER_ID, DEITY_ACTIVE, DEITY_SEVA.SEVA_ID, SEVA_CODE, SEVA_NAME, DEITY_SEVA.DEITY_ID, SEVA_DESC, DEITY_SEVA.DATE_TIME, DEITY_SEVA.DATE, DEITY_SEVA.USER_ID, SEVA_ACTIVE, QUANTITY_CHECKER, IS_SEVA, BOOKING, IS_TOKEN, DEITY_SEVA.SEVA_TYPE, SEVA_BELONGSTO, DEITY_RECEIPT.RECEIPT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_NAME, RECEIPT_PHONE, RECEIPT_EMAIL, RECEIPT_ADDRESS, RECEIPT_RASHI, RECEIPT_NAKSHATRA, RECEIPT_DEITY_NAME, RECEIPT_DEITY_ID, SUM(RECEIPT_PRICE) as RECEIPT_PRICE, RECEIPT_PAYMENT_METHOD, CHEQUE_NO, CHEQUE_DATE, BANK_NAME, BRANCH_NAME, TRANSACTION_ID, RECEIPT_PAYMENT_METHOD_NOTES, RECEIPT_ISSUED_BY, RECEIPT_ISSUED_BY_ID, DEITY_RECEIPT.DATE_TIME, RECEIPT_ACTIVE, CANCELLED_BY, CANCELLED_BY_ID, CANCELLED_DATE, CANCELLED_DATE_TIME, CANCEL_NOTES, RECEIPT_CATEGORY_ID, PAYMENT_STATUS, PAYMENT_CONFIRMED_BY_NAME, PAYMENT_CONFIRMED_BY, PAYMENT_DATE_TIME, PAYMENT_DATE, AUTHORISED_STATUS, AUTHORISED_BY, AUTHORISED_BY_NAME, AUTHORISED_DATE_TIME, AUTHORISED_DATE, CHEQUE_CREDITED_DATE, DATE_TYPE, IS_BOOKING, RECEIPT_SB_ID, IS_TRUST, RECEIPT_HB_ID, EOD_CONFIRMED_BY_ID, EOD_CONFIRMED_BY_NAME, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, POSTAGE_CHECK, POSTAGE_PRICE, POSTAGE_GROUP_ID, ADDRESS_LINE1, ADDRESS_LINE2, CITY, STATE, COUNTRY, PINCODE, IF(POSTAGE_CHECK = 1, CONCAT(ADDRESS_LINE1, ', ', IF(ADDRESS_LINE2 = '', '', CONCAT(ADDRESS_LINE2, ', ')), CITY, ' ', STATE, ' ', COUNTRY, ' - ', PINCODE), '') AS POSTAL_ADDR, DEITY_RECEIPT.SS_ID, PRINT_STATUS, IS_JEERNODHARA, SHASHWATH_PERIOD_SETTING.SP_ID, PERIOD_NAME, PERIOD, P_STATUS, COUNT(*) as CORPUS_CNT, SHASH_PRICE FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID JOIN DEITY_RECEIPT ON DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID WHERE DEITY_RECEIPT.RECEIPT_CATEGORY_ID = '7' AND DEITY_RECEIPT.RECEIPT_ACTIVE = '1' AND DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE = '1' $mergeCondition GROUP BY DEITY_RECEIPT.SS_ID  ORDER BY  STR_TO_DATE( shashwath_seva.SS_RECEIPT_DATE,'%d-%m-%Y')";
		
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function get_member_filter_search($filter,$masa,$condsrch = ""){
		$sql = "SELECT shashwath_members.SM_NAME,shashwath_members.SM_ID FROM shashwath_members WHERE $condsrch GROUP BY shashwath_members.SM_NAME ORDER BY SM_APPEAR_STATUS,SM_NAME ASC"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return "";
		}
	}

	function mandali_members_details($conditionSmId){
		$sql = "SELECT shashwath_mandali_member_details.MM_NAME,shashwath_mandali_member_details.MM_ID FROM shashwath_mandali_member_details where $conditionSmId"; 
		$query = $this->db->query($sql);
		return $query->result("array");
	}

	function update_manadli_member_details($RECEIPT_ID,$mmId){
		// $sql = "SELECT SS_ID FROM deity_receipt where RECEIPT_ID = $RECEIPT_ID"; 
		$this->db->select("SS_ID")->from('deity_receipt');
		$this->db->where('RECEIPT_ID',$RECEIPT_ID);
		$SSID = $this->db->get()->row()->SS_ID;

		$sql1 ="UPDATE `deity_receipt` SET ADDL_MM_PAID_BY = '$mmId'  WHERE SS_ID = $SSID" ; 
  		$this->db->query($sql1);
	}

	function getTempleDetails(){
		$sql="SELECT * from temple_details";	
		$query= $this->db->query($sql);
		return $query->result("array");
	}

}