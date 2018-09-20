<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends FOSRestController
{
    /**
     * @return View
     */
    public function newAction()
    {
        $form = $this->createForm(
            OrderType::class,
            null,
            [
                'action' => $this->generateUrl('app_api_order_post'),
            ]
        );

        return View::create()->setData(['form' => $form->createView()]);
    }

    /**
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(
            OrderType::class,
            null,
            [
                'method' => 'post',
                'action' => $this->generateUrl('app_api_order_post'),
            ]
        );

        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException('Request does not contain form');
        }

        if ($form->isValid()) {
            $order = $form->getData();
            $doctrine = $this->getDoctrine();
            $doctrine->getManager()->persist($order);
            $doctrine->getManager()->flush();

            return View::createRouteRedirect(
                'app_api_order_get',
                array('id' => $order->getId()),
                Response::HTTP_CREATED
            );
        }

        return View::create()
            ->setData(['form' => $form->createView()])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return View
     */
    public function patchAction(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $order = $manager->find(Order::class, $id);
        if (null === $order) {
            throw new NotFoundHttpException("Order#$id not found");
        }

        $form = $this->createForm(
            OrderType::class,
            $order,
            [
                'method' => 'PATCH',
                'action' => $this->generateUrl('app_api_order_patch', ['id' => $id]),
            ]
        );
        $form->submit($request->get('order'), false);
        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException('Request does not contain form');
        }

        if ($form->isValid()) {
            $this
                ->getDoctrine()
                ->getManager()
                ->flush();

            return View::create()
                ->setData(['data' => $order])
                ->setStatusCode(Response::HTTP_OK);
        }

        return View::create()
            ->setData(['form' => $form->createView()])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction(int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $order = $manager->find(Order::class, $id);
        if (null === $order) {
            throw new NotFoundHttpException("Order#$id not found");
        }

        return View::create()->setData(['data' => $order]);
    }


    /**
     * @return View
     */
    public function editAction(int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $order = $manager->find(Order::class, $id);
        if (null === $order) {
            throw new NotFoundHttpException("Order#$id not found");
        }

        $form = $this->createForm(
            OrderType::class,
            $order,
            [
                'method' => 'PATCH',
                'action' => $this->generateUrl('app_api_order_patch', ['id' => $order->getId()]),
            ]
        );

        return View::create()->setData(['form' => $form->createView()]);
    }
}
