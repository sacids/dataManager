<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 17/03/2018
 * Time: 15:47
 */

class Stories extends MX_Controller
{
    private $data;

    function __construct()
    {
        parent::__construct();
    }

    //stories
    function index()
    {
        $this->data['title'] = "Newsletter Stories";

        if (isset($_POST['search'])) {
            $keyword = $this->input->post('keyword');

            $stories = $this->Newsletter_model->search_newsletter_stories_list($keyword);
            if ($stories) {
                $this->data['stories'] = $stories;

                foreach ($this->data['stories'] as $k => $v) {
                    $this->data['stories'][$k]->edition = $this->Newsletter_model->get_newsletter_edition_by_id($v->edition_id);
                    $this->data['stories'][$k]->user = $this->User_model->find_by_id($v->created_by);
                }
            } else {
                $this->data['stories'] = array();
            }
        } else {
            //pagination
            $config = array(
                'base_url' => $this->config->base_url("newsletters/stories"),
                'total_rows' => $this->Newsletter_model->count_newsletter_stories(),
                'uri_segment' => 3,
            );

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->data['stories'] = $this->Newsletter_model->get_newsletter_stories_list($this->pagination->per_page, $page);
            $this->data["links"] = $this->pagination->create_links();

            foreach ($this->data['stories'] as $k => $v) {
                $this->data['stories'][$k]->edition = $this->Newsletter_model->get_newsletter_edition_by_id($v->edition_id);
                $this->data['stories'][$k]->user = $this->User_model->find_by_id($v->created_by);
            }
        }


        //render view
        $this->load->view("layout/header", $this->data);
        $this->load->view("stories/index");
        $this->load->view("layout/footer");
    }

    //newsletter story
    public function post($alias)
    {
        $this->data['title'] = "Newsletter Story";

        if (!$alias)
            redirect("newsletters/stories/post/");

        //story
        $story = $this->Newsletter_model->get_newsletter_story_by_alias($alias);
        if (count($story) == 0) {
            show_error("Story does not exist");
        }
        $this->data['story'] = $story;
        $this->data['user'] = $this->User_model->find_by_id($story->created_by);
        $this->data['edition'] = $this->Newsletter_model->get_newsletter_edition_by_id($story->edition_id);

        //recent post
        $this->data['recent_posts'] = $this->Newsletter_model->get_newsletter_stories_list(5, 0);

        //render view
        $this->load->view("layout/header", $this->data);
        $this->load->view("stories/post");
        $this->load->view("layout/footer");
    }

    //email stories
    function emails($edition_id)
    {
        $this->data['title'] = "Email Newsletter Stories";

        //edition
        $edition = $this->Newsletter_model->get_newsletter_edition_by_id($edition_id);

        if ($edition)
            $this->data['edition'] = $edition;

        $this->data['stories'] = $this->Newsletter_model->get_newsletter_stories_by_edition($edition_id);

        foreach ($this->data['stories'] as $k => $v) {
            $this->data['stories'][$k]->edition = $this->Newsletter_model->get_newsletter_edition_by_id($v->edition_id);
        }

        //render view
        $this->load->view('layout/header', $this->data);
        $this->load->view("stories/emails");
        $this->load->view('layout/footer');
    }
}