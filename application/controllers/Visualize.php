<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visualize extends CI_Controller
{

    public function index()
    {
        $this->load->view('header');
        $this->load->view('visualize');
        $this->load->view('footer');
    }

    public function step2()
    {

        $id = $_POST['dataset'];
        $type = $_POST['type'];
        ?>
        <section>

            <form action='<?php echo base_url(); ?>visualize/finish' method='POST'>
                <input type='hidden' value='<?php echo $type ?>' name='type' class="form-control">
                <input type='hidden' value='<?php echo $id ?>' name='dataset' class="form-control">
                <table width='100%'>
                    <tr>
                        <td>Title</td>
                        <td><input type='text' name='title' class='form-control'></td>
                    </tr>
                    <?php
                    if ($type == 'PieChart') {
                        $this->PieChart($id);
                    } else {
                        $this->LineChart($id);
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><input type='submit' value='Next' class='btn btn-primary'></td>
            </form>
            </table>
        </section>
        <?php
    }

    public function PieChart($id)
    {
        echo "<tr><td>Label</td>";
        //Label
        $sql = $this->db->query("SELECT * FROM datasets WHERE id='" . $id . "'");
        $row = $sql->result_array();
        $row = $row[0];

        $table = $row['table'];

        $result = $this->db->list_fields($table);
        $result2 = $this->db->list_fields($table);
        if (!$result) {
            echo 'Could not run query';
            exit;
        }
        if (count($result) > 0) {

            echo "<td><select name='label1' class='form-control'>";

            foreach ($result as $field) {
                echo "<option value='$field'>$field</option>";
            }

            echo "</select></td></tr>";


        }
        //values
        echo "<tr><td>Values</td>";
        if (count($result2) > 0) {

            echo "<td><select name='label2' class='form-control'>";
            foreach ($result2 as $field) {
                echo "<option value='$field'>$field</option>";
            }

            echo "</select></td></tr>";

        }
    }

    public function LineChart($id)
    {
        echo "<tr><td>x-axis</td>";
        $sql = $this->db->query("SELECT * FROM datasets WHERE id='" . $id . "'");
        $row = $sql->result_array();
        $row = $row[0];
        $table = $row['table'];

        $result = $this->db->list_fields($table);
        $result2 =$this->db->list_fields($table);

        //show x-axis
        if (!$result) {
            echo 'Could not run query';
            exit;
        }
        if (count($result) > 0) {

            $fields = array();
            echo "<td><select name='label1' class='form-control'>";
            foreach ($result2 as $field) {
                echo "<option value='$field'>$field</option>";
            }

            echo "</select></td></tr>";

        }
        //show other things to plot
        echo "<tr><td></td><td><b>Chart Parameters</b></td></tr>";
        if (!$result2) {
            echo 'Could not run query';
            exit;
        }
        if (count($result2) > 0) {

            foreach ($result2 as $value) {
                if ($value != 'id') {
                    echo "<tr><td><input type='checkbox' name='label[]' value='" . $value . "' class='form-control'></td><td>";
                    echo "$value";
                    echo "</td></tr>";
                }
            }
        }
    }

    public function finish()
    {
        $title = $_POST['title'];
        $type = $_POST['type'];
        $label1 = $_POST['label1'];
        $dataset = $_POST['dataset'];
        if ($type == 'PieChart') {
            $label2 = $_POST['label2'];
        } else {
            $label = implode(',', $_POST['label']);
            $label2 = $label;
        }
        $sql = $this->db->query("INSERT INTO charts( `type`, `title`, `label1`, `label2`, `dataset`)VALUES('$type', '$title', '$label1', '$label2', '$dataset')");

        $data['sql'] = $sql;


        $sql = $this->db->query("SELECT * FROM charts ORDER BY id Desc");
        $row = $sql->result_array();
        $data['row'] = $row[0];

        $this->load->view('header');
        $this->load->view('finish_visualization', $data);
        $this->load->view('footer');
    }

    public function chart()
    {
        $this->load->view('header');

        $id = $_GET['id'];
        $data['id'] = $_GET['id'];

        $sql = $this->db->query("SELECT * FROM charts WHERE id='$id'");
        $row = $sql->result_array();
        $row = $row[0];

        $type = $row['type'];
        $data['type'] = $row['type'];
        $data['title'] = $row['title'];
        $label1 = $row['label1'];
        $label2 = $row['label2'];

        $dataset = $row['dataset'];

        $sql3 = $this->db->query("SELECT * FROM datasets WHERE id='$dataset'");
        $row3 = $sql3->result_array();
        $row3 = $row3[0];

        $table = $row3['table'];


        $data_raw = array();
//piechart
        if($type=='PieChart')
        {

            $data_raw[]= "['$label1', '$label2']";

            $sql2 = $this->db->query("SELECT * FROM $table");

            $sql2 = $sql2->result_array();

            foreach($sql2 as $row2)
            {
                $data_raw[]="['".$row2[$label1]."', ".$row2[$label2]."]";
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


            $data_raw[]= "['$label1', $labels]";

            $sql2 = $this->db->query("SELECT * FROM $table");
            $total = substr_count($label3, ',');
            $label3 = explode(',', $label3);
            $total = $total+1;

            $sql2 = $sql2->result_array();

            foreach($sql2 as $row2)
            {
                $rowf=array();
                for($i=0;$i<$total;$i++)
                {
                    $rowf[]=$row2[$label3[$i]];
                }
                $rowf=implode(', ', $rowf);

                $data_raw[]="['".$row2[$label1]."', $rowf]";
            }
        }

        $data['data'] =implode(', ', $data_raw);

        $this->load->view('chart.php', $data);

        $this->load->view('footer');
    }
}

