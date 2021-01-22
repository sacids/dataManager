<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2016. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $realm;
    private $user_id;
    private $controller;
    private $data = [];

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'language'));
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->lang->load('auth');
        $this->load->model('model');

        //variable
        $this->realm = 'Authorized users of Sacids Openrosa';
        $this->user_id = $this->session->userdata('user_id');
        $this->controller = $this->router->fetch_class();
    }

    // redirect if needed, otherwise display the user list
    function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {
            // redirect them to the home page because they must be an administrator to view this
            redirect('dashboard', 'refresh');
        }

    }

    /**
     * @param $method_name
     * Check if user has permission
     */
    function has_allowed_perm($method_name)
    {
        if (!perms_role($this->controller, $method_name)) {
            show_error("You are not allowed to view this page", 401, "Unauthorized");
        }
    }


    /**
     * List of all registered users
     *
     * @load view
     */
    function users_list()
    {
        $this->data['title'] = "Users List";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if ($this->input->post("search")) {
            $first_name = $this->input->post("firstname", null);
            $last_name = $this->input->post("lastname", null);
            $phone = $this->input->post("phone", null);
            $user_status = $this->input->post("status", null);

            $this->data['user_list'] = $this->User_model->search_users($first_name, $last_name, $phone, $user_status);
            foreach ($this->data['user_list'] as $k => $user) {
                $this->data['user_list'][$k]->groups = $this->ion_auth->get_users_groups($user->user_id)->result();

                //facility
                $this->model->set_table('health_facilities');
                $this->data['user_list'][$k]->facility = $this->model->get_by('id', $user->facility);
            }

        } else {

            $config = array(
                'base_url'    => $this->config->base_url("auth/users_list"),
                'total_rows'  => $this->User_model->count_users(),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->data['user_list'] = $this->User_model->get_users_list($this->pagination->per_page, $page);
            foreach ($this->data['user_list'] as $k => $user) {
                $this->data['user_list'][$k]->groups = $this->ion_auth->get_users_groups($user->user_id)->result();

                //facility
                $this->model->set_table('health_facilities');
                $this->data['user_list'][$k]->facilities = $this->model->get_by('id', $user->facility);
            }
            $this->data["links"] = $this->pagination->create_links();
        }

        //render view
        $this->load->view('header', $this->data);
        $this->_render_page('index');
        $this->load->view('footer');
    }

    function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }

    /**
     * Logged user profile
     *
     * @load view
     */
    function profile()
    {
        $User = $this->User_model->find_by_id($this->user_id);
        $this->data['fname'] = $User->first_name . ' ' . $User->last_name;
        $this->data['username'] = $User->username;
        $this->data['status'] = $User->active;
        $this->data['phone'] = $User->phone;
        $this->data['email'] = $User->email;
        $date_string = "%d-%m-%Y  %h:%i %a";
        $this->data['created'] = mdate($date_string, $User->created_on);
        $this->data['last_login'] = mdate($date_string, $User->last_login);

        $this->data['title'] = 'My profile';
        $this->load->view('header', $this->data);
        $this->load->view('profile/user_info');
        $this->load->view('footer');
    }

    // log the user out
    function login()
    {
        if ($this->ion_auth->logged_in()) {
            redirect('dashboard', 'refresh');
        }

        $this->data['title'] = "Login";

        //validate form input
        $this->form_validation->set_rules('identity', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('auth/index', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name'        => 'identity',
                                            'id'          => 'identity',
                                            'type'        => 'text',
                                            'value'       => $this->form_validation->set_value('identity'),
                                            'class'       => 'form-control',
                                            'placeholder' => 'Enter username'
            );
            $this->data['password'] = array('name'        => 'password',
                                            'id'          => 'password',
                                            'type'        => 'password',
                                            'class'       => 'form-control',
                                            'placeholder' => 'Enter password'
            );

            //render view
            $this->load->view('header', $this->data);
            $this->_render_page('auth/login');
            $this->load->view('footer');
        }
    }

    // change password
    function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == FALSE) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name'        => 'old',
                'id'          => 'old',
                'type'        => 'password',
                'class'       => 'form-control',
                'placeholder' => 'Enter old password'
            );
            $this->data['new_password'] = array(
                'name'        => 'new',
                'id'          => 'new',
                'type'        => 'password',
                'pattern'     => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class'       => 'form-control',
                'placeholder' => 'Enter new password'
            );
            $this->data['new_password_confirm'] = array(
                'name'        => 'new_confirm',
                'id'          => 'new_confirm',
                'type'        => 'password',
                'pattern'     => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class'       => 'form-control',
                'placeholder' => 'Confirm new password'
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );

            // render
            $this->data['title'] = "Change Password";
            $this->load->view('header', $this->data);
            $this->_render_page('profile/change_password');
            $this->load->view('footer');
            //$this->_render_page('auth/change_password', $this->data);
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {

                //New password
                $new_pass = $this->input->post('new');

                //server realm and unique id
                $realm = 'Authorized users of Sacids Openrosa';

                $digest_pass = md5("{$identity}:{$realm}:{$new_pass}");

                //array data
                $digest_data = array('digest_password' => $digest_pass);

                //update digest password
                $this->db->update('users', $digest_data, array('username' => $identity));

                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    // forgot password

    function logout()
    {
        $this->data['title'] = "Logout";
        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }

    // reset password - final step for forgotten password

    function forgot_password()
    {
        // setting validation rules by checking weather identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == FALSE) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = array('name' => 'identity',
                                            'id'   => 'identity',
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth/forgot_password', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }


    // activate the user

    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == FALSE) {
                // display the form

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name'    => 'new',
                    'id'      => 'new',
                    'type'    => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name'    => 'new_confirm',
                    'id'      => 'new_confirm',
                    'type'    => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name'  => 'user_id',
                    'id'    => 'user_id',
                    'type'  => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth/reset_password', $this->data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        //New password
                        $new_pass = $this->input->post('new');

                        //server realm and unique id
                        $realm = 'Authorized users of Sacids Openrosa';

                        $digest_pass = md5("{$identity}:{$realm}:{$new_pass}");

                        //array data
                        $digest_data = array('digest_password' => $digest_pass);

                        //update digest password
                        $this->db->update('users', $digest_data, array('username' => $identity));

                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // deactivate the user

    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    // create a new user

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // edit a user

    function activate($id, $code = FALSE)
    {

        if ($code !== FALSE) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth/users_list", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //group lists

    function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int)$id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->data['title'] = "Deactivate user";
            $this->load->view('header', $this->data);
            $this->_render_page('auth/deactivate_user');
            $this->load->view('footer');

        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect('auth/users_list', 'refresh');
        }
    }

    //sign up
    function sign_up()
    {
        $this->data['title'] = "Create account";

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'required');

