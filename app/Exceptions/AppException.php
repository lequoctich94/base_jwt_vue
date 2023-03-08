<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected $message;
    protected $data;
    protected $code;
    protected $status_code;

    protected $redirect_to = null;

    const DEFAULT_MESSAGE = 'The app return none message!';
    const DEFAULT_CODE = 'ERROR';
    const DEFAULT_STATUS_CODE = 400;
    const DEFAULT_DATA = null;

    /**
     * $messageOrException is values:
     * string
     * array
     * Exception
     */
    public function __construct($message_or_exception = null, $data = null, $code = '', $status_code = null)
    {
        if (is_array($message_or_exception) || is_null($message_or_exception)) {
            $this->message = collect($message_or_exception);
        } else {
            if ($message_or_exception instanceof Exception) {
                $mess = $message_or_exception->getMessage();
            } elseif (is_string($message_or_exception)) {
                $mess = $message_or_exception;
            } else {
                $mess = self::DEFAULT_MESSAGE;
            }
            $this->message = collect(['message' => $mess]);
        }
        $this->data = $data;
        $this->code = $code;
        $this->status_code = $status_code;
    }

    /**
     * 
     */
    private function getCustomMessage()
    {
        if (!empty($this->message) && !$this->message->isEmpty()) {
            return $this->message;
        }
        return $this->getMessageDefault();
    }

    /**
     * 
     */
    private function getData()
    {
        if (!empty($this->data)) {
            return $this->data;
        }
        return $this->getDataDefault();
    }

    /**
     * 
     */
    private function getCustomeCode()
    {
        if (!empty($this->code)) {
            return $this->code;
        }
        return $this->getCodeDefault();
    }

    /**
     * 
     */
    private function getStatusCode()
    {
        if (!empty($this->status_code)) {
            return $this->status_code;
        }
        return $this->getStatusCodeDefault();
    }

    /**
     * 
     */
    public function getMessageDefault()
    {
        return self::DEFAULT_MESSAGE;
    }

    /**
     * 
     */
    public function getDataDefault()
    {
        return self::DEFAULT_DATA;
    }


    /**
     * 
     */
    public function getCodeDefault()
    {
        return self::DEFAULT_CODE;
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return self::DEFAULT_STATUS_CODE;
    }

    /**
     * 
     */
    public function render($request)
    {
        $err_mess = !empty($this->getCustomMessage()['message'])
            ? $this->getCustomMessage()['message']
            : $this->getCustomMessage();

        if ($request->is('api/*') || $request->ajax()) {
            // api|ajax
            return response()->jsonError(
                is_string($err_mess) ? ['system_mess' => [$err_mess]] : $err_mess, 
                $this->getData(), 
                $this->getCustomeCode(), 
                request()->trace_id ?? 0, 
                $this->getStatusCode()
            );
        } else {
            // web|view
            if (!empty($this->redirect_to) && is_string($this->redirect_to)) {
                return $this->renderRedirect($err_mess);
            }
            return $this->renderBack($err_mess);
        }
    }

    /**
     * render view
     */
    private function renderBack($err_mess)
    {
        if (!empty($this->data)) {
            return back()->withInput()->with([
                'error' => $err_mess,
                'data' => $this->getData()
            ]);
        }
        return back()->withInput()->with('error', $err_mess);
    }

    /**
     * render view
     */
    private function renderRedirect($err_mess)
    {
        if (!empty($this->data)) {
            return redirect($this->redirect_to)->withInput()->with([
                'error' => $err_mess,
                'data' => $this->getData()
            ]);
        }
        return redirect($this->redirect_to)->withInput()->with('error', $err_mess);
    }
}
