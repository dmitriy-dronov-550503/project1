<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Attribute;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Form\EditProductType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Id\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        $product->setImage(
            new File($this->getParameter('images_directory') . '/' . $product->getImage())
        );


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


            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $product->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $product->setImage($fileName);


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
     * @Route("/product/create", name="product_create")
     */
    public function createEditFormAction(Request $request)
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

    /**
     * @Route("product/delete/{id}", name="product_delete")
     */
    public function deleteProductAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        foreach ($product->getAttributes() as $attribute) {
            $em->remove($attribute);
        }
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("product/create_ajax", name="product_create_ajax")
     */
    public function createAjaxAction(Request $request)
    {
        $attrName = $request->request->get('attrName');
        $attrValue = $request->request->get('attrValue');
        $name = $request->request->get('name');
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->find($request->request->get('category'));
        $description = $request->request->get('description');

        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setCategory($category);
        $attributes = array();
        foreach ($attrName as $index => $attr){
            $newAttr = new Attribute();
            $newAttr->setName($attr);
            $newAttr->setValue($attrValue[$index]);
            $newAttr->setProduct($product);
            array_push($attributes, $newAttr);
        }
        $product->setAttributes($attributes);
        $product->setImage("0cbaa3ed3edc0a91ba0ef1f67f549f87.jpeg");
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return new Response('Name: '.$name.' Description: '.$description);
    }

}