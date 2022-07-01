<?php

namespace App\Http\Requests\API\Auth;

use InfyOm\Generator\Request\APIRequest;
use Symfony\Component\Console\Input\Input;

class VerificationAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $request['id'] = $this->route('id');
        $request['hash'] = $this->route('hash');
        return $request;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'hash' => 'required',
        ];
    }
}
