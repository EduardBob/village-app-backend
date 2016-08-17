<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Village;
use League\Fractal\TransformerAbstract;

class VillageTransformer extends TransformerAbstract
{
    /**
     * Turn village object into generic array
     *
     * @param Village $village
     * @return array
     */
    public function transform(Village $village)
    {
        $importantContacts = array();
        if(unserialize($village->important_contacts))
        {
            // Prepare array of objets for PhoneGap.
            $importantContactsPrepare = unserialize($village->important_contacts);
            foreach($importantContactsPrepare as $contactItem)
            {
                $contact = new \stdClass();
                $contact->title =  $contactItem[0];
                $contact->phone = intval($contactItem[1]);
                $importantContacts[] = $contact;
            }
        }

        return [
            'id' => $village->id,
            'name' => $village->name,
            'shop_name' => $village->shop_name,
            'shop_address' => $village->shop_address,
            'service_payment_info' => $village->service_payment_info,
            'service_bottom_text' => $village->service_bottom_text,
            'product_payment_info' => $village->product_payment_info,
            'product_bottom_text' => $village->product_bottom_text,
            'product_unit_step_kg' => $village->product_unit_step_kg,
            'product_unit_step_bottle' => $village->product_unit_step_bottle,
            'product_unit_step_piece' => $village->product_unit_step_piece,
            'active' => (bool)$village->active,
            'important_contacts' => $importantContacts,
        ];
    }
}