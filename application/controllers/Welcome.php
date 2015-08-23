<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['cats'] = $this->getCategories();
		$data['countries'] = $this->getCountries();
		$data['datasets'] = $this->getDatasets();
		$data['latest_charts'] = $this->getLatest();
		$this->load->view('header', $data);
		$this->load->view('home', $data);
		$this->load->view('footer', $data);
	}

	public function getCategories(){
		$cats = $this->db->get("categories");
		return $cats->result_array();
	}

	public function getCountries(){
		$cats = $this->db->get("countries");
		return $cats->result_array();
	}

	public function getDatasets(){
		$cats = $this->db->get("datasets");
		return $cats->result_array();
	}
	public function getLatest(){
		$latestCharts = $this->db->query('SELECT * FROM charts');
		$latestCharts = $latestCharts->result_array();

		$latestCharts_final = array();

		foreach($latestCharts as $row){

			$id = $row['id'];
			$type=$row['type'];
			$title=$row['title'];
			$label1=$row['label1'];
			$label2=$row['label2'];

			$dataset=$row['dataset'];

			$sql3 = $this->db->query("SELECT * FROM datasets WHERE id='$dataset'");
			$row3 =$sql3->result_array();
			$row3 = $row3[0];

			$table=$row3['table'];

			$data = array();
			//piechart
			if($type=='PieChart')
			{

				$data[]= "['$label1', '$label2']";

				$sql2 = $this->db->query("SELECT * FROM $table");
				$sql2 = $sql2->result_array();

				foreach($sql2 as $row2)
				{
					$data[]="['".$row2[$label1]."', ".$row2[$label2]."]";
				}
			}

			//linechart
			else //if($type=='LineChart')
			{
				$label3 = $label2;
				$total = substr_count($label2, ',');
				$label2 = explode(',', $label2);
				$total = $total+1;
				$labels=array();
				for($i=0;$i<$total;$i++)
				{
					$labels[]="'".$label2[$i]."'";
				}
				$labels=implode(', ', $labels);


				$data[]= "['$label1', $labels]";

				$sql2 = $this->db->query("SELECT * FROM $table");
				$sql2 = $sql2->result_array();

				$total = substr_count($label3, ',');
				$label3 = explode(',', $label3);
				$total = $total+1;

				foreach($sql2 as $row2)
				{
					$rowf=array();
					for($i=0;$i<$total;$i++)
					{
						$rowf[]=$row2[$label3[$i]];
					}
					$rowf=implode(', ', $rowf);

					$data[]="['".$row2[$label1]."', $rowf]";
				}
			}
			$data = implode(', ', $data);

			$latestCharts_final[] = array("data"=>$data, "title"=>$title, "type"=>$type, "id"=>$id);
		}

		return $latestCharts_final;
	}
}
