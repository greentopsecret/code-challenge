<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Order;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('title')
            ->add(
                'executionDate',
                ChoiceType::class,
                ['choices' => $this->getExecutionDateChoices()]
            )
            ->add(
                'service',
                EntityType::class,
                ['class' => Service::class, 'choice_label' => 'name', 'choice_value' => 'id']
            )
            ->add(
                'city',
                EntityType::class,
                ['class' => City::class, 'choice_label' => 'name', 'choice_value' => 'zip']
            );
    }

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
