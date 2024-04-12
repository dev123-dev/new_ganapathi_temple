<?php defined('BASEPATH') OR exit('No direct script access allowed');
class finance extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('finance_model','obj_finance',true);
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('Shashwath_Model','obj_shashwath',true);
		$this->load->helper('url','form');
		$this->load->library("pagination");
		if(!isset($_SESSION['userId']))
			redirect('login');
		if($_SESSION['trustLogin'] == 1)
			redirect('Trust');
	}
	
	public function index() {
	}

	public function Receipt() {

		$data['whichTab'] = 'Finance';
		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
			$data['todayDate'] = $_SESSION['todayDate'] = $_POST['todayDateVal'];
		} else {
			$data['compId'] = $compId = 1;
			$data['todayDate'] = $todayDate = $_SESSION['todayDate'] =date('d-m-Y');
		}
		$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate($data['todayDate']);
		$startDate = "01-04-".explode('-',$finYear)[0];
		$endDate = "31-03-".explode('-',$finYear)[1];
		// finacial_group_ledger_heads.FGLH_ID !=19 and finacial_group_ledger_heads.FGLH_ID !=17
		$condition = ("and finacial_group_ledger_heads.FGLH_ID !=18 
		               and finacial_group_ledger_heads.FGLH_ID !=20 
					   and finacial_group_ledger_heads.FGLH_ID !=22 
					   and finacial_group_ledger_heads.FGLH_ID !=23 
					   and finacial_group_ledger_heads.FGLH_ID !=25 
					   and finacial_group_ledger_heads.FGLH_ID !=26 ");
		$data['ledger'] =  $this->obj_finance->getLedger($condition,$compId,$startDate,$endDate);
		$condition = ("and finacial_group_ledger_heads.FGLH_ID !=27");
		$data['account'] =  $this->obj_finance->getAccount($condition,$compId,$startDate,$endDate);
		$data['committee'] =  $this->obj_finance->getCommittee();
        $data['loggedUser'] = $_SESSION['userId'];
		$data['receiptFormat'] =  $this->obj_finance->getReceiptFormat(1);

		$this->load->view('header', $data);
		$this->load->view('financeReceipt',$data);
		$this->load->view('footer_home');	//TS
	}

	public function addReceiptTrans() {
		$data['whichTab'] = "Finance";
		$dateTime = date('d-m-Y H:i:s A');
		$aidR = explode("|",@$_POST['aidR']);
		$lidR = explode("|",@$_POST['lidR']);
		$countNoR = @$_POST['countNoR'];
		$amtsR = @$_POST['amtsR'];
		$todayDate = @$_POST['todayDate'];
		$naration = str_replace("'","\'",@$_POST['naration']);
		//$naration= @$_POST['naration'];
		$userId= $_SESSION['userId'];
		$receivedfrom = str_replace("'","\'",@$_POST['receivedfrom']);
		// $receivedfrom= @$_POST['receivedfrom'];				
		$status="Completed";
		$compId= @$_POST['selCommittee'];	
		$this->obj_finance->incrementVoucherCounter(1);

		
		if($aidR[3]!=8)
		{
			$receiptmethod= @$_POST['receiptmethod'];
			$chequeDate= @$_POST['chequeDate'];
			$chkno = @$_POST['chkno'];
			$bankName = str_replace("'","\'",@$_POST['bankname']);
			$branchName = str_replace("'","\'",@$_POST['branchname']);
			// $branchName = str_replace("'","\'",@$_POST['branchname']);
			// $bankName = @$_POST['bankname'];
			// $branchName = @$_POST['branchname'];	
			if($receiptmethod == "Cheque")
			{ 
				$status="Pending";
			}
		} else {
			$chequeDate=$bankName =$branchName =$chkno =""; 
			$receiptmethod="Cash";
			//$receiptmethod=$chequeDate=$bankName =$branchName =$chkno =""; 
		}

		$user=$this->obj_finance->putReceipt($aidR[0],$lidR[0],$countNoR,$amtsR,$todayDate,$dateTime,$naration,$userId,$chequeDate,$receiptmethod,$chkno,$bankName,$branchName,$receivedfrom,$status,$compId);
		//////////////////////////////////////////////new code start///////////////////
		$CurrentDate = date('d-m-Y');
		$year = date('Y');
		$userSentDate = $todayDate;
		$finYear = $this->obj_finance->getFinYearBasedOnDate($todayDate);
		$fromDate = "01-04-".explode("-",$finYear)[0];
		$toDate = "31-03-".explode("-",$finYear)[1];
		$newFromDate = "01-04-".explode("-",$finYear)[1];
        if($year == explode("-",$finYear)[1]){
        	$newYear = $year - 1;
        	$newFromDate = "01-04-".$newYear;
        }
		if(strtotime($userSentDate) > strtotime($newFromDate) && strtotime($userSentDate) < strtotime($CurrentDate) ){
			 $data['res'] =  $this->obj_finance->checkAndInsertToFinancial_Ledger($fromDate,$toDate,$Revision = "True");
		}   	
		////////////////////////////////////////////new code end//////////////////////
		
		redirect(site_url()."finance/Receipt");
	}	

	public function Payment() {	//TS
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

		$unsetCall = @$_GET['unsetCall'];
		if($unsetCall!="No"){
			//for session 
			unset($_SESSION['aidSes']);
			unset($_SESSION['lidSes']);
			unset($_SESSION['amtsSes']);
			unset($_SESSION['favSes']);
			unset($_SESSION['narationSes']);
		}
		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = $_SESSION['CommitteeId'] = @$_POST['CommitteeId'];
			$data['todayDate'] = $_SESSION['todayDate'] = $_POST['todayDateVal'];
		} 
		else {	
			$data['compId'] = $compId = 1;
			$data['todayDate'] = $todayDate = $_SESSION['todayDate'] =date('d-m-Y');
		}
		$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate($data['todayDate']);
		$startDate = "01-04-".explode('-',$finYear)[0];
		$endDate = "31-03-".explode('-',$finYear)[1];
		$data['loggedUser'] = $_SESSION['userId'];
		$condition = ("and finacial_group_ledger_heads.FGLH_PARENT_ID !=13 and finacial_group_ledger_heads.FGLH_ID !=25");	
		// AND  finacial_group_ledger_heads.TYPE_ID !='L'	
		$data['ledger'] =  $this->obj_finance->getLedger($condition,$compId,$startDate,$endDate);
		$condition = ("AND finacial_group_ledger_heads.FGLH_ID !=21");
		$data['account'] =  $this->obj_finance->getAccount($condition,$compId,$startDate,$endDate);
		$data['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
		$data['range'] = json_encode($this->obj_finance->getrange());
		$data['pettyCashData'] =  $this->obj_finance->getPettyCashData($compId);
		$data['account1'] =  json_encode($this->obj_finance->getToAccount());


		$data['receiptFormatPc']=$this->obj_finance->getReceiptFormat(2);
		$data['receiptFormatContra']=$this->obj_finance->getReceiptFormat(4);
		$data['receiptFormatBank']=$this->obj_finance->getReceiptFormat(3);
		$data['committee'] =  $this->obj_finance->getCommittee();

		$this->load->view('header', $data);
		$this->load->view('financePayment',$data);
		$this->load->view('footer_home');
	}

	public function addPaymentTrans() {
		$dateTime = date('d-m-Y H:i:s A');
		$aidP =  explode("|",@$_POST['aidP']);
		$lidP = explode("|",@$_POST['lidP']);
		$countNoP = @$_POST['countNoP'];
		$amtsP = @$_POST['amtsP'];
		$todayDate = @$_POST['todayDate'];
		//$naration= @$_POST['naration'];
		$naration = str_replace("'","\'",@$_POST['naration']);
		//$favouring= @$_POST['favouring'];
		$favouring = str_replace("'","\'",@$_POST['favouring']);											
		$status="Completed";
		$userId= $_SESSION['userId'];
		$selectedId = @$_POST['selectedId'];
		$compId = @$_POST['selCommittee'];	
		//for session 
		unset($_SESSION['aidSes']);
		unset($_SESSION['lidSes']);
		unset($_SESSION['amtsSes']);
		unset($_SESSION['favSes']);
		unset($_SESSION['narationSes']);

		if($aidP[3]!=8)
		{
			$paymentmethod= @$_POST['paymentmethod'];
			$chequeDate= @$_POST['chequeDate'];
			$chequeData=  explode("|",@$_POST['rid']);												
			$bankName = $aidP[4];
			$branchName = $aidP[5];
			$FCD_ID = $chequeData[1];
			$chkno = $chequeData[0];
			$fcbdId = $chequeData[2];
			if($paymentmethod == "Cheque")
			{ 
				$this->obj_finance->putPaymentandContraCheque($todayDate,$countNoP,$chequeDate,$favouring,$FCD_ID,$aidP[0],$fcbdId);
				$status="Pending";
			}
			//update bank voucher counter
			$this->obj_finance->incrementVoucherCounter(3); //payment(bank)
		} else {
			$paymentmethod=$chequeDate=$bankName =$branchName =$chkno =""; 
			//update pettycash voucher counter
			$this->obj_finance->incrementVoucherCounter(2); // payment(petty cash)
		}

		$user=$this->obj_finance->putPayment($aidP[0],$lidP[0],$countNoP,$amtsP,$todayDate,$dateTime,$naration,$userId,$chequeDate,$paymentmethod,$chkno,$bankName,$branchName,$favouring,$status,$selectedId,$compId);

         //////////////////////////////////////////////new code start///////////////////
         $CurrentDate = date('d-m-Y');
		 $userSentDate = $todayDate;
		 $finYear = $this->obj_finance->getFinYearBasedOnDate($todayDate);
		 $fromDate = "01-04-".explode("-",$finYear)[0];
		 $toDate = "31-03-".explode("-",$finYear)[1];
		 $newFromDate = "01-04-".explode("-",$finYear)[1];

		 $year = date('Y');
		 if($year == explode("-",$finYear)[1]){
        	$newYear = $year - 1;
        	$newFromDate = "01-04-".$newYear;
        }
		if(strtotime($userSentDate) > strtotime($newFromDate) && strtotime($userSentDate) < strtotime($CurrentDate) ){
			  $data['res'] =  $this->obj_finance->checkAndInsertToFinancial_Ledger($fromDate,$toDate,$Revision = "True");
		}  
         ////////////////////////////////////////////new code end//////////////////////
		echo "success";			//ajax call
	}
	
	public function Journal() {
		$data['whichTab'] = 'Finance';
		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = $_SESSION['CommitteeId'] = @$_POST['CommitteeId'];
			$data['todayDate'] = $_SESSION['todayDate'] = $_POST['todayDateVal'];	
		} else {
			$data['compId'] = $compId = 1;
			$data['todayDate'] = $todayDate = $_SESSION['todayDate'] =date('d-m-Y');	
		}	
		$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate($data['todayDate']);	
		$startDate = "01-04-".explode('-',$finYear)[0];
		$endDate = "31-03-".explode('-',$finYear)[1];
		$data['loggedUser'] = $_SESSION['userId'];
		$condition = ("AND IS_JOURNAL_STATUS='1'");
		$data['ledger'] =  $this->obj_finance->getLedger($condition,$compId,$startDate,$endDate);
		$data['receiptFormat'] = $this->obj_finance->getReceiptFormat(5);
		$data['committee'] =  $this->obj_finance->getCommittee();

		$this->load->view('header', $data);
		$this->load->view('financeJournal',$data);
		$this->load->view('footer_home');
	}

	public function addJournalTrans() {
		$countNoJ = @$_POST['countNoJ'];
		$tDateJ = @$_POST['todayDate'];
		// $naration= @$_POST['naration'];
		$naration = str_replace("'","\'",@$_POST['naration']);
		$dateTime = date('d-m-Y H:i:s A');
		$userId= $_SESSION['userId'];
		$compId = @$_POST['selCommittee'];	

		$type = json_decode(@$_POST['type']);
		$ledgers = json_decode(@$_POST['ledgers']);
		$amount = json_decode(@$_POST['amount']);

		$this->obj_finance->incrementVoucherCounter(5);

		for($i = 0; $i < count($amount); ++$i) {
			$lidJ = $ledgers[$i];
			if($type[$i]=="from")
			{
				$firstAmt = $amount[$i];
				$secondAmt = 0;
				$rptype = "J1";
				$this->obj_finance->putJournal($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$userId,$rptype,$compId);
			} else if($type[$i]=="to") {
				$firstAmt = 0;
				$secondAmt = $amount[$i];
				$rptype = "J2";
				$this->obj_finance->putJournal($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$userId,$rptype,$compId);
			}

		}

		//////////////////////////////////////////////new code start///////////////////
		$CurrentDate = date('d-m-Y');
		$userSentDate = $tDateJ;
		$finYear = $this->obj_finance->getFinYearBasedOnDate($tDateJ);
		$fromDate = "01-04-".explode("-",$finYear)[0];
		$toDate = "31-03-".explode("-",$finYear)[1];
		$newFromDate = "01-04-".explode("-",$finYear)[1];
		$year = date('Y');
		if($year == explode("-",$finYear)[1]){
        	$newYear = $year - 1;
        	$newFromDate = "01-04-".$newYear;
        }
		if(strtotime($userSentDate) > strtotime($newFromDate) && strtotime($userSentDate) < strtotime($CurrentDate) ){
			  $data['res'] =  $this->obj_finance->checkAndInsertToFinancial_Ledger($fromDate,$toDate,$Revision = "True");
		}  
		////////////////////////////////////////////new code end//////////////////////
		echo "success";
	}
	public function Contra() {	//TS
		$data['whichTab'] = 'Finance';
		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = $_SESSION['CommitteeId'] = @$_POST['CommitteeId'];
			$data['todayDate'] = $_SESSION['todayDate'] = $_POST['todayDateVal'];	
		} else {
			$data['compId'] = $compId = 1;
			$data['todayDate'] = $todayDate = $_SESSION['todayDate'] =date('d-m-Y');	
		}
		$data['loggedUser'] = $_SESSION['userId'];
		$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate($data['todayDate']);
		$startDate = "01-04-".explode('-',$finYear)[0];
		$endDate = "31-03-".explode('-',$finYear)[1];
		$condition = ("AND finacial_group_ledger_heads.FGLH_ID !=27");
		$data['account'] =  $this->obj_finance->getAccount($condition,$compId,$startDate,$endDate);
		
		$condition = ("AND finacial_group_ledger_heads.FGLH_ID !=21");
		$data['account3'] =  $this->obj_finance->getAccount($condition,$compId,$startDate,$endDate);
		$data['range'] = json_encode($this->obj_finance->getrange());	
		$data['cashReceipts'] = $this->obj_finance->getCashReceipts();
		$data['indCashReceipts'] = $this->obj_finance->getIndividualCashReceipts();
		$data['receiptFormat']=$this->obj_finance->getReceiptFormat(4);
		$data['committee'] =  $this->obj_finance->getCommittee();


		$this->load->view('header', $data);
		$this->load->view('financeContra',$data);
		$this->load->view('footer_home');
	}

	
	public function addContraTrans() {
		$dateTime = date('d-m-Y H:i:s A');
		$aidC = explode("|",@$_POST['aidC']);
		$acidC = explode("|",@$_POST['acidC']);
		$countNoC = @$_POST['countNoC'];
		$amtsC = @$_POST['amtsC'];
		$todayDate = @$_POST['todayDate'];
		$naration = str_replace("'","\'",@$_POST['naration']);
		//$naration= @$_POST['naration'];
		$favouring= @$_POST['favouring'];											
		$status="Completed";
		$userId= $_SESSION['userId'];
		$from= @$_POST['from'];
		//$selectedId = explode(",",@$_POST['selectedId']);
		$selectedId = explode(",",@$_POST['selectedLedgerId']);
		$compId = @$_POST['selCommittee'];
		
		//For Contra Session
		$_SESSION['aidSes'] = @$_POST['aidSes'];
		$_SESSION['lidSes'] = @$_POST['lidSes'];
		$_SESSION['amtsSes'] = @$_POST['amtsSes'];
		$_SESSION['favSes'] = @$_POST['favSes'];
		$_SESSION['narationSes'] = @$_POST['narationSes'];
		//End Session 

		$this->obj_finance->incrementVoucherCounter(4);

		if($aidC[3]!=8)
		{
			$paymentmethod= @$_POST['paymentmethod'];
			$chequeDate= @$_POST['chequeDate'];
			$chequeData=  explode("|",@$_POST['rid']);

			$bankName = $aidC[4];
			$branchName = $aidC[5];
			$FCD_ID = $chequeData[1];
			$chkno = $chequeData[0];
			$fcbdId = $chequeData[2];
			if($paymentmethod == "Cheque")
			{ 
				$this->obj_finance->putPaymentandContraCheque($todayDate,$countNoC,$chequeDate,$favouring,$FCD_ID,$aidC[0],$fcbdId);
				$status="Pending";
			}
		} else {
			$paymentmethod=$chequeDate=$bankName =$branchName =$chkno =""; 
			for($i = 0; $i < count($selectedId); ++$i) {
				$fId = $selectedId[$i];
				$this->obj_finance->putCashReceipt($fId,$todayDate);		
			}
		}

		if($acidC[0]==27){
			$pcPay=$aidC[0];
		}else{
			$pcPay="";
		}

		$user=$this->obj_finance->putContra($aidC[0],$acidC[0],$countNoC,$amtsC,$todayDate,$dateTime,$naration,$userId,$chequeDate,$paymentmethod,$chkno,$bankName,$branchName,$favouring,$status,$pcPay,$compId);
		//////////////////////////////////////////////new code start///////////////////
		$CurrentDate = date('d-m-Y');
		$userSentDate = $todayDate;
		$finYear = $this->obj_finance->getFinYearBasedOnDate($todayDate);
		$fromDate = "01-04-".explode("-",$finYear)[0];
		$toDate = "31-03-".explode("-",$finYear)[1];
		$newFromDate = "01-04-".explode("-",$finYear)[1];
		$year = date('Y');
		if($year == explode("-",$finYear)[1]){
        	$newYear = $year - 1;
        	$newFromDate = "01-04-".$newYear;
        }
		if(strtotime($userSentDate) > strtotime($newFromDate) && strtotime($userSentDate) < strtotime($CurrentDate) ){
			  $data['res'] =  $this->obj_finance->checkAndInsertToFinancial_Ledger($fromDate,$toDate,$Revision = "True");
		}  
		////////////////////////////////////////////new code end//////////////////////
		// if($from=="Payment")
			echo "success";
		// else
		// 	redirect(site_url()."finance/Contra");
	}

	public function Group() {
		$data['whichTab'] = 'Finance';
		$condition = "LEVELS='PG' OR LEVELS='SG'";		
		$data['groups'] =  $this->obj_finance->getGroups($condition);		
		$data['maingroups'] =  $this->obj_finance->getMainGroups();
		$data['callFrom'] = @$_GET['callFrom'];
		$this->load->view('header', $data);
		$this->load->view('financeAddGroup',$data);
		$this->load->view('footer_home');
	}

	public function addNewGroup() {
		$mainGroupId = explode("|",@$_POST['mainGroupId']);
		$groupId = explode("|",@$_POST['groupId']);
		// $nameG = @$_POST['nameG'];
		$nameG = str_replace("'","\'",@$_POST['nameG']);
		// $nameSG = @$_POST['nameSG'];
		$nameSG = str_replace("'","\'",@$_POST['nameSG']);
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		if($mainGroupId[0]>0){
			$group=$mainGroupId[0];
			$levels='PG';   // new Main Group
			$name=$nameG;
		} else{
			$group=$groupId[0];
			$levels='SG';  //sub Group
			$name=$nameSG;
		}
		$checkType =  $this->obj_finance->getType1($group);   //sending groupId and fetching data based on Id from ledger_head 
		$lft = '';
		$rgt = '';

		if ($checkType == 'A') { //Asset
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') { //liability
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') { //Income
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') { //Expense
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}

		$parentLevel =  $this->obj_finance->getParentLevel($group);
		$user=$this->obj_finance->putNewGroup($group,$name,$lft,$rgt,$levels,$parentLevel);
		$last_id = $this->db->insert_id();
		if($levels == 'PG'){
			$sql="UPDATE finacial_group_ledger_heads SET PRIMARY_PARENT_CODE = $last_id  where FGLH_ID = $last_id";
			$this->db->query($sql);
		}
		$this->obj_finance->putGroupLedgerHistory($last_id,$name,$userId,'Insert',$levels,$date,$dateTime);

		redirect(site_url()."finance/Group");
	}

	public function discardGroup() {
		if(isset($_POST)) {
			$groupId = $this->input->post('DLT_GROUP_ID');
			$name = str_replace("'","\'",$this->input->post('grpName'));
			// $name = $this->input->post('grpName');
			$levels = $this->input->post('DLT_GROUP_LEVEL');
			$underId = $this->input->post('underId');
		}
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		
		$checkType =  $this->obj_finance->getType1($groupId);

		$lft = '';
		$rgt = '';

		if ($checkType == 'A') {
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') {
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') {
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') {
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}

		$parentLevel =  $this->obj_finance->getParentLevel($underId);
		$user=$this->obj_finance->discardGroup($underId,$name,$lft,$rgt,$groupId);
		$this->obj_finance->putGroupLedgerHistory($groupId,$name,$userId,'Delete',$levels,$date,$dateTime);
		redirect(site_url()."finance/allGroupLedgerDetails");
	}

	public function transferGroup() {
		if(isset($_POST)){
			$transferGroupId = $this->input->post('transferGroupId');
			$name = str_replace("'","\'",$this->input->post('transferGroupName'));
			// str_replace("'","\'",@$_POST['nameG']);
			$transferGroupParentId = $this->input->post('transferGroupParentId');
			$oldGroupParentId = $this->input->post('oldGroupParentId');
			$levels = $this->input->post('transferGroup');
		}
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$checkType =  $this->obj_finance->getType1($transferGroupId);
		$lft = '';
		$rgt = '';
		if ($checkType == 'A') {
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') {
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') {
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') {
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}

		$checkTypeParent =  $this->obj_finance->getType1($transferGroupParentId);
		$lftParent = '';
		$rgtParent = '';
		if ($checkTypeParent == 'A') {
			$lftParent = 'LF_A';
			$rgtParent = 'RG_A'; 		    	
		} else if ($checkTypeParent == 'L') {
			$lftParent = 'LF_L';
			$rgtParent = 'RG_L'; 
		} else if ($checkTypeParent == 'I') {
			$lftParent = 'LF_I';
			$rgtParent = 'RG_I'; 
		} else if ($checkTypeParent == 'E') {
			$lftParent = 'LF_E';
			$rgtParent = 'RG_E'; 
		}

		$parentLevel =  $this->obj_finance->getParentLevel($transferGroupParentId);
		$this->obj_finance->putTransferGroup($transferGroupId,$transferGroupParentId,$lft,$rgt,$parentLevel,$lftParent,$rgtParent,$checkType,$checkTypeParent);
		$this->obj_finance->putGroupLedgerHistory($transferGroupId,$name,$userId,'Transfer_Group',$levels,$date,$dateTime,$oldGroupParentId);
		redirect(site_url()."finance/allGroupLedgerDetails");
	}

	public function updateGroup() {
		if(isset($_POST)){
			$GROUP_ID = $this->input->post('GROUP_ID');
			$name = str_replace("'","\'",@$_POST['name']);
			// $name = $this->input->post('name');
			$levels = $this->input->post('GROUP_LEVEL');
		}
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$sql="UPDATE finacial_group_ledger_heads SET FGLH_NAME = '$name'  where FGLH_ID = $GROUP_ID";
		$this->db->query($sql);
		$this->obj_finance->putGroupLedgerHistory($GROUP_ID,$name,$userId,'Update',$levels,$date,$dateTime);
		redirect(site_url()."finance/allGroupLedgerDetails");
	}

	public function Ledger() {
		$data['whichTab'] = 'Finance';
		$condition = "LEVELS='PG' OR LEVELS='SG'";		
		$data['groups'] =  $this->obj_finance->getGroups($condition);
		$data['ledgerdate'] = $this->obj_finance->getledgerdate();
		$data['bank'] =    $this->obj_finance->getBankDetails();
		$data['allocationHeads'] = $this->obj_finance->getAllocationHeads();
		$data['allocationLedgers'] =  json_encode($this->obj_finance->getAllocationLedgers());
		$data['committee'] =  $this->obj_finance->getCommittee();
		$data['callFrom'] = @$_GET['callFrom'];

		$this->load->view('header', $data);
		$this->load->view('financeAddLedger',$data);
		$this->load->view('footer_home');
	}

	public function addLedger() {
		$group = explode("|",@$_POST['group']);
		//$nameL = @$_POST['nameL'];
		$nameL = str_replace("'","\'",@$_POST['nameL']);
		$intrestrate =@$_POST['intrestrate'];
		$checkType =  $this->obj_finance->getType1($group[0]);
		$dateTime = date('d-m-Y H:i:s A');
		$todayDate = @$_POST['todayDate'];
		$opAmt = @$_POST['opAmt'];
		$committeeAssigned = @$_POST['committee1'];
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$naration="";
		$fdBankName1 = "";
		$fdBankId = "";
		$fdBankName =  "";
		$fdNumber = "";
		$fdyes = $this->input->post('fdyes');
		if($fdyes==""){
			$fdyes=0;
		}else{
			 // added by adithya start
			 $fdBankName1 = explode("|",$this->input->post('Bank')) ;
			 $fdBankId = $fdBankName1[0];
			 $fdBankName =  $fdBankName1[1];
			 $fdNumber = $this->input->post('FDNumber');
	 // added by adithya end
		}
       
		$jouranalyes = 1; 
		//$this->input->post('jouranalyes');
		// if($jouranalyes==""){
		// 	$jouranalyes=0;
		// }
		$maturitystart = @$_POST['todayDate3'];
		$maturityend = @$_POST['todayDate1'];
		// print_r($maturitystart);
		$terminalyes = $this->input->post('terminalyes');
		if($terminalyes==""){
			$terminalyes=0;
		}
		if($group[0]==9){
			$accountno = @$_POST['accountno'];
			$ifsccode = @$_POST['ifsccode'];
			//$bankname = @$_POST['bankname'];
			$bankname = str_replace("'","\'",@$_POST['bankname']);
			//$branch = @$_POST['branch'];
			$branch = str_replace("'","\'",@$_POST['branch']);
			//$location = @$_POST['location'];
			$location = str_replace("'","\'",@$_POST['location']);
		} else { $accountno =$ifsccode =$bankname =$branch =$location =""; }
		$lft = '';
		$rgt = '';


		if ($checkType == 'A') {
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') {
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') {
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') {
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}
		$parentLevel =  $this->obj_finance->getParentLevel($group[0]);
		$user=$this->obj_finance->putNewLedger($group[0],$nameL,$lft,$rgt,$accountno,$ifsccode,$bankname,$branch,$location,$parentLevel,$jouranalyes,$committeeAssigned,$terminalyes,$fdyes,$maturitystart,$maturityend,$intrestrate,$fdBankName,$fdNumber,$fdBankId);
		$last_id = $this->db->insert_id();

		if($checkType == 'A' || $checkType == 'L'){

			$selectedCommittee = explode(",",@$_POST['committee1']);
			$selectedOpBal = explode(",",@$_POST['committeeOpBal1']);
			for($i = 0; $i < count($selectedCommittee); ++$i) {
				$compId = $selectedCommittee[$i];
				$opAmt = $selectedOpBal[$i];
				$user1=$this->obj_finance->putOpeningBal($dateTime,$todayDate,$last_id,$opAmt,$naration,$compId,$userId);
			}
		}
		

		if($group[0]==9){
			$selectedLedgers = json_decode(@$_POST['ledger1']);
			for($i = 0; $i < count($selectedLedgers); ++$i) {
				$ledgerFglhId = $selectedLedgers[$i];
				$this->obj_finance->putAllocatedLedger($last_id,$ledgerFglhId);		
			}
		}

		$this->obj_finance->putGroupLedgerHistory($last_id,$nameL,$userId,'Insert','LG',$date,$dateTime);
		redirect(site_url()."finance/Ledger");
	}

	public function editLedger() {
		$data['whichTab'] = 'Finance';
		$data['ledgerdate'] = $this->obj_finance->getledgerdate();
		$data['allocationHeads'] = $this->obj_finance->getAllocationHeads();
		$data['allocationLedgers'] =  json_encode($this->obj_finance->getAllocationLedgers());
		$data['bank'] =    $this->obj_finance->getBankDetails();

		if(isset($_POST)){
			$data['LEDGER_ID'] = $LEDGER_FGLH_ID = $this->input->post('LEDGER_ID');
			$data['LEDGER_NAME'] = $this->input->post('LEDGER_NAME');
			$data['LEDGER_PARENT_ID'] = $LEDGER_PARENT_ID = $this->input->post('LEDGER_PARENT_ID');
			$data['IS_FD_STATUS'] = $IS_FD_STATUS = $this->input->post('IS_FD_STATUS');
			$data['FD_MATURITY_START_DATE'] = $FD_MATURITY_START_DATE = $this->input->post('FD_MATURITY_START_DATE');
			$data['FD_MATURITY_END_DATE'] = $IS_FD_STATUS = $this->input->post('FD_MATURITY_END_DATE');
			$data['FD_INTEREST_RATE'] = $IS_FD_STATUS = $this->input->post('FD_INTEREST_RATE');
			$data['IS_JOURNAL_STATUS'] = $IS_JOURNAL_STATUS = $this->input->post('IS_JOURNAL_STATUS');
			$data['IS_TERMINAL'] = $IS_TERMINAL = $this->input->post('IS_TERMINAL');
		}
		$condition = "FGLH_ID = $LEDGER_PARENT_ID";		
		$data['parentDetails'] =  $this->obj_finance->getGroups($condition);
		$condition = "FGLH_ID = $LEDGER_FGLH_ID";
		$data['ledgerDetails'] = $ledgerDetails = $this->obj_finance->getAllLedger($condition);
		$data['assignedBankLedger'] =  $this->obj_finance->getAssignedBankLedger($LEDGER_FGLH_ID);
		//ASSIGNED COMMITTEES
		$assignedCommittees = explode(",",$ledgerDetails[0]->COMP_ID);
		$committeeCondition = "finance_committee.COMP_ID = $assignedCommittees[0]";
		for($i = 1; $i < count($assignedCommittees); ++$i) {
			$committeeCondition.= " OR finance_committee.COMP_ID = $assignedCommittees[$i] ";
		}
		$data['assignedComp'] =  $this->obj_finance->getAssignedCommittee($committeeCondition,$LEDGER_FGLH_ID);
		$data['committee'] =  $this->obj_finance->getCommittee();

		$this->load->view('header', $data);
		$this->load->view('financeEditLedger',$data);
		$this->load->view('footer_home');
	}

	public function deleteLedger() {
		$data['whichTab'] = 'Finance';
		$data['ledgerdate'] = $this->obj_finance->getledgerdate();
		$data['allocationHeads'] = $this->obj_finance->getAllocationHeads();
		$data['allocationLedgers'] =  json_encode($this->obj_finance->getAllocationLedgers());

		if(isset($_POST)){
			$data['LED_ID'] = $LED_ID = $this->input->post('LED_ID');
			$data['LED_NAME'] = $this->input->post('LED_NAME');
			$data['LED_PARENT_ID'] = $LED_PARENT_ID = $this->input->post('LED_PARENT_ID');
			$data['JOURNAL_STATUS'] = $JOURNAL_STATUS = $this->input->post('JOURNAL_STATUS');
			$data['TERMINAL'] = $TERMINAL = $this->input->post('TERMINAL');
			$data['BALANCE'] = $BALANCE = $this->input->post('BALANCE');
			$data['OPBALANCE'] = $OPBALANCE = $this->input->post('OPBALANCE');
			$data['CURRENT_BALANCE'] = $CURRENT_BALANCE = $this->input->post('CURRENT_BALANCE');
		}
		$condition = "FGLH_ID = $LED_PARENT_ID";		
		$data['parentDetails'] =  $this->obj_finance->getGroups($condition);
		$condition = "FGLH_ID = $LED_ID";
		// print_r($LEDGER_FGLH_ID);
		$data['ledgerDetails'] = $ledgerDetails = $this->obj_finance->getAllLedger($condition);
		$data['assignedBankLedger'] =  $this->obj_finance->getAssignedBankLedger($LED_ID);
		//ASSIGNED COMMITTEES
		$assignedCommittees = explode(",",$ledgerDetails[0]->COMP_ID);
		$committeeCondition = "finance_committee.COMP_ID = $assignedCommittees[0]";
		for($i = 1; $i < count($assignedCommittees); ++$i) {
			$committeeCondition.= " OR finance_committee.COMP_ID = $assignedCommittees[$i] ";
		}
		$data['assignedComp'] =  $this->obj_finance->getAssignedCommittee($committeeCondition,$LED_ID);
		$data['committee'] =  $this->obj_finance->getCommittee();

		$this->load->view('header', $data);
		$this->load->view('financeDeleteLedger',$data);
		$this->load->view('footer_home');
	}

	public function updateLedger() {
		// $name = $this->input->post('nameL');

		// added by adithya start
	    $fdBankName = explode("|",$this->input->post('Bank')) ;
		$fdBankId = $fdBankName[0];
		$fdNumber = $this->input->post('FDNumber');
// added by adithya end
		$name = str_replace("'","\'",@$_POST['nameL']);
		$accountno = $this->input->post('accountno');
		$ifsccode = $this->input->post('ifsccode');
		$bankname = str_replace("'","\'",@$_POST['bankname']);
		$intrestrate =@$_POST['intrestrate'];
		// $bankname = $this->input->post('bankname');
		// $branch = $this->input->post('branch');
		$branch = str_replace("'","\'",@$_POST['branch']);
		//$location = $this->input->post('location');
		$location = str_replace("'","\'",@$_POST['location']);
		$ledgerId = $this->input->post('editLedgerId');
		$underId = $this->input->post('underId');
		$opAmt = $this->input->post('opAmt');
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$committeeAssigned = @$_POST['committee1'];
		$todayDate = @$_POST['todayDate'];
		$fdyes = $this->input->post('fdyes');
		if($fdyes==""){
			$fdyes=0;
		}
		$jouranalyes = $this->input->post('jouranalyes');
		if($jouranalyes==""){
			$jouranalyes=0;
		}
		$terminalyes = $this->input->post('terminalyes');
		if($terminalyes==""){
			$terminalyes=0;
		}
		$maturitystart = @$_POST['todayDate3'];
		$maturityend = @$_POST['todayDate1'];

		$sql="UPDATE finacial_group_ledger_heads SET FD_BANK_NAME = '$fdBankName[1]',FD_BANK_ID = '$fdBankName[0]',FD_NUMBER = '$fdNumber', FGLH_NAME = '$name',BANK_NAME= '$bankname',ACCOUNT_NO= '$accountno',BANK_BRANCH= '$branch',BANK_LOCATION= '$location',BANK_IFSC_CODE= '$ifsccode',COMP_ID = '$committeeAssigned',IS_JOURNAL_STATUS =$jouranalyes,IS_TERMINAL =$terminalyes,IS_FD_STATUS=$fdyes, FD_MATURITY_START_DATE ='$maturitystart', FD_MATURITY_END_DATE='$maturityend',FD_INTEREST_RATE=$intrestrate where FGLH_ID = $ledgerId";
		$this->db->query($sql);

		//Assigning new ledgers
		if($underId == 9){
			$selectedLedgers = json_decode(@$_POST['ledger1']);
			for($i = 0; $i < count($selectedLedgers); ++$i) {
				$ledgerFglhId = $selectedLedgers[$i];
				$this->obj_finance->putAllocatedLedger($ledgerId,$ledgerFglhId);		
			}
		}
		//Updating Opening Balance 
		// if($opAmt != ""){
		// 	$this->db->select("TYPE_ID")->from('finacial_group_ledger_heads');
		// 	$this->db->where("FGLH_ID = '$ledgerId'");
		// 	$type = $this->db->get()->row()->TYPE_ID;

		// 	$this->db->query("UPDATE `finacial_group_ledger_heads` SET OP_BAL = 1 WHERE FGLH_ID = $ledgerId");

		// 	if ($type == 'A' || $type == 'E') {
		// 		$this->db->query("UPDATE financial_ledger_transcations SET FLT_DR = $opAmt  where FGLH_ID = $ledgerId and RP_TYPE='OP'");
		// 	} else {
		// 		$this->db->query("UPDATE financial_ledger_transcations SET FLT_CR = $opAmt  where FGLH_ID = $ledgerId and RP_TYPE='OP'");
		// 	}
		// }

		//New Committee Opening Balance
		$selectedCommittee = explode(",",@$_POST['committee1']);
		$selectedOpBal = explode(",",@$_POST['committeeOpBal1']);
		for($i = 0; $i < count($selectedCommittee); ++$i) {
			if($selectedOpBal[$i]!=""){
				$compId = $selectedCommittee[$i];
				$opAmt = $selectedOpBal[$i];
				$this->obj_finance->putOpeningBal($dateTime,$todayDate,$ledgerId,$opAmt,$naration,$compId,$userId);
			}
		}

		//deleting Existing Assigned ledgers
		$removingLedgers = explode(",",@$_POST['removingLedgers']);
		if(@$_POST['removingLedgers']){
			for($i = 0; $i < count($removingLedgers); ++$i) {
				$blaid = $removingLedgers[$i];
				$this->db->query("DELETE FROM `bank_ledger_allocation` WHERE `BLA_ID`= $blaid");	
			}
		}
		
		$this->obj_finance->putGroupLedgerHistory($ledgerId,$name,$userId,'Update','LG',$date,$dateTime);
		redirect(site_url()."finance/allGroupLedgerDetails");
	}

	public function discardLedger() {
		$name = str_replace("'","\'",$this->input->post('nameL'));
		// $name = $this->input->post('nameL');
		$accountno = $this->input->post('accountno');
		$ifsccode = $this->input->post('ifsccode');
		$bankname = $this->input->post('bankname');
		$branch = $this->input->post('branch');
		$location = $this->input->post('location');
		$ledgerId = $this->input->post('deleteLedgerId');
		$underId = $this->input->post('underId');
		$opAmt = $this->input->post('opAmt');
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$checkType =  $this->obj_finance->getType1($underId);
		$committeeAssigned = @$_POST['committee1'];
		$todayDate = @$_POST['todayDate'];
		$jouranalyes = $this->input->post('jouranalyes');
		if($jouranalyes==""){
			$jouranalyes=0;
		}
		$terminalyes = $this->input->post('terminalyes');
		if($terminalyes==""){
			$terminalyes=0;
		}

		$lft = '';
		$rgt = '';

		if ($checkType == 'A') {
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') {
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') {
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') {
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}
		$parentLevel =  $this->obj_finance->getParentLevel($underId);
		$user=$this->obj_finance->discardLedger($name,$ledgerId,$lft,$rgt,$parentLevel);
		$condition ="BANK_FGLH_ID = $ledgerId";
		$data['bankdeltails'] = $bankdeltails = $this->obj_finance->getBankLedgerDetails($condition);

		if($bankdeltails == $ledgerId){
			$sql="DELETE FROM bank_ledger_allocation WHERE BANK_FGLH_ID =$ledgerId ";
			$this->db->query($sql);
			// $this->obj_finance->putBankLedgerHistory($ledgerId,$bankdeltails,$userId,'Delete',$date,$dateTime);
		}
		$this->obj_finance->putGroupLedgerHistory($ledgerId,$name,$userId,'Delete','LG',$date,$dateTime);
		redirect(site_url()."finance/allGroupLedgerDetails");
	}

	public function transferLedger() {
		if(isset($_POST)){
			$transferLedgerId = $this->input->post('transferLedgerId');
			$name = str_replace("'","\'",$this->input->post('transferLedgerName'));
			// $name = $this->input->post('transferLedgerName');
			$transferLedgerparentId = $this->input->post('transferLedgerparentId');
			$oldLedgerParentId = $this->input->post('oldLedgerParentId');
		}
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$checkType =  $this->obj_finance->getType1($transferLedgerId);
		$lft = '';
		$rgt = '';
		if ($checkType == 'A') {
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') {
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') {
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') {
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}

		$checkTypeParent =  $this->obj_finance->getType1($transferLedgerparentId);
		$lftParent = '';
		$rgtParent = '';
		if ($checkTypeParent == 'A') {
			$lftParent = 'LF_A';
			$rgtParent = 'RG_A'; 		    	
		} else if ($checkTypeParent == 'L') {
			$lftParent = 'LF_L';
			$rgtParent = 'RG_L'; 
		} else if ($checkTypeParent == 'I') {
			$lftParent = 'LF_I';
			$rgtParent = 'RG_I'; 
		} else if ($checkTypeParent == 'E') {
			$lftParent = 'LF_E';
			$rgtParent = 'RG_E'; 
		}

		$parentLevel = $this->obj_finance->getParentLevel($transferLedgerparentId);
		$this->obj_finance->putTransferLedger($transferLedgerId,$transferLedgerparentId,$lft,$rgt,$parentLevel,$lftParent,$rgtParent,$checkType,$checkTypeParent);
		$this->obj_finance->putGroupLedgerHistory($transferLedgerId,$name,$userId,'Transfer_Ledger','LG',$date,$dateTime,$oldLedgerParentId);
		redirect(site_url()."finance/allGroupLedgerDetails");
	}

	public function updateOpeningBalance() {
		$fltId = $this->input->post('fltId');
		$Balance = $this->input->post('Balance');
		$LedgerFglhId = $this->input->post('LedgerFglhId');
		$oldBalance = $this->input->post('oldBalance');
		$LedgerFglhName = $this->input->post('LedgerFglhName');
		$compId = $this->input->post('compId');
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');

		$this->db->select("TYPE_ID")->from('finacial_group_ledger_heads');
		$where = "FGLH_ID = '$LedgerFglhId'";
		$this->db->where($where);
		$TYPE_ID = $this->db->get()->row()->TYPE_ID;
		if ($TYPE_ID == 'A' || $TYPE_ID == 'E') {
			$fltAmtType='FLT_DR';
		} else {
			$fltAmtType='FLT_CR';
		}

		$sql="UPDATE financial_ledger_transcations SET $fltAmtType = $Balance where FLT_ID = $fltId";
		$this->db->query($sql);

		$this->obj_finance->putGroupLedgerHistory($LedgerFglhId,$LedgerFglhName,$userId,'EditOP','LG',$date,$dateTime,$compId,$oldBalance);

		echo "success";
	}
	
	public function OpeningBal() {	
		$data['whichTab'] = 'Finance';
		$condition = "LEVELS='LG' AND TYPE_ID!='I' AND TYPE_ID!='E'"; //
		$data['allLedger'] =  $this->obj_finance->getAllLedger($condition);
		$data['committee'] =  $this->obj_finance->getCommittee();
		$this->load->view('header', $data);
		$this->load->view('financeOpeningBalance',$data);
		$this->load->view('footer_home');
	}

	public function addOpeningBal() {
		$dateTime = date('d-m-Y H:i:s A');
		$led = explode("|",@$_POST['led']);
		$opAmt = @$_POST['opAmt'];
		$todayDate = @$_POST['todayDate'];
		$naration=str_replace("'","\'",@$_POST['naration']);
		$committeeAssigned = @$_POST['committee1'];

		$sql="UPDATE finacial_group_ledger_heads SET COMP_ID = '$committeeAssigned'  where FGLH_ID = $led[0]";
		$this->db->query($sql);

		$selectedCommittee = explode(",",@$_POST['committee1']);
		$selectedOpBal = explode(",",@$_POST['committeeOpBal1']);
		for($i = 0; $i < count($selectedCommittee); ++$i) {
			$compId = $selectedCommittee[$i];
			$opAmt = $selectedOpBal[$i];
			$this->obj_finance->putOpeningBal($dateTime,$todayDate,$led[0],$opAmt,$naration,$compId,$userId);
		}
		redirect(site_url()."finance/OpeningBal");
	}

	// public function addAddChequeDetails(){
	// 	$chkbookno = @$_POST['chkbookno'];
	// 	$fromno = @$_POST['fromno'];
	// 	$tono = @$_POST['tono'];
	// 	$FGLH_ID = @$_POST['FGLH_ID'];
	
	// 	if( $FGLH_ID !=""){
	// 			$FGLH_ID = @$_POST['FGLH_ID'];
	// 		}else{
	// 			$FGLH_ID= @$_POST['bankcheque'];
				
	// 		}
	// 	$numberofchk  = @$_POST['numberofchk'];
	// 	$chkname = @$_POST['chkname'];
	// 	$FCBD_ID = @$_POST[''];

	// 	$numRow=$this->obj_finance->getBookStatus($FGLH_ID);

	// 	if($numRow>0){
	// 		$status = "Available";
	// 	} else {
	// 		$status = "Active";
	// 	}

	// 	$user=$this->obj_finance->putChequeDetails($chkbookno,$fromno,$tono,$numberofchk,$chkname,$FGLH_ID,$status);
	// 	$last_id = $this->db->insert_id();

	// 	for($x = $fromno; $x<= $tono; $x++ ){
	// 		$data = array(
	// 			'CHEQUE_NO' => $x,
	// 			'FCD_STATUS' => 'Available',
	// 			'FCBD_ID' => $last_id
	// 		);
	// 		$this->db->insert('finance_cheque_detail',$data);
	// 	}
	// 	redirect(site_url()."finance/chequeDetails");
	// }

	public function addAddChequeDetails(){
		$chkbookno = @$_POST['chkbookno'];
		$fromno = @$_POST['fromno'];
		$tono = @$_POST['tono'];
		$FGLH_ID = @$_POST['FGLH_ID'];
	
		if( $FGLH_ID !=""){
			$FGLH_ID = @$_POST['FGLH_ID'];
			$numberofchk  = @$_POST['numberofchk'];
			$chkname = @$_POST['chkname'];
			$FCBD_ID = @$_POST[''];

			$numRow=$this->obj_finance->getBookStatus($FGLH_ID);

			if($numRow>0){
				$status = "Available";
			} else {
				$status = "Active";
			}

			$user=$this->obj_finance->putChequeDetails($chkbookno,$fromno,$tono,$numberofchk,$chkname,$FGLH_ID,$status);
			$last_id = $this->db->insert_id();

			for($x = $fromno; $x<= $tono; $x++ ){
				$data = array(
					'CHEQUE_NO' => $x,
					'FCD_STATUS' => 'Available',
					'FCBD_ID' => $last_id
				);
				$this->db->insert('finance_cheque_detail',$data);
			}
			redirect(site_url()."finance/chequeDetails");
		}else{
			$FGLH_ID= @$_POST['bankcheque'];
			$numberofchk  = @$_POST['numberofchk'];
			$chkname = @$_POST['chkname'];
			$FCBD_ID = @$_POST[''];

			$numRow=$this->obj_finance->getBookStatus($FGLH_ID);

			if($numRow>0){
				$status = "Available";
			} else {
				$status = "Active";
			}

			$user=$this->obj_finance->putChequeDetails($chkbookno,$fromno,$tono,$numberofchk,$chkname,$FGLH_ID,$status);
			$last_id = $this->db->insert_id();

			for($x = $fromno; $x<= $tono; $x++ ){
				$data = array(
					'CHEQUE_NO' => $x,
					'FCD_STATUS' => 'Available',
					'FCBD_ID' => $last_id
				);
				$this->db->insert('finance_cheque_detail',$data);
			}
			redirect(site_url()."finance/chequeDetailsPayment");
		}
	}

	public function activateChequeBook(){
		if(isset($_POST)){
			$fcbdid = $this->input->post('fcbdid');
			$baseurl = $this->input->post('baseurl');
		}
		$sql="UPDATE finance_cheque_book_details SET FCBD_STATUS ='Active' where FCBD_ID = '$fcbdid'";
		$this->db->query($sql);
		redirect($baseurl);
	}

	public function activateCancelledCheque(){
		if(isset($_POST)){
			// $activatefcdid = $this->input->post('activatefcdid');
			// $activateFcbdid = $this->input->post('activateFcbdid');
			$activateFcbdid = $this->input->post('fcbdid');
			$activatefcdid = $this->input->post('fcdid');
		}
		$userId= $_SESSION['userId'];
		$sql="UPDATE finance_cheque_detail SET FCD_STATUS ='Available',CHEQUE_CANCELLED_NOTES ='',USER_ID = $userId where FCD_ID = '$activatefcdid'";
		$this->db->query($sql);

		$sql2="UPDATE finance_cheque_book_details SET FCBD_STATUS ='Active' where FCBD_ID = '$activateFcbdid'";
		$this->db->query($sql2);
		redirect(site_url()."finance/individualChequeDetails");
	}
	
	public function displayBalanceSheet() {	//TS
		// $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		// $_SESSION['actual_link'] = $actual_link;
		$newCondition = " OR RP_TYPE = 'OP'";
       // committe id code
       		if(@$_POST['CommitteeId']){
       			$data['compId'] = $compId = @$_POST['CommitteeId'];
       		} else {
       			$data['compId'] = $compId = "";
       		}
       		if(@$_POST['fromBsDate'] && @$_POST['toBsDate']){
			$data['fromDate'] = $fromDate = @$_POST['fromBsDate'];            
			$data['toDate'] = $toDate = @$_POST['toBsDate'];
			$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate(@$_POST['fromBsDate']);
			$formatted_date = date("d-m", strtotime(@$_POST['fromBsDate']));

			if($formatted_date == "01-04"){
				$fromDate = $fromRP_OP =  @$_POST['fromBsDate'];
				$toDate = $toRP_OP =  @$_POST['toBsDate'];
				$newCondition = "OR RP_TYPE = 'OP'";
				
				
			} else {								
				$fromRP_OP = "01-04-".explode("-",$finYear)[0];
				$toRP_OP = date("d-m-Y", strtotime(@$_POST['fromBsDate']."-1 day"));
				$newCondition = "OR RP_TYPE = 'OP'"; 
				
				$fromDate = @$_POST['fromBsDate'] ;
				$toDate = @$_POST['toBsDate'];
			}
			$data['fromDate'] = @$_POST['fromBsDate'];
			$data['toDate'] = @$_POST['toBsDate'];
		  		   
		} else {
			   
			$maxYear = $this->obj_shashwath->getfinyear();	
			$data['fromDate'] = $fromDate  = $fromRP_OP= $fromReceiptDate = '01-04-'.($maxYear-1);
			$data['toDate'] = $toDate  = $toReceiptDate = $toRP_OP = '31-03-'.($maxYear);
			$data['FinancialYear'] = $this->obj_finance->getFinYearBasedOnDate($fromDate);	
		
		}
	    $minDate =   $this->obj_finance->getledgerdate();
		$data['ledgerFinanceDate'] =  $this->obj_finance->getledgerdate();

		$data['openedRowsActive'] =  @$_POST['openedRowsActive'];
		$data['committee'] =  $this->obj_finance->getCommittee();
		$data['difference'] =  $this->obj_finance->getDifference($fromDate,$toDate,$compId);
		$groupBy = "GROUP BY financial_ledger_transcations.COMP_ID";
		$data['splitDifference'] =  $this->obj_finance->getDifference($fromDate,$toDate,$compId,$groupBy);
		$data['assets'] =  $this->obj_finance->getAssets($fromRP_OP,$fromDate,$toDate,$compId,$newCondition);
		$data['Cash'] =  $this->obj_finance->getCash($fromDate,$toDate,$compId);
		$data['liablities']=$this->obj_finance->getLiablities($fromRP_OP,$fromDate,$toDate,$compId,$newCondition);	
		$this->load->view('header',$data);           	
		$this->load->view('financeBalanceSheet',$data);
		$this->load->view('footer_home');
	}

	public function displayIncomeAndExpenditure() {	//TS
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;	

		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}
		if(@$_POST['fromIe'] && @$_POST['toIe']){

			$data['fromDate'] = $fromIncomeDate =  @$_POST['fromIe'];
			$fromDate =  $this->obj_finance->getledgerdate();
			$data['toDate'] = $toDate = $toIncomeDate  = @$_POST['toIe'];
			$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate(@$_POST['fromIe']);
           
		} else {
		   $maxYear = $this->obj_shashwath->getfinyear();	
			$data['fromDate'] = $fromDate  = $fromIncomeDate = '01-04-'.($maxYear-1);
			$data['toDate'] = $toDate =  $toIncomeDate = '31-03-'.($maxYear);
			$data['FinancialYear'] = $this->obj_finance->getFinYearBasedOnDate($fromDate);	
		}
		$minDate =   $this->obj_finance->getledgerdate();
		$data['ledgerFinanceDate'] =  $this->obj_finance->getledgerdate();

		$data['openedRowsActive'] =  @$_POST['openedRowsActive'];
		$data['committee'] =  $this->obj_finance->getCommittee();
		$data['difference'] =  $this->obj_finance->getDifference($fromIncomeDate,$toIncomeDate,$compId);
		$groupBy = "GROUP BY financial_ledger_transcations.COMP_ID";

		$data['splitDifference'] =  $this->obj_finance->getDifference($fromIncomeDate,$toIncomeDate,$compId,$groupBy);
		$data['income']=$this->obj_finance->getIncome($fromIncomeDate,$toIncomeDate,$compId);
		$data['Cash'] =  $this->obj_finance->getCash($fromIncomeDate,$toIncomeDate,$compId);
		$data['expence']=$this->obj_finance->getExpence($fromIncomeDate,$toIncomeDate,$compId);
		$this->load->view('header',$data);    
	   	
		$this->load->view('financeIncomeAndExpense',$data);
		$this->load->view('footer_home');
	}

	public function displayReceiptAndPayment() {	//TS
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
        $newCondition = " AND RP_TYPE = 'OP'";
        // new code added by adithya start

		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}		
        
		if(@$_POST['fromRP'] && @$_POST['toRP']) {
			$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate(@$_POST['fromRP']);
            $date = date(@$_POST['fromRP']);
			$formatted_date = date("d-m", strtotime(@$_POST['fromRP']));

			if($formatted_date == "01-04"){
				$fromReceiptDate = @$_POST['fromRP'];
				$toReceiptDate = @$_POST['toRP'];

				$newCondition = " AND RP_TYPE = 'OP'";

				$fromRP_OP = @$_POST['fromRP'];
				$toRP_OP = @$_POST['toRP'];
			} else {				
				//For Opening Balance Dates				
				$fromRP_OP = "01-04-".explode("-",$finYear)[0];
				$toRP_OP = date("d-m-Y", strtotime(@$_POST['fromRP']."-1 day"));				
				
				//For Receipts and Payments Query
				$fromReceiptDate = @$_POST['fromRP'] ;
				$toReceiptDate = @$_POST['toRP'];
				$newCondition = "";
			}
			$data['fromDate'] = @$_POST['fromRP'];
			$data['toDate'] = @$_POST['toRP'];
		} else {
			$maxYear = $this->obj_shashwath->getfinyear();	
			$data['fromDate'] = $fromDate = $fromRP_OP = $fromReceiptDate = '01-04-'.($maxYear-1);
			
			$data['toDate'] = $toDate =  $toRP_OP = $toReceiptDate = '31-03-'.($maxYear);
			
			$data['FinancialYear'] = $this->obj_finance->getFinYearBasedOnDate($fromDate);			
		}

		$minDate =   $this->obj_finance->getledgerdate();
		$data['ledgerFinanceDate'] =  $this->obj_finance->getledgerdate();

		$data['openedRowsActive'] =  @$_POST['openedRowsActive'];
		$data['committee'] =  $this->obj_finance->getCommittee();
		$data['receipt'] =  $this->obj_finance->getReceipt($fromReceiptDate,$toReceiptDate,$compId);
		$data['opening'] =  $this->obj_finance->getOpening($fromRP_OP,$toRP_OP,$compId,$newCondition);
		$data['Cash'] =  $this->obj_finance->getCash($fromReceiptDate,$toReceiptDate,$compId);

		$data['payment']=$this->obj_finance->getPayment($fromReceiptDate,$toReceiptDate,$compId);	

		$data['closing']=$this->obj_finance->getClosing($fromRP_OP ,$fromReceiptDate,$toReceiptDate,$compId);	
		$this->load->view('header',$data);
		$this->load->view('financeReceiptAndPayment',$data);
		$this->load->view('footer_home');	
	}

	public function displayTrialBalance() {		//TS
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;


		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}
		
		if(@$_POST['fromTB'] && @$_POST['toTB']){
			$data['fromDate'] = $fromDate = @$_POST['fromTB'];
			$data['toDate'] = $toDate = @$_POST['toTB'];
			$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate(@$_POST['fromTB']);
		} else {
			$maxYear = $this->obj_shashwath->getfinyear();	
			$data['fromDate'] = $fromDate  = $fromReceiptDate = '01-04-'.($maxYear-1);
			$data['toDate'] = $toDate  = $toReceiptDate = '31-03-'.($maxYear);
			$data['FinancialYear'] = $this->obj_finance->getFinYearBasedOnDate($fromDate);	
		}
		$minDate =   $this->obj_finance->getledgerdate();
		$data['ledgerFinanceDate'] =  $this->obj_finance->getledgerdate();

		$data['committee'] =  $this->obj_finance->getCommittee();
		$data['trialData'] =  $this->obj_finance->getTrialData($fromDate,$toDate,$compId);
		$this->load->view('header',$data);           	
		$this->load->view('financeTrialBalancePage',$data);
		$this->load->view('footer_home');		
	}	
	
	// finance voucher COUNTER
	public function voucherCounter() {
		$data['finance_voucher_counter'] = $this->obj_finance->get_finance_voucher_counter_setting();
		// $data['admin_settings_receipt'] = $this->obj_admin_settings->get_deity_receipt_setting();,$data
		$this->load->view('header', $data);
		$this->load->view('financeVoucherCounter',$data);
		$this->load->view('footer_home');
	}

	//UPDATE FINANCE VOUCHER COUNTER
	public function update_finance_voucher_counter() {
		$data = array('FVC_COUNTER' => 0);
		$condition = array('FVC_ID' => $_POST['id']); 
		$this->obj_finance->edit_finance_voucher_counter_modal($condition,$data);
		echo "Success";
	}

	//EDIT FINANCE VOUCHER DETAILS
	public function edit_finance_voucher_details($id) {
		$data['id'] = $id;
		$condition = array('FVC_ID' => $id);
		$data['receipt_deity'] = $this->obj_finance->get_finance_voucher_counter_setting($condition);
		
		$this->load->view('header',$data);           
		$this->load->view('edit_financeVoucherCounter');
		$this->load->view('footer_home');
	}

	//For Edit Finance Voucher  details
	public function save_finance_voucher_details(){
		$data = array('FVC_ABBR1' => $_POST['receipt_for'], 'FVC_ABBR2' => $_POST['receipt_format']);
		$condition = array('FVC_ID' => $_POST['receiptid']); 
		$this->obj_finance->edit_finance_voucher_counter_modal($condition,$data);
		redirect('/finance/voucherCounter/');
	}

	public function get_financial_year($month) {
		$dbFinMth = $month->MONTH_IN_NUMBER; //getting value from the database for start financial month 
		$currFinMth = date('n');
		if($dbFinMth == 1) {
			$fYear = date('Y');
		} else {
			if($currFinMth >= $dbFinMth && $currFinMth <= 12) {
				$year1 = date('Y');
				$year2 = $year1 + 1; 
			}
			if($currFinMth >= 1 && $currFinMth <= $dbFinMth - 1) {
				$year1 = date('Y')-1;
				$year2 = date('Y');
			}
			$fYear = $year1.'-'.substr($year2,2,2);
		}
		return $fYear;
	}

	// finance voucher COUNTER
	public function Prerequisites() {
		$data['user'] =  $_SESSION['userId'];
		$data['fyear'] = $this->obj_finance->get_finance_prerequisites();
		$this->load->view('header',$data);
		$this->load->view('financePrerequisites');
		$this->load->view('footer_home');
	}

	public function save_finance_prerequisites(){
		// echo $_POST['todayDate'];
		// echo @$_POST['toDate'];
		$dateTime = date('d-m-Y H:i:s A');
		$todayDate = @$_POST['todayDate'];
		$toDate = @$_POST['toDate'];
		$userId= $_SESSION['userId'];
		$data = array('FP_FIN_BEGIN_DATE' => $todayDate,'FP_BOOKS_BEGIN_DATE' => $toDate,'DATE_TIME' => $dateTime,'USER_ID' => $userId);
		$this->obj_finance->update_finance_prerequisites($data);
		$data['fyear'] = $this->obj_finance->get_finance_prerequisites();
		redirect(site_url()."finance/Prerequisites");
	}

	//chequeConfiguration, $data
	function chequeConfiguartion($start=0) {
		$this->load->library('pagination');
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

		$data['chequeConfiguartion'] = $this->obj_finance->get_chequeConfiguartion_details(10,$start);
			// $fglh_id = @$_POST['FGLH_ID'];$fglh_id
			//$data['chequeCount'] = $this->obj_finance->count_rows_chequeCountConfiguartion();
		$data['bankCount'] = $this->obj_finance->count_rows_chequeConfiguartion();
		$config['base_url'] = base_url().'finance/chequeConfiguartion';
		$config['total_rows']= $this->obj_finance->count_rows_chequeConfiguartion();
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('financeChequeConfig');
		$this->load->view('footer_home');
	}

	function chequeDetails($start=0) {
		$this->load->library('pagination');
		if(@$_POST['FGLH_ID']){
			$data['FGLH_ID'] = $_SESSION['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
			$data['BANK_NAME'] = $_SESSION['BANK_NAME'] = @$_POST['BANK_NAME'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'] = @$_POST['FGLH_NAME'];

		} else {
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
			$data['BANK_NAME'] = $_SESSION['BANK_NAME'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'];

		}

		$data['chequeDetail'] = $this->obj_finance->get_cheque_details(10,$start,$FGLH_ID);
					
		$config['base_url'] = $data['base_url'] =  base_url().'finance/chequeDetails';
		$config['total_rows']= $data['chequeCount'] = $this->obj_finance->count_rows_cheque_details($FGLH_ID);

		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';        
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header',$data);
		$this->load->view('chequeDetails');
		$this->load->view('footer_home');
	}

	function chequeDetailsPayment($start=0) {
		$this->load->library('pagination');
		
		if(@$_POST['bankcheque']){
			$data['bankcheque'] = $_SESSION['bankcheque'] = $bankcheque = @$_POST['bankcheque'];
			$data['FGLH_NAME'] = $_SESSION['bank_fglh_name'] = $FGLH_NAME = @$_POST['bank_fglh_name'];
		}else {
			$data['bankcheque'] = $bankcheque = $_SESSION['bankcheque'];
			$data['FGLH_NAME'] = $FGLH_NAME = $_SESSION['bank_fglh_name'];
		}

		$data['chequeDetail'] = $this->obj_finance->get_cheque_details(10,$start,$bankcheque);
		//$data['FGLH_NAME'] = $this->obj_finance->get_cheque_detailsname($bankcheque);
					
		$config['base_url'] = $data['base_url'] = base_url().'finance/chequeDetailsPayment';
		$config['total_rows']= $data['chequeCount'] = $this->obj_finance->count_rows_cheque_details($bankcheque);

		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';        
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header',$data);
		$this->load->view('chequeDetails');
		$this->load->view('footer_home');
	}

	public function multipaymentCheque() {
		$fcbid= $this->input->post('fcbid');
		 $chequestatus = $this->input->post('chequestatus');
		$chequeno = $this->input->post('chequeno');
		
		$user=$this->obj_finance->putmultiPaymentCheque($fcbid,$chequestatus,$chequeno);
		redirect(site_url()."finance/individualChequeDetails");		
	}

	public function deletemultipaymentCheque() {
		$fcdidno= $this->input->post('fcdidno');
		$user=$this->obj_finance->deletemultiPaymentCheque($fcdidno);
		redirect(site_url()."finance/individualChequeDetails");
	}

	public function cancelCheque() {
		$cancellationRedirectPath= $this->input->post('cancellationRedirectPath');
		$chequeCancellationNotes = str_replace("'","\'",$this->input->post('chequeCancellationNotes'));
		$chequeNumber = $this->input->post('cancellationChequeNumber');
		$chequeStatus = $this->input->post('cancellationChequeStatus');
		$voucherNo = $this->input->post('cancellationVoucherNo');
		if($cancellationRedirectPath=="IndividualChequeDetails"){
			$cancellationFcdid= $this->input->post('cancellationFcdid');	
			$cancellationFcbdid= $this->input->post('cancellationFcbdid');	
			$cancellationFglhId= $this->input->post('cancellationFglhId');	
		} else if($cancellationRedirectPath=="deityChequeRemmittance" || $cancellationRedirectPath=="eventChequeRemmittance"){
			$sqlcheque ="SELECT * FROM `finance_cheque_detail` JOIN `finance_cheque_book_details` ON `finance_cheque_detail`.`FCBD_ID` = `finance_cheque_book_details`.`FCBD_ID` WHERE VOUCHER_NO = '$voucherNo' AND CHEQUE_NO = $chequeNumber ";
			$queryCheque = $this->db->query($sqlcheque);
			$resultCheque=$queryCheque->result();
			$cancellationFcdid= $resultCheque[0]->FCD_ID;	
			$cancellationFcbdid= $resultCheque[0]->FCBD_ID;
			$cancellationFglhId= $resultCheque[0]->FGLH_ID;
		}
		$userId= $_SESSION['userId'];
		if($chequeStatus == 'Unreconciled') {
			$sql="UPDATE financial_ledger_transcations SET 	PAYMENT_STATUS ='Cancelled' where VOUCHER_NO = '$voucherNo'";
			$this->db->query($sql);
			$sql1="UPDATE finance_cheque_detail SET FCD_STATUS ='Cancelled',CHEQUE_CANCELLED_NOTES ='$chequeCancellationNotes',FLT_DATE='', USER_ID ='$userId'  where VOUCHER_NO = '$voucherNo'";
			$this->db->query($sql1);
		}else if($chequeStatus == 'Available'){
			$sql="UPDATE finance_cheque_detail SET FCD_STATUS ='Cancelled',CHEQUE_CANCELLED_NOTES ='$chequeCancellationNotes',FLT_DATE='', USER_ID ='$userId'  where FCD_ID = '$cancellationFcdid'";
			$this->db->query($sql);
		}

		//newcode
		$sql1 ="SELECT COUNT(FCD_ID) as getCount FROM `finance_cheque_detail` JOIN finance_cheque_book_details ON finance_cheque_detail.FCBD_ID=finance_cheque_book_details.FCBD_ID WHERE FCD_STATUS='Available' AND FCBD_STATUS='Active' AND finance_cheque_detail.FCBD_ID = $cancellationFcbdid";
		$query = $this->db->query($sql1);
		$AvailChequescount =  $query->row()->getCount;
		if($AvailChequescount==0){
			$sql2 ="SELECT FCBD_ID FROM `finance_cheque_book_details` WHERE FGLH_ID=$cancellationFglhId AND FCBD_STATUS='Available'";
			$query2 = $this->db->query($sql2);
			if($query2->num_rows()>0){
				$FRISTFCBD_ID =  $query2->row()->FCBD_ID;
			}else{$FRISTFCBD_ID ="";}
			$sql3 ="UPDATE `finance_cheque_book_details` SET FCBD_STATUS='Expired' WHERE FCBD_STATUS='Active' AND FCBD_ID = $cancellationFcbdid" ; 
  			$this->db->query($sql3);
  			if($FRISTFCBD_ID){
  				$sql4 ="UPDATE `finance_cheque_book_details` SET FCBD_STATUS='Active' WHERE FCBD_ID=$FRISTFCBD_ID" ; 
  				$this->db->query($sql4);
  			}
		}
		//new code end
		if($cancellationRedirectPath=="deityChequeRemmittance"){
			redirect(site_url()."admin_settings/Admin_setting/deityChequeRemmittance");
		}else if($cancellationRedirectPath=="eventChequeRemmittance"){
			redirect(site_url()."admin_settings/Admin_setting/chequeRemmittance");
		} 
		else {
			redirect(site_url()."finance/individualChequeDetails");
		}
	}

	function replaceChequeDetails(){
		$replaceChequeNo= $this->input->post('replaceChequeNo');
		$replaceReceiptChequeCancelledNotes = trim(str_replace("'","\'",$this->input->post('replaceReceiptChequeCancelledNotes')));
		$replaceChequedate = $this->input->post('replaceChequedate');
		$replaceBank = $this->input->post('replaceBank');
		$replaceBranch = $this->input->post('replaceBranch');
		$replaceVoucherNo = $this->input->post('replaceVoucherNo');
		$replaceReceiptId = $this->input->post('replaceReceiptId');
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');

		$sql1="UPDATE financial_ledger_transcations SET PAYMENT_STATUS ='Waiting',CHEQUE_NO='$replaceChequeNo', FLT_DEPOSIT_PAYMENT_DATE='$date', BANK_NAME='$replaceBank',	BRANCH_NAME='$replaceBranch',CHEQUE_DATE='$replaceChequedate',RECEIPT_CHEQUE_CANCEL_NOTES='$replaceReceiptChequeCancelledNotes' where VOUCHER_NO = '$replaceVoucherNo'";
		$this->db->query($sql1);

		if($replaceReceiptId !=0){
			$sql2="UPDATE deity_receipt SET CHEQUE_NO='$replaceChequeNo', CHEQUE_DATE='$replaceChequedate', BANK_NAME='$replaceBank', BRANCH_NAME='$replaceBranch' where RECEIPT_ID = '$replaceReceiptId'";
			$this->db->query($sql2);
			
			$sql3="UPDATE deity_user_collection SET DUC_CHEQUE_NO='$replaceChequeNo', DUC_CHEQUE_DATE='$replaceChequedate', DUC_BANK_NAME='$replaceBank', DUC_BRANCH_NAME='$replaceBranch', DUC_IS_DEPOSITED=0, DUC_LEDGER_ID='', DUC_DEPOSIT_DATE='' where RECEIPT_ID = '$replaceReceiptId'";
			$this->db->query($sql3);
		}

		redirect(site_url()."admin_settings/Admin_setting/deityChequeRemmittance");
	}

	function replaceEventChequeDetails(){
		$replaceChequeNo= $this->input->post('replaceChequeNo');
		$replaceReceiptChequeCancelledNotes = trim(str_replace("'","\'",$this->input->post('replaceReceiptChequeCancelledNotes')));
		$replaceChequedate = $this->input->post('replaceChequedate');
		$replaceBank = $this->input->post('replaceBank');
		$replaceBranch = $this->input->post('replaceBranch');
		$replaceVoucherNo = $this->input->post('replaceVoucherNo');
		$replaceReceiptId = $this->input->post('replaceReceiptId');
		$userId= $_SESSION['userId'];
		$date = date('d-m-Y');

		$sql1="UPDATE financial_ledger_transcations SET PAYMENT_STATUS ='Waiting',CHEQUE_NO='$replaceChequeNo', FLT_DEPOSIT_PAYMENT_DATE='$date', BANK_NAME='$replaceBank',	BRANCH_NAME='$replaceBranch',CHEQUE_DATE='$replaceChequedate',RECEIPT_CHEQUE_CANCEL_NOTES='$replaceReceiptChequeCancelledNotes' where VOUCHER_NO = '$replaceVoucherNo'";
		$this->db->query($sql1);

		if($replaceReceiptId !=0){
			$sql2="UPDATE event_receipt SET CHEQUE_NO='$replaceChequeNo', CHEQUE_DATE='$replaceChequedate', BANK_NAME='$replaceBank', BRANCH_NAME='$replaceBranch' where ET_RECEIPT_ID = '$replaceReceiptId'";
			$this->db->query($sql2);
			
			$sql3="UPDATE event_user_collection SET EUC_CHEQUE_NO='$replaceChequeNo', EUC_CHEQUE_DATE='$replaceChequedate', EUC_BANK_NAME='$replaceBank', EUC_BRANCH_NAME='$replaceBranch', EUC_IS_DEPOSITED=0, EUC_LEDGER_ID='', EUC_DEPOSIT_DATE='' where ET_RECEIPT_ID = '$replaceReceiptId'";
			$this->db->query($sql3);
		}
		redirect(site_url()."admin_settings/Admin_setting/ChequeRemmittance");
	}

	function individualChequeDetails($start=0) {
		if(@$_POST['FCBD_ID']){
			$data['FCBD_ID'] = $_SESSION['FCBD_ID'] = $FCBD_ID = @$_POST['FCBD_ID'];
			$data['CHEQUE_BOOK_NAME'] = $_SESSION['CHEQUE_BOOK_NAME'] = @$_POST['CHEQUE_BOOK_NAME'];
		} else {
			$data['FCBD_ID'] = $FCBD_ID = $_SESSION['FCBD_ID'];
			$data['CHEQUE_BOOK_NAME'] = $_SESSION['CHEQUE_BOOK_NAME'];
		}
		$data['indChequeDetail'] = $this->obj_finance->get_ind_cheque_details(15,$start,$FCBD_ID);

		$config['base_url'] = base_url().'finance/individualChequeDetails';
		$config['total_rows']= $data['indChequeCount'] = $this->obj_finance->count_rows_ind_cheque_details($FCBD_ID);
		$config['per_page'] = 15;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header',$data);
		$this->load->view('individualChequeDetails');
		$this->load->view('footer_home');
	}

	function addbank($start=0) {
		$this->load->library('pagination');
		$data['addbank'] = $this->obj_finance->get_all_payment_method_details();
		$data['bank'] = $this->obj_finance->get_banks();					 //laz new..
		$config['total_rows']= $data['bankCount'] = $this->obj_finance->count_rows_bank_details();
		$config['base_url'] = base_url().'finance/addbank';

		$this->load->view('header',$data);           
		$this->load->view('addBank');
		$this->load->view('footer_home');
	}

	function updateBankDetails(){
		$RECEIPT_ID = @$_POST['id'];
		$tobank = @$_POST['bank1'];
		$this->obj_finance->update_all_payment_method_bank_details($RECEIPT_ID,$tobank);
		redirect(site_url()."finance/addBank");
	}

	function addEventBank($start=0) {
		$this->load->library('pagination');
		$data['addbank'] = $this->obj_finance->get_all_event_payment_method_details();
		$data['bank'] = $this->obj_finance->get_banks();					 //laz new..
		$config['total_rows']= $data['bankCount'] = count($this->obj_finance->get_all_event_payment_method_details());
		$config['base_url'] = base_url().'finance/addEventBank';

		$this->load->view('header',$data);           
		$this->load->view('addEventBank');
		$this->load->view('footer_home');
	}

	function updateEventBankDetails(){
		$RECEIPT_ID = @$_POST['id'];
		$tobank = @$_POST['bank1'];
		$this->obj_finance->update_all_event_payment_method_bank_details($RECEIPT_ID,$tobank);
		redirect(site_url()."finance/addEventBank");
	}

	function dayBook($start=0) {
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		$data['radioOpt'] = $radioOpt;
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['fromDate']);
		unset($_SESSION['toDate']);
		unset($_SESSION['voucherType']);
		unset($_SESSION['paymentType']);

		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}

		if(isset($_POST['voucherType'])){
			$_SESSION['voucherType'] = $this->input->post('voucherType');
			$voucherType = $this->input->post('voucherType');
			$data['voucherType'] = $voucherType;

		} else if(isset($_SESSION['voucherType'])) {
			$voucherType = $_SESSION['voucherType'];
			$data['voucherType'] = $voucherType;
		} else {
			$data['voucherType'] = $voucherType = '';

		}

		if(isset($_POST['paymentType'])){
			$_SESSION['paymentType'] = $this->input->post('paymentType');
			$paymentType = $this->input->post('paymentType');
			$data['paymentType'] = $paymentType;

		} else if(isset($_SESSION['paymentType'])) {
			$paymentType = $_SESSION['paymentType'];
			$data['paymentType'] = $paymentType;
		} else {
			$data['paymentType'] =	$paymentType = '';
		}

	


		$data['date'] = date('d-m-Y');
		$fromDate = date("d-m-Y");
		$data['dayBook']= $this->obj_finance->get_dayBook_details($fromDate,'',10,$start,$compId,$voucherType,$paymentType);
		$data['committee'] =  $this->obj_finance->getCommittee();
		// $condition = ("AND finacial_group_ledger_heads.FGLH_ID !=21");
		$condition = '';
		$data['accountOp'] =  $this->obj_finance->getAccountOpBal($condition,$compId,$fromDate);
		$data['accountClosing'] =  $this->obj_finance->getAccountClosingBal($condition,$compId,$fromDate);

		$this->load->library('pagination');
		$data['bookCount']=$config['total_rows'] = $this->obj_finance->count_rows_dayBook($fromDate,'',$compId,$voucherType,$paymentType);
		//$config['base_url'] = base_url().'finance/dayBook';
		$config['base_url'] = $data['base_url'] =  base_url().'finance/dayBook';
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('financeDayBook');
		$this->load->view('footer_home');
	}


	//DEITY RECEIPT REPORT ON CHANGE OF FIELD
	function day_book_on_change_date($start = 0) {
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
			//For Menu Selection
		$data['whichTab'] = "finance";
		
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}

		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}

		if(isset($_POST['voucherType'])){
			$_SESSION['voucherType'] = $this->input->post('voucherType');
			$voucherType = $this->input->post('voucherType');
			$data['voucherType'] = $voucherType;

		} else if(isset($_SESSION['voucherType'])) {
			$voucherType = $_SESSION['voucherType'];
			$data['voucherType'] = $voucherType;
		} else {
			$data['voucherType'] =	$voucherType = '';

		}

		if(isset($_POST['paymentType'])){
			$_SESSION['paymentType'] = $this->input->post('paymentType');
			$paymentType = $this->input->post('paymentType');
			$data['paymentType'] = $paymentType;

		} else if(isset($_SESSION['paymentType'])) {
			$paymentType = $_SESSION['paymentType'];
			$data['paymentType'] = $paymentType;
		} else {
			$data['paymentType'] =	$paymentType = '';

		}
		
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDate'])) {
			$fromDate = @$_POST['fromDate'];
			$toDate = @$_POST['toDate'];
			$_SESSION['fromDate'] = $fromDate;
			$_SESSION['toDate'] = $toDate;
		} else {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
		}
		
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		
		if(@$_POST['tdate']) {
			unset($_SESSION['date']);
			$data['date'] = $this->input->post('tdate');
			$date = $this->input->post('tdate');
		}
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('tdate'));
			$data['date'] = $_SESSION['date'];
			$date = $this->input->post('tdate');
		} else {
			$date = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}
		// $condition = ("AND finacial_group_ledger_heads.FGLH_ID !=21");
		$condition = '';
		$this->load->library('pagination');
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$data['dayBook'] = $this->obj_finance->get_dayBook_details($_SESSION['fromDate'],$_SESSION['toDate'],10,$start, $compId,$voucherType,$paymentType);
			$data['bookCount']=$config['total_rows'] = $this->obj_finance->count_rows_dayBook($fromDate,$toDate,$compId,$voucherType,$paymentType);	
			$data['accountOp'] =  $this->obj_finance->getAccountOpBal($condition,$compId,$_SESSION['fromDate']);	
			$data['accountClosing'] =  $this->obj_finance->getAccountClosingBal($condition,$compId,$_SESSION['toDate']);
		} else {
			$data['dayBook'] = $this->obj_finance->get_dayBook_details($_SESSION['date'],'',10,$start,$compId,$voucherType,$paymentType);
			$data['bookCount']=$config['total_rows'] = $this->obj_finance->count_rows_dayBook($_SESSION['date'],'',$compId,$voucherType,$paymentType);
			$data['accountOp'] =  $this->obj_finance->getAccountOpBal($condition,$compId,$_SESSION['date']);
			$data['accountClosing'] =  $this->obj_finance->getAccountClosingBal($condition,$compId,$_SESSION['date']);
		}
		$config['base_url'] = $data['base_url'] =  base_url().'finance/day_book_on_change_date';
			
		//$config['base_url'] = base_url().'finance/day_book_on_change_date';
		$data['committee'] =  $this->obj_finance->getCommittee();
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header', $data);
		$this->load->view('financeDayBook');
		$this->load->view('footer_home');
	}

	//CHECK
	function day_book_on_check_date($start = 0) {
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		if(isset($_POST['fromDate'])) {
			$fromDate = @$_POST['fromDate'];
			$toDate = @$_POST['toDate'];
			$_SESSION['fromDate'] = $fromDate;
			$_SESSION['toDate'] = $toDate;
		} else {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
		}
		if(@$_POST['tdate']) {
			unset($_SESSION['date']);
			$data['date'] = $this->input->post('tdate');
			$date = $this->input->post('tdate');
		}
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('tdate'));
			$data['date'] = $_SESSION['date'];
			$date = $this->input->post('tdate');
		} else {
			$date = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}

		$data['fromCheckDate'] = $fromCheckDate = $this->obj_finance->getledgerdate();
		$curtimestamp1 = strtotime($fromDate);
   		$curtimestamp2 = strtotime($fromCheckDate);
   		$curtimestamp3 = strtotime($date);

		if($curtimestamp1 > $curtimestamp2 || $curtimestamp3 > $curtimestamp2){		
			redirect('/finance/day_book_on_change_date/');
		}else{
		//	redirect('/Report/temple_day_book/');
			redirect('/finance/day_book_on_change_date/');

		}

		// if($curtimestamp3 > $curtimestamp2 ){		
		// 	redirect('/finance/day_book_on_change_date/');
		// }else{
		// 	redirect('/Report/temple_day_book/');
		// }
	}


	function dayBookDetail($start=0) {
		$data['whichTab'] = 'Finance';
		$this->load->library('pagination');
		if(@$_POST['FGLH_ID']){
			$data['FGLH_ID'] = $_SESSION['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'] = @$_POST['FGLH_NAME'];
			$data['VOUCHER_NO'] = $_SESSION['VOUCHER_NO'] =$VOUCHER_NO= @$_POST['VOUCHER_NO'];
			$data['FLT_DATE'] = $_SESSION['FLT_DATE'] =$FLT_DATE= @$_POST['FLT_DATE'];
		} else {
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
			$data['VOUCHER_NO'] = $VOUCHER_NO= $_SESSION['VOUCHER_NO'];
			$data['FLT_DATE'] = $FLT_DATE= $_SESSION['FLT_DATE'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'];			
		}
		$data['dayBookDetail'] = $this->obj_finance->get_day_Book_details($VOUCHER_NO,$FLT_DATE);
		$data['voucherType'] = $this->obj_finance->get_day_Book_details_vouchertype($VOUCHER_NO,$FLT_DATE);
		$data['naration'] = $this->obj_finance->get_day_Book_details_narration($VOUCHER_NO,$FLT_DATE);
		$data['chequeno'] = $this->obj_finance->get_day_Book_details_chequeno($VOUCHER_NO,$FLT_DATE);
		$data['chequedate'] = $this->obj_finance->get_day_Book_details_chequedate($VOUCHER_NO,$FLT_DATE);
			//$config['total_rows']= $data['chequeCount'] = $this->obj_finance->count_rows_cheque_details($FGLH_ID);
		$data['base_url'] = $baseurl = $this->input->post('baseurl');
		$config['base_url'] = base_url().'finance/financeDayBookDetails';
	
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';        
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header');
		$this->load->view('financeDayBookDetails',$data);
		$this->load->view('footer_home');
	}

	function finance_day_book_excel() {		//TS R
		$data['whichTab'] = "finance";
		if(@$_POST['CommitteeIdVal']){
			$data['compId'] = $compId = @$_POST['CommitteeIdVal'];
		} else {
			$data['compId'] = $compId = "";
		}
		
		if(isset($_POST['voucherType'])){
			$_SESSION['voucherType'] = $this->input->post('voucherType');
			$voucherType = $this->input->post('voucherType');
			$data['voucherType'] = $voucherType;

		} else if(isset($_SESSION['voucherType'])) {
			$voucherType = $_SESSION['voucherType'];
			$data['voucherType'] = $voucherType;
		} else {
			$data['voucherType'] =	$voucherType = '';

		}

		if(isset($_POST['paymentType'])){
			$_SESSION['paymentType'] = $this->input->post('paymentType');
			$paymentType = $this->input->post('paymentType');
			$data['paymentType'] = $paymentType;

		} else if(isset($_SESSION['paymentType'])) {
			$paymentType = $_SESSION['paymentType'];
			$data['paymentType'] = $paymentType;
		} else {
			$data['paymentType'] =	$paymentType = '';

		}

		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$finance_day_book = $this->obj_finance->get_dayBook_details_excel($_SESSION['fromDate'],$_SESSION['toDate'],'','',$compId,$voucherType,$paymentType);
			$filename = "Finance_Day_Book_from_".$_SESSION['fromDate']. "_to_".$_SESSION['toDate']; //File Name	
		} else if (@$_SESSION['date']){
			$finance_day_book= $this->obj_finance->get_dayBook_details_excel($_SESSION['date'],'','','',$compId,$voucherType,$paymentType);
			$filename = "Finance_Day_Book_from_".$_SESSION['date']; //File Name

		} else{
			$finance_day_book = $this->obj_finance->get_dayBook_details_excel(date("d-m-Y"),'','','',$compId,$voucherType,$paymentType);
			$filename = "Finance_Day_Book_from_".date("d-m-Y"); //File Name
		}

		$file_ending = "xls";
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		$header = "";
		
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "Date" . "\t";
		$header .= "Particular" . "\t";
		$header .= "Voucher Type" . "\t";
		$header .= "Voucher Number" . "\t";
		$header .= "Debit Amount" . "\t";
		$header .= "Credit Amount" . "\t";
		$result = "";
		$i = 0;
		foreach($finance_day_book as $res) {	
			if( $res->TRANSACTION_STATUS != "Cancelled"){			
				$value = "";
				$value .= '"' . (++$i) . '"' . "\t";			
				$value .= '"' . $res->FLT_DATE . '"' . "\t";
				$value .= '"' . $res->FGLH_NAME . '"' . "\t";	
				$value .= '"' . $res->VOUCHER_TYPE .'"'. "\t";
				$value .= '"' . $res->VOUCHER_NO .'"'. "\t";
				$value .= '"' . $res->FLT_DR .'"'. "\t";
				$value .= '"' . $res->FLT_CR .'"'. "\t";
				$result .= trim($value) . "\n";
			}
		}
		$result .= "\n";

		$value = "";
		$value .= '"Cancelled"'. "\t";
		$result .= trim($value) . "\n";

		$i = 0;
		foreach($finance_day_book as $res) {				
			if( $res->TRANSACTION_STATUS == "Cancelled"){			
				$value = "";
				$value .= '"' . (++$i) . '"' . "\t";			
				$value .= '"' . $res->FLT_DATE . '"' . "\t";
				$value .= '"' . $res->FGLH_NAME . '"' . "\t";	
				$value .= '"' . $res->VOUCHER_TYPE .'"'. "\t";
				$value .= '"' . $res->VOUCHER_NO .'"'. "\t";
				$value .= '"' . $res->FLT_DR .'"'. "\t";
				$value .= '"' . $res->FLT_CR .'"'. "\t";
				$result .= trim($value) . "\n";
			}
		}
		$result = str_replace( "\r" , "" , $result );
		print("$header\n$result"); 
	}

	// public function allGroupLedgerDetails($pageCall= "", $start = 0) {
		// 	$data['whichTab'] = 'Finance';

		// 	$pageSize = $data['pageSize'] = 13;
		// 	if($pageCall == "Group") {
		// 		unset($_SESSION['pageGroupStart']);
		// 		$_SESSION['pageGroupStart'] = $start;
		// 		if(!isset($_SESSION['pageLedgerStart'])) {
		// 			$_SESSION['pageLedgerStart'] = 0;
		// 		}
		// 	}
		// 	else if($pageCall == "Ledger") {
		// 		unset($_SESSION['pageLedgerStart']);
		// 		$_SESSION['pageLedgerStart'] = $start;
		// 		if(!isset($_SESSION['pageGroupStart'])) {
		// 			$_SESSION['pageGroupStart'] = 0;
		// 		}
		// 	} else {
		// 		$_SESSION['pageGroupStart'] = $start;
		// 		$_SESSION['pageLedgerStart'] = $start;
		// 	}

		// 	//FOR SEARCH CONDITIONS
		// 	if(isset($_POST['callFromGroup']) && $_POST['callFromGroup'] == "SearchGroup") {
		// 		if(isset($_POST['GroupName'])) {
		// 			unset($_SESSION['GroupName']);
		// 			$data['GroupName'] = $_SESSION['GroupName'] = $_POST['GroupName'];
		// 		} 
		// 		$cond_Groupsrch = "FGLH_NAME LIKE '%".str_replace("'","''",$_SESSION['GroupName'])."%'";
		// 		$cond_Ledgersrch = "";
		// 		$_SESSION['pageGroupStart']="";
		// 	} else if(isset($_POST['callFromLedger']) && $_POST['callFromLedger'] == "SearchLedger") {
		// 		if(isset($_POST['LedgerName'])) {
		// 			unset($_SESSION['LedgerName']);
		// 			$data['LedgerName'] = $_SESSION['LedgerName'] = $_POST['LedgerName'];
		// 		} 
		// 		$cond_Ledgersrch = "FGLH_NAME LIKE '%".str_replace("'","''",$_SESSION['LedgerName'])."%'";
		// 		$cond_Groupsrch = "";
		// 		$_SESSION['pageLedgerStart']="";
		// 	} else {
		// 		$cond_Groupsrch = "";
		// 		$cond_Ledgersrch = "";
		// 		$data['GroupName'] = "";
		// 		$data['LedgerName'] = "";
		// 	}

		// 	$data['parentDetails'] =  $this->obj_finance->getGroups();
		// 	$conditionGroup = "LEVELS!='MG' AND LEVELS!='LG'";
		// 	$data['allGroups'] = $this->obj_finance->getAllLedgerAndGroups($pageSize,$_SESSION['pageGroupStart'],$conditionGroup, $cond_Groupsrch);
		// 	$data['allGroupsCount'] = $config['total_rows'] = count($this->obj_finance->getAllLedgerAndGroups(0,0,$conditionGroup, $cond_Groupsrch));
			
		// 	if($pageCall == "Group" || $pageCall == "") {
		// 		$this->load->library('pagination');
		// 		$config['base_url'] = base_url().'finance/allGroupLedgerDetails/Group';
		// 		$config['per_page'] = $pageSize;
		// 		$config['prev_link'] = '&lt;&lt;';
		// 		$config['next_link'] = '&gt;&gt;';
		// 		$config['first_tag_open'] = '<li>';
		// 		$config['first_tag_close'] = '</li>';
		// 		$config['last_tag_open'] = '<li>';
		// 		$config['last_tag_close'] = '</li>';
		// 		$config['next_tag_open'] = '<li>';
		// 		$config['next_tag_close'] = '</li>';
		// 		$config['prev_tag_open'] = '<li>';
		// 		$config['prev_tag_close'] = '</li>';
		// 		$config['cur_tag_open'] = '<li class="active"><a>';
		// 		$config['cur_tag_close'] = '</a></li>';
		// 		$config['num_tag_open'] = '<li>';
		// 		$config['num_tag_close'] = '</li>';
		// 		$config['last_link'] = 'Last';
		// 		$config['first_link'] = 'First';
		// 		$this->pagination->initialize($config);
		// 		$_SESSION['pages1'] = $data['pages1'] = $this->pagination->create_links();
		// 	}

		// 	$conditionLedger = 	"LEVELS='LG'";
		// 	$data['allLedger'] = $this->obj_finance->getAllLedgerAndGroups($pageSize,$_SESSION['pageLedgerStart'],$conditionLedger,$cond_Ledgersrch);
		// 	$data['allLedgerCount'] = $config['total_rows'] = count($this->obj_finance->getAllLedgerAndGroups(0,0,$conditionLedger,$cond_Ledgersrch));

		// 	if($pageCall == "Ledger" || $pageCall == "") {
		// 		$this->load->library('pagination');
		// 		$config['base_url'] = base_url().'finance/allGroupLedgerDetails/Ledger';
		// 		$config['per_page'] = $pageSize;
		// 		$config['prev_link'] = '&lt;&lt;';
		// 		$config['next_link'] = '&gt;&gt;';
		// 		$config['first_tag_open'] = '<li>';
		// 		$config['first_tag_close'] = '</li>';
		// 		$config['last_tag_open'] = '<li>';
		// 		$config['last_tag_close'] = '</li>';
		// 		$config['next_tag_open'] = '<li>';
		// 		$config['next_tag_close'] = '</li>';
		// 		$config['prev_tag_open'] = '<li>';
		// 		$config['prev_tag_close'] = '</li>';
		// 		$config['cur_tag_open'] = '<li class="active"><a>';
		// 		$config['cur_tag_close'] = '</a></li>';
		// 		$config['num_tag_open'] = '<li>';
		// 		$config['num_tag_close'] = '</li>';
		// 		$config['last_link'] = 'Last';
		// 		$config['first_link'] = 'First';
		// 		$this->pagination->initialize($config);
		// 		$_SESSION['pages2'] = $data['pages2'] = $this->pagination->create_links();
		// 	}
		// 	$this->load->view('header',$data);
		// 	$this->load->view('financeAllGroupLedgerDetails');
		// 	$this->load->view('footer_home');
	// }	

	public function allGroupLedgerDetails($pageCall= "", $start = 0) {	//TS
		$data['whichTab'] = 'Finance';
		$condition = "LEVELS='PG' OR LEVELS='SG'";	
		// $newCondition = "AND $TYPE_ID != ''";
		$TYPE_ID = "";
		if(@$_POST['TYPE_ID']){
			$data['TYPE_ID']  = @$_POST['TYPE_ID'] ; 
			 $TYPE_ID =  str_split(@$_POST['TYPE_ID'])[0];
			
		}else{
			$data['TYPE_ID'] = $TYPE_ID = "";
		}
		$data['groups'] =  $this->obj_finance->getGroups($condition);
		$condition = "LEVELS!='LG'";		
		$data['group'] =  $this->obj_finance->getGroups($condition);
		$pageSize = $data['pageSize'] = 13;
		if($pageCall == "Group") {
			unset($_SESSION['pageGroupStart']);
			$_SESSION['pageGroupStart'] = $start;
			if(!isset($_SESSION['pageLedgerStart'])) {
				$_SESSION['pageLedgerStart'] = 0;
			}
		}
		else if($pageCall == "Ledger") {
			unset($_SESSION['pageLedgerStart']);
			$_SESSION['pageLedgerStart'] = $start;
			if(!isset($_SESSION['pageGroupStart'])) {
				$_SESSION['pageGroupStart'] = 0;
			}
		} else {
			$_SESSION['pageGroupStart'] = $start;
			$_SESSION['pageLedgerStart'] = $start;
		}

		//FOR SEARCH CONDITIONS
		if(isset($_POST['callFromGroup']) && $_POST['callFromGroup'] == "SearchGroup") {
			if(isset($_POST['GroupName'])) {
				unset($_SESSION['GroupName']);
				$data['GroupName'] = $_SESSION['GroupName'] = $_POST['GroupName'];
			} 
			$cond_Groupsrch = "AND FGLH_NAME LIKE '%".str_replace("'","''",$_SESSION['GroupName'])."%'";
			$cond_Ledgersrch = "";
			$_SESSION['pageGroupStart']=0;
		} else if(isset($_POST['callFromLedger']) && $_POST['callFromLedger'] == "SearchLedger") {
			if(isset($_POST['LedgerName'])) {
				unset($_SESSION['LedgerName']);
				$data['LedgerName'] = $_SESSION['LedgerName'] = $_POST['LedgerName'];
			} 
			$cond_Ledgersrch = "AND FGLH_NAME LIKE '%".str_replace("'","''",$_SESSION['LedgerName'])."%'";
			$cond_Groupsrch = "";
			$_SESSION['pageLedgerStart']=0;
		} else {
			$cond_Groupsrch = "";
			$cond_Ledgersrch = "";
			$data['GroupName'] = "";
			$data['LedgerName'] = "";
		}

		$data['parentDetails'] =  $this->obj_finance->getGroups();
		$conditionGroup = "LEVELS!='MG' AND LEVELS!='LG'";
		$data['allGroups'] = $this->obj_finance->getAllLedgerAndGroups($pageSize,$_SESSION['pageGroupStart'],$conditionGroup, $cond_Groupsrch);
		$data['allGroupsCount'] = $config['total_rows'] = $this->obj_finance->getAllLedgerAndGroups_count(0,0,$conditionGroup, $cond_Groupsrch);
		
		if($pageCall == "Group" || $pageCall == "") {
			$this->load->library('pagination');
			$config['base_url'] = base_url().'finance/allGroupLedgerDetails/Group';
			$config['per_page'] = $pageSize;
			$config['prev_link'] = '&lt;&lt;';
			$config['next_link'] = '&gt;&gt;';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['first_link'] = 'First';
			$this->pagination->initialize($config);
			$_SESSION['pages1'] = $data['pages1'] = $this->pagination->create_links();
		}
		$sql ="SELECT FGLH_NAME FROM finacial_group_ledger_heads WHERE LEVELS = 'MG'";
		$result = $this->db->query($sql);
        $data['types'] =  $result->result();
		$conditionLedger = 	"LEVELS='LG' AND TYPE_ID like '%$TYPE_ID%' ";
		$data['allLedger'] = $this->obj_finance->getAllLedgerAndGroups($pageSize,$_SESSION['pageLedgerStart'],$conditionLedger,$cond_Ledgersrch);
		$data['allLedgerCount'] = $config['total_rows'] = $this->obj_finance->getAllLedgerAndGroups_count(0,0,$conditionLedger,$cond_Ledgersrch);
		
		if($pageCall == "Ledger" || $pageCall == "") {
			$this->load->library('pagination');
			$config['base_url'] = base_url().'finance/allGroupLedgerDetails/Ledger';
			$config['per_page'] = $pageSize;
			$config['prev_link'] = '&lt;&lt;';
			$config['next_link'] = '&gt;&gt;';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['first_link'] = 'First';
			$this->pagination->initialize($config);
			$_SESSION['pages2'] = $data['pages2'] = $this->pagination->create_links();
		}
		$this->load->view('header',$data);
		$this->load->view('financeAllGroupLedgerDetails');
		$this->load->view('footer_home');
	}	

	// ADDED NY ADITHYA VEWLEDGER DETAILS PAGE START 
	public function ViewLedger(){
		$fromRP_OP ="";
	    $toRP_OP  ="";
		$newCondition = "";
		$compId ="";

		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}

		$data['whichTab'] = 'Finance';
		if(@$_POST['FGLH_ID']){
			$fglh_id = $_SESSION['FGLH_ID'] =  @$_POST['FGLH_ID'];
		}else{
			$fglh_id = $_SESSION['FGLH_ID'];
		}
		
        $fromYear = date('d-m-Y');                                                           
		$finYear = $this->obj_finance->getFinYearBasedOnDate($fromYear);
		$fromDate = "01-04-".explode("-",$finYear)[0];
		$toDate = "31-03-".explode("-",$finYear)[1];
		
		if(@$_POST['fromRP'] && @$_POST['toRP']) {
			$data['FinancialYear'] = $finYear = $this->obj_finance->getFinYearBasedOnDate(@$_POST['fromRP']);
            $date = date(@$_POST['fromRP']);
			$formatted_date = date("d-m", strtotime(@$_POST['fromRP']));
			
			if($formatted_date == "01-04"){
				$fromDate = @$_POST['fromRP'];
				$toDate = @$_POST['toRP'];

				$fromRP_OP =""; //here i dont need to send op date bcz OP record is getting fetched in fromDate and toDate
				$toRP_OP  ="";
				
				$newCondition = "";
			} else {	
				$fromRP_OP = "01-04-".explode("-",$finYear)[0]; // here i need op date to fetch OP record separetly
				$toRP_OP = date("d-m-Y", strtotime(@$_POST['fromRP']."-1 day"));

				$fromDate = @$_POST['fromRP'] ;
				$toDate = @$_POST['toRP'];
				
				$newCondition = "AND RP_TYPE != 'OP'";
			}
			$data['fromDate'] = @$_POST['fromRP'];
			$data['toDate'] = @$_POST['toRP'];
		} else {
			$maxYear = $this->obj_shashwath->getfinyear();	
			$data['fromDate'] = $fromDate =  $fromReceiptDate = '01-04-'.($maxYear-1);
			
			$data['toDate'] = $toDate =   $toReceiptDate = '31-03-'.($maxYear);
			
			$data['FinancialYear'] = $this->obj_finance->getFinYearBasedOnDate($fromDate);	

			$fromRP_OP ="";	//initial condition it will be blank bcz i dont need to fetch OP record separetly
			$toRP_OP = "";	
		}


		// echo $fromReceiptDate,$toReceiptDate ;
		$minDate =   $this->obj_finance->getledgerdate();
		$data['ledgerFinanceDate'] =  $this->obj_finance->getledgerdate();

		$sql = "SELECT FGLH_NAME,TYPE_ID FROM finacial_group_ledger_heads WHERE FGLH_ID = $fglh_id";
		$query = $this->db->query($sql);
		$data['ledgerName'] = $query->row()->FGLH_NAME;
		$data['TYPE_ID'] = $query->row()->TYPE_ID;
		$data['committee'] =  $this->obj_finance->getCommittee();
		$data['opening'] = "";
		$data['closing'] = "";
		$data['ledgerDetails'] = $this->obj_finance->getLedgerDetails($fromRP_OP,$toRP_OP,$fromDate,$toDate,$fglh_id,$newCondition, $compId);

		$this->load->view('header',$data);
		$this->load->view('financeViewLedger');
		$this->load->view('footer_home');

	}
	// ADDED BY ADITHYA VIEWLEDGER DETAILS PAGE END

	public function groupAndLedgerList($pageCall= "", $start = 0) {
		unset($_SESSION['group_and_ledger_link']);
		$group_and_ledger_link = (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['group_and_ledger_link'] = $group_and_ledger_link;
		$data['whichTab'] = 'Finance';
		$data['openedRowsActive'] =  @$_POST['openedRowsActive'];
		$data['allLedgerList'] = $this->obj_finance->getAllLedgerList();

		$this->load->view('header',$data);
		$this->load->view('financeGroupAndLedgerList');
		$this->load->view('footer_home');
	}
	
	function ledgerSummaryDetail($pageCall= "", $start=0) {
		$data['whichTab'] = 'Finance';
		$pageSize = $data['pageSize'] =10;
		if($pageCall == "transactionBreakup") {
			unset($_SESSION['pageTransactionBreakupStart']);
			$_SESSION['pageTransactionBreakupStart'] = $start;
			if(!isset($_SESSION['pageSevaBreakupStart'])) {
				$_SESSION['pageSevaBreakupStart'] = 0;
			}
		}
		else if($pageCall == "sevaBreakup") {
			unset($_SESSION['pageSevaBreakupStart']);
			$_SESSION['pagesevaBreakupStart'] = $start;
			if(!isset($_SESSION['pageTransactionBreakupStart'])) {
				$_SESSION['pageTransactionBreakupStart'] = 0;
			}
		} else {
			$_SESSION['pageTransactionBreakupStart'] = $start;
			$_SESSION['pagesevaBreakupStart'] = $start;
		}

		// $this->load->library('pagination');
		if(@$_POST['FGLH_ID']) {
			$data['FGLH_ID'] = $_SESSION['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'] = $FGLH_NAME = @$_POST['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom = $_SESSION['firstFrom'] = @$_POST['from'];
			$data['from'] = $from = $_SESSION['from'] = $this->obj_finance->getledgerdate();
			$data['to'] = $to =  $_SESSION['to'] = @$_POST['to'];
			$data['openedRows'] = $_SESSION['openedRows'] = @$_POST['openedRows'];
		}
		else{
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
			$data['FGLH_NAME'] = $FGLH_NAME = $_SESSION['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom =  $_SESSION['firstFrom'];
			$data['from'] = $from =  $_SESSION['from'];
			$data['to'] = $to =  $_SESSION['to'];
			$data['openedRows'] = $_SESSION['openedRows'];
		}
		if(@$_POST['compIdVal']){
			$data['compId'] = $compId = @$_POST['compIdVal'];
		} else {
			$data['compId'] = $compId = "";
		}
		
		$data['breakupDetail'] = $this->obj_finance->get_ledger_breakup_details($FGLH_ID,$pageSize,$_SESSION['pageTransactionBreakupStart'] ,$firstFrom,$to,$compId);
		$data['Closing'] = $this->obj_finance->get_ledger_closing_details($FGLH_ID,$from,$firstFrom,$compId);
		$config['total_rows']= $data['breakupCount'] =  $this->obj_finance->get_ledger_breakup_details_count($FGLH_ID,$firstFrom,$to,$compId);
		 // count($this->obj_finance->get_ledger_breakup_details($FGLH_ID,0,0,$firstFrom,$to));

		if($pageCall == "transactionBreakup" || $pageCall == "") {
			// $this->load->library('pagination');
			// $config['base_url'] = base_url().'finance/ledgerSummaryDetail/transactionBreakup';
			// $config['per_page'] = $pageSize;
			// $config['prev_link'] = '&lt;&lt;';
			// $config['next_link'] = '&gt;&gt;';
			// $config['first_tag_open'] = '<li>';
			// $config['first_tag_close'] = '</li>';
			// $config['last_tag_open'] = '<li>';
			// $config['last_tag_close'] = '</li>';
			// $config['next_tag_open'] = '<li>';
			// $config['next_tag_close'] = '</li>';
			// $config['prev_tag_open'] = '<li>';
			// $config['prev_tag_close'] = '</li>';
			// $config['cur_tag_open'] = '<li class="active"><a>';
			// $config['cur_tag_close'] = '</a></li>';
			// $config['num_tag_open'] = '<li>';
			// $config['num_tag_close'] = '</li>';
			// $config['last_link'] = 'Last';
			// $config['first_link'] = 'First';
			// $this->pagination->initialize($config);
			// $_SESSION['pages1'] = $data['pages1'] = $this->pagination->create_links();
		}
		$data['breakupDetailGrid'] = $this->obj_finance->get_legder_grid_breakup_details($FGLH_ID,$firstFrom,$to,$pageSize,$_SESSION['pagesevaBreakupStart']);
		$config['total_rows'] = $data['breakupCountGrid'] =  $this->obj_finance->get_ledger_breakup_details_grid_count($FGLH_ID,$firstFrom,$to);
		if($pageCall == "sevaBreakup" || $pageCall == "") {
			// $this->load->library('pagination');
			// $config['base_url'] = base_url().'finance/ledgerSummaryDetail/sevaBreakup';
			// $config['per_page'] = $pageSize;
			// $config['prev_link'] = '&lt;&lt;';
			// $config['next_link'] = '&gt;&gt;';
			// $config['first_tag_open'] = '<li>';
			// $config['first_tag_close'] = '</li>';
			// $config['last_tag_open'] = '<li>';
			// $config['last_tag_close'] = '</li>';
			// $config['next_tag_open'] = '<li>';
			// $config['next_tag_close'] = '</li>';
			// $config['prev_tag_open'] = '<li>';
			// $config['prev_tag_close'] = '</li>';
			// $config['cur_tag_open'] = '<li class="active"><a>';
			// $config['cur_tag_close'] = '</a></li>';
			// $config['num_tag_open'] = '<li>';
			// $config['num_tag_close'] = '</li>';
			// $config['last_link'] = 'Last';
			// $config['first_link'] = 'First';
			// $this->pagination->initialize($config);
			// $_SESSION['pages2'] = $data['pages2'] = $this->pagination->create_links();
		}

		$this->load->view('header');
		$this->load->view('financeLedgerSummaryDetails',$data);
		$this->load->view('footer_home');
	}	

	function IEledgerSummaryDetail($start=0) {	//TS
		$data['whichTab'] = 'Finance';
		$pageSize = $data['pageSize'] = 10;
		$this->load->library('pagination');
		if(@$_POST['FGLH_ID']) {
			$data['FGLH_ID'] = $_SESSION['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'] = $FGLH_NAME = @$_POST['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom = $_SESSION['firstFrom'] = @$_POST['from'];
			$data['from'] = $from = $_SESSION['from'] = $this->obj_finance->getledgerdate();
			$data['to'] = $to =  $_SESSION['to'] = @$_POST['to'];
			$data['openedRows'] = $openedRows =  $_SESSION['openedRows'] = @$_POST['openedRows'];
		}
		else{
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
			$data['FGLH_NAME'] = $FGLH_NAME = $_SESSION['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom =  $_SESSION['firstFrom'];
			$data['from'] = $from =  $_SESSION['from'];
			$data['to'] = $to =  $_SESSION['to'];
			$data['openedRows'] = $openedRows =  $_SESSION['openedRows'];
		}
		if(@$_POST['compIdVal']){
			$data['compId'] = $compId = @$_POST['compIdVal'];
		} else {
			$data['compId'] = $compId = "";
		}

		$data['breakupDetail'] = $this->obj_finance->get_ledger_breakup_details($FGLH_ID,$pageSize,$start,$firstFrom,$to,$compId);
		$data['Closing'] = $this->obj_finance->get_ledger_closing_details($FGLH_ID,$from,$firstFrom,$compId);

		$config['base_url'] = base_url().'finance/IEledgerSummaryDetail';
		$config['total_rows']= $data['breakupCount'] =  $this->obj_finance->get_ledger_breakup_details_count($FGLH_ID,$firstFrom,$to,$compId );

		// $config['per_page'] =$pageSize;
		// $config['prev_link'] = '&lt;&lt;';
		// $config['next_link'] = '&gt;&gt;';
		// $config['first_tag_open'] = '<li>';
		// $config['first_tag_close'] = '</li>';
		// $config['last_tag_open'] = '<li>';
		// $config['last_tag_close'] = '</li>';
		// $config['next_tag_open'] = '<li>';
		// $config['next_tag_close'] = '</li>';
		// $config['prev_tag_open'] = '<li>';
		// $config['prev_tag_close'] = '</li>';
		// $config['cur_tag_open'] = '<li class="active"><a>';
		// $config['cur_tag_close'] = '</a></li>';
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
		// $config['last_link'] = 'Last';        
		// $config['first_link'] = 'First';
		// $this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header');
		$this->load->view('financeIELedgerSummaryDetails',$data);
		$this->load->view('footer_home');
	}	

	function RPledgerSummaryDetail($pageCall= "", $start=0) {
		$data['whichTab'] = 'Finance';
		$pageSize = $data['pageSize'] = 10;
		if($pageCall == "transactionBreakup") {
			unset($_SESSION['pageTransactionBreakupStart']);
			$_SESSION['pageTransactionBreakupStart'] = $start;
			if(!isset($_SESSION['pageSevaBreakupStart'])) {
				$_SESSION['pageSevaBreakupStart'] = 0;
			}
		}
		else if($pageCall == "sevaBreakup") {
			unset($_SESSION['pageSevaBreakupStart']);
			$_SESSION['pagesevaBreakupStart'] = $start;
			if(!isset($_SESSION['pageTransactionBreakupStart'])) {
				$_SESSION['pageTransactionBreakupStart'] = 0;
			}
		} else {
			$_SESSION['pageTransactionBreakupStart'] = $start;
			$_SESSION['pagesevaBreakupStart'] = $start;
		}

		$this->load->library('pagination');
		if(@$_POST['FGLH_ID']) {
			$data['FGLH_ID'] = $_SESSION['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'] = $FGLH_NAME = @$_POST['FGLH_NAME'];
			$data['TYPE_ID'] = $_SESSION['TYPE_ID'] =  $this->obj_finance->getTypeId(@$_POST['FGLH_ID']);
			$data['firstFrom'] = $firstFrom = $_SESSION['firstFrom'] = @$_POST['from'];
			$data['from'] = $from = $_SESSION['from'] = $this->obj_finance->getledgerdate();
			$data['to'] = $to =  $_SESSION['to'] = @$_POST['to'];
			$data['openedRows'] = $openedRows =  $_SESSION['openedRows'] = @$_POST['openedRows'];
		}
		else{
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
			$data['TYPE_ID'] = $TYPE_ID =  $_SESSION['TYPE_ID'];
			$data['FGLH_NAME'] = $FGLH_NAME = $_SESSION['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom =  $_SESSION['firstFrom'];
			$data['from'] = $from =  $_SESSION['from'];
			$data['to'] = $to =  $_SESSION['to'];
			$data['openedRows'] = $openedRows =  $_SESSION['openedRows'];
		}
		if(@$_POST['compIdVal']){
			$data['compId'] = $compId = @$_POST['compIdVal'];
		} else {
			$data['compId'] = $compId = "";
		}
		$data['breakupDetail'] = $this->obj_finance->get_ledger_breakup_details($FGLH_ID,$pageSize,$_SESSION['pageTransactionBreakupStart'] ,$firstFrom,$to,$compId);
		$data['Closing'] = $this->obj_finance->get_ledger_closing_details($FGLH_ID,$from,$firstFrom,$compId);
		$config['total_rows']= $data['breakupCount'] =  $this->obj_finance->get_ledger_breakup_details_count($FGLH_ID,$firstFrom,$to,$compId);

		if($pageCall == "transactionBreakup" || $pageCall == "") {
			// $this->load->library('pagination');
			// $config['base_url'] = base_url().'finance/RPledgerSummaryDetail/transactionBreakup';
			// $config['per_page'] = $pageSize;
			// $config['prev_link'] = '&lt;&lt;';
			// $config['next_link'] = '&gt;&gt;';
			// $config['first_tag_open'] = '<li>';
			// $config['first_tag_close'] = '</li>';
			// $config['last_tag_open'] = '<li>';
			// $config['last_tag_close'] = '</li>';
			// $config['next_tag_open'] = '<li>';
			// $config['next_tag_close'] = '</li>';
			// $config['prev_tag_open'] = '<li>';
			// $config['prev_tag_close'] = '</li>';
			// $config['cur_tag_open'] = '<li class="active"><a>';
			// $config['cur_tag_close'] = '</a></li>';
			// $config['num_tag_open'] = '<li>';
			// $config['num_tag_close'] = '</li>';
			// $config['last_link'] = 'Last';
			// $config['first_link'] = 'First';
			// $this->pagination->initialize($config);
			$_SESSION['pages1'] = $data['pages1'] = $this->pagination->create_links();
		}
		$data['breakupDetailGrid'] = $this->obj_finance->get_legder_grid_breakup_details($FGLH_ID,$firstFrom,$to,$pageSize,$_SESSION['pagesevaBreakupStart']);
		$config['total_rows'] = $data['breakupCountGrid'] =  $this->obj_finance->get_ledger_breakup_details_grid_count($FGLH_ID,$firstFrom,$to);
		if($pageCall == "sevaBreakup" || $pageCall == "") {
			// $this->load->library('pagination');
			// $config['base_url'] = base_url().'finance/ledgerSummaryDetail/sevaBreakup';
			// $config['per_page'] = $pageSize;
			// $config['prev_link'] = '&lt;&lt;';
			// $config['next_link'] = '&gt;&gt;';
			// $config['first_tag_open'] = '<li>';
			// $config['first_tag_close'] = '</li>';
			// $config['last_tag_open'] = '<li>';
			// $config['last_tag_close'] = '</li>';
			// $config['next_tag_open'] = '<li>';
			// $config['next_tag_close'] = '</li>';
			// $config['prev_tag_open'] = '<li>';
			// $config['prev_tag_close'] = '</li>';
			// $config['cur_tag_open'] = '<li class="active"><a>';
			// $config['cur_tag_close'] = '</a></li>';
			// $config['num_tag_open'] = '<li>';
			// $config['num_tag_close'] = '</li>';
			// $config['last_link'] = 'Last';
			// $config['first_link'] = 'First';
			// $this->pagination->initialize($config);
			$_SESSION['pages2'] = $data['pages2'] = $this->pagination->create_links();
		}

		$this->load->view('header');
		$this->load->view('financeRPLedgerSummaryDetails',$data);
		$this->load->view('footer_home');
	}	

	function TrialledgerSummaryDetail($start=0) {	//TS
		$data['whichTab'] = 'Finance';
		$pageSize = $data['pageSize'] = 10;
		$this->load->library('pagination');
		if(@$_POST['FGLH_ID']) {
			$data['FGLH_ID'] = $_SESSION['FGLH_ID'] = $FGLH_ID = @$_POST['FGLH_ID'];
			$data['FGLH_NAME'] = $_SESSION['FGLH_NAME'] = $FGLH_NAME = @$_POST['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom = $_SESSION['firstFrom'] = @$_POST['from'];
			$data['from'] = $from = $_SESSION['from'] = $this->obj_finance->getledgerdate();
			$data['to'] = $to =  $_SESSION['to'] = @$_POST['to'];
		}
		else{
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
			$data['FGLH_NAME'] = $FGLH_NAME = $_SESSION['FGLH_NAME'];
			$data['firstFrom'] = $firstFrom =  $_SESSION['firstFrom'];
			$data['from'] = $from =  $_SESSION['from'];
			$data['to'] = $to =  $_SESSION['to'];
		}
		if(@$_POST['compIdVal']){
			$data['compId'] = $compId = @$_POST['compIdVal'];
		} else {
			$data['compId'] = $compId = "";
		}
		$data['breakupDetail'] = $this->obj_finance->get_ledger_breakup_details($FGLH_ID,$pageSize,$start,$firstFrom,$to,$compId);
		$data['Closing'] = $this->obj_finance->get_ledger_closing_details($FGLH_ID,$from,$firstFrom,$compId);

		$config['base_url'] = base_url().'finance/ledgerSummaryDetail';
		$config['total_rows']= $data['breakupCount'] =  $this->obj_finance->get_ledger_breakup_details_count($FGLH_ID,$firstFrom,$to,$compId);

		$config['per_page'] =$pageSize;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';        
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header');
		$this->load->view('financeTrailLedgerSummaryDetails',$data);
		$this->load->view('footer_home');
	}

	function addCommittee(){
		$data['whichTab'] = 'Finance';
		$data['AllCommittee'] = $this->obj_finance->getAllCommittee();
		$this->load->view('header');
		$this->load->view('financeAddCommittee',$data);
		$this->load->view('footer_home');
	}

	public function addCommitteeDetails() {
		$committeename = @$_POST['committeename'];
		$this->obj_finance->putCommitteeDetails($committeename);
		redirect(site_url()."finance/addCommittee");

	}

	public function updateCommitteeName() {
		if(isset($_POST)){
			$compid = $this->input->post('compid');
			$editCommitteeName = $this->input->post('editCommitteeName');
		}
		$sql="UPDATE finance_committee SET COMP_NAME = '$editCommitteeName'  where COMP_ID = $compid";
		$this->db->query($sql);
		redirect(site_url()."finance/addCommittee");
	}

	public function checkTransactionAmt() {	//TS
		$LEDGER_ID = $this->input->post('LEDGER_ID');
		$sql="SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS TRANSACTION_AMT 
		 FROM financial_ledger_transcations 
		 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID  where financial_ledger_transcations.FGLH_ID = $LEDGER_ID and RP_TYPE != 'OP' and TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY financial_ledger_transcations.FGLH_ID ";
		$query = $this->db->query($sql);
		echo $query->num_rows();
	}

	public function checkGroupTransactionAmt() {		//TS
		$GROUP_ID = $this->input->post('GROUP_ID');	
		$checkType =  $this->obj_finance->getType1($GROUP_ID);
		$lft = '';
		$rgt = '';
		if ($checkType == 'A') {
			$lft = 'LF_A';
			$rgt = 'RG_A'; 		    	
		} else if ($checkType == 'L') {
			$lft = 'LF_L';
			$rgt = 'RG_L'; 
		} else if ($checkType == 'I') {
			$lft = 'LF_I';
			$rgt = 'RG_I'; 
		} else if ($checkType == 'E') {
			$lft = 'LF_E';
			$rgt = 'RG_E'; 
		}
		$Level =  $this->obj_finance->getParentLevel($GROUP_ID);
		if($Level == 'PG') {
			$column = "LEDGER_PRIMARY_PARENT_CODE";
			$sql="SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS TRANSACTION_AMT 
			 FROM financial_ledger_transcations 
			 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID  where $column = $GROUP_ID and RP_TYPE != 'OP' and TRANSACTION_STATUS != 'Cancelled'
			 GROUP BY financial_ledger_transcations.FGLH_ID ";
		$query = $this->db->query($sql);
		echo $query->num_rows();
		} else {
			$column = "FGLH_PARENT_ID";
			//New Abhi code
			$sql ="SELECT @myLeft  := $lft , @myRight := $rgt, @myWidth := $rgt - $lft + 1  FROM finacial_group_ledger_heads WHERE FGLH_ID = $GROUP_ID";
			$sql1="SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS TRANSACTION_AMT 
			 FROM financial_ledger_transcations 
			 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID  where $lft > @myLeft AND $lft < @myRight and RP_TYPE != 'OP' and TRANSACTION_STATUS != 'Cancelled'
			 GROUP BY financial_ledger_transcations.FGLH_ID ";
			$query = $this->db->query($sql);
			$query1 = $this->db->query($sql1);
			echo $query1->num_rows();
		}
	}

	public function Fddetails($start=0){
		$date = date('d-m-Y');
		$data['date'] = $date;
		// print_r($date);
		$startDate =date('01-m-Y');
		$endDate= date('t-m-Y', strtotime($date));
		
		// $last_day_april_2010 = date('m--Y', strtotime('April 21, 2010'));
		$result = $this->obj_finance->fd_Exp_Count($startDate,$endDate);
		$_SESSION['fdExpCount'] = $result;
		$data['fdExpCurrentMonth'] = $this->obj_finance->fd_Exp_Current_Month($startDate,$endDate); 

		$data['fdAllExp'] = $this->obj_finance->fd_All_Exp($startDate,$endDate,$start,8); 
		$this->load->library('pagination');
		// $data['shashwath_Sevas'] = $this->obj_shashwath->addSevaPrice($date,10,$start); 
		$config['base_url'] = base_url().'finance/Fddetails';
		$config['total_rows'] = $this->obj_finance->fd_All_Exp_Count($startDate,$endDate);
		$config['per_page'] = 8;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('fdexpire');
		$this->load->view('footer_home');
	}

	//SELECTED LEDGER ALL TRANSACTIONS***********
	function allLedgerTranscation($start=0) {	//TS
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		$data['radioOpt'] = $radioOpt;
		if(isset($_POST['FGLH_ID'])) {
			$data['FGLH_ID'] = $_SESSION['FGLH_ID']= $FGLH_ID = @$_POST['FGLH_ID'];
		} else {
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
		}
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['fromDate']);
		unset($_SESSION['toDate']);
		unset($_SESSION['voucherType']);
		unset($_SESSION['paymentType']);

		if(@$_POST['CommitteeId']){
			$data['compId'] = $compId = @$_POST['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}

		$data['date'] = date('d-m-Y');
		$fromDate = date("d-m-Y");
		$data['dayBook']= $this->obj_finance->get_ledger_transactions($fromDate,'',$compId,10,$start,$FGLH_ID);
		
		$data['committee'] =  $this->obj_finance->getCommittee();

		$this->load->library('pagination');
		$data['bookCount']=$config['total_rows'] = $this->obj_finance->count_rows_ledger_transactions($fromDate,'','',$FGLH_ID);
		//$config['base_url'] = base_url().'finance/dayBook';
		$config['base_url'] = $data['base_url'] =  base_url().'finance/allLedgerTranscation';
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('financeLedgerAllTranscation');
		$this->load->view('footer_home');
	}

	function all_ledger_transcation_on_change_date($start = 0) {	//TS
		$data['whichTab'] = 'Finance';
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
			//For Menu Selection
		$data['whichTab'] = "finance";
		
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDate'])) {
			$fromDate = @$_POST['fromDate'];
			$toDate = @$_POST['toDate'];
			$_SESSION['fromDate'] = $fromDate;
			$_SESSION['toDate'] = $toDate;
		} else {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
		}
		
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;

		if(isset($_POST['FGLH_ID'])) {
			$data['FGLH_ID'] = $_SESSION['FGLH_ID']= $FGLH_ID = @$_POST['FGLH_ID'];
		} else {
			$data['FGLH_ID'] = $FGLH_ID = $_SESSION['FGLH_ID'];
		}

		if(@$_POST['tdate']) {
			unset($_SESSION['date']);
			$data['date'] = $this->input->post('tdate');
			$date = $this->input->post('tdate');
		}
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('tdate'));
			$data['date'] = $_SESSION['date'];
			$date = $this->input->post('tdate');
		} else {
			$date = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}
		$condition = ("AND finacial_group_ledger_heads.FGLH_ID !=21");
		$this->load->library('pagination');
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$data['dayBook'] = $this->obj_finance->get_ledger_transactions($fromDate,$toDate,'',10,$start,$FGLH_ID);
			$data['bookCount']=$config['total_rows'] = $this->obj_finance->count_rows_ledger_transactions($fromDate,$toDate,'',$FGLH_ID);
		} else {
			$data['dayBook'] = $this->obj_finance->get_ledger_transactions($_SESSION['date'],'','',10,$start,$FGLH_ID);
			$data['bookCount']=$config['total_rows'] = $this->obj_finance->count_rows_ledger_transactions($_SESSION['date'],'','',$FGLH_ID);
		}
		$config['base_url'] = $data['base_url'] =  base_url().'finance/all_ledger_transcation_on_change_date';
			
		//$config['base_url'] = base_url().'finance/day_book_on_change_date';
		$data['committee'] =  $this->obj_finance->getCommittee();
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();

		$this->load->view('header', $data);
		$this->load->view('financeLedgerAllTranscation');
		$this->load->view('footer_home');
	}
	//END

	function cancelTransaction(){
		$VOUCHER_NO = @$_POST['VOUCHER_NO'];
		$FLT_DATE = @$_POST['FLT_DATE'];
		$chequeno = @$_POST['chequeno'];
		$voucherType = @$_POST['voucherType'];
		$this->obj_finance->cancel_finance_transaction($VOUCHER_NO,$FLT_DATE,$chequeno,$voucherType);
		redirect(site_url()."finance/dayBook");
	}

	// added by adithya
	function addInterest(){
		$bank = $this->input->post('bank');
		$fglh_id = $this->input->post('fglh_id');
		$fd_bank_name = $this->input->post('fd_bank_name');
		$fd_number = $this->input->post('fd_number');
		$fd_bank_id = $this->input->post('fd_bank_id') ;
		$fd_interest_date = $this->input->post('fd_interest_date');
        $fd_interest = $this->input->post('fd_interest');
		$updatedById = $_SESSION['userId'];
		$updatedByDate = date('d-m-Y');
		$UpdatedDateTime = date('d-m-Y H:i:s A');
		$this->obj_finance->addFDDetails($fglh_id,$bank,$fd_bank_name,$fd_number,$fd_bank_id,$fd_interest_date,$fd_interest,$updatedById,$updatedByDate,$UpdatedDateTime);
		echo "success";
	}

	// function getInterestDetails(){
	// 	$fglh_id = $_POST['FGLH_ID'];
	// 	$result = $this->obj_finance->getFDDetails($fglh_id);
	// 	$res =  (array) json_decode(json_encode($result));
	
	// echo '<div class="row form-group">';
	// echo'	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
	// echo'		<div class="table-responsive" >';
	// echo'			<table class="table table-bordered">';
	// echo'				<thead>';
	// echo'					<tr>';
	// echo'						<th width="30%">FD Name </th>';	
	// echo'						<th width="30%">FD Credit Date</th>';
	// echo'						<th width="30%">Credited Amount</th>';
	// // echo'						<th width="30%">Amount</th>';
	// echo'					</tr>';
	// echo'				</thead>';
	// echo               '<tbody>';
	// foreach ($res as $row) {
	// 	echo '<tr>';
	// 	echo '<td>'.$row->FGLH_NAME.'</td>';
	// 	echo '<td>'.$row->FD_INT_DATE.'</td>';
	// 	echo '<td>'.$row->FD_INTEREST.'</td>';
	// 	// echo '<td>'.$row['FGLH_NAME'].'</td>';
	// 	// echo '<td>'.$row['FGLH_NAME'].'</td>';
	// }
	// echo               '</tbody>';
	// echo'			</table>';	
	// echo'		</div>';
	// echo'	</div>';
	// echo'</div>';

		
	// }
}
?>