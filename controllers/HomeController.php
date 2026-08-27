<?php
class HomeController extends Controller {
    public function index() {
        // If user is already logged in, redirect to their dashboard
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['role'] === 'Admin') {
                $this->redirect('/payrollsystem/admin');
            } else {
                $this->redirect('/payrollsystem/employee');
            }
            return;
        }
        
        $this->view('home/index', ['title' => 'Home']);
    }
}
