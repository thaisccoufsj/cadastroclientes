<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $pageSize = 2;

    /**
     * Identifica se request tem campo que não está vazio
     *
     * @param Request $request
     * @return bool
     */
    public function requestHasNotemptyFields(Request $request): bool
    {
        foreach ($request->all() as $field => $fieldValue) {
            if ($field == '_token') {
                continue;
            }

            if (!empty($fieldValue)) {
                return true;
            }
        }

        return false;
    }
}
