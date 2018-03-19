<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 14/03/2018
 * Time: 13:28
 */

class Newsletters extends MX_Controller
{
    private $data;
    private $list_id;
    private $reply_to;
    private $from_name;

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('MailChimp'));

        $this->list_id = '5a798801f2';
        $this->reply_to = 'afyadata@sacids.org';
        $this->from_name = 'TechnoSurveillance Newsletter';

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    //newsletter stories
    function lists()
    {
        $this->data['title'] = 'Newsletter Stories';

        //pagination
        $config = array(
            'base_url' => $this->config->base_url("newsletters/lists"),
            'total_rows' => $this->Newsletter_model->count_newsletter_stories(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['stories_list'] = $this->Newsletter_model->get_newsletter_stories_list($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        foreach ($this->data['stories_list'] as $k => $v) {
            $this->data['stories_list'][$k]->edition = $this->Newsletter_model->get_newsletter_edition_by_id($v->edition_id);
        }

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("lists");
        $this->load->view('footer');
    }

    //add new story
    function add_new()
    {

        $this->data['title'] = 'Add Newsletter Story';
        $this->data['edition_list'] = $this->Newsletter_model->find_all_edition();

        //form validation
        $this->form_validation->set_rules("name", "Title", "required|trim");
        $this->form_validation->set_rules("edition_id", "Edition", "required|trim");
        $this->form_validation->set_rules("attachment", "Media", "callback_upload_attachment|trim");
        $this->form_validation->set_rules("story_content", "Story Content", "required|trim");
        $this->form_validation->set_rules("status", "Status", "trim");

        if ($this->form_validation->run($this) === TRUE) {
            $data = array(
                "title" => $this->input->post("name"),
                "edition_id" => $this->input->post("edition_id"),
                "alias" => strtolower(str_replace(array(" ", "&", "."), "-", $this->input->post("name"))),
                "media" => $_POST['attachment'],
                "story" => $this->input->post("story_content"),
                "status" => $this->input->post("status"),
                "date_created" => date("c"),
                "created_by" => get_current_user_id()
            );

            if ($this->Newsletter_model->create_newsletter_story($data))
                $this->session->set_flashdata("message", display_message("Newsletter story added"));
            else
                $this->session->set_flashdata("message", display_message("Failed to add story", 'danger'));

            redirect("newsletters/lists", "refresh");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'form-control',
            'placeholder' => 'Write story title ...'
        );

        $this->data['attachment'] = array(
            'name' => 'attachment',
            'id' => 'attachment',
            'type' => 'file',
            'value' => $this->form_validation->set_value('attachment'),
            'class' => 'form-control'
        );

        $this->data['story_content'] = array(
            'name' => 'story_content',
            'id' => 'story_content',
            'type' => 'text area',
            'rows' => 5,
            'value' => $this->form_validation->set_value('story_content'),
            'class' => 'form-control',
            'placeholder' => 'Write story content ...'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("add_new");
        $this->load->view('footer');
    }

    //edit story
    function edit($id)
    {
        $this->data['title'] = 'Add Newsletter Story';
        $this->data['edition_list'] = $this->Newsletter_model->find_all_edition();

        $story = $this->Newsletter_model->get_newsletter_story_by_id($id);
        if (count($story) == 0) {
            show_error('Story does not exist');
        }
        $this->data['story'] = $story;

        //form validation
        $this->form_validation->set_rules("name", "Title", "required|trim");
        $this->form_validation->set_rules("edition_id", "Edition", "required|trim");
        $this->form_validation->set_rules("story_content", "Story Content", "required|trim");
        $this->form_validation->set_rules("status", "Status", "trim");

        if ($this->form_validation->run($this) === TRUE) {
            $data = array(
                "title" => $this->input->post("name"),
                "edition_id" => $this->input->post("edition_id"),
                "alias" => strtolower(str_replace(array(" ", "&", "."), "-", $this->input->post("name"))),
                "story" => $this->input->post("story_content"),
                "status" => $this->input->post("status")
            );

            if ($this->Newsletter_model->update_newsletter_story($data, $id))
                $this->session->set_flashdata("message", display_message("Newsletter story updated"));
            else
                $this->session->set_flashdata("message", display_message("Failed to update story", 'danger'));

            redirect("newsletters/lists", "refresh");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $story->title),
            'class' => 'form-control',
            'placeholder' => 'Write story title ...'
        );

        $this->data['story_content'] = array(
            'name' => 'story_content',
            'id' => 'story_content',
            'type' => 'text area',
            'rows' => 5,
            'value' => $this->form_validation->set_value('story_content', $story->story),
            'class' => 'form-control',
            'placeholder' => 'Write story content ...'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("edit");
        $this->load->view('footer');
    }

    //delete story
    function delete($id)
    {
        $this->data['title'] = 'Delete Newsletter Story';

        $story = $this->Newsletter_model->get_newsletter_story_by_id($id);
        if (count($story) == 0) {
            show_error('Story does not exist');
        }

        if ($this->Newsletter_model->delete_newsletter_story($id))
            $this->session->set_flashdata("message", display_message("Newsletter story deleted", 'danger'));
        else
            $this->session->set_flashdata("message", display_message("Failed to delete story", 'danger'));

        redirect("newsletters/lists", "refresh");
    }

    //edition lists
    function edition_lists()
    {
        $this->data['title'] = 'Newsletter Edition';

        //pagination
        $config = array(
            'base_url' => $this->config->base_url("newsletters/edition_lists"),
            'total_rows' => $this->Newsletter_model->count_newsletter_edition(),
            'uri_segment' => 3,
        );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['edition_list'] = $this->Newsletter_model->get_newsletter_edition_list($this->pagination->per_page, $page);
        $this->data["links"] = $this->pagination->create_links();

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("edition_lists");
        $this->load->view('footer');
    }

    //add new edition
    function add_new_edition()
    {
        $this->data['title'] = 'Add Newsletter Edition';

        //form validation
        $this->form_validation->set_rules("name", 'Title', "required|trim");

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "title" => $this->input->post("name"),
                "date_created" => date("Y-m-d H:i:s"),
                "created_by" => get_current_user_id(),
            );

            if ($this->Newsletter_model->create_newsletter_edition($data))
                $this->session->set_flashdata("message", display_message("Newsletter edition added"));
            else
                $this->session->set_flashdata("message", display_message("Failed to add edition", 'danger'));

            redirect("newsletters/edition_lists", "refresh");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
            'class' => 'form-control',
            'placeholder' => 'Write edition title ...'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("add_new_edition");
        $this->load->view('footer');
    }

    //edit edition
    function edit_edition($id)
    {
        $this->data['title'] = 'Edit Newsletter Edition';

        $newsletter = $this->Newsletter_model->get_newsletter_edition_by_id($id);

        if (count($newsletter) == 0) {
            show_error("Newsletter does not exist");
        }
        $this->data['newsletter'] = $newsletter;

        //form validation
        $this->form_validation->set_rules("name", 'Title', "required|trim");

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "title" => $this->input->post("name")
            );

            if ($this->Newsletter_model->update_newsletter_edition($data, $id))
                $this->session->set_flashdata("message", display_message("Newsletter edition updated"));
            else
                $this->session->set_flashdata("message", display_message("Failed to update edition", 'danger'));

            redirect("newsletters/edition_lists", "refresh");
        }

        //populate data
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name', $newsletter->title),
            'class' => 'form-control',
            'placeholder' => 'Write edition title ...'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("edit_edition");
        $this->load->view('footer');
    }

    //delete edition
    function delete_edition($id)
    {
        $this->data['title'] = 'Delete Newsletter Edition';

        $newsletter = $this->Newsletter_model->get_newsletter_edition_by_id($id);
        if (count($newsletter) == 0) {
            show_error("Newsletter does not exist");
        }

        if ($this->Newsletter_model->delete_newsletter_edition($id)) {
            //delete all stories
            $this->Newsletter_model->delete_newsletter_stories_by_edition($id);

            $this->session->set_flashdata("message", display_message("Newsletter edition deleted", 'danger'));
        } else {
            $this->session->set_flashdata("message", display_message("Failed to delete edition", 'danger'));
        }

        redirect("newsletters/edition_lists", "refresh");
    }


    //send newsletter
    function send_newsletter()
    {
        $this->data['title'] = "Send Newsletter";
        $this->data['edition_list'] = $this->Newsletter_model->find_all_edition();

        //form validation
        $this->form_validation->set_rules("edition", "Edition", "required|trim");
        $this->form_validation->set_rules("message", "Message", "required|trim");

        //validation success
        if ($this->form_validation->run() == TRUE) {
            $edition_id = $this->input->post('edition_id');
            $message = $this->input->post('message');

            //edition
            $edition = $this->Newsletter_model->get_newsletter_edition_by_id($edition_id);

            if ($edition) {
                $subject = $edition->title;
                $message = $message . '<p>Click ' . anchor('newsletters/stories/emails/' . $edition->id, 'here') . ' to read stories</p>';

                $this->action_send($subject, $message);

                $this->session->set_flashdata("message", display_message("Newsletter sent"));
            } else {
                $this->session->set_flashdata("message", display_message("Newsletter not sent"));
            }

            redirect("newsletters/send_newsletter", "refresh");
        }

        //populate data
        $this->data['message'] = array(
            'name' => 'message',
            'id' => 'message',
            'type' => 'text area',
            'rows' => 5,
            'value' => $this->form_validation->set_value('message'),
            'class' => 'form-control',
            'placeholder' => 'Write message here...'
        );

        //render view
        $this->load->view('header', $this->data);
        $this->load->view("send_newsletter");
        $this->load->view('footer');
    }

    //action to send campaign to mailChimp
    function action_send($subject, $message)
    {
        //create campaign
        $campaign = $this->MailChimp->post('/campaigns', [
            'type' => 'regular',
            'recipients' => ['list_id' => $this->list_id],
            'settings' => [
                'subject_line' => $subject,
                'title' => $subject,
                'reply_to' => $this->reply_to,
                'from_name' => $this->from_name
            ]
        ]);

        $result = array();

        if ($campaign) {
            //insert campaign content
            $this->MailChimp->put('campaigns/' . $campaign['id'] . '/content',
                [
                    'html' => $message
                ]);

            // Send campaign
            $result = $this->MailChimp->post('campaigns/' . $campaign['id'] . '/actions/send');
        }
    }


    /*============================================================
   CALLBACK FUNCTIONS
   =============================================================*/
    //function to upload attachment
    function upload_attachment()
    {
        $config['upload_path'] = './assets/uploads/media';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '100000';
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
                $resize_conf['width'] = 800;
                $resize_conf['height'] = 340;

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
            $this->form_validation->set_message('upload_attachment', "Please, include media attachment");
            return FALSE;
        }
}

}