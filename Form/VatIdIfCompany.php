<?php declare(strict_types=1);

namespace Yireo\HyvaCheckoutVatIdIfCompany\Form;

use Hyva\Checkout\Model\Form\EntityField\Input;
use Hyva\Checkout\Model\Form\EntityFormInterface;
use Hyva\Checkout\Model\Form\EntityFormModifierInterface;
use Magento\Framework\Model\Context;

class VatIdIfCompany implements EntityFormModifierInterface
{
    private Context $context;

    public function __construct(
        Context $context

    ) {
        $this->context = $context;
    }

    public function apply(EntityFormInterface $form): EntityFormInterface
    {
        $form->registerModificationListener(
            'Yireo_HyvaCheckoutVatIdIfCompany::initToggleField',
            'form:init',
            [$this, 'initToggleField']
        );

        $form->registerModificationListener(
            'Yireo_HyvaCheckoutVatIdIfCompany::modifyVatId',
            'form:build',
            [$this, 'modifyVatId']
        );

        return $form;
    }

    public function initToggleField(EntityFormInterface $form)
    {
        /*
        $countryId = $form->getField('country_id');
        if ($countryId->getValue() === 'nl') {
            $state = $form->getField('region');
            $state->isRequired(false);
        }
        */

        return $form;
        $field = new Input($form->get, []);
        $field->addData([

        ]);

        $form->addField($field);
    }


    public function modifyVatId(EntityFormInterface $form)
    {
        $companyField = $form->getField('company');
        if (!$companyField) {
            return $form;
        }

        $jsCall = '$dispatch(\'hyva.checkout.company-changed\', $event.target.value);';
        $jsCall .= $companyField->getAttributeCode('@change');
        $companyField->setAttribute('@change', $jsCall);

        /*
        if (!$companyField->getValue()) {
            $vatIdField = $form->getField('vat_id');
            $form->removeField($vatIdField);
        }
        */

        return $form;
    }
}