<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Waitinglist_model extends CI_Model {

		public function __construct() {
			parent::__construct();
			$this->load->database();
		}
		

		public function addStudent($idNumber, $priorityNumber,$phoneNumber) {
			$query = "insert into waitinglist(studid, prioritynumber, dateadded, timeadded, phonenumber) values ('$idNumber', $priorityNumber, current_date, localtime(0),'$phoneNumber')";
			return $this->db->query($query);
		}
		//count sa na served na for the current date
		//deprecated
		public function countUnServedEntries() {
			$query = "Select COUNT(*) As studentcount From waitinglist Where served = false and dateadded = current_date";
			return $this->db->query($query)->row_array();
		}
		//count sa wala pa na serve for the current date
		//deprecated
		public function countServedEntries() {
			$query = "Select COUNT(*) As studentcount From waitinglist Where served = true and dateadded = current_date";
			return $this->db->query($query)->row_array();
		}

		//count sa mga nag queue for the current date
		//deprecated
		public function countAllEntries() {
			$query = "Select COUNT(studid) As studentcount From waitinglist Where dateadded = current_date";
			return $this->db->query($query)->row_array();
		}	

		public function clearWaitingList() {
			$query = "Delete From waitinglist";
			return $this->db->query($query);
		}

		//used in cashier_test through retrieveAStudent
		public function getStudent($idNumber) {
			$query = "SELECT * FROM waitinglist WHERE served = false AND serving = false AND dateadded = current_date ORDER BY timeadded";
			return $this->db->query($query);
		}

		//check to be deprecated
		public function retrieveNthEntry($n) {
			$query = "Select studid From waitinglist Where prioritynumber = $n Order By timestampadded";
			return $this->db->query($query);
		}

		public function retrieve10thEntry(){
			//temporary 10
			$query = $this->db->query("SELECT * FROM waitinglist WHERE served = false AND serving = false AND dateadded = current_date ORDER BY timeadded LIMIT 1 OFFSET 3");
			if($query->num_rows() == 0)
				return false;
			else
				return $query->row_array();
			
		}

		public function retrieve50thEntry(){
			//temporary 11
			$query = $this->db->query("SELECT * FROM waitinglist WHERE served = false AND serving = false AND dateadded = current_date ORDER BY timeadded LIMIT 1 OFFSET 8");
			if($query->num_rows() == 0)
				return false;
			else
				return $query->row_array();
		}

		public function getValidity($idNumber) {
			$query = $this->db->query(" SELECT * 
										FROM waitinglist 
										WHERE studid = '$idNumber' AND dateadded = current_date and served = false
										");
			return $query;
		}

		public function getFifteenStudents() {
			$query = $this->db->query("SELECT * FROM waitinglist WHERE served = false AND serving = false AND dateadded = current_date ORDER BY timeadded LIMIT 15");
			return $query;
		}

		public function getFirstAvalableStudent() {
			$query = $this->db->query("SELECT studid FROM waitinglist WHERE served = false AND serving = false AND dateadded = current_date ORDER BY timeadded LIMIT 1");
			return $query;
		}

		public function updateServing($idNumber, $value) {
			if($value){
				$this->db->query("UPDATE waitinglist SET serving = true WHERE studid = '$idNumber'");
			}
			else
				$this->db->query("UPDATE waitinglist SET serving = false WHERE studid = '$idNumber'");
		}

		public function updateServed($idNumber) {
			$this->db->query("UPDATE waitinglist SET served = true WHERE studid = '$idNumber'");
		}

		public function updateDateServed($idNumber){
			$this->db->query("UPDATE waitinglist SET dateserved = current_date WHERE studid = '$idNumber'");
		}
		 
		 public function updateTimeServed($idNumber){
		 	$this->db->query("UPDATE waitinglist SET timeserved = localtime(0) WHERE studid = '$idNumber'");
		 }

	}