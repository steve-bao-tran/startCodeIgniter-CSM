<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $uri = urlencode(uri_string());
            redirect('admin/login/?redirect=' . $uri);
        }
        if ($this->config->item('enable_profiler')) {
            $this->output->enable_profiler(true);
        }

    }

    public function showError($errorMsg = 'Ocurrio un error inesperado', $data = array('title' => 'Error', 'h1' => 'Error'))
    {
        $data['conten'] = $errorMsg;
        $data['header'] = $this->load->view('admin/header', $data, true);
        echo $this->blade->view("admin.blankpage", $data);
    }

    public function error404()
    {

        $data['base_url'] = $this->config->base_url();
        $data['title'] = "404";
        $url = uri_string();
        if (stristr($url, 'admin') === false) {
            echo $this->blade->view("error404", $data);
        } else {
            if (!$this->session->userdata('logged_in')) {
                $uri = str_replace('/', '_', uri_string());
                redirect('login/index/' . $uri);
            } else {
                $data['h1'] = "404 Page not found :(";
                $data['header'] = $this->load->view('admin/header', $data, true);
                echo $this->blade->view("admin.blankpage", $data);
            }
        }

    }

}

class Base_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $config = $this->Site_config->all();
        $config = $config ? $config : [];
        foreach ($config as $value) {
            $this->config->set_item($value->config_name, $value->config_value);
        }
    }

    public function getPageMetas($page)
    {
        if ($page->page_data["meta"]) {
            function convertArrayToObject($value)
            {
                return (Array) $value;
            }
            return array_map("convertArrayToObject", $page->page_data["meta"]);

        }

        $default_metas = array(
            array('name' => 'keywords', 'content' => $page->title),
            array('name' => 'description', 'content' => $page->title),
            array('name' => 'ROBOTS', 'content' => 'NOODP'),
            array('name' => 'GOOGLEBOT', 'content' => 'INDEX, FOLLOW'),
            array('property' => 'og:title', 'content' => $page->title),
            array('property' => 'og:description', 'content' => $page->title),
            array('property' => 'og:site_name', 'content' => $page->title),
            array('property' => 'og:url', 'content' => $page->title),
            array('property' => 'og:image', 'content' => $page->title),
            array('property' => 'og:type', 'content' => $page->title),
            array('name' => 'twitter:card', 'content' => 'summary'),
            array('name' => 'twitter:title', 'content' => $page->title),
            array('name' => 'twitter:description', 'content' => $page->title),
            array('name' => 'twitter:image', 'content' => $page->title),
        );
        return $default_metas;
    }

    public function error404()
    {
        $this->output->set_status_header(404);
        $data['base_url'] = $this->config->base_url();
        $data['title'] = "404";
        $url = uri_string();
        if (stristr($url, 'admin') === false) {
            echo $this->blade->view("error404", $data);
        } else {
            if (!$this->session->userdata('logged_in')) {
                $uri = str_replace('/', '_', uri_string());
                redirect('login/index/' . $uri);
            } else {
                $data['h1'] = "404 Page not found :(";
                $data['header'] = $this->load->view('admin/header', $data, true);
                echo $this->blade->view("admin.blankpage", $data);
            }
        }

    }

}

/* End of file MY_Controller */
