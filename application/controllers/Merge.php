<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merge extends CI_Controller
{
    public function hybrid(){
        $d1=$_POST['d1'];
        $d2=$_POST['d2'];

        $data['d1'] = $d1;
        $data['d2'] = $d2;
        $data['rows'] = $this->getRows("SELECT * FROM datasets WHERE id='$d1'");

        $data['rows2'] = $this->getRows("SELECT * FROM datasets WHERE id='$d2'");

        $this->load->view('hybrid', $data);
    }

    public function getRows($query){
        $sql=$this->db->query($query);
        $rows = $sql->result_array();

        $values = array();

        foreach($rows as $row)
        {
            $table = $row['table'];

            $columns =$this->db->list_fields($table);

            if (count($columns) > 0) {

                $values_row = array();
                foreach($columns as $field){
                    $values_row[] = $field;
                }
                $values[$row['name']] = $values_row;

            }

        }

        return $values;
    }

    public function hybrid_process(){
        $d1=$_POST['d1'];
        $d2=$_POST['d2'];
        $v1=$_POST['v1'];
        $v2=$_POST['v2'];
        $name=$_POST['name'];
        $category=$_POST['category'];
        $description=$_POST['description'];
        //create random table name

        $result_string ="";

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $size = strlen( $chars );
        $tbname='';
        for( $i = 0; $i < 20; $i++ ) {
            $tbname .= $chars[ rand( 0, $size - 1 ) ];
        }

        $table=$tbname;
//
        $column_count = 0;
//create dataset
        $sql = $this->db->query("INSERT INTO datasets(`name`, `table`, `description`, `category`, `isHybrid`)VALUES('$name', '$table', '$description', '$category', '1')");
        if(!$sql)
        {
            $result_string.= "Dataset could not be created!";
        }
//get columns for new table
//get columns for table of dataset 1
        $query3 = "SELECT * FROM datasets WHERE id='$d1'";
        $sql = $this->db->query($query3);
        $sql = $sql->result_array();
        $sql = $sql[0];
        
        $tbname1 = $sql['table'];
        $result = $this->db->list_fields($tbname1);
        if (!$result) {
            $result_string.= 'Could not run query';
            return $result_string;
        }

        if (count($result) > 0) {
            $fields=array();
            $fields[]="`".$v1."` varchar(15)";

            foreach($result as $value){
                    if($value!=$v1&&$value!='id')
                    {
                        $column_count++;
                        $fields[]="`".$value."` varchar(15)";
                    }
                }
        }

        //get columns for table of dataset 2
        $query2="SELECT * FROM datasets WHERE id='$d2'";
        $sql = $this->db->query($query2);
        $sql = $sql->result_array();
        $sql = $sql[0];
        
        $tbname2 = $sql['table'];
        $result = $this->db->list_fields($tbname2);
        if (!$result) {
            $result_string.= 'Could not run query';
            return $result_string;
        }
        if (count($result) > 0) {

                foreach($result as $value){
                    if($value!=$v2&&$value!='id')
                    {
                        if(in_array($value, $fields));
                            $value .=$column_count;
                        $column_count++;
                        $fields[]="`".$value."` varchar(15)";
                    }
                }
            

        }
        $columnames = implode(', ', $fields);
        $columnames ="id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),".$columnames;


        $query = "CREATE TABLE ".$table."($columnames);";
        $create_tables= $this->db->query($query);

        if(!$create_tables){
            $result_string.= "error creating table";
        }
//table created - now the tough part!!



//insert values into created table
        $sql3 = $this->db->query("SELECT * FROM $tbname1");
        //find columns of first table
        $result = $this->db->list_fields($tbname1);
        if (!$result) {
            $result_string.= 'Could not run query';
            return $result_string;
        }
        if (count($result) > 0) {
            $fields=array();
                foreach($result as $value){
                    if($value!='id')
                    {
                        //now we have a column name
                        $fields[]=$value;
                    }
                }


        }
        $sql3 = $sql3->result_array();
        foreach($sql3 as $row3)
        {
//initalize array
            $insert=array();
            foreach($fields as $value)
            {
                $input="'".$row3[$value]."'";
                $value="`".$value."`";
                $insert = array($value=>$input)+$insert;
            }

            $query ="INSERT INTO $table (".implode(',',array_keys($insert)).") VALUES (".implode(',',array_values($insert)).")";
            //bingo!!!
            $do = $this->db->query($query);
            if(!$do)
            {
                $result_string .= "Problem encountered, Value not inserted!";
            }


        }

//moving on! update table by adding values of second dataset
//query formart should be something like : update $table set column=value where $v2=$v1
//Algorithm
//1. loop through each row of $table using $v1
//2. for each $v2=$v1 update row columns from table2 columns that are not id or $v2
        $sql = $this->db->query("SELECT * FROM $table");
        $sql = $sql->result_array();
        foreach($sql as $row)
        {
            $tvalue = "'".$row[$v1]."'";

            $sql2 = $this->db->query("SELECT * FROM $tbname2 WHERE $v2=$tvalue");

            //get columns of $tbname2 that are not id or $v2
            $result = $this->db->list_fields($tbname2);
            if (!$result) {
                $result_string /= 'Could not run query';
                return $result_string;
            }
            if (count($result) > 0) {
                $fields=array();
                    foreach($result as $value){
                        if($value!='id'&&$value!=$v2)
                        {
                            //now we have a column name
                            $fields[]=$value;
                        }
                    }


            }

            $sql2 = $sql2->result_array();
            foreach($sql2 as $row2)
            {
                //update
                //create key value array
                $query=array();
                foreach($fields as $fvalue)
                {
                    $query[]= "`".$fvalue."`='".$row2[$fvalue]."'";
                }


                //final action

                $query2=implode(', ', $query);

                //echo "UPDATE `$table` SET $query2 WHERE $v2=$tvalue";
                $do = $this->db->query("UPDATE `$table` SET $query2 WHERE $v2=$tvalue");

            }


        }
        if(!$do)
        {
            $result_string .= "Problem encountered, rows not updated!";
        }
        else
        {
            //now that wasn't so tough was it?
            $result_string.= "<b>Datasets merged!</b><br>";
        }
//print details and visualize
        ?>
        <?php
        $sql=$this->db->query("SELECT * FROM datasets ORDER by id Desc");
        $row=$sql->result_array();
        $row=$row[0];

        $result_string.= "<h3>".$row['name']."</h3>";
        $table = $row['table'];

        $result = $this->db->list_fields($table);
        if (!$result) {
            $result_string.= 'Could not run query';
            return $result_string;
        }
        if (count($result) > 0) {
            $result_string.="<div style='font-size:x-small'>Data Fields: ";
            $fields=array();
                foreach($result as $value){
                        $fields[]=$value;
                }

            $result_string.= implode(', ', $fields);
            //description

            $result_string.="</div>";
        }
        $result_string.= $row['description'];
        $result_string.= "<br><a class='white_link' href='".base_url()."visualize?dataset=".$row['id']."'>Create visualization</a>";

        print $result_string;
    }
}
?>