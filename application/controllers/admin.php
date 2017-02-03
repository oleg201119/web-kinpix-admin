<?php
/**
 * Web Admin Panel for KinPix system.
 * Created by
 * 		boris801117@hotmail.com	2015/02/23
 * Do not copy or use this module without boris's approval.
 * Contact email
 * 		boris801117@hotmail.com
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ROWS_PER_USERPAGE',             10);
define('ROWS_PER_FLAGPAGE',             5);

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('pagination');

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('download');

        $this->load->model('admin_model');
        $this->load->model('user_model');
        $this->load->model('post_model');
    }

    // Default method
    public function index()
    {
        $this->view('login');
    }

    private function create_pagination($base_url, $total_rows, $per_page, $num_links)
    {
        $config['base_url'] = $base_url;
        $config['uri_segment'] = 3;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;

        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';

        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

    public function view($page = 'login')
    {
        if ( ! file_exists('application/views/pages/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        // Check session
        if ($this->session->userdata('login_state') != TRUE)
        {
            $page = 'login';
        }

        $data['page'] = $page;

        if ($page != 'login')
        {
            show_404();
        }
        else if ($page == 'login')
        {
            $data['side_menu'] = '';
        }

        // Load view
        $this->load->view('templates/header', $data);

        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function login()
    {
        $username = ($this->input->post('username'));
        $password = ($this->input->post('password'));

        // check account
        $result = $this->admin_model->check_user($username, $password);

        if ($result >= 0)
        {
            $this->session->set_userdata('login_state', 'online'); // state is logged in
            $this->session->set_userdata('login_user', $username); // admin username
            $this->session->set_userdata('login_permission', $result); // admin flag
        }
        else{
            $this->session->set_userdata('login_state', FALSE); // state is logged out
        }

        echo json_encode(array('result' => $result));
    }

    public function change_password()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $username = ($this->session->userdata('login_user'));
        $password = ($this->input->post('password'));

        // change password
        $this->admin_model->change_password($username, $password);

        echo json_encode(array('result' => 1));
    }

    public function logout()
    {
        $this->session->set_userdata('login_state', 'offline'); // state is logged out
        $this->session->unset_userdata('login_state');
        redirect('admin/view/login');
    }

    public function search_user()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $offset = $this->uri->segment(3, 0);

        if ($this->input->post('search_start') == 1)
        {
            $search_field = ($this->input->post('search_field'));
            $search_val = ($this->input->post('search_val'));
            $sort_field = ($this->input->post('sort_field'));
            $order_field = ($this->input->post('order_field'));

            $this->session->set_userdata('search_field', $search_field);
            $this->session->set_userdata('search_val', $search_val);
            $this->session->set_userdata('sort_field', $sort_field);
            $this->session->set_userdata('order_field', $order_field);
        }
        else
        {
            $search_field = $this->session->userdata('search_field');
            $search_val = $this->session->userdata('search_val');
            $sort_field = $this->session->userdata('sort_field');
            $order_field = $this->session->userdata('order_field');
        }

        if ($search_field == null) {
            $search_field = "email";
        }

        if ($search_val == null) {
            $search_val = "";
        }

        if ($sort_field == null) {
            $sort_field = "accountcreatedate";
        }

        if ($order_field == null) {
            $order_field = "asc";
        }

        $data['search_field'] = $search_field;
        $data['search_val'] = $search_val;
        $data['sort_field'] = $sort_field;
        $data['order_field'] = $order_field;

        $total_user = $this->user_model->get_total_user();
        $result = $this->user_model->search_user($search_field, $search_val, $sort_field, $order_field, $offset, ROWS_PER_USERPAGE);

        $base_url = site_url('admin/search_user');
        $num_links = 2;

        $pagenation = $this->create_pagination($base_url, $result['total_count'], ROWS_PER_USERPAGE, $num_links);

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $data['pagenation'] = $pagenation;
        $data['offset'] = $offset;
        $data['data_list'] = $result['data'];
        $data['total_user'] = $total_user;

        $page = 'home';
        $data['side_menu'] = 'home';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function accept_user()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $userid = $this->uri->segment(3);

        $this->user_model->accept_user($userid);

        redirect('admin/search_user/0');
    }

    public function reject_user()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $userid = $this->uri->segment(3);

        $this->user_model->reject_user($userid);

        redirect('admin/search_user/0');
    }

    public function delete_user()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $userid = $this->uri->segment(3);

        $this->user_model->delete_user($userid);

        redirect('admin/search_user/0');
    }

    public function suspend_user()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $userid = $this->uri->segment(3);

        $this->user_model->suspend_user($userid);

        redirect('admin/search_user/0');
    }

    public function unsuspend_user()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $userid = $this->uri->segment(3);

        $this->user_model->unsuspend_user($userid);

        redirect('admin/search_user/0');
    }

    public function flag_photo()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $offset = $this->uri->segment(3, 0);

        $result = $this->post_model->get_photos($offset, ROWS_PER_FLAGPAGE);

        $base_url = site_url('admin/flag_photo');
        $num_links = 2;

        $pagenation = $this->create_pagination($base_url, $result['total_count'], ROWS_PER_FLAGPAGE, $num_links);

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $data['pagenation'] = $pagenation;
        $data['offset'] = $offset;
        $data['data_list'] = $result['data'];

        $page = 'flag_photo';
        $data['side_menu'] = 'flag_photo';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function delete_photo()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $photoid = $this->uri->segment(3);

        $this->post_model->delete_photo($photoid);

        redirect('admin/flag_photo/0');
    }

    public function ignore_accusation()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $photoid = $this->uri->segment(3);

        $this->post_model->ignore_accusation($photoid);

        redirect('admin/flag_photo/0');
    }

    public function admins()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $offset = $this->uri->segment(3, 0);

        $result = $this->admin_model->get_admins($offset, ROWS_PER_USERPAGE);

        $base_url = site_url('admin/admins');
        $num_links = 2;

        $pagenation = $this->create_pagination($base_url, $result['total_count'], ROWS_PER_USERPAGE, $num_links);

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $data['pagenation'] = $pagenation;
        $data['offset'] = $offset;
        $data['data_list'] = $result['data'];

        $page = 'admins';
        $data['side_menu'] = 'admins';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function check_adminname()
    {
        $username = ($this->input->post('username'));

        $result = $this->admin_model->check_username($username);

        if ($result == 1)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }

    public function check_adminname_edit()
    {
        $username = ($this->input->post('username'));
        $username_old = ($this->input->post('username_old'));

        if ($username == $username_old)
        {
            $result = 1;
        }
        else
        {
            $result = $this->admin_model->check_username($username);
        }

        if ($result == 1)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }

    public function new_admin()
    {
        $username = ($this->input->post('username'));
        $password = ($this->input->post('password'));
        $adminflag = ($this->input->post('adminflag'));

        // create admin account
        $result = $this->admin_model->new_admin($username, $password, $adminflag);

        echo json_encode(array('result' => $result));
    }

    public function edit_admin()
    {
        $username_old = ($this->input->post('username_old'));
        $username = ($this->input->post('username'));
        $password = ($this->input->post('password'));
        $adminflag = ($this->input->post('adminflag'));

        // create admin account
        $result = $this->admin_model->edit_admin($username_old, $username, $password, $adminflag);

        echo json_encode(array('result' => $result));
    }

    public function delete_admin()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $username = $this->uri->segment(3);

        // delete admin account
        $result = $this->admin_model->delete_admin($username);

        redirect('admin/admins/0');
    }

    public function change_pwd()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $page = 'change_pwd';
        $data['side_menu'] = 'change_pwd';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function setting()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $settings = $this->admin_model->get_settings();
        $data['settings'] = $settings;

        $page = 'setting';
        $data['side_menu'] = 'setting';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function check_oldpassword()
    {
        $username = ($this->session->userdata('login_user'));
        $password = $this->input->post('password');

        $result = $this->admin_model->check_user($username, $password);

        if ($result >= 0) {
            echo 'true';
        }
        else {
            echo 'false';
        }
    }

    public function set_settings()
    {
        $comprate = $this->input->post('comprate');
        $autosignflag = $this->input->post('autosignflag');

        $this->admin_model->set_settings($comprate, $autosignflag);

        echo json_encode(array('result' => 1));
    }

    public function about()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        // Get content
        $content = $this->admin_model->get_screencontent('about');
        $data['content'] = $content;

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $page = 'about';
        $data['side_menu'] = 'about';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function help()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        // Get content
        $content = $this->admin_model->get_screencontent('help');
        $data['content'] = $content;

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $page = 'help';
        $data['side_menu'] = 'help';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function feedback()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        // Get content
        $content = $this->admin_model->get_screencontent('feedback');
        $data['content'] = $content;

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $page = 'feedback';
        $data['side_menu'] = 'feedback';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function privacy()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        // Get content
        $content = $this->admin_model->get_screencontent('privacy');
        $data['content'] = $content;

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $page = 'privacy';
        $data['side_menu'] = 'privacy';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function terms()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        // Get content
        $content = $this->admin_model->get_screencontent('terms');
        $data['content'] = $content;

        $username = ($this->session->userdata('login_user'));
        $data['username'] = $username;

        $page = 'terms';
        $data['side_menu'] = 'terms';
        $data['page'] = $page;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function save_content()
    {
        $screen = ($this->input->post('screen'));
        $content = ($this->input->post('content'));

        $this->admin_model->set_screencontent($screen, $content);

        echo json_encode(array('result' => 1));
    }

    public function send_content()
    {
        $screen = ($this->input->post('screen'));

        // Send mail
        $this->user_model->send_update_mail($screen);

        echo json_encode(array('result' => 1));
    }

    public function change_usertype()
    {
        $userid = urldecode($this->input->post('userid'));
        $usertype = urldecode($this->input->post('usertype'));

        $this->user_model->change_usertype($userid, $usertype);

        $this->output->set_content_type('application/json');
        echo json_encode(array('result' => 1));
    }

    public function download_photo()
    {
        if ($this->session->userdata('login_state') != 'online')
            redirect('admin/view/login');

        $userid = $this->uri->segment(3, 0);

        return "";
    }

    public function export_csv()
    {
        $search_field = $this->session->userdata('search_field');
        $search_val = $this->session->userdata('search_val');
        $sort_field = $this->session->userdata('sort_field');
        $order_field = $this->session->userdata('order_field');

        if ($search_field == null) {
            $search_field = "email";
        }

        if ($search_val == null) {
            $search_val = "";
        }

        if ($sort_field == null) {
            $sort_field = "accountcreatedate";
        }

        if ($order_field == null) {
            $order_field = "asc";
        }

        $result = $this->user_model->export_user($search_field, $search_val, $sort_field, $order_field);
        force_download('kinpix_users_' . date('Ymd') . '.csv', $result);
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */