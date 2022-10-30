<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/{_locale}")
*/
class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
    */
    public function index(Request $r, TranslatorInterface $t): Response
    {
      $em = $this->getDoctrine()->getManager();

      $produit = new Produit();
      $form = $this->createForm(ProduitType::class, $produit);
      $form->handleRequest($r);
      if($form->isSubmitted() && $form->isValid()){

        $photoFile = $form->get('photo')->getData();

        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($photoFile) {
          $newFilename = uniqid().'.'.$photoFile->guessExtension();

          // Move the file to the directory where brochures are stored
          try {
              $photoFile->move(
                  $this->getParameter('upload_directory'),
                  $newFilename
              );
          } catch (FileException $e) {
              // ... handle exception if something happens during file upload
          }

          // updates the 'brochureFilename' property to store the PDF file name
          // instead of its contents
          $produit->setPhoto($newFilename);
        }

        $em->persist($produit);
        $em->flush();

        $this->addFlash('success', $t->trans('produit.added'));
      }

      $produits = $em->getRepository(Produit::class)->findAll();

      return $this->render('produit/index.html.twig', [
        'produits' => $produits,
        'ajout' => $form->createView()
      ]);
    }

    /**
     * @Route("/produit/{id}", name="une_fiche_produit")
    */
    public function show(Produit $p = null, TranslatorInterface $t){
      if($p == null){
        $this->addFlash('danger', $t->trans('produit.unknown'));
        return $this->redirectToRoute('produit');
      }

      return $this->render('produit/fiche_produit.html.twig', [
        'produit' => $p
      ]);
  }

    /**
     * @Route("/produit/edit/{id}", name="un_produit")
    */
    public function update(Produit $p = null, Request $r, TranslatorInterface $t){
      if($p == null){
        $this->addFlash('danger', $t->trans('produit.unknown'));
        return $this->redirectToRoute('produit');
      }

      $form = $this->createForm(ProduitType::class, $p);
      $form->handleRequest($r);
      if($form->isSubmitted() && $form->isValid()){
          $em = $this->getDoctrine()->getManager();
          $em->persist($p);
          $em->flush();

          $this->addFlash('success', $t->trans('produit.updated'));
        }

      return $this->render('produit/update.html.twig', [
          'produit' => $p,
          'edit' => $form->createView()
      ]);
    }

    /**
     * @Route("/produit/delete/{id}", name="produit_delete")
    */
    public function delete(Produit $p = null, TranslatorInterface $t){
      if($p == null){
        $this->addFlash('danger', $t->trans('produit.unknown'));
        return $this->redirectToRoute('produit');
      }

      $em = $this->getDoctrine()->getManager();
      $em->remove($p); // Suppression
      $em->flush();

      $this->addFlash('warning', $t->trans('produit.deleted'));

      return $this->redirectToRoute('produit');
    }
}