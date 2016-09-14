<?php

class Pusherer
{
    public function post($request_data = NULL)
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
        $pusher->trigger('game', $data['event'], $data);

        $response = array('status' => $request_data);

        return $response;
    }

}
