<?php 

class GenerateProfile_model extends CI_Model {
	
	
		function otherStudentsInHouse($booking)
		{
			$booking_from=$booking['booking_from'];
			$sql="select `bookings`.`id` as `booking_id`, `sha_one`.`fname` as `student_fname`, `sha_one`.`lname` as `student_lname`  from `bookings` JOIN `sha_one` ON(`bookings`.`student`=`sha_one`.`id`) where `bookings`.`id`!='".$booking['id']."' and `bookings`.`host`='".$booking['host']."' and ( (`bookings`.`booking_from`<='".$booking_from."' and `bookings`.`booking_to`>='".$booking_from."') OR `bookings`.`booking_from`='".$booking_from."' OR `bookings`.`booking_to`='".$booking_from."')";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			
			/*if(!empty($res))
			{
				$studentsArray=array();	
				foreach($res as $r)
					$studentsArray[]=$r['student_fname'].' '.$r['student_lname'];
				$students=implode(', ',$studentsArray);
			}
			else
				$students='None';*/
			
			if(!empty($res))
				$students='Yes, up to '.count($res);
			else
				$students='None';
				
			return $students;
		}
		
		function getHfaLatestVisitReport($hfa_id)
		{
			return $this->db->query("SELECT * FROM `hfa_visitReport` where `hfa_id`='".$hfa_id."' order by `date_visited` DESC limit 1")->row_array();
		}
	
	}