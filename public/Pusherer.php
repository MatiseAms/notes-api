<?php

class Pusherer
{
    public function score()
    {
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true,
        );
        $pusher = new Pusher(
            'e28b6f53404860a0e3bd',
            '3b228e610233fb531266',
            '248015',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('game', 'score', $data);

        $response = array('status' => 'success');

        return $response;
    }
    public function karaoke()
    {
        $response = array('status' => 'success');

        return $response;
    }
}
