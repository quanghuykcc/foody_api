<?php

namespace InfyOm\Generator\Utils;

class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data, $last_sync_timestamp = [])
    {

        $res = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        if (!empty($last_sync_timestamp)) {
            $res['last_sync_timestamp'] = $last_sync_timestamp;
        }
        
        return $res;
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
