<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('executionDate', ChoiceType::class, ['choices' => $this->getExecutionDateChoices()])
            ->add('service')
            ->add('city');
    }

//<select id="job_date_selection" data-ng-mousedown="DatepickerCustom.close()" data-ng-model="DatepickerCustom.selected_option" class="form-control ng-pristine ng-valid ng-not-empty ng-touched" style="">
//    <option value="10" selected="selected"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">contemporary</font></font></option>
//    <option value="20"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Within the next 30 days</font></font></option>
//    <option value="23"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">In the next 3 months</font></font></option>
//    <option value="25"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">In 3 to 6 months</font></font></option>
//    <option value="27"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">In more than 6 months</font></font></option>
//    <option value="30" class="ng-binding"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Desired date: Please select date</font></font></option>
//</select>

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Order::class,
            ]
        );
    }

    private function getExecutionDateChoices(): array
    {
        return [
            'Zeitnah' => 10,
            'Innerhalb der nächsten 30 Tage' => 20,
            'In den nächsten 3 Monaten' => 23,
            'In 3 bis 6 Monaten' => 25,
            'In mehr als 6 Monaten' => 27,
            'Wunschtermin: Bitte Datum wählen' => 30,
        ];
    }
}
