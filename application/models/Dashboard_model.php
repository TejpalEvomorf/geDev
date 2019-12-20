<?php 

class Dashboard_model extends CI_Model { 

	function getchartData($data)
	{
		$sql_date=" where `date`>='".$data['feedFrom']."' and `date`<='".$data['feedTo']."'";
		
		if($data['xAxis']=='m')
			$sql="SELECT DATE(DATE_FORMAT(date, '%Y-%m-01')) AS `month`, SUM(`sent`) AS `total_sent`, SUM(`visits`) AS `total_visits`, SUM(`submissions`) AS `total_submissions` FROM `booking_feedbacks_count`".$sql_date." GROUP BY DATE(DATE_FORMAT(date, '%Y-%m-01')) ORDER BY DATE(DATE_FORMAT(date, '%Y-%m-01'))";
		elseif($data['xAxis']=='w')
			$sql="SELECT FROM_DAYS(TO_DAYS(`date`) -MOD(TO_DAYS(`date`) -1, 7)) AS week_beginning, SUM(`sent`) AS `total_sent`, SUM(`visits`) AS `total_visits`, SUM(`submissions`) AS `total_submissions` FROM `booking_feedbacks_count`".$sql_date." GROUP BY FROM_DAYS(TO_DAYS(`date`) -MOD(TO_DAYS(`date`) -1, 7)) ORDER BY FROM_DAYS(TO_DAYS(`date`) -MOD(TO_DAYS(`date`) -1, 7))";
		elseif($data['xAxis']=='d')
			$sql="SELECT `date`, `sent` AS `total_sent`, `visits` AS `total_visits`, `submissions` AS `total_submissions` FROM `booking_feedbacks_count`".$sql_date."  ORDER BY `date`";
		return $chartData=$this->db->query($sql)->result_array();
	}
	
	function bookingFeedbackVisited($booking_from)
	{
		$date=date('Y-m-d',strtotime($booking_from.' + 1 week'));
		$this->db->query("update `booking_feedbacks_count` set `visits`=`visits`+1 where `date`=?",array($date));
	}
}

?>