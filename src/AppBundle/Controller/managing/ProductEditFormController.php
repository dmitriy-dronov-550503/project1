<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Product;
use AppBundle\Form\EditProductType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Id\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ProductEditFormController
 * @package AppBundle\Controller\managing
 * Form to edit product
 */
class ProductEditFormController extends Controller
{
    /**
     * @Route("/product/edit/{productId}", requirements={"productId" = "new|\d+"}, name="product_edit")
     */
    public function productEditAction(Request $request, $productId)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($productId);
        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $productId);
        }

        $originalAttributes = new ArrayCollection();
        foreach ($product->getAttributes() as $attribute) {
            $originalAttributes->add($attribute);
        }

        $isImage = $product->getImage();
        if ($isImage) {
            $product->setImage(
                new File($this->getParameter('images_directory') . '/' . $product->getImage())
            );
        }


        $form = $this->createForm(EditProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalAttributes as $attribute) {
                if (false === $product->getAttributes()->contains($attribute)) {
                    $attribute->setProduct(null);
                    $em->remove($attribute);
                }
            }

            if(!$isImage){
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $product->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $product->setImage($fileName);
            }

            $product->setDateLastChange(new \DateTime());
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_edit', array('productId' => $product->getId()));
        }

        return $this->render(
            'managing/productEditForm.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/product_create", name="product_create")
     */
    public function createEditForm(Request $request)
    {
        $product = new Product();
        $product->setDateWasCreated(new \DateTime());
        $product->setDateLastChange(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $uuid = new UuidGenerator();
        $uuid->generate($em, $product);
        $form = $this->createForm(EditProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $product->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $product->setImage($fileName);

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product_edit', array('productId' => $product->getId()));
        }

        return $this->render(
            'managing/productEditForm.html.twig',
            array('form' => $form->createView())
        );
    }
}