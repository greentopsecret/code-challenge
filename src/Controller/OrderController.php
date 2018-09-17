<?php

namespace App\Controller;

use App\Form\OrderType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @TODO: description
 */
class OrderController extends FOSRestController
{
    /**
     * @TODO: check that it accepts only GET
     *
     * @return View
     */
    public function newAction()
    {
        $form = $this->get('form.factory')->create(OrderType::class);
        $view = View::create()
            ->setData(array('form' => $form->createView()));

        return $view;
    }
}
