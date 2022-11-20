<?php

namespace App\Core;

class Email
{
    private $from = '';
    private $to = '';
    private $subject = '';
    private $message = '';

    public function from($from = '')
    {
        $this->from = $from;

        return $this;
    }

    /**
     *
     * @param string $to
     *
     * @return Email
     */
    public function to($to = '')
    {
        $this->to .= $this->to ? ',' . $to : $to;

        return $this;
    }

    /**
     *
     * @param string $subject
     *
     * @return Email
     */
    public function subject($subject = '')
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     *
     * @param number $port
     *
     * @return Email
     */
    public function setPort($port = 25)
    {
        ini_set('smtp_port', intval($port));

        return $this;
    }

    /**
     *
     * @param string $message
     *
     * @return Email
     */
    public function message($message = '')
    {
        if (strtolower(substr(ltrim($message), 0, 4)) == '<htm' || substr(ltrim($message), 0, 2) == '<!') {
            $this->type = 'html';
            $this->message = $message;

        } else {
            $this->type = 'text';
            $this->message = $message;
        }

        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function send()
    {
        if ($this->type == 'html') {

            $list = get_html_translation_table(HTML_ENTITIES);

            unset($list['"']);
            unset($list['<']);
            unset($list['>']);
            unset($list['&']);

            $search = array_keys($list);
            $values = array_values($list);
            $search = array_map('utf8_encode', $search);

            $this->message = str_replace($search, $values, $this->message);
        }

        return mail($this->to, $this->subject, $this->message);
    }
}