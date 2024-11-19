<?php

class Emails_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function emailsCount()
    {
        return $this->db->count_all_results('newsletter_subscriber');
    }

    public function getSuscribedEmails($limit, $page)
    {
        $this->db->order_by('subscriber_id', 'desc');
        $query = $this->db->select('*')->get('newsletter_subscriber', $limit, $page);
        return $query;
    }

    public function deleteEmail($id)
    {
        if (!$this->db->where('subscriber_id', $id)->delete('newsletter_subscriber')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}
