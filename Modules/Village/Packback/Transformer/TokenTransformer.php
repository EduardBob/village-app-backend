<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\Token;

class TokenTransformer extends TransformerAbstract
{
    /**
     * Turn Token object into generic array
     *
     * @param Token $token
     * @return array
     */
    public function transform(Token $token)
    {
        $data = [
            'session' => $token->session,
        ];

        if (config('app.debug')) {
            $data['code'] = $token->code;
        }

        return $data;
    }
}