//        if ($identity_column !== 'email') {
//            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required');
//            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
//        } else {
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|numeric|min_length[9]|max_length[13] ');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == TRUE) {
            $email = strtolower($this->input->post('email'));
            $identity = $this->input->post('email');
            $password = $this->input->post('password');
            $groups = array($this->input->post('group'));

            //digest password
            $digest_password = md5("{$identity}:{$this->realm}:{$password}");

            $additional_data = array(
                'first_name'      => $this->input->post('first_name'),
                'last_name'       => $this->input->post('last_name'),
                'phone'           => $this->input->post('phone'),
                'company'         => $this->input->post('organization'),
                'digest_password' => $digest_password
            );
        }
        if ($this->form_validation->run() == TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data, $groups)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', display_message($this->ion_auth->messages()));
            redirect("auth/sign_up", 'refresh');
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'        => 'first_name',
                'id'          => 'first_name',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('first_name'),
                'class'       => 'form-control',
                'placeholder' => 'First name e.g Eric'
            );
            $this->data['last_name'] = array(
                'name'        => 'last_name',
                'id'          => 'last_name',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('last_name'),
                'class'       => 'form-control',
                'placeholder' => 'Last name e.g Beda'
            );

            $this->data['organization'] = array(
                'name'        => 'organization',
                'id'          => 'organization',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('organization'),
                'class'       => 'form-control',
                'placeholder' => 'Organization e.g SACIDS Tanzania'
            );

            $this->data['phone'] = array(
                'name'        => 'phone',
                'id'          => 'phone',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('phone'),
                'class'       => 'form-control',
                'placeholder' => 'Phone number e.g 255717705746'
            );

            $this->data['email'] = array(
                'name'        => 'email',
                'id'          => 'email',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('email'),
                'class'       => 'form-control',
                'placeholder' => 'Email e.g afyadata@sacids.org'
            );

            $this->data['password'] = array(
                'name'        => 'password',
                'id'          => 'password',
                'type'        => 'password',
                'value'       => $this->form_validation->set_value('password'),
                'class'       => 'form-control',
                'placeholder' => 'Password {at lease 8 character}'
            );
            $this->data['password_confirm'] = array(
                'name'        => 'password_confirm',
                'id'          => 'password_confirm',
                'type'        => 'password',
                'value'       => $this->form_validation->set_value('password_confirm'),
                'class'       => 'form-control',
                'placeholder' => 'Confirm password'
            );

            //render view
            $this->load->view('header', $this->data);
            $this->_render_page('auth/sign_up');
            $this->load->view('footer');
        }
    }

    //create new user
    function create_user()
    {
        $this->data['title'] = "Create User";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');

        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|numeric|min_length[9]|max_length[13] ');

        //$this->form_validation->set_rules('district', 'District', 'required');
        //$this->form_validation->set_rules('facility', 'Health Facility', 'required');

        $this->form_validation->set_rules('group', $this->lang->line('create_user_group_label'), 'required');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == TRUE) {
            $email = strtolower($this->input->post('email'));
            $identity = $this->input->post('identity');
            $password = $this->input->post('password');
            $groups = array($this->input->post('group'));

            //digest password
            $digest_password = md5("{$identity}:{$this->realm}:{$password}");

            $additional_data = array(
                'first_name'      => $this->input->post('first_name'),
                'last_name'       => $this->input->post('last_name'),
                'phone'           => $this->input->post('phone'),
                'digest_password' => $digest_password,
                //'district' => $this->input->post('district'),
                //'facility' => $this->input->post('facility')
            );
        }
        if ($this->form_validation->run() == TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data, $groups)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', display_message($this->ion_auth->messages()));
            redirect("auth/create_user", 'refresh');
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            //populate data
            $this->data['first_name'] = array(
                'name'        => 'first_name',
                'id'          => 'first_name',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('first_name'),
                'class'       => 'form-control',
                'placeholder' => 'Enter first name'
            );
            $this->data['last_name'] = array(
                'name'        => 'last_name',
                'id'          => 'last_name',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('last_name'),
                'class'       => 'form-control',
                'placeholder' => 'Enter last name'
            );
            $this->data['identity'] = array(
                'name'        => 'identity',
                'id'          => 'identity',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('identity'),
                'class'       => 'form-control',
                'placeholder' => 'Enter username'
            );
            $this->data['email'] = array(
                'name'        => 'email',
                'id'          => 'email',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('email'),
                'class'       => 'form-control',
                'placeholder' => 'Enter email address'
            );
            $this->data['group_id'] = array(
                'name'  => 'group_id',
                'id'    => 'group_id',
                'type'  => 'select',
                'value' => $this->form_validation->set_value('group_id'),
                'class' => 'form-control'
            );
            $this->data['level_id'] = array(
                'name'  => 'level_id',
                'id'    => 'level_id',
                'type'  => 'select',
                'value' => $this->form_validation->set_value('level_id'),
                'class' => 'form-control'
            );
            $this->data['user_level'] = array(
                'name'  => 'user_level',
                'id'    => 'user_level',
                'type'  => 'select',
                'value' => $this->form_validation->set_value('user_level'),
                'class' => 'form-control'
            );
            $this->data['phone'] = array(
                'name'        => 'phone',
                'id'          => 'phone',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('phone'),
                'class'       => 'form-control',
                'placeholder' => 'Enter phone'
            );
            $this->data['password'] = array(
                'name'        => 'password',
                'id'          => 'password',
                'type'        => 'password',
                'value'       => $this->form_validation->set_value('password'),
                'class'       => 'form-control',
                'placeholder' => 'Enter password'
            );
            $this->data['password_confirm'] = array(
                'name'        => 'password_confirm',
                'id'          => 'password_confirm',
                'type'        => 'password',
                'value'       => $this->form_validation->set_value('password_confirm'),
                'class'       => 'form-control',
                'placeholder' => 'Confirm password'
            );

            $this->data['district_list'] = $this->db->order_by('name', 'asc')->get('district')->result();
            $this->data['group_list'] = $this->db->order_by('name', 'asc')->get('groups')->result();

            //render view
            $this->data['title'] = "Create New User";
            $this->load->view('header', $this->data);
            $this->_render_page('auth/create_user');
            $this->load->view('footer');
        }
    }

    /**
     * edit user details
     * @param $id
     */
    function edit_user($id)
    {
        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|numeric|min_length[9]|max_length[13] ');
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required|valid_email');

        //$this->form_validation->set_rules('district', 'District', 'required');
        //$this->form_validation->set_rules('facility', 'Health Facility', 'required');

        if (isset($_POST) && !empty($_POST)) {
//            // do we have a valid request?
//            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
//                show_error($this->lang->line('error_csrf'));
//            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $identity = $this->input->post('identity');

                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'username' => $this->input->post('identity'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    //'district' => $this->input->post('district'),
                    //'facility' => $this->input->post('facility')
                );

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $password = $this->input->post('password');
                    $data['password'] = $password;

                    //digest password
                    $data['digest_password'] = md5("{$identity}:{$this->realm}:{$password}");
                }


                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }

                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', display_message("User Saved"));
                    redirect('auth/edit_user/' . $id, 'refresh');

                }

            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        //populate data
        $this->data['first_name'] = array(
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
            'class' => 'form-control'
        );
        $this->data['last_name'] = array(
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
            'class' => 'form-control'
        );

        $this->data['identity'] = array(
            'name'  => 'identity',
            'id'    => 'identity',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('identity', $user->username),
            'class' => 'form-control',
        );
        $this->data['email'] = array(
            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('email', $user->email),
            'class' => 'form-control',
        );

        $this->data['level_id'] = array(
            'name'  => 'level_id',
            'id'    => 'level_id',
            'type'  => 'select',
            'value' => $this->form_validation->set_value('level_id'),
            'class' => 'form-control'
        );
        $this->data['user_level'] = array(
            'name'  => 'user_level',
            'id'    => 'user_level',
            'type'  => 'select',
            'value' => $this->form_validation->set_value('user_level'),
            'class' => 'form-control'
        );

        $this->data['phone'] = array(
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
            'class' => 'form-control'
        );
        $this->data['password'] = array(
            'name'  => 'password',
            'id'    => 'password',
            'type'  => 'password',
            'class' => 'form-control'
        );
        $this->data['password_confirm'] = array(
            'name'  => 'password_confirm',
            'id'    => 'password_confirm',
            'type'  => 'password',
            'class' => 'form-control'
        );

        $this->data['district_list'] = $this->db->order_by('name', 'asc')->get('district')->result();

        $this->model->set_table('health_facilities');
        $this->data['facilities_list'] = $this->model->get_many_by('district', $user->district);

        //render view
        $this->load->view('header', $this->data);
        $this->_render_page('auth/edit_user');
        $this->load->view('footer');
    }

    /**
     * @param $district_id
     */
    function get_facilities($district_id)
    {
        $this->model->set_table('health_facilities');
        $facilities_list = $this->model->get_many_by('district', $district_id);

        //print_r($facilities_list);

        if ($facilities_list) {
            foreach ($facilities_list as $value) {
                echo '<option value="' . $value->id . '" ' . set_value("facility", $value->id) . '>' . $value->name . '</option>';
            }
        } else {
            echo '<option value="">Choose Facility</option>';
        }
    }


    //assign privilege to group
    function group_list()
    {
        //check login
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $data['title'] = 'Manage Groups';
        $data['groups'] = $this->db->get('groups')->result();
        $this->load->view('header', $data);
        $this->load->view('auth/group_list');
        $this->load->view('footer');
    }

    function create_group()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/create_group", 'refresh');
            }
        } else {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name'        => 'group_name',
                'id'          => 'group_name',
                'type'        => 'text',
                'value'       => $this->form_validation->set_value('group_name'),
                'class'       => 'form-control',
                'placeholder' => 'Enter group name'
            );
            $this->data['description'] = array(
                'name'        => 'description',
                'id'          => 'description',
                'type'        => 'text area',
                'rows'        => '5',
                'value'       => $this->form_validation->set_value('description'),
                'class'       => 'form-control',
                'placeholder' => 'Enter group description'
            );

            //render view
            $this->load->view('header', $this->data);
            $this->_render_page('auth/create_group');
            $this->load->view('footer');
        }
    }

    function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth/login', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth/edit_group/" . $id, 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name'    => 'group_name',
            'id'      => 'group_name',
            'type'    => 'text',
            'value'   => $this->form_validation->set_value('group_name', $group->name),
            'class'   => 'form-control',
            $readonly => $readonly,
        );
        $this->data['description'] = array(
            'name'  => 'description',
            'id'    => 'description',
            'type'  => 'text area',
            'rows'  => '5',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('description', $group->description),
        );

        //Load View
        $this->load->view('header', $this->data);
        $this->_render_page('auth/edit_group');
        $this->load->view('footer');
    }

    function perms_group($group_id)
    {
        $this->data['title'] = 'Assign Permission';

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        //Group Name
        $groups = $this->db->get_where('groups', array('id' => $group_id))->row();
        $this->data['group_name'] = $groups->name;
        $this->data['group_id'] = $group_id;

        $this->data['perm_list'] = $perm_list = $this->User_model->get_perms_list($group_id);

        //check if user save
        if ($this->input->post('save')) {
            $perms = $this->User_model->get_perms_list($group_id);

            foreach ($perms[1] as $key => $value) {

                foreach ($value as $k => $v):

                    if ($this->input->post('module_' . $v[0] . '_' . $v[1])) {

                        $check = $this->db->get_where('perms_group',
                            array('group_id' => $group_id, 'module_id' => $v[0], 'perm_slug' => $k))->row();

                        if (count($check) == 1) {
                            $this->db->update('perms_group',
                                array('allow' => $this->input->post('module_' . $v[0] . '_' . $v[1])),
                                array('group_id' => $group_id, 'module_id' => $v[0], 'perm_slug' => $k));
                        } else {
                            $this->db->insert('perms_group', array('group_id' => $group_id, 'module_id' => $v[0], 'perm_slug' => $k, 'allow' => 1));
                        }
                    } else {
                        $this->db->update('perms_group', array('allow' => 0), array('group_id' => $group_id, 'module_id' => $v[0], 'perm_slug' => $k));
                    }
                endforeach;
            }
            $this->session->set_flashdata('message', display_message('Permission successfully configured'));
            redirect('auth/perms_group/' . $group_id, 'refresh');
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view('auth/perms_group');
        $this->load->view('footer');
    }

    //module list
    function module_list()
    {
        $this->data['title'] = 'Module List';

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $config = array(
            'base_url'    => $this->config->base_url("auth/module_list"),
            'total_rows'  => $this->User_model->count_module(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['module'] = $this->User_model->find_all_module($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        //render data
        $this->load->view('header', $this->data);
        $this->load->view("auth/module_list");
        $this->load->view('footer');
    }

    //add new module
    function add_module()
    {
        $this->data['title'] = "Add Module";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('name', 'Module', 'required');
        $this->form_validation->set_rules('controller', 'Controller', 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name'       => $this->input->post('name'),
                'controller' => $this->input->post('controller')
            );
            $this->db->insert('perms_module', $data);

            //message and redirect
            $this->session->set_flashdata("message", display_message("Module added successfully"));
            redirect('auth/add_module', 'refresh');
        }

        //populate data
        $this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('name'),
        );

        $this->data['controller'] = array(
            'name'  => 'controller',
            'id'    => 'controller',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('controller'),
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("auth/add_new_module");
        $this->load->view('footer');
    }

    //add module
    function edit_module($module_id)
    {
        $this->data['title'] = "Edit Module";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $this->data['module'] = $this->User_model->get_module_by_id($module_id);

        //validate form input
        $this->form_validation->set_rules('name', 'Module', 'required');
        $this->form_validation->set_rules('controller', 'Controller', 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name'       => $this->input->post('name'),
                'controller' => $this->input->post('controller')
            );
            $this->db->update('perms_module', $data, array('id' => $module_id));

            $this->session->set_flashdata("message", display_message("Module edited successfully"));
            redirect('auth/edit_module/' . $module_id, 'refresh');
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("auth/edit_module");
        $this->load->view('footer');
    }


    //permission list
    function permission_list()
    {
        $this->data['title'] = 'Permission List';

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $config = array(
            'base_url'    => $this->config->base_url("auth/permission_list/"),
            'total_rows'  => $this->User_model->count_perms(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['perms'] = $this->User_model->find_all_perms($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        //render data
        $this->load->view('header', $this->data);
        $this->load->view("auth/perms_list");
        $this->load->view('footer');
    }

    //add new perms
    function add_perm()
    {
        $this->data['title'] = "Add Perm";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('name', 'Perm name', 'required');
        $this->form_validation->set_rules('perm_slug', 'Perm slug', 'required');
        $this->form_validation->set_rules('module', 'Module', 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name'      => $this->input->post('name'),
                'perm_slug' => $this->input->post('perm_slug'),
                'module_id' => $this->input->post('module')
            );
            $this->db->insert('perms', $data);

            //message and redirect
            $this->session->set_flashdata("message", display_message("Perms added successfully"));
            redirect('auth/add_perm', 'refresh');
        }

        //populate data
        $this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('name'),
        );

        $this->data['perm_slug'] = array(
            'name'  => 'perm_slug',
            'id'    => 'perm_slug',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('perm_slug'),
        );

        $this->data['module'] = $this->User_model->find_all_module(30, 0);
        //render view
        $this->load->view('header', $this->data);
        $this->load->view("auth/add_perm");
        $this->load->view('footer');
    }

    //edit perm
    function edit_perm($perm_id)
    {
        $this->data['title'] = "Edit Perm";

        //check login
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $this->data['perm'] = $perm = $this->User_model->get_perm_by_id($perm_id);

        $this->data['module_name'] = $this->User_model->get_module_by_id($perm->module_id)->name;

        //validate form input
        $this->form_validation->set_rules('name', 'Perm name', 'required');
        $this->form_validation->set_rules('perm_slug', 'Perm slug', 'required');
        $this->form_validation->set_rules('module', 'Module', 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name'      => $this->input->post('name'),
                'perm_slug' => $this->input->post('perm_slug'),
                'module_id' => $this->input->post('module')
            );
            $this->db->update('perms', $data, array('id' => $perm_id));

            $this->session->set_flashdata("message", display_message("Perm edited successfully"));
            redirect('auth/edit_perm/' . $perm_id, 'refresh');
        }

        $this->data['module'] = $this->User_model->find_all_module(30, 0);
        //render view
        $this->load->view('header', $this->data);
        $this->load->view("auth/edit_perm");
        $this->load->view('footer');
    }

}