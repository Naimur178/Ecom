<?php
class adminBack{
    private $conn;

    public function __construct()
    {
        $dbhost= "localhost";
        $dbuser= "root";
        $dbpass="";
        $dbname="eshop";

        $this->conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

        if(!$this->conn){
            die("Database Connection Error!");
        }
        
    }
    function admin_login($data){
        $admin_email = $data['admin_email'];
        $admin_pass = md5($data['admin_pass']);

        $query="SELECT * FROM adminlog 
        WHERE admin_email='$admin_email' AND 
        admin_pass='$admin_pass' ";

        if(mysqli_query($this->conn,$query)){
        $result =mysqli_query($this->conn,$query);
        $admin_info= mysqli_fetch_assoc($result);

        if($admin_info){
            header('location:dashboard.php');
            session_start();
            $_SESSION['id']=$admin_info['id'];
            $_SESSION['admin_email']=$admin_info['admin_email'];
            $_SESSION['adminPass']=$admin_info['admin_pass'];

        }else{
            $errmsg="Your username or Password is incorrect!";
            return $errmsg;
        }
        }
    }

    function adminLogout(){
        unset($_SESSION['id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['adminPass']);
        header('location:index.php');
    }

    function add_catagory($data){
        $ctg_name= $data['ctg_name'];
        $ctg_des=$data['ctg_des'];
        $ctg_status=$data['ctg_status'];

        $query= "INSERT INTO catagory(ctg_name,ctg_des,ctg_status)
        VALUE('$ctg_name','$ctg_des','$ctg_status ')";
        if(mysqli_query($this->conn, $query)){
            $message= "Catagory Added Successfully";
            return $message;
        }else
        {
            $message= "Catagory Not Added";
            return $message;
        }
    }
    
    function display_catagory(){
        $query ="SELECT * FROM catagory";
        if(mysqli_query($this->conn, $query)){
            $return_ctg = mysqli_query($this->conn, $query);
            return $return_ctg;
        }
    }

    function p_display_catagory(){
        $query ="SELECT * FROM catagory WHERE ctg_status=1";
        if(mysqli_query($this->conn, $query)){
            $return_ctg = mysqli_query($this->conn, $query);
            return $return_ctg;
        }
    }

    function publish_catagory($id){
         $query = "UPDATE catagory SET ctg_status=1 WHERE ctg_id=$id";
         mysqli_query($this->conn, $query);
    }

    function unpublish_catagory($id){
        $query = "UPDATE catagory SET ctg_status=0 WHERE ctg_id=$id";
         mysqli_query($this->conn, $query);
    }
    function delete_catagory($id){
        $query="DELETE FROM catagory WHERE ctg_id=$id";
        if(mysqli_query($this->conn, $query)){
            $msg="Catagory deleted successfully!";
            return $msg;
        }

    }
    function getCatinfo_toupdate($id){
        $query="SELECT * FROM catagory WHERE ctg_id=$id";
        if(mysqli_query($this->conn,$query)){
            $cat_info= mysqli_query($this->conn, $query);
            $ct_info= mysqli_fetch_assoc($cat_info);
            return $ct_info;
        }
    }
    function update_catagory($recieve_data){
        $ctg_name=$recieve_data['u_ctg_name'];
        $ctg_des=$recieve_data['u_ctg_des'];
        $ctg_id=$recieve_data['u_ctg_id'];
        
        $query="UPDATE catagory SET ctg_name='$ctg_name',
        ctg_des='$ctg_des' WHERE ctg_id=$ctg_id";

        if(mysqli_query($this->conn,$query)){
            $return_msg="Catagory updated Successfully!";
            return $return_msg;
        }
    }
    function add_product($data)
    {
        $pdt_name= $data['pdt_name'];
        $pdt_price= $data['pdt_price'];
        $pdt_des= $data['pdt_des'];
        $pdt_ctg= $data['pdt_ctg'];
        $pdt_img_name= $_FILES['pdt_image']['name'];
        $pdt_img_size= $_FILES['pdt_image']['size'];
        $pdt_temp_name= $_FILES['pdt_image']['tmp_name'];
        $pdt_ext =pathinfo($pdt_img_name,PATHINFO_EXTENSION);
        $pdt_status= $data['pdt_status'];

        if($pdt_ext=='jpg' or $pdt_ext=='jpeg' or $pdt_ext=='png')
        {
            if($pdt_img_size<=2097152)
            {
                $query= "INSERT INTO products(pdt_name,pdt_price,pdt_des,pdt_ctg,pdt_img,pdt_status) 
                VALUE('$pdt_name',$pdt_price,'$pdt_des', $pdt_ctg,'$pdt_img_name',$pdt_status)";

                if(mysqli_query($this->conn, $query))
                {
                    move_uploaded_file( $pdt_temp_name,'upload/'.$pdt_img_name);
                    $msg="Product Added Succesfully!";
                    return $msg;
                }
            }
            else
            {
            $msg= "Your file size should be less than or equal 2MB!";
            }

        }
        else
        {
            $msg= "Your File must be JPG or PNG File!";
            return $msg;
        }
    }

    function display_product()
    {
        $query= "SELECT * FROM product_info_ctg";
        if(mysqli_query($this->conn, $query))
        {
            $product= mysqli_query($this->conn, $query);
            return $product;
        }
    }

    function delete_product($id)
    {
        $query = "DELETE FROM products WHERE pdt_id=$id";
        if(mysqli_query($this->conn, $query))
        {
            $msg= "Product Deleted Successfully!!";
            return $msg;
        }
    }

    function getEditProduct_info($id)
    {
        $query = "SELECT * FROM product_info_ctg WHERE pdt_id=$id";
        if(mysqli_query($this->conn, $query)){
            $product_info = mysqli_query($this->conn, $query);
            $pdt_data = mysqli_fetch_assoc($product_info);
            return $pdt_data;
        }
    }
    function update_product($data)
    {
        $pdt_id = $data['u_pdt_id'];
        $pdt_name= $data['u_pdt_name'];
        $pdt_price= $data['u_pdt_price'];
        $pdt_des= $data['u_pdt_des'];
        $pdt_img_name= $_FILES['u_pdt_image']['name'];
        $pdt_img_size= $_FILES['u_pdt_image']['size'];
        $pdt_temp_name= $_FILES['u_pdt_image']['tmp_name'];
        $pdt_ext =pathinfo($pdt_img_name,PATHINFO_EXTENSION);
        $pdt_status= $data['u_pdt_status'];

        if($pdt_ext=='jpg' or $pdt_ext=='jpeg' or $pdt_ext=='png')
        {
            if($pdt_img_size<=2097152)
            {
                $query= "UPDATE products 
                SET 
                pdt_name='$pdt_name',
                pdt_price= $pdt_price, pdt_des= '$pdt_des',
                pdt_img= '$pdt_img_name', pdt_status= $pdt_status
                WHERE pdt_id = $pdt_id";

                if(mysqli_query($this->conn, $query))
                {
                    move_uploaded_file( $pdt_temp_name,'upload/'.$pdt_img_name);
                    $msg="Product Updated Succesfully!";
                    return $msg;
                }
            }
            else
            {
            $msg= "Your file size should be less than or equal 2MB!";
            }

        }
        else
        {
            $msg= "Your File must be JPG or PNG File!";
            return $msg;
        }
    }

    function product_by_ctg($id){
        $query = "SELECT * FROM product_info_ctg  WHERE ctg_id=$id";
        if(mysqli_query($this->conn, $query)){
            $proinfo = mysqli_query($this->conn, $query);
            return $proinfo;
        }
    }

    function product_by_id($id){
        $query = "SELECT * FROM product_info_ctg  WHERE pdt_id=$id";
        if(mysqli_query($this->conn, $query)){
            $proinfo = mysqli_query($this->conn, $query);
            return $proinfo;
        }
    
    }

    function related_product($id){
        $query = "SELECT * FROM product_info_ctg WHERE ctg_id=$id ORDER BY pdt_id DESC LIMIT 3";
        if(mysqli_query($this->conn, $query)){
            $proinfo = mysqli_query($this->conn, $query);
            return $proinfo;
        }
    }

    function ctg_by_id($id){
        $query = "SELECT * FROM product_info_ctg WHERE ctg_id=$id";
        if(mysqli_query($this->conn, $query)){
            $proinfo = mysqli_query($this->conn, $query);
            $ctg = mysqli_fetch_assoc($proinfo);
            return $ctg;
        }
    }
    function user_register($data){
        $username= $data['username'];
        $user_firstName= $data['user_firstName'];
        $user_lastName= $data['user_lastName'];
        $useremail= $data['useremail'];
        $user_mobile= $data['user_mobile'];
        $user_pass= md5($data['user_pass']);
        $user_roles = $data['user_roles'];

        $get_user_data= "SELECT * FROM users WHERE user_name= '$username' or 
        user_email='$useremail'";
        $sent_data=mysqli_query($this->conn,$get_user_data);
        $row =mysqli_num_rows($sent_data);
        
        if($row>=1){
            $msg= "Username Or Email Already Exist!!!";
            return $msg;
        }else{
            if(strlen($user_mobile)<11 or strlen($user_mobile)>11)
            {
                $msg= "Invalid Mobile number!!";
                return $msg;
            }else{
                $query = "INSERT INTO users(user_name, user_firstName,user_lastName,
        user_email, user_password, user_mobile,user_roles ) VALUE('$username','$user_firstName',
        '$user_lastName','$useremail','$user_pass',$user_mobile,$user_roles)";

        if(mysqli_query($this->conn, $query))
        {
            $msg= "Your account successfully registered!";
            return $msg;
        }
            }
        
    }

    }

    function user_login($data){
        $user_email = $data['user_email'];
        $user_pass = md5($data['user_pass']);

        $query="SELECT * FROM users 
        WHERE user_email='$user_email' AND 
        user_password='$user_pass' ";

        if(mysqli_query($this->conn,$query)){
        $result =mysqli_query($this->conn,$query);
        $user_info= mysqli_fetch_assoc($result);

        if($user_info){
            header('location:user_profile.php');
            session_start();
            $_SESSION['id']=$user_info['user_id'];
            $_SESSION['admin_email']=$user_info['user_email'];
            $_SESSION['user_pass']=$user_info['user_password'];
            $_SESSION['user_name']=$user_info['user_name'];

        }else{
            $errmsg="Your username or Password is incorrect!";
            return $errmsg;
        }
        }
    }
}

?>