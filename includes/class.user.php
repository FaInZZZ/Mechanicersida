<?php
class User {
    private $username;
    private $role;
    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo) {
        $this->role = 4;
        $this->username = "RandomGuest123";
        $this->pdo = $pdo;
    }
  
    private function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
  
    public function checkUserRegisterInput($uname, $umail, $upass, $upassrepeat){
        $this->errorState = 0;
        if(isset($_POST['register-submit'])){
            $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
            $stmt_checkUsername->bindParam(":uname", $uname, PDO::PARAM_STR);
            $stmt_checkUsername->bindParam(":email", $umail, PDO::PARAM_STR);
            $stmt_checkUsername->execute();
          
            if($stmt_checkUsername->rowCount() > 0){
                array_push($this->errorMessages,"Username or email is already taken! ");
                $this->errorState = 1;
            }
        }
        else{
            $stmt_checkUserEmail = $this->pdo->prepare('SELECT * FROM table_users WHERE u_email = :email');
            $stmt_checkUserEmail->bindParam(":email", $umail, PDO::PARAM_STR);
            $stmt_checkUserEmail->execute();
            
            if($stmt_checkUserEmail->rowCount() > 0){
                array_push($this->errorMessages,"Email is already taken! ");
                $this->errorState = 1;
            }
        }
        
        if($upass !== $upassrepeat){
            array_push($this->errorMessages,"Passwords do not match! ");
            $this->errorState = 1;
        }
        else{
            if(strlen($upass) < 8){
                array_push($this->errorMessages,"Password is too short! ");
                $this->errorState = 1;
            }
        }
        
        if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorMessages,"Email not in correct format! ");
            $this->errorState = 1;
        }
      
        if($this->errorState === 1){ 
            return $this->errorMessages;
        }
        else {
            return 1;
        }
    }
  
    public function register($uname, $umail, $upass){
        $hashedPassword = password_hash($upass, PASSWORD_DEFAULT);
        $uname = $this->cleanInput($uname);
        
        $stmt_registerUser = $this->pdo->prepare('INSERT INTO table_users (u_name, u_password, u_email, u_role_fk) VALUES (:name, :pw, :email, 1)');
        $stmt_registerUser->bindParam(":name", $uname, PDO::PARAM_STR);
        $stmt_registerUser->bindParam(":pw", $hashedPassword, PDO::PARAM_STR);
        $stmt_registerUser->bindParam(":email", $umail, PDO::PARAM_STR);
        
        if($stmt_registerUser->execute()){
            header("Location: index.php?newuser=1");
        }
        else{
            array_push($this->errorMessages, "Your info was input correctly,but something went wrong when saving to database, please be in touch with support!");
        }
    }
  
    public function login($unamemail, $upass){
        $this->errorState = 0;
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
        $stmt_checkUsername->bindParam(":uname", $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(":email", $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->execute();

        if($stmt_checkUsername->rowCount() === 0){
            array_push($this->errorMessages,"Username or email does not exist! ");
            $this->errorState = 1;
        }

        $userData = $stmt_checkUsername->fetch();
        
        if(password_verify($upass, $userData['u_password'])){
            $_SESSION['user_id'] = $userData['u_id'];
            $_SESSION['user_name'] = $userData['u_name'];
            $_SESSION['user_mail'] = $userData['u_email'];
            $_SESSION['user_role'] = $userData['u_role_fk'];
            header("Location: project.php");
        }
        else{
            array_push($this->errorMessages,"Password is incorrect! ");
            return $this->errorMessages;
        }
    }
  
    public function checkLoginStatus(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        else{
            header("Location: index.php");
        }
    }
  
    public function checkUserRole($val){
        $stmt_checkUserRoleLevel = $this->pdo->prepare('SELECT * FROM table_roles WHERE r_id = :rid');
        $stmt_checkUserRoleLevel->bindParam(":rid", $_SESSION['user_role'], PDO::PARAM_INT);
        $stmt_checkUserRoleLevel->execute();
        $result = $stmt_checkUserRoleLevel->fetch();
        
        if($result['r_level'] >= $val){
            return true;
        }
        
        else{
            return false;
        }
    }
  
    public function editUserInfo($umail, $opass, $upass, $uid, $role, $status){
        $stmt_getUserPassword = $this->pdo->prepare('SELECT u_password FROM table_users WHERE u_id = :uid');
        $stmt_getUserPassword->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt_getUserPassword->execute();
        $oldPassword = $stmt_getUserPassword->fetch();
        
        if(isset($_POST['update-submit'])){
            if(!password_verify($opass, $oldPassword['u_password'])){
                return "The password is invalid";
            }
        }
        $hashedPassword = password_hash($upass, PASSWORD_DEFAULT);
        
        $stmt_updateUserInfo = $this->pdo->prepare('UPDATE table_users SET u_email=:umail, u_password=:upass, u_role_fk = :role, u_status = :status WHERE u_id = :uid');
        $stmt_updateUserInfo->bindParam(":umail", $umail, PDO::PARAM_STR);
        $stmt_updateUserInfo->bindParam(":upass", $hashedPassword, PDO::PARAM_STR);
        $stmt_updateUserInfo->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt_updateUserInfo->bindParam(":role", $role, PDO::PARAM_INT);
        $stmt_updateUserInfo->bindParam(":status", $status, PDO::PARAM_INT);
        
        if($stmt_updateUserInfo->execute() && $uid == $_SESSION['user_id']){
            $_SESSION['user_mail'] = $umail;
        }
    }

    public function editCustInfo($uid, $cust_fname, $cust_lname, $cust_tel, $cust_epost, $cust_adress, $cust_postnummer, $cust_ort) {
        $stmt_updateCustInfo = $this->pdo->prepare('UPDATE table_customer SET cust_fname=:fname, cust_lname=:lname, cust_tel=:tel, cust_epost=:epost, cust_adress=:adress, cust_postnummer=:postnummer, cust_ort=:ort WHERE id_cust=:uid');
        
        $stmt_updateCustInfo->bindParam(":fname", $cust_fname, PDO::PARAM_STR);
        $stmt_updateCustInfo->bindParam(":lname", $cust_lname, PDO::PARAM_STR);
        $stmt_updateCustInfo->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt_updateCustInfo->bindParam(":tel", $cust_tel, PDO::PARAM_STR);
        $stmt_updateCustInfo->bindParam(":epost", $cust_epost, PDO::PARAM_STR);
        $stmt_updateCustInfo->bindParam(":adress", $cust_adress, PDO::PARAM_STR);
        $stmt_updateCustInfo->bindParam(":postnummer", $cust_postnummer, PDO::PARAM_STR);
        $stmt_updateCustInfo->bindParam(":ort", $cust_ort, PDO::PARAM_STR);
        
        if ($stmt_updateCustInfo->execute()) {
            header("Location: active_projects.php?status=successeditcust");
            exit();
        } else {
            header("Location: active_projects.php?status=faileditcust");
            exit();
        }
    }

    public function searchUsers($input){
        $inputJoker = "%{$input}%";
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name LIKE :uname OR u_email LIKE :email');
        $stmt_checkUsername->bindParam(":uname", $inputJoker, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(":email", $inputJoker, PDO::PARAM_STR);
        $stmt_checkUsername->execute();
        $userArray = $stmt_checkUsername->fetchAll();
        return $userArray;
    }

    public function searchCust($input){
        $inputJoker = "%{$input}%";
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_customer WHERE cust_lname LIKE :cust_lname OR cust_epost LIKE :cust_epost');
        $stmt_checkUsername->bindParam(":cust_lname", $inputJoker, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(":cust_epost", $inputJoker, PDO::PARAM_STR);
        $stmt_checkUsername->execute();
        $userArray = $stmt_checkUsername->fetchAll();
        return $userArray;
    }
  
    public function getUserInfo($uid){
        $stmt_selectUserData = $this->pdo->prepare('SELECT * FROM table_users WHERE u_id = :uid');
        $stmt_selectUserData->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt_selectUserData->execute();
        $userInfo = $stmt_selectUserData->fetch();
        return $userInfo;
    }
  
    public function logout(){
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
  
    public function deleteUser($uid){
        $stmt_deleteUser = $this->pdo->prepare('DELETE FROM table_users WHERE u_id = :uid');
        $stmt_deleteUser->bindParam(":uid", $uid, PDO::PARAM_INT);
        if($stmt_deleteUser->execute()){
            return "User deleted successfully";
        }
        else{
            return "Something unexpected has happened. Try again later or contact support";
        }
    }

    public function getCustInfo($uid){
        $stmt_custData = $this->pdo->prepare('SELECT * FROM table_customer WHERE id_cust = :uid');
        $stmt_custData->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt_custData->execute();
        $CustInfo = $stmt_custData->fetch();
        return $CustInfo;
    }

    public function deleteCust($uid){
        $stmt_deleteCust = $this->pdo->prepare('DELETE FROM table_customer WHERE id_cust = :uid');
        $stmt_deleteCust->bindParam(":uid", $uid, PDO::PARAM_INT);
        if($stmt_deleteCust->execute()){
            return "Customer deleted successfully";
        }
        else{
            return "Something unexpected has happened. Try again later or contact support";
        }
    }

    public function getAllCustomers() {
        $stmt = $this->pdo->prepare("SELECT id_cust, cust_fname, cust_lname FROM table_customer");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
