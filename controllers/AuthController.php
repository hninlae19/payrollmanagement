<?php
class AuthController extends Controller {

    public function index() {
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['role'] === 'Admin') {
                $this->redirect('/payrollsystem/admin');
            } else {
                $this->redirect('/payrollsystem/employee');
            }
            return;
        }
        $this->employee();
    }

    /**
     * Display or handle Employee Login
     */
    public function employee() {
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['role'] === 'Admin') {
                $this->redirect('/payrollsystem/admin');
            } else {
                $this->redirect('/payrollsystem/employee');
            }
            return;
        }
        $this->view('auth/employee_login', ['title' => 'Employee Portal Login']);
    }

    public function employee_login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');
            
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->view('auth/employee_login', [
                    'title' => 'Employee Portal Login', 
                    'error' => 'Please enter your employee email and password.'
                ]);
                return;
            }

            $employeeModel = $this->model('Employee');
            if ($employeeModel->login($email, $password)) {
                $_SESSION['user_id'] = $employeeModel->EmpID;
                $_SESSION['employee_id'] = $employeeModel->EmpID;
                $_SESSION['role'] = 'Employee';
                $_SESSION['email'] = $email;
                $_SESSION['first_name'] = $employeeModel->FirstName;
                $_SESSION['last_name'] = $employeeModel->LastName;
                $_SESSION['profile_picture'] = $employeeModel->ProfilePicture;
                $_SESSION['is_first_login'] = $employeeModel->is_first_login;
                $this->redirect('/payrollsystem/employee');
                return;
            }

            $this->view('auth/employee_login', [
                'title' => 'Employee Portal Login', 
                'error' => 'Invalid employee email or password.'
            ]);
        } else {
            $this->employee();
        }
    }

    /**
     * Display or handle Admin Login (NO Forgot Password)
     */
    public function admin() {
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['role'] === 'Admin') {
                $this->redirect('/payrollsystem/admin');
            } else {
                $this->redirect('/payrollsystem/employee');
            }
            return;
        }
        $this->view('auth/admin_login', ['title' => 'Admin Portal Login']);
    }

    public function admin_login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');
            
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->view('auth/admin_login', [
                    'title' => 'Admin Portal Login', 
                    'error' => 'Please enter admin email and password.'
                ]);
                return;
            }

            $adminModel = $this->model('Admin');
            if ($adminModel->login($email, $password)) {
                $_SESSION['user_id'] = $adminModel->AdminID;
                $_SESSION['role'] = 'Admin';
                $_SESSION['email'] = $adminModel->Email;
                $this->redirect('/payrollsystem/admin');
                return;
            }

            $this->view('auth/admin_login', [
                'title' => 'Admin Portal Login', 
                'error' => 'Invalid administrator credentials.'
            ]);
        } else {
            $this->admin();
        }
    }

    /**
     * Fallback login method
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $portalType = $_POST['portal_type'] ?? 'employee';
            if ($portalType === 'admin') {
                $this->admin_login();
            } else {
                $this->employee_login();
            }
        } else {
            $this->employee();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/payrollsystem/home');
    }

    public function forgot_password() {
        $this->view('auth/forgot_password', ['title' => 'Forgot Password']);
    }

    public function forgot_password_submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrfToken($_POST['csrf_token'] ?? '');
            
            $email = trim($_POST['email'] ?? '');
            if (empty($email)) {
                $this->view('auth/forgot_password', ['title' => 'Forgot Password', 'error' => 'Please enter your email.']);
                return;
            }

            // Check if employee exists
            $db = new Database();
            $conn = $db->getConnection();
            $query = "SELECT EmpID FROM employee WHERE Email = :email AND Status = 'Active'";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // Set PasswordResetRequest = 1
                $updateQuery = "UPDATE employee SET PasswordResetRequest = 1 WHERE Email = :email";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bindParam(':email', $email);
                $updateStmt->execute();

                // Send notification to Admin (user_id 1)
                require_once __DIR__ . '/../models/Notification.php';
                $notifModel = new Notification();
                $empStmt = $conn->prepare("SELECT EmpID, FirstName, LastName FROM employee WHERE Email = :email");
                $empStmt->bindParam(':email', $email);
                $empStmt->execute();
                $emp = $empStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($emp) {
                    $notifMessage = $emp['FirstName'] . " " . $emp['LastName'] . " (ID: " . $emp['EmpID'] . ") requested a password reset.";
                    $notifModel->create(1, $notifMessage, 'error', '/admin/password_resets', 'Password Reset Request', $emp['EmpID']);
                }
            }

            // Always show success message and redirect to employee login
            $_SESSION['login_success'] = "Password reset requested! An Admin will review and assist you with your new password soon.";
            $this->redirect('/payrollsystem/auth/employee');
        } else {
            $this->redirect('/payrollsystem/auth/employee');
        }
    }
}
