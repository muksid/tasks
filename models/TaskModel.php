<?php
/**
 *
 */

require_once 'config/Database.php';

class TaskModel
{

    private $db;

    function __construct()
    {
        # code...
        $databs = new Database();
        $this->host = $databs->host;
        $this->user = $databs->DB_USER;
        $this->pass = $databs->pass;
    }

    function connecDB()
    {
        try {
            $this->db = new PDO("mysql:host=$this->host;dbname=tasks", 'root', '');
            /*** echo a message saying we have connected ***/

        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function closeDB()
    {
        $this->db->close();
    }

    public function get($id, $order, $sort)
    {
        try {
            $this->connecDB();
            $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id=:id");
            $stmt->execute(array(":id"=>$id));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        catch (Exception $exception) {
            throw new Exception("Error: ", $exception);
        }
    }

	public function insertTask($objData)
	{
	    //
        try {
            $this->connecDB();
            $objData->status = 0;
            $sql = "INSERT INTO tasks(user_name,email,task_text, status) VALUES(:un, :em, :tt, :st)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(":un", $objData->user_name);
            $stmt->bindparam(":em", $objData->email);
            $stmt->bindparam(":tt", $objData->task_text);
            $stmt->bindparam(":st", $objData->status);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            $this->closeDB();
            throw $e;
        }
	}

	public function updateTask($objData)
	{
        try
        {
            $this->connecDB();
            $get_task = $this->get($objData->id, null, null);
            $status = $get_task['status'];
            $tt = $get_task['task_text'];
            if (!empty($_SESSION['username'])){
                $status = $objData->status;
                
                if($tt != trim($objData->task_text)){                   
                $status = 1;
                } elseif($status == 2) {
                $status = $objData->status;
                } elseif($status != 2){
                    $status = 0;
                }
                else {
                    $status = $get_task['status'];
                }
            }
            $sql = "UPDATE tasks SET user_name=:un, email=:em, task_text=:tt, status=:st WHERE id=:id";
            $stmt=$this->db->prepare($sql);
            $stmt->bindparam(":un", $objData->user_name);
            $stmt->bindparam(":em", $objData->email);
            $stmt->bindparam(":tt", $objData->task_text);
            $stmt->bindparam(":st", $status);
            $stmt->bindparam(":id",$objData->id);
            $stmt->execute();

            return true;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
	}

    public function deleteTask($id)
    {
        try{
            $this->connecDB();
            $sql = "DELETE FROM tasks WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(":id",$id);
            $stmt->execute();
            return true;
        }
        catch (Exception $e)
        {
            $this->closeDB();
            throw $e;
        }
    }

    public function dataView($query)
    {
        $this->connecDB();
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if($stmt->rowCount()>0)
        {
            $row_num = 0;

            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $row_num++;
                ?>
                <tr>
                    <td><?php print($row_num); ?></td>
                    <td><?php print($row['user_name']); ?></td>
                    <td><?php print($row['email']); ?></td>
                    <td><?php print($row['task_text']); ?></td>
                    <td>
                        <?php
                        if ($row['status'] == 0){
                            echo '<span class="badge badge-pill badge-danger">Новый</span>';
                        } elseif($row['status'] == 1) {
                            echo '<span class="badge badge-pill badge-primary">Отредактировал</span>';
                        } else {
                            echo '<span class="badge badge-pill badge-success">Выполнено</span>';
                        }
                        ?>
                    </td>
                    <td align="center">
                        <a href="index.php?act=update&id=<?php echo $row['id']; ?>"><i class="bi bi-pencil"></i></a>
                    </td>
                    <td align="center">
                        <?php
                        if (!$_SESSION['username'] == 'admin') { ?>
                            <a href="index.php?act=delete&id=<?php echo $row['id']; ?>"><i class="bi bi-trash"></i></a>
                        <? }?>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
            <tr>
                <td>not found rows...</td>
            </tr>
            <?php
        }

    }

    public function paging($query,$records_per_page)
    {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
    }

    public function pagingLink($query,$records_per_page)
    {

        $self = $_SERVER['PHP_SELF'];

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $total_no_of_records = $stmt->rowCount();

        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li class='page-item'><a href='".$self."?page_no=1' class='page-link'>First</a></li>";
                echo "<li class='page-item'><a href='".$self."?page_no=".$previous."' class='page-link'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li class='page-item active'><a href='".$self."?page_no=".$i."' class='page-link'>".$i."</a></li>";
                }
                else
                {
                    echo "<li class='page-item'><a href='".$self."?page_no=".$i."' class='page-link'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li class='page-item'><a href='".$self."?page_no=".$next."' class='page-link'>Next</a></li>";
                echo "<li class='page-item'><a href='".$self."?page_no=".$total_no_of_pages."' class='page-link'>Last</a></li>";
            }
            ?></ul><?php
        }
    }


}
