<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
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
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 10:31
 */
class Post extends MX_Controller
{
    private $data;
    private $list_id;
    private $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('upload', 'mailchimp'));

        $this->form_validation->CI =& $this;
        $this->list_id = '';
        $this->user_id = $this->session->userdata("user_id");

        //$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->load->model("Post_model");
    }

    //check user login
    function _is_logged_in()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }

    public function index()
    {
        $this->posts();
    }

    //posts list
    public function posts()
    {
        $this->data['title'] = "Newsletter Posts";
        $this->data['posts'] = $this->Post_model->find_all();

        foreach ($this->data['posts'] as $k => $v) {
            $this->data['posts'][$k]->user = $this->User_model->find_by_id($v->user_id);
        }

        //render view
        $this->load->view("layout/header", $this->data);
        $this->load->view("posts_view");
        $this->load->view("layout/footer");
    }

    //newsletter post details
    public function post_details($post_id)
    {
        if (!$post_id)
            redirect("blog/post/");

        $this->data['title'] = "Afyadata Blog";

        //newsletter post
        $post = $this->Post_model->find_by_id($post_id);
        $this->data['post'] = $post;

        if ($post)
            $this->data['user'] = $this->User_model->find_by_id($post->user_id);

        //recent post
        $this->data['recent_posts'] = $this->Post_model->find_all(5);

        //render view
        $this->load->view("layout/header", $this->data);
        $this->load->view("single_post_view");
        $this->load->view("layout/footer");
    }

    //posts list
    function lists()
    {
        $this->data['title'] = "Newsletter Posts";
        $this->data['posts'] = $this->Post_model->find_all();

        foreach ($this->data['posts'] as $k => $v) {
            $this->data['posts'][$k]->user = $this->User_model->find_by_id($v->user_id);
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("posts_list");
        $this->load->view('footer');
    }

    //add new post
    public function add_new()
    {
        $this->data['title'] = "Add new post";

        $this->_is_logged_in();

        $this->form_validation->set_rules("name", "Title", "required|trim");
        $this->form_validation->set_rules("attachment", "Image", "callback_upload_attachment|trim");
        $this->form_validation->set_rules("content", "Content", "required|trim");
        $this->form_validation->set_rules("status", "Status", "trim");

        if ($this->form_validation->run() == TRUE) {
            $post_details = array(
                "user_id" => $this->user_id,
                "title" => $this->input->post("name"),
                "image" => $_POST['attachment'],
                "alias" => str_replace(array(" ", "&", "."), "-", $this->input->post("title")),
                "content" => $this->input->post("content"),
                "status" => $this->input->post("status"),
                "date_created" => date("c")
            );

            if ($post_id = $this->Post_model->create($post_details)) {
                $this->session->set_flashdata("message", display_message("Posted was created"));
                redirect("blog/post/edit_post/" . $post_id, "refresh");
            } else {
                $this->session->set_flashdata("message", display_message("An error occurred"), "danger");
            }
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'form-control',
            'placeholder' => 'Write post title ...'
        );

        $this->data['attachment'] = array(
            'name' => 'attachment',
            'id' => 'attachment',
            'type' => 'file',
            'value' => $this->form_validation->set_value('attachment'),
            'class' => 'form-control'
        );

        $this->data['content'] = array(
            'name' => 'content',
            'id' => 'content',
            'type' => 'text area',
            'value' => $this->form_validation->set_value('content'),
            'class' => 'form-control',
            'placeholder' => 'Write newsletter content here...'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("new_post");
        $this->load->view('footer');
    }

    public function edit($post_id)
    {
        if (!$post_id)
            redirect("blog/post/lists");

        $this->data['title'] = "Afyadata Blog";

        $this->_is_logged_in();

        $post = $this->Post_model->find_by_id($post_id);
        $this->data['post'] = $post;

        //form validation
        $this->form_validation->set_rules("title", "Title", "required");
        $this->form_validation->set_rules("content", "Content", "");
        $this->form_validation->set_rules("status", "Status", "");

        if ($this->form_validation->run() == TRUE) {

            $post_details = array(
                "user_id" => $this->session->userdata("user_id"),
                "title" => $this->input->post("title"),
                "alias" => str_replace(array(" ", "&", "."), "-", $this->input->post("title")),
                "content" => $this->input->post("content"),
                "status" => $this->input->post("status"),
                "date_modified" => date("c")
            );

            if ($this->Post_model->update($post_id, $post_details)) {
                $this->session->set_flashdata("message", display_message("Posted was updated"));
            } else {
                $this->session->set_flashdata("message", display_message("Failed to update post"), "danger");
            }
            redirect("blog/post/edit/" . $post_id, "refresh");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $post->title),
            'class' => 'form-control',
            'placeholder' => 'Write post title ...'
        );

        $this->data['content'] = array(
            'name' => 'content',
            'id' => 'content',
            'type' => 'text area',
            'value' => $this->form_validation->set_value('content', $post->content),
            'class' => 'form-control',
            'placeholder' => 'Write newsletter content here...'
        );

        //render view
        $this->load->view("header", $this->data);
        $this->load->view("edit_post");
        $this->load->view("footer");
    }

    function subscribe()
    {
        //create campaign
        $campaign = $this->mailchimp->post('/campaigns', [
            'type' => 'regular',
            'recipients' => ['list_id' => $this->list_id],
            'settings' => [
                'subject_line' => 'Newsletter Edition 12',
                'preview_text' => 'Just a testing case',
                'title' => 'Newsletter Edition 12',
                'reply_to' => 'renfridfrancis@gmail.com',
                'from_name' => 'AfyaData',
            ]
        ]);

        $result = array();
        if ($campaign) {
            //insert campaign content
            $create = $this->mailchimp->put('campaigns/' . $campaign['id'] . '/content',
                [
                    'html' => '<p>The HTML to use for the saved campaign</p>'
                ]);

            // Send campaign
            $result = $this->mailchimp->post('campaigns/' . $campaign['id'] . '/actions/send');
        }

        echo '<pre>';
        print_r($result);
    }


    /*============================================================
    CALLBACK FUNCTIONS
    =============================================================*/
    //function to upload attachment
    function upload_attachment()
    {
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '20000';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;

        //initialize config
        $this->load->library(array('upload'));
        $this->upload->initialize($config);

        if (isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'])) {
            if ($this->upload->do_upload('attachment')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();

                //POST variables
                $_POST['attachment'] = $upload_data['file_name'];

                //Image Resizing
                $resize_conf['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $resize_conf['new_image'] = $this->upload->upload_path . 'thumb_' . $this->upload->file_name;
                $resize_conf['maintain_ratio'] = FALSE;
                $resize_conf['width'] = 400;
                $resize_conf['height'] = 300;

                // initializing image_lib
                $this->image_lib->initialize($resize_conf);
                $this->image_lib->resize();

                return TRUE;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('upload_attachment', $this->upload->display_errors());
                return FALSE;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('upload_attachment', "Please, attach media image");
            return FALSE;
        }
    }
